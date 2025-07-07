<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EspecialidadController;
use App\Models\Cita;
use App\Models\ExamenFisico;
use App\Models\Menu;
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

        $menus = [];
        $menusArray = [];
        if (auth()->user()->esp_id == 2) {

            $menus = Menu::where('men_pac_id', $consulta->pac_id)->where('men_fecha', $consulta->cit_fecha)->get()->toArray();
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
                $menusArray[$menu['men_comida']][$menu['men_dia']]['descripcion'] = (string) $menu['men_descripcion'];
              }
            ksort($menusArray);
        }


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

        return view(
            "paginas.consulta",
            array(
                'consulta' => $consulta,
                'notas' => $notas,
                'fisico' => $fisico,
                'medicamentos' => $medicamentosArray,
                'statusReceta' => $statusReceta,
                'receta' => $receta,
                'cantidadRegistros' => $cantidadRegistros,
                'menus' => $menus,
                'menusArray' => $menusArray
            )
        );
    }

}
