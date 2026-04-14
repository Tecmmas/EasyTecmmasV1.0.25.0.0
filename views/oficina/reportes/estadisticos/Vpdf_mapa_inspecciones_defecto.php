<?php

set_time_limit(0);
ini_set('memory_limit', '-1');
//$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$titulo = "NÃºmero de registro visual: " . $this->session->userdata('idhojapruebas') . "-" . $this->session->userdata('idprueba') . " \nFecha inspeccion: " . $fechafinal . "\nPlaca: " . $this->session->userdata('numero_placa');
$hoy = getdate();
$pdf->SetTitle($titulo);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $nombreCda . " - Mapa de inspecciones por defecto", "Fecha inicial: " . $fechainicial . "            Fecha final: " . $fechafinal . " \nFecha de generación de este informe: ".$fechageneracion);
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
if ($inspecciones != false) {
    $tbl1 = ' 
        <table >
            <thead>
                <tr >
                    <th style="text-align: center;font-weight: bold;width: 70px">Placa</th>
                    <th style="text-align: center;font-weight: bold;width: 80px">Fecha</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">Mot.</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">Res.</th>
                    <th style="text-align: center;font-weight: bold;width: 60px">Inspector</th>
                    <th style="text-align: center;font-weight: bold;width: 80px">Certificado</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">Cat.</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">Tipo</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">Comb.</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">Marca</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">Modelo</th>
                </tr>
            </thead>
            <tbody>';

    $tbl2 = '';
    $idprueba = "";
    foreach ($inspecciones as $lis) {
        $tbltmp = '
                <tr >
                    <td style="text-align: center;width: 70px">' . $lis->placa . '</td>
                    <td style="text-align: center;width: 80px">' . $lis->fecha . '</td>
                    <td style="text-align: center;width: 50px">' . $lis->motivo . '</td>
                    <td style="text-align: center;width: 50px">' . $lis->resultado . '</td>
                    <td style="text-align: center;width: 50px">' . $lis->inspector . '</td>
                    <td style="text-align: center;width: 90px">' . $lis->no_certificado . '</td>
                    <td style="text-align: center;width: 50px">' . $lis->cat . '</td>
                    <td style="text-align: center;width: 50px">' . $lis->tipo . '</td>
                    <td style="text-align: center;width: 50px">' . $lis->comb . '</td>
                    <td style="text-align: center;width: 50px">' . $lis->marca . '</td>
                    <td style="text-align: center;width: 50px">' . $lis->modelo . '</td>
                </tr>';
        $idprueba = $lis->prueba;
        $defectos = $this->Mestadisticos->defectos($idprueba);
        $tbltmp = $tbltmp . '
                <tr >
                    <td style="text-align: center;width: 30px;font-weight: bold;font-size:10px"></td>
                    <td style="text-align: center;width: 50px;font-weight: bold;font-size:10px"><i>Código</i></td>
                    <td style="text-align: left;width: 500px;font-weight: bold;font-size:10px"><i>Descripción</i></td>
                    <td style="text-align: center;width: 50px;font-weight: bold;font-size:10px"><i>Tipo</i></td>
                </tr>';

        foreach ($defectos as $def) {
            $tbltmp = $tbltmp . '
                <tr >
                    <td style="text-align: center;width: 30px;font-size:10px"></td>
                    <td style="text-align: center;width: 50px;font-size:10px"><i>' . $def->codigo . '</i></td>
                    <td style="text-align: left;width: 500px;font-size:10px"><i>' . $def->descripcion . '</i></td>
                    <td style="text-align: center;width: 50px;font-size:10px"><i>' . $def->tipo . '</i></td>
                </tr>';
        }


        $tbl2 = $tbl2 . $tbltmp;
    }

    $tbl3 = ' </tbody>
        </table>';

    $tbl = $tbl1 . $tbl2 . $tbl3;

    $pdf->writeHTML($tbl, true, false, false, false, '');
}
$pdf->Ln();

$pdf->SetFontSize(10);
$pdf->Write(0, 'Convenciones:', '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, '- Mot: Inspección (0), Reinspección (1), Prueba libre (8888), Peritaje (7777), Preventiva (4444)', '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, '- Res: Aprobada (A), Rechazada (R)', '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, '- Inspector: Consultar códigos de inspector', '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, '- Cat: Liviano (1), Pesado (2), Moto (3)', '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, '- Tipo: Oficial (1), Público (2), Particular (3), Diplomático (4)', '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, '- Comb: Diesel (1), Gasolina(2), Gas-Gasolina(4)', '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, '- Marca: Consultar códigos de marca', '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, '- Modelo: Consultar código de lineas', '', 0, 'L', true, 0, false, false, 0);





$pdf->Output($titulo. $fechageneracion . ".pdf", 'I');

