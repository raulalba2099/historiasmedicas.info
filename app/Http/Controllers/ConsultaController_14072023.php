<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\ExamenFisico;
use App\Models\Receta;
use Illuminate\Http\Request;

use App\Models\CitaCrear;
use App\Models\Nota;
use App\Models\Consulta;


class ConsultaController extends Controller
{
    static public function indexAction($id)
    {

        $consulta = Consulta::rightJoin('citas', 'con_cit_id', 'cit_id')
            ->join('pacientes', 'cit_pac_id', 'pac_id')
            ->where('cit_id', '=', $id)
            ->first();
        $notas = Nota::where('not_pac_id', $consulta->cit_pac_id)->orderBy('not_id', 'desc')->get();
        $fisico = ExamenFisico::where('exa_cit_id', $id)->first();

        $citas = Cita::where('cit_pac_id', $consulta->cit_pac_id)->get()->toArray();

        $medicamentosArray = [];
        foreach ($citas as $cita) {
            $medicamentos = Receta::where('rec_cit_id', $cita['cit_id'])->get()->toArray();

            foreach ($medicamentos as $medicamento) {
                $medicamentosArray[$cita['cit_id']]['medicamento'] = $medicamento['rec_medicamento'];
                $medicamentosArray[$cita['cit_id']]['dosis'] = $medicamento['rec_dosis'];
                $medicamentosArray[$cita['cit_id']]['duracion'] = $medicamento['rec_duracion'];
                $medicamentosArray[$cita['cit_id']]['fecha'] = $cita['cit_fecha'];
            }
        }

        $receta = Receta::where('rec_cit_id', $id)->get();

        $cantidadRegistros = 0;
        if (count($receta) > 0) {
            $statusReceta = 200;
            $cantidadRegistros = count($receta);
        } else {
            $statusReceta = 400;
        }

        return view("paginas.consulta", array('consulta' => $consulta, 'notas' => $notas, 'fisico' => $fisico, 'medicamentos' => $medicamentosArray, 'statusReceta' => $statusReceta, 'receta' => $receta, 'cantidadRegistros' => $cantidadRegistros, ));

    }

}
