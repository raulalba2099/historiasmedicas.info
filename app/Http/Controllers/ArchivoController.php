<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{
    public function guardaArchivo($archivo,$nombreArchivo, $ruta)
    {
       $path =  $archivo->storeAs($ruta,$nombreArchivo);
       return $path;
    }

    public  function descargaArchivo ($nombreArchivo) {
        $descarga = Storage::download($nombreArchivo);
        return $descarga;
    }

}
