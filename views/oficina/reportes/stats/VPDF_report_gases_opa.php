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
        <td colspan="2">$usuariogeneracion->usuario</td>
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
        if ($cal->resultado == 'APROBADO') {
            $resultadocal = '<td colspan = "2" align = "center" bgcolor = "#F9F774">Aprobado</td>';
        } else {
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
                <td colspan="2">$cal->Pef</td>
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
        <td colspan="2">$cal->Responsable</td>
    </tr>
    <tr>
        <td>Fecha de la prueba:</td>
        <td colspan="2">$cal->Fecha</td>
    </tr>
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Span alto</th>
    </tr>
    <tr>
        <td>Hc[ppm]:</td>
        <td colspan="2">$cal->Span_alto_hc</td>
    </tr>
    <tr>
        <td>Co[%]:</td>
        <td colspan="2">$cal->Span_alto_co</td>
    </tr>
    <tr>
        <td>Co2[%]:</td>
        <td colspan="2">$cal->Span_alto_co2</td>
    </tr>
    <tr>
        <td>N:</td>
        <td colspan="2">$cal->Span_alto_n</td>
    </tr>
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Span bajo</th>
    </tr>
    <tr>
        <td>Hc[ppm]:</td>
        <td colspan="2">$cal->Span_bajo_hc</td>
    </tr>
    <tr>
        <td>Co[%]:</td>
        <td colspan="2">$cal->Span_bajo_co</td>
    </tr>
    <tr>
        <td>Co2[%]:</td>
        <td colspan="2">$cal->Span_bajo_co2</td>
    </tr>
    <tr>
        <td>N:</td>
        <td colspan="2">$cal->Span_bajo_n</td>
    </tr>
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Calibracion alto</th>
    </tr>
    <tr>
        <td>Hc[ppm]:</td>
        <td colspan="2">$cal->Cal_alto_hc</td>
    </tr>
    <tr>
        <td>Co[%]:</td>
        <td colspan="2">$cal->Cal_alto_co</td>
    </tr>
    <tr>
        <td>Co2[%]:</td>
        <td colspan="2">$cal->Cal_alto_co2</td>
    </tr>
    <tr>
        <td>O2[%]:</td>
        <td colspan="2">$cal->Cal_alto_o2</td>
    </tr>
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Calibracion baja</th>
    </tr>
    <tr>
        <td>Hc[ppm]:</td>
        <td colspan="2">$cal->Cal_bajo_hc</td>
    </tr>
    <tr>
        <td>Co[%]:</td>
        <td colspan="2">$cal->Cal_bajo_co</td>
    </tr>
    <tr>
        <td>Co2[%]:</td>
        <td colspan="2">$cal->Cal_bajo_co2</td>
    </tr>
    <tr>
        <td>O2[%]:</td>
        <td colspan="2">$cal->Cal_bajo_o2</td>
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
        if ($fug->resultado == 'Aprobado') {
            $resultadofug = '<td colspan = "2" align = "center" bgcolor = "#F9F774">Aprobado</td>';
        } else {
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
                <td colspan="2">$fug->Pef</td>
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
        <td colspan="2">$fug->Responsable</td>
    </tr>
    <tr>
        <td>Fecha de la prueba:</td>
        <td colspan="2">$fug->Fecha</td>
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
        <td colspan="2">$fug->vacio_bomba_apag</td>
    </tr>
    <tr>
        <td>Vacion bomba encendida[mBar]:</td>
        <td colspan="2">$fug->vacio_bomba_pren</td>
    </tr>
    <tr>
        <td>Total fugas[mBar]:</td>
        <td colspan="2">$fug->total_fugas_num</td>
    </tr>
    <tr>
        <td>Total fugas[%]:</td>
        <td colspan="2">$fug->total_fugas_porc</td>
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
//        if ($lin->Resultado_control_cero == 'Aprobado') {
//            $resultadocontrolcero = '<td colspan = "2" align = "center" bgcolor = "#F9F774">Aprobado</td>';
//        }else{
//            $resultadocontrolcero = '<td colspan = "2" align = "center" bgcolor = "#E74C3C">Rechazado</td>';
//        }
        if ($lin->Resultado == 'Aprobada') {
            $resultadolin = '<td colspan = "2" align = "center" bgcolor = "#F9F774">Aprobado</td>';
        } else {
            $resultadolin = '<td colspan = "2" align = "center" bgcolor = "#E74C3C">Rechazado</td>';
        }
        $data = $lin->Lente1_desviacion + $lin->Lente2_desviacion + $lin->Lente3_desviacion + $lin->Lente4_desviacion;
        $Error_total_lectura = $data / 4;
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
        <td colspan="2">$lin->Responsable</td>
    </tr>
    <tr>
        <td>Fecha de la prueba:</td>
        <td colspan="2">$lin->Fecha</td>
    </tr>
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Informacion lentes</th>
    </tr>
     <tr>
        <td>Opacidad lente 1 [%]:</td>
        <td colspan="2">$lin->Lente1_valor</td>
    </tr>           
     <tr>
        <td>Opacidad lente 2 [%]:</td>
        <td colspan="2">$lin->Lente2_valor</td>
    </tr>           
     <tr>
        <td>Opacidad lente 3 [%]:</td>
        <td colspan="2">$lin->Lente3_valor</td>
    </tr>           
     <tr>
        <td>Opacidad lente 4 [%]:</td>
        <td colspan="2">$lin->Lente4_valor</td>
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
        <td colspan="2">$lin->Lente1_lectura</td>
    </tr>
    <tr>
        <td>Lente 2:</td>
        <td colspan="2">$lin->Lente2_lectura</td>
    </tr>
    <tr>
        <td>Lente 3:</td>
        <td colspan="2">$lin->Lente3_lectura</td>
    </tr>
    <tr>
        <td>Lente 4:</td>
        <td colspan="2">$lin->Lente4_lectura</td>
    </tr>
    <tr>
        <td bgcolor="#BFD0F5">Error total:</td>
        <td colspan="2" align="center" bgcolor="#BFD0F5">$Error_total_lectura%</td>
    </tr>
    <tr>
        <td bgcolor="#6773FE">Resultado:</td>
        $resultadolin
    </tr>
   
</table>
EOF;
        $pdf->writeHTML($html, true, false, true, false, '');
        break;
    case 5:
        if ($cero->Resultado == 'Aprobada') {
            $resultadocero = '<td colspan = "2" align = "center" bgcolor = "#F9F774">Aprobado</td>';
        } else {
            $resultadocero = '<td colspan = "2" align = "center" bgcolor = "#E74C3C">Rechazado</td>';
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
        <td colspan="2">$cero->Usuario</td>
    </tr>
    <tr>
        <td>Fecha de la prueba:</td>
        <td colspan="2">$cero->Fecha</td>
    </tr>
    <tr>
        <th bgcolor="#6773FE" align="center" colspan="2">Resultado</th>
    </tr>
     <tr>
        <td>Valor antes:</td>
        <td colspan="2">$cero->Valorantes</td>
    </tr>           
     <tr>
        <td>Valor despues:</td>
        <td colspan="2">$cero->Valordespues</td>
    </tr>                     
    <tr>
        <td bgcolor="#6773FE">Resultado:</td>
        $resultadocero
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

// <tr>
//        <th bgcolor="#6773FE" align="center" colspan="2">Infromacion control de cero</th>
//    </tr>
//    <tr>
//        <td bgcolor="#BFD0F5" align="center" >Parametro</td>
//        <td bgcolor="#BFD0F5" align="center" >Valor</td>
//    </tr>
//    <tr>
//        <td>Usuario que realizo la prueba:</td>
//        <td colspan="2">$lin->Usuario_cero</td>
//    </tr>
//    <tr>
//        <td>Fecha de la prueba:</td>
//        <td colspan="2">$lin->Fecha_control_cero</td>
//    </tr>
//    <tr>
//        <td bgcolor="#6773FE">Resultado:</td>
//        $resultadocontrolcero
//    </tr>