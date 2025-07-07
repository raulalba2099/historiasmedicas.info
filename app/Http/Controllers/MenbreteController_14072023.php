<?php

namespace App\Http\Controllers;

use Fpdf\Fpdf;
use Illuminate\Http\Request;

class MenbreteController extends Controller
{
    public function membreteAction () {

        $medico = utf8_decode(auth()->user()->name);

        $pdf = new Fpdf($orientation = 'P', $unit = 'mm');
        $pdf->SetTitle('Hoja membretada');
        $pdf->AddPage();

        $textypos = 5;

        $pdf->AddFont('Poppins-Regular' );
        $pdf->AddFont('breeSerif-regular');

        $yposdinamic = 200;

        $pdf->SetTextColor(69,95,124);
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
}
