<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use DateTime;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;


class CitaController extends Controller
{
   static  public function indexAction () {

        $citas = Cita::join('pacientes','cit_pac_id', 'pac_id')
            ->where('pac_use_id', (!empty(auth()->user())) ?  auth()->user()->id : '>', 0  )
            ->orderBy('cit_hora', 'desc')
            ->get();
        $citasArray = $citas->toArray();

       $pacientesCita = Paciente::orderBy('pac_id', 'desc')->get();
       $pacientesArray = $pacientesCita->toArray();
       $pacientesArrayNumeros = array_unique(array_column($pacientesArray, 'pac_numero'));

       if(count($pacientesCita) > 0 ) {
           $siguienteNumero = max($pacientesArrayNumeros) + 1;
       }

         if (count($citas) > 0) {
             $fechaActual = new DateTime(date('Y-m-d'));
             $horaActual = date("H:i:s");


             foreach ($citasArray as $key => $cita) {
                 $fechaCita = new DateTime(date($cita['cit_fecha']));

                 $intervalo = $fechaActual->diff($fechaCita);
                 $horasDìas = $intervalo->days * 24;

                 $horaActualCompleta = explode(':', $horaActual);
                 $horaCitaCompleta = explode(':', $cita['cit_hora']);

                 if($fechaActual > $fechaCita) {
                     $horas = $horaActualCompleta[0] - $horaCitaCompleta[0];
                     $horasTotales = '-' . ' ' .  $horasDìas + $horas;
                 } else {

                     $horas = $horaCitaCompleta[0] - $horaActualCompleta[0] ;
                     $horasTotales = '+' .' ' . $horasDìas + $horas;
                 }

                 $citasArray[$key]['horas'] = $horasTotales;
                 $citasArray[$key]['minutos'] = $horaCitaCompleta[1];

             }
         }

       $pacientes = [];
       $pacientesQuery = new Paciente();
       if (auth()->user())  {
//           $pacientes = $pacientesQuery->where('pac_use_id' , auth()->user()->id)->orderBy("pac_id", 'desc')->get();
           $pacientes = $pacientesQuery->where('pac_use_id' , auth()->user()->id)->orderBy("pac_id", 'desc')->get();
       }

//       dd($citasArray);

         return  $citas =   array('citas' => $citasArray, 'pacientes' => $pacientes, 'siguienteNumero' => $siguienteNumero) ;
    }

}
