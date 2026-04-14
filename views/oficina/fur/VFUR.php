<?php

$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT_LEGAL, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT_FUR, PDF_MARGIN_TOP_FUR, PDF_MARGIN_RIGHT_FUR);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->SetFont('helvetica', '', 8);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();

//TITULO Y NUMERO CONSECUTIVO
$html = <<<EOF
<table cellpadding="2">
        <tr>
                <td  width="80%" ><label><strong>$titulo</strong></label></td>
                <td  width="20%" border="1"><label>$consecutivo</label></td>
        </tr>
</table>

EOF;
$pdf->writeHTML($html, true, false, true, false, '');


$pdf->Output("fur.pdf", 'I');

