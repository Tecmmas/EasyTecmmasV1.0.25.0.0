<?php

set_time_limit(0);
ini_set('memory_limit', '-1');
//$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$titulo = "NÃºmero de registro visual: " . $this->session->userdata('idhojapruebas') . "-" . $this->session->userdata('idprueba') . " \nFecha inspeccion: " . $fechafinal . "\nPlaca: " . $this->session->userdata('numero_placa');
$hoy = getdate();
$pdf->SetTitle($titulo);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $nombreCda . " - Mapa de resumen diario de servicio", "Fecha inicial: " . $fechainicial . "            Fecha final: " . $fechafinal . " \nFecha de generacion de este informe: " . $fechageneracion);
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
$fechavalid = "";
$liv = 0;
$pes = 0;
$mot = 0;
$tec1 = 0;
$tec2 = 0;
$prev = 0;
$lib = 0;
$peri = 0;
$dupli = 0;
$totaltipo = 0;

for ($i = $fechai; $i <= $fechaf; $i += 86400) {
    $fecha = date("Y-m-d", $i);
    $resumen = $this->Mestadisticos->resumendiarioservicio($fechainicial, $fechafinal);
    if ($resumen != FALSE) {
        $pdf->AddPage();
        $tbl1 = ' 
        <table >
            <thead>
                <tr >
                <th style="text-align: center;font-weight: bold;width: 200px"><strong>Fecha:' . $fecha . ' </strong></th>
                </tr >
                <tr >
                    <th style="text-align: center;font-weight: bold;width: 50px">Placa</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">Mot.</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">Hora I.</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">Hora F.</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">T. Esp</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">Res.</th>
                    <th style="text-align: center;font-weight: bold;width: 60px">Vigencia</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">Insp.</th>
                    <th style="text-align: center;font-weight: bold;width: 70px">Certifcado</th>
                    <th style="text-align: center;font-weight: bold;width: 50px">Km</th>
                    <th style="text-align: center;font-weight: bold;width: 100px">Cat/Tip/Mar/Mod</th>
                </tr>
            </thead>
            <tbody>';
        $tbl2 = '';
        foreach ($resumen as $lis) {
            if ($lis->fechainicial == $fecha) {
                $fechavalid = $lis->fechainicial;
                if ($lis->tipo_vehiculo == '1') {
                    $liv++;
                }
                if ($lis->tipo_vehiculo == '2') {
                    $pes++;
                }
                if ($lis->tipo_vehiculo == '3') {
                    $mot++;
                }
                if ($lis->reinspeccion == '0') {
                    $tec1++;
                }
                if ($lis->reinspeccion == '1') {
                    $tec2++;
                }
                if ($lis->reinspeccion == '4444' || $lis->reinspeccion == '44441') {
                    $prev++;
                }
                if ($lis->reinspeccion == '8888') {
                    $lib++;
                }
                if ($lis->reinspeccion == '7777') {
                    $peri++;
                }
                if ($lis->reinspeccion == '9999') {
                    $dupli++;
                }
//                $total = $liv + $pes + $mot;
//                $totaltipo = $tec1 + $tec2 + $prev + $lib + $peri + $dupli;
                $tbltmp = '
                <tr >
                    <td style="text-align: center;width: 50px;font-size: 10px">' . $lis->numero_placa . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px">' . $lis->reinspeccion . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px">' . $lis->horainicial . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px">' . $lis->horafinal . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px">' . $lis->tiempoespera . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px">' . $lis->ar . '</td>
                    <td style="text-align: center;width: 60px;font-size: 10px">' . $lis->fecha_vigencia . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px">' . $lis->inspector . '</td>
                    <td style="text-align: center;width: 70px;font-size: 10px">' . $lis->numero_certificado . '</td>
                    <td style="text-align: center;width: 50px;font-size: 10px">' . $lis->kilometraje . '</td>
                    <td style="text-align: center;width: 100px;font-size: 10px">' . $lis->tipo_vehiculo . '-' . $lis->idservicio . '-' . $lis->marca . '-' . $lis->idlinea . '</td>
                </tr>';
                $tbl2 = $tbl2 . $tbltmp;
            }
        }
//        $data['liviano'] = $liv;
//        $liv = 0;

        $tbl3 = ' </tbody>
        </table>';

        $tbl = $tbl1 . $tbl2 . $tbl3;
        $pdf->writeHTML($tbl, true, false, false, false, '');
        $c = 0;
        $data['liviano'] = [];
        if ($fechavalid == $fecha) {
            //tabla 1
            $data['liviano'] = $liv;
            $liv = 0;
            $data['pesado'] = $pes;
            $pes = 0;
            $data['moto'] = $mot;
            $mot = 0;
            $total = $data['liviano'] + $data['pesado'] + $data['moto'];

            $dat1 = '<table border="1" >
                            <thead>
                                <tr >
                                    <th style="text-align: center;font-weight: bold;width: 50px">Liviano</th>
                                    <th style="text-align: center;font-weight: bold;width: 50px">Pesado</th>
                                    <th style="text-align: center;font-weight: bold;width: 50px">Moto</th>
                                    <th style="text-align: center;font-weight: bold;width: 50px">Total</th>
                                </tr>
                            </thead>
                                <tbody>
                                  <tr>
                                    <td style="text-align: center;font-weight: bold;width: 50px"> ' . $data['liviano'] . '</td>
                                    <td style="text-align: center;font-weight: bold;width: 50px"> ' . $data['pesado'] . '</td>
                                    <td style="text-align: center;font-weight: bold;width: 50px"> ' . $data['moto'] . '</td>
                                    <td style="text-align: center;font-weight: bold;width: 50px"> ' . $total . '</td>
                                  </tr>
                                </tbody>
                            </table>';
            $pdf->writeHTML($dat1, true, false, false, false, '');
            $data['tec1'] = $tec1;
            $tec1 = 0;
            $data['tec2'] = $tec2;
            $tec2 = 0;
            $data['lib'] = $lib;
            $lib = 0;
            $data['peri'] = $peri;
            $peri = 0;
            $data['prev'] = $prev;
            $prev = 0;
            $data['dupli'] = $dupli;
            $dupli = 0;
            $totaltipo = $data['tec1'] + $data['tec2'] + $data['lib'] + $data['peri'] + $data['prev'] + $data['dupli'];
            $dat2 = '<table border="1" >
                            <thead>
                                <tr >
                                    <th style="text-align: center;font-weight: bold;width: 60px">Inspeccion</th>
                                    <th style="text-align: center;font-weight: bold;width: 80px">Re inspeccion</th>
                                    <th style="text-align: center;font-weight: bold;width: 70px">Prueba libre</th>
                                    <th style="text-align: center;font-weight: bold;width: 60px">Peritaje</th>
                                    <th style="text-align: center;font-weight: bold;width: 60px">Preventiva</th>
                                    <th style="text-align: center;font-weight: bold;width: 60px">Duplicado</th>
                                    <th style="text-align: center;font-weight: bold;width: 60px">Total</th>
                                </tr>
                            </thead>
                                <tbody>
                                  <tr>
                                   <td style="text-align: center;font-weight: bold;width: 60px">' . $data['tec1'] . '</td>
                                    <td style="text-align: center;font-weight: bold;width: 80px">' . $data['tec2'] . '</td>
                                    <td style="text-align: center;font-weight: bold;width: 70px">' . $data['lib'] . '</td>
                                    <td style="text-align: center;font-weight: bold;width: 60px">' . $data['peri'] . '</td>
                                    <td style="text-align: center;font-weight: bold;width: 60px">' . $data['prev'] . '</td>
                                    <td style="text-align: center;font-weight: bold;width: 60px">' . $data['dupli'] . '</td>
                                    <td style="text-align: center;font-weight: bold;width: 60px">' . $totaltipo . '</td>
                                  </tr>
                                </tbody>
                            </table>';
            $pdf->writeHTML($dat2, true, false, false, false, '');
        }

        $pdf->SetFontSize(8);
        $pdf->Write(0, 'Convenciones:', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '- Mot: Inspección (0), Reinspección (1), Prueba libre (8888), Peritaje (7777), Preventiva (4444), Duplicado (9999)', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '- Res: Aprobada (A), Rechazada (R)', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '- Inspector: Consultar códigos de inspector', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '- Cat: Liviano (1), Pesado (2), Moto (3)', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '- Tipo: Oficial (1), Público (2), Particular (3), Diplomático (4)', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '- Marca: Consultar códigos de marca', '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, '- Modelo: Consultar código de lineas', '', 0, 'L', true, 0, false, false, 0);
    }
}







$pdf->Output($titulo . $fechageneracion . ".pdf", 'I');

