<?php

namespace App\Http\Controllers;

use Elibyy\TCPDF\TCPDF;
use Fpdf\Fpdf;
use Illuminate\Http\Request;

class MenbreteController extends Controller
{
    public function indexAction()
    {
        $datos = [];
        return view(
            "paginas.membrete",
            $datos
        );
    }

    public function membredteAction(Request $request)
    {
        $pdf = new TCPDF('L', 'mm', 'A4');

        $path = getcwd();
        $logo =  "public/imgs/logo.jpeg";

//        dd($logo);

//        dd($logo);

        // set default header data
//        $pdf->SetHeaderData($logo,552, "", "");


        $pdf->SetHeaderData('public/imgs/logo.jpeg',
            100,
            'string to print as title on document header',
            'string to print on document header'
        );

        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetMargins(PDF_MARGIN_LEFT, 30, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//        $pdf->setPrintHeader(false);
//        $pdf->setPrintFooter(false);

        $pdf->AddPage();

        $pdf->writeHTML($request->textoMembrete, true, false, true, false, '');

        $pdf->Output('membrete.pdf', 'I');
    }

    public function membreteAction(Request $request)
    {
        $fecha = date("d-m-Y", strtotime($request->fecha));
        $texto = $request->textoMembrete;

        $medico = utf8_decode(auth()->user()->name);

        $pdf = new Fpdf($orientation = 'P', $unit = 'mm');
        $pdf->SetTitle('Hoja membretada');
        $pdf->AddPage();

        $textypos = 5;

        $pdf->AddFont('Poppins-Regular');
        $pdf->AddFont('breeSerif-regular');

        $pdf->SetTextColor(69, 95, 124);
        $pdf->SetFont('breeSerif-regular', '', 15);

        if ($request->certificado) {
            $pdf->setY(55);
            $pdf->setX(80);
            $pdf->Cell(5, $textypos, utf8_decode('CERTIFICADO MÉDICO'));

        }
        $pdf->SetFont('breeSerif-regular', '', 10);
        $pdf->setY(65);
        $pdf->setX(162);
        $pdf->Cell(5, $textypos, "Fecha:");

        $pdf->setY(65);
        $pdf->setX(177);
        $pdf->Cell(5, $textypos, $fecha);

        $pdf->setY(85);
        $pdf->setX(15);
//        $texto = $pdf->WriteHTML($texto);
        $pdf->MultiCell(180, 5, $texto, 0, 'J');

        $yposdinamic = 200;

        $pdf->SetTextColor(69, 95, 124);
        $pdf->SetFont('breeSerif-regular', '', 10);
        $pdf->setY($yposdinamic);
        $pdf->setX(88);
        $pdf->Cell(5, $textypos, "FIRMA Y SELLO");

        $pdf->SetFont('breeSerif-regular', '', 10);

        $pdf->setY($yposdinamic + 20);
        $pdf->setX(63);
        $pdf->Cell(5, $textypos, "_________________________________________");
        $pdf->setY($yposdinamic + 25);

        $pdf->Image('imgs/sello_firma.png', 75, $yposdinamic + 1, 55, 25);

        $pdf->setX(95);
        $pdf->Cell(5, $textypos, utf8_decode('Médico'));
        $pdf->setY($yposdinamic + 55);

        $pdf->output();
        exit;
    }
}
