<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Consulta;
use App\Models\ExamenFisico;
use App\Models\Menu;
use App\Models\Nota;
use App\Models\Receta;
use App\Models\RecomendacionesMenu;
use Fpdf\Fpdf;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use Elibyy\TCPDF\TCPDF;


//require_once('tcpdf_include.php');
class MenuController extends Controller
{

    static public function indexAction($id)
    {
        $consulta = Consulta::rightJoin('citas', 'con_cit_id', 'cit_id')
            ->join('pacientes', 'cit_pac_id', 'pac_id')
            ->where('cit_id', '=', $id)
            ->first();
        $notas = Nota::where('not_pac_id', $consulta->cit_pac_id)->orderBy('not_id', 'desc')->get();
        $fisico = ExamenFisico::where('exa_cit_id', $id)->first();

        $citas = Cita::where('cit_pac_id', $consulta->cit_pac_id)->get()->toArray();

        $especialidad = EspecialidadController::especilidadUser();

        $recomendaciones = RecomendacionesMenu::where('rec_pac_id', $consulta->pac_id)->where(
            'rec_fecha',
            $consulta->cit_fecha
        )->get()->toArray();


        $menus = [];
        $menusArray = [];
        if ($especialidad->esp_id == 2) {
            $menus = Menu::where('men_pac_id', $consulta->pac_id)->where('men_fecha', $consulta->cit_fecha)->get(
            )->toArray();
            foreach ($menus as $menu) {
                switch ($menu['men_comida']) {
                    case 1:
                        $comida = 'Ayunas';
                        break;
                    case 2:
                        $comida = 'Desayuno';
                        break;
                    case 3:
                        $comida = 'Colación';
                        break;
                    case 4:
                        $comida = 'Comida';
                        break;
                    case 5:
                        $comida = 'Cena';
                        break;
                }
                $menusArray[$menu['men_comida']]['com_id'] = $menu['men_comida'];
                $menusArray[$menu['men_comida']]['comida'] = $comida;
                $menusArray[$menu['men_comida']][$menu['men_dia']]['men_id'] = $menu['men_id'];
                $menusArray[$menu['men_comida']][$menu['men_dia']]['descripcion'] = (string)$menu['men_descripcion'];
            }
            ksort($menusArray);
        }


        $medicamentosArray = [];
        foreach ($citas as $cita) {
            $medicamentos = Receta::where('rec_cit_id', $cita['cit_id'])->get()->toArray();

            foreach ($medicamentos as $medicamento) {
                $medicamentosArray[$cita['cit_id']]['medicamento'] = $medicamento['rec_medicamento'];
                $medicamentosArray[$cita['cit_id']]['dosis'] = $medicamento['rec_dosis'];
                $medicamentosArray[$cita['cit_id']]['duracion'] = $medicamento['rec_duracion'];
                $medicamentosArray[$cita['cit_id']]['fecha'] = $cita['cit_fecha'];
            }
        }

        $receta = Receta::where('rec_cit_id', $id)->get();

        $cantidadRegistros = 0;
        if (count($receta) > 0) {
            $statusReceta = 200;
            $cantidadRegistros = count($receta);
        } else {
            $statusReceta = 400;
        }

        return view(
            "paginas.menu",
            array(
                'consulta' => $consulta,
                'notas' => $notas,
                'fisico' => $fisico,
                'medicamentos' => $medicamentosArray,
                'statusReceta' => $statusReceta,
                'receta' => $receta,
                'cantidadRegistros' => $cantidadRegistros,
                'especialidad' => $especialidad,
                'menus' => $menus,
                'menusArray' => $menusArray,
                'recomendaciones' => $recomendaciones
            )
        );
    }

    public function saveAction(Request $request)
    {
        $citId = $request->cit_id;
        $menuExiste = Menu::where('men_pac_id', $request->pac_id)->where('men_fecha', $request->fecha)
            ->where('men_comida', $request->com_id)
            ->where('men_dia', $request->dia)
            ->where('men_id', '<>', $request->men_id)->get();

        $menus = Menu::where('men_pac_id', $request->pac_id)->where('men_fecha', $request->fecha)->where(
            'men_comida',
            $request->men_comida
        )->get();
        $totalMenus = count($menus);

        if (count($menuExiste) > 0) {
            return json_encode('menu-existe');
        }

        $dia = $request->dia;
        if ($request->com_id == 1 || $request->com_id == 3) {
            $dia = 1;
        }

        if (empty($dia)) {
            return json_encode('dia-requerido');
        }

        if (empty($request->com_id)) {
            return json_encode('comida-reuerido');
        }

        if (!empty($request->men_id)) {
            $datos = array(
                'men_id' => $request->men_id,
                'men_dia' => $dia,
                'men_comida' => $request->com_id,
                'men_hora' => $request->hora,
                'men_fecha' => $request->fecha,
                'men_pac_id' => $request->pac_id,
                'men_descripcion' => $request->descripcion,
            );

//            dd($datos);
//            $validar = $request->validate(
//                [
//                    "men_dia" => "required",
//                    "men_comida" => 'required'
//                ]);

            $menu = Menu::where('men_id', $request->men_id)->update($datos);
            $respuesta = array(
                'men_comida' => $datos['men_comida'],
                'men_dia' => $datos['men_dia'],
                'men_descripcion' => $datos['men_descripcion'],
                'mensaje' => 'ok',
                'accion' => 'editar',
                'totalmenus' => 0,
                'cit_id' => $citId
            );
        } else {
            $menu = new Menu();
            $menu->men_dia = $dia;
            $menu->men_comida = $request?->com_id;
            $menu->men_hora = $request?->hora;
            $menu->men_fecha = $request->fecha;
            $menu->men_pac_id = $request->pac_id;
            $menu->men_descripcion = $request->descripcion;

//             $validar = $request->validate(
//                [
//                    "men_dia" => "required",
//                    "men_comida" => 'required'
//                ]);

            $menu->save();
            $men_id = $menu->id;

            $respuesta = array(
                'men_dia' => $menu->men_dia,
                'men_comida' => $menu->men_comida,
                'men_descripcion' => $menu->men_descripcion,
                'mensaje' => 'ok',
                'accion' => 'insertar',
                'totalMenus' => $totalMenus,
                'cit_id' => $citId
            );
        }
        return json_encode($respuesta);
//        return redirect("consulta/$request->cit_id")->with("ok-crear-menu", "");
    }

    public function exportarPdf($id)
    {
        $consulta = Consulta::rightJoin('citas', 'con_cit_id', 'cit_id')
            ->join('pacientes', 'cit_pac_id', 'pac_id')
            ->where('cit_id', '=', $id)
            ->first();
        $notas = Nota::where('not_pac_id', $consulta->cit_pac_id)->orderBy('not_id', 'desc')->get();
        $fisico = ExamenFisico::where('exa_cit_id', $id)->first();

        $citas = Cita::where('cit_pac_id', $consulta->cit_pac_id)->get()->toArray();

        $especialidad = EspecialidadController::especilidadUser();
        $recomendaciones = RecomendacionesMenu::where('rec_pac_id', $consulta->pac_id)->where(
            'rec_fecha',
            $consulta->cit_fecha
        )->get()->toArray();
        
        $menus = [];
        $menusArray = [];
        if ($especialidad->esp_id == 2) {
            $menus = Menu::where('men_pac_id', $consulta->pac_id)->where('men_fecha', $consulta->cit_fecha)->get(
            )->toArray();
            foreach ($menus as $menu) {
                switch ($menu['men_comida']) {
                    case 1:
                        $comida = 'Ayunas';
                        break;
                    case 2:
                        $comida = 'Desayuno';
                        break;
                    case 3:
                        $comida = 'Colación';
                        break;
                    case 4:
                        $comida = 'Comida';
                        break;
                    case 5:
                        $comida = 'Cena';
                        break;
                }
                $menusArray[$menu['men_comida']]['comida'] = $comida;
                $menusArray[$menu['men_comida']]['descripcion'][] = $menu['men_descripcion'];
            }
            ksort($menusArray);
        }

        $pdf = new TCPDF('l',  true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage();

        $tdEncabezado = 'background-color: #004369; color: #ffffff; text-align:center; font-family: Arial; font-size: 8pts';
        $tdContenido = 'text-align:center; font-family: Arial; font-size: 8pts; vertical-align:middle;';
        $tdContenidoComidas = 'text-align:justify; font-family: Arial; font-size: 8pts; ';

        $html = '
           <table style="text-align: center; cellspacing="0"; border="1"; border-color: green; ">
                    <tr style=" ">
                        <td style="' . $tdEncabezado . '" ></td>';
        for ($i = 1; $i <= 7; $i++) {
            $html = $html . '
                                <td style="' . $tdEncabezado . '">Día ' . $i . '</td>
                            ';
        }
        $html = $html . '</tr>';
        $fila = 1;
        foreach ($menusArray as $menu) {
            if ($fila % 2 == 0) {
                $colorFondo = 'background-color:#ffffff';
            } else {
                $colorFondo = 'background-color:#f2f2f2';
            }
            $saltos = '';
            if ($menu['comida'] == 'Comida') {
                $saltos = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                ";
            }
            $html = $html .
                '<tr>
                                <td style="' . $tdContenido . $colorFondo . '"> ' . $menu["comida"] . '</td>';
            foreach ($menu['descripcion'] as $descripcion) {
                $break = '';
                if ($menu['comida'] == 'Ayunas' || $menu['comida'] == 'Colación') {

                    if($menu['comida'] == 'cena') {

                            $break = 'page-break-before:always';
                    }

                    $html = $html . '

                                    <td style="' . $tdContenidoComidas . $colorFondo . '  " colspan="7">
                                            <div style="'.$break.' font-size=6pts;">  ' . $descripcion . '</div>
                                    </td>';

                } else {

                    $html = $html . '
                                     <td style="' . $tdContenidoComidas . $colorFondo . '" >
                                            <div style="font-size= 6pts; margin-top: 0px;">  ' . $descripcion . '</div>
                                    </td>';

                }

            }
            $html = $html . '</tr>   ';

            $fila++;
        }

        $descripcion = '';
        if($recomendaciones) {
            $descripcion =  $recomendaciones[0]['rec_descripcion'] = '';
        }

        $html = $html . '
           </table>';
        $html = $html . ' <table style="text-align: center; cellspacing="0"; border="1"; border-color: green; ">
                    <tr><td style = "' . $tdEncabezado . '"  >Recomendaciones</td></tr>
                    <tr style="margin-top: 100px;">
                    <td style = "' . $tdContenidoComidas . '"> ' . $descripcion . '  </td>
                    </tr>
                    </table>';

        $pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
        $pdf->Output('menu.pdf', 'I');
    }

    public function sendPdf(Request $request)
    {

        $id = $request->cit_id;

        $consulta = Consulta::rightJoin('citas', 'con_cit_id', 'cit_id')
            ->join('pacientes', 'cit_pac_id', 'pac_id')
            ->where('cit_id', '=', $id)
            ->first();

        $medico = utf8_decode(auth()->user()->name);
        $nombrePaciente = $consulta->pac_nombre . " " . $consulta->pac_paterno . " " . $consulta->pac_materno;

        $notas = Nota::where('not_pac_id', $consulta->cit_pac_id)->orderBy('not_id', 'desc')->get();
        $fisico = ExamenFisico::where('exa_cit_id', $id)->first();

        $citas = Cita::where('cit_pac_id', $consulta->cit_pac_id)->get()->toArray();

        $especialidad = EspecialidadController::especilidadUser();

        $recomendaciones = RecomendacionesMenu::where('rec_pac_id', $consulta->pac_id)->where(
            'rec_fecha',
            $consulta->cit_fecha
        )->get()->toArray();

        $menus = [];
        $menusArray = [];
        if ($especialidad->esp_id == 2) {
            $menus = Menu::where('men_pac_id', $consulta->pac_id)->where('men_fecha', $consulta->cit_fecha)->get(
            )->toArray();
            foreach ($menus as $menu) {
                switch ($menu['men_comida']) {
                    case 1:
                        $comida = 'Ayunas';
                        break;
                    case 2:
                        $comida = 'Desayuno';
                        break;
                    case 3:
                        $comida = 'Colación';
                        break;
                    case 4:
                        $comida = 'Comida';
                        break;
                    case 5:
                        $comida = 'Cena';
                        break;
                }
                $menusArray[$menu['men_comida']]['comida'] = $comida;
                $menusArray[$menu['men_comida']]['descripcion'][] = $menu['men_descripcion'];
            }
            ksort($menusArray);
        }

//       dd($menusArray);

//        $pdf = new TCPDF('L', 'mm', 'A4');

        $pdf = new TCPDF('l',  true, 'UTF-8', false);

        // set default header data
//        $pdf->SetHeaderData(
//            PDF_HEADER_LOGO,
//            PDF_HEADER_LOGO_WIDTH,
//            PDF_HEADER_TITLE . ' 001',
//            PDF_HEADER_STRING,
//            array(0, 64, 255),
//            array(0, 64, 128)
//        );

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage();

//       $pdf->SetMargins(PDF_MARGIN_LEFT, 30, PDF_MARGIN_RIGHT);
//
//
//
//       $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);


//       $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

        $tdEncabezado = 'background-color: #004369; color: #ffffff; text-align:center; font-family: Arial; font-size: 8pts';
        $tdContenido = 'text-align:center; font-family: Arial; font-size: 8pts; vertical-align:middle;';
        $tdContenidoComidas = 'text-align:justify; font-family: Arial; font-size: 8pts; ';

        $html = '
           <table style="text-align: center; cellspacing="0"; border="1"; border-color: green; ">
                    <tr style=" ">
                        <td style="' . $tdEncabezado . '" ></td>';
        for ($i = 1; $i <= 7; $i++) {
            $html = $html . '
                                <td style="' . $tdEncabezado . '">Día ' . $i . '</td>
                            ';
        }
        $html = $html . '</tr>';

        $fila = 1;
        foreach ($menusArray as $menu) {
            if ($fila % 2 == 0) {
                $colorFondo = 'background-color:#ffffff';
            } else {
                $colorFondo = 'background-color:#f2f2f2';
            }
//                        dd($tdContenidoComidas);
            $saltos = '';
            if ($menu['comida'] == 'Comida') {
                $saltos = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                ";
            }
            $html = $html .
                '<tr> <td style="' . $tdContenido . $colorFondo . '"> ' . $menu["comida"] . '</td>';
            foreach ($menu['descripcion'] as $descripcion) {
                $break = '';
                if ($menu['comida'] == 'Ayunas' || $menu['comida'] == 'Colación') {

                    if($menu['comida'] == 'cena') {

                        $break = 'page-break-before:always';
                    }

                    $html = $html . '<td style="' . $tdContenidoComidas . $colorFondo . '  " colspan="7">
                                            <div style="'.$break.' font-size=6pts;">  ' . $descripcion . '</div>
                                    </td>';

                } else {

                    $html = $html . '
                                     <td style="' . $tdContenidoComidas . $colorFondo . '" >
                                            <div style="font-size= 6pts; margin-top: 0px;">  ' . $descripcion . '</div>
                                    </td>';

                }

            }
            $html = $html . '</tr>   ';

            $fila++;
        }
        $html = $html . '
           </table>';

        $descripcion = '';
        if($recomendaciones) {
            $descripcion =  $recomendaciones[0]['rec_descripcion'] = '';
        }
        $html = $html . ' <table style="text-align: center; cellspacing="0"; border="1"; border-color: green; ">
                    <tr><td style = "' . $tdEncabezado . '"  >Recomendaciones</td></tr>
                    <tr style="margin-top: 100px;">
                    <td style = "' . $tdContenidoComidas . '"> ' . $descripcion . '  </td>
                    </tr>
                    </table>';


// Print text using writeHTMLCell()
//       $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
//        $pdfdoc = $pdf->Output('menu.pdf', 'I');
        $pdfdoc = $pdf->Output("", "S");

        $mail = new PHPMailer;
        $mail->From = 'consulta@historiasmedicas.info';
        $mail->FromName = $medico;
        $mail->Subject =  utf8_decode('Menu: ' . $nombrePaciente);
        $mail->addAddress($request->email);
        $mail->isHTML(true);

        $html = "
        <div>
            <span style='font-weight= bold'>".utf8_decode($nombrePaciente)."  </span>
            <p> ".utf8_decode('Se adjunta Ménu.')." </p>
            <p>Saludos Cordiales...</p>
        </div>";


        $mail->Body = $html;
        $mail->AddAddress($request->email, $nombrePaciente);
        $mail->addStringAttachment($pdfdoc, 'menu_'.utf8_decode($nombrePaciente).'.pdf');
        if(!$mail->send())
        {
//            return redirect("consulta/$id")->with("Mailer Error: ", $mail->ErrorInfo);
            return redirect("consulta/$id")->with("mensaje-error", "");
        }
        else
        {
            return redirect("consulta/$id")->with("mensaje-enviado", "");

        }
    }
}
