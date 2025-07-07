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

        $medico = utf8_decode(auth()->user()->name);
        $nombrePaciente = $consulta->pac_nombre . " " . $consulta->pac_paterno . " " . $consulta->pac_materno;

        $especialidad = EspecialidadController::especilidadUser();

        $recomendaciones = RecomendacionesMenu::where('rec_pac_id', $consulta->pac_id)->where(
            'rec_fecha',
            $consulta->cit_fecha
        )->get()->toArray();


        $menus = [];
        $menusArray = [];
        $comidasArray = [];

        if ($especialidad->esp_id == 2) {
            $menus = Menu::where('men_pac_id', $consulta->pac_id)->where('men_fecha', $consulta->cit_fecha)->get(
            )->toArray();
            $comidasArray = [];
            $dia = 1;
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

                $pdf = new TCPDF('l', true, 'UTF-8', false);
                $pdf->setPageOrientation('L');

                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);

                $pdf->AddPage();

                $comidasArray[$menu['men_comida']] = $comida;
                $menusArray[$menu['men_comida']][$menu['men_dia']] = $menu['men_descripcion'];

                $dia++;
            }
            ksort($menusArray);
            ksort($comidasArray);
        }

        $tdEncabezadoPrimero = 'background-color: #004369; color: #ffffff; text-align:center; font-family: Arial; font-size: 8pts; border-color:#FFFF';
        $tdEncabezado = 'background-color: #004369; color: #ffffff; text-align:center; font-family: Arial; font-size: 8pts; border-color:#FFFF';
        $tdContenido = 'font-family: Arial; font-size: 8pts; vertical-align:middle;';
        $tdContenidoComidas = 'text-align:justify; font-family: Arial; font-size: 10pts; ';

        $html = '<table style="cellspacing="0"; border="1"; border-color: green; ">';
        $html = $html . '<tr>';
        $html = $html . '<td style=" ' . $tdEncabezadoPrimero .' "></td>';
        for ($dia = 1; $dia <= 7; $dia++) {
            $html = $html . '<td style="' . $tdEncabezado . ' "> Día  ' . $dia . ' </td>';
        }
        $html = $html . '</tr>';
        $fila = 1;

        foreach ($comidasArray as $key => $comida) {
            $colspan = 1;
            $break = '';
            $salto = '';
            if ($fila % 2 == 0) {
                $colorFondo = 'background-color:#ffffff';
            } else {
                $colorFondo = 'background-color:#f2f2f2';
            }
            if ($fila == 1 || $fila == 3) {
                $colspan = 7;
            }
            if ($fila == 5) {
//                $break = 'page-break-before:always';
//                $salto = '<div style=" page-break-before:always"></div>';

            }
            $html =
                $html . '<tr>
                                <td style="' . $tdContenidoComidas . $colorFondo . ' ">
                                    <div style=" ' . $break . ' ">
                                      ' . $comida . $salto . '
                                    </div>
                                </td>';
            for ($dia = 1; $dia <= 7; $dia++) {
                if (!empty($menusArray[$key][$dia])) {
                    $html = $html . '<td style=" ' . $tdContenido . $colorFondo . '" colspan="' . $colspan . '">
                    <div style="' . $break . '">' . $menusArray[$key][$dia] . $salto . '</div> </td>';
                } else {
                    $html = $html . '<td style=" ' . $tdContenido . $colorFondo . '"><div style=" ' . $break . ' "> ' . $salto . '  </div> </td>';
                }
            }

            $html = $html . '</tr>';

            $fila++;
        }

        $html = $html . '</table>';

        $descripcion = '';
        if ($recomendaciones) {
            $descripcion = $recomendaciones[0]['rec_descripcion'];

            $html = $html . ' <table style="text-align: center; cellspacing="0"; border="1"; border-color: green; ">
                    <tr><td style = "' . $tdEncabezado . '"  >Recomendaciones</td></tr>
                    <tr style="margin-top: 100px;">
                    <td style = "' . $tdContenidoComidas . '"> ' . $descripcion . '  </td>
                    </tr>
                    </table>';
        }

        $pdf->writeHTML($html, true, false, true, false, '');
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
        $comidasArray = [];

        if ($especialidad->esp_id == 2) {
            $menus = Menu::where('men_pac_id', $consulta->pac_id)->where('men_fecha', $consulta->cit_fecha)->get(
            )->toArray();
            $comidasArray = [];
            $dia = 1;
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

                $pdf = new TCPDF('l', true, 'UTF-8', false);
                $pdf->setPageOrientation('L');

                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);

                $pdf->AddPage();

                $comidasArray[$menu['men_comida']] = $comida;
                $menusArray[$menu['men_comida']][$menu['men_dia']] = $menu['men_descripcion'];

                $dia++;
            }
            ksort($menusArray);
            ksort($comidasArray);
        }

        $tdEncabezadoPrimero = 'background-color: #004369; color: #ffffff; text-align:center; font-family: Arial; font-size: 8pts; border-color:#FFFF';
        $tdEncabezado = 'background-color: #004369; color: #ffffff; text-align:center; font-family: Arial; font-size: 8pts; border-color:#FFFF';
        $tdContenido = 'font-family: Arial; font-size: 8pts; vertical-align:middle;';
        $tdContenidoComidas = 'text-align:justify; font-family: Arial; font-size: 10pts; ';

        $html = '<table style="cellspacing="0"; border="1"; border-color: green; ">';
        $html = $html . '<tr>';
        $html = $html . '<td style=" ' . $tdEncabezadoPrimero .' "></td>';
        for ($dia = 1; $dia <= 7; $dia++) {
            $html = $html . '<td style="' . $tdEncabezado . ' "> Día  ' . $dia . ' </td>';
        }
        $html = $html . '</tr>';
        $fila = 1;

        foreach ($comidasArray as $key => $comida) {
            $colspan = 1;
            $break = '';
            $salto = '';
            if ($fila % 2 == 0) {
                $colorFondo = 'background-color:#ffffff';
            } else {
                $colorFondo = 'background-color:#f2f2f2';
            }
            if ($fila == 1 || $fila == 3) {
                $colspan = 7;
            }
            if ($fila == 5) {
//                $break = 'page-break-before:always';
//                $salto = '<div style=" page-break-before:always"></div>';

            }
            $html =
                $html . '<tr>
                                <td style="' . $tdContenidoComidas . $colorFondo . ' ">
                                    <div style=" ' . $break . ' ">
                                      ' . $comida . $salto . '
                                    </div>
                                </td>';
            for ($dia = 1; $dia <= 7; $dia++) {
                if (!empty($menusArray[$key][$dia])) {
                    $html = $html . '<td style=" ' . $tdContenido . $colorFondo . '" colspan="' . $colspan . '">
                    <div style="' . $break . '">' . $menusArray[$key][$dia] . $salto . '</div> </td>';
                } else {
                    $html = $html . '<td style=" ' . $tdContenido . $colorFondo . '"><div style=" ' . $break . ' "> ' . $salto . '  </div> </td>';
                }
            }

            $html = $html . '</tr>';

            $fila++;
        }

        $html = $html . '</table>';

        $descripcion = '';
        if ($recomendaciones) {
            $descripcion = $recomendaciones[0]['rec_descripcion'];

            $html = $html . ' <table style="text-align: center; cellspacing="0"; border="1"; border-color: green; ">
                    <tr><td style = "' . $tdEncabezado . '"  >Recomendaciones</td></tr>
                    <tr style="margin-top: 100px;">
                    <td style = "' . $tdContenidoComidas . '"> ' . $descripcion . '  </td>
                    </tr>
                    </table>';
        }


        $pdf?->writeHTML($html, true, false, true, false, '');


        $pdfdoc = $pdf->Output("", "S");
        $mail = new PHPMailer;
        $mail->From = 'consulta@historiasmedicas.info';
        $mail->FromName = $medico;
        $mail->Subject = utf8_decode('Menu: ' . $nombrePaciente);
        $mail->addAddress($request->email);
        $mail->isHTML(true);

        $html = "
        <div>
            <span style='font-weight= bold'>" . utf8_decode($nombrePaciente) . "  </span>
            <p> " . utf8_decode('Se adjunta Ménu.') . " </p>
            <p>Saludos Cordiales...</p>
        </div>";


        $mail->Body = $html;
        $mail->AddAddress($request->email, $nombrePaciente);
        $mail->addStringAttachment($pdfdoc, 'menu_' . utf8_decode($nombrePaciente) . '.pdf');
        if (!$mail->send()) {
//            return redirect("consulta/$id")->with("Mailer Error: ", $mail->ErrorInfo);
            return redirect("menu/$id")->with("mensaje-error", "");
        } else {
            return redirect("menu/$id")->with("mensaje-enviado", "");
        }
    }
}
