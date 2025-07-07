<?php

namespace App\Http\Controllers;

use App\Models\HistoriaClinicaPreguntas;
use App\Models\HistoriaClinicaSeccion;
use App\Models\HistoriaClinicaSubSecciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoriaClinicaSubSeccionesController extends Controller
{
    public function indexAction()
    {

        $secciones = HistoriaClinicaSeccion::orderBy('nombre')->get();
        $subsecciones = HistoriaClinicaSubSecciones::orderBy('id_seccion')->orderBy('orden')->orderBy('id', 'desc')->get();

        return view(
            "configuracion.historia-clinica-subsecciones",
            array("status" => 200, 'secciones' => $secciones, 'subsecciones' => $subsecciones));
    }

    static public function showSubseccion ($id) {

        $seccion = HistoriaClinicaSeccion::where('id', $id)->firstOrFail();
        return $seccion;
    }

    static public function shoswSubsecciones ($idSeccion) {

        $subsecciones = HistoriaClinicaSubSecciones::where('id_seccion', $idSeccion)->orderBy('orden')->get();
        return $subsecciones;
    }


    public function saveAction (Request $request) {

        $subseccion = new HistoriaClinicaSubSecciones();
        $subseccion->orden = $request->orden;
        $subseccion->id_seccion = $request->id_seccion;
        $subseccion->nombre = $request->nombre;
        $subseccion->descripcion = $request->descripcion;

        $subseccion->save();
        return redirect("historia-clinica-subsecciones")->with("ok-crear-subseccion", "");
    }

    public function updateAction($id, Request $request) {

        $seccion = new HistoriaClinicaSubSecciones();
        $datos = array(
                        'orden' => $request->orden,
                        'nombre' => $request->nombre,
                        'descripcion' => $request->descripcion,
                        'id_seccion' => $request->id_seccion
                        );
        $seccion->where('id', $id)->update($datos);
        return redirect("historia-clinica-subsecciones")->with("ok-editar-subseccion", "");
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

    public function disableAction($id) {

        $deshabilitar = DB::table('historia_clinica_subsecciones')
            ->where('id', $id)
            ->update(['estado' => 2]);

        return 'ok';
    }

    public function enableAction($id) {

        $deshabilitar = DB::table('historia_clinica_subsecciones')
            ->where('id', $id)
            ->update(['estado' => 1]);

        return 'ok';
    }


    public function deleteAction($id) {

        $preguntas = HistoriaClinicaPreguntas::where('id_subseccion', $id)->get();
        $validar = HistoriaClinicaSubSecciones::where("id", $id)->firstOrFail();


        if(count($preguntas) > 0) {
            return "existe-registro-preguntas";
        }

        if(!empty($validar)) {
            $subseccion = HistoriaClinicaSubSecciones::where('id', $id)->delete();

            return "ok";
        }

    }
}
