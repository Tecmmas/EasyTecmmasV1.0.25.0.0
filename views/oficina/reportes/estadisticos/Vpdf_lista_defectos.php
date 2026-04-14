<?php

set_time_limit(0);
ini_set('memory_limit', '-1');

//$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$titulo = "NÃºmero de registro visual: " . $this->session->userdata('idhojapruebas') . "-" . $this->session->userdata('idprueba') . " \nFecha inspeccion: " . $fechafinal . "\nPlaca: " . $this->session->userdata('numero_placa');
$pdf->SetTitle($titulo);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $nombreCda . " - LISTA DE DEFECTOS ", "Fecha de generación de este informe: " . $fechageneracion);
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
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
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
        <table border="1" >
            <thead>
                <tr >
                    <th style="text-align: center;"><strong>Codigo</strong></th>
                    <th style="text-align: center;width: 370px;"><strong>Descripción</strong></th>
                    <th style="text-align: center;width: 25px;"><strong>Gra</strong></th>
                    <th style="text-align: center;width: 25px;"><strong>Ins</strong></th>
                    <th style="text-align: center;width: 25px;"><strong>Liv</strong></th>
                    <th style="text-align: center;width: 25px;"><strong>Pes</strong></th>
                    <th style="text-align: center;width: 25px;"><strong>Mot</strong></th>
                    <th style="text-align: center;width: 25px;"><strong>Mcr</strong></th>
                    <th style="text-align: center;width: 25px;"><strong>Ser</strong></th>
                    <th style="text-align: center;width: 25px;"><strong>Ens</strong></th>
                </tr>
            </thead>
            <tbody>';

$tbl2 = '';
$livianopesado = "";
$motocarro = "";
$moto = "";
$visual = "";
$ensenanza = "";
if ($defectos != FALSE) {
    foreach ($defectos as $value) {
        if ($value->nombre_defecto == 'liviano pesado' || $value->nombre_defecto == 'motocarro' || $value->nombre_defecto == 'gasolina-motos' || $value->nombre_defecto == 'motocicletas y motociclos') {
            if ($value->nombre_defecto == 'liviano pesado') {
                $motocarro = '';
                $moto = '';
                $livianopesado = 'X';
            } elseif ($value->nombre_defecto == 'motocarro') {
                $livianopesado = '';
                $moto = '';
                $motocarro = 'X';
            } else {
                $livianopesado = '';
                $motocarro = '';
                $moto = 'X';
            }
            if ($value->visual == 1) {
                $visual = 'V';
            } else {
                $visual = 'M';
            }
            $tbltmp = '<tr >
                        <td >' . $value->codigo . '</td>
                        <td style="text-align: left;width: 370px;">' . $value->descripcion . '</td>
                        <td style="text-align: center;width: 25px;">' . $value->tipo . '</td>
                        <td style="text-align: center;width: 25px;">' . $visual . '</td>
                        <td style="text-align: center;width: 25px;">' . $livianopesado . '</td>
                        <td style="text-align: center;width: 25px;">' . $livianopesado . '</td>
                        <td style="text-align: center;width: 25px;">' . $moto . '</td>
                        <td style="text-align: center;width: 25px;">' . $motocarro . '</td>
                        <td style="text-align: center;width: 25px;">' . $value->publico . '</td>
                        <td style="text-align: center;width: 25px;">' . $value->ensenanza . '</td>
                    </tr>';
            $tbl2 = $tbl2 . $tbltmp;
        }
    }
}


$tbl3 = ' </tbody>
        </table>';

$tbl = $tbl1 . $tbl2 . $tbl3;

$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->Ln();



$pdf->Ln();
$pdf->Write(0, 'Gra: Gravedad', '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'Ins: Tipo inpeccion. V. Visual M. Mecanzado', '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'Mot: Motos', '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'Liv: Livianos', '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'Pes: Pesados', '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'Mcr: Motocarros', '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'Ser: Servicio. 0. Particular 1.Público', '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'Ens: Enseñanza', '', 0, 'L', true, 0, false, false, 0);


$pdf->Output("listaDefectos.pdf", 'I');

