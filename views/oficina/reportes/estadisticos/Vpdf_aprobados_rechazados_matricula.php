<?php

set_time_limit(0);
ini_set('memory_limit', '-1');

//$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$titulo = "NÃºmero de registro visual: " . $this->session->userdata('idhojapruebas') . "-" . $this->session->userdata('idprueba') . " \nFecha inspeccion: " . $fechafinal . "\nPlaca: " . $this->session->userdata('numero_placa');
$hoy = getdate();
$pdf->SetTitle($titulo);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $nombreCda . " - Estadística de aprobaciones y rechazos por año de matrícula", "Fecha inicial: " . $fechainicial . "            Fecha final: " . $fechafinal . " \nFecha de generación de este informe: " . $fechageneracion);
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
$style4 = array('L' => 0,
//    'T' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => '20,10', 'phase' => 10, 'color' => array(100, 100, 255)),
    'R' => array('width' => 0.50, 'cap' => 'round', 'join' => 'miter', 'dash' => 0, 'color' => array(50, 50, 127)),
    'B' => array('width' => 0.75, 'cap' => 'square', 'join' => 'miter', 'dash' => '30,10,5,10'));
// set font
$pdf->SetFont('helvetica', '', 10);
$style4 = "";

// add a page

$pdf->AddPage();
$tbl1 = ' 
        <table >
            <thead>
            <tr >
                    <th style="width: 140px"></th>
                    <th style="text-align: center;border-width: 1px;font-weight: bold;width: 200px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Inspecciones</th>
                    <th style="text-align: center;border-width: 1px;font-weight: bold;width: 200px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Reinspecciones</th>
                    <th style="text-align: center;border-width: 1px;font-weight: bold;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Total</th>
                </tr>
                <tr >
                    <th style="text-align: center;border-width: 1px;width: 140px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Año matrícula</th>
                    <th style="text-align: center;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Aprobados</th>
                    <th style="text-align: center;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Rechazados</th>
                    <th style="text-align: center;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Aprobados</th>
                    <th style="text-align: center;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Rechazados</th>
                    <th style="text-align: center;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Veic. Insp</th>
                </tr>
            </thead>
            <tbody>';

$tbl2 = '
                    <tr >
                        <td style="text-align: center;vertical-align: middle;width: 140px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Menor o igual a 1993</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ai1993 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ri1993 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ar1993 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $rr1993 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $total1993 . '</td>
                    </tr>
                    <tr >
                        <td style="text-align: center;vertical-align: middle;border-width: 1px;width: 140px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">1994 - 1998</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ai19941998 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ri19941998 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ar19941998 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $rr19941998 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $total19941998 . '</td>
                    </tr>
                    <tr >
                        <td style="text-align: center;vertical-align: middle;border-width: 1px;width: 140px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">1999 - 2003</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ai19992003 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ri19992003 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ar19992003 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $rr19992003 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $total19992003 . '</td>
                    </tr>
                    <tr >
                        <td style="text-align: center;vertical-align: middle;border-width: 1px;width: 140px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">2004 - 2008</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ai20042008 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ri20042008 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ar20042008 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $rr20042008 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $total20042008 . '</td>
                    </tr>
                    <tr >
                        <td style="text-align: center;vertical-align: middle;border-width: 1px;width: 140px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Mayor o igual a 2009</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ai2009 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ri2009 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ar2009 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $rr2009 . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $total2009 . '</td>
                    </tr>
                    <tr >
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 140px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px;color: #cd0a0a">Total</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px;color: #cd0a0a">' . $totalAprobadosInpeccion . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px;color: #cd0a0a">' . $totalRechazadosInpeccion . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px;color: #cd0a0a">' . $totalAprobadosReinpeccion . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px;color: #cd0a0a">' . $totalRechazadosReinpeccion . '</td>
                        <td style="text-align: center;vertical-align: middle;font-weight: bold;border-width: 1px;width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px;color: #cd0a0a">' . $total . '</td>
                    </tr>
                    
';

$tbl3 = ' </tbody>
        </table>';

$tbl = $tbl1 . $tbl2 . $tbl3;

$pdf->writeHTML($tbl, true, false, false, false, '');

$txt = 'Resultados por año de matrícula';

$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);

$pdf->Ln();
$pdf->Ln();
$txt = 'Mayor igual 2009';
$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$txt = '2004 - 2008';
$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);
$txt = '                                                                                                                                                    Leyenda';
$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);
$txt = '                                                                                                                                                      Ins. Aprobadas';
$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);
$txt = '                                                                                                                                                      Ins. Rechazadas';
$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);
$txt = '1999 - 2003                                                                                                                                   Reins. Aprobadas';
$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);
$txt = '                                                                                                                                                      Reins. Rechazadas';
$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);
$pdf->Ln();
$pdf->Ln();
$txt = '1994 - 1998';
$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$txt = 'Menor igual 1993';
$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);
//$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->Line(44, 75, 44, 160);
$pdf->Line(44, 160, 150, 160);
$pdf->Rect(155, 100, 40, 25, 'D', $style4, array(15, 3, 137));
$pdf->Rect(156, 120, 5, 3, 'F', $style4, array(15, 3, 137));
$pdf->Rect(156, 116, 5, 3, 'F', $style4, array(21, 0, 255));
$pdf->Rect(156, 112, 5, 3, 'F', $style4, array(29, 139, 7));
$pdf->Rect(156, 108, 5, 3, 'F', $style4, array(210, 16, 16));
//------------------------------------------------------------------------------BARRAS DE 2009 HACIA ARRIBA
$pdf->Rect(45, 77, $rr2009Por, 3, 'F', $style4, array(15, 3, 137));
$pdf->Rect(45 + $rr2009Por, 77, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetFontSize(8);
$pdf->Text(44 + $rr2009Por, 77, $rr2009);


$pdf->Rect(45, 80, $ar2009Por, 3, 'F', $style4, array(21, 0, 255));
$pdf->Rect(45 + $ar2009Por, 80, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetFontSize(8);
$pdf->Text(44 + $ar2009Por, 80, $ar2009);


$pdf->Rect(45, 83, $ri2009Por, 3, 'F', $style4, array(29, 139, 7));
$pdf->Rect(45 + $ri2009Por, 83, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetFontSize(8);
$pdf->Text(44 + $ri2009Por, 83, $ri2009);

$pdf->Rect(45, 86, $ai2009Por, 3, 'F', $style4, array(210, 16, 16));
$pdf->Rect(45 + $ai2009Por, 86, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetFontSize(8);
$pdf->Text(44 + $ai2009Por, 86, $ai2009);

//------------------------------------------------------------------------------BARRAS DE 2004 - 2008
$pdf->Rect(45, 93, $rr20042008Por, 3, 'F', $style4, array(15, 3, 137));
$pdf->Rect(45 + $rr20042008Por, 93, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetXY(44 + $rr20042008Por, 93);
$pdf->SetFontSize(8);
$pdf->Write(0, $rr20042008, '', 0, 'L', true, 0, false, false, 0);

$pdf->Rect(45, 96, $ar20042008Por, 3, 'F', $style4, array(21, 0, 255));
$pdf->Rect(45 + $ar20042008Por, 96, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetXY(44 + $ar20042008Por, 96);
$pdf->SetFontSize(8);
$pdf->Write(0, $ar20042008, '', 0, 'L', true, 0, false, false, 0);

$pdf->Rect(45, 99, $ri20042008Por, 3, 'F', $style4, array(29, 139, 7));
$pdf->Rect(45 + $ri20042008Por, 99, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetXY(44 + $ri20042008Por, 99);
$pdf->SetFontSize(8);
$pdf->Write(0, $ri20042008, '', 0, 'L', true, 0, false, false, 0);

$pdf->Rect(45, 102, $ai20042008Por, 3, 'F', $style4, array(210, 16, 16));
$pdf->Rect(45 + $ai20042008Por, 102, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetXY(44 + $ai20042008Por, 102);
$pdf->SetFontSize(8);
$pdf->Write(0, $ai20042008, '', 0, 'L', true, 0, false, false, 0);
//------------------------------------------------------------------------------BARRAS DE 1999 - 2003
$pdf->Rect(45, 111, $rr19992003Por, 3, 'F', $style4, array(15, 3, 137));
$pdf->Rect(45 + $rr19992003Por, 111, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetXY(44 + $rr19992003Por, 111);
$pdf->SetFontSize(8);
$pdf->Write(0, $rr19992003, '', 0, 'L', true, 0, false, false, 0);

$pdf->Rect(45, 114, $ar19992003Por, 3, 'F', $style4, array(21, 0, 255));
$pdf->Rect(45 + $ar19992003Por, 114, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetXY(44 + $ar19992003Por, 114);
$pdf->SetFontSize(8);
$pdf->Write(0, $ar19992003, '', 0, 'L', true, 0, false, false, 0);

$pdf->Rect(45, 117, $ri19992003Por, 3, 'F', $style4, array(29, 139, 7));
$pdf->Rect(45 + $ri19992003Por, 117, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetXY(44 + $ri19992003Por, 117);
$pdf->SetFontSize(8);
$pdf->Write(0, $ri19992003, '', 0, 'L', true, 0, false, false, 0);

$pdf->Rect(45, 120, $ai19992003Por, 3, 'F', $style4, array(210, 16, 16));
$pdf->Rect(45 + $ai19992003Por, 120, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetXY(44 + $ai19992003Por, 120);
$pdf->SetFontSize(8);
$pdf->Write(0, $ai19992003, '', 0, 'L', true, 0, false, false, 0);
//------------------------------------------------------------------------------BARRAS DE 1994 - 1998
$pdf->Rect(45, 128, $rr19941998Por, 3, 'F', $style4, array(15, 3, 137));
$pdf->Rect(45 + $rr19941998Por, 128, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetXY(44 + $rr19941998Por, 128);
$pdf->SetFontSize(8);
$pdf->Write(0, $rr19941998, '', 0, 'L', true, 0, false, false, 0);

$pdf->Rect(45, 131, $ar19941998Por, 3, 'F', $style4, array(21, 0, 255));
$pdf->Rect(45 + $ar19941998Por, 131, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetXY(44 + $ar19941998Por, 131);
$pdf->SetFontSize(8);
$pdf->Write(0, $ar19941998, '', 0, 'L', true, 0, false, false, 0);

$pdf->Rect(45, 134, $ri19941998Por, 3, 'F', $style4, array(29, 139, 7));
$pdf->Rect(45 + $ri19941998Por, 134, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetXY(44 + $ri19941998Por, 134);
$pdf->SetFontSize(8);
$pdf->Write(0, $ri19941998, '', 0, 'L', true, 0, false, false, 0);

$pdf->Rect(45, 137, $ai19941998Por, 3, 'F', $style4, array(210, 16, 16));
$pdf->Rect(45 + $ai19941998Por, 137, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetXY(44 + $ai19941998Por, 137);
$pdf->SetFontSize(8);
$pdf->Write(0, $ai19941998, '', 0, 'L', true, 0, false, false, 0);
//------------------------------------------------------------------------------MENOR QUE 1993
$pdf->Rect(45, 146, $rr1993Por, 3, 'F', $style4, array(15, 3, 137));
$pdf->Rect(45 + $rr1993Por, 146, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetXY(44 + $rr1993Por, 146);
$pdf->SetFontSize(8);
$pdf->Write(0, $rr1993, '', 0, 'L', true, 0, false, false, 0);



$pdf->Rect(45, 149, $ar1993Por, 3, 'F', $style4, array(21, 0, 255));
$pdf->Rect(45 + $ar1993Por, 149, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetXY(44 + $ar1993Por, 149);
$pdf->SetFontSize(8);
$pdf->Write(0, $ar1993, '', 0, 'L', true, 0, false, false, 0);


$pdf->Rect(45, 152, $ri1993Por, 3, 'F', $style4, array(29, 139, 7));
$pdf->Rect(45 + $ri1993Por, 152, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetXY(44 + $ri1993Por, 152);
$pdf->SetFontSize(8);
$pdf->Write(0, $ri1993, '', 0, 'L', true, 0, false, false, 0);


$pdf->Rect(45, 155, $ai1993Por, 3, 'F', $style4, array(210, 16, 16));
$pdf->Rect(45 + $ai1993Por, 155, 5, 3, 'D', $style4, array(210, 16, 16));
$pdf->SetXY(44 + $ai1993Por, 155);
$pdf->SetFontSize(8);
$pdf->Write(0, $ai1993, '', 0, 'L', true, 0, false, false, 0);
$pdf->Ln();
$pdf->Ln();
$txt = 'Total de inspecciones por año de matrícula';
$pdf->SetFontSize(10);
$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);

$pdf->Rect(155, 185, 30, 15, 'D', $style4, array(15, 3, 137));
$pdf->Rect(156, 193, 5, 3, 'F', $style4, array(210, 16, 16));

$pdf->Line(20, 175, 20, 230);
$pdf->Line(20, 230, 150, 230);
$pdf->Rect(25, 229, 20, -$total1993Por, 'F', $style4, array(210, 16, 16));


$pdf->Rect(50, 229, 20, -$total19941998Por, 'F', $style4, array(210, 16, 16));

$pdf->Rect(75, 229, 20, -$total19992003Por, 'F', $style4, array(210, 16, 16));

$pdf->Rect(100, 229, 20, -$total20042008Por, 'F', $style4, array(210, 16, 16));

$pdf->Rect(125, 229, 20, -$total2009Por, 'F', $style4, array(210, 16, 16));
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$txt = '                                                                                                                                               Leyenda';
$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);
$txt = '                                                                                                                                                      Total';
$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();


$txt = '           Menor igual 1993         1994-1998              1999-2003               2004-2008           Mayor igual 2009';
$pdf->SetFontSize(8);
$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFontSize(10);
$pdf->Text(30, 225 - $total1993Por, $total1993);
$pdf->Text(55, 225 - $total19941998Por, $total19941998);
$pdf->Text(80, 225 - $total19992003Por, $total19992003);
$pdf->Text(105, 225 - $total20042008Por, $total20042008);
$pdf->Text(130, 225 - $total2009Por, $total2009);


$pdf->Text(15, 240, 'Porcentaje de inspecciones aprobadas y rechazadas por año de matrícula');
$pdf->SetFontSize(8);
$pdf->Text(15, 248, '           Menor igual 1993         1994-1998              1999-2003               2004-2008           Mayor igual 2009');


$xc1993 = 35;
$yc1993 = 265;
$r1993 = 10;

$aprobadas1993 = $ar1993 + $ai1993;
$rechazadas1993 = $rr1993 + $ri1993;

$aprobadas1993Por = round(($aprobadas1993 / $total1993) * 100);
$recchazadas1993Por = round(($rechazadas1993 / $total1993) * 100);

$aprobadas1993Gr = round(($aprobadas1993 / $total1993) * 360);
$recchazadas1993Gr = round(($rechazadas1993 / $total1993) * 360);

$pdf->SetFillColor(210, 16, 16);
$pdf->PieSector($xc1993, $yc1993, $r1993, 0, $aprobadas1993Gr, 'F', false, 0, 2);

$pdf->SetFillColor(29, 139, 7);
$pdf->PieSector($xc1993, $yc1993, $r1993, $aprobadas1993Gr, 360, 'F', false, 0, 2);

$pdf->SetTextColor(210, 16, 16);
$pdf->Text(24, 253, $aprobadas1993Por . '%');
$pdf->SetTextColor(29, 139, 7);
$pdf->Text(43.5, 268, $recchazadas1993Por . '%');

$xc19941998 = 60;
$yc19941998 = 265;
$r19941998 = 10;

$aprobadas19941998 = $ar19941998 + $ai19941998;
$rechazadas19941998 = $rr19941998 + $ri19941998;

$aprobadas19941998Por = round(($aprobadas19941998 / $total19941998) * 100);
$recchazadas19941998Por = round(($rechazadas19941998 / $total19941998) * 100);

$aprobadas19941998Gr = round(($aprobadas19941998 / $total19941998) * 360);
$recchazadas19941998Gr = round(($rechazadas19941998 / $total19941998) * 360);

$pdf->SetFillColor(210, 16, 16);
$pdf->PieSector($xc19941998, $yc19941998, $r19941998, 0, $aprobadas19941998Gr, 'F', false, 0, 2);

$pdf->SetFillColor(29, 139, 7);
$pdf->PieSector($xc19941998, $yc19941998, $r19941998, $aprobadas19941998Gr, 360, 'F', false, 0, 2);

$pdf->SetTextColor(210, 16, 16);
$pdf->Text(49, 253, $aprobadas19941998Por . '%');
$pdf->SetTextColor(29, 139, 7);
$pdf->Text(68.5, 268, $recchazadas19941998Por . '%');

$xc19992003 = 85;
$yc19992003 = 265;
$r19992003 = 10;

$aprobadas19992003 = $ar19992003 + $ai19992003;
$rechazadas19992003 = $rr19992003 + $ri19992003;

$aprobadas19992003Por = round(($aprobadas19992003 / $total19992003) * 100);
$recchazadas19992003Por = round(($rechazadas19992003 / $total19992003) * 100);

$aprobadas19992003Gr = round(($aprobadas19992003 / $total19992003) * 360);
$recchazadas19992003Gr = round(($rechazadas19992003 / $total19992003) * 360);

$pdf->SetFillColor(210, 16, 16);
$pdf->PieSector($xc19992003, $yc19992003, $r19992003, 0, $aprobadas19992003Gr, 'F', false, 0, 2);

$pdf->SetFillColor(29, 139, 7);
$pdf->PieSector($xc19992003, $yc19992003, $r19992003, $aprobadas19992003Gr, 360, 'F', false, 0, 2);

$pdf->SetTextColor(210, 16, 16);
$pdf->Text(74, 253, $aprobadas19992003Por . '%');
$pdf->SetTextColor(29, 139, 7);
$pdf->Text(93.5, 268, $recchazadas19992003Por . '%');

$xc20042008 = 110;
$yc20042008 = 265;
$r20042008 = 10;

$aprobadas20042008 = $ar20042008 + $ai20042008;
$rechazadas20042008 = $rr20042008 + $ri20042008;

$aprobadas20042008Por = round(($aprobadas20042008 / $total20042008) * 100);
$recchazadas20042008Por = round(($rechazadas20042008 / $total20042008) * 100);

$aprobadas20042008Gr = round(($aprobadas20042008 / $total20042008) * 360);
$recchazadas20042008Gr = round(($rechazadas20042008 / $total20042008) * 360);

$pdf->SetFillColor(210, 16, 16);
$pdf->PieSector($xc20042008, $yc20042008, $r20042008, 0, $aprobadas20042008Gr, 'F', false, 0, 2);

$pdf->SetFillColor(29, 139, 7);
$pdf->PieSector($xc20042008, $yc20042008, $r20042008, $aprobadas20042008Gr, 360, 'F', false, 0, 2);

$pdf->SetTextColor(210, 16, 16);
$pdf->Text(99, 253, $aprobadas20042008Por . '%');
$pdf->SetTextColor(29, 139, 7);
$pdf->Text(118.5, 268, $recchazadas20042008Por . '%');

$xc2009 = 135;
$yc2009 = 265;
$r2009 = 10;

$aprobadas2009 = $ar2009 + $ai2009;
$rechazadas2009 = $rr2009 + $ri2009;

$aprobadas2009Por = round(($aprobadas2009 / $total2009) * 100);
$recchazadas2009Por = round(($rechazadas2009 / $total2009) * 100);

$aprobadas2009Gr = round(($aprobadas2009 / $total2009) * 360);
$recchazadas2009Gr = round(($rechazadas2009 / $total2009) * 360);

$pdf->SetFillColor(210, 16, 16);
$pdf->PieSector($xc2009, $yc2009, $r2009, 0, $aprobadas2009Gr, 'F', false, 0, 2);

$pdf->SetFillColor(29, 139, 7);
$pdf->PieSector($xc2009, $yc2009, $r2009, $aprobadas2009Gr, 360, 'F', false, 0, 2);

$pdf->SetTextColor(210, 16, 16);
$pdf->Text(124, 253, $aprobadas2009Por . '%');
$pdf->SetTextColor(29, 139, 7);
$pdf->Text(143.5, 268, $recchazadas2009Por . '%');

$pdf->SetFontSize(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->Text(156, 255, 'Leyenda');
$pdf->Rect(155, 255, 32, 15, 'D', $style4, array(210, 16, 16));
$pdf->Rect(156, 260, 5, 3, 'F', $style4, array(210, 16, 16));
$pdf->Rect(156, 265, 5, 3, 'F', $style4, array(29, 139, 7));
$pdf->SetTextColor(210, 16, 16);
$pdf->Text(161, 260, '% Aprobadas');
$pdf->SetTextColor(29, 139, 7);
$pdf->Text(161, 265, '% Rechazadas');


$pdf->Output($titulo. '_' . $fechageneracion . ".pdf", 'I');

