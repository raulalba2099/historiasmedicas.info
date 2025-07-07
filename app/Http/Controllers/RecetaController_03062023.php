<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\ExamenFisico;
use App\Models\Paciente;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Fpdf\Fpdf;


use Illuminate\Support\Facades\URL;
class RecetaController extends Controller
{
    static public function indexAction($id)
    {
        $consulta = Consulta::rightJoin('citas', 'con_cit_id', 'cit_id')
            ->join('pacientes', 'cit_pac_id', 'pac_id')
            ->where('cit_id', '=', $id)
            ->first();

        $receta = Receta::where('rec_cit_id', $id)->get();

        $cantidadRegistros = 0;
        if (count($receta) > 0) {
            $statusReceta = 200;
            $cantidadRegistros = count($receta);
        } else {
            $statusReceta = 400;
        }

        return view("paginas.receta", array('cantidadRegistros' => $cantidadRegistros, 'statusReceta' => $statusReceta, 'consulta' => $consulta, 'receta' => $receta));

    }

    public function saveAction(Request $request)
    {
        $receta = new Receta();

        $numero_inputs = $request->numero_inputs;
        $idCita = $request->cit_id;

        $paciente = Receta::where("rec_cit_id", $idCita)->delete();

        for ($i = 1; $i <= $numero_inputs; $i++) {

            $datos = array('rec_cit_id' => $request->input('cit_id'),
                'rec_medicamento' => $request->input('medicamento_' . $i . ''),
                'rec_dosis' => $request->input('dosis_' . $i . ''),
                'rec_duracion' => $request->input('duracion_' . $i . ''),
                'created_at' => now(),
                'updated_at' => now()

            );

//            $validar = $request->validate(
//                [
//                    "cit_id" => "required",
//                    "medicamento_".$i."" => "required",
//                    "dosis_".$i."" => "required",
//                    "duracion_".$i."" => "required",
//                ]);

            if ($datos['rec_medicamento'] != '') {
                DB::table('recetas')->insert($datos);
            }
        }

        return redirect("receta/$request->cit_id")->with("ok-crear-receta", "");
    }

    public function deleteAction($id, Request $request)
    {

        $validar = Receta::where("rec_id", $id)->get();

        if (!empty($validar)) {

            $medicamento = Receta::where("rec_id", $id)->delete();
            $respuesta = array('mensaje' => 'medicamento-eliminado', 'datos' => $validar);
//            return redirect("pacientes")->with("no-borrar", "");
            //Responder al AJAX de JS
        } else {

            return redirect("receta")->with("no-borrar", "");

        }
        return $respuesta;

    }

    public function exportarPdf($id) {

        $receta = Receta::where('rec_cit_id', $id)->join('citas', 'rec_cit_id', 'cit_id')
            ->join('pacientes', 'cit_pac_id', 'pac_id')->get();

        $fisico = ExamenFisico::where('exa_cit_id',$id)->orderBy('exa_cit_id', 'desc')->first();

        $medico = utf8_decode(auth()->user()->name);
        $nombrePaciente = $receta[0]->pac_nombre . " " . $receta[0]->pac_materno . " " . $receta[0]->pac_paterno;
        $edadPaciente  = PacienteController::age(' '.$receta[0]->pac_nacimiento.' ' );

        $pdf = new Fpdf($orientation = 'P', $unit = 'mm');
        $pdf->SetTitle('receta_medica');
        $pdf->AddPage();

        $textypos = 5;

        $pdf->AddFont('Poppins-Regular' );
        $pdf->AddFont('breeSerif-regular');

        $pdf->SetTextColor(69,95,124);
        $pdf->SetFont('breeSerif-regular', '', 10);
        $pdf->setY(55);
        $pdf->setX(14);
        $pdf->Cell(5, $textypos, "Paciente: " . utf8_decode($nombrePaciente));

        $pdf->setY(60);
        $pdf->setX(14);
        $pdf->Cell(5, $textypos,  'Edad: ' . $edadPaciente);

        $pdf->SetTextColor(69,95,124);
        $pdf->SetFont('breeSerif-regular', '', 10);
        $pdf->setY(65);
        $pdf->setX(14);
        $pdf->Cell(5, $textypos, "Idx: " . (!empty($fisico->diagnostico) ? utf8_decode($fisico->diagnostico) : ''));

        $pdf->setY(55);
        $pdf->setX(145);
        $pdf->Cell(5, $textypos, "Frecuencia Cardiaca:");

        $pdf->setY(55);
        $pdf->setX(190);
        $pdf->Cell(5, $textypos, $fisico?->frecuencia_cardiaca);

        $pdf->setY(60);
        $pdf->setX(145);
        $pdf->Cell(5, $textypos, "Frecuencia Respiratoria:");

        $pdf->setY(60);
        $pdf->setX(190);
        $pdf->Cell(5, $textypos, $fisico?->frecuencia_respiratoria);

        $pdf->setY(65);
        $pdf->setX(145);
        $pdf->Cell(5, $textypos, utf8_decode('Presión Arterial:'));

        $pdf->setY(65);
        $pdf->setX(187);
        $pdf->Cell(5, $textypos,  $fisico?->presion_arterial );

        $pdf->setY(70);
        $pdf->setX(145);
        $pdf->Cell(5, $textypos, "Temperatura:");

        $pdf->setY(70);
        $pdf->setX(190);
        $pdf->Cell(5, $textypos, $fisico?->temperatura);

        $pdf->setY(75);
        $pdf->setX(145);
        $pdf->Cell(5, $textypos, "Peso:");

        $pdf->setY(75);
        $pdf->setX(190);
        $pdf->Cell(5, $textypos, $fisico?->peso);

        $pdf->setY(80);
        $pdf->setX(145);
        $pdf->Cell(5, $textypos, "Talla:");

        $pdf->setY(80);
        $pdf->setX(190);
        $pdf->Cell(5, $textypos, $fisico?->talla);

        $pdf->setY(85);
        $pdf->setX(145);
        $pdf->Cell(5, $textypos, "IMC:");

        $pdf->setY(85);
        $pdf->setX(190);
        $pdf->Cell(5, $textypos, $fisico?->imc);

        //Apartir de aqui empezamos con la tabla de medicamentos
        $pdf->setY(110);
        $pdf->setX(25);
//        $pdf->Ln();

        $th = array("No.", "Medicamento", "Dosis", utf8_decode('Duración'));

        $products = [];
        $row = 1;
        foreach ($receta as  $medicamento) {
            $products[] = array(
                $row,
                utf8_decode($medicamento?->rec_medicamento),
                utf8_decode($medicamento?->rec_dosis),
                utf8_decode($medicamento?->rec_duracion)
            );
            $row++;
        }

        // Column widths
        $w = array(20, 85, 50, 25);
        // Header

        $pdf->setX(14);
        $pdf->Cell($w[0], 7, $th[0], 0, 0, 'L');
        $pdf->Cell($w[1], 7, $th[1], 0, 0, 'L');
        $pdf->Cell($w[2], 7, $th[2], 0, 0, 'L');
        $pdf->Cell($w[3], 7, $th[3], 0, 0, 'L');
        $pdf->Ln();
        for ($i = 0; $i < count($th); $i++)
//            $pdf->Cell($w[$i], 7, $th[$i], 0, 0, 'L');
//            $pdf->Ln();
            // Data
            $total = 0;
            foreach ($products as $row) {
                $pdf->setX(14);
                $pdf->Cell($w[0], 6, $row[0], '0', 0, 'L');
                $pdf->Cell($w[1], 6, $row[1], 0);
                $pdf->Cell($w[2], 6, $row[2], '0', 0, 'L');
                $pdf->Cell($w[3], 6, $row[3], '0', 0, 'L');
    //            $pdf->Cell($w[4],6,$row[3],'1',0,'R');
                $pdf->Ln();
            }
        $yposdinamic = 130 + (count($products ) * 10) ;

        $pdf->SetFont('breeSerif-regular', '', 10);
        $pdf->setY($yposdinamic);
        $pdf->setX(88);
        $pdf->Cell(5,$textypos,"FIRMA Y SELLO");

        $pdf->SetFont('breeSerif-regular','',10);

        $pdf->setY($yposdinamic+20);
        $pdf->setX(63);
        $pdf->Cell(5,$textypos,"_________________________________________");
        $pdf->setY($yposdinamic+25);

        $pdf->setX(80);
        $pdf->Cell(5,$textypos,utf8_decode('Nombre del Médico/Doctor'));
        $pdf->setY($yposdinamic+55);

        $pdf->output();
        exit;
    }


//    public function exportarPdf($id)
//    {
//        $receta = Receta::where('rec_cit_id', $id)->join('citas', 'rec_cit_id', 'cit_id')
//            ->join('pacientes', 'cit_pac_id', 'pac_id')->get();
//
//        $medico = utf8_decode(auth()->user()->name);
//        $nombrePaciente = $receta[0]->pac_nombre . " " . $receta[0]->pac_materno . " " . $receta[0]->pac_paterno;
//
//        $pdf = new FPDF($orientation = 'P', $unit = 'mm');
//        $pdf->SetTitle('receta_medica');
//        $pdf->AddPage();
//
//        $textypos = 5;
//
//// Agregamos los datos del consultorio medico
//        $pdf->Image('imgs/logo.jpeg', 5, 5,  0, );
////        $pdf->setY(5);
////        $pdf->setX(5);
//
//
//
//        $pdf->SetTextColor(69,95,124);
//
//        $pdf->AddFont('Poppins-Regular' );
//        $pdf->AddFont('breeSerif-regular');
//
//
//
//        $pdf->SetFont('Poppins-Regular');
//        $pdf->setX(40);
//        $pdf->Cell(5, $textypos, utf8_decode(auth()->user()->name));
//
//        $pdf->setY(18);
//        $pdf->setX(40);
//        $pdf->Cell(5, $textypos, "ESPECIALISTA EN MEDICINA FAMILIAR");
//
//        $pdf->SetFont('breeSerif-regular', '', 8  );
//        $pdf->setY(23);
//        $pdf->setX(40);
//        $pdf->Cell(5, $textypos, "UNIVERSIDAD AUTÓNOMA DE SINALOA");
//
//        $pdf->setY(27);
//        $pdf->setX(40);
//        $pdf->Cell(5, $textypos, "CERTIFICADO POR EL CONSEJO MEXICANO DE CERTIFICACIÓN EN MEDICINA FAMILIAR A.C.
//");
//
//        $pdf->SetFont('Arial', '', 10);
//        $pdf->setY(35);
//        $pdf->setX(40);
//        $pdf->Cell(5, $textypos, "Numero de Receta: _____________________________________________");
//        $pdf->setY(40);
//        $pdf->setX(40);
//        $pdf->Cell(5, $textypos,  utf8_decode("Médico/Doctor: ") . $medico);
//        $pdf->setY(45);
//        $pdf->setX(40);
//        $pdf->Cell(5, $textypos, "Paciente: " . utf8_decode($nombrePaciente));
//        $pdf->setY(50);
//        $pdf->setX(40);
//        $pdf->Cell(5, $textypos, "Fecha: " . date('d-M-Y', strtotime(now())));
//
///// Apartir de aqui empezamos con la tabla de medicamentos
//        $pdf->setY(60);
//        $pdf->setX(30);
//        $pdf->Ln();
///////////////////////////////
////// Array de Cabecera
//        $header = array("No.", "Medicamento", "Dosis", "Duracion");
////// Arrar de Productos
//
//        $products = [];
//        foreach ($receta as  $medicamento) {
//            $products[] = array(
//                1,
//                utf8_decode($medicamento->rec_medicamento),
//                utf8_decode($medicamento->rec_dosis),
//                utf8_decode($medicamento->rec_duracion)
//            );
//        }
//
//        // Column widths
//        $w = array(20, 95, 20, 25);
//        // Header
//        for ($i = 0; $i < count($header); $i++)
//            $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
//        $pdf->Ln();
//        // Data
//        $total = 0;
//        foreach ($products as $row) {
//            $pdf->Cell($w[0], 6, $row[0], '1', 0, 'C');
//            $pdf->Cell($w[1], 6, $row[1], 1);
//            $pdf->Cell($w[2], 6, $row[2], '1', 0, 'C');
//            $pdf->Cell($w[3], 6, $row[3], '1', 0, 'C');
////            $pdf->Cell($w[4],6,$row[3],'1',0,'R');
//
//            $pdf->Ln();
//
//        }
//        $yposdinamic = 60 + (count($products) * 10);
//
//        $pdf->SetFont('Arial', 'B', 10);
//
//        $pdf->setY($yposdinamic);
//        $pdf->setX(75);
////        $pdf->Cell(15, $textypos, "FIRMA Y SELLO");
//        $pdf->SetFont('Arial', '', 10);
//
//        $pdf->setY($yposdinamic + 20);
//        $pdf->setX(50);
//        $pdf->Cell(5, $textypos, "_________________________________________");
//        $pdf->setY($yposdinamic + 25);
//        $pdf->setX(70);
//        $pdf->Cell(5, $textypos, utf8_decode("Nombre del Médico/Doctor"));
////        $pdf->Cell(5, $textypos, utf8_decode("Nombre del Médico/Doctor"));
//        $pdf->setY($yposdinamic + 55);
//        $pdf->setX(80);
//
//        $pdf->output();
//        exit;
//    }
}
