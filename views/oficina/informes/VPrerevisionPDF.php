<?php

class MyTCPDF extends TCPDF {

    var $htmlHeader;
    var $fechaAprobacionPre;
    var $versionPre;

    public function setHtmlHeader($htmlHeader) {
        $this->htmlHeader = $htmlHeader;
    }

    public function setHtmlFooter($fechaAprobacionPre, $versionPre) {
        $this->fechaAprobacionPre = $fechaAprobacionPre;
        $this->versionPre = $versionPre;
    }

    public function Header() {
        $this->writeHTMLCell(
                $w = 0, $h = 0, $x = '', $y = '', $this->htmlHeader, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
    }

    public function Footer() {
        $this->SetFont('helvetica', 'I', 8);
        if ($this->fechaAprobacionPre == "") {
            $this->SetY(-15);
            $this->Cell(0, 10, $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(),
                    0, false, 'R', 0, '', 0, false, 'T', 'M');
        } else {
            $this->SetY(-20);
            $this->writeHTML('<table><tr><td width="460px"></td><td><table  border="1" style="text-align:center" nobr="true"><tr><td width="105px"><strong>Versión</strong></td><td width="80px">' . $this->versionPre . '</td></tr><tr><td><strong>Fecha de aprobación</strong></td><td>' . $this->fechaAprobacionPre . '</td></tr><tr><td><strong>Páginas</strong></td><td>' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages() . '</td></tr></table></td></tr></table>', false, true, false, true, 'R');
        }
    }

}

$pdf = new MyTCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$titulo = "PRE-REVISIÓN VEHICULOS - CODIGO: P.IV.002-R1 - VERSION: 7 - FECHA: 2019/07/30";
//$logo = "data:image/jpg;base64," . base64_encode($cda->logo);
//$logo = $pdf->Image('@' . $logo);
//$pdf->SetHeaderData($logo, PDF_HEADER_LOGO_WIDTH, "CDA MI CARRERA SAS", $titulo);
//$logo = "data:image/jpg;base64," . base64_encode($cda->logo);
//$file = fopen($_SERVER['DOCUMENT_ROOT'] . 'et/application/libraries/tcpdf_logo.jpg', "wb");
//fwrite($file, $cda->logo);
//fclose($file);

$pdf->SetCreator(PDF_CREATOR);
// set default header data

$pdf->setHtmlHeader($encabezado);
$pdf->setHtmlFooter($fechaAprobacionPre, $versionPre);

//$logo = "data:image/jpg;base64," . base64_encode($cda->logo);
//$logo = file_get_contents($logo);
//$path = tempnam(sys_get_temp_dir(), 'prefix');
//file_put_contents($path, $logo);
//$pdf->SetHeaderData($path, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 009', PDF_HEADER_STRING);
//$pdf->SetHeaderData($path, PDF_HEADER_LOGO_WIDTH, "CDA MI CARRERA SAS", $titulo);
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(3);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
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

// -------------------------------------------------------------------
// set font
$pdf->SetFont('helvetica', '', 8);

// add a page
$pdf->AddPage();
//------------------------------------------------------------------------------INFORMACION DEL VEHICULO
$html = <<<EOF
$datoVehiculo
EOF;
$pdf->writeHTML($html, true, false, true, false, '');
//------------------------------------------------------------------------------PRESION DE AIRE
$html = <<<EOF
<p><strong>Presión de inflado (Psi)</strong></p>
<table cellpadding="1" cellspacing="1" border="1" style="text-align:center" nobr="true">
    $presion_llantas
</table>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');
////------------------------------------------------------------------------------II. REQUISITOS PARA INSPECCION

$html = <<<EOF
        $lista_chequeo
EOF;
$pdf->writeHTML($html, true, false, true, false, '');
//------------------------------------------------------------------------------III. ESTADO FÍSICO DEL VEHÍCULO
$html = <<<EOF
<div style="background-color: black;color:white;text-align: center"><strong>III. ESTADO FÍSICO DEL VEHÍCULO</strong></div>
        $fotos<br>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');
$html = <<<EOF
<strong>Observaciones:</strong> $observaciones<br>
        <div>
            <table   width="155" cellpadding="1" cellspacing="1" border="1" style="text-align:center;vertical-align: middle" nobr="true">
                <tr>
                    <td><label><strong>Funcionario que diligencia</strong></label></td>
                </tr>
                <tr>
                    <td><img  width="200" height="100"  src="@$firmaEncargado" /></td>
                    
                </tr>
                <tr>
                    <td>Nombre: $nombreUser</td>
                </tr>
                <tr>
                    <td>C.C: $identificacionUser</td>
                </tr>
            </table>
        </div>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');
//
//
////------------------------------------------------------------------------------IV. CONDICIONES GENERALES (POR FAVOR LEALAS ANTES DE FIRMAR)

$html = <<<EOF
    $condiciones
EOF;
$pdf->writeHTML($html, true, false, true, false, '');

if(isset($condicionesadicionales) && $condicionesadicionales !== ''){
    $html = <<<EOF
    $condicionesadicionales
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
}


////------------------------------------------------------------------------------V. ACEPTACIÓN DEL SERVICIO
$pdf->writeHTML($aceptacion, true, false, true, false, '');
////------------------------------------------------------------------------------VI. RESULTADO Y ENTREGA DE RESULTADOS/ DOCUMENTOS
if ($resultados !== '') {
    $html = <<<EOF
<div style="background-color: black;color:white;text-align: center"><strong>VI. RESULTADO Y ENTREGA DE RESULTADOS/ DOCUMENTOS</strong></div>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->writeHTML($resultados, true, false, true, false, '');
    $op = "<table style='margin-top:5px'><tr><td>" . $operarios . "</td><td>" . $documentos . "</td></tr></table>";
} else {
    $op = '';
}
$pdf->writeHTML($op, true, false, true, false, '');

$html = <<<EOF
------------------------------------------------------------------------------------ Fin del informe --------------------------------------------------------------------------------------
EOF;
$pdf->writeHTML($html, true, false, true, false, '');

//------------------------------------------------------------------------------VII. FIRMA DEL CLIENTE
//$html = <<<EOF
//<div style="background-color: black;color:white;text-align: center"><strong>VII. FIRMA DEL CLIENTE</strong></div>
//EOF;
$pdf->writeHTML($html, true, false, true, false, '');
if ($tipo == 1) {
    $pdf->Output($url . $file, 'F');
} else {
    $pdf->Output("prerevision.pdf", 'I');
}


