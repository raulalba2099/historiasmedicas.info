<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarioContenidoController extends Controller
{
    static public function calendarioContenido($fecha,$valores){

        if(isset($reporte)){

            $pagina =  "reportes/reporte_maquinaria_mano";
        }else {

            $pagina = "administrador/maquinaria_mano";
        }

        $valor = ['2023-05-01','2023-05-27'];

        foreach ($valores as $key => $valor) {

            $fechaCompleta = explode("-", $valor);
            $fechasArray[] = $fechaCompleta[0]."-".$fechaCompleta[1]."-".$fechaCompleta[2];

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
		<td class='badge-info text-center'>";

        if($diaActual==$totalDias && $diaActual!=28){

            $diaTmp=date("t", strtotime(($anioActual - 1)."-$mesActual-01"));

            $dia = $diaTmp;

        }else{

            $dia = $diaActual;
            //print "$diaActual";
        }



        ?>

        <a class="ligaBlanca" href="" >">&lt
        </a>

        <?php
        print "

		</td>

		<td class='badge-info text-center' colspan='5'>$anioActual</td>

		<td class='badge-info text-center'>";

        if($diaActual==$totalDias && $diaActual!=28){
            $diaTmp=date("t", strtotime(($anioActual - 1)."-$mesActual-01"));

            $dia = $diaTmp;

        }else{

            $dia = $diaActual;

        }

        ?>

        <a class="ligaBlanca" href="">&gt
        </a>

        <?php

        print"
	    </td>

    </tr>

	<tr>

	<td class='badge-info text-center'>";

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

        <a class="ligaBlanca" href="">&lt
        </a>

        <?php

        print "
	</td>

	<td class='badge-info text-center' colspan='5'>".$mesActual."
	 </td>

	<td class='badge-info text-center'>";

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

        <a class="ligaBlanca" href="">">&gt
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
                        $colorLiga = "ligaBlanca";


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
                        $colorLiga = "ligaBlanca";
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
