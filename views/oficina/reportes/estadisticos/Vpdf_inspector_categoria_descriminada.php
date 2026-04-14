<?php

set_time_limit(0);
ini_set('memory_limit', '-1');
//$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$titulo = "NÃºmero de registro visual: " . $this->session->userdata('idhojapruebas') . "-" . $this->session->userdata('idprueba') . " \nFecha inspeccion: " . $fechafinal . "\nPlaca: " . $this->session->userdata('numero_placa');
$hoy = getdate();
$pdf->SetTitle($titulo);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $nombreCda . " - Estadástica por inspector/categoria discriminada", "Fecha inicial: " . $fechainicial . "            Fecha final: " . $fechafinal . " \nFecha de generación de este informe: " . $fechageneracion);
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

if ($inspectores != FALSE) {
    $rango = "'" . $fechainicial . "' and '" . $fechafinal . "'";
//TOTAL DEFECTOS CDA
    $total1a = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=1', 'A', $rango);
    $total1b = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=1', 'B', $rango);
    $total1 = $total1a + $total1b;

    $total2a = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=3', 'A', $rango);
    $total2b = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=3', 'B', $rango);
    $total2 = $total2a + $total2b;

    $total3a = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=2', 'A', $rango);
    $total3b = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=2', 'B', $rango);
    $total3 = $total3a + $total3b;

    $total4a = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=4', 'A', $rango);
    $total4b = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=4', 'B', $rango);
    $total4 = $total4a + $total4b;

    $total5a = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=5', 'A', $rango);
    $total5b = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=5', 'B', $rango);
    $total5 = $total5a + $total5b;

    $total6a = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=7', 'A', $rango);
    $total6b = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=7', 'B', $rango);
    $total6 = $total6a + $total6b;

    $total7a = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=8', 'A', $rango);
    $total7b = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=8', 'B', $rango);
    $total7 = $total7a + $total7b;

    $total8a = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=10', 'A', $rango);
    $total8b = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=10', 'B', $rango);
    $total8 = $total8a + $total8b;

    $total9a = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=11', 'A', $rango);
    $total9b = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=11', 'B', $rango);
    $total9 = $total9a + $total9b;

    $total10a = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=24', 'A', $rango);
    $total10b = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto=24', 'B', $rango);
    $total10 = $total10a + $total10b;

    $total11a = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'A', $rango);
    $total11b = $this->Mestadisticos->getTotalNumDefectos('td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'B', $rango);
    $total11 = $total11a + $total11b;

    foreach ($inspectores as $ins) {

        if ($this->Mestadisticos->siDefectos($rango, $ins->idusuario) != 0) {

            $pdf->AddPage();

//DEFECTOS POR TIPO
//EXTERIOR TIPO A
            $lpa1a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=1', 'A', $rango);
            $lpu1a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=1', 'A', $rango);
            $lot1a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=1', 'A', $rango);
            $ppa1a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=1', 'A', $rango);
            $ppu1a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=1', 'A', $rango);
            $pot1a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=1', 'A', $rango);
            $mpa1a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=1', 'A', $rango);
            $mpu1a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=1', 'A', $rango);
            $mot1a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=1', 'A', $rango);
            $rem1a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=1', 'A', $rango);
            $sem1a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=1', 'A', $rango);
            $totalInspector1a = $lpa1a + $lpu1a + $lot1a + $ppa1a + $ppu1a + $pot1a + $mpa1a + $mpu1a + $mot1a + $rem1a + $sem1a;
            if ($total1a <= 0) {
                $total1a = 1;
            }
            $porInsp1a = round(($totalInspector1a / $total1a) * 100) . "%";
//EXTERIOR TIPO B
            $lpa1b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=1', 'B', $rango);
            $lpu1b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=1', 'B', $rango);
            $lot1b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=1', 'B', $rango);
            $ppa1b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=1', 'B', $rango);
            $ppu1b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=1', 'B', $rango);
            $pot1b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=1', 'B', $rango);
            $mpa1b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=1', 'B', $rango);
            $mpu1b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=1', 'B', $rango);
            $mot1b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=1', 'B', $rango);
            $rem1b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=1', 'B', $rango);
            $sem1b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=1', 'B', $rango);
            $totalInspector1b = $lpa1b + $lpu1b + $lot1b + $ppa1b + $ppu1b + $pot1b + $mpa1b + $mpu1b + $mot1b + $rem1b + $sem1b;
            if ($total1b <= 0) {
                $total1b = 1;
            }
            $porInsp1b = round(($totalInspector1b / $total1b) * 100) . "%";
            if ($total1 <= 0) {
                $total1 = 1;
            }
            $porTotal1ab = round((($totalInspector1a + $totalInspector1b) / ($total1)) * 100) . "%";

//INTERIOR TIPO A
            $lpa2a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=3', 'A', $rango);
            $lpu2a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=3', 'A', $rango);
            $lot2a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=3', 'A', $rango);
            $ppa2a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=3', 'A', $rango);
            $ppu2a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=3', 'A', $rango);
            $pot2a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=3', 'A', $rango);
            $mpa2a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=3', 'A', $rango);
            $mpu2a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=3', 'A', $rango);
            $mot2a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=3', 'A', $rango);
            $rem2a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=3', 'A', $rango);
            $sem2a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=3', 'A', $rango);
            $totalInspector2a = $lpa2a + $lpu2a + $lot2a + $ppa2a + $ppu2a + $pot2a + $mpa2a + $mpu2a + $mot2a + $rem2a + $sem2a;
            if ($total2a <= 0) {
                $total2a = 1;
            }
            $porInsp2a = round(($totalInspector2a / $total2a) * 100) . "%";
//INTERIOR TIPO B
            $lpa2b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=3', 'B', $rango);
            $lpu2b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=3', 'B', $rango);
            $lot2b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=3', 'B', $rango);
            $ppa2b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=3', 'B', $rango);
            $ppu2b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=3', 'B', $rango);
            $pot2b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=3', 'B', $rango);
            $mpa2b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=3', 'B', $rango);
            $mpu2b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=3', 'B', $rango);
            $mot2b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=3', 'B', $rango);
            $rem2b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=3', 'B', $rango);
            $sem2b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=3', 'B', $rango);
            $totalInspector2b = $lpa2b + $lpu2b + $lot2b + $ppa2b + $ppu2b + $pot2b + $mpa2b + $mpu2b + $mot2b + $rem2b + $sem2b;
            if ($total2b <= 0) {
                $total2b = 1;
            }
            $porInsp2b = round(($totalInspector2b / $total2b) * 100) . "%";
            if ($total2 <= 0) {
                $total2 = 1;
            }
            $porTotal2ab = round((($totalInspector2a + $totalInspector2b) / ($total2)) * 100) . "%";

//VIDRIOS TIPO A
            $lpa3a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=2', 'A', $rango);
            $lpu3a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=2', 'A', $rango);
            $lot3a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=2', 'A', $rango);
            $ppa3a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=2', 'A', $rango);
            $ppu3a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=2', 'A', $rango);
            $pot3a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=2', 'A', $rango);
            $mpa3a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=2', 'A', $rango);
            $mpu3a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=2', 'A', $rango);
            $mot3a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=2', 'A', $rango);
            $rem3a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=2', 'A', $rango);
            $sem3a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=2', 'A', $rango);
            $totalInspector3a = $lpa3a + $lpu3a + $lot3a + $ppa3a + $ppu3a + $pot3a + $mpa3a + $mpu3a + $mot3a + $rem3a + $sem3a;
            if ($total3a <= 0) {
                $total3a = 1;
            }
            $porInsp3a = round(($totalInspector3a / $total3a) * 100) . "%";
//VIDRIOS TIPO B
            $lpa3b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=2', 'B', $rango);
            $lpu3b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=2', 'B', $rango);
            $lot3b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=2', 'B', $rango);
            $ppa3b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=2', 'B', $rango);
            $ppu3b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=2', 'B', $rango);
            $pot3b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=2', 'B', $rango);
            $mpa3b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=2', 'B', $rango);
            $mpu3b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=2', 'B', $rango);
            $mot3b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=2', 'B', $rango);
            $rem3b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=2', 'B', $rango);
            $sem3b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=2', 'B', $rango);
            $totalInspector3b = $lpa3b + $lpu3b + $lot3b + $ppa3b + $ppu3b + $pot3b + $mpa3b + $mpu3b + $mot3b + $rem3b + $sem3b;
            if ($total3b <= 0) {
                $total3b = 1;
            }
            $porInsp3b = round(($totalInspector3b / $total3b) * 100) . "%";
            if ($total3 <= 0) {
                $total3 = 1;
            }
            $porTotal3ab = round((($totalInspector3a + $totalInspector3b) / ($total3)) * 100) . "%";

//EMISIONES TIPO A
            $lpa4a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=4', 'A', $rango);
            $lpu4a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=4', 'A', $rango);
            $lot4a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=4', 'A', $rango);
            $ppa4a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=4', 'A', $rango);
            $ppu4a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=4', 'A', $rango);
            $pot4a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=4', 'A', $rango);
            $mpa4a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=4', 'A', $rango);
            $mpu4a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=4', 'A', $rango);
            $mot4a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=4', 'A', $rango);
            $rem4a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=4', 'A', $rango);
            $sem4a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=4', 'A', $rango);
            $totalInspector4a = $lpa4a + $lpu4a + $lot4a + $ppa4a + $ppu4a + $pot4a + $mpa4a + $mpu4a + $mot4a + $rem4a + $sem4a;
            if ($total4a <= 0) {
                $total4a = 1;
            }
            $porInsp4a = round(($totalInspector4a / $total4a) * 100) . "%";
//EMISIONES TIPO B
            $lpa4b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=4', 'B', $rango);
            $lpu4b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=4', 'B', $rango);
            $lot4b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=4', 'B', $rango);
            $ppa4b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=4', 'B', $rango);
            $ppu4b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=4', 'B', $rango);
            $pot4b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=4', 'B', $rango);
            $mpa4b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=4', 'B', $rango);
            $mpu4b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=4', 'B', $rango);
            $mot4b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=4', 'B', $rango);
            $rem4b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=4', 'B', $rango);
            $sem4b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=4', 'B', $rango);
            $totalInspector4b = $lpa4b + $lpu4b + $lot4b + $ppa4b + $ppu4b + $pot4b + $mpa4b + $mpu4b + $mot4b + $rem4b + $sem4b;
            if ($total4b <= 0) {
                $total4b = 1;
            }
            $porInsp4b = round(($totalInspector4b / $total4b) * 100) . "%";
            if ($total4 <= 0) {
                $total4 = 1;
            }
            $porTotal4ab = round((($totalInspector4a + $totalInspector4b) / ($total4)) * 100) . "%";

//LUCES TIPO A
            $lpa5a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=5', 'A', $rango);
            $lpu5a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=5', 'A', $rango);
            $lot5a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=5', 'A', $rango);
            $ppa5a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=5', 'A', $rango);
            $ppu5a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=5', 'A', $rango);
            $pot5a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=5', 'A', $rango);
            $mpa5a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=5', 'A', $rango);
            $mpu5a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=5', 'A', $rango);
            $mot5a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=5', 'A', $rango);
            $rem5a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=5', 'A', $rango);
            $sem5a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=5', 'A', $rango);
            $totalInspector5a = $lpa5a + $lpu5a + $lot5a + $ppa5a + $ppu5a + $pot5a + $mpa5a + $mpu5a + $mot5a + $rem5a + $sem5a;
            if ($total5a <= 0) {
                $total5a = 1;
            }
            $porInsp5a = round(($totalInspector5a / $total5a) * 100) . "%";
//LUCES TIPO B
            $lpa5b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=5', 'B', $rango);
            $lpu5b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=5', 'B', $rango);
            $lot5b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=5', 'B', $rango);
            $ppa5b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=5', 'B', $rango);
            $ppu5b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=5', 'B', $rango);
            $pot5b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=5', 'B', $rango);
            $mpa5b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=5', 'B', $rango);
            $mpu5b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=5', 'B', $rango);
            $mot5b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=5', 'B', $rango);
            $rem5b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=5', 'B', $rango);
            $sem5b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=5', 'B', $rango);
            $totalInspector5b = $lpa5b + $lpu5b + $lot5b + $ppa5b + $ppu5b + $pot5b + $mpa5b + $mpu5b + $mot5b + $rem5b + $sem5b;
            if ($total5b <= 0) {
                $total5b = 1;
            }
            $porInsp5b = round(($totalInspector5b / $total5b) * 100) . "%";
            if ($total5 <= 0) {
                $total5 = 1;
            }
            $porTotal5ab = round((($totalInspector5a + $totalInspector5b) / ($total5)) * 100) . "%";

//FRENOS TIPO A
            $lpa6a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=7', 'A', $rango);
            $lpu6a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=7', 'A', $rango);
            $lot6a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=7', 'A', $rango);
            $ppa6a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=7', 'A', $rango);
            $ppu6a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=7', 'A', $rango);
            $pot6a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=7', 'A', $rango);
            $mpa6a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=7', 'A', $rango);
            $mpu6a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=7', 'A', $rango);
            $mot6a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=7', 'A', $rango);
            $rem6a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=7', 'A', $rango);
            $sem6a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=7', 'A', $rango);
            $totalInspector6a = $lpa6a + $lpu6a + $lot6a + $ppa6a + $ppu6a + $pot6a + $mpa6a + $mpu6a + $mot6a + $rem6a + $sem6a;
            if ($total6a <= 0) {
                $total6a = 1;
            }
            $porInsp6a = round(($totalInspector6a / $total6a) * 100) . "%";
//FRENOS TIPO B
            $lpa6b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=7', 'B', $rango);
            $lpu6b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=7', 'B', $rango);
            $lot6b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=7', 'B', $rango);
            $ppa6b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=7', 'B', $rango);
            $ppu6b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=7', 'B', $rango);
            $pot6b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=7', 'B', $rango);
            $mpa6b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=7', 'B', $rango);
            $mpu6b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=7', 'B', $rango);
            $mot6b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=7', 'B', $rango);
            $rem6b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=7', 'B', $rango);
            $sem6b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=7', 'B', $rango);
            $totalInspector6b = $lpa6b + $lpu6b + $lot6b + $ppa6b + $ppu6b + $pot6b + $mpa6b + $mpu6b + $mot6b + $rem6b + $sem6b;
            if ($total6b <= 0) {
                $total6b = 1;
            }
            $porInsp6b = round(($totalInspector6b / $total6b) * 100) . "%";
            if ($total6 <= 0) {
                $total6 = 1;
            }
            $porTotal6ab = round((($totalInspector6a + $totalInspector6b) / ($total6)) * 100) . "%";

//SUSPENSION TIPO A
            $lpa7a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=8', 'A', $rango);
            $lpu7a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=8', 'A', $rango);
            $lot7a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=8', 'A', $rango);
            $ppa7a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=8', 'A', $rango);
            $ppu7a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=8', 'A', $rango);
            $pot7a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=8', 'A', $rango);
            $mpa7a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=8', 'A', $rango);
            $mpu7a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=8', 'A', $rango);
            $mot7a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=8', 'A', $rango);
            $rem7a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=8', 'A', $rango);
            $sem7a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=8', 'A', $rango);
            $totalInspector7a = $lpa7a + $lpu7a + $lot7a + $ppa7a + $ppu7a + $pot7a + $mpa7a + $mpu7a + $mot7a + $rem7a + $sem7a;
            if ($total7a <= 0) {
                $total7a = 1;
            }
            $porInsp7a = round(($totalInspector7a / $total7a) * 100) . "%";
//SUSPENSION TIPO B
            $lpa7b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=8', 'B', $rango);
            $lpu7b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=8', 'B', $rango);
            $lot7b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=8', 'B', $rango);
            $ppa7b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=8', 'B', $rango);
            $ppu7b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=8', 'B', $rango);
            $pot7b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=8', 'B', $rango);
            $mpa7b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=8', 'B', $rango);
            $mpu7b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=8', 'B', $rango);
            $mot7b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=8', 'B', $rango);
            $rem7b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=8', 'B', $rango);
            $sem7b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=8', 'B', $rango);
            $totalInspector7b = $lpa7b + $lpu7b + $lot7b + $ppa7b + $ppu7b + $pot7b + $mpa7b + $mpu7b + $mot7b + $rem7b + $sem7b;
            if ($total7b <= 0) {
                $total7b = 1;
            }
            $porInsp7b = round(($totalInspector7b / $total7b) * 100) . "%";
            if ($total7 <= 0) {
                $total7 = 1;
            }
            $porTotal7ab = round((($totalInspector7a + $totalInspector7b) / ($total7)) * 100) . "%";

//DIRECCION TIPO A
            $lpa8a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=10', 'A', $rango);
            $lpu8a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=10', 'A', $rango);
            $lot8a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=10', 'A', $rango);
            $ppa8a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=10', 'A', $rango);
            $ppu8a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=10', 'A', $rango);
            $pot8a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=10', 'A', $rango);
            $mpa8a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=10', 'A', $rango);
            $mpu8a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=10', 'A', $rango);
            $mot8a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=10', 'A', $rango);
            $rem8a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=10', 'A', $rango);
            $sem8a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=10', 'A', $rango);
            $totalInspector8a = $lpa8a + $lpu8a + $lot8a + $ppa8a + $ppu8a + $pot8a + $mpa8a + $mpu8a + $mot8a + $rem8a + $sem8a;
            if ($total8a <= 0) {
                $total8a = 1;
            }
            $porInsp8a = round(($totalInspector8a / $total8a) * 100) . "%";
//DIRECCION TIPO B
            $lpa8b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=10', 'B', $rango);
            $lpu8b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=10', 'B', $rango);
            $lot8b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=10', 'B', $rango);
            $ppa8b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=10', 'B', $rango);
            $ppu8b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=10', 'B', $rango);
            $pot8b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=10', 'B', $rango);
            $mpa8b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=10', 'B', $rango);
            $mpu8b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=10', 'B', $rango);
            $mot8b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=10', 'B', $rango);
            $rem8b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=10', 'B', $rango);
            $sem8b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=10', 'B', $rango);
            $totalInspector8b = $lpa8b + $lpu8b + $lot8b + $ppa8b + $ppu8b + $pot8b + $mpa8b + $mpu8b + $mot8b + $rem8b + $sem8b;
            if ($total8b <= 0) {
                $total8b = 1;
            }
            $porInsp8b = round(($totalInspector8b / $total8b) * 100) . "%";
            if ($total8 <= 0) {
                $total8 = 1;
            }
            $porTotal8ab = round((($totalInspector8a + $totalInspector8b) / ($total8)) * 100) . "%";

//RINES Y LLANTAS TIPO A
            $lpa9a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=11', 'A', $rango);
            $lpu9a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=11', 'A', $rango);
            $lot9a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=11', 'A', $rango);
            $ppa9a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=11', 'A', $rango);
            $ppu9a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=11', 'A', $rango);
            $pot9a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=11', 'A', $rango);
            $mpa9a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=11', 'A', $rango);
            $mpu9a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=11', 'A', $rango);
            $mot9a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=11', 'A', $rango);
            $rem9a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=11', 'A', $rango);
            $sem9a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=11', 'A', $rango);
            $totalInspector9a = $lpa9a + $lpu9a + $lot9a + $ppa9a + $ppu9a + $pot9a + $mpa9a + $mpu9a + $mot9a + $rem9a + $sem9a;
            if ($total9a <= 0) {
                $total9a = 1;
            }
            $porInsp9a = round(($totalInspector9a / $total9a) * 100) . "%";
//RINES Y LLANTAS TIPO B
            $lpa9b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=11', 'B', $rango);
            $lpu9b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=11', 'B', $rango);
            $lot9b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=11', 'B', $rango);
            $ppa9b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=11', 'B', $rango);
            $ppu9b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=11', 'B', $rango);
            $pot9b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=11', 'B', $rango);
            $mpa9b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=11', 'B', $rango);
            $mpu9b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=11', 'B', $rango);
            $mot9b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=11', 'B', $rango);
            $rem9b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=11', 'B', $rango);
            $sem9b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=11', 'B', $rango);
            $totalInspector9b = $lpa9b + $lpu9b + $lot9b + $ppa9b + $ppu9b + $pot9b + $mpa9b + $mpu9b + $mot9b + $rem9b + $sem9b;
            if ($total9b <= 0) {
                $total9b = 1;
            }
            $porInsp9b = round(($totalInspector9b / $total9b) * 100) . "%";
            if ($total9 <= 0) {
                $total9 = 1;
            }
            $porTotal9ab = round((($totalInspector9a + $totalInspector9b) / ($total9)) * 100) . "%";

//ALINEACION TIPO A
            $lpa10a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=24', 'A', $rango);
            $lpu10a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=24', 'A', $rango);
            $lot10a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=24', 'A', $rango);
            $ppa10a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=24', 'A', $rango);
            $ppu10a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=24', 'A', $rango);
            $pot10a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=24', 'A', $rango);
            $mpa10a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=24', 'A', $rango);
            $mpu10a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=24', 'A', $rango);
            $mot10a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=24', 'A', $rango);
            $rem10a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=24', 'A', $rango);
            $sem10a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=24', 'A', $rango);
            $totalInspector10a = $lpa10a + $lpu10a + $lot10a + $ppa10a + $ppu10a + $pot10a + $mpa10a + $mpu10a + $mot10a + $rem10a + $sem10a;
            if ($total10a <= 0) {
                $total10a = 1;
            }
            $porInsp10a = round(($totalInspector10a / $total10a) * 100) . "%";
//ALINEACION TIPO B
            $lpa10b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto=24', 'B', $rango);
            $lpu10b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto=24', 'B', $rango);
            $lot10b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=24', 'B', $rango);
            $ppa10b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto=24', 'B', $rango);
            $ppu10b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto=24', 'B', $rango);
            $pot10b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=24', 'B', $rango);
            $mpa10b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto=24', 'B', $rango);
            $mpu10b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto=24', 'B', $rango);
            $mot10b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto=24', 'B', $rango);
            $rem10b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto=24', 'B', $rango);
            $sem10b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto=24', 'B', $rango);
            $totalInspector10b = $lpa10b + $lpu10b + $lot10b + $ppa10b + $ppu10b + $pot10b + $mpa10b + $mpu10b + $mot10b + $rem10b + $sem10b;
            if ($total10b <= 0) {
                $total10b = 1;
            }
            $porInsp10b = round(($totalInspector10b / $total10b) * 100) . "%";
            if ($total10 <= 0) {
                $total10 = 1;
            }
            $porTotal10ab = round((($totalInspector10a + $totalInspector10b) / ($total10)) * 100) . "%";

//OTROS TIPO A
            $lpa11a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'A', $rango);
            $lpu11a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'A', $rango);
            $lot11a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'A', $rango);
            $ppa11a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'A', $rango);
            $ppu11a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'A', $rango);
            $pot11a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'A', $rango);
            $mpa11a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'A', $rango);
            $mpu11a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'A', $rango);
            $mot11a = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'A', $rango);
            $rem11a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'A', $rango);
            $sem11a = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'A', $rango);
            $totalInspector11a = $lpa11a + $lpu11a + $lot11a + $ppa11a + $ppu11a + $pot11a + $mpa11a + $mpu11a + $mot11a + $rem11a + $sem11a;
            if ($total11a <= 0) {
                $total11a = 1;
            }
            $porInsp11a = round(($totalInspector11a / $total11a) * 100) . "%";
//OTROS TIPO B
            $lpa11b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=3', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'B', $rango);
            $lpu11b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio=2', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'B', $rango);
            $lot11b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '1', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'B', $rango);
            $ppa11b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=3', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'B', $rango);
            $ppu11b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio=2', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'B', $rango);
            $pot11b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '2', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'B', $rango);
            $mpa11b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=3', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'B', $rango);
            $mpu11b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio=2', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'B', $rango);
            $mot11b = $this->Mestadisticos->getNumDefectos($ins->idusuario, '3', 'v.idservicio!=2 and v.idservicio!=3', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'B', $rango);
            $rem11b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '15', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'B', $rango);
            $sem11b = $this->Mestadisticos->getNumDefectosRemolque($ins->idusuario, '13', 'td.id_tipo_defecto!=24 and td.id_tipo_defecto!=11 and td.id_tipo_defecto!=10 and td.id_tipo_defecto!= 8 and td.id_tipo_defecto!=7 and td.id_tipo_defecto!=5 and td.id_tipo_defecto!=4 and td.id_tipo_defecto!=2 and td.id_tipo_defecto!=3 and td.id_tipo_defecto!=1', 'B', $rango);
            $totalInspector11b = $lpa11b + $lpu11b + $lot11b + $ppa11b + $ppu11b + $pot11b + $mpa11b + $mpu11b + $mot11b + $rem11b + $sem11b;
            if ($total11b <= 0) {
                $total11b = 1;
            }
            $porInsp11b = round(($totalInspector11b / $total11b) * 100) . "%";
            if ($total11 <= 0) {
                $total11 = 1;
            }
            $porTotal11ab = round((($totalInspector11a + $totalInspector11b) / ($total11)) * 100) . "%";

            $tbl1 = ' <br/><br/><br/>
        <table >
            <thead>
                <tr >
                    <th style="font-weight: bold;width: 150px"><strong>INSPECTOR: ' . $ins->user . ' </strong></th>
                    <th style="text-align: center;vertical-align: middle;width: 792px;font-weight: bold;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"><strong>Número de defectos de tipo A y B marcados</strong></th>
                </tr>
                <tr >
                    <th style="font-weight: bold;width: 150px"></th>
                    <th style="text-align: center;vertical-align: middle;width: 72px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Exterior</th>
                    <th style="text-align: center;vertical-align: middle;width: 72px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Interior</th>
                    <th style="text-align: center;vertical-align: middle;width: 72px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Vidrios</th>
                    <th style="text-align: center;vertical-align: middle;width: 72px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Emisiones</th>
                    <th style="text-align: center;vertical-align: middle;width: 72px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Luces</th>
                    <th style="text-align: center;vertical-align: middle;width: 72px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Frenos</th>
                    <th style="text-align: center;vertical-align: middle;width: 72px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Suspensión</th>
                    <th style="text-align: center;vertical-align: middle;width: 72px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Dirección</th>
                    <th style="font-size:10px;text-align: center;vertical-align: middle;width: 72px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Rines y llantas</th>
                    <th style="text-align: center;vertical-align: middle;width: 72px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Alineación</th>
                    <th style="text-align: center;vertical-align: middle;width: 72px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">Otros</th>
                </tr>
                <tr >
                    <th style="font-weight: bold;width: 150px"></th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">A</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">B</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">A</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">B</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">A</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">B</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">A</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">B</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">A</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">B</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">A</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">B</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">A</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">B</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">A</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">B</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">A</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">B</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">A</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">B</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">A</th>
                    <th style="text-align: center;vertical-align: middle;width: 36px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px">B</th>
                </tr>
                
            </thead>
            <tbody>';

            $tbl2 = '
        <tr >
            <td style="width: 942px;font-weight: bold;border-width: 1px;border-left-width: 1px;border-right-width: 1px"><strong> Livianos</strong></td>
        </tr>
        <tr >
            <td style="width: 75px;border-left-width: 1px"></td>
            <td style="width: 75px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"> Particulares</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpa1a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpa1b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpa2a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpa2b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpa3a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpa3b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpa4a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpa4b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpa5a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpa5b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpa6a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpa6b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpa7a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpa7b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpa8a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpa8b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpa9a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpa9b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpa10a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpa10b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpa11a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpa11b . '</td>
        </tr>
        <tr >
            <td style="width: 75px;border-left-width: 1px"></td>
            <td style="width: 75px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"> Públicos</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpu1a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpu1b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpu2a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpu2b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpu3a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpu3b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpu4a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpu4b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpu5a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpu5b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpu6a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpu6b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpu7a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpu7b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpu8a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpu8b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpu9a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpu9b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpu10a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpu10b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lpu11a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lpu11b . '</td>
        </tr>
        <tr >
            <td style="width: 75px;border-left-width: 1px"></td>
            <td style="width: 75px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"> Otros</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lot1a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lot1b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lot2a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lot2b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lot3a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lot3b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lot4a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lot4b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lot5a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lot5b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lot6a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lot6b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lot7a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lot7b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lot8a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lot8b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lot9a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lot9b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lot10a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lot10b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $lot11a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $lot11b . '</td>
        </tr>
        <tr >
            <td style="width: 942px;font-weight: bold;border-width: 1px;border-left-width: 1px;border-right-width: 1px"><strong> Pesados</strong></td>
        </tr>
        <tr >
            <td style="width: 75px;border-left-width: 1px"></td>
            <td style="width: 75px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"> Particulares</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppa1a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppa1b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppa2a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppa2b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppa3a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppa3b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppa4a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppa4b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppa5a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppa5b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppa6a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppa6b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppa7a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppa7b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppa8a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppa8b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppa9a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppa9b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppa10a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppa10b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppa11a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppa11b . '</td>
        </tr>
        <tr >
            <td style="width: 75px;border-left-width: 1px"></td>
            <td style="width: 75px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"> Públicos</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppu1a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppu1b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppu2a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppu2b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppu3a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppu3b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppu4a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppu4b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppu5a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppu5b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppu6a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppu6b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppu7a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppu7b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppu8a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppu8b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppu9a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppu9b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppu10a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppu10b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $ppu11a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $ppu11b . '</td>
        </tr>
        <tr >
            <td style="width: 75px;border-left-width: 1px"></td>
            <td style="width: 75px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"> Otros</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $pot1a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $pot1b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $pot2a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $pot2b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $pot3a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $pot3b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $pot4a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $pot4b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $pot5a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $pot5b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $pot6a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $pot6b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $pot7a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $pot7b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $pot8a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $pot8b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $pot9a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $pot9b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $pot10a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $pot10b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $pot11a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $pot11b . '</td>
        </tr>
        <tr >
            <td style="width: 942px;font-weight: bold;border-width: 1px;border-left-width: 1px;border-right-width: 1px"><strong> Motos</strong></td>
        </tr>
        <tr >
            <td style="width: 75px;border-left-width: 1px"></td>
            <td style="width: 75px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"> Particulares</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpa1a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpa1b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpa2a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpa2b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpa3a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpa3b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpa4a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpa4b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpa5a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpa5b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpa6a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpa6b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpa7a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpa7b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpa8a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpa8b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpa9a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpa9b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpa10a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpa10b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpa11a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpa11b . '</td>
        </tr>
        <tr >
            <td style="width: 75px;border-left-width: 1px"></td>
            <td style="width: 75px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"> Públicos</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpu1a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpu1b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpu2a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpu2b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpu3a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpu3b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpu4a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpu4b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpu5a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpu5b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpu6a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpu6b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpu7a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpu7b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpu8a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpu8b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpu9a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpu9b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpu10a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpu10b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mpu11a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mpu11b . '</td>
        </tr>
        <tr >
            <td style="width: 75px;border-left-width: 1px"></td>
            <td style="width: 75px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"> Otros</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mot1a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mot1b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mot2a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mot2b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mot3a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mot3b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mot4a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mot4b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mot5a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mot5b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mot6a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mot6b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mot7a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mot7b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mot8a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mot8b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mot9a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mot9b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mot10a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mot10b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $mot11a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $mot11b . '</td>
        </tr>
        <tr >
            <td style="width: 942px;font-weight: bold;border-width: 1px;border-left-width: 1px;border-right-width: 1px"><strong> Remolques</strong></td>
        </tr>
        <tr >
            <td style="width: 75px;border-left-width: 1px"></td>
            <td style="width: 75px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"> Todo tipo</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $rem1a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $rem1b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $rem2a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $rem2b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $rem3a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $rem3b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $rem4a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $rem4b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $rem5a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $rem5b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $rem6a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $rem6b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $rem7a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $rem7b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $rem8a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $rem8b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $rem9a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $rem9b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $rem10a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $rem10b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $rem11a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $rem11b . '</td>
        </tr>
        <tr >
            <td style="width: 942px;font-weight: bold;border-width: 1px;border-left-width: 1px;border-right-width: 1px"><strong> Semi-Remolques</strong></td>
        </tr>
        <tr >
            <td style="width: 75px;border-left-width: 1px;border-bottom-width: 1px"></td>
            <td style="width: 75px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"> Todo tipo</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $sem1a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $sem1b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $sem2a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $sem2b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $sem3a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $sem3b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $sem4a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $sem4b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $sem5a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $sem5b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $sem6a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $sem6b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $sem7a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $sem7b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $sem8a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $sem8b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $sem9a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $sem9b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $sem10a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $sem10b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $sem11a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $sem11b . '</td>
        </tr>
        
<br/>
<br/>

        <tr >
            <td style="width: 50px"></td>
            <td style="width: 100px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"> <strong>Total Inspector</strong></td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $totalInspector1a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $totalInspector1b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $totalInspector2a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $totalInspector2b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $totalInspector3a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $totalInspector3b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $totalInspector4a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $totalInspector4b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $totalInspector5a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $totalInspector5b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $totalInspector6a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $totalInspector6b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $totalInspector7a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $totalInspector7b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $totalInspector8a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $totalInspector8b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $totalInspector9a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $totalInspector9b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $totalInspector10a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $totalInspector10b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $totalInspector11a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $totalInspector11b . '</td>
        </tr>
<br/>
        <tr >
            <td style="width: 50px"></td>
            <td style="width: 100px;border-width: 1px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"> <strong>Total CDA</strong></td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $total1a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $total1b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $total2a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $total2b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $total3a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $total3b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $total4a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $total4b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $total5a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $total5b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $total6a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $total6b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $total7a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $total7b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $total8a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $total8b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $total9a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $total9b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $total10a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $total10b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px">' . $total11a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $total11b . '</td>
        </tr>
<br/>
        <tr >
            <td style="width: 50px"></td>
            <td style="width: 100px;border-width: 1px;border-left-width: 1px;border-right-width: 1px"> <strong>Porcentaje con</strong></td>
            <td style="text-align: center;width: 36px;border-width: 1px">' . $porInsp1a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-right-width: 1px">' . $porInsp1b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px">' . $porInsp2a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-right-width: 1px">' . $porInsp2b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px">' . $porInsp3a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-right-width: 1px">' . $porInsp3b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px">' . $porInsp4a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-right-width: 1px">' . $porInsp4b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px">' . $porInsp5a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-right-width: 1px">' . $porInsp5b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px">' . $porInsp6a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-right-width: 1px">' . $porInsp6b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px">' . $porInsp7a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-right-width: 1px">' . $porInsp7b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px">' . $porInsp8a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-right-width: 1px">' . $porInsp8b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px">' . $porInsp9a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-right-width: 1px">' . $porInsp9b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px">' . $porInsp10a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-right-width: 1px">' . $porInsp10b . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px">' . $porInsp11a . '</td>
            <td style="text-align: center;width: 36px;border-width: 1px;border-right-width: 1px">' . $porInsp11b . '</td>
        </tr>
        <tr >
            <td style="width: 50px"></td>
            <td style="width: 100px;border-left-width: 1px;border-bottom-width: 1px;border-right-width: 1px"> <strong>relación al CDA</strong></td>
            <td style="text-align: center;width: 72px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $porTotal1ab . '</td>
            <td style="text-align: center;width: 72px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $porTotal2ab . '</td>
            <td style="text-align: center;width: 72px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $porTotal3ab . '</td>
            <td style="text-align: center;width: 72px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $porTotal4ab . '</td>
            <td style="text-align: center;width: 72px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $porTotal5ab . '</td>
            <td style="text-align: center;width: 72px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $porTotal6ab . '</td>
            <td style="text-align: center;width: 72px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $porTotal7ab . '</td>
            <td style="text-align: center;width: 72px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $porTotal8ab . '</td>
            <td style="text-align: center;width: 72px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $porTotal9ab . '</td>
            <td style="text-align: center;width: 72px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $porTotal10ab . '</td>
            <td style="text-align: center;width: 72px;border-width: 1px;border-bottom-width: 1px;border-right-width: 1px">' . $porTotal11ab . '</td>
        </tr>
        ';

            $tbl3 = ' </tbody>
        </table>';

            $tbl = $tbl1 . $tbl2 . $tbl3;

            $pdf->writeHTML($tbl, true, false, false, false, '');
        }
    }
}



$pdf->Output($titulo . '_' . $fechageneracion . ".pdf", 'I');

