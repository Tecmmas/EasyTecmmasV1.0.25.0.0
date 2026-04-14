<?php

set_time_limit(0);
ini_set('memory_limit', '-1');
//$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$titulo = "NÃºmero de registro visual: " . $this->session->userdata('idhojapruebas') . "-" . $this->session->userdata('idprueba') . " \nFecha inspeccion: " . $fechafinal . "\nPlaca: " . $this->session->userdata('numero_placa');
$hoy = getdate();
$pdf->SetTitle($titulo);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $nombreCda . " - Estadística de clientes adquiridos, perdidos y retornados", "Fecha inicial perdidos: " . $fechaperdidos . "                 Fecha inicial: " . $fechainicial . "            Fecha final: " . $fechafinal . " \nFecha de generación de este informe: " . $fechageneracion);
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

$pdf->AddPage();

if ($clientesAdquiridos != FALSE) {

    $tbl1 = ' 
        <table >
            <thead>
                <tr >
                    <th style="font-weight: bold;width: 940px"><strong>CLIENTES ADQUIRIDOS</strong></th>
                </tr>
                <tr >
                    <th style="text-align: center;font-weight: bold;width: 70px">Placa</th>
                    <th style="font-weight: bold;width: 200px">Mar/Mod</th>
                    <th style="text-align: center;font-weight: bold;width: 100px">Vigencia</th>
                    <th style="font-weight: bold;width: 460px">Propietario</th>
                    <th style="text-align: center;font-weight: bold;width: 60px">Inspector</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">AR</th>
                </tr>
            </thead>
            <tbody>';

    $tbl2 = '';



    foreach ($clientesAdquiridos as $lis) {
        $tbltmp = '
                <tr >
                    <td style="text-align: center;width: 70px;font-size:10px">' . $lis->numero_placa . '</td>
                    <td style="width: 200px;font-size:10px">' . $lis->marca . '</td>
                    <td style="text-align: center;width: 100px;font-size:10px">' . $lis->fecha . '</td>
                    <td style="width: 230px;font-size:10px">' . $lis->propietario . '</td>
                    <td style="width: 230px;font-size:10px">' . $lis->direccion . '</td>
                    <td style="text-align: center;width: 60px;font-size:10px">' . $lis->usuario . '</td>
                    <td style="text-align: center;width: 50px;font-size:10px">' . $lis->AR . '</td>
                </tr>
                <tr >
                    <td style="text-align: center;width: 70px;font-size:10px"></td>
                    <td style="text-align: center;width: 200px;font-size:10px"></td>
                    <td style="text-align: center;width: 100px;"></td>
                    <td style="width: 230px;font-size:10px">Telefono 1: ' . $lis->telefono1 . '</td>
                    <td style="width: 130px;font-size:10px">Telefono 2: ' . $lis->telefono2 . '</td>
                    <td style="width: 200px;font-size:10px">' . $lis->ciudad . '</td>
                </tr>
                ';

        $tbl2 = $tbl2 . $tbltmp;
    }
} else {
    $pdf->Write(0, 'NO HAY CLIENTES ADQUIRIDOS EN ESTE INTERVALO DE FECHAS', '', 0, 'L', true, 0, false, false, 0);
}

$tbl3 = ' </tbody>
        </table>';

$tbl = $tbl1 . $tbl2 . $tbl3;

$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->AddPage();
if ($clientesPerdidos != FALSE) {

    $tbl1 = ' 
        <table >
            <thead>
                            <tr >
                    <th style="font-weight: bold;width: 940px"><strong>CLIENTES PERDIDOS</strong></th>
                </tr>
                <tr >
                    <th style="text-align: center;font-weight: bold;width: 70px">Placa</th>
                    <th style="font-weight: bold;width: 200px">Mar/Mod</th>
                    <th style="text-align: center;font-weight: bold;width: 100px">Vigencia</th>
                    <th style="font-weight: bold;width: 460px">Propietario</th>
                    <th style="text-align: center;font-weight: bold;width: 60px">Inspector</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">AR</th>
                </tr>
            </thead>
            <tbody>';

    $tbl2 = '';



    foreach ($clientesPerdidos as $lis) {
        $tbltmp = '
                <tr >
                    <td style="text-align: center;width: 70px;font-size:10px">' . $lis->numero_placa . '</td>
                    <td style="width: 200px;font-size:10px">' . $lis->marca . '</td>
                    <td style="text-align: center;width: 100px;font-size:10px">' . $lis->fecha . '</td>
                    <td style="width: 230px;font-size:10px">' . $lis->propietario . '</td>
                    <td style="width: 230px;font-size:10px">' . $lis->direccion . '</td>
                    <td style="text-align: center;width: 60px;font-size:10px">' . $lis->usuario . '</td>
                    <td style="text-align: center;width: 50px;font-size:10px">' . $lis->AR . '</td>
                </tr>
                <tr >
                    <td style="text-align: center;width: 70px;font-size:10px"></td>
                    <td style="text-align: center;width: 200px;font-size:10px"></td>
                    <td style="text-align: center;width: 100px;"></td>
                    <td style="width: 230px;font-size:10px">Telefono 1: ' . $lis->telefono1 . '</td>
                    <td style="width: 130px;font-size:10px">Telefono 2: ' . $lis->telefono2 . '</td>
                    <td style="width: 200px;font-size:10px">' . $lis->ciudad . '</td>
                </tr>
                ';

        $tbl2 = $tbl2 . $tbltmp;
    }
} else {
    $pdf->Write(0, 'NO HAY CLIENTES PERDIDOS EN ESTE INTERVALO DE FECHAS', '', 0, 'L', true, 0, false, false, 0);
}

$tbl3 = ' </tbody>
        </table>';

$tbl = $tbl1 . $tbl2 . $tbl3;

$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->AddPage();
if ($clientesRetornados != FALSE) {

    $tbl1 = ' 
        <table >
            <thead>
                <tr >
                    <th style="font-weight: bold;width: 940px"><strong>CLIENTES RETORNADOS</strong></th>
                </tr>
                <tr >
                    <th style="text-align: center;font-weight: bold;width: 70px">Placa</th>
                    <th style="font-weight: bold;width: 200px">Mar/Mod</th>
                    <th style="text-align: center;font-weight: bold;width: 100px">Vigencia</th>
                    <th style="font-weight: bold;width: 460px">Propietario</th>
                    <th style="text-align: center;font-weight: bold;width: 60px">Inspector</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">AR</th>
                </tr>
            </thead>
            <tbody>';

    $tbl2 = '';



    foreach ($clientesRetornados as $lis) {
        $tbltmp = '
                <tr >
                    <td style="text-align: center;width: 70px;font-size:10px">' . $lis->numero_placa . '</td>
                    <td style="width: 200px;font-size:10px">' . $lis->marca . '</td>
                    <td style="text-align: center;width: 100px;font-size:10px">' . $lis->fecha . '</td>
                    <td style="width: 230px;font-size:10px">' . $lis->propietario . '</td>
                    <td style="width: 230px;font-size:10px">' . $lis->direccion . '</td>
                    <td style="text-align: center;width: 60px;font-size:10px">' . $lis->usuario . '</td>
                    <td style="text-align: center;width: 50px;font-size:10px">' . $lis->AR . '</td>
                </tr>
                <tr >
                    <td style="text-align: center;width: 70px;font-size:10px"></td>
                    <td style="text-align: center;width: 200px;font-size:10px"></td>
                    <td style="text-align: center;width: 100px;"></td>
                    <td style="width: 230px;font-size:10px">Telefono 1: ' . $lis->telefono1 . '</td>
                    <td style="width: 130px;font-size:10px">Telefono 2: ' . $lis->telefono2 . '</td>
                    <td style="width: 200px;font-size:10px">' . $lis->ciudad . '</td>
                </tr>
                ';

        $tbl2 = $tbl2 . $tbltmp;
    }
} else {
    $pdf->Write(0, 'NO HAY CLIENTES RETORNADOS EN ESTE INTERVALO DE FECHAS', '', 0, 'L', true, 0, false, false, 0);
}

$tbl3 = ' </tbody>
        </table>';

$tbl = $tbl1 . $tbl2 . $tbl3;

$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->Ln();


$pdf->Output($titulo . '_' .$fechageneracion . ".pdf", 'I');


