<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\ExamenFisico;
use App\Models\Receta;
use Illuminate\Http\Request;
use App\Models\CitaCrear;
use App\Models\Paciente;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Logging\Exception;

class CitasCrearController extends Controller
{
    public function indexAction () {

         $siguienteNumero = 0;
         $citas =  CitaCrear::join('pacientes','cit_pac_id', 'pac_Id')->where('pac_use_id', auth()->user()->id)->orderBy('cit_id', 'desc')->get();
         $pacientesCita = Paciente::select('pac_id','pac_numero','pac_paterno','pac_materno','pac_nombre')
          ->where('pac_use_id', auth()->user()->id)
             ->orderBy('pac_id', 'desc')
             ->take(100)
             ->get();
         $pacientesArray = $pacientesCita->toArray();
         $pacientesArrayNumeros = array_unique(array_column($pacientesArray, 'pac_numero'));

         if(count($pacientesCita) > 0 ) {
             $siguienteNumero = max($pacientesArrayNumeros) + 1;
         }

        return view("paginas.citas-crear", array('citas' => $citas, 'pacientes' => $pacientesCita, 'siguienteNumero' => $siguienteNumero ));
    }

    public function saveAction (Request $request) {

       $cita = new CitaCrear();

       $modulo_calendario = 0;
       $modulo_calendario =   $request->input('mod_calendario');
       $cita->cit_fecha = $request->fecha;
       $cita->cit_hora =  $request->hora;
       $cita->cit_pac_id = $request->id;

        $validar = $request->validate(
            [
                "id" => "required"
            ]);

        $cita->save();

        if ($modulo_calendario == 1) {
            return redirect("citas")->with("ok-crear-cita", "");
        }else {
            return redirect("citas-crear")->with("ok-crear-cita", "");
        }
    }

    public function create() {

        try {

            $validator = Validator::make(request()->all(), [
                "id" => "required",
                "fecha" => "required",
                "hora" => "required",
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            };

            $cita = Cita::create(request()->all());

            $response = response()->json([
                'status' => 1,
                'message' => 'Cita creada correctamente',
                'cita' => $cita,
            ]);

        }catch (\Exception $e) {

            $response = response()->json([
                'status' => 2,
                'message' => $e->getMessage(),
            ]);

        } finally {

           return $response;
        }
    }

    public function deleteAction($id, Request $request)
    {
        $validar = CitaCrear::where("cit_id", $id)->get();
        $receta = Receta::where('rec_cit_id', $id)->get();
        $examen = ExamenFisico::where('exa_cit_id' ,$id)->get();

        if (!empty($validar)) {

            if(!empty($receta)) {
                $receta = Receta::where('rec_cit_id', $id)->delete();
            }
            if (!empty($examen)) {
                $examen = ExamenFisico::where('exa_cit_id', $id)->delete();
            }
            $cita = CitaCrear::where("cit_id", $id)->delete();

            //Responder al AJAX de JS
            return "ok";

        } else {
            return redirect("citas-crear")->with("no-borrar", "");
        }
    }

    public function updateAction($id, Request $request)
    {

        $cita = new CitaCrear();

        $fecha = $cita->cit_fecha = $request->fecha;
        $hora = $cita->cit_hora = $request->hora;
        $paciente = $cita->cit_pac_id = $request->id;

        $datos = array('cit_fecha' => $fecha, 'cit_hora' => $hora, 'cit_pac_id' => $paciente);


        $update = $cita->where('cit_id', $id)->update($datos);

        return redirect("citas-crear")->with("ok-editar-cita", "");

    }

    public function show($id, Request $request)
    {
        $cita = CitaCrear::where('cit_id', $id)->get();
        $pacientes = Paciente::orderBy('pac_nombre','desc')->get();

        $respuesta = array("status" => 400);
        if (count($cita) > 0) {
            $respuesta = array('status' => 200, "cita" => $cita, 'pacientes' => $pacientes);
        }
        echo  json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }
}
