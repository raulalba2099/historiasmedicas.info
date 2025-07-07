<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use DateTime;
use Illuminate\Http\Request;


class CitaController extends Controller
{
   static  public function indexAction () {

         date_default_timezone_set('America/Mexico_City');

         $citas = Cita::where('pac_id','>',0)->join('pacientes','cit_pac_id','pac_id')
             ->orderBy('cit_fecha','DESC')->orderBy('cit_hora')->get();
         $citasArray = $citas->toArray();

         if (count($citas) > 0) {
             $fechaActual = new DateTime(date('Y-m-d'));

             $horaActual = date("H:i:s");
             foreach ($citasArray as $key => $cita) {
                 $fechaCita = new DateTime(date($cita['cit_fecha']));

                 $intervalo = $fechaActual->diff($fechaCita);
                 $horasDìas = $intervalo->days * 24;

                 $horaActualCompleta = explode(':', $horaActual);
                 $horaCitaCompleta = explode(':', $cita['cit_hora']);

                 $horas = $horaActualCompleta[0] - $horaCitaCompleta[0];
                 $horasTotales = $horasDìas + $horas;

                 $citasArray[$key]['horas'] = $horasTotales;
                 $citasArray[$key]['minutos'] = $horaCitaCompleta[1];

             }


         }
       $pacientes = [];
       $pacientesQuery = new Paciente();
       if (auth()->user())  {
           $pacientes = $pacientesQuery->where('pac_use_id' , auth()->user()->id)->orderBy("pac_nombre", 'desc')->get();
       }

         return  $citas =   array('citas' => $citasArray, 'pacientes' => $pacientes) ;
    }

}
