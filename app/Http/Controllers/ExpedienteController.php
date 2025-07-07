<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Estudio;
use App\Models\ExamenFisico;
use App\Models\HistoriaClinicaPreguntas;
use App\Models\HistoriaClinicaRespuestas;
use App\Models\HistoriaClinicaSeccion;
use App\Models\HistoriaClinicaSencilla;
use App\Models\HistoriaClinicaSubSecciones;
use App\Models\Menu;
use App\Models\Nota;
use App\Models\Paciente;
use App\Models\Receta;
use App\Models\RecomendacionesMenu;
use DateTime;
use Illuminate\Http\Request;

class ExpedienteController extends Controller
{
    static public function indexEstudiosAction($id)
    {
        $paciente = Paciente::where('pac_id', $id)->first();
        $estudios = Estudio::where('est_pac_id', $id)->orderBy('est_id', 'DESC')->get();

        return view(
            "reportes.expediente-estudios",
            array(
                'paciente' => $paciente,
                'estudios' => $estudios
            )
        );
    }

    protected  function indexHistoriaSencillaAction ($id) {


        $paciente = Paciente::where('pac_id', $id)->first();

        $consulta = Consulta::rightJoin('citas', 'con_cit_id', 'cit_id')
            ->join('pacientes', 'cit_pac_id', 'pac_id')
            ->where('cit_pac_id', '=', $id)
            ->orderby('cit_id','desc')
            ->first();

        $fisico = ExamenFisico::where('exa_cit_id', $consulta->cit_id)->first();

        $historia = new HistoriaClinicaSencilla();
        $historiaClinica =  $historia->where('cit_id',$consulta->cit_id)->first();

        return view(
            "reportes.expediente-historia",
            array('historia' => $historiaClinica,'consulta' => $consulta, 'fisico' => $fisico,'paciente'=>$paciente)
        );
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
        return view(
            "reportes.expediente-historia",
            array("status" => 200, 'secciones' => $seccionesArray, 'paciente' => $paciente, 'respuestas' => $respuestas)
        );
    }

    static public function indexNotasAction($id)
    {
        $paciente = Paciente::where('pac_id', $id)->first();

        $notas = Nota::join('pacientes', 'not_pac_id', 'pac_id')->
        where('not_pac_id', $id)->orderBy('not_id', 'desc')->get();
        $fisico = ExamenFisico::where('exa_pac_id', $id)->first();

        return view(
            "reportes.expediente-notas",
            array(
                'notas' => $notas,
                'paciente' => $paciente,
                'fisico' => $fisico
            )
        );
    }

    static public function indexExpedienteAction()
    {
        $pacientes = Paciente::where('pac_use_id', auth()->user()->id)->orderBy("pac_id", 'desc')->get()->toArray();
        $diagnosticos = ExamenFisico::select('exa_pac_id', 'diagnostico')->orderBy('exa_pac_id', 'desc')->get(
        )->toArray();

        $pacientesArray = [];

        foreach ($diagnosticos as $diagnostico) {
            foreach ($pacientes as $key => $paciente) {
                $pacientesArray[$paciente['pac_id']]['pac_id'] = $paciente['pac_id'];
                $pacientesArray[$paciente['pac_id']]['pac_numero'] = $paciente['pac_numero'];
                $pacientesArray[$paciente['pac_id']]['pac_nombre'] = $paciente['pac_nombre'];
                $pacientesArray[$paciente['pac_id']]['pac_paterno'] = $paciente['pac_paterno'];
                $pacientesArray[$paciente['pac_id']]['pac_materno'] = $paciente['pac_materno'];
                $pacientesArray[$paciente['pac_id']]['pac_nacimiento'] = $paciente['pac_nacimiento'];
                $pacientesArray[$paciente['pac_id']]['pac_genero'] = $paciente['pac_genero'];
                $pacientesArray[$paciente['pac_id']]['pac_direccion'] = $paciente['pac_direccion'];
                $pacientesArray[$paciente['pac_id']]['pac_telefono'] = $paciente['pac_telefono'];
                $pacientesArray[$paciente['pac_id']]['pac_correo'] = $paciente['pac_correo'];
                if ($paciente['pac_id'] == $diagnostico['exa_pac_id']) {
                    $pacientesArray[$paciente['pac_id']]['diagnostico'][] = $diagnostico['diagnostico'];
                }
            }
        }
//        dd($pacientesArray);

        return view(
            "reportes.expediente",
            array(
                'pacientes' => $pacientesArray,
                'diagnosticos' => $diagnosticos
            )
        );
    }

    static public function indexFisicoAction($id)
    {
        $paciente = Paciente::where('pac_id', $id)->first();
//        $fisicoExpediente = ExamenFisico::where('exa_pac_id', $id)->orderBy('fecha', 'DESC')->first();
        $fisicoExpediente = ExamenFisico::where('exa_pac_id', $id)->where('fecha', date('Y-m-d'))->orderBy(
            'fecha',
            'DESC'
        )->first();
        $fisicos = ExamenFisico::where('exa_pac_id', $id)->get();

        $fisicosArray = [];
        $fechaActual = new DateTime(date('Y-m-d'));
        $horaActual = date("H:i:s");
        $horaActualCompleta = explode(':', $horaActual);
        $horaCompleta = array('12', '00', '00');
        $horas = [];
        foreach ($fisicos as $key => $fisico) {
            $fechaExamen = new DateTime(date($fisico->fecha));

            $intervaloFechas = $fechaActual->diff($fechaExamen);
            $horasDiasFisico = $intervaloFechas->days * 24;

            $fisicosArray[$key]['id'] = $fisico->id;
            $fisicosArray[$key]['fecha'] = $fisico->fecha;
            $fisicosArray[$key]['horas'] = $horasDiasFisico;
        }

        return view(
            "reportes.expediente-fisico",
            array(
                'paciente' => $paciente,
                'fisico' => $fisicoExpediente,
                'fisicos' => $fisicosArray
            )
        );
    }

    static public function mostrarFisicoAction($id, $fecha)
    {
        $fecha = date('Y-m-d', strtotime($fecha));
        $examenFisico = ExamenFisico::where('exa_pac_id', $id)->where('fecha', $fecha)->first();
        $respuesta = array('datos' => $examenFisico, 'status' => 1, 'fecha' => date('d-M-y',strtotime($fecha)));

//        return $id;
        return $respuesta;
    }

    static public function indexMenuAction($id, $fech)
    {
        $fechaMenu = new DateTime($fech);
        $fechaMenu = $fechaMenu->format('Y-m-d');

        $paciente = Paciente::where('pac_id', $id)?->first();
        $menusHoras = Menu::where('men_pac_id', $id)->get()?->toArray();

        $menus = Menu::where('men_pac_id', $id)->where('men_fecha', $fechaMenu)->get()->toArray();

//        dd($menus);

        $recomendaciones = RecomendacionesMenu::where('rec_pac_id', $id)->where(
            'rec_fecha',
            $fechaMenu
        )->get()->toArray();


        $menuArray = [];
        $menusArray = [];
        $comidaArray = [];
        $comidasArray = [];
        $horas = [];
        $fechaActual = new DateTime(date('Y-m-d'));
        $horaActual = date("H:i:s");
        $horaActualCompleta = explode(':', $horaActual);
        $horaCompleta = array('12', '00', '00');

        $fechaConsulta = date('Y-m-d');
        foreach ($menusHoras as $key => $menu) {
            $fechaMenu = new DateTime(date($menu['men_fecha']));

            $intervaloFechas = $fechaActual->diff($fechaMenu);
            $horasDiasMenu = $intervaloFechas->days * 24;

            $fecha[$key] = $menu['men_fecha'];
            $horas[$key] = $horasDiasMenu;
        }

        foreach ($menus as $menu) {
            switch ($menu['men_comida']) {
                case 1:
                    $comida = 'Ayunas';
                    break;
                case 2:
                    $comida = 'Desayuno';
                    break;
                case 3:
                    $comida = 'Colación';
                    break;
                case 4:
                    $comida = 'Comida';
                    break;
                case 5:
                    $comida = 'Cena';
                    break;
            }
            $menusArray[$menu['men_comida']]['com_id'] = $menu['men_comida'];
            $menusArray[$menu['men_comida']]['comida'] = $comida;
            $menusArray[$menu['men_comida']][$menu['men_dia']]['men_id'] = $menu['men_id'];
            $menusArray[$menu['men_comida']][$menu['men_dia']]['descripcion'] = (string)$menu['men_descripcion'];

            $fechaConsulta = $menu['men_fecha'];
        }

        ksort($menusArray);
        $horas = array_unique($horas);


        return view(
            "reportes.expediente-menus",
            array(
                'paciente' => $paciente,
                'menuArray' => $menuArray,
                'menusArray' => $menusArray,
                'horas' => $horas,
                'recomendaciones' => $recomendaciones,
                'fechaMenu' => $fechaConsulta
            )
        );
    }

    static public function mostrarDiagnostico($id)
    {
        $dianosticos = ExamenFisico::select('diagnostico')->where('exa_pac_id', 1)->get()->toArray();

        $cadenaDianostico = '';
        foreach ($dianosticos as $dianostico) {
            $cadenaDianostico = '';
            foreach ($dianostico as $value) {
                $cadenaDianostico = $cadenaDianostico . " " . $value;
            }
        }
        return $cadenaDianostico;
    }

    static public function calendarioFisico($id, $fecha)
    {
        if (isset($reporte)) {
            $pagina = "reportes/reporte_maquinaria_mano";
        } else {
            $pagina = "administrador/maquinaria_mano";
        }

        $fisicos = ExamenFisico::where('exa_pac_id', $id)->get();


        $fechasArray = [];
        foreach ($fisicos as $key => $fisico) {
            $fechaCompleta = explode("-", $fisico->fecha);
            $fechasArray[$key] = $fechaCompleta[0] . "-" . $fechaCompleta[1] . "-" . $fechaCompleta[2];
        }

        $fechasArray = array_unique($fechasArray);

        $diaActual = date("d", strtotime($fecha));
        $mesActual = date("m", strtotime($fecha));
        $anioActual = date("Y", strtotime($fecha));
        $diaInicio = date("w", strtotime($anioActual . "-" . $mesActual . "-01"));
        $totalDias = date("t", strtotime($fecha));

        if ($diaInicio == 0) {
            $semanas = intval($totalDias / 7);

            if ($totalDias % 7 > 0) {
                $semanas += 1;
            }
        } else {
            $semanas = intval(($totalDias + $diaInicio) / 7);
            if (($totalDias + $diaInicio) % 7 > 0) {
                $semanas += 1;
            }
        }

#Imprime calendario

        print '<table id="" class="table-striped table-bordered table-condensed m-0 m-auto" style="width:220px!important; height:196px;">';

        print"

	<tr>
		<td class='bg-primary text-center'>";

        if ($diaActual == $totalDias && $diaActual != 28) {
            $diaTmp = date("t", strtotime(($anioActual - 1) . "-$mesActual-01"));

            $dia = $diaTmp;
        } else {
            $dia = $diaActual;
            //print "$diaActual";
        }


        ?>

        <a class="text-white" href="">">&lt
        </a>

        <?php
        print "

		</td>

		<td class='bg-primary text-center' colspan='5'>$anioActual</td>

		<td class='bg-primary text-center'>";

        if ($diaActual == $totalDias && $diaActual != 28) {
            $diaTmp = date("t", strtotime(($anioActual - 1) . "-$mesActual-01"));

            $dia = $diaTmp;
        } else {
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

        if ($mesActual == 1) {
            $cadAnioMes = ($anioActual - 1) . "-12";
        } else {
            $cadAnioMes = "$anioActual-" . ($mesActual - 1);
        }

        //print  $cadAnioMes;

        if (($diaActual == $totalDias && $diaActual == 31) || ($mesActual == 3 && ($diaActual == 30 || $diaActual == 29))) {
            $diaTmp = date("t", strtotime($cadAnioMes . "-01"));

            $dia = $diaTmp;
        } else {
            $dia = $diaActual;
        }

        $fecha = $cadAnioMes . "-" . $dia;


        ?>

        <a class="text-white" href="">&lt
        </a>

        <?php

        print "
	</td>

	<td class='bg-primary text-center' colspan='5'>" . $mesActual . "
	 </td>

	<td class='bg-primary text-center'>";

        if ($mesActual == 1) {
            $cadAnioMes = ($anioActual - 1) . "-12";
        } else {
            $cadAnioMes = "$anioActual-" . ($mesActual + 1);
        }

        //print  $cadAnioMes;

        if (($diaActual == $totalDias && $diaActual == 31) || ($mesActual == 3 && ($diaActual == 30 || $diaActual == 29))) {
            $diaTmp = date("t", strtotime($cadAnioMes . "-01"));

            $dia = $diaTmp;
        } else {
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

        $dia = 1;
        $fondo = "fondoCal";

        for ($i = 0; $i < $semanas; $i++) {
            print "<tr>";

            for ($j = 0; $j < 7; $j++) {
                if (($i == 0 && $j < $diaInicio) || ($dia > $totalDias)) {
                    print "<td class='$fondo' style='widht:28px;' height:28px;>&nbsp;</td>";
                } else {
                    if (($dia == $diaActual)) {
                        $fondo = "badge-primary";
                        $colorLiga = "text-white";
                    }
//                    else if(in_array($dia,$arrDias)){
//
//                        $fondo="badge-success";
//
//                    }

                    $numCaracteresDia = strlen($dia);

                    if ($numCaracteresDia == 1) {
                        $dia = "0" . $dia;
                    }


                    $fecha = $anioActual . "-" . $mesActual . "-" . $dia;

                    if (in_array($fecha, $fechasArray)) {
                        $fondo = "badge-success";
                        $colorLiga = "text-white";
                    }


                    print "<td class='$fondo text-center' style='widht:28px; height:28px;'>";


                    ?>

                    <a class="<?php
                    echo $colorLiga; ?>" href=""> <?php
                        echo $dia; ?>
                    </a>


                    <?php

                    print "
			</td>";

                    $dia++;
                }


                $fondo = "fondoCal";
                $colorLiga = "";
            }

            print "</tr>";
        }

        print "</table>";
        #Fin calendario

    }
}
