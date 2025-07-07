<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\ExamenFisico;
use App\Models\HistoriaClinicaSencilla;
use Illuminate\Http\Request;

class HistoriaClinicaSencillaController extends Controller
{
        protected  function index ($id) {

            $consulta = Consulta::rightJoin('citas', 'con_cit_id', 'cit_id')
                ->join('pacientes', 'cit_pac_id', 'pac_id')
                ->where('cit_id', '=', $id)
                ->first();

            $fisico = ExamenFisico::where('exa_cit_id', $id)->first();

            $historia = new HistoriaClinicaSencilla();
             $historiaClinica =  $historia->where('cit_id',$id)->first();
            return view(
                "paginas.historia",
                array('historia' => $historiaClinica,'consulta' => $consulta, 'fisico' => $fisico)
            );
        }

        protected function save(Request $request) {

            $historia = new HistoriaClinicaSencilla();
            $historia->descripcion =$request->descripcion;
            $historia->cit_id =$request->cit_id;
            $historiaCita = $historia->where('cit_id',$request->cit_id)->get()->toArray();

            if (!empty($historiaCita)){
                $historiaArray = $historia->toArray();
                $update = $historia->where('cit_id', $request->cit_id)->update($historiaArray);
            }else {
                $historia->save();
            }
            return redirect("historia/$request->cit_id")->with("ok-crear", "");
        }


}
