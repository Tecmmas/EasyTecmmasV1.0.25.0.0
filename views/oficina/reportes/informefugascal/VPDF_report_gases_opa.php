<?php

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle($titulo);



// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 006', PDF_HEADER_STRING);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->SetFont('dejavusans', '', 10);
$pdf->AddPage();

$red = array(255, 0, 0);
$blue = array(0, 0, 200);
$yellow = array(255, 255, 0);
$green = array(0, 255, 0);
$white = array(255);
$black = array(0);

$coords = array(0, 0, 1, 0);
$pdf->LinearGradient(10, 10, 190, 2, $red, $blue, $coords);
$html = <<<EOF
    <table bgcolor="#cccccc">
        <tr>
        <td width="100%" height="105px" border="1">
            <table>
                <tr>
                 <td width="50%" align="center"><br><br><img src="@$imagen->logo" style="width:220px;height:100px;"></td>
                 <td width="290px" align="center"><br><br><label style="font-size:15px">$cda->nombre_cda</label><br>
                                  <label style="font-size:12px">Nit: $cda->numero_id</label><br>
                                  Tel: $sede->telefono_uno<br>
                                   $sede->direccion<br>
                                  $sede->ciudad-$sede->departamento<br>
                </td>
                </tr>
            </table>
        </td>
        </tr>
</table>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');
$html = <<<EOF

        <label align="center" style="font-size:18px">$titulo</label><br>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');
$html = <<<EOF
        <table border="1" cellspacing="2" cellpadding="1">
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Informacion de usuario</th>
    </tr>
    <tr>
        <td>Usuario que genera el reporte:</td>
        <td colspan="2">$usuariogeneracion</td>
    </tr>
    <tr>
        <td>Fecha de generacion del reporte:</td>
        <td colspan="2">$fechageneracion</td>
    </tr>
</table>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');

switch ($tipoinforme) {
    case 1:
        if ($cal->resultado == 'S') {
            $resultadocal = '<td colspan = "2" align = "center" bgcolor = "#F9F774">Aprobado</td>';
        }else{
            $resultadocal = '<td colspan = "2" align = "center" bgcolor = "#E74C3C">Rechazado</td>';
        }
        $html = <<<EOF
        
        <table border="1" cellspacing="2" cellpadding="1">
            <tr>
                <th bgcolor="#6773FE"  align="center" colspan="2">Informacion de equipo</th>
            </tr>
            <tr>
                <td>Marca:</td>
                <td colspan="2">$marca</td>
            </tr>
            <tr>
                <td>Modelo:</td>
                <td colspan="2">$modelo</td>
            </tr>
            <tr>
                <td>Serial:</td>
                <td colspan="2">$serial</td>
            </tr>
            <tr>
                <td>Pef:</td>
                <td colspan="2">$cal->pef</td>
            </tr>

        </table>
EOF;
        $pdf->writeHTML($html, true, false, true, false, '');

        $html = <<<EOF
        
<table border="1" cellspacing="2" cellpadding="1">
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Informacion de prueba</th>
    </tr>
    <tr>
        <td bgcolor="#BFD0F5" align="center" >Parametro</td>
        <td bgcolor="#BFD0F5" align="center" >Valor</td>
    </tr>
    <tr>
        <td>Usuario que realizo la prueba:</td>
        <td colspan="2">$nombreuser->nombre_user</td>
    </tr>
    <tr>
        <td>Fecha de la prueba:</td>
        <td colspan="2">$cal->fecha</td>
    </tr>
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Span alto</th>
    </tr>
    <tr>
        <td>Hc[ppm]:</td>
        <td colspan="2">$cal->span_alto_hc</td>
    </tr>
    <tr>
        <td>Co[%]:</td>
        <td colspan="2">$cal->span_alto_co</td>
    </tr>
    <tr>
        <td>Co2[%]:</td>
        <td colspan="2">$cal->span_alto_co2</td>
    </tr>
    <tr>
        <td>N:</td>
        <td colspan="2">$n</td>
    </tr>
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Span bajo</th>
    </tr>
    <tr>
        <td>Hc[ppm]:</td>
        <td colspan="2">$cal->span_bajo_hc</td>
    </tr>
    <tr>
        <td>Co[%]:</td>
        <td colspan="2">$cal->span_bajo_co</td>
    </tr>
    <tr>
        <td>Co2[%]:</td>
        <td colspan="2">$cal->span_bajo_co2</td>
    </tr>
    <tr>
        <td>N:</td>
        <td colspan="2">$n</td>
    </tr>
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Calibracion alto</th>
    </tr>
    <tr>
        <td>Hc[ppm]:</td>
        <td colspan="2">$cal->cal_alto_hc</td>
    </tr>
    <tr>
        <td>Co[%]:</td>
        <td colspan="2">$cal->cal_alto_co</td>
    </tr>
    <tr>
        <td>Co2[%]:</td>
        <td colspan="2">$cal->cal_alto_co2</td>
    </tr>
    <tr>
        <td>N:</td>
        <td colspan="2">$n</td>
    </tr>
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Calibracion baja</th>
    </tr>
    <tr>
        <td>Hc[ppm]:</td>
        <td colspan="2">$cal->cal_bajo_hc</td>
    </tr>
    <tr>
        <td>Co[%]:</td>
        <td colspan="2">$cal->cal_bajo_co</td>
    </tr>
    <tr>
        <td>Co2[%]:</td>
        <td colspan="2">$cal->cal_bajo_co2</td>
    </tr>
    <tr>
        <td>N:</td>
        <td colspan="2">$n</td>
    </tr>
    <tr>
        <td bgcolor="#6773FE">Resultado:</td>
        $resultadocal
    </tr>
</table>
EOF;

        $pdf->writeHTML($html, true, false, true, false, '');

        break;
    case 2:
        if ($fug->aprobado == 'S') {
            $resultadofug = '<td colspan = "2" align = "center" bgcolor = "#F9F774">Aprobado</td>';
        }else{
            $resultadofug = '<td colspan = "2" align = "center" bgcolor = "#E74C3C">Rechazado</td>';
        }
        $html = <<<EOF
        
        <table border="1" cellspacing="2" cellpadding="1">
            <tr>
                <th bgcolor="#6773FE"  align="center" colspan="2">Informacion de equipo</th>
            </tr>
            <tr>
                <td>Marca:</td>
                <td colspan="2">$marca</td>
            </tr>
            <tr>
                <td>Modelo:</td>
                <td colspan="2">$modelo</td>
            </tr>
            <tr>
                <td>Serial:</td>
                <td colspan="2">$serial</td>
            </tr>
            <tr>
                <td>Pef:</td>
                <td colspan="2">$cal->pef</td>
            </tr>

        </table>
EOF;
        $pdf->writeHTML($html, true, false, true, false, '');

        $html = <<<EOF
        
<table border="1" cellspacing="2" cellpadding="1">
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Informacion de prueba</th>
    </tr>
    <tr>
        <td bgcolor="#BFD0F5" align="center" >Parametro</td>
        <td bgcolor="#BFD0F5" align="center" >Valor</td>
    </tr>
    <tr>
        <td>Usuario que realizo la prueba:</td>
        <td colspan="2">$nombreuser->nombre_user</td>
    </tr>
    <tr>
        <td>Fecha de la prueba:</td>
        <td colspan="2">$fug->fecha</td>
    </tr>
    <tr>
        <td>Presion base[mBar]:</td>
        <td colspan="2">$fug->presion_base</td>
    </tr>
    <tr>
        <td>Presion bomba[mBar]:</td>
        <td colspan="2">$fug->presion_bomba</td>
    </tr>
    <tr>
        <td>Presion filtros[mBar]:</td>
        <td colspan="2">$fug->presion_filtros</td>
    </tr>
    <tr>
        <td>Vacio bomba apagada[mBar]:</td>
        <td colspan="2">$fug->presion_bombaoff</td>
    </tr>
    <tr>
        <td>Vacion bomba encendida[mBar]:</td>
        <td colspan="2">$fug->presion_bombaon</td>
    </tr>
    <tr>
        <td>Total fugas[mBar]:</td>
        <td colspan="2">$fug->num_fuga</td>
    </tr>
    <tr>
        <td>Total fugas[%]:</td>
        <td colspan="2">$fug->por_num_fuga</td>
    </tr>
    <tr>
        <td bgcolor = "#6773FE">Resultado:</td>
        $resultadofug
    </tr>
    
</table>
EOF;
        $pdf->writeHTML($html, true, false, true, false, '');
        
        break;

    case 3:
        $html = <<<EOF
        
        <table border="1" cellspacing="2" cellpadding="1">
            <tr>
                <th bgcolor="#6773FE"  align="center" colspan="2">Informacion de equipo</th>
            </tr>
            <tr>
                <td>Marca:</td>
                <td colspan="2">$marca</td>
            </tr>
            <tr>
                <td>Modelo:</td>
                <td colspan="2">$modelo</td>
            </tr>
            <tr>
                <td>Serial:</td>
                <td colspan="2">$serial</td>
            </tr>
            <tr>
                <td>Pef:</td>
                <td colspan="2">$pef</td>
            </tr>

        </table>
EOF;
        $pdf->writeHTML($html, true, false, true, false, '');

        $html = <<<EOF
        
<table border="1" cellspacing="2" cellpadding="1">
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Informacion de prueba</th>
    </tr>
    <tr>
        <td bgcolor="#BFD0F5" align="center" >Parametro</td>
        <td bgcolor="#BFD0F5" align="center" >Valor</td>
    </tr>
    <tr>
        <td>Usuario que realizo la prueba:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td>Fecha de la prueba:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Span alto</th>
    </tr>
    <tr>
        <td>Hc[ppm]:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td>Co[%]:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td>Co2[%]:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td>N:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Span bajo</th>
    </tr>
    <tr>
        <td>Hc[ppm]:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td>Co[%]:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td>Co2[%]:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td>N:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Calibracion alto</th>
    </tr>
    <tr>
        <td>Hc[ppm]:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td>Co[%]:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td>Co2[%]:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td>N:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Calibracion alto</th>
    </tr>
    <tr>
        <td>Hc[ppm]:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td>Co[%]:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td>Co2[%]:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td>N:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td bgcolor="#6773FE">Resultado:</td>
        <td colspan = "2" align = "center" bgcolor = "#F9F774">Aprobado</td>
    </tr>
    
    
     
</table>
EOF;
        $pdf->writeHTML($html, true, false, true, false, '');

        break;
    case 4:
        $html = <<<EOF
        
        <table border="1" cellspacing="2" cellpadding="1">
            <tr>
                <th bgcolor="#6773FE"  align="center" colspan="2">Informacion de equipo</th>
            </tr>
            <tr>
                <td>Marca:</td>
                <td colspan="2">$marca</td>
            </tr>
            <tr>
                <td>Modelo:</td>
                <td colspan="2">$modelo</td>
            </tr>
            <tr>
                <td>Serial:</td>
                <td colspan="2">$serial</td>
            </tr>
            <tr>
                <td>Ltoe:</td>
                <td colspan="2">$ltoe</td>
            </tr>

        </table>
EOF;
        $pdf->writeHTML($html, true, false, true, false, '');

        $html = <<<EOF
        
<table border="1" cellspacing="2" cellpadding="1">
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Informacion de prueba</th>
    </tr>
    <tr>
        <td bgcolor="#BFD0F5" align="center" >Parametro</td>
        <td bgcolor="#BFD0F5" align="center" >Valor</td>
    </tr>
    <tr>
        <td>Usuario que realizo la prueba:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td>Fecha de la prueba:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Informacion lentes</th>
    </tr>
     <tr>
        <td>Opacidad lente 1 [%]:</td>
        <td colspan="2"></td>
    </tr>           
     <tr>
        <td>Opacidad lente 2 [%]:</td>
        <td colspan="2"></td>
    </tr>           
     <tr>
        <td>Opacidad lente 3 [%]:</td>
        <td colspan="2"></td>
    </tr>           
     <tr>
        <td>Opacidad lente 4 [%]:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Resultados linealidad</th>
    </tr>
    <tr>
        <td bgcolor="#BFD0F5" align="center" >Lente</td>
        <td bgcolor="#BFD0F5" align="center" >Valor</td>
    </tr>
    <tr>
        <td>Lente 1:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td>Lente 2:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td>Lente 3:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td>Lente 4:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td bgcolor="#BFD0F5">Error total:</td>
        <td colspan="2" align="center" bgcolor="#BFD0F5"></td>
    </tr>
    <tr>
        <td bgcolor="#6773FE">Resultado:</td>
        <td colspan="2" align="center" bgcolor="#FFFF00">Aprobado</td>
    </tr>
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Infromacion control de cero</th>
    </tr>
    <tr>
        <td bgcolor="#BFD0F5" align="center" >Parametro</td>
        <td bgcolor="#BFD0F5" align="center" >Valor</td>
    </tr>
    <tr>
        <td>Usuario que realizo la prueba:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td>Fecha de la prueba:</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td bgcolor="#6773FE">Resultado:</td>
        <td colspan = "2" align = "center" bgcolor = "#F9F774">Aprobado</td>
    </tr>
</table>
EOF;
        $pdf->writeHTML($html, true, false, true, false, '');
        break;
    default:
        break;
}
$html = <<<EOF
        <label align="center">*************************Fin reporte*************************</label>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');




//Close and output PDF document
$pdf->Output($titulo . '_' . $serial . '.pdf');

//============================================================+
// END OF FILE
//============================================================+