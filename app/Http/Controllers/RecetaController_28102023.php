<?php

namespace App\Http\Controllers;

use App\Mail\RecetaMail;
use App\Models\Consulta;
use App\Models\ExamenFisico;
use App\Models\Paciente;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Fpdf\Fpdf;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\URL;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require base_path("vendor/autoload.php");
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

        return view(
            "paginas.receta",
            array(
                'cantidadRegistros' => $cantidadRegistros,
                'statusReceta' => $statusReceta,
                'consulta' => $consulta,
                'receta' => $receta
            )
        );
    }

    public function saveAction(Request $request)
    {
        $receta = new Receta();

        $numero_inputs = $request->numero_inputs;
        $idCita = $request->cit_id;

        $paciente = Receta::where("rec_cit_id", $idCita)->delete();

        for ($i = 1; $i <= $numero_inputs; $i++) {
            $datos = array(
                'rec_cit_id' => $request->input('cit_id'),
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

        return redirect("consulta/$request->cit_id")->with("ok-crear-receta", "");
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

    public function sendPdf(Request $request)  {

        $id = $request->cit_id;

        $receta = Receta::where('rec_cit_id', $id)->join('citas', 'rec_cit_id', 'cit_id')
            ->join('pacientes', 'cit_pac_id', 'pac_id')->get();

        $fisico = ExamenFisico::where('exa_cit_id', $id)->orderBy('exa_cit_id', 'desc')->first();

        $medico = utf8_decode(auth()->user()->name);
        $nombrePaciente = $receta[0]->pac_nombre . " " . $receta[0]->pac_paterno . " " . $receta[0]->pac_materno;
        $edadPaciente = utf8_decode($receta[0]->pac_nacimiento);

        $pdf = new Fpdf($orientation = 'P', $unit = 'mm');
        $pdf->SetTitle('receta_medica');
        $pdf->AddPage();

        $textypos = 5;

        $pdf->AddFont('Poppins-Regular');
        $pdf->AddFont('breeSerif-regular');

        $pdf->SetTextColor(69, 95, 124);
        $pdf->SetFont('breeSerif-regular', '', 10);
        $pdf->setY(55);
        $pdf->setX(14);
        $pdf->Cell(5, $textypos, "Paciente: " . utf8_decode($nombrePaciente));

        $pdf->setY(60);
        $pdf->setX(14);
        $pdf->Cell(5, $textypos, 'Edad: ' . $edadPaciente);

        $pdf->SetTextColor(69, 95, 124);
        $pdf->SetFont('breeSerif-regular', '', 10);
        $pdf->setY(65);
        $pdf->setX(14);
        $pdf->Cell(5, $textypos, "Idx: " . (!empty($fisico->diagnostico) ? utf8_decode($fisico->diagnostico) : ''));

        $pdf->setY(55);
        $pdf->setX(160);
        $pdf->Cell(5, $textypos, "Fecha:");

        $pdf->setY(55);
        $pdf->setX(177);
        $pdf->Cell(5, $textypos, date('d-m-Y'));

//        $pdf->setY(55);
//        $pdf->setX(130);
//        $pdf->Cell(5, $textypos, "Frecuencia Cardiaca:");

//        $pdf->setY(55);
//        $pdf->setX(190);
//        $pdf->Cell(5, $textypos, $fisico?->frecuencia_cardiaca);
//
//        $pdf->setY(60);
//        $pdf->setX(130);
//        $pdf->Cell(5, $textypos, "Frecuencia Respiratoria:");
//
//        $pdf->setY(60);
//        $pdf->setX(190);
//        $pdf->Cell(5, $textypos, $fisico?->frecuencia_respiratoria);
//
//        $pdf->setY(65);
//        $pdf->setX(130);
//        $pdf->Cell(5, $textypos, utf8_decode('Presión Arterial Sistólica:'));
//
//        $pdf->setY(65);
//        $pdf->setX(189);
//        $pdf->Cell(5, $textypos, $fisico?->presion_arterial_sistolica);
//
//        $pdf->setY(70);
//        $pdf->setX(130);
//        $pdf->Cell(5, $textypos, utf8_decode('Presión Arterial Diastólica :'));
//
//        $pdf->setY(70);
//        $pdf->setX(190);
//        $pdf->Cell(5, $textypos, $fisico?->presion_arterial_diastolica);
//
//        $pdf->setY(75);
//        $pdf->setX(130);
//        $pdf->Cell(5, $textypos, utf8_decode('Presión Arterial Media :'));
//
//        $pdf->setY(75);
//        $pdf->setX(188);
//        $pdf->Cell(5, $textypos, number_format($fisico?->presion_arterial, 1));
//
//        $pdf->setY(80);
//        $pdf->setX(130);
//        $pdf->Cell(5, $textypos, "Temperatura:");
//
//        $pdf->setY(80);
//        $pdf->setX(190);
//        $pdf->Cell(5, $textypos, $fisico?->temperatura);
//
//        $pdf->setY(85);
//        $pdf->setX(130);
//        $pdf->Cell(5, $textypos, "Peso:");
//
//        $pdf->setY(85);
//        $pdf->setX(187);
//        $pdf->Cell(5, $textypos, $fisico?->peso);
//
//        $pdf->setY(90);
//        $pdf->setX(130);
//        $pdf->Cell(5, $textypos, "Talla:");
//
//        $pdf->setY(90);
//        $pdf->setX(188);
//        $pdf->Cell(5, $textypos, $fisico?->talla);
//
//        $pdf->setY(95);
//        $pdf->setX(130);
//        $pdf->Cell(5, $textypos, "IMC:");
//
//        $pdf->setY(95);
//        $pdf->setX(188);
//        $pdf->Cell(5, $textypos, number_format($fisico?->imc, 1));

        //Apartir de aqui empezamos con la tabla de medicamentos
        $pdf->setY(115);
        $pdf->setX(25);
//        $pdf->Ln();

        $th = array("No.", "Medicamento", "Dosis", utf8_decode('Duración'));

        $products = [];
        $row = 1;
        foreach ($receta as $medicamento) {
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
        $yposdinamic = 130 + (count($products) * 10);

        $pdf->SetFont('breeSerif-regular', '', 10);
        $pdf->setY($yposdinamic);
        $pdf->setX(88);
        $pdf->Cell(5, $textypos, "FIRMA Y SELLO");

        $pdf->SetFont('breeSerif-regular', '', 10);

        $pdf->setY($yposdinamic + 20);
        $pdf->setX(63);
        $pdf->Cell(5, $textypos, "_________________________________________");
        $pdf->setY($yposdinamic + 25);

        $pdf->Image('imgs/sello_firma.png', 75, $yposdinamic + 1 , 55, 25);

        $pdf->setX(95);
        $pdf->Cell(5,$textypos,utf8_decode('Médico'));
        $pdf->setY($yposdinamic+55);
        $pdfdoc = $pdf->Output("", "S");

        $mail = new PHPMailer;
        $mail->From = 'consulta@historiasmedicas.info';
        $mail->FromName = $medico;
        $mail->Subject =  utf8_decode('Receta Médica: ' . utf8_decode($nombrePaciente));
        $mail->addAddress($request->email);
        $mail->isHTML(true);

        $html = "
        <div>
            <span style='font-weight= bold'>".$nombrePaciente."  </span>
            <p> ".utf8_decode('Se adjunta Receta Médica.')." </p>
            <p>Saludos Cordiales...</p>
        </div>";


        $mail->Body = $html;
        $mail->AddAddress($request->email, $nombrePaciente);
        $mail->addStringAttachment($pdfdoc, 'receta.pdf');
        if(!$mail->send())
        {
//            return redirect("consulta/$id")->with("Mailer Error: ", $mail->ErrorInfo);
            return redirect("consulta/$id")->with("mensaje-error", "");
        }
        else
        {
            return redirect("consulta/$id")->with("mensaje-enviado", "");

        }


        exit();
    }

    public function exportarPdf($id)
    {

        $receta = Receta::where('rec_cit_id', $id)->join('citas', 'rec_cit_id', 'cit_id')
            ->join('pacientes', 'cit_pac_id', 'pac_id')->get();

        $fisico = ExamenFisico::where('exa_cit_id', $id)->orderBy('exa_cit_id', 'desc')->first();

        $medico = utf8_decode(auth()->user()->name);
        $nombrePaciente = $receta[0]->pac_nombre . " " . $receta[0]->pac_paterno . " " . $receta[0]->pac_materno;
        $edadPaciente = utf8_decode($receta[0]->pac_nacimiento);

        $pdf = new Fpdf($orientation = 'P', $unit = 'mm');
        $pdf->SetTitle('receta_medica');
        $pdf->AddPage();

        $textypos = 5;

        $pdf->AddFont('Poppins-Regular');
        $pdf->AddFont('breeSerif-regular');

        $pdf->SetTextColor(69, 95, 124);
        $pdf->SetFont('breeSerif-regular', '', 10);
        $pdf->setY(55);
        $pdf->setX(14);
        $pdf->Cell(5, $textypos, "Paciente: " . utf8_decode($nombrePaciente));

        $pdf->setY(60);
        $pdf->setX(14);
        $pdf->Cell(5, $textypos, 'Edad: ' . $edadPaciente);

        $pdf->SetTextColor(69, 95, 124);
        $pdf->SetFont('breeSerif-regular', '', 10);
        $pdf->setY(65);
        $pdf->setX(14);
        $pdf->Cell(5, $textypos, "Idx: " . (!empty($fisico->diagnostico) ? utf8_decode($fisico->diagnostico) : ''));

        $pdf->setY(55);
        $pdf->setX(160);
        $pdf->Cell(5, $textypos, "Fecha:");

        $pdf->setY(55);
        $pdf->setX(177);
        $pdf->Cell(5, $textypos, date('d-m-Y'));

//        $pdf->setY(55);
//        $pdf->setX(130);
//        $pdf->Cell(5, $textypos, "Frecuencia Cardiaca:");

//        $pdf->setY(55);
//        $pdf->setX(190);
//        $pdf->Cell(5, $textypos, $fisico?->frecuencia_cardiaca);
//
//        $pdf->setY(60);
//        $pdf->setX(130);
//        $pdf->Cell(5, $textypos, "Frecuencia Respiratoria:");
//
//        $pdf->setY(60);
//        $pdf->setX(190);
//        $pdf->Cell(5, $textypos, $fisico?->frecuencia_respiratoria);
//
//        $pdf->setY(65);
//        $pdf->setX(130);
//        $pdf->Cell(5, $textypos, utf8_decode('Presión Arterial Sistólica:'));
//
//        $pdf->setY(65);
//        $pdf->setX(189);
//        $pdf->Cell(5, $textypos, $fisico?->presion_arterial_sistolica);
//
//        $pdf->setY(70);
//        $pdf->setX(130);
//        $pdf->Cell(5, $textypos, utf8_decode('Presión Arterial Diastólica :'));
//
//        $pdf->setY(70);
//        $pdf->setX(190);
//        $pdf->Cell(5, $textypos, $fisico?->presion_arterial_diastolica);
//
//        $pdf->setY(75);
//        $pdf->setX(130);
//        $pdf->Cell(5, $textypos, utf8_decode('Presión Arterial Media :'));
//
//        $pdf->setY(75);
//        $pdf->setX(188);
//        $pdf->Cell(5, $textypos, number_format($fisico?->presion_arterial, 1));
//
//        $pdf->setY(80);
//        $pdf->setX(130);
//        $pdf->Cell(5, $textypos, "Temperatura:");
//
//        $pdf->setY(80);
//        $pdf->setX(190);
//        $pdf->Cell(5, $textypos, $fisico?->temperatura);
//
//        $pdf->setY(85);
//        $pdf->setX(130);
//        $pdf->Cell(5, $textypos, "Peso:");
//
//        $pdf->setY(85);
//        $pdf->setX(187);
//        $pdf->Cell(5, $textypos, $fisico?->peso);
//
//        $pdf->setY(90);
//        $pdf->setX(130);
//        $pdf->Cell(5, $textypos, "Talla:");
//
//        $pdf->setY(90);
//        $pdf->setX(188);
//        $pdf->Cell(5, $textypos, $fisico?->talla);
//
//        $pdf->setY(95);
//        $pdf->setX(130);
//        $pdf->Cell(5, $textypos, "IMC:");
//
//        $pdf->setY(95);
//        $pdf->setX(188);
//        $pdf->Cell(5, $textypos, number_format($fisico?->imc, 1));

        //Apartir de aqui empezamos con la tabla de medicamentos
        $pdf->setY(115);
        $pdf->setX(25);
//        $pdf->Ln();

        $th = array("No.", "Medicamento", "Dosis", utf8_decode('Duración'));

        $products = [];
        $row = 1;
        foreach ($receta as $medicamento) {
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
        $yposdinamic = 130 + (count($products) * 10);

        $pdf->SetFont('breeSerif-regular', '', 10);
        $pdf->setY($yposdinamic);
        $pdf->setX(88);
        $pdf->Cell(5, $textypos, "FIRMA Y SELLO");

        $pdf->SetFont('breeSerif-regular', '', 10);

        $pdf->setY($yposdinamic + 20);
        $pdf->setX(63);
        $pdf->Cell(5, $textypos, "_________________________________________");
        $pdf->setY($yposdinamic + 25);

        $pdf->Image('imgs/sello_firma.png', 75, $yposdinamic + 1 , 55, 25);

        $pdf->setX(95);
        $pdf->Cell(5,$textypos,utf8_decode('Médico'));
        $pdf->setY($yposdinamic+55);
        $pdf->Output();
    }
}
