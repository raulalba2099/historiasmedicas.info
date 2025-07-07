<?php

namespace App\Http\Controllers;

use App\Models\HistoriaClinicaRespuestas;
use App\Models\HistoriaClinicaSeccion;
use App\Models\HistoriaClinicaSubSecciones;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoriaClinicaSeccionController extends Controller
{
    public function indexAction()
    {
        $secciones = HistoriaClinicaSeccion::orderBy('orden')->orderBy('id', 'desc')->get();
        return view("configuracion.historia-clinica-secciones", array("status" => 200, 'secciones' => $secciones));
    }

    public function show($id)
    {
        return $seccion = HistoriaClinicaSeccion::where('id', $id)->first();

    }

    public function saveAction(Request $request)
    {
        $seccion = new HistoriaClinicaSeccion();
        $seccion->orden = $request->orden;
        $seccion->nombre = $request->nombre;
        $seccion->descripcion = $request->descripcion;
        $seccion->save();

        return redirect("historia-clinica-secciones")->with("ok-crear-seccion", "");
    }

    public function updateAction($id, Request $request)
    {
        $seccion = new HistoriaClinicaSeccion();
        $seccion->orden = $request->orden;
        $datos = array('nombre' => $request->nombre, 'descripcion' => $request->descripcion, 'orden' => $request->orden);
        $seccion->where('id', $id)->update($datos);
        return redirect("historia-clinica-secciones")->with("ok-editar-seccion", "");
    }

    public function disableAction($id) {

        $deshabilitar = DB::table('historia_clinica_secciones')
            ->where('id', $id)
            ->update(['estado' => 2]);

        return 'ok';
    }

    public function enableAction($id) {

        $deshabilitar = DB::table('historia_clinica_secciones')
            ->where('id', $id)
            ->update(['estado' => 1]);

        return 'ok';
    }

    public function deleteAction($id, Request $request)
    {
        $validar = HistoriaClinicaSeccion::where("id", $id)->firstOrFail();
        $subsecciones = HistoriaClinicaSubSecciones::where('id_seccion', $id)->get();

        if (count($subsecciones) > 0) {
            return "existe-registro-subseccion";
        }

        if (!empty($validar)) {

            $seccion = HistoriaClinicaSeccion::where("id", $id)->delete();

            //Responder al AJAX de JS
            return "ok";

        } else {
            return redirect("historia-clinica-secciones")->with("no-borrar", "");
        }
    }

    static public function estadoString($estado)
    {

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
