<?php

// Extend the TCPDF class to create custom Header and Footer

class MYPDF extends TCPDF
{

    //Page header
    public function Header()
    {
        // Logo
        $image_file = K_PATH_IMAGES . 'logo_example.jpg';
        $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        //        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}



if ($tamano == 'oficio') {
    $pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT_COL_OFICIO, true, 'UTF-8', false);
} else {
    $pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT_COL_CARTA, true, 'UTF-8', false);
}


//$pdf->SetCreator(PDF_CREATOR);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT_FUR, PDF_MARGIN_TOP_FUR, PDF_MARGIN_RIGHT_FUR);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pageNumbers = "Page " . $pdf->getAliasNumPage();
//$pdf->SetY(-15);
//$pdf->Cell(0, 10, $pageNumbers, 0, false, "C", 0, "", 0, false, "T", "M");
//$total = $pdf->getNumPages();
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->SetFont('helvetica', '', 8);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(true);
// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


$pdf->AddPage();

//TITULO Y NUMERO CONSECUTIVO
$showencabezado = true;
if ($luces->idprueba == '' && ($reins == '8888' || $reins == '88881') && ($idrunt == '19705572' || $idrunt == '19236858' || $idrunt == '17244773')) {
    $showencabezado = false;
}

if ($showencabezado) {
    $html = <<<EOF
    <table cellpadding="2">
            <tr>
                    <td  width="1%" ></td>
                    <td  width="78%" ><label><strong>$titulo</strong></label></td>
                    <td  width="20%" border="1"><label>$consecutivo</label></td>
            </tr>
    </table>
EOF;
    $direccion = '<label style="font-size: 7px">' . $sede->direccion . '</label>';
    $pdf->writeHTML($html, true, false, true, false, '');
    //ENCABEZADO DEL FUR: ESCUDO, LOGOS, INFORMACIÓN DEL CDA
    $html = <<<EOF
<table >
<tr>
        <td  width="5px"></td>
        <td  width="44px">$escudoColombia</td>
        <td  width="188px">$tituloMinisterio
            <table cellpadding="3px">
                <tr >
                    <td width="40px"></td>
                    <td width="110px">$logoSuper</td>
                </tr>
            </table>
        </td>
        <td border="1" width="340.157px" height="85.039px">
                        <table >
                            <tr><td style="font-size: 5.5px;color: white" ></td></tr>
                            <tr>
                                <td width="$colOnac" style="text-align: center">$infoOnac</td>
                                <td width="$colMid"></td>
                                <td width="$colCda">$logoCda</td>
                                <td width="$colDatCda" align="center">$cda->nombre_cda<br>
                                                                                 NIT: $cda->numero_id<br>
                                                                                 $direccion<br>
                                                                                 Tel - $sede->telefono_uno<br>
                                                                                 $ciudadCDA->nombre $departamentoCDA->nombre<br>
                                                                                 $sede->email </td>
                            </tr>
                        </table>
        </td>
</tr>
</table>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');

    $html = <<<EOF
<label>   <strong>A. INFORMACIÓN GENERAL</strong></label>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');

    //INFORMACIÓN DEL PROPIETARIO O TINEDOR DEL VEHÍCULO
    $html = <<<EOF
<br>
<table cellpadding="2" nobr="true">
                <tr>
                    <td width="10%"></td>
                    <td width="30%"><label><strong>1. FECHA</strong></label></td>
                    <td width="60%"><label><strong>2.  DATOS DEL PROPIETARIO, TENEDOR O POSEEDOR DEL VEHÍCULO </strong></label></td>
                </tr>
                <tr >
                    <td width="20%" border="1" ><strong>Fecha de prueba</strong><br>$fechafur</td>
                    <td width="40%" border="1" ><label><strong>Nombre o Razón social</strong></label><br>$propietario->nombre1 $propietario->nombre2 $propietario->apellido1 $propietario->apellido2</td>
                    <td width="39%" border="1"><label><strong>Documento de identidad</strong><br>$tipoDocumento No. $propietario->numero_identificacion</label></td>
                </tr>
                <tr >
                    <td width="30%" border="1" ><strong>Direccion</strong><br>$propietario->direccion</td>
                    <td width="30%" border="1" ><label><strong>Teléfono fijo o Número de Celular</strong><br>$propietario->telefono1</label></td>
                    <td width="20%" border="1"><label><strong>Ciudad</strong><br>$ciudadPropietario->nombre</label></td>
                    <td width="19%" border="1"><label><strong>Departamento</strong><br>$departamentoPropietario->nombre</label></td>
                </tr>
                <tr >
                    <td width="99%" border="1" ><strong>Correo Electrónico</strong><br>$propietario->correo</td>
                </tr>
</table>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
}



//INFORMACIÓN DEL VEHÍCULO
$html = <<<EOF
        <br>
        <table cellpadding="2" nobr="true">
                        <tr >
                            <td width="99%" align="center"><strong>3. DATOS DEL VEHÍCULO</strong></td>
                        </tr>
                        <tr>
                            <td width="20%" border="1"><strong>Placa</strong><br>$vehiculo->numero_placa</td>
                            <td width="15%" border="1"><strong>País</strong><br>$pais->nombre</td>
                            <td width="15%" border="1"><strong>Servicio</strong><br>$servicio->nombre</td>
                            <td width="17%" border="1"><strong>Clase</strong><br>$clase->nombre</td>
                            <td width="16%" border="1"><strong>Marca</strong><br>$marca->nombre</td>
                            <td width="16%" border="1"><strong>Línea</strong><br>$linea->nombre</td>
                        </tr>
                        <tr>
                            <td width="6%" border="1"><strong>Modelo</strong><br>$vehiculo->ano_modelo</td>
                            <td width="21%" border="1"><strong>Número de licencia de tránsito</strong><br>$vehiculo->numero_tarjeta_propiedad</td>
                            <td width="14%" border="1"><strong>Fecha de matrícula</strong><br>$vehiculo->fecha_matricula</td>
                            <td width="24%" border="1"><strong>Color</strong><br>$color->nombre</td>
                            <td width="18%" border="1"><strong>Combustible / Propulsión</strong><br>$combustible->nombre</td>
                            <td width="16%" border="1"><strong>VIN o Chasis </strong><br>$vehiculo->numero_vin</td>
                        </tr>
                        <tr>
                            <td width="15%" border="1"><strong>No de motor</strong><br>$vehiculo->numero_motor</td>
                            <td width="10%" border="1"><strong>Tipo motor</strong><br>$vehiculo->tiempos</td>
                            <td width="18%" border="1"><strong>Cilindraje(cm<sup>3</sup>)(si aplica)</strong><br>$vehiculo->cilindraje</td>
                            <td width="14%" border="1"><strong>Kilometraje</strong><br>$vehiculo->kilometraje</td>
                            <td width="30%" border="1"><strong>Número de pasajeros (sin incluir conductor)</strong><br>$pasajeros</td>
                            <td width="12%" border="1"><strong>Blindaje</strong><br>$blindaje</td>
                        </tr>
                        <tr>
                            <td width="20%" border="1"><strong>Potencia (si aplica)</strong><br>$vehiculo->potencia_motor</td>
                            <td width="20%" border="1"><strong>Tipo de Carrocería</strong><br>$carroceria->nombre</td>
                            <td width="20%" border="1"><strong>Fecha vencimiento SOAT</strong><br>$vehiculo->fecha_vencimiento_soat</td>
                            <td width="20%" border="1"><strong>Conversión GNV</strong><br>$vehiculo->certificadoGas</td>
                            <td width="19%" border="1"><strong>Fecha Vencimiento GNV</strong><br>$vehiculo->fecha_final_certgas</td>
                        </tr>
        </table>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');

$html = <<<EOF
        <br>
        <table>
        <tr>
        <td >$tituloB<br>
        Nota: Todo valor medido, seguido del símbolo *, indica un defecto encontrado.</td>
                        </tr>
        </table>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');

//------------------------------------------------------------------------------LUXOMETRO
$showLux = true;
if ($luces->idprueba == '' && ($reins == '4444' || $reins == '44441')) {
    $showLux = false;
}
if ($showLux) {
    $html = <<<EOF
            <br>
        <table cellpadding="2" nobr="true">
                        <tr>
                            <td width="100%"><strong>4. Medición de Intensidad / inclinación de las luces (Bajas, Altas Antiniebla / Exploradoras)</strong></td>
                        </tr>
                        <tr>
                            <td width="30%" border="1" align="center"></td>
                            <td width="11%" border="1" align="center"><strong>Valor 1</strong></td>
                            <td width="11%" border="1" align="center"><strong>Valor 2</strong></td>
                            <td width="11%" border="1" align="center"><strong>Valor 3</strong></td>
                            <td width="11%" border="1" align="center"><strong>Mínima/Rango</strong></td>
                            <td width="11%" border="1" align="center"><strong>Unidad</strong></td>
                            <td width="14%" border="1" align="center"><strong>Simultanea (Si) (No)</strong></td>
                        </tr>
                        <tr>
                            <td width="11%" border="1" align="center" rowspan="4"><br><br><br><strong>Baja(s)</strong></td>
                            <td width="9%" border="1" align="center" rowspan="2"><br><br><strong>Derecha(s)</strong></td>
                            <td width="10%" border="1" align="center"><strong>Intensidad</strong></td>
                            <td width="11%" border="1" align="center">$luces->valor_baja_derecha_1</td>
                            <td width="11%" border="1" align="center">$luces->valor_baja_derecha_2</td>
                            <td width="11%" border="1" align="center">$luces->valor_baja_derecha_3</td>
                            <td width="11%" border="1" align="center">$luces->intensidad_minima</td>
                            <td width="11%" border="1" align="center"><strong>klux</strong></td>
                            <td width="14%" border="1" align="center" rowspan="2"><br><br>$luces->simultaneaBaja</td>
                        </tr>
                        <tr>
                            <td width="10%" border="1" align="center"><strong>Inclinación</strong></td>
                            <td width="11%" border="1" align="center">$luces->inclinacion_baja_derecha_1</td>
                            <td width="11%" border="1" align="center">$luces->inclinacion_baja_derecha_2</td>
                            <td width="11%" border="1" align="center">$luces->inclinacion_baja_derecha_3</td>
                            <td width="11%" border="1" align="center">$luces->inclinacion_rango</td>
                            <td width="11%" border="1" align="center"><strong>%</strong></td>
                        </tr>
                        <tr>
                            <td width="9%" border="1" align="center" rowspan="2"><br><br><strong>Izquierda(s)</strong></td>
                            <td width="10%" border="1" align="center"><strong>Intensidad</strong></td>
                            <td width="11%" border="1" align="center">$luces->valor_baja_izquierda_1</td>
                            <td width="11%" border="1" align="center">$luces->valor_baja_izquierda_2</td>
                            <td width="11%" border="1" align="center">$luces->valor_baja_izquierda_3</td>
                            <td width="11%" border="1" align="center">$luces->intensidad_minimaBI</td>
                            <td width="11%" border="1" align="center"><strong>klux</strong></td>
                            <td width="14%" border="1" align="center" rowspan="2"><br><br>$luces->simultaneaBaja</td>
                        </tr>
                        <tr>
                            <td width="10%" border="1" align="center"><strong>Inclinación</strong></td>
                            <td width="11%" border="1" align="center">$luces->inclinacion_baja_izquierda_1</td>
                            <td width="11%" border="1" align="center">$luces->inclinacion_baja_izquierda_2</td>
                            <td width="11%" border="1" align="center">$luces->inclinacion_baja_izquierda_3</td>
                            <td width="11%" border="1" align="center">$luces->inclinacion_rangoBI</td>
                            <td width="11%" border="1" align="center"><strong>%</strong></td>
                        </tr>
                        <tr>
                            <td width="11%" border="1" align="center" rowspan="2"><br><br><strong>Alta(s)</strong></td>
                            <td width="9%" border="1" align="center"><strong>Derecha(s)</strong></td>
                            <td width="10%" border="1" align="center"><strong>Intensidad</strong></td>
                            <td width="11%" border="1" align="center">$luces->valor_alta_derecha_1</td>
                            <td width="11%" border="1" align="center">$luces->valor_alta_derecha_2</td>
                            <td width="11%" border="1" align="center">$luces->valor_alta_derecha_3</td>
                            <td width="11%" border="1" align="center">$luces->intensidad_minimaAD</td>
                            <td width="11%" border="1" align="center"><strong>klux</strong></td>
                            <td width="14%" border="1" align="center">$luces->simultaneaAlta</td>
                        </tr>
                        <tr>
                            <td width="9%" border="1" align="center"><strong>Izquierda(s)</strong></td>
                            <td width="10%" border="1" align="center"><strong>Intensidad</strong></td>
                            <td width="11%" border="1" align="center">$luces->valor_alta_izquierda_1</td>
                            <td width="11%" border="1" align="center">$luces->valor_alta_izquierda_2</td>
                            <td width="11%" border="1" align="center">$luces->valor_alta_izquierda_3</td>
                            <td width="11%" border="1" align="center">$luces->intensidad_minimaAI</td>
                            <td width="11%" border="1" align="center"><strong>klux</strong></td>
                            <td width="14%" border="1" align="center">$luces->simultaneaAlta</td>
                        </tr>
                        <tr>
                            <td width="11%" border="1" align="center" rowspan="2"><strong>Antiniebla(s)/ Exploradora(s)</strong></td>
                            <td width="9%" border="1" align="center"><strong>Derecha(s)</strong></td>
                            <td width="10%" border="1" align="center"><strong>Intensidad</strong></td>
                            <td width="11%" border="1" align="center">$luces->valor_antiniebla_derecha_1</td>
                            <td width="11%" border="1" align="center">$luces->valor_antiniebla_derecha_2</td>
                            <td width="11%" border="1" align="center">$luces->valor_antiniebla_derecha_3</td>
                            <td width="11%" border="1" align="center"><strong></strong></td>
                            <td width="11%" border="1" align="center"><strong>klux</strong></td>
                            <td width="14%" border="1" align="center">$luces->simultaneaAntiniebla</td>
                        </tr>
                        <tr>
                            <td width="9%" border="1" align="center"><strong>Izquierda(s)</strong></td>
                            <td width="10%" border="1" align="center"><strong>Intensidad</strong></td>
                            <td width="11%" border="1" align="center">$luces->valor_antiniebla_izquierda_1</td>
                            <td width="11%" border="1" align="center">$luces->valor_antiniebla_izquierda_2</td>
                            <td width="11%" border="1" align="center">$luces->valor_antiniebla_izquierda_3</td>
                            <td width="11%" border="1" align="center"><strong></strong></td>
                            <td width="11%" border="1" align="center"><strong>klux</strong></td>
                            <td width="14%" border="1" align="center">$luces->simultaneaAntiniebla</td>
                        </tr>
                        <tr>
                            <td width="30%" border="1" align="center"><strong>Sumatoria de luces simultáneamente</strong></td>
                            <td width="33%" border="1" align="center"><strong>Intensidad</strong><br>$luces->intensidad_total</td>
                            <td width="11%" border="1" align="center"><strong>Máxima</strong><br>$luces->intensidad_maxima</td>
                            <td width="25%" border="1" align="center"><strong>Unidad<br>klux</strong></td>
                        </tr>
        </table>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
}
//------------------------------------------------------------------------------SUSPENSIÓN
$showSus = true;
if ($suspension->idprueba == '' && ($reins == '4444' || $reins == '44441')) {
    $showSus = false;
}
if ($showSus) {
    $html = <<<EOF
            <br>
        <table cellpadding="2" nobr="true">
                        <tr >
                            <td width="100%" align="center"><strong>5. SUSPENSIÓN (adherencia)(si aplica)</strong></td>
                        </tr>
                        <tr>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;" align="center"><strong>Delantera</strong></td>
                            <td width="10%" style="border-right: 1px solid black;border-top: 1px solid black;" align="center"><strong>Valor</strong></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;" align="center"><strong>Delantera</strong></td>
                            <td width="10%" style="border-right: 1px solid black;border-top: 1px solid black;" align="center"><strong>Valor</strong></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;" align="center"><strong>Trasera</strong></td>
                            <td width="10%" style="border-right: 1px solid black;border-top: 1px solid black;" align="center"><strong>Valor</strong></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;" align="center"><strong>Trasera</strong></td>
                            <td width="10%" style="border-right: 1px solid black;border-top: 1px solid black;" align="center"><strong>Valor</strong></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;" align="center"><strong>Mínima</strong></td>
                            <td width="9%" style="border-right: 1px solid black;border-top: 1px solid black;" align="center"><strong>Unidad</strong></td>
                        </tr>
                        <tr>
                            <td width="10%" style="border-left: 1px solid black;border-bottom: 1px solid black;" align="center"><strong>Izquierda</strong></td>
                            <td width="10%" style="border-right: 1px solid black;border-bottom: 1px solid black;" align="center">$suspension->delantera_izquierda</td>
                            <td width="10%" style="border-left: 1px solid black;border-bottom: 1px solid black;" align="center"><strong>Derecha</strong></td>
                            <td width="10%" style="border-right: 1px solid black;border-bottom: 1px solid black;" align="center">$suspension->delantera_derecha</td>
                            <td width="10%" style="border-left: 1px solid black;border-bottom: 1px solid black;" align="center"><strong>Izquierda</strong></td>
                            <td width="10%" style="border-right: 1px solid black;border-bottom: 1px solid black;" align="center">$suspension->trasera_izquierda</td>
                            <td width="10%" style="border-left: 1px solid black;border-bottom: 1px solid black;" align="center"><strong>Derecha</strong></td>
                            <td width="10%" style="border-right: 1px solid black;border-bottom: 1px solid black;" align="center">$suspension->trasera_derecha</td>
                            <td width="10%" style="border-left: 1px solid black;border-bottom: 1px solid black;" align="center">$suspension->minima</td>
                            <td width="9%" style="border-right: 1px solid black;border-bottom: 1px solid black;" align="center"><strong>%</strong></td>
                        </tr>
        </table>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
}
//------------------------------------------------------------------------------FRENOS
$showFre = true;
if ($frenos->idprueba == '' && ($reins == '4444' || $reins == '44441')) {
    $showFre = false;
}
if ($showFre) {
    $html = <<<EOF
            <br>
        <table cellpadding="2" nobr="true">
                        <tr>
                            <td width="100%" align="center"><strong>6. FRENOS</strong></td>
                        </tr>
                         <tr>
                            <td width="5%" border="1" align="center" rowspan="2"><strong></strong></td>
                            <td width="9%" style="border-top: 1px solid black" align="center"><strong>Fuerza</strong></td>
                            <td width="9%" style="border-top: 1px solid black;border-left: 1px solid black" align="center"><strong>Peso</strong></td>
                            <td width="9%" border="1" align="center" rowspan="2"><br><br><strong>Unidad</strong></td>
                            <td width="5%" border="1" align="center" rowspan="2"><strong></strong></td>
                            <td width="9%" style="border-top: 1px solid black;border-left: 1px solid black" align="center"><strong>Fuerza</strong></td>
                            <td width="9%" style="border-top: 1px solid black;border-left: 1px solid black" align="center"><strong>Peso</strong></td>
                            <td width="9%" border="1" align="center" rowspan="2"><br><br><strong>Unidad</strong></td>
                            <td width="10%" border="1" align="center" rowspan="2"><br><br><strong>Desequilibrio</strong></td>
                            <td width="9%" border="1" align="center" rowspan="2"><br><br><strong>Rangos(B)</strong></td>
                            <td width="9%" border="1" align="center" rowspan="2"><br><br><strong>Max(A)</strong></td>
                            <td width="7%" border="1" align="center" rowspan="2"><br><br><strong>Unidad</strong></td>
                        </tr>
                        <tr>
                             <td width="9%" style="border-bottom: 1px solid black;border-left: 1px solid black" align="center"><strong>Izquierdo</strong></td>
                             <td width="9%" style="border-bottom: 1px solid black;border-left: 1px solid black" align="center"><strong>Izquierdo</strong></td>
                             <td width="9%" style="border-bottom: 1px solid black;border-left: 1px solid black" align="center"><strong>Derecho</strong></td>
                             <td width="9%" style="border-bottom: 1px solid black;border-left: 1px solid black" align="center"><strong>Derecho</strong></td>
                        </tr>
                        <tr>
                            <td width="5%" border="1" align="center"><strong>Eje 1</strong></td>
                            <td width="9%" border="1" align="center">$frenos->freno_1_izquierdo</td>
                            <td width="9%" border="1" align="center">$frenos->peso_1_izquierdo</td>
                            <td width="9%" border="1" align="center"><strong>N</strong></td>
                            <td width="5%" border="1" align="center"><strong>Eje 1</strong></td>
                            <td width="9%" border="1" align="center">$frenos->freno_1_derecho</td>
                            <td width="9%" border="1" align="center">$frenos->peso_1_derecho</td>
                            <td width="9%" border="1" align="center"><strong>N</strong></td>
                            <td width="10%" border="1" align="center">$frenos->desequilibrio_1</td>
                            <td width="9%" border="1" align="center">$frenos->n_desequilibrio_B</td>
                            <td width="9%" border="1" align="center">$frenos->n_desequilibrio_A</td>
                            <td width="7%" border="1" align="center"><strong>%</strong></td>
                        </tr>
                        <tr>
                            <td width="5%" border="1" align="center"><strong>Eje 2</strong></td>
                            <td width="9%" border="1" align="center">$frenos->freno_2_izquierdo</td>
                            <td width="9%" border="1" align="center">$frenos->peso_2_izquierdo</td>
                            <td width="9%" border="1" align="center"><strong>N</strong></td>
                            <td width="5%" border="1" align="center"><strong>Eje 2</strong></td>
                            <td width="9%" border="1" align="center">$frenos->freno_2_derecho</td>
                            <td width="9%" border="1" align="center">$frenos->peso_2_derecho</td>
                            <td width="9%" border="1" align="center"><strong>N</strong></td>
                            <td width="10%" border="1" align="center">$frenos->desequilibrio_2</td>
                            <td width="9%" border="1" align="center">$frenos->n_desequilibrio_B</td>
                            <td width="9%" border="1" align="center">$frenos->n_desequilibrio_A</td>
                            <td width="7%" border="1" align="center"><strong>%</strong></td>
                        </tr>
                        <tr>
                            <td width="5%" border="1" align="center"><strong>Eje 3</strong></td>
                            <td width="9%" border="1" align="center">$frenos->freno_3_izquierdo</td>
                            <td width="9%" border="1" align="center">$frenos->peso_3_izquierdo</td>
                            <td width="9%" border="1" align="center"><strong>N</strong></td>
                            <td width="5%" border="1" align="center"><strong>Eje 3</strong></td>
                            <td width="9%" border="1" align="center">$frenos->freno_3_derecho</td>
                            <td width="9%" border="1" align="center">$frenos->peso_3_derecho</td>
                            <td width="9%" border="1" align="center"><strong>N</strong></td>
                            <td width="10%" border="1" align="center">$frenos->desequilibrio_3</td>
                            <td width="9%" border="1" align="center">$frenos->n_desequilibrio_B</td>
                            <td width="9%" border="1" align="center">$frenos->n_desequilibrio_A</td>
                            <td width="7%" border="1" align="center"><strong>%</strong></td>
                        </tr>
                        <tr>
                            <td width="5%" border="1" align="center"><strong>Eje 4</strong></td>
                            <td width="9%" border="1" align="center">$frenos->freno_4_izquierdo</td>
                            <td width="9%" border="1" align="center">$frenos->peso_4_izquierdo</td>
                            <td width="9%" border="1" align="center"><strong>N</strong></td>
                            <td width="5%" border="1" align="center"><strong>Eje 4</strong></td>
                            <td width="9%" border="1" align="center">$frenos->freno_4_derecho</td>
                            <td width="9%" border="1" align="center">$frenos->peso_4_derecho</td>
                            <td width="9%" border="1" align="center"><strong>N</strong></td>
                            <td width="10%" border="1" align="center">$frenos->desequilibrio_4</td>
                            <td width="9%" border="1" align="center">$frenos->n_desequilibrio_B</td>
                            <td width="9%" border="1" align="center">$frenos->n_desequilibrio_A</td>
                            <td width="7%" border="1" align="center"><strong>%</strong></td>
                        </tr>
                        <tr>
                            <td width="5%" border="1" align="center"><strong>Eje 5</strong></td>
                            <td width="9%" border="1" align="center">$frenos->freno_5_izquierdo</td>
                            <td width="9%" border="1" align="center">$frenos->peso_5_izquierdo</td>
                            <td width="9%" border="1" align="center"><strong>N</strong></td>
                            <td width="5%" border="1" align="center"><strong>Eje 5</strong></td>
                            <td width="9%" border="1" align="center">$frenos->freno_5_derecho</td>
                            <td width="9%" border="1" align="center">$frenos->peso_5_derecho</td>
                            <td width="9%" border="1" align="center"><strong>N</strong></td>
                            <td width="10%" border="1" align="center">$frenos->desequilibrio_5</td>
                            <td width="9%" border="1" align="center">$frenos->n_desequilibrio_B</td>
                            <td width="9%" border="1" align="center">$frenos->n_desequilibrio_A</td>
                            <td width="7%" border="1" align="center"><strong>%</strong></td>
                        </tr>
                        <tr>
                            <td width="23%" border="1" align="center" rowspan="2"><br><br><strong>Eficacia Total</strong></td>
                            <td width="21%" border="1" align="center"><strong>Valor</strong></td>
                            <td width="20%" border="1" align="center"><strong>Minimo</strong></td>
                            <td width="35%" border="1" align="center"><strong>Unidad</strong></td>
                        </tr>
                        <tr>
                            <td width="21%" border="1" align="center">$frenos->eficacia_total</td>
                            <td width="20%" border="1" align="center">$frenos->n_eficacia_total</td>
                            <td width="35%" border="1" align="center"><strong>%</strong></td>
                        </tr>
        </table>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');

    //------------------------------------------------------------------------------FRENO AUXILIAR
    $html = <<<EOF
            <br>
        <table cellpadding="2" nobr="true">
                        <tr>
                            <td width="99%" align="center"><strong>6.1 FRENO AUXILIAR (Si aplica)</strong></td>
                        </tr>
                        <tr>
                            <td width="9%" style="
                                border-top: 1px solid black;
                                border-rigth: 1px solid black;
                                border-left: 1px solid black;" align="center"><strong>Eficacia</strong></td>
                            <td width="9%" style="
                                border-top: 1px solid black;
                                border-rigth: 1px solid black;
                                border-left: 1px solid black;" align="center"><strong>Mínimo</strong></td>
                            <td width="9%" style="
                                border-top: 1px solid black;
                                border-rigth: 1px solid black;
                                border-left: 1px solid black;" align="center"><strong>Unidad</strong></td>
                            <td width="9%" style="
                                border-top: 1px solid black;
                                border-bottom: 1px solid black;
                                border-left: 1px solid black;" align="center"><strong></strong></td>
                            <td width="9%" style="
                                border-top: 1px solid black;
                                border-bottom: 1px solid black" align="center"><strong>Fuerza</strong></td>
                            <td width="9%" style="
                                border-top: 1px solid black;
                                border-bottom: 1px solid black" align="center"><strong>Peso</strong></td>
                            <td width="9%" style="
                                border-top: 1px solid black;
                                border-bottom: 1px solid black;
                                border-rigth: 1px solid black;" align="center"><strong>Unidad</strong></td>
                            <td width="9%" style="
                                border-top: 1px solid black;
                                border-bottom: 1px solid black;
                                border-left: 1px solid black;" align="center"><strong></strong></td>
                            <td width="9%" style="
                                border-top: 1px solid black;
                                border-bottom: 1px solid black" align="center"><strong>Fuerza</strong></td>
                            <td width="9%" style="
                                border-top: 1px solid black;
                                border-bottom: 1px solid black" align="center"><strong>Peso</strong></td>
                            <td width="9%" style="
                                border-rigth: 1px solid black;
                                border-top: 1px solid black;
                                border-bottom: 1px solid black" align="center"><strong>Unidad</strong></td>
                            <td style="border-left: 1px solid black;" align="center"><strong></strong></td>
                        </tr>
                        <tr>
                            <td width="9%" style="
                                border-bottom: 1px solid black;
                                border-left: 1px solid black" align="center"><br><br>$frenos->eficacia_auxiliar</td>
                            <td width="9%" style="  
                                border-bottom: 1px solid black" align="center"><br><br>$frenos->n_eficacia_auxiliar</td>
                            <td width="9%" style="
                                border-bottom: 1px solid black;
                                border-rigth: 1px solid black" align="center"><br><br><strong>%</strong></td>
                            <td width="9%" style="
                                border-bottom: 1px solid black;
                                border-left: 1px solid black;
                                border-rigth: 1px solid black;" align="center"><strong>Sumatoria Izquierdo</strong></td>
                            <td width="9%" style="
                                border-top: 1px solid black;
                                border-bottom: 1px solid black" align="center"><br><br>$frenos->sum_freno_aux_izquierdo</td>
                            <td width="9%" style="
                                border-top: 1px solid black;
                                border-bottom: 1px solid black" align="center"><br><br>$frenos->sum_peso_izquierdo</td>
                            <td width="9%" style="
                                border-top: 1px solid black;
                                border-bottom: 1px solid black" align="center"><br><br><strong>N</strong></td>
                            <td width="9%" style="
                                border-top: 1px solid black;
                                border-left: 1px solid black;
                                border-bottom: 1px solid black" align="center"><strong>Sumatoria Derecho</strong></td>
                            <td width="9%" style="
                                border-top: 1px solid black;
                                border-bottom: 1px solid black" align="center"><br><br>$frenos->sum_freno_aux_derecho</td>
                            <td width="9%" style="
                                border-top: 1px solid black;
                                border-bottom: 1px solid black" align="center"><br><br>$frenos->sum_peso_derecho</td>
                            <td width="9%" style="
                                border-top: 1px solid black;
                                border-rigth: 1px solid black;
                                border-bottom: 1px solid black" align="center"><br><br><strong>N</strong></td>
                            <td style="border-left: 1px solid black;" align="center"><strong></strong></td>
                        </tr>
                         
        </table>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
}
//------------------------------------------------------------------------------DESVIACIÓN LATERAL
$showAli = true;
if ($alineacion->idprueba == '' && ($reins == '4444' || $reins == '44441')) {
    $showAli = false;
}
if ($showAli) {
    $html = <<<EOF
            <br>
        <table cellpadding="2" nobr="true">
                        <tr>
                            <td width="100%" align="center"><strong>7. DESVIACIÓN LATERAL (si aplica)</strong></td>
                        </tr>
                        <tr>
                            <td width="14%" style="
                                border-top: 1px solid black;
                                border-left: 1px solid black"><strong>Eje 1</strong></td>
                            <td width="14%" style="
                                border-top: 1px solid black;
                                border-left: 1px solid black"><strong>Eje 2</strong></td>
                            <td width="14%" style="
                                border-top: 1px solid black;
                                border-left: 1px solid black"><strong>Eje 3</strong></td>
                            <td width="14%" style="
                                border-top: 1px solid black;
                                border-left: 1px solid black"><strong>Eje 4</strong></td>
                            <td width="14%" style="
                                border-top: 1px solid black;
                                border-left: 1px solid black"><strong>Eje 5</strong></td>
                            <td width="15%" style="
                                border-top: 1px solid black;
                                border-left: 1px solid black" align="center"><strong>Máximo</strong></td>
                            <td width="14%" style="
                                border-top: 1px solid black;" align="center"><strong>Unidad</strong></td>
                            <td style="border-left: 1px solid black;" align="center"><strong></strong></td>
                        </tr>
                        <tr>
                            <td width="14%" style="
                                border-bottom: 1px solid black;
                                border-left: 1px solid black" align="center">$alineacion->alineacion_1</td>
                            <td width="14%" style="
                                border-bottom: 1px solid black;
                                border-left: 1px solid black" align="center">$alineacion->alineacion_2</td>
                            <td width="14%" style="
                                border-bottom: 1px solid black;
                                border-left: 1px solid black" align="center">$alineacion->alineacion_3</td>
                            <td width="14%" style="
                                border-bottom: 1px solid black;
                                border-left: 1px solid black" align="center">$alineacion->alineacion_4</td>
                            <td width="14%" style="
                                border-bottom: 1px solid black;
                                border-left: 1px solid black" align="center">$alineacion->alineacion_5</td>
                            <td width="15%" style="
                                border-bottom: 1px solid black;
                                border-left: 1px solid black" align="center">$alineacion->minmax</td>
                            <td width="14%" style="
                                border-bottom: 1px solid black;" align="center"><strong>m/Km</strong></td>
                            <td style="border-left: 1px solid black;" align="center"><strong></strong></td>
                        </tr>
                         
        </table>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
}
//------------------------------------------------------------------------------DISPOSIIVO DE COBRO
$showTax = true;
if ($taximetro->idprueba == '' && ($reins == '4444' || $reins == '44441')) {
    $showTax = false;
}
if ($showTax) {
    $html = <<<EOF
            <br>
        <table cellpadding="2" nobr="true">
                        <tr>
                            <td width="100%" align="center"><strong>8. DISPOSITIVOS DE COBRO (si aplica)</strong></td>
                        </tr>
                        <tr>
                            <td width="25%" style="
                                border-top: 1px solid black;
                                border-left: 1px solid black"><strong>Tamaño normalizado de la Llanta</strong></td>
                            <td width="14%" style="
                                border-top: 1px solid black;
                                border-left: 1px solid black" align="center"><strong>Error en distancia</strong></td>
                            <td width="10%" style="
                                border-top: 1px solid black;" align="center"><strong>Unidad</strong></td>
                            <td width="14%" style="
                                border-top: 1px solid black;
                                border-left: 1px solid black" align="center"><strong>Error en tiempo</strong></td>
                            <td width="10%" style="
                                border-top: 1px solid black;" align="center"><strong>Unidad</strong></td>
                            <td width="14%" style="
                                border-top: 1px solid black;
                                border-left: 1px solid black" align="center"><strong>Máximo</strong></td>
                            <td width="12%" style="
                                border-top: 1px solid black" align="center"><strong>Unidad</strong></td>
                            <td style="border-left: 1px solid black;" align="center"><strong></strong></td>
                        </tr>
                        <tr>
                            <td width="25%" style="
                                border-bottom: 1px solid black;
                                border-left: 1px solid black" align="center">$taximetro->r_llanta</td>
                            <td width="14%" style="
                                border-bottom: 1px solid black;
                                border-left: 1px solid black" align="center">$taximetro->distancia</td>
                            <td width="10%" style="
                                border-bottom: 1px solid black;" align="center"><strong>%</strong></td>
                            <td width="14%" style="
                                border-bottom: 1px solid black;
                                border-left: 1px solid black" align="center">$taximetro->tiempo</td>
                            <td width="10%" style="
                                border-bottom: 1px solid black;" align="center"><strong>%</strong></td>
                            <td width="14%" style="
                                border-bottom: 1px solid black;
                                border-left: 1px solid black" align="center">$taximetro->minmax</td>
                            <td width="12%" style="
                                border-bottom: 1px solid black" align="center"><strong>%</strong></td>
                            <td style="border-left: 1px solid black;" align="center"><strong></strong></td>
                        </tr>
        </table>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
}
//------------------------------------------------------------------------------EMISIONES DE GASES
//------------------------------------------------------------------------------VEHÍCULOS CICLO OTTO, 4T o 2T
if ($vehiculo->tipo_vehiculo !== "3") {
    $coFlagRa = $gases->CoFlag;
    $co2FlagRa = $gases->Co2Flag;
    $o2FlagRa = $gases->O2Flag;
    $hcFlagRa = $gases->HcFlag;
    $coFlagCr = $gases->CoFlag;
    $co2FlagCr = $gases->Co2Flag;
    $o2FlagCr = $gases->O2Flag;
    $hcFlagCr = $gases->HcFlag;
} else {
    $coFlagRa = $gases->CoFlag;
    $co2FlagRa = $gases->Co2Flag;
    $o2FlagRa = $gases->O2Flag;
    $hcFlagRa = $gases->HcFlag;
    $coFlagCr = '';
    $co2FlagCr = '';
    $o2FlagCr = '';
    $hcFlagCr = '';
}
$showGas = true;
if ($gases->idprueba == '' && ($reins == '4444' || $reins == '44441')) {
    $showGas = false;
}
if ($showGas) {
    $html = <<<EOF
            <br>
        <table cellpadding="2" nobr="true">
                        <tr>
                            <td width="100%" align="center"><strong>9. EMISIONES DE GASES (Exentos vehículos a motor Eléctrico e Hidrógeno)</strong></td>
                        </tr>
                        <tr>
                            <td width="100%" align="center"><strong>9a. VEHÍCULOS CICLO OTTO, 4T o 2T</strong></td>
                        </tr>
                        <tr>
                            <td width="15%" style="
                                border-top: 1px solid black;
                                border-left: 1px solid black" align="center"><strong></strong></td>
                            <td width="17%" border="1" align="center"><strong>Monóxido de Carbono</strong></td>
                            <td width="17%" border="1" align="center"><strong>Dióxido de carbono</strong></td>
                            <td width="17%" border="1" align="center"><strong>Oxigeno</strong></td>
                            <td width="17%" border="1" align="center"><strong>Hidrocarburo (hexano)</strong></td>
                            <td width="16%" border="1" align="center"><strong>Óxido Nitroso</strong></td>
                        </tr>
                        <tr>
                            <td width="8%" style="
                                border-left: 1px solid black" align="center"><strong></strong></td>
                            <td width="7%" align="center"><strong>(rpm)</strong></td>
                            <td width="5%" style="
                                border-left: 1px solid black" align="center"><strong>(CO)</strong></td>
                            <td width="6%" style="
                                border-left: 1px solid black" align="center"><strong>Norma</strong></td>
                            <td width="6%" style="
                                border-left: 1px solid black" align="center"><strong>Unidad</strong></td>
                            <td width="5%" style="
                                border-left: 1px solid black" align="center"><strong>(CO<sub>2</sub>)</strong></td>
                            <td width="6%" style="
                                border-left: 1px solid black" align="center"><strong>Norma</strong></td>
                            <td width="6%" style="
                                border-left: 1px solid black" align="center"><strong>Unidad</strong></td>
                            <td width="5%" style="
                                border-left: 1px solid black" align="center"><strong>(O<sub>2</sub>)</strong></td>
                            <td width="6%" style="
                                border-left: 1px solid black" align="center"><strong>Norma</strong></td>
                            <td width="6%" style="
                                border-left: 1px solid black" align="center"><strong>Unidad</strong></td>
                            <td width="5%" style="
                                border-left: 1px solid black" align="center"><strong>(HC)</strong></td>
                            <td width="6%" style="
                                border-left: 1px solid black" align="center"><strong>Norma</strong></td>
                            <td width="6%" style="
                                border-left: 1px solid black" align="center"><strong>Unidad</strong></td>
                            <td width="5%" style="
                                border-left: 1px solid black" align="center"><strong>(NOx)</strong></td>
                            <td width="6%" style="
                                border-left: 1px solid black" align="center"><strong>Norma</strong></td>
                            <td width="5%" style="
                                border-left: 1px solid black;font-size: 7.3px"  align="center"><strong>Unidad</strong></td>
                            <td style="border-left: 1px solid black;" align="center"><strong></strong></td>
                        </tr>
                        <tr>
                            <td width="8%" style="
                                border-left: 1px solid black" align="center"><strong>Ralentí</strong></td>
                            <td width="7%" align="center">$gases->rpm_ralenti</td>
                            <td width="5%" style="
                                border-left: 1px solid black" align="center">$gases->co_ralenti</td>
                            <td width="6%" align="center"><strong>$coFlagRa</strong></td>
                            <td width="6%" align="center"><strong>%</strong></td>
                            <td width="5%" style="
                                border-left: 1px solid black" align="center">$gases->co2_ralenti</td>
                            <td width="6%" align="center"><strong>$co2FlagRa</strong></td>
                            <td width="6%" align="center"><strong>%</strong></td>
                            <td width="5%" style="
                                border-left: 1px solid black" align="center">$gases->o2_ralenti</td>
                            <td width="6%" align="center"><strong>$o2FlagRa</strong></td>
                            <td width="6%" align="center"><strong>%</strong></td>
                            <td width="5%" style="
                                border-left: 1px solid black" align="center">$gases->hc_ralenti</td>
                            <td width="6%" align="center"><strong>$hcFlagRa</strong></td>
                            <td width="6%" align="center"><strong>(ppm)</strong></td>
                            <td width="5%" style="
                                border-left: 1px solid black" align="center"></td>
                            <td width="6%" align="center"><strong></strong></td>
                            <td width="5%" align="center"><strong>%</strong></td>
                            <td style="border-left: 1px solid black;" align="center"><strong></strong></td>
                        </tr>
                        <tr>
                            <td width="8%" style="
                                border-left: 1px solid black;
                                border-top: 1px solid black" align="center"><strong>Crucero</strong></td>
                            <td width="7%" align="center">$gases->rpm_crucero</td>
                            <td width="5%" style="
                                border-left: 1px solid black" align="center">$gases->co_crucero</td>
                            <td width="6%" align="center"><strong>$coFlagCr</strong></td>
                            <td width="6%" align="center"><strong>%</strong></td>
                            <td width="5%" style="
                                border-left: 1px solid black" align="center">$gases->co2_crucero</td>
                            <td width="6%" align="center"><strong>$co2FlagCr</strong></td>
                            <td width="6%" align="center"><strong>%</strong></td>
                            <td width="5%" style="
                                border-left: 1px solid black" align="center">$gases->o2_crucero</td>
                            <td width="6%" align="center"><strong>$o2FlagCr</strong></td>
                            <td width="6%" align="center"><strong>%</strong></td>
                            <td width="5%" style="
                                border-left: 1px solid black" align="center">$gases->hc_crucero</td>
                            <td width="6%" align="center"><strong>$hcFlagCr</strong></td>
                            <td width="6%" align="center"><strong>(ppm)</strong></td>
                            <td width="5%" style="
                                border-left: 1px solid black" align="center"></td>
                            <td width="6%" align="center"><strong></strong></td>
                            <td width="5%" align="center"><strong>%</strong></td>
                            <td style="border-left: 1px solid black;" align="center"><strong></strong></td>
                        </tr>
                        <tr>
                            <td width="32%" border="1" align="center"><strong>Vehículo con catalizador (SI) (NO) (N.A)</strong></td>
                            <td width="17%" border="1" align="center">$vehiculo->convertidorCat</td>
                            <td width="34%" border="1" align="center"><strong>Valor</strong></td>
                            <td width="16%" border="1" align="center"><strong>Unidad</strong></td>
                        </tr>
                        <tr>
                            <td width="32%" border="1" align="center"><strong>Temperatura de prueba</strong></td>
                            <td width="17%" border="1" align="center"><strong>Temperatura</strong></td>
                            <td width="34%" border="1" align="center">$gases->temperatura</td>
                            <td width="16%" border="1" align="center"><strong>°C</strong></td>
                        </tr>
                        <tr>
                            <td width="32%" border="1" align="center" rowspan="2"><br><br><strong>Condiciones Ambientales</strong></td>
                            <td width="17%" border="1" align="center"><strong>Temperatura Ambiente</strong></td>
                            <td width="34%" border="1" align="center">$gases->temperatura_ambiente</td>
                            <td width="16%" border="1" align="center"><strong>°C</strong></td>
                        </tr>
                        <tr>
                            <td width="17%" border="1" align="center"><strong>Humedad Relativa</strong></td>
                            <td width="34%" border="1" align="center">$gases->humedad</td>
                            <td width="16%" border="1" align="center"><strong>%</strong></td>
                        </tr>
        </table>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
}
//------------------------------------------------------------------------------VEHÍCULOS CICLO DIESEL
$showOpa = true;
if ($opacidad->idprueba == '' && ($reins == '4444' || $reins == '44441')) {
    $showOpa = false;
}
if ($showOpa) {
    if ($opacidad->idprueba == '') {
        $vehiculo->diametro_escape = "";
    }
    $html = <<<EOF
            <br>
        <table cellpadding="2" nobr="true">
                        <tr>
                            <td width="100%" align="center"><strong>9b. VEHÍCULOS CICLO DIESEL</strong></td>
                        </tr>
                        <tr>
                            <td width="8%" style="
                                border-top: 1px solid black;
                                border-left: 1px solid black" align="center"><strong></strong></td>
                            <td width="7%" border="1" align="center"><strong>Ciclo 1</strong></td>
                            <td width="7%" border="1" align="center"><strong>Unidad</strong></td>
                            <td width="7%" border="1" align="center"><strong>Ciclo 2</strong></td>
                            <td width="7%" border="1" align="center"><strong>Unidad</strong></td>
                            <td width="7%" border="1" align="center"><strong>Ciclo 3</strong></td>
                            <td width="7%" border="1" align="center"><strong>Unidad</strong></td>
                            <td width="7%" border="1" align="center"><strong>Ciclo 4</strong></td>
                            <td width="8%" border="1" align="center"><strong>Unidad</strong></td>
                            <td width="8%" style="
                                border-top: 1px solid black" align="center"><strong></strong></td>
                            <td width="9%" style="
                                border-top: 1px solid black" align="center"><strong>Valor</strong></td>
                            <td width="9%" style="
                                border-top: 1px solid black" align="center"><strong>Norma</strong></td>
                            <td width="8%" style="
                                border-top: 1px solid black" align="center"><strong>Unidad</strong></td>
                            <td style="border-left: 1px solid black;" align="center"><strong></strong></td>
                        </tr>
                        <tr>
                            <td width="8%" style="
                                border-left: 1px solid black" align="center"><strong>Opacidad</strong></td>
                            <td width="7%" style="
                                border-left: 1px solid black" align="center">$opacidad->op_ciclo1</td>
                            <td width="7%" style="
                                border-left: 1px solid black" align="center"><strong>$opacidad->unidad</strong></td>
                            <td width="7%" style="
                                border-left: 1px solid black" align="center">$opacidad->op_ciclo2</td>
                            <td width="7%" style="
                                border-left: 1px solid black" align="center"><strong>$opacidad->unidad</strong></td>
                            <td width="7%" style="
                                border-left: 1px solid black" align="center">$opacidad->op_ciclo3</td>
                            <td width="7%" style="
                                border-left: 1px solid black" align="center"><strong>$opacidad->unidad</strong></td>
                            <td width="7%" style="
                                border-left: 1px solid black" align="center">$opacidad->op_ciclo4</td>
                            <td width="8%" style="
                                border-left: 1px solid black" align="center"><strong>$opacidad->unidad</strong></td>
                            <td width="8%" style="
                                border-top: 1px solid black;
                                border-left: 1px solid black" align="center"><strong>Resultado</strong></td>
                            <td width="9%" style="
                                border-top: 1px solid black" align="center">$opacidad->opacidad_total</td>
                            <td width="9%" style="
                                border-top: 1px solid black" align="center"><strong>$opacidad->max</strong></td>
                            <td width="8%" style="
                                border-top: 1px solid black" align="center"><strong>$opacidad->unidad</strong></td>
                            <td style="border-left: 1px solid black;" align="center"><strong></strong></td>
                        </tr>
                        <tr>
                            <td width="8%" style="
                                border-left: 1px solid black" align="center"><strong>Gobernada</strong></td>
                            <td width="7%" style="
                                border-left: 1px solid black" align="center">$opacidad->rpm_ciclo1</td>
                            <td width="7%" style="
                                border-left: 1px solid black" align="center"><strong>(rpm)</strong></td>
                            <td width="7%" style="
                                border-left: 1px solid black" align="center">$opacidad->rpm_ciclo2</td>
                            <td width="7%" style="
                                border-left: 1px solid black" align="center"><strong>(rpm)</strong></td>
                            <td width="7%" style="
                                border-left: 1px solid black" align="center">$opacidad->rpm_ciclo3</td>
                            <td width="7%" style="
                                border-left: 1px solid black" align="center"><strong>(rpm)</strong></td>
                            <td width="7%" style="
                                border-left: 1px solid black" align="center">$opacidad->rpm_ciclo4</td>
                            <td width="8%" style="
                                border-left: 1px solid black" align="center"><strong>(rpm)</strong></td>
                            <td width="8%" style="
                                border-left: 1px solid black" align="center"><strong></strong></td>
                            <td width="9%"  align="center"><strong></strong></td>
                            <td width="9%"  align="center"><strong></strong></td>
                            <td width="8%"  align="center"><strong></strong></td>
                            <td style="border-left: 1px solid black;" align="center"><strong></strong></td>
                        </tr>
                        <tr>
                            <td width="8%" style="
                                border-left: 1px solid black;
                                border-top: 1px solid black" align="center"><strong>(rpm)</strong></td>
                            <td width="28%" style="
                                border-left: 1px solid black;
                                border-top: 1px solid black" align="center"><strong>Temperatura de operación del motor</strong></td>
                            <td width="46%" style="
                                border-left: 1px solid black;
                                border-top: 1px solid black" align="center"><strong>Condiciones Ambientales</strong></td>
                            <td width="9%" style="
                                border-left: 1px solid black;
                                border-top: 1px solid black" align="center"><strong>LTOE</strong></td>
                            <td width="8%" style="
                                border-left: 1px solid black;
                                border-top: 1px solid black;
                                border-rigth: 1px solid black;" align="center"><strong></strong></td>
                            <td style="border-left: 1px solid black;" align="center"><strong></strong></td>
                        </tr>
                        <tr>
                            <td width="8%" style="
                                border-left: 1px solid black" align="center"><strong>Ralenti</strong></td>
                            <td width="10%" style="
                                border-left: 1px solid black;
                                border-top: 1px solid black" align="center"><strong>Temp-Inicial</strong></td>
                            <td width="10%" style="
                                border-left: 1px solid black;
                                border-top: 1px solid black" align="center"><strong>Temp-Final</strong></td>
                            <td width="8%" style="
                                border-left: 1px solid black;
                                border-top: 1px solid black" align="center"><strong>Unidad</strong></td>
                            <td width="16%" style="
                                border-left: 1px solid black;
                                border-top: 1px solid black" align="center"><strong>Temperatura ambiente</strong></td>
                            <td width="7%" style="
                                border-left: 1px solid black;
                                border-top: 1px solid black" align="center"><strong>Unidad</strong></td>
                            <td width="16%" style="
                                border-left: 1px solid black;
                                border-top: 1px solid black" align="center"><strong>Humedad Relativa</strong></td>
                            <td width="7%" style="
                                border-left: 1px solid black;
                                border-top: 1px solid black" align="center"><strong>Unidad</strong></td>
                            <td width="9%" style="
                                border-left: 1px solid black;" align="center"><strong>estándar</strong></td>
                            <td width="8%" style="
                                border-left: 1px solid black;
                                border-rigth: 1px solid black;" align="center"><strong>Unidad</strong></td>
                            <td style="border-left: 1px solid black;" align="center"><strong></strong></td>
                        </tr>
                        <tr>
                            <td width="8%" style="
                                border-left: 1px solid black;
                                border-bottom: 1px solid black" align="center">$opacidad->rpm_ralenti</td>
                            <td width="10%" style="
                                border-left: 1px solid black;
                                border-bottom: 1px solid black" align="center">$opacidad->temp_inicial</td>
                            <td width="10%" style="
                                border-left: 1px solid black;
                                border-bottom: 1px solid black" align="center">$opacidad->temp_final</td>
                            <td width="8%" style="
                                border-left: 1px solid black;
                                border-bottom: 1px solid black" align="center"><strong>°C</strong></td>
                            <td width="16%" style="
                                border-left: 1px solid black;
                                border-bottom: 1px solid black" align="center">$opacidad->temp_ambiente</td>
                            <td width="7%" style="
                                border-left: 1px solid black;
                                border-bottom: 1px solid black" align="center"><strong>°C</strong></td>
                            <td width="16%" style="
                                border-left: 1px solid black;
                                border-bottom: 1px solid black" align="center">$opacidad->humedad</td>
                            <td width="7%" style="
                                border-left: 1px solid black;
                                border-bottom: 1px solid black" align="center"><strong>%</strong></td>
                            <td width="9%" style="
                                border-left: 1px solid black;
                                border-bottom: 1px solid black" align="center">$vehiculo->diametro_escape</td>
                            <td width="8%" style="
                                border-left: 1px solid black;
                                border-rigth: 1px solid black;
                                border-bottom: 1px solid black" align="center"><strong>mm</strong></td>
                            <td style="border-left: 1px solid black;" align="center"><strong></strong></td>
                        </tr>
        </table>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
}
//------------------------------------------------------------------------------LISTADO DEFECTOS MECANIZADOS
$html = <<<EOF
        <br>
        <table>
        <tr>
        <td >$tituloC</td>
                        </tr>
        </table>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');

$defMA = "";
$countDedMeqA = "";
if (count($defectosMecanizadosA) > 0) {
    $countDedMeqA = count($defectosMecanizadosA);
    foreach ($defectosMecanizadosA as $def) {
        if ($def->tipo == "A") {
            $tipo = '<td width="10%" border="1" align="center">X</td>
               <td width="9%" border="1" align="center"></td>';
        } else {
            $tipo = '<td width="10%" border="1" align="center"></td>
               <td width="9%" border="1" align="center">X</td>';
        }
        $defMA = $defMA .
            '<tr>
                            <td width="10%" border="1" align="center"><strong>' . $def->codigo . '</strong></td>
                            <td width="45%" border="1" style="text-align: justify" >' . $def->descripcion . '</td>
                            <td width="25%" border="1" >' . $def->grupo . '</td>
                            ' . $tipo . '
                        </tr>';
    }
} else {
    $tipo = '<tr>
                            <td width="10%" border="1" align="center"></td>
                            <td width="45%" border="1" align="center"></td>
                            <td width="25%" border="1" align="center"></td>
                            <td width="10%" border="1" align="center"></td>
                            <td width="9%" border="1" align="center"></td>
                        </tr>';
}

$defMB = "";
$countDedMeqB = "";
if (count($defectosMecanizadosB) > 0) {
    $countDedMeqB = count($defectosMecanizadosB);
    foreach ($defectosMecanizadosB as $def) {
        if ($def->tipo == "A") {
            $tipo = '<td width="10%" border="1" align="center">X</td>
               <td width="9%" border="1" align="center"></td>';
        } else {
            $tipo = '<td width="10%" border="1" align="center"></td>
               <td width="9%" border="1" align="center">X</td>';
        }
        $defMB = $defMB .
            '<tr>
                            <td width="10%" border="1" align="center"><strong>' . $def->codigo . '</strong></td>
                            <td width="45%" border="1" style="text-align: justify" >' . $def->descripcion . '</td>
                            <td width="25%" border="1" >' . $def->grupo . '</td>
                            ' . $tipo . '
                        </tr>';
    }
}

$html = <<<EOF
        <br>
        <table cellpadding="2" nobr="true">
                        <tr>
                            <td width="10%" border="1" align="center" rowspan="2"><strong>Código</strong></td>
                            <td width="45%" border="1" align="center" rowspan="2"><strong>Descripción</strong></td>
                            <td width="25%" border="1" align="center" rowspan="2"><strong>Grupo</strong></td>
                            <td width="19%" border="1" align="center"><strong>Tipo de defecto</strong></td>
                        </tr>
                        <tr>
                            <td width="10%" border="1" align="center"><strong>A</strong></td>
                            <td width="9%" border="1" align="center"><strong>B</strong></td>
                        </tr>
                        $defMA
                        $defMB
                        <tr>
                            <td width="80%" align="rigth"><strong>TOTAL</strong></td>
                            <td width="10%" border="1" align="center"><strong>$countDedMeqA</strong></td>
                            <td width="9%" border="1" align="center"><strong>$countDedMeqB</strong></td>
                        </tr>
        </table>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');

//------------------------------------------------------------------------------LISTADO DEFECTOS SENSORIALES

$defSA = "";
$countDefSenA = "";
if (count($defectosSensorialesA) > 0) {
    $countDefSenA = count($defectosSensorialesA);
    foreach ($defectosSensorialesA as $def) {
        if ($def->tipo == "A") {
            $tipo = '<td width="10%" border="1" align="center">X</td>
               <td width="9%" border="1" align="center"></td>';
        } else {
            $tipo = '<td width="10%" border="1" align="center"></td>
               <td width="9%" border="1" align="center">X</td>';
        }
        $defSA = $defSA .
            '<tr>
                            <td width="10%" border="1" align="center"><strong>' . $def->codigo . '</strong></td>
                            <td width="45%" border="1" style="text-align: justify" >' . $def->descripcion . '</td>
                            <td width="25%" border="1" >' . $def->grupo . '</td>
                            ' . $tipo . '
                        </tr>';
    }
} else {
    $tipo = '<tr>
                            <td width="10%" border="1" align="center"></td>
                            <td width="45%" border="1" align="center"></td>
                            <td width="25%" border="1" align="center"></td>
                            <td width="10%" border="1" align="center"></td>
                            <td width="10%" border="1" align="center"></td>
                        </tr>';
}

$defSB = "";
$countDefSenB = "";
if (count($defectosSensorialesB) > 0) {
    $countDefSenB = count($defectosSensorialesB);
    foreach ($defectosSensorialesB as $def) {
        if ($def->tipo == "A") {
            $tipo = '<td width="10%" border="1" align="center">X</td>
               <td width="9%" border="1" align="center"></td>';
        } else {
            $tipo = '<td width="10%" border="1" align="center"></td>
               <td width="9%" border="1" align="center">X</td>';
        }
        $defSB = $defSB .
            '<tr>
                            <td width="10%" border="1" align="center"><strong>' . $def->codigo . '</strong></td>
                            <td width="45%" border="1" style="text-align: justify" >' . $def->descripcion . '</td>
                            <td width="25%" border="1" >' . $def->grupo . '</td>
                            ' . $tipo . '
                        </tr>';
    }
}
$html = <<<EOF
        <br>
        <table>
        <tr>
        <td >$tituloD</td>
                        </tr>
        </table>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');
$html = <<<EOF
        <br>
        <table cellpadding="2" nobr="true">
                        <tr>
                            <td width="10%" border="1" align="center" rowspan="2"><strong>Código</strong></td>
                            <td width="45%" border="1" align="center" rowspan="2"><strong>Descripción</strong></td>
                            <td width="25%" border="1" align="center" rowspan="2"><strong>Grupo</strong></td>
                            <td width="19%" border="1" align="center"><strong>Tipo de defecto</strong></td>
                        </tr>
                        <tr>
                            <td width="10%" border="1" align="center"><strong>A</strong></td>
                            <td width="9%" border="1" align="center"><strong>B</strong></td>
                        </tr>
                        $defSA
                        $defSB
                        <tr>
                            <td width="80%" align="rigth"><strong>TOTAL</strong></td>
                            <td width="10%" border="1" align="center"><strong>$countDefSenA</strong></td>
                            <td width="9%" border="1" align="center"><strong>$countDefSenB</strong></td>
                        </tr>
        </table>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');
//------------------------------------------------------------------------------LISTADO DEFECTOS SENSORIALES ENSEÑANZA
$defEA = "";
$countDefEnsA = "";
if (count($defectosEnsenanzaA) > 0) {
    $countDefEnsA = count($defectosEnsenanzaA);
    foreach ($defectosEnsenanzaA as $def) {
        if ($def->tipo == "A") {
            $tipo = '<td width="10%" border="1" align="center">X</td>
               <td width="9%" border="1" align="center"></td>';
        } else {
            $tipo = '<td width="10%" border="1" align="center"></td>
               <td width="9%" border="1" align="center">X</td>';
        }
        $defEA = $defEA .
            '<tr>
                            <td width="10%" border="1" align="center"><strong>' . $def->codigo . '</strong></td>
                            <td width="45%" border="1" style="text-align: justify" >' . $def->descripcion . '</td>
                            <td width="25%" border="1" >' . $def->grupo . '</td>
                            ' . $tipo . '
                        </tr>';
    }
} else {
    $tipo = '<tr>
                            <td width="10%" border="1" align="center"></td>
                            <td width="45%" border="1" align="center"></td>
                            <td width="25%" border="1" align="center"></td>
                            <td width="10%" border="1" align="center"></td>
                            <td width="9%" border="1" align="center"></td>
                        </tr>';
}

$defEB = "";
$countDefEnsB = "";
if (count($defectosEnsenanzaB) > 0) {
    $countDefEnsB = count($defectosEnsenanzaB);
    foreach ($defectosEnsenanzaB as $def) {
        if ($def->tipo == "A") {
            $tipo = '<td width="10%" border="1" align="center">X</td>
               <td width="9%" border="1" align="center"></td>';
        } else {
            $tipo = '<td width="10%" border="1" align="center"></td>
               <td width="9%" border="1" align="center">X</td>';
        }
        $defEB = $defEB .
            '<tr>
                            <td width="10%" border="1" align="center"><strong>' . $def->codigo . '</strong></td>
                            <td width="45%" border="1" style="text-align: justify" >' . $def->descripcion . '</td>
                            <td width="25%" border="1" >' . $def->grupo . '</td>
                            ' . $tipo . '
                        </tr>';
    }
}
$html = <<<EOF
        <br>
        <table>
        <tr>
        <td ><strong>D1. DEFECTOS ENCONTRADOS EN LA INSPECCIÓN SENSORIAL DE LOS VEHÍCULOS UTILIZADOS PARA IMPARTIR LA ENSEÑANZA AUTOMOVILÍSTICA.</strong></td>
                        </tr>
        </table>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');
$html = <<<EOF
        <br>
        <table cellpadding="2" nobr="true">
                        <tr>
                            <td width="10%" border="1" align="center" rowspan="2"><strong>Código</strong></td>
                            <td width="45%" border="1" align="center" rowspan="2"><strong>Descripción</strong></td>
                            <td width="25%" border="1" align="center" rowspan="2"><strong>Grupo</strong></td>
                            <td width="19%" border="1" align="center"><strong>Tipo de defecto</strong></td>
                        </tr>
                        <tr>
                            <td width="10%" border="1" align="center"><strong>A</strong></td>
                            <td width="9%" border="1" align="center"><strong>B</strong></td>
                        </tr>
                        $defEA
                        $defEB
                        <tr>
                            <td width="80%" align="rigth"><strong>TOTAL</strong></td>
                            <td width="10%" border="1" align="center"><strong>$countDefEnsA</strong></td>
                            <td width="9%" border="1" align="center"><strong>$countDefEnsB</strong></td>
                        </tr>
        </table>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');

//------------------------------------------------------------------------------PROFUNIDAD DE LABRADO
$html = <<<EOF
        <br>
    <label style="text-align: justify;"><strong>D2. REGISTRO DE LA PROFUNDIDAD DE LABRADO Y PRESIÓN DE LAS LLANTAS</strong></label><br>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');

$html = <<<EOF
        <br>
        <table cellpadding="2" nobr="true">
                        <tr>
                            <td width="16%" border="1" align="center"><strong></strong></td>  
                            <td width="14%" border="1" align="center"><strong>Eje 1 (mm)</strong></td>
                            <td width="14%" border="1" align="center"><strong>Eje 2 (mm)</strong></td>
                            <td width="14%" border="1" align="center"><strong>Eje 3 (mm)</strong></td>
                            <td width="14%" border="1" align="center"><strong>Eje 4 (mm)</strong></td>
                            <td width="14%" border="1" align="center"><strong>Eje 5 (mm)</strong></td>
                            <td width="13%" border="1" align="center"><strong>Repuesto (mm)</strong></td>
                        </tr>
                        <tr>
                            <td width="16%" border="1" align="center"><strong>IZQUIERDA</strong></td>  
                            <td width="14%" border="1" align="center">$labrado->eje1_izquierdo</td>
                            <td width="7%" border="1" align="center">$labrado->eje2_izquierdo</td>
                            <td width="7%" border="1" align="center">$labrado->eje2_izquierdo_interior</td>
                            <td width="7%" border="1" align="center">$labrado->eje3_izquierdo</td>
                            <td width="7%" border="1" align="center">$labrado->eje3_izquierdo_interior</td>
                            <td width="7%" border="1" align="center">$labrado->eje4_izquierdo</td>
                            <td width="7%" border="1" align="center">$labrado->eje4_izquierdo_interior</td>
                            <td width="7%" border="1" align="center">$labrado->eje5_izquierdo</td>
                            <td width="7%" border="1" align="center">$labrado->eje5_izquierdo_interior</td>
                            <td width="7%" border="1" rowspan="2" align="center"><br><br>$labrado->repuesto</td>
                            <td width="6%" border="1" rowspan="2" align="center"><br><br>$labrado->repuesto2</td>
                        </tr>
                        <tr>
                            <td width="16%" border="1" align="center"><strong>DERECHA</strong></td>  
                            <td width="14%" border="1" align="center">$labrado->eje1_derecho</td>
                            <td width="7%" border="1" align="center">$labrado->eje2_derecho</td>
                            <td width="7%" border="1" align="center">$labrado->eje2_derecho_interior</td>
                            <td width="7%" border="1" align="center">$labrado->eje3_derecho</td>
                            <td width="7%" border="1" align="center">$labrado->eje3_derecho_interior</td>
                            <td width="7%" border="1" align="center">$labrado->eje4_derecho</td>
                            <td width="7%" border="1" align="center">$labrado->eje4_derecho_interior</td>
                            <td width="7%" border="1" align="center">$labrado->eje5_derecho</td>
                            <td width="7%" border="1" align="center">$labrado->eje5_derecho_interior</td>
                        </tr>
        </table>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');

//-----------------------------------------------------------------------------
if ($reins == '0' || $reins == '1' || $reins == '8888') {
    $html = <<<EOF
            <br>
        <table cellpadding="2" nobr="true">
                        <tr>
                            <td width="10%">Nota:</td>  
                            <td width="89%" align="justify">Defectos tipo A: Son aquellos defectos graves que implican un peligro inminente para la seguridad del vehículo, la de otros vehículos, la de sus ocupantes, la de los usuarios de la vía pública o el ambiente.<br>Defectos tipo B: Son aquellos defectos que implican un peligro potencial para la seguridad del vehículo, la de otros vehículos, la de sus ocupantes, la de los usuarios de la vía pública.</td>
                        </tr>
        </table>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
}
//-----------------------------------------------------------------------------
if ($reins == '0' || $reins == '1' || $reins == '8888') {
    $html = <<<EOF
            <br>
    <label style="text-align: justify;">$tituloE</label><br>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');

    $html = <<<EOF
            <br>
        <table cellpadding="5" nobr="true">
                        <tr>
                            <td width="50%" border="1" align="center"><strong>$apro</strong></td>  
                            <td width="49%" border="1" ><strong>No Consecutivo RUNT:</strong> $numero_consecutivo</td>
                        </tr>
                        <tr>
                            <td width="99%" border="1" ><strong>E.1. ¿Cumple con las adaptaciones para vehículos de enseñanza automovilística? (Solo para vehículos de este tipo)<br><br>$aproE</strong></td>
                        </tr>
        </table>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
} else {
    $html = <<<EOF
    <label style="text-align: justify;">$tituloE</label>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');

    $html = <<<EOF
        <table cellpadding="5" nobr="true">
                        <tr>
                            <td width="100%" border="1" align="center"><strong>$apro</strong></td>
                        </tr>
                        <tr>
                            <td width="100%" border="1" ><strong>E.1. ¿Cumple con las adaptaciones para vehículos de enseñanza automovilística? (Solo para vehículos de este tipo)<br><br>$aproE</strong></td>
                        </tr>
        </table>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
}
//------------------------------------------------------------------------------
if ($reins == '0' || $reins == '1' || $reins == '8888') {
    $html = <<<EOF
            <br>
    <label style="text-align: justify;"><strong>Nota: Causal de Rechazo</strong></label>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
    $html = <<<EOF
            <br>
        <table>
                        <tr>
                            <td width="2%">a)</td>  
                            <td >Se encuentra al menos un defecto Tipo A.</td>
                        </tr>
                        <tr>
                            <td width="2%">b)</td>  
                            <td width="98%">La cantidad total de defectos tipo B sea:</td>
                        </tr>
                        <tr>
                            <td width="2%"></td>
                            <td width="98%">- Igual o superior a 10 para vehículos Livianos Particulares y Pesados Particulares.</td>
                        </tr>
                        <tr>
                            <td width="2%"></td>
                            <td width="98%">- Igual o superior a 7 para vehículos Motocarros, Cuatrimotos, Mototriciclos y Cuadriciclos.</td>
                        </tr>
                        <tr>
                            <td width="2%"></td>
                            <td width="98%">- Igual o superior a 5 para vehículos Livianos públicos, Pesados públicos, Motocicleta, Ciclomotor y Tricimoto.</td>
                        </tr>
                        <tr>
                            <td width="2%"></td>
                            <td width="98%">- Igual o superior a 5 para vehículos de enseñanza automovilística.</td>
                        </tr>
                        <tr>
                            <td width="2%"></td>
                            <td width="98%">- Igual o superior a 1 para vehículos de enseñanza automovilística tipo Cuatrimotos, Mototriciclos, Cuadriciclos, Ciclomotor, Tricimoto.</td>
                        </tr>
                        <tr>
                            <td width="2%"></td>
                            <td width="98%">- Cuando se presente al menos un defecto tipo A para vehículos tipo Remolque o similares.</td>
                        </tr>
        </table>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');

    //------------------------------------------------------------------------------NUMEROS DE LOS FUR ASOCIADOS AL A LA INSPECCIÓN

    $html = <<<EOF
            <br>
        NÚMEROS DE LOS FUR ASOCIADOS AL VEHÍCULO PARA LA REVISIÓN: <strong>$num_fur_aso</strong> <br>
        <hr>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
}
//------------------------------------------------------------------------------OBSERVACIONES
$obs = '';
if (count($observaciones) > 0) {
    //    $countDefSenA = count($defectosSensorialesA);
    foreach ($observaciones as $o) {
        $obs = $obs . "<strong>$o->codigo</strong>: $o->descripcion<br>";
    }
}
$obs = $obs . $fechainicioprueba . $fechafinalprueba;

$html = <<<EOF
        <br>
        <strong>F. COMENTARIOS U OBSERVACIONES ADICIONALES:</strong><br>
        <table>
        <tr>
        <td >$obs</td>
        </tr>
        </table>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');

//------------------------------------------------------------------------------PRESIONES
if ($showencabezado) {
    $html = <<<EOF
        <br>
    <label style="text-align: justify;"><strong>PRESIÓN DE LAS LLANTAS </strong></label>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');

    $html = <<<EOF
        <br>
        <table cellpadding="2" nobr="true">
                        <tr>
                            <td width="16%" border="1" align="center"><strong></strong></td>  
                            <td width="14%" border="1" align="center"><strong>Eje 1 (psi)</strong></td>
                            <td width="14%" border="1" align="center"><strong>Eje 2 (psi)</strong></td>
                            <td width="14%" border="1" align="center"><strong>Eje 3 (psi)</strong></td>
                            <td width="14%" border="1" align="center"><strong>Eje 4 (psi)</strong></td>
                            <td width="14%" border="1" align="center"><strong>Eje 5 (psi)</strong></td>
                            <td width="13%" border="1" align="center"><strong>Repuesto (psi)</strong></td>
                        </tr>
                        <tr>
                            <td width="16%" border="1" align="center"><strong>IZQUIERDA</strong></td>  
                            <td width="14%" border="1" align="center">$presion->llanta_1_I</td>
                            <td width="7%" border="1" align="center">$presion->llanta_2_IE</td>
                            <td width="7%" border="1" align="center">$presion->llanta_2_II</td>
                            <td width="7%" border="1" align="center">$presion->llanta_3_IE</td>
                            <td width="7%" border="1" align="center">$presion->llanta_3_II</td>
                            <td width="7%" border="1" align="center">$presion->llanta_4_IE</td>
                            <td width="7%" border="1" align="center">$presion->llanta_4_II</td>
                            <td width="7%" border="1" align="center">$presion->llanta_5_IE</td>
                            <td width="7%" border="1" align="center">$presion->llanta_5_II</td>
                            <td width="7%" border="1" rowspan="2" align="center"><br><br>$presion->llanta_R</td>
                            <td width="6%" border="1" rowspan="2" align="center"><br><br>$presion->llanta_R2</td>
                        </tr>
                        <tr>
                            <td width="16%" border="1" align="center"><strong>DERECHA</strong></td>  
                            <td width="14%" border="1" align="center">$presion->llanta_1_D</td>
                            <td width="7%" border="1" align="center">$presion->llanta_2_DE</td>
                            <td width="7%" border="1" align="center">$presion->llanta_2_DI</td>
                            <td width="7%" border="1" align="center">$presion->llanta_3_DE</td>
                            <td width="7%" border="1" align="center">$presion->llanta_3_DI</td>
                            <td width="7%" border="1" align="center">$presion->llanta_4_DE</td>
                            <td width="7%" border="1" align="center">$presion->llanta_4_DI</td>
                            <td width="7%" border="1" align="center">$presion->llanta_5_DE</td>
                            <td width="7%" border="1" align="center">$presion->llanta_5_DI</td>
                        </tr>
        </table><br>
        <hr>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
}
//------------------------------------------------------------------------------FOTOGRAFÍAS
$html = <<<EOF
        <br>
        <strong>$tituloG<strong><br>
        <hr>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');
//------------------------------------------------------------------------------FOTOGRAFÍAS
if ($fotografia->imagen1 !== '' || $fotografia->imagen2 !== '') {
    $html = <<<EOF
        <table cellpadding="5" nobr="true">
                        <tr >
                            <td width="5%"></td>  
                            <td width="42%"><img src="$fotografia->imagen1" style="width: 226.772px;height:198.425px"></td>
                            <td width="6%"></td>  
                            <td width="42%"><img src="$fotografia->imagen2" style="width: 226.772px;height:198.425px"></td>
                            <td width="5%"></td>
                        </tr>
        </table>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
}
//------------------------------------------------------------------------------PERISFERICOS
$luxometro = "";
$opacimetro = "";
$analizador = "";
$sonometro = "";
$camara = "";
$taximetro = "";
$frenometro = "";
$suspension = "";
$alineador = "";
$termohigrometro = "";
$profundimetro = "";
$captador = "";
$pierey = "";
$elevador = "";
$detector = "";
$sensorRPM = "";
$sondaTMP = "";
if ($maquinas->nombreLuxometro !== '') {
    $luxometro = explode("$", $maquinas->nombreLuxometro);
    $luxometro = <<<EOF
            <tr>
                <td border="1" align="center">$luxometro[0]</td>
                <td border="1" align="center">$luxometro[1]</td>
                <td border="1" align="center">$luxometro[2]</td>
                <td border="1" align="center">$luxometro[3]</td>
                <td border="1" align="center"></td>
                <td border="1" align="center">$luxometro[4]</td>
                <td border="1" align="center">$luxometro[5]</td>
            </tr>
EOF;
}

if ($maquinas->nombreOpacimetro !== '') {
    $opacimetro = explode("$", $maquinas->nombreOpacimetro);
    $opacimetro = <<<EOF
            <tr>
                <td border="1" align="center">$opacimetro[0]</td>
                <td border="1" align="center">$opacimetro[1]</td>
                <td border="1" align="center">$opacimetro[2]</td>
                <td border="1" align="center">$opacimetro[3]</td>
                <td border="1" align="center"></td>
                <td border="1" align="center">$opacimetro[4]</td>
                <td border="1" align="center">$opacimetro[5]</td>
            </tr>
EOF;
}
$bench = "";
if ($maquinas->nombreGases !== '') {
    $analizador = explode("$", $maquinas->nombreGases);
    $analizador = <<<EOF
            <tr>
                <td border="1" align="center">$analizador[0]</td>
                <td border="1" align="center">$analizador[1]</td>
                <td border="1" align="center">$analizador[2]</td>
                <td border="1" align="center">$analizador[3]</td>
                <td border="1" align="center">$analizador[6]</td>            
                <td border="1" align="center">$analizador[4]</td>
                <td border="1" align="center">$analizador[5]</td>
            </tr>
EOF;
}
//echo $maquinas->nombreSonometro;
if ($maquinas->nombreSonometro !== '') {
    $sonometro = explode("$", $maquinas->nombreSonometro);
    if ($sonometro[0] !== '') {
        $sonometro = <<<EOF
            <tr>
                <td border="1" align="center">$sonometro[0]</td>
                <td border="1" align="center">$sonometro[1]</td>
                <td border="1" align="center">$sonometro[2]</td>
                <td border="1" align="center">$sonometro[3]</td>
                <td border="1" align="center"></td>                
                <td border="1" align="center">$sonometro[4]</td>
                <td border="1" align="center">$sonometro[5]</td>
            </tr>
EOF;
    } else {
        $sonometro = "";
    }
}

if ($maquinas->nombreFotos !== '') {
    $camara = explode("$", $maquinas->nombreFotos);
    $camara = <<<EOF
            <tr>
                <td border="1" align="center">$camara[0]</td>
                <td border="1" align="center">$camara[1]</td>
                <td border="1" align="center">$camara[2]</td>
                <td border="1" align="center">$camara[3]</td>
                <td border="1" align="center"></td>            
                <td border="1" align="center">$camara[4]</td>
                <td border="1" align="center">$camara[5]</td>
            </tr>
EOF;
}

if ($maquinas->nombreTaximetro !== '') {
    $taximetro = explode("$", $maquinas->nombreTaximetro);
    $taximetro = <<<EOF
            <tr>
                <td border="1" align="center">$taximetro[0]</td>
                <td border="1" align="center">$taximetro[1]</td>
                <td border="1" align="center">$taximetro[2]</td>
                <td border="1" align="center">$taximetro[3]</td>
                <td border="1" align="center"></td>            
                <td border="1" align="center">$taximetro[4]</td>
                <td border="1" align="center">$taximetro[5]</td>
            </tr>
EOF;
}

if ($maquinas->nombreFrenos !== '') {
    $frenometro = explode("$", $maquinas->nombreFrenos);
    $frenometro = <<<EOF
            <tr>
                <td border="1" align="center">$frenometro[0]</td>
                <td border="1" align="center">$frenometro[1]</td>
                <td border="1" align="center">$frenometro[2]</td>
                <td border="1" align="center">$frenometro[3]</td>
                <td border="1" align="center"></td>            
                <td border="1" align="center">$frenometro[4]</td>
                <td border="1" align="center">$frenometro[5]</td>
            </tr>
EOF;
}
if ($maquinas->nombreBascula !== '') {
    $bascula = explode("$", $maquinas->nombreBascula);
    $bascula = <<<EOF
            <tr>
                <td border="1" align="center">$bascula[0]</td>
                <td border="1" align="center">$bascula[1]</td>
                <td border="1" align="center">$bascula[2]</td>
                <td border="1" align="center">$bascula[3]</td>
                <td border="1" align="center"></td>            
                <td border="1" align="center">$bascula[4]</td>
                <td border="1" align="center">$bascula[5]</td>
            </tr>
EOF;
} else {
    $bascula = '';
}

if ($maquinas->nombreVisual !== '') {
    $visual = explode("$", $maquinas->nombreVisual);
    $visual = <<<EOF
            <tr>
                <td border="1" align="center">$visual[0]</td>
                <td border="1" align="center">$visual[1]</td>
                <td border="1" align="center">$visual[2]</td>
                <td border="1" align="center">$visual[3]</td>
                <td border="1" align="center"></td>            
                <td border="1" align="center">$visual[4]</td>
                <td border="1" align="center">$visual[5]</td>
            </tr>
EOF;
} else {
    $visual = "";
}


if ($maquinas->nombreSuspension !== '') {
    $suspension = explode("$", $maquinas->nombreSuspension);
    $suspension = <<<EOF
            <tr>
                <td border="1" align="center">$suspension[0]</td>
                <td border="1" align="center">$suspension[1]</td>
                <td border="1" align="center">$suspension[2]</td>
                <td border="1" align="center">$suspension[3]</td>
                <td border="1" align="center"></td>            
                <td border="1" align="center">$suspension[4]</td>
                <td border="1" align="center">$suspension[5]</td>
            </tr>
EOF;
}

if ($maquinas->nombreAlineador !== '') {
    $alineador = explode("$", $maquinas->nombreAlineador);
    $alineador = <<<EOF
            <tr>
                <td border="1" align="center">DESVIACIÓN LATERAL</td>
                <td border="1" align="center">$alineador[1]</td>
                <td border="1" align="center">$alineador[2]</td>
                <td border="1" align="center">$alineador[3]</td>
                <td border="1" align="center"></td>            
                <td border="1" align="center">$alineador[4]</td>
                <td border="1" align="center">$alineador[5]</td>
            </tr>
EOF;
}

if ($maquinas->nombreTermohigrometro !== '') {
    $termohigrometro = explode("$", $maquinas->nombreTermohigrometro);
    $termohigrometro = <<<EOF
            <tr>
                <td border="1" align="center">$termohigrometro[0]</td>
                <td border="1" align="center">$termohigrometro[1]</td>
                <td border="1" align="center">$termohigrometro[2]</td>
                <td border="1" align="center">$termohigrometro[3]</td>
                <td border="1" align="center"></td>            
                <td border="1" align="center">$termohigrometro[4]</td>
                <td border="1" align="center">$termohigrometro[5]</td>
            </tr>
EOF;
}

if ($maquinas->nombreProfundimetro !== '') {
    $profundimetro = explode("$", $maquinas->nombreProfundimetro);
    $profundimetro = <<<EOF
            <tr>
                <td border="1" align="center">$profundimetro[0]</td>
                <td border="1" align="center">$profundimetro[1]</td>
                <td border="1" align="center">$profundimetro[2]</td>
                <td border="1" align="center">$profundimetro[3]</td>
                <td border="1" align="center"></td>            
                <td border="1" align="center">$profundimetro[4]</td>
                <td border="1" align="center">$profundimetro[5]</td>
            </tr>
EOF;
}

if ($maquinas->nombreCaptador !== '') {
    $captador = explode("$", $maquinas->nombreCaptador);
    $captador = <<<EOF
            <tr>
                <td border="1" align="center">$captador[0]</td>
                <td border="1" align="center">$captador[1]</td>
                <td border="1" align="center">$captador[2]</td>
                <td border="1" align="center">$captador[3]</td>
                <td border="1" align="center"></td>            
                <td border="1" align="center">$captador[4]</td>
                <td border="1" align="center">$captador[5]</td>
            </tr>
EOF;
}

if ($maquinas->nombrePiederey !== '') {
    $pierey = explode("$", $maquinas->nombrePiederey);
    $pierey = <<<EOF
            <tr>
                <td border="1" align="center">$pierey[0]</td>
                <td border="1" align="center">$pierey[1]</td>
                <td border="1" align="center">$pierey[2]</td>
                <td border="1" align="center">$pierey[3]</td>
                <td border="1" align="center"></td>            
                <td border="1" align="center">$pierey[4]</td>
                <td border="1" align="center">$pierey[5]</td>
            </tr>
EOF;
}

if ($maquinas->nombreElevador !== '') {
    $elevador = explode("$", $maquinas->nombreElevador);
    $elevador = <<<EOF
            <tr>
                <td border="1" align="center">$elevador[0]</td>
                <td border="1" align="center">$elevador[1]</td>
                <td border="1" align="center">$elevador[2]</td>
                <td border="1" align="center">$elevador[3]</td>
                <td border="1" align="center"></td>            
                <td border="1" align="center">$elevador[4]</td>
                <td border="1" align="center">$elevador[5]</td>
            </tr>
EOF;
}

if ($maquinas->nombreDetector !== '') {
    $detector = explode("$", $maquinas->nombreDetector);
    $detector = <<<EOF
            <tr>
                <td border="1" align="center">$detector[0]</td>
                <td border="1" align="center">$detector[1]</td>
                <td border="1" align="center">$detector[2]</td>
                <td border="1" align="center">$detector[3]</td>
                <td border="1" align="center"></td>            
                <td border="1" align="center">$detector[4]</td>
                <td border="1" align="center">$detector[5]</td>
            </tr>
EOF;
}

if ($maquinas->nombreSensorRPM !== '') {
    $sensorRPM = explode("$", $maquinas->nombreSensorRPM);
    $sensorRPM = <<<EOF
            <tr>
                <td border="1" align="center">$sensorRPM[0]</td>
                <td border="1" align="center">$sensorRPM[1]</td>
                <td border="1" align="center">$sensorRPM[2]</td>
                <td border="1" align="center">$sensorRPM[3]</td>
                <td border="1" align="center"></td>            
                <td border="1" align="center">$sensorRPM[4]</td>
                <td border="1" align="center">$sensorRPM[5]</td>
            </tr>
EOF;
}

if ($vehiculo->convertidorCat === "NO" || ($vehiculo->tipo_vehiculo === '3' && $vehiculo->scooter === '0') || $combustible->nombre === "Diesel") {
    // var_dump($combustible->nombre);
    // var_dump($maquinas->nombreSondaTMP);
    if ($maquinas->nombreSondaTMP !== '') {
        $sondaTMP = explode("$", $maquinas->nombreSondaTMP);
        $sondaTMP = <<<EOF
            <tr>
                <td border="1" align="center">$sondaTMP[0]</td>
                <td border="1" align="center">$sondaTMP[1]</td>
                <td border="1" align="center">$sondaTMP[2]</td>
                <td border="1" align="center">$sondaTMP[3]</td>
                <td border="1" align="center"></td>                
                <td border="1" align="center">$sondaTMP[4]</td>
                <td border="1" align="center">$sondaTMP[5]</td>
            </tr>
EOF;
    }
}
//if ($reins == '0' || $reins == '1' || $reins == '8888') {
//    if ($vehiculo->scooter !== '1') {
//        $sensorTmp = '<tr>
//                <td border="1" align="center">SONDA TEMPERATURA</td>
//                <td border="1" align="center">CAPELEC</td>
//                <td border="1" align="center">32363</td>
//                <td border="1" align="center">CAP8530</td>
//                <td border="1" align="center"></td>
//                <td border="1" align="center"></td>
//            </tr>';
//    } else {
//        $sensorTmp = "";
//    }
//    $sensorRpm = '<tr>
//                <td border="1" align="center">SENSOR VIBRACION</td>
//                <td border="1" align="center">CAPELEC</td>
//                <td border="1" align="center">32363</td>
//                <td border="1" align="center">CAP8530</td>
//                <td border="1" align="center"></td>
//                <td border="1" align="center"></td>
//            </tr>';
//        $sensorRpm
//        $sensorTmp


$html = <<<EOF
        <br>
        <strong>H. RELACIÓN DE EQUIPOS Y PERIFERICOS UTILIZADOS EN LA REVISIÓN</strong><br><br>
        <table cellpadding="1" nobr="true" >
            <tr>
                <td border="1" align="center" width="18%"><strong>NOMBRE</strong></td>
                <td border="1" align="center" width="20%"><strong>MARCA</strong></td>
                <td border="1" align="center" width="20%"><strong>SERIAL</strong></td>
                <td border="1" align="center" width="19%"><strong>REFERENCIA</strong></td>
                <td border="1" align="center" width="12%"><strong># SERIE BANCO</strong></td>
                <td border="1" align="center" width="5%"><strong>PEF</strong></td>
                <td border="1" align="center" width="5%"><strong>LTOE</strong></td>
            </tr>
        $luxometro
        $opacimetro
        $analizador
        $sonometro
        $taximetro
        $frenometro
        $bascula
        $suspension
        $alineador
        $termohigrometro
        $profundimetro
        $captador
        $pierey
        $elevador
        $detector
        $sensorRPM
        $sondaTMP
        </table>
        <br>
        $bench
        <hr>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');

if ($reins == '0' || $reins == '1') {
    //------------------------------------------------------------------------------VERSION
    $html = <<<EOF
            <br>
        <strong>I. SOFTWARE Y/O APLICATIVOS CON LA VERSIÓN UTILIZADA: </strong><br>
             <table>
        <tr>
        <td width="99%">$software</td></tr>
        </table>
        <br>
        <hr>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
}
//------------------------------------------------------------------------------LISTA DE TECNICOS
//------------------------------------------------------------------------------PERISFERICOS
$luxometroOperario = "";
$opacimetroOperario = "";
$analizadorOperario = "";
$sonometroOperario = "";
$camaraOperario = "";
$taximetroOperario = "";
$frenometroOperario = "";
$suspensionOperario = "";
$alineadorOperario = "";
if ($inspectores->nombreLuxometro !== '') {
    $luxometroOperario = explode("$", $inspectores->nombreLuxometro);
    $luxometroOperario = str_replace('^', '', $luxometroOperario);
    $luxometroOperario = <<<EOF
            <tr>
                <td border="1" align="left">Luces</td>
                <td border="1" align="left">$luxometroOperario[8]</td>
            </tr>
EOF;
}

if ($inspectores->nombreOpacimetro !== '') {
    $opacimetroOperario = explode("$", $inspectores->nombreOpacimetro);
    $opacimetroOperario = str_replace('^', '', $opacimetroOperario);
    $opacimetroOperario = <<<EOF
            <tr>
                <td border="1" align="left">Emisiones ciclo Diesel</td>
                <td border="1" align="left">$opacimetroOperario[8]</td>
            </tr>
EOF;
}

if ($inspectores->nombreGases !== '') {
    $analizadorOperario = explode("$", $inspectores->nombreGases);
    $analizadorOperario = str_replace('^', '', $analizadorOperario);
    $analizadorOperario = <<<EOF
            <tr>
                <td border="1" align="left">Emisiones ciclo OTTO/4T/2T</td>
                <td border="1" align="left">$analizadorOperario[8]</td>
            </tr>
EOF;
}

if ($inspectores->nombreSonometro !== '') {
    $sonometroOperario = explode("$", $inspectores->nombreSonometro);
    $sonometroOperario = str_replace('^', '', $sonometroOperario);
    if ($sonometroOperario[0] !== '') {
        $sonometroOperario = <<<EOF
            <tr>
                <td border="1" align="left">Sonometría</td>
                <td border="1" align="left">$sonometroOperario[8]</td>
            </tr>
EOF;
    } else {
        $sonometroOperario = "";
    }
}

if ($inspectores->nombreFotos !== '') {
    $camaraOperario = explode("$", $inspectores->nombreFotos);
    $camaraOperario = str_replace('^', '', $camaraOperario);
    $camaraOperario = <<<EOF
            <tr>
                <td border="1" align="left">Registro fotográfico</td>
                <td border="1" align="left">$camaraOperario[8]</td>
            </tr>
EOF;
}

if ($inspectores->nombreTaximetro !== '') {
    $taximetroOperario = explode("$", $inspectores->nombreTaximetro);
    $taximetroOperario = str_replace('^', '', $taximetroOperario);
    $taximetroOperario = <<<EOF
            <tr>
                <td border="1" align="left">Dispositivo de cobro</td>
                <td border="1" align="left">$taximetroOperario[8]</td>
            </tr>
EOF;
}

if ($inspectores->nombreFrenos !== '') {
    $frenometroOperario = explode("$", $inspectores->nombreFrenos);
    $frenometroOperario = str_replace('^', '', $frenometroOperario);
    $frenometroOperario = <<<EOF
            <tr>
                <td border="1" align="left">Frenos</td>
                <td border="1" align="left">$frenometroOperario[8]</td>
            </tr>
EOF;
}

if ($inspectores->nombreVisual !== '') {
    $visualOperario = explode("$", $inspectores->nombreVisual);
    $visualOperario = str_replace('^', '', $visualOperario);
    $visualOperario = <<<EOF
            <tr>
                <td border="1" align="left">Inspección sensorial</td>
                <td border="1" align="left">$visualOperario[8]</td>
            </tr>
EOF;
} else {
    $visualOperario = "";
}

if ($inspectores->nombreSuspension !== '') {
    $suspensionOperario = explode("$", $inspectores->nombreSuspension);
    $suspensionOperario = str_replace('^', '', $suspensionOperario);
    $suspensionOperario = <<<EOF
            <tr>
                <td border="1" align="left">Suspensión</td>
                <td border="1" align="left">$suspensionOperario[8]</td>
            </tr>
EOF;
}

if ($inspectores->nombreAlineador !== '') {
    $alineadorOperario = explode("$", $inspectores->nombreAlineador);
    $alineadorOperario = str_replace('^', '', $alineadorOperario);
    $alineadorOperario = <<<EOF
            <tr>
                <td border="1" align="left">Desviación lateral</td>
                <td border="1" align="left">$alineadorOperario[8]</td>
            </tr>
EOF;
}
$sensoriales = "";
if ($sensorial->operarios_sensorial) {
    foreach ($sensorial->operarios_sensorial as $s) {
		$tipo_inpeccion =  str_replace("visual", "sensorial", $s->sensorial);
        $sensoriales = $sensoriales . <<<EOF
            <tr>
                <td border="1" align="left">$tipo_inpeccion</td>
                <td border="1" align="left">$s->operario</td>
            </tr>
EOF;
    }
}
$html = <<<EOF
        <br>
        <strong>$tituloJ</strong><br><br>
            <table cellpadding="1" >
            <tr>
                <td border="1" align="left" width="35%"><strong>PRUEBA</strong></td>
                <td border="1" align="left" width="40%"><strong>INSPECTOR</strong></td>
            </tr>
        $luxometroOperario
        $opacimetroOperario
        $analizadorOperario
        $sonometroOperario
        $camaraOperario
        $taximetroOperario
        $frenometroOperario
        $visualOperario
        $suspensionOperario
        $alineadorOperario
        $sensoriales
        </table>
        <br>
        <hr>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');
//}
//------------------------------------------------------------------------------FIRMA JEFE DE PISTA
if ($showencabezado) {
    if ($firmaJefe == '') {
        $html = <<<EOF
                <br>
            <strong>K. NOMBRE Y FIRMA DEL DIRECTOR TÉCNICO AUTORIZADO POR EL REPRESENTANTE LEGAL DEL CDA</strong><br><br><br><br><br>
                <table>
            <tr>
            <td width="99%">
                _______________________________________<br>
            <strong>$hojatrabajo->jefelinea</strong><br>
            Director técnico<br>
             </td></tr>
            </table>
            
            <hr>
EOF;
    } else {
        $html = <<<EOF
                <br>
            <strong>K. NOMBRE Y FIRMA DEL DIRECTOR TÉCNICO AUTORIZADO POR EL REPRESENTANTE LEGAL DEL CDA</strong><br>
                <table>
            <tr>
            <td width="99%">
                <img src="@$firmaJefe" style="width: 200px"><br>
            _________________________________________________<br>
            <strong>$hojatrabajo->jefelinea</strong><br>
            Director técnico<br>
             </td></tr>
            </table>
            <hr>
EOF;
    }
    $pdf->writeHTML($html, true, false, true, false, '');
}



if ($reins == '0' || $reins == '1' || $reins == '8888') {
    //------------------------------------------------------------------------------
    $html = <<<EOF
            <br>
    <label style="text-align: justify;"><strong>NOTA: </strong></label> 
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
    $html = <<<EOF
            <br>
        <table nobr="true">
                        <tr>
                            <td width="3%">1)</td>  
                            <td width="96%" align="justify">El campo del resultado de la prueba de Óxido Nitroso (NO) en el formato, se aplicará cuando quede regulado por la entidad competente.</td>
                        </tr>
                        <tr>
                            <td width="3%">2)</td>  
                            <td width="96%" align="justify">Los resultados aquí consignados corresponden al momento de la revisión técnico-mecánica y de emisiones contaminantes, y por ende es
responsabilidad del poseedor o tenedor del vehículo mantener las condiciones técnico-mecánicas y de emisiones contaminantes que
indican artículos 50- 51 de la ley 769 de 2002 o la que modifique o sustituya.</td>
                        </tr>
                        <tr>
                            <td width="3%">3)</td>  
                            <td width="96%" align="justify">En caso de rechazo, el propietario, poseedor o tenedor del vehículo automotor objeto de revisión, deberá efectuar las reparaciones
pertinentes y subsanar los aspectos defectuosos dentro de los quince (15) días calendario contados a partir de la fecha en que fue
reprobado. Una vez realizadas las reparaciones, el propietario, poseedor o tenedor del vehículo automotor, podrá volver por una sola vez
sin costo alguno al mismo Centro de Diagnóstico Automotor para someter el vehículo a la revisión de los aspectos reprobados en la visita
inicial, conforme a lo indicado en el artículo 28 de la Resolución 3768 de 2013, o la que la modifique, adicione o sustituya.</td>
                        </tr>
        </table>
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
}
$html = <<<EOF
    <label style="text-align: justify;">_____________________________________________________________Fin del informe__________________________________________________________</label> 
EOF;
$pdf->writeHTML($html, true, false, true, false, '');

if (($reins == '0' || $reins == '1') && $ocasion == 'false' && $apro === 'APROBADO: SI_____ NO__X__') {
    $f = date('Y-m-d  H:i', strtotime($fechafur . '+ 358 hours'));
    $fec = date_format(date_create($f), 'd/m/Y H:i');
    $html = <<<EOF
            <br>
<p style="font-size:6px;text-align:justify">RECUERDE: A PARTIR DE LA FECHA DE ESTA REVISIÓN USTED CUENTA CON 15 DÍAS CALENDARIO EXACTAMENTE HASTA EL <strong>$fec</strong>, PARA REPARAR SUS DEFECTOS Y REGRESAR A UNA SEGUNDA VISITA, EN TODOS LOS CASOS EL VEHÍCULO SERÁ OBJETO DE UNA REVISIÓN SENSORIAL COMPLETA PARA VERIFICAR QUE LAS CONDICIONES GENERALES SE MANTIENEN Y SE PROCEDA A HACER UNA REVISIÓN GRATUITA DE LOS ASPECTOS REPROBADOS EN LA VISITA INICIAL, CUANDO EN LA REVISIÓN SENSORIAL SE COMPRUEBE QUE EL VEHÍCULO PUDO HABER SUFRIDO ALGUNA ALTERACIÓN, ESTE SERÁ SOMETIDO A UNA REVISIÓN TOTAL COMO SI FUESE LA PRIMERA VEZ, EN ESTE CASO O SI SE PASA DEL PLAZO ESTABLECIDO, SE GENERARÁ EL RESPECTIVO COBRO.</p><br>
$horarioAtencion            
EOF;
    $pdf->writeHTML($html, true, false, true, false, '');
}
//$pdf->Output($url_ . $file_, 'F'); 
//ob_end_clean();
if ($tipopdfenvio == '1') {
    $pdf->Output($url_ . $file_, 'F');
} else {
    $pdf->Output("fur.pdf", 'I');
}

