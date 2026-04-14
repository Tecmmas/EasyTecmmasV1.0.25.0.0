<?php

set_time_limit(0);
ini_set('memory_limit', '-1');
//$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$titulo = "NÃºmero de registro visual: " . $this->session->userdata('idhojapruebas') . "-" . $this->session->userdata('idprueba') . " \nFecha inspeccion: " . $fechafinal . "\nPlaca: " . $this->session->userdata('numero_placa');
$hoy = getdate();
$pdf->SetTitle($titulo);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $nombreCda . " - Mapa de servicio entre fechas", "Fecha inicial: " . $fechainicial . "            Fecha final: " . $fechafinal . " \nFecha de generación de este informe: " .$fechageneracion);
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "prueba", "prueba");
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
//
$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(255, 0, 0));
//$style4 = array('L' => 0,
//    'T' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => '20,10', 'phase' => 10, 'color' => array(100, 100, 255)),
//    'R' => array('width' => 0.50, 'cap' => 'round', 'join' => 'miter', 'dash' => 0, 'color' => array(50, 50, 127)),
//    'B' => array('width' => 0.75, 'cap' => 'square', 'join' => 'miter', 'dash' => '30,10,5,10'));
// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$fecha = "";
for ($i = $fechai; $i <= $fechaf; $i+=86400) {
    $fecha = date("Y-m-d", $i);
    $resumen = $this->Mestadisticos->mapa_servicio_entre_fechas($fechainicial,$fechafinal);
    if ($resumen != FALSE) {
        $pdf->AddPage();
        $tbl1 = ' 
        <table >
            <thead>
                <tr >
                <th style="text-align: center;font-weight: bold;width: 200px"><strong>Fecha: ' . $fecha . '</strong></th>
                </tr >
                <tr >
                    <th style="text-align: center;font-weight: bold;width: 50px">Placa</th>
                    <th style="text-align: center;font-weight: bold;width: 30px">Mot.</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">Hora I.</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">Hora F.</th>
                    <th style="text-align: center;font-weight: bold;width: 80px">Documento</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">Total</th>
                    <th style="text-align: center;font-weight: bold;width: 30px">Res.</th>
                    <th style="text-align: center;font-weight: bold;width: 60px">Vigencia</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">Insp.</th>
                    <th style="text-align: center;font-weight: bold;width: 70px">Certifcado</th>
                    <th style="text-align: center;font-weight: bold;width: 100px">Cat/Tip/Mar/Mod</th>
                </tr>
            </thead>
            <tbody>';

        $tbl2 = '';
        $kPagina = 0;
        $kAcumulado = 0;
        $valorPagina = 0;
        $valorAcumulado = 0;
        $inspAprobado = 0;
        $inspRechazado = 0;
        $reinAprobado = 0;
        $reinRechazado = 0;
        $periAprobado = 0;
        $periRechazado = 0;
        $prevAprobado = 0;
        $prevRechazado = 0;
        $duplicado = 0;

        foreach ($resumen as $lis) {
            $tbltmp = '
                <tr >
                    <td style="text-align: center;width: 50px;font-size: 10px">' . $lis->numero_placa . '</td>
                    <td style="text-align: center;width: 30px;font-size: 10px">' . $lis->reinspeccion . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px">' . $lis->horainicial . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px">' . $lis->horafinal . '</td>
                    <td style="text-align: center;width: 80px;font-size: 10px">' . substr($lis->documento, 0, 12) . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px">' . $lis->valor . '</td>
                    <td style="text-align: center;width: 30px;font-size: 10px">' . $lis->ar . '</td>
                    <td style="text-align: center;width: 60px;font-size: 10px">' . $lis->fecha_vigencia . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px">' . $lis->inspector . '</td>
                    <td style="text-align: center;width: 70px;font-size: 10px">' . $lis->numero_certificado . '</td>
                    <td style="text-align: center;width: 100px;font-size: 10px">' . $lis->tipo_vehiculo . '/' . $lis->idservicio . '/' . $lis->marca . '/' . $lis->idlinea . '</td>
                </tr>';


            if ($kPagina == 63) {
                $kAcumulado = $kAcumulado + $kPagina;
                $valorAcumulado = $valorAcumulado + $valorPagina;

                $tbltmp = $tbltmp . '
                <tr>
                    <td style="width: 80px;font-size: 10px"></td>
                    <td style="text-align: center;width: 60px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>N° Insp</strong></td>
                    <td style="text-align: center;width: 120px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>Total</strong></td>
                </tr>
                <tr>
                    <td style="width: 80px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>Total página</strong></td>
                    <td style="text-align: center;width: 60px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>' . $kPagina . '</strong></td>
                    <td style="text-align: center;width: 120px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>$ ' . $valorPagina . '</strong></td>
                </tr>
                <tr>
                    <td style="width: 80px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>Total</strong></td>
                    <td style="text-align: center;width: 60px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>' . $kAcumulado . '</strong></td>
                    <td style="text-align: center;width: 120px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>$ ' . $valorAcumulado . '</strong></td>
                </tr>
                ';
                $kPagina = 0;
                $valorPagina = 0;
                //$pdf->AddPage();
            } else {
                $kPagina++;
                $valorPagina = $valorPagina + $lis->valor;
                if ($lis->reinspeccion == 0) {
                    if ($lis->ar == 'A') {
                        $inspAprobado++;
                    } else {
                        $inspRechazado++;
                    }
                } elseif ($lis->reinspeccion == 4444 || $lis->reinspeccion == 44440 || $lis->reinspeccion == 44441) {
                    if ($lis->ar == 'A') {
                        $prevAprobado++;
                    } else {
                        $prevRechazado++;
                    }
                } elseif ($lis->reinspeccion == 1) {
                    if ($lis->ar == 'A') {
                        $reinAprobado++;
                    } else {
                        $reinRechazado++;
                    }
                } elseif ($lis->reinspeccion == 7777 || $lis->reinspeccion == 77770 || $lis->reinspeccion == 77771) {
                    if ($lis->ar == 'A') {
                        $periAprobado++;
                    } else {
                        $periRechazado++;
                    }
                } else {
                    $duplicado++;
                }
            }
            $tbl2 = $tbl2 . $tbltmp;
        }
        $kAcumulado = $kAcumulado + $kPagina;
        $valorAcumulado = $valorAcumulado + $valorPagina;

        $tbl3 = ' <tr>
                    <td style="width: 80px;font-size: 10px"></td>
                    <td style="text-align: center;width: 60px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>N° Insp</strong></td>
                    <td style="text-align: center;width: 120px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>Total</strong></td>
                </tr>
                <tr>
                    <td style="width: 80px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>Total página</strong></td>
                    <td style="text-align: center;width: 60px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>' . $kPagina . '</strong></td>
                    <td style="text-align: center;width: 120px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>$ ' . $valorPagina . '</strong></td>
                </tr>
                <tr>
                    <td style="width: 80px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>Total</strong></td>
                    <td style="text-align: center;width: 60px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>' . $kAcumulado . '</strong></td>
                    <td style="text-align: center;width: 120px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>$ ' . $valorAcumulado . '</strong></td>
                </tr>
            </tbody>
        </table>';

        $tbl = $tbl1 . $tbl2 . $tbl3;

        $pdf->writeHTML($tbl, true, false, false, false, '');

        $tbl2 = ' 
         <table>
             <tr>
                    <td style="width: 80px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>Motivo</strong></td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>0</strong></td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>1</strong></td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>7777</strong></td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>4444</strong></td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>9999</strong></td>
                    <td style="text-align: center;width: 10px;font-size: 10px"></td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>Total</strong></td>                    
                </tr>
                <tr>
                    <td style="width: 80px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>Aprobados</strong></td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $inspAprobado . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $reinAprobado . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $periAprobado . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $prevAprobado . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $duplicado . '</td>
                    <td style="text-align: center;width: 10px;font-size: 10px"></td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . ($inspAprobado + $reinAprobado + $periAprobado + $prevAprobado + $duplicado) . '</td>
                </tr>
                <tr>
                    <td style="width: 80px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>Rechazados</strong></td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $inspRechazado . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $reinRechazado . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $periRechazado . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $prevRechazado . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">0</td>
                    <td style="text-align: center;width: 10px;font-size: 10px"></td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . ($inspRechazado + $reinRechazado + $periRechazado + $prevRechazado) . '</td>
                </tr>
                <tr>
                    <td style="width: 80px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>Total</strong></td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . ($inspAprobado + $inspRechazado) . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . ($reinAprobado + $reinRechazado) . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . ($periAprobado + $periRechazado) . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . ($prevAprobado + $prevRechazado) . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . ($duplicado) . '</td>
                    <td style="text-align: center;width: 10px;font-size: 10px"></td>
                    <td style="text-align: center;width: 50px;font-size: 10px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . ($inspAprobado + $inspRechazado + $reinAprobado + $reinRechazado + $prevAprobado + $prevRechazado + $duplicado) . '</td>
                </tr>
        </table>';

        $pdf->writeHTML($tbl2, true, false, false, false, '');
        $pdf->SetFontSize(8);
        $pdf->Write(0, 'Convenciones:', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '- Mot: InspecciÃ³n (0), ReinspecciÃ³n (1), Peritaje (7777 0-1), Preventiva (4444 0-1), Duplicado (9999)', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '- Res: Aprobada (A), Rechazada (R)', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '- Inspector: Consultar cÃ³digos de inspector', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '- Cat: Liviano (1), Pesado (2), Moto (3)', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '- Tipo: Oficial (1), PÃºblico (2), Particular (3), DiplomÃ¡tico (4)', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '- Marca: Consultar cÃ³digos de marca', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '- Modelo: Consultar cÃ³digo de lineas', '', 0, 'L', true, 0, false, false, 0);
    }
}
$pdf->Output($titulo . $fechageneracion . ".pdf", 'I');
