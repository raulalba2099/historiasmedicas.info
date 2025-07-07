<?php

namespace App\Http\Controllers;

use App\Models\ExamenFisico;
use Illuminate\Http\Request;

use App\Models\CitaCrear;
use App\Models\Nota;
use App\Models\Consulta;


class ConsultaController extends Controller
{
    static public function indexAction($id) {

        $consulta = Consulta::rightJoin('citas','con_cit_id', 'cit_id')
            ->join('pacientes','cit_pac_id','pac_id')
            ->where('cit_id', '=' , $id)
            ->first();

        $notas = Nota::where('not_pac_id', $consulta->cit_pac_id)->orderBy('not_id', 'desc')->get();
        $fisico = ExamenFisico::where('exa_cit_id', $id)->first();

       return view("paginas.consulta", array('consulta' => $consulta, 'notas' =>$notas, 'fisico'=> $fisico));

    }

}
