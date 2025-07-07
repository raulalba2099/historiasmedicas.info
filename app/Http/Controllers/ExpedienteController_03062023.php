<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Estudio;
use App\Models\ExamenFisico;
use App\Models\HistoriaClinicaPreguntas;
use App\Models\HistoriaClinicaRespuestas;
use App\Models\HistoriaClinicaSeccion;
use App\Models\HistoriaClinicaSubSecciones;
use App\Models\Nota;
use App\Models\Paciente;
use App\Models\Receta;
use DateTime;
use Illuminate\Http\Request;

class ExpedienteController extends Controller
{
    static public function indexEstudiosAction($id)
    {
        $paciente = Paciente::where('pac_id', $id)->first();
        $estudios = Estudio::where('est_pac_id', $id)->orderBy('est_id', 'DESC')->get();

        return view("reportes.expediente-estudios",
            array(
                'paciente' => $paciente,
                'estudios' => $estudios
            ));
    }

    public function indexHistoriaAction($id)
    {

        $paciente = Paciente::where('pac_id', $id)->first();

        $secciones = HistoriaClinicaSeccion::where('estado', 1)->orderBy('orden')->get()->toArray();
        $subsecciones = HistoriaClinicaSubSecciones::where('estado', 1)->orderBy('orden')->get()->toArray();
        $preguntas = HistoriaClinicaPreguntas::where('estado', 1)->orderBy('orden')->get()->toArray();
        $respuestas = HistoriaClinicaRespuestas::where('res_pac_id', $paciente->pac_id)->get()->toArray();

        $seccionesArray = [];
        foreach ($secciones as $seccion) {
            $seccionesArray[$seccion['id']]['sec_id'] = $seccion['id'];
            $seccionesArray[$seccion['id']]['sec_nombre'] = $seccion['nombre'];
            $seccionesArray[$seccion['id']]['sec_descripcion'] = $seccion['descripcion'];
            $seccionesArray[$seccion['id']]['sec_estado'] = $seccion['estado'];
            $seccionesArray[$seccion['id']]['sec_orden'] = $seccion['orden'];
            foreach ($subsecciones as $key => $subseccion) {
                if ($seccion['id'] == $subseccion['id_seccion']) {
                    $seccionesArray[$seccion['id']]['sec_subsecciones'][$subseccion['id']] = $subseccion;
                    foreach ($preguntas as $pregunta) {
                        if ($subseccion['id'] == $pregunta['id_subseccion']) {
                            $seccionesArray[$seccion['id']]['sec_subsecciones'][$subseccion['id']]['preguntas'][$pregunta['id']] = $pregunta;
                            foreach ($respuestas as $respuesta) {
                                if ($pregunta['id'] == $respuesta['res_pre_id']) {
                                    $seccionesArray[$seccion['id']]['sec_subsecciones'][$subseccion['id']]['preguntas'][$pregunta['id']]['respuesta'] = $respuesta['res_respuesta'];
                                }
                            }
                        }
                    }
                }
            }
        }
        return view("reportes.expediente-historia", array("status" => 200, 'secciones' => $seccionesArray, 'paciente' => $paciente, 'respuestas' => $respuestas));
    }

    static public function indexNotasAction($id)
    {
        $paciente = Paciente::where('pac_id', $id)->first();

        $notas = Nota::join('pacientes', 'not_pac_id', 'pac_id')->
        where('not_pac_id', $id)->orderBy('not_id', 'desc')->get();
        $fisico = ExamenFisico::where('exa_pac_id', $id)->first();

        return view("reportes.expediente-notas",
            array(
                'notas' => $notas,
                'paciente' => $paciente,
                'fisico' => $fisico
            ));
    }

    static public function indexExpedienteAction()
    {

        $pacientes = Paciente::where('pac_use_id', auth()->user()->id)->orderBy("pac_id", 'desc')->get()->toArray();

        foreach ($pacientes as $key => $paciente) {
            $pacientes[$key]['pac_edad'] = PacienteController::age($paciente['pac_nacimiento']);
        }

        return view("reportes.expediente",
            array(
                'pacientes' => $pacientes
            ));
    }

    static public function indexFisicoAction($id) {

        $paciente = Paciente::where('pac_id', $id)->first();
        $fisico = ExamenFisico::where('exa_pac_id', $id)->first();
        $fisicos = ExamenFisico::where('exa_pac_id', $id)->get();

        $fisicosArray = [];
        $fechaActual = new DateTime(date('Y-m-d'));
        $horaActual = date("H:i:s");
        $horaActualCompleta = explode(':', $horaActual);
        $horaCompleta = array('12','00','00');
        foreach ($fisicos as $key => $fisico) {
            $fechaExamen = new DateTime(date($fisico->fecha));

            $intervaloFechas = $fechaActual->diff($fechaExamen);
            $horasDias = $intervaloFechas->days * 24;

            $fisicosArray[$key]['id'] = $fisico->id;
            $fisicosArray[$key]['fecha'] = $fisico->fecha;
            $fisicosArray[$key]['horas'] = $horasDias;

        }

        return view("reportes.expediente-fisico",
            array(
                'paciente' => $paciente,
                'fisico' => $fisico,
                'fisicos' => $fisicosArray
            ));
    }

    static public function mostrarFisicoAction($id, $fecha) {

        $fecha = date('Y-m-d',strtotime($fecha));
        $examenFisico = ExamenFisico::where('exa_pac_id',$id)->where('fecha', $fecha)->first();

        $respuesta = array('datos' => $examenFisico, 'status' => 1) ;

//        return $id;
        return  $respuesta;
    }

    static public function calendarioFisico($id,$fecha){

        if(isset($reporte)){

            $pagina =  "reportes/reporte_maquinaria_mano";
        }else {

            $pagina = "administrador/maquinaria_mano";
        }

        $fisicos = ExamenFisico::where('exa_pac_id', $id)->get();



        $fechasArray = [] ;
        foreach ($fisicos as $key => $fisico) {
            $fechaCompleta = explode("-", $fisico->fecha);
            $fechasArray[$key] = $fechaCompleta[0]."-".$fechaCompleta[1]."-".$fechaCompleta[2];
        }

        $fechasArray = array_unique($fechasArray);

        $diaActual=date("d",strtotime($fecha));
        $mesActual=date("m",strtotime($fecha));
        $anioActual=date("Y",strtotime($fecha));
        $diaInicio=date("w",strtotime($anioActual."-".$mesActual."-01"));
        $totalDias=date("t", strtotime($fecha));

        if($diaInicio==0){

            $semanas=intval($totalDias/7);

            if($totalDias % 7 > 0){
                $semanas+=1;
            }

        }else{

            $semanas=intval(($totalDias + $diaInicio)/7);
            if(($totalDias + $diaInicio)%7 > 0){
                $semanas+=1;
            }
        }

#Imprime calendario

        print '<table id="" class="table-striped table-bordered table-condensed m-0 m-auto" style="width:220px!important; height:196px;">';

        print"

	<tr>
		<td class='bg-primary text-center'>";

        if($diaActual==$totalDias && $diaActual!=28){

            $diaTmp=date("t", strtotime(($anioActual - 1)."-$mesActual-01"));

            $dia = $diaTmp;

        }else{

            $dia = $diaActual;
            //print "$diaActual";
        }



        ?>

        <a class="text-white" href="" >">&lt
        </a>

        <?php
        print "

		</td>

		<td class='bg-primary text-center' colspan='5'>$anioActual</td>

		<td class='bg-primary text-center'>";

        if($diaActual==$totalDias && $diaActual!=28){
            $diaTmp=date("t", strtotime(($anioActual - 1)."-$mesActual-01"));

            $dia = $diaTmp;

        }else{

            $dia = $diaActual;

        }

        ?>

        <a class="text-white" href="">&gt
        </a>

        <?php

        print"
	    </td>

    </tr>

	<tr>

	<td class='bg-primary text-center'>";

        if($mesActual==1){

            $cadAnioMes=($anioActual - 1)."-12";

        }else{
            $cadAnioMes="$anioActual-".($mesActual - 1);
        }

        //print  $cadAnioMes;

        if(($diaActual==$totalDias && $diaActual==31) || ($mesActual==3 && ($diaActual==30 || $diaActual==29))){
            $diaTmp=date("t", strtotime($cadAnioMes."-01"));

            $dia = $diaTmp;

        }else{

            $dia = $diaActual;
        }

        $fecha = $cadAnioMes . "-" . $dia;


        ?>

        <a class="text-white" href="">&lt
        </a>

        <?php

        print "
	</td>

	<td class='bg-primary text-center' colspan='5'>".$mesActual."
	 </td>

	<td class='bg-primary text-center'>";

        if($mesActual==1){

            $cadAnioMes=($anioActual - 1)."-12";

        }else{
            $cadAnioMes="$anioActual-".($mesActual + 1);
        }

        //print  $cadAnioMes;

        if(($diaActual==$totalDias && $diaActual==31) || ($mesActual==3 && ($diaActual==30 || $diaActual==29))){
            $diaTmp=date("t", strtotime($cadAnioMes."-01"));

            $dia = $diaTmp;

        }else{

            $dia = $diaActual;
        }

        $fecha = $cadAnioMes . "-" . $dia;


        ?>

        <a class="text-white" href="">">&gt
        </a>


        <?php

        print"
	    </td>
	        </tr>
	            <tr>
                    <td class='encaAzulB text-center'>D</td>
                    <td class='encaAzulB text-center'>L</td>
                    <td class='encaAzulB text-center'>M</td>
                    <td class='encaAzulB text-center'>Mc</td>
                    <td class='encaAzulB text-center'>J</td>
                    <td class='encaAzulB text-center'>V</td>
                    <td class='encaAzulB text-center'>S</td>
	            </tr>";

        $dia=1;
        $fondo="fondoCal";

        for($i=0; $i<$semanas; $i++){

            print "<tr>";

            for($j=0; $j<7; $j++){

                if(($i==0 && $j<$diaInicio) || ($dia > $totalDias)){

                    print "<td class='$fondo' style='widht:28px;' height:28px;>&nbsp;</td>";


                }else{

                    if(($dia==$diaActual)){

                        $fondo="badge-primary";
                        $colorLiga = "text-white";


                    }
//                    else if(in_array($dia,$arrDias)){
//
//                        $fondo="badge-success";
//
//                    }

                    $numCaracteresDia = strlen($dia);

                    if ($numCaracteresDia==1) {

                        $dia = "0".$dia;
                    }


                    $fecha = $anioActual."-".$mesActual."-".$dia;

                    if (in_array($fecha, $fechasArray)) {

                        $fondo="badge-success";
                        $colorLiga = "text-white";
                    }



                    print "<td class='$fondo text-center' style='widht:28px; height:28px;'>";



                    ?>

                    <a class="<?php echo $colorLiga; ?>" href=""> <?php echo $dia; ?>
                    </a>


                    <?php

                    print "
			</td>";

                    $dia++;



                }


                $fondo="fondoCal";
                $colorLiga = "";

            }

            print "</tr>";

        }

        print "</table>";

        #Fin calendario

    }
}
