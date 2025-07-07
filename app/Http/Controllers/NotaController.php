<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nota;

class NotaController extends Controller
{
    public function saveAction(Request $request)
    {

        $nota = new Nota();

        $nota->not_pac_id = $request->pac_id;
        $nota->not_descripcion = $request->descripcion;
        $nota->not_fecha = $request->fecha;
        $nota->not_hora = date('H:i:s');

        $validar = $request->validate(
            [
                "descripcion" => "required"
            ]);

        $nota->save();

        return redirect("consulta/$request->cit_id")->with("ok-crear-nota", "");
    }

    public function updateAction ($id, Request $request) {

        $nota = new Nota();
        $descripcion =  $nota->not_descripcion = $request->descripcion;
        $hora = $nota->not_hora = $request->hora;

        $validar = $request->validate(
            [
                "descripcion" => "required"
            ]);
        $datos = array('not_descripcion' => $descripcion, 'not_hora' => $hora);
        $update = $nota->where('not_id', $request->not_id)->update($datos);

        return redirect("consulta/$request->cit_id")->with("ok-editar-nota", "");
    }

    public function deleteAction($id, Request $request)
    {

        $validar = Nota::where("not_id", $id)->get();

        if (!empty($validar)) {

            $paciente = Nota::where("not_id", $id)->delete();
            $respuesta = "ok";
            //Responder al AJAX de JS

        } else {
            return redirect("consulta")->with("no-borrar", "");
        }
        return $respuesta;

    }

}
