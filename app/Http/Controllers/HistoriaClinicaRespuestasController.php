<?php

namespace App\Http\Controllers;

use App\Models\HistoriaClinicaRespuestas;
use Illuminate\Http\Request;

class HistoriaClinicaRespuestasController extends Controller
{
    public function showRespuesta($idPregunta)
    {
        $respuesta = HistoriaClinicaRespuestas::where('res_pre_id', $idPregunta)->get();

        return $respuesta;

    }
}
