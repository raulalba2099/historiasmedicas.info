<?php

namespace App\Http\Controllers;

use App\Models\ExamenFisico;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;

class ExamenFisicoController extends Controller
{

    public  function saveAction (Request $request) {

        $existe = ExamenFisico::where('exa_cit_id', $request->cit_id)->orderBy('id', 'DESC')->first();

        if(!empty($existe)) {
            $datos = array
            (
                "presion_arterial_diastolica" => $request?->input( 'diastolica'),
                "presion_arterial_sistolica" => $request?->input( 'sistolica'),
                "presion_arterial" => $request?->input('arterial'),
                "frecuencia_cardiaca" => $request?->input('cardiaca'),
                "frecuencia_respiratoria" => $request?->input('respiratoria'),
                "saturacion" => $request?->input('saturacion'),
                "temperatura" => $request?->input('temperatura'),
                "talla" => $request?->input('talla'),
                "glucosa" => $request?->input('glucosa'),
                "peso" => $request?->input('peso'),
                'alergias' => $request?->input('alergias'),
                "imc" => $request?->input('imc'),
                'diagnostico' => $request?->input('diagnostico'),
                'fecha' => $request?->input('cit_fecha'),

                'exa_grasa' =>$request?->input('exa_grasa'),
                'exa_musculo' =>$request?->input('exa_musculo'),
                'exa_visceral' =>$request?->input('exa_visceral'),
                'exa_metabolica' =>$request?->input('exa_metabolica'),
                'exa_kilos' =>$request?->input('exa_kilos'),
                'exa_cmb' =>$request?->input('exa_cmb'),
                'exa_cci' =>$request?->input('exa_cci'),
                'exa_cca' =>$request?->input('exa_cca'),

            );

//            dd($datos);

            $fisico = ExamenFisico::where('exa_cit_id', $request->cit_id)->update($datos);

        }else {

            $fisico = new ExamenFisico();

            $fisico->presion_arterial_sistolica = $request?->sistolica;
            $fisico->presion_arterial_diastolica = $request?->diastolica;
            $fisico->presion_arterial = $request?->arterial;
            $fisico->exa_cit_id = $request?->cit_id;
            $fisico->exa_pac_id = $request?->pac_id;
            $fisico->frecuencia_cardiaca = $request?->cardiaca;
            $fisico->frecuencia_respiratoria = $request?->respiratoria;
            $fisico->saturacion = $request?->saturacion;
            $fisico->temperatura = $request?->temperatura;
            $fisico->talla = $request?->talla;
            $fisico->peso = $request?->peso;
            $fisico->glucosa = $request?->glucosa;
            $fisico->alergias = $request?->alergias;
            $fisico->imc = $request?->imc;
            $fisico->diagnostico = $request?->diagnostico;
            $fisico->fecha = $request?->cit_fecha;

            $fisico->exa_grasa = $request?->exa_grasa;
            $fisico->exa_musculo = $request?->exa_musculo;
            $fisico->exa_visceral = $request?->exa_visceral;
            $fisico->exa_metabolica = $request?->exa_metabolica;
            $fisico->exa_kilos = $request?->exa_kilos;
            $fisico->exa_cmb = $request?->exa_cmb;
            $fisico->exa_cci = $request?->exa_cci;
            $fisico->exa_cca = $request?->exa_cca;

            $fisico->save();

        }
        return redirect("consulta/$request->cit_id")->with("ok-crear-fisico", "");

    }


}
