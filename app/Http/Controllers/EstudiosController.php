<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ArchivoController;
use App\Models\Cita;
use App\Models\Nota;
use Illuminate\Http\Request;
use App\Models\Estudio;


use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;

class EstudiosController extends Controller
{
    public function indexAction($id)
    {
        $consulta = Cita::where('cit_id', $id)
            ->join('pacientes', 'cit_pac_id', 'pac_id')->get();

        $estudios = Estudio::where('est_pac_id', $consulta[0]->cit_pac_id)->orderBy('est_id', 'desc')->get();
       // $especialidad = EspecialidadController::especilidadUser();

        return view(
            "paginas.estudios",
            array('consulta' => $consulta, 'estudios' => $estudios)
        );
    }


    public function saveAction(Request $request)
    {
        $estudio = new Estudio();

        $estudio->est_pac_id = $request->pac_id;
        $estudio->est_nombre = $request->est_nombre;
        $estudio->est_observaciones = $request->est_observaciones;
        $estudio->est_fecha = $request->est_fecha;

        $ruta = '';
        if ($request->est_archivo != null) {
            $extension = $request->file('est_archivo')->getClientOriginalExtension();
            $tamaño = $request->file('est_archivo')->getSize();
            $tamañoMb = (30 * 1024) * 1024;

            if ($extension != 'pdf' and $extension != 'docx' and $extension != 'odt' and $extension != "jpeg") {
                return redirect("estudios/$request->cit_id")->with("error-extension", "");
            }
            if ($tamaño > $tamañoMb) {
                return redirect("estudios/$request->cit_id")->with("error-tamanio", "");
            }

            $nombreArchivo = 'est_' . auth()->id() . "_" . uniqid() . "." . $extension;
            $archivo = new ArchivoController();
            $ruta = $archivo->guardaArchivo($request->est_archivo, $nombreArchivo, 'public/files/estudios');
        }

        $estudio->est_archivo = $ruta;

        $validar = $request->validate(
            [
                "est_nombre" => "required",
                "est_fecha" => "required",
            ]
        );

        $estudio->save();

        return redirect("estudios/$request->cit_id")->with("ok-crear", "");
    }

    public function updateAction(Request $request, $id)
    {
        $extension = $request->file('est_archivo')->getClientOriginalExtension();
        $tamaño = $request->file('est_archivo')->getSize();
        $tamañoMb = (30 * 1024) * 1024;

        if ($extension != 'pdf' and $extension != 'docx' and $extension != 'odt' and $extension != "jpeg") {
            return redirect("estudios/$id")->with("error-extension", "");
        }
        if ($tamaño > $tamañoMb) {
            return redirect("estudios/$id")->with("error-tamanio", "");
        }

        $archivoActual = $request->est_archivo_actual;

        $borrado = 0;
        $existe = 1;
        if ($archivoActual != '') {
            if (Storage::delete($archivoActual)) {
                $borrado = 1;
            }
        } else {
            $existe = 0;
        }

        $ruta = '';
        if ($borrado == 1 or $existe == 0) {
            $nombreArchivo = 'est_' . auth()->id() . "_" . uniqid() . "." . $extension;
            $archivo = new ArchivoController();
            $ruta = $archivo->guardaArchivo($request->est_archivo, $nombreArchivo, 'public/files/estudios');
        }

        $datos = array
        (
            'est_nombre' => $request->est_nombre,
            'est_observaciones' => $request->est_observaciones,
            'est_fecha' => $request->est_fecha,
            'est_archivo' => $ruta
        );

        $estudioeQuery = new Estudio();
        $estudioeQuery->where('est_id', $request->est_id)->update($datos);
        return redirect("estudios/$id")->with("ok-editar", "");
    }

    public function dowloadAction($id)
    {
        $estudio = Estudio::where('est_id', $id)->firstOrFail();

        $ruta = $estudio->est_archivo;

        $descarga = Storage::download($ruta);
        return $descarga;
    }

    public function deleteAction($id, Request $request)
    {
        $validar = Estudio::where("est_id", $id)->firstOrFail();


        if (!empty($validar)) {
            if ($validar->est_archivo != '') {
                Storage::delete($validar->est_archivo);
            }

            $estudio = Estudio::where("est_id", $id)->delete();

            //Responder al AJAX de JS
            return "ok";
        } else {
            return redirect("estudios")->with("no-borrar", "");
        }
    }

}
