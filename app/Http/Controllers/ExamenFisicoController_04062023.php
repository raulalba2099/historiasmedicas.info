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
                "frecuencia_cardiaca" => $request->input('cardiaca'),
                "frecuencia_respiratoria" => $request->input('respiratoria'),
                "presion_arterial" => $request->input('arterial'),
                "temperatura" => $request->input('temperatura'),
                "talla" => $request->input('talla'),
                "peso" => $request->input('peso'),
                "imc" => $request->input('imc'),
                'diagnostico' => $request->input('diagnostico'),
                'fecha' => $request->input('cit_fecha'),
//                "fecha" => date("y-m-d", strtotime(now()))
            );

            $fisico = ExamenFisico::where('exa_cit_id', $request->cit_id)->update($datos);
//            $pacienteQuery = new Paciente();
//            $pacienteQuery->where('pac_id', $datos['pac_id'])->update($datos);

        }else {

            $fisico = new ExamenFisico();
            $fisico->exa_cit_id = $request->cit_id;
            $fisico->exa_pac_id = $request->pac_id;
            $fisico->frecuencia_cardiaca = $request->cardiaca;
            $fisico->frecuencia_respiratoria = $request->respiratoria;
            $fisico->presion_arterial = $request->arterial;
            $fisico->temperatura = $request->temperatura;
            $fisico->talla = $request->talla;
            $fisico->peso = $request->peso;
            $fisico->imc = $request->imc;
            $fisico->diagnostico = $request->diagnostico;
            $fisico->fecha = $request->cit_fecha;

            $fisico->save();

        }
        return redirect("consulta/$request->cit_id")->with("ok-crear-fisico", "");

    }


}
