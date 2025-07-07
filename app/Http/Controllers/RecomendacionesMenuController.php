<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\RecomendacionesMenu;
use Illuminate\Http\Request;

class RecomendacionesMenuController extends Controller
{
    public function saveAction (Request $request) {

        $citId = $request->cit_id;

        if($request->rec_id) {

            $datos = array(
                'rec_id' => $request->rec_id,
                'rec_fecha' => $request->fecha,
                'rec_pac_id' => $request->pac_id,
                'rec_descripcion' => $request->descripcion,
            );

            $recomendaciones = RecomendacionesMenu::where('rec_id', $request->rec_id)->update($datos);

            $respuesta = array(
                'rec_id' => $datos['rec_id'],
                'rec_descripcion' => $datos['rec_descripcion'],
                'mensaje' => 'ok',
                'accion' => 'editar',
                'cit_id' => $citId
            );
        }else {

            $recomendaciones = new RecomendacionesMenu();
            $recomendaciones->rec_fecha = $request->fecha;
            $recomendaciones->rec_pac_id = $request->pac_id;
            $recomendaciones->rec_descripcion = $request->descripcion;

            $recomendaciones->save();
            $recomendaciones_id = $recomendaciones->rec_id;

            $respuesta = array(
                'rec_descripcion' => $recomendaciones->rec_descripcion,
                'mensaje' => 'ok',
                'accion' => 'insertar',
                'cit_id' => $citId,
            );
        }
        return json_encode($respuesta);

    }
}
