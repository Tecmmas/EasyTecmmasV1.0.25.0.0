<?php

set_time_limit(0);
ini_set('memory_limit', '-1');
//$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$titulo = "NÃºmero de registro visual: " . $this->session->userdata('idhojapruebas') . "-" . $this->session->userdata('idprueba') . " \nFecha inspeccion: " . $fechafinal . "\nPlaca: " . $this->session->userdata('numero_placa');
$hoy = getdate();
$pdf->SetTitle($titulo);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $nombreCda . " - Lista de previsiones de servicios", "Fecha inicial: " . $fechainicial . "            Fecha final: " . $fechafinal . " \nFecha de generación de este informe: " . $fechageneracion);
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
if ($listagem != FALSE) {
    $tbl1 = ' 
        <table >
            <thead>
                <tr >
                    <th style="font-weight: bold;width: 250px">Cliente</th>
                    <th style="text-align: center;font-weight: bold;width: 60px">Placa</th>
                    <th style="text-align: center;font-weight: bold;width: 60px">Cat.</th>
                    <th style="text-align: center;font-weight: bold;width: 60px">Tipo</th>
                    <th style="text-align: center;font-weight: bold;width: 100px">Vigencia</th>
                    <th style="text-align: center;font-weight: bold;width: 60px">Mot.</th>
                    <th style="text-align: center;font-weight: bold;width: 60px">Valor</th>
                </tr>
            </thead>
            <tbody>';

    $tbl2 = '';

    $i = 0;
    $valor = 0;

    foreach ($listagem as $lis) {

        $tbltmp = '
                <tr >
                    <td style="width: 250px;font-size: 10px">' . substr($lis->cliente, 0, 38) . '</td>
                    <td style="text-align: center;width: 60px;font-size: 10px">' . $lis->numero_placa . '</td>
                    <td style="text-align: center;width: 60px;font-size: 10px">' . $lis->tipo_vehiculo . '</td>
                    <td style="text-align: center;width: 60px;font-size: 10px">' . $lis->idservicio . '</td>
                    <td style="text-align: center;width: 100px;font-size: 10px">' . $lis->vigencia . '</td>
                    <td style="text-align: center;width: 60px;font-size: 10px">' . $lis->mot . '</td>
                    <td style="text-align: center;width: 60px;font-size: 10px">$ ' . $lis->valor . '</td>
                </tr>';


        if ($i == 66) {
            $tbltmp = $tbltmp . '
                <tr>
                    <td style="width: 250px;font-size: 10px;border-width: 1px"></td>
                    <td style="text-align: center;width: 60px;font-size: 10px;border-width: 1px"></td>
                    <td style="text-align: center;width: 60px;font-size: 10px;border-width: 1px"></td>
                    <td style="text-align: center;width: 60px;font-size: 10px;border-width: 1px"></td>
                    <td style="text-align: center;width: 30px;font-size: 10px;border-width: 1px"></td>
                    <td style="text-align: center;width: 100px;font-size: 11px;border-width: 1px"><strong>Total acumulado</strong></td>
                    <td style="text-align: center;width: 90px;font-size: 11px;border-width: 1px"><strong>$' . $valor . '</strong></td>
                </tr>';
            $i = -1;
            $valor = 0;
            //$pdf->AddPage();
        }
        $i++;
        $valor = $valor + $lis->valor;
        $tbl2 = $tbl2 . $tbltmp;
    }

    $tbl3 = ' <tr>
                    <td style="width: 250px;font-size: 10px;border-width: 1px"></td>
                    <td style="text-align: center;width: 60px;font-size: 10px;border-width: 1px"></td>
                    <td style="text-align: center;width: 60px;font-size: 10px;border-width: 1px"></td>
                    <td style="text-align: center;width: 60px;font-size: 10px;border-width: 1px"></td>
                    <td style="text-align: center;width: 30px;font-size: 10px;border-width: 1px"></td>
                    <td style="text-align: center;width: 100px;font-size: 11px;border-width: 1px"><strong>Total acumulado</strong></td>
                    <td style="text-align: center;width: 90px;font-size: 11px;border-width: 1px"><strong>$' . $valor . '</strong></td>
                </tr>
            </tbody>
        </table>';

    $tbl = $tbl1 . $tbl2 . $tbl3;

    $pdf->writeHTML($tbl, true, false, false, false, '');
}
$pdf->SetFontSize(8);
$pdf->Write(0, 'Convenciones:', '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, '- Mot: Inspección (Insp), Peritaje (Peri), Preventiva (Prev), Duplicado (Dupl)', '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, '- Cat: Liviano (1), Pesado (2), Moto (3)', '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, '- Tipo: Oficial (1), Público (2), Particular (3), Diplomático (4)', '', 0, 'L', true, 0, false, false, 0);








$pdf->Output($titulo .'_' .$fechageneracion. ".pdf", 'I');

