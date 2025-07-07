<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Estudio;
use App\Models\ExamenFisico;
use App\Models\Nota;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Paciente;
use DateTime;

class PacienteController extends Controller
{
    static public function indexAction()
    {

        $pacientesQuery = new Paciente();
        $ultimoNumeroPaciente = 0;

        $pacientes = $pacientesQuery->where('pac_use_id', auth()->user()->id)->orderBy("pac_id", 'desc')->get();
        $pacientesArray = $pacientes->toArray();

        $pacientesTodos = Paciente::all()->toArray();



//        foreach ($pacientesArray as $key => $paciente) {
//            $pacientesArray[$key]['pac_edad'] = self::age($paciente['pac_nacimiento']);
//        }

        if (count($pacientesTodos) > 0) {
            $numerosPacientes = array_column($pacientesTodos, 'pac_numero');
            $ultimoNumeroPaciente = max($numerosPacientes);
        }

        return view("paginas.pacientes", array("status" => 200, "mensaje" => 'index', "pacientes" => $pacientesArray, 'ultimoNumeroPaciente' => $ultimoNumeroPaciente));
    }


    /*================================================
    =            Mostrar un solo registro            =
    ================================================*/

    public function show($id)
    {

        $pacientes = DB::table('pacientes')
            ->orderBy('pac_id', 'desc')
            ->get();

        $pacientesQuery = new Paciente();
        $paciente = $pacientesQuery->where('pac_id', $id)->get();

        $respuesta = array("status" => 400);
        if (count($paciente) > 0) {
            $respuesta = array('status' => 200, "paciente" => $paciente);
        }

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }

    /*=====  End of Mostrar un solo registro  ======*/

    static public function saveAction(Request $request)
    {

        //Recoger los datos
        $datos = array
        (
            "es_cita" => $request->input('es_cita'),
            "pac_nombre" => $request->input('pac_id'),
            "pac_numero" => $request->input('pac_numero'),
            "pac_nombre" => $request->input('pac_nombre'),
            "pac_paterno" => $request->input('pac_paterno'),
            "pac_materno" => $request->input('pac_materno'),
            "pac_nacimiento" => $request->input('pac_nacimiento'),
            "pac_genero" => $request->input('pac_genero'),
            "pac_direccion" => $request->input('pac_direccion'),
            "pac_telefono" => $request->input('pac_telefono'),
            "pac_correo" => $request->input('pac_correo'),
            'pac_use_id' => auth()->user()->id,
        );

        $pacientesQuery = new Paciente();

        $validar = $request->validate(
            [
                "pac_numero" => "required|unique:pacientes",
                "pac_nombre" => "required",
                "pac_paterno" => "required",
                "pac_materno" => "required",
                "pac_genero" => "required",
            ]);

        //busca si existe
        $pacienteExiste = Paciente::where('pac_nombre', 'like', $request->pac_nombre)
            ->where('pac_paterno', 'like', $request->pac_paterno)
            ->where('pac_materno', 'like', $request->pac_materno)
            ->get();

        if ($request->es_cita == 1) {
            $vista = 'citas-crear';
        } else if ($request->es_cita == 2) {
            $vista = 'citas';
        } else {
            $vista = 'pacientes';
        }

        if (count($pacienteExiste) > 0) {
            return redirect($vista)->with("paciente-ya-existe", "");
        }

        $paciente = new Paciente();

        $paciente->pac_numero = $datos['pac_numero'];
        $paciente->pac_nombre = $datos['pac_nombre'];
        $paciente->pac_paterno = $datos['pac_paterno'];
        $paciente->pac_materno = $datos['pac_materno'];
        $paciente->pac_nacimiento = $datos['pac_nacimiento'];
        $paciente->pac_genero = $datos['pac_genero'];
        $paciente->pac_direccion = $datos['pac_direccion'];
        $paciente->pac_telefono = $datos['pac_telefono'];
        $paciente->pac_correo = $datos['pac_correo'];
        $paciente->pac_correo = $datos['pac_correo'];
        $paciente->pac_use_id = $datos['pac_use_id'];

        $paciente->save();

        if ($datos['es_cita'] == 1) {
            return redirect("citas-crear")->with("ok-crear-paciente", "");
        } else if ($datos['es_cita'] == 2) {
            return redirect("citas")->with("ok-crear-paciente", "");
        } else {
            return redirect("pacientes")->with("ok-crear", "");
        }
    }

    public function updateAction(int $id, Request $request)
    {
        //Recoger los datos


        $pacienteQuery = new Paciente();
        $pacientes = $pacienteQuery->where('pac_id', '<>', $id)->get()->toArray();

        $numerosPacientes = array_column($pacientes, 'pac_numero');

        $datos = array
        (
            'pac_id' => $request->input('pac_id'),
            "pac_numero" => $request->input('pac_numero'),
            "pac_nombre" => $request->input('pac_nombre'),
            "pac_paterno" => $request->input('pac_paterno'),
            "pac_materno" => $request->input('pac_materno'),
            "pac_nacimiento" => $request->input('pac_nacimiento'),
            "pac_genero" => $request->input('pac_genero'),
            "pac_direccion" => $request->input('pac_direccion'),
            "pac_telefono" => $request->input('pac_telefono'),
            "pac_correo" => $request->input('pac_correo')
        );

        $pacientesQuery = new Paciente();
        $validar = $request->validate(
            [
//                "pac_numero" => "required|unique:pacientes,pac_id,".$id,
                "pac_nombre" => "required",
                "pac_paterno" => "required",
                "pac_materno" => "required",
                "pac_genero" => "required",
                //"pac_telefono" => "regex:/^[^(\d{3}[- ]?){2}\d{4}$]+$/i",
                //"pac_correo" => "email",
            ]);

        //busca si existe
        $pacienteExiste = Paciente::where('pac_nombre', 'like', $request->pac_nombre)
            ->where('pac_paterno', 'like', $request->pac_paterno)
            ->where('pac_materno', 'like', $request->pac_materno)
            ->where('pac_id', '<>', $id)
            ->get();

        if ($request->es_cita == 1) {
            $vista = 'citas-crear';
        } else if ($request->es_cita == 2) {
            $vista = 'citas';
        } else {
            $vista = 'pacientes';
        }

        if (count($pacienteExiste) > 0) {
            return redirect($vista)->with("paciente-ya-existe", "");
        }

        if (in_array($datos['pac_numero'], $numerosPacientes)) {
            return redirect("pacientes")->with("existe-editar", "");
        } else {

            $pacienteQuery = new Paciente();
            $pacienteQuery->where('pac_id', $datos['pac_id'])->update($datos);
        }

        return redirect("pacientes")->with("ok-editar", "");

    }

    public function deleteAction($id, Request $request)
    {
        $cita = Cita::where('cit_pac_id', $id)->get();
        $estudios = Estudio::where('est_pac_id', $id)->get();
        $notas = Nota::where('not_pac_id', $id)->get();
        $examenFisico = ExamenFisico::where('exa_pac_id', $id)->get();


        if (count($cita) > 0 || count($estudios) > 0 || count($notas) > 0 || count($examenFisico) > 0) {
            $respuesta = 'existe-registro-paciente';
            return $respuesta;
        }

        $validar = Paciente::where("pac_id", $id)->get();

        if (!empty($validar)) {
            $paciente = Paciente::where("pac_id", $id)->delete();
            $respuesta = "ok";
            //Responder al AJAX de JS
        } else {
            return redirect("pacientes")->with("no-borrar", "");
        }

        return $respuesta;

    }

    public function buscaPacientes(Request $request, $paciente)
    {
        if (is_numeric($paciente)) {
            $pacientes = Paciente::where('pac_numero', $paciente)->first();
        } else {
            $nombreCompleto = explode(' ', $paciente);

            if(empty($nombreCompleto[1])) {
                $nombreCompleto[1] = '';
            }
            if(empty($nombreCompleto[2])) {
                $nombreCompleto[2] = '';
            }

            $pacientes = Paciente::where('pac_nombre', 'like', $nombreCompleto[0].'%')
                ->where('pac_paterno', 'like', '%'.$nombreCompleto[1].'%')
                ->where('pac_materno', 'like', '%'.$nombreCompleto[2].'%')
                ->where('pac_use_id', auth()->user()->id)
                ->orderBy('pac_id', 'desc')
                ->get();
        }
        if (count($pacientes) >0 ) {
            $pacientesArray = array('pacientes' => $pacientes, 'status' => 1 );
        } else {
            $pacientes = Paciente::where('pac_use_id', auth()->user()->id)->orderBy('pac_id','desc')->get();
            $pacientesArray = array('pacientes' => $pacientes, 'status' => 400);
        }
        return $pacientesArray;
    }

//   static public function age($fecha_nacimiento)
//    {
//        $nacimiento = new DateTime($fecha_nacimiento);
//        $ahora = new DateTime(date("Y-m-d"));
//        $diferencia = $ahora->diff($nacimiento);
//        return $diferencia->format("%y");
//    }

}
