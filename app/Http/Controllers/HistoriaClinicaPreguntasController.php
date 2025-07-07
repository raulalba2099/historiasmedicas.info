<?php

namespace App\Http\Controllers;

use App\Models\HistoriaClinicaPreguntas;
use App\Models\HistoriaClinicaRespuestas;
use App\Models\HistoriaClinicaSeccion;
use App\Models\HistoriaClinicaSubSecciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoriaClinicaPreguntasController extends Controller
{
    public function indexAction() {
        $preguntas = HistoriaClinicaPreguntas::where('id', '>', 0)-> orderBy('id_subseccion')->orderBy('orden')->get();
        $secciones = HistoriaClinicaSeccion::where('estado', 1)->orderBy('nombre')->get();
        $subsecciones = HistoriaClinicaSubSecciones::where('estado',1)->orderBy('nombre')->get();

        return view("configuracion.historia-clinica-preguntas", array("status" => 200, 'secciones' =>$secciones, 'subsecciones' => $subsecciones, 'preguntas' => $preguntas));
    }

    static  public function showSubseccion($id) {

        $subseccion = HistoriaClinicaSubSecciones::where('id', $id)->firstOrFail();
        return $subseccion;
    }

    public function saveAction(Request $request, $idPregunta = null) {

        $pregunta = new HistoriaClinicaPreguntas();
        $pregunta->orden = $request->orden;
        $pregunta->tipo = $request->id_tipo;
        $pregunta->id_subseccion = $request->id_subseccion;
        $pregunta->descripcion = $request->descripcion;
        $pregunta->id_padre = $request->id_padre;

        $validar = $request->validate(
            [
                "orden" => "required|",
                'id_tipo' => 'required',
                "id_subseccion" => "required",
                "descripcion" => "required",
            ]);

        $datos = array(
                'orden' => $pregunta->orden,
                'tipo' => $pregunta->tipo,
                'id_subseccion' => $pregunta->id_subseccion,
                'descripcion'=> $pregunta->descripcion,
                'id_padre' => $pregunta->id_padre
                );
       if(!empty($idPregunta)) {

           $pregunta->where('id', $idPregunta)->update($datos);
           return redirect("historia-clinica-preguntas")->with("ok-editar", "");
       }else {

           $pregunta->save();
           return redirect("historia-clinica-preguntas")->with("ok-crear", "");
       }
    }

    public function disableAction($id) {

        $deshabilitar = DB::table('historia_clinica_preguntas')
            ->where('id', $id)
            ->update(['estado' => 2]);

        return 'ok';
    }

    public function enableAction($id) {

        $deshabilitar = DB::table('historia_clinica_preguntas')
            ->where('id', $id)
            ->update(['estado' => 1]);

        return 'ok';
    }

    public function deleteAction($id, Request $request)
    {
        $validar = HistoriaClinicaPreguntas::where("id", $id)->firstOrFail();
        $respuestas = HistoriaClinicaRespuestas::where('res_pre_id', $id)->get();

        if (count($respuestas) > 0) {
            return 'existe-registro-respuestas';
        }

        if (!empty($validar)) {
            $preugunta = HistoriaClinicaPreguntas::where("id", $id)->delete();
            //Responder al AJAX de JS
            return "ok";
        } else {
            return redirect("historia-clinica-preguntas")->with("no-borrar", "");
        }
    }

    static public function estadoString($estado) {

        switch ($estado) {
            case 1:
                $estadoString = 'Habilitado';
                break;
            case 2:
                $estadoString = 'Deshabilitado';
                break;
        }
        return $estadoString;
    }
}
