<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\HistoriaClinicaPreguntas;
use App\Models\HistoriaClinicaRespuestas;
use App\Models\HistoriaClinicaSeccion;
use App\Models\HistoriaClinicaSubSecciones;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoriaClinicaController extends Controller
{
    public function indexAction($id)
    {

        $consulta = Consulta::rightJoin('citas', 'con_cit_id', 'cit_id')
            ->join('pacientes', 'cit_pac_id', 'pac_id')
            ->where('cit_id', '=', $id)
            ->first();

        $secciones = HistoriaClinicaSeccion::where('estado', 1)->orderBy('orden')->get()->toArray();
        $subsecciones = HistoriaClinicaSubSecciones::where('estado', 1)->orderBy('orden')->get()->toArray();
        $preguntas = HistoriaClinicaPreguntas::where('estado', 1)->orderBy('orden')->get()->toArray();
        $respuestas = HistoriaClinicaRespuestas::where('res_pac_id', $consulta->pac_id)->get()->toArray();

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
        return view("paginas.historia", array("status" => 200, 'secciones' => $seccionesArray, 'consulta' => $consulta));
    }

    public function saveAction(Request $request)
    {

        $respuestasPaciente = HistoriaClinicaRespuestas::where('res_pac_id', $request->pac_id)->get();
        $respuestasIds = array_column($respuestasPaciente->toArray(), 'res_pre_id');

        $preguntas = $request->idPregunta;
        $respuestas = $request->respuesta;

        $preguntasCheck = HistoriaClinicaPreguntas::where('estado' , 1)->where('tipo', 2)->orderBy('orden')->get()->toArray();
        $pregunbtasRadio = HistoriaClinicaPreguntas::where('estado', 1)->where('tipo', 3)->orderBy('orden')->get()->toArray();


        $respuestasArray = [];
        foreach ($preguntas as $key => $pregunta) {
            foreach ($respuestas as $j => $respuesta) {
                if ($key == $j) {

                    $respuestasArray[$key]['res_pre_id'] = $pregunta;
                    $respuestasArray[$key]['res_pac_id'] = $request->pac_id;
                    $respuestasArray[$key]['res_respuesta'] = $respuesta;

                }
            }
        }
        foreach ($respuestasArray as $respuesta) {

            if (in_array($respuesta['res_pre_id'], $respuestasIds)) {
                $update = HistoriaClinicaRespuestas::where('res_pre_id', $respuesta['res_pre_id'])->update($respuesta);
            } else {
                DB::table('historia_clinica_respuestas')->insert($respuesta);
            }
        }

        $respuestasArrayRadio = [] ;
        foreach ($pregunbtasRadio as $key => $radio) {
            $respuestasArrayRadio[$key]['res_pre_id'] = $radio['id'];
            $respuestasArrayRadio[$key]['res_pac_id'] = $request->pac_id;
            $respuestasArrayRadio[$key]['res_respuesta'] =  $request->input('pregunta_' . $radio['id'] . '');
        }
        foreach ($respuestasArrayRadio as $respuesta) {
            if (in_array($respuesta['res_pre_id'], $respuestasIds)) {
                $update = HistoriaClinicaRespuestas::where('res_pre_id', $respuesta['res_pre_id'])->update($respuesta);
            } else {
                DB::table('historia_clinica_respuestas')->insert($respuesta);
            }
        }

        $respuestasArrayCheck = [];
        foreach ($preguntasCheck as $key => $check) {

            $valor = $request->input('pregunta_' . $check['id'] . '');
            if($valor == '' ){
                $valor = '2';
            }

            $respuestasArrayCheck[$key]['res_pre_id'] = $check['id'];
            $respuestasArrayCheck[$key]['res_pac_id'] = $request->pac_id;
            $respuestasArrayCheck[$key]['res_respuesta'] = $valor ;
        }

        foreach ($respuestasArrayCheck as $respuesta) {
            if (in_array($respuesta['res_pre_id'], $respuestasIds)) {
                $update = HistoriaClinicaRespuestas::where('res_pre_id', $respuesta['res_pre_id'])->update($respuesta);
            } else {
                DB::table('historia_clinica_respuestas')->insert($respuesta);
            }
        }

        return redirect("historia/" . $request->cit_id)->with("ok-editar", "");

//        if (count($respuestasPaciente) > 0) {
//            foreach ($respuestasArray as $respuesta) {
//                $update = HistoriaClinicaRespuestas::where('res_pre_id', $respuesta['res_pre_id'])->update($respuesta);
//            }
//            return redirect("historia/".$request->cit_id)->with("ok-editar", "");
//        }else {
//            foreach ($respuestasArray as $respuesta) {
//                DB::table('historia_clinica_respuestas')->insert($respuesta);
//            }
//            return redirect("historia/".$request->cit_id)->with("ok-crear", "");
//        }
    }
}
