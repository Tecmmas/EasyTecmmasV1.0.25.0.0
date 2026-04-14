<?php

set_time_limit(0);
ini_set('memory_limit', '-1');

//$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$titulo = "NÃºmero de registro visual: " . $this->session->userdata('idhojapruebas') . "-" . $this->session->userdata('idprueba') . " \nFecha inspeccion: " . $fechafinal . "\nPlaca: " . $this->session->userdata('numero_placa');
$hoy = getdate();
$pdf->SetTitle($titulo);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $nombreCda . " - Lista de defectos por inspector", "Fecha inicial: " . $fechainicial . "            Fecha final: " . $fechafinal . " \nFecha de generación de este informe: ".$fechageneracion);
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
$tbl1 = ' 
        <table >
            <thead>
            <tr >
                    <th style="width: 140px"></th>
                    <th style="text-align: center;border-width: 1px;font-weight: bold;width: 200px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Defectos</th>
                </tr>
                <tr >
                    <th style="text-align: center;border-width: 1px;width: 140px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Inspectores</th>
                    <th style="text-align: center;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">A</th>
                    <th style="text-align: center;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">B</th>
                    <th style="text-align: center;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Total defectos</th>
                </tr>
            </thead>
            <tbody>';

$tbl2 = '';

if ($inspectores != FALSE) {
    $total_a = 0;
    $total_b = 0;
    foreach ($inspectores as $ins) {
        $idusuario = $ins->idusuario;
        $num = $this->Mestadisticos->numDefectos($fechainicial,$fechafinal,$idusuario);
        $tbltmp = '<tr >
                        <td style="text-align: center;vertical-align: middle;width: 140px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ins->idusuario . '</td>
                        <td style="text-align: center;vertical-align: middle;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $num->num_defA . '</td>
                        <td style="text-align: center;vertical-align: middle;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $num->num_defB . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . ($num->num_defA + $num->num_defB) . '</td>
                    </tr>';
        $tbl2 = $tbl2 . $tbltmp;
        $total_a = $total_a + $num->num_defA;
        $total_b = $total_b + $num->num_defB;
    }
    $tbltmp2 = '<tr >
                        <td style="text-align: center;vertical-align: middle;width: 140px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px;color: #cd0a0a"><strong>Total</strong></td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px;color: #cd0a0a">' . $total_a . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px;color: #cd0a0a">' . $total_b . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px;color: #cd0a0a">' . ($total_a + $total_b) . '</td>
                    </tr>';
}


$tbl3 = $tbltmp2 . ' </tbody>
        </table>';

$tbl = $tbl1 . $tbl2 . $tbl3;

$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->AddPage();
$xc = 35;
$yc = 50;
$r = 15;
$xTextInspector = 27;
$yTextInspector = 30;
$xTextNum = 50;
$yTextNum1 = 40;
$yTextNum2 = 55;

$pdf->SetTextColor(210, 16, 16);
$pdf->Text(40, 22, 'Defectos de tipo A');
$pdf->SetTextColor(142, 139, 139);
$pdf->Text(130, 22, 'Defectos de tipo B');

$banderaX = 1;
if ($inspectores != FALSE) {
    foreach ($inspectores as $ins) {
        $idusuario = $ins->idusuario;
        $num = $this->Mestadisticos->numDefectos($fechainicial,$fechafinal,$idusuario);
        $numA = $num->num_defA;
        $numB = $num->num_defB;
        $total = $numA + $numB;

        $numAPor = round(($numA / $total) * 100);
        $numBPor = round(($numB / $total) * 100);

        $numAGr = round(($numA / $total) * 360);
        $numBGr = round(($numB / $total) * 360);

        $pdf->SetFillColor(210, 16, 16);
        $pdf->PieSector($xc, $yc, $r, 0, $numAGr, 'F', false, 0, 2);

        $pdf->SetFillColor(142, 139, 139);
        $pdf->PieSector($xc, $yc, $r, $numAGr, 360, 'F', false, 0, 2);

        $pdf->SetTextColor(210, 16, 16);
        $pdf->Text($xTextNum, $yTextNum1, $numA);
        $pdf->SetTextColor(142, 139, 139);
        $pdf->Text($xTextNum, $yTextNum2, $numB);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Text($xTextInspector, $yTextInspector, 'Insp. ' . $ins->idusuario);

        if ($banderaX == 3) {
            $xTextInspector = 27;
            $xTextNum = 50;
            $xc = 35;
            $yc = $yc + 40;
            $yTextInspector = $yTextInspector + 40;
            $yTextNum1 = $yTextNum1 + 40;
            $yTextNum2 = $yTextNum2 + 40;
            $banderaX = 0;
        } else {
            $xTextInspector = $xTextInspector + 65;
            $xTextNum = $xTextNum + 65;
            $xc = $xc + 65;
        }
        $banderaX++;
    }
}


$pdf->Output($titulo . $fechageneracion . ".pdf", 'I');

