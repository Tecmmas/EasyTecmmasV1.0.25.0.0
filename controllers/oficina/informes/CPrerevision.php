<?php

defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
ini_set('memory_limit', '-1');
set_time_limit(300);

class CPrerevision extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("oficina/informes/MPrerevision");
        $this->load->model("dominio/Mcda");
        $this->load->library('Opensslencryptdecrypt');
        // espejoDatabase();
    }

    var $envioCorreo = "0";
    var $emailCDA = "";
    var $pwEmailCDA = "";
    var $asuntoEmailCDA = "";
    var $vistaEmailCDA = "";
    var $nombreCDA = "";
    var $fechaAprobacionPre = "";
    var $versionPre = "";

    var $sistemaOperativo = "";

    var $ruta = "";

    public function index()
    {
        if ($this->session->userdata('IdUsuario') == '' || $this->session->userdata('IdUsuario') == '1024') {
            redirect('Cindex');
        }
        $data['prerevision'] = '';
        $data['placa'] = '';
        $data['rango'] = '';
        $this->load->view('oficina/informes/VPrerevision', $data);
    }

    public function consultar()
    {
        $data['prerevision'] = $this->MPrerevision->consultar($this->input->post('placa'), $this->input->post('rango'));
        $data['placa'] = $this->input->post('placa');
        $data['rango'] = $this->input->post('rango');
        $this->setConf();
        $data['envioCorreo'] = $this->envioCorreo;
        $this->load->view('oficina/informes/VPrerevision', $data);
    }

    public function setConf()
    {
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/oficina.json', true), true);
        $ofc = json_decode($json, true);
        $this->mostrarAireAjustada = true;
        $this->mostrarAireDesajustada = true;
        foreach ($ofc as $d) {
            $data[$d['nombre']] = $d['valor'];
            if ($d['nombre'] == 'envioCorreo') {
                $this->envioCorreo = $d['valor'];
            }
            if ($d['nombre'] == 'emailCDA') {
                $this->emailCDA = $d['valor'];
            }
            if ($d['nombre'] == 'pwEmailCDA') {
                $this->pwEmailCDA = $d['valor'];
            }
            if ($d['nombre'] == 'asuntoEmailCDA') {
                $this->asuntoEmailCDA = $d['valor'];
            }
            if ($d['nombre'] == 'vistaEmailCDA') {
                $this->vistaEmailCDA = $d['valor'];
            }
            if ($d['nombre'] == 'nombreCDA') {
                $this->nombreCDA = $d['valor'];
            }
            if ($d['nombre'] == "mostrarAireAjustada") {
                if ($d['valor'] == '0') {
                    $this->mostrarAireAjustada = false;
                }
            }
            if ($d['nombre'] == "mostrarAireDesajustada") {
                if ($d['valor'] == '0') {
                    $this->mostrarAireDesajustada = false;
                }
            }
            if ($d['nombre'] == "fechaAprobacionPre") {
                $this->fechaAprobacionPre = $d['valor'];
            }
            if ($d['nombre'] == "versionPre") {
                $this->versionPre = $d['valor'];
            }
        }
    }

    var $mostrarAireAjustada;
    var $mostrarAireDesajustada;

    public function generar()
    {
        $this->sistemaOperativo = sistemaoperativo();
        $savePdf = $this->input->post('savePdf');
        $idpre_prerevision = $this->input->post('idpre_prerevision');
        $tipo_inspeccion = $this->input->post('tipo_inspeccion');
        $email = $this->input->post('email');
        $vehiculo = $this->MPrerevision->getInfoVehiculo($idpre_prerevision);
        //        var_dump($data['vehiculo']);
        $this->setConf();
        $Rpre_prerevision = $this->MPrerevision->get($idpre_prerevision);
        $pre_prerevision = $Rpre_prerevision->result();
        $fechaPre = explode(" ", $pre_prerevision[0]->fecha_prerevision);
        $fechaPre = str_replace("-", "", $fechaPre[0]);
        $Rcda = $this->Mcda->get();
        $cda = $Rcda->result();
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('recursos/prerevision.json', true));
        $informe = json_decode($json, true);
        $cliente = $this->MPrerevision->getCliente($vehiculo->placa);
        foreach ($informe as $i) {
            $zonaDat = explode("_", $i['zona']);
            switch ($zonaDat[0]) {
                case 'encabezado':
                    if (intval($fechaPre) >= intval($zonaDat[1]) && intval($fechaPre) <= intval($zonaDat[2])) {
                        $data['encabezado'] = $i['html'];
                    }
                    break;
                case 'infovehiculo':
                    if (intval($fechaPre) >= intval($zonaDat[1]) && intval($fechaPre) <= intval($zonaDat[2])) {
                        //                        $data['datoVehiculo'] = $i['html'];
                        //  var_dump($i['html']);
                         $datos = $i['html'];
                        $vehiculos = get_object_vars($vehiculo);
                        //  var_dump($cliente);
                        $key = array_keys($vehiculos);
                        $k = 0;
                        $datos = str_replace('$cliente->nombre', $cliente->nombre, $datos);
                        $datos = str_replace('$cliente->direccion', $cliente->direccion, $datos);
                        $datos = str_replace('$cliente->telefono', $cliente->telefono, $datos);
                        $datos = str_replace('$cliente->correo', $cliente->correo, $datos);
                        $datos = str_replace('$cliente->numero_identificacion', $cliente->numero_identificacion, $datos);
                        $datos = str_replace('$cliente->nombre', $cliente->nombre, $datos);
                        $datos = str_replace('$cliente->direccion', $cliente->direccion, $datos);
                        $datos = str_replace('$cliente->telefono', $cliente->telefono, $datos);
                        $datos = str_replace('$cliente->correo', $cliente->correo, $datos);
                        $datos = str_replace('$cliente->numero_identificacion', $cliente->numero_identificacion, $datos);
                        $datos = str_replace('$cliente->numero_licencia', $cliente->numero_licencia, $datos);
                        $datos = str_replace('$cliente->categoria_licencia', $cliente->categoria_licencia, $datos);
                        $datos = str_replace('$vehiculo->ocupacion', $vehiculo->ocupacion, $datos);
                        $datos = str_replace('$vehiculo->actividadeconomica', $vehiculo->actividadeconomica, $datos);
                        $datos = str_replace('$vehiculo->codigociiu', $vehiculo->codigociiu, $datos);
                        $datos = str_replace('$vehiculo->restriccionauditiva', $vehiculo->restriccionauditiva, $datos);

                        $placa = "";
                        foreach ($vehiculo as $v) {
                            if ($key[$k] == 'placa') {
                                $placa = $v;
                            }
                            $datos = str_replace('$vehiculo->' . $key[$k], $v, $datos);
                            $k++;
                        }
                        //  var_dump($datos);
                        // $cliente = $this->MPrerevision->getCliente($placa);
                        
                        $data['datoVehiculo'] = $datos;
                    }
                    break;
                case 'listachequeo':
                    if (intval($fechaPre) >= intval($zonaDat[1]) && intval($fechaPre) <= intval($zonaDat[2])) {
                        $rta = $this->MPrerevision->getPre_datoApr($idpre_prerevision, 'chk-');
                        $datos = $i['html'];
                        foreach ($rta->result() as $cl) {
                            $cumple = '';
                            switch ($cl->valor) {
                                case 'SI':
                                    $cumple = <<<EOF
                           <td style="text-align:center">X</td>
                           <td style="text-align:center"></td>
                           <td style="text-align:center"></td>
EOF;
                                    break;
                                case 'NO':
                                    $cumple = <<<EOF
                           <td style="text-align:center"></td>
                           <td style="text-align:center">X</td>
                           <td style="text-align:center"></td>
EOF;
                                    break;
                                case 'NA':
                                    $cumple = <<<EOF
                           <td style="text-align:center"></td>
                           <td style="text-align:center"></td>
                           <td style="text-align:center">X</td>
EOF;
                                    break;
                                case ' ':
                                    $cumple = <<<EOF
                           <td></td>
EOF;
                                    break;
                                default:
                                    $cumple = <<<EOF
                           <td style="text-align:center" colspan="3">$cl->valor</td>
EOF;
                                    break;
                            }

                            if ($cl->valor !== '') {
                                $datos = str_replace("</td>$cl->id</tr>", "</td>$cumple</tr>", $datos);
                            }
                        }
                        $acep = '<td style="text-align:center"></td><td style="text-align:center"></td><td style="text-align:center">X</td>';
                        //$acep = '';
                        //$data['lista_chequeo'] = $datos;
                        //$no_permitidas = array("chk-1", "chk-2","chk-3");
                        //$permitidas = array('<td style="text-align:center">X</td><td style="text-align:center"></td><td style="text-align:center"></td>');
                        //$data['lista_chequeo'] =  preg_replace('/(chk-)(1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|30|31|32|33|34|35|36|37|38|39|40|41|42|43|44|45|46|47|48|49|50|51|52|53|54|55|56|57|58|59|60|61|62|63|64|65|66|67|68|69|70)/', '<td style="text-align:center">X</td><td style="text-align:center"></td><td style="text-align:center"></td>', $data['lista_chequeo']);
                        //                        $data['lista_chequeo'] =  preg_replace('/(chk-)(1|2|3|4|5|6|7|8|9|10)/', '<td style="text-align:center">X</td><td style="text-align:center"></td><td style="text-align:center"></td>', $data['lista_chequeo']);
                        // $no_permitidas = array('chk-1', 'chk-2', 'chk-3', 'chk-4', 'chk-5',    'chk-6',    'chk-7',    'chk-8',    'chk-9',    'chk-10',    'chk-11',    'chk-12',    'chk-13',    'chk-14',    'chk-15',    'chk-16',    'chk-17',    'chk-18',    'chk-19',    'chk-20',    'chk-21',    'chk-22',    'chk-23',    'chk-24',    'chk-25',    'chk-26',    'chk-27',    'chk-28',    'chk-29',    'chk-30',    'chk-31',    'chk-32',    'chk-33',    'chk-34',    'chk-35',    'chk-36',    'chk-37',    'chk-38',    'chk-39',    'chk-40',    'chk-41',    'chk-42',    'chk-43',    'chk-44',    'chk-45',    'chk-46',    'chk-47',    'chk-48',    'chk-49',    'chk-50',    'chk-51',    'chk-52',    'chk-53',    'chk-54',    'chk-55',    'chk-56',    'chk-57',    'chk-58',    'chk-59',    'chk-60',    'chk-61',    'chk-62', 'chk-64',    'chk-65',    'chk-66',    'chk-67',    'chk-68',    'chk-69',    'chk-70');

                        $no_permitidas = array(
                            'chk-70',
                            'chk-69',
                            'chk-68',
                            'chk-67',
                            'chk-66',
                            'chk-65',
                            'chk-64',
                            'chk-63',
                            'chk-62',
                            'chk-61',
                            'chk-60',
                            'chk-59',
                            'chk-58',
                            'chk-57',
                            'chk-56',
                            'chk-55',
                            'chk-54',
                            'chk-53',
                            'chk-52',
                            'chk-51',
                            'chk-50',
                            'chk-49',
                            'chk-48',
                            'chk-47',
                            'chk-46',
                            'chk-45',
                            'chk-44',
                            'chk-43',
                            'chk-42',
                            'chk-41',
                            'chk-40',
                            'chk-39',
                            'chk-38',
                            'chk-37',
                            'chk-36',
                            'chk-35',
                            'chk-34',
                            'chk-33',
                            'chk-32',
                            'chk-31',
                            'chk-30',
                            'chk-29',
                            'chk-28',
                            'chk-27',
                            'chk-26',
                            'chk-25',
                            'chk-24',
                            'chk-23',
                            'chk-22',
                            'chk-21',
                            'chk-20',
                            'chk-19',
                            'chk-18',
                            'chk-17',
                            'chk-16',
                            'chk-15',
                            'chk-14',
                            'chk-13',
                            'chk-12',
                            'chk-11',
                            'chk-10',
                            'chk-9',
                            'chk-8',
                            'chk-7',
                            'chk-6',
                            'chk-5',
                            'chk-4',
                            'chk-3',
                            'chk-2',
                            'chk-1',
                        );
                        $permitidas = array($acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep,    $acep);
                        $data['lista_chequeo'] = str_replace($no_permitidas, $permitidas, $datos);
                    }

                    break;
                case 'infocondiciones':
                    if (intval($fechaPre) >= intval($zonaDat[1]) && intval($fechaPre) <= intval($zonaDat[2])) {
                        
                        $data['condiciones'] = $i['html'];
                    }

                    // var_dump($data['condiciones']);
                    // if ($tipo_inspeccion == '1' || $tipo_inspeccion == '3') {
                    // } else {
                    // }

                    break;
                case 'infocondicionesadicionales':
                    if (intval($fechaPre) >= intval($zonaDat[1]) && intval($fechaPre) <= intval($zonaDat[2])) {
                        $html = $i['html'];
                        $html = str_replace('$condicionesadicionales->empleadopublico', $vehiculo->empleadopublico, $html);
                        $html = str_replace('$condicionesadicionales->recursospublicos', $vehiculo->recursospublicos, $html);
                        $html = str_replace('$condicionesadicionales->poderpublico', $vehiculo->poderpublico, $html);
                        $html = str_replace('$condicionesadicionales->reconocimientopublico', $vehiculo->reconocimientopublico, $html);
                        $html = str_replace('$condicionesadicionales->calidadpublica', $vehiculo->calidadpublica, $html);
                        $data['condicionesadicionales'] = $html;
                        // var_dump($data['condicionesadicionales']);
                    }
                    break;
                case 'infoaceptacion':
                    if (intval($fechaPre) >= intval($zonaDat[1]) && intval($fechaPre) <= intval($zonaDat[2])) {
                        $html = $i['html'];
                        $acepta = $this->getPLAcepta($idpre_prerevision, "acepta");
                        $acepta1 = $this->getPLAcepta($idpre_prerevision, "acepta1");
                        $acepta2 = $this->getPLAcepta($idpre_prerevision, "acepta2");
                        $acepta3 = $this->getPLAcepta($idpre_prerevision, "acepta3");
                        //                        echo $acepta;
                        if ($acepta == '') {
                            $html = str_replace('$aceptaD', 'none', $html);
                            $html = str_replace('$aceptaP', 'absolute', $html);
                        } else {
                            $html = str_replace('$aceptaD', 'block', $html);
                            $html = str_replace('$aceptaP', 'relative', $html);
                            $html = str_replace('$acepta_', $acepta, $html);
                        }
                        if ($acepta1 == '') {
                            $html = str_replace('$acepta1D', 'none', $html);
                            $html = str_replace('$acepta1P', 'absolute', $html);
                        } else {
                            $html = str_replace('$acepta1D', 'block', $html);
                            $html = str_replace('$acepta1P', 'relative', $html);
                            $html = str_replace('$acepta1', $acepta1, $html);
                        }
                        if ($acepta2 == '') {
                            $html = str_replace('$acepta2D', 'none', $html);
                            $html = str_replace('$acepta2P', 'absolute', $html);
                        } else {
                            $html = str_replace('$acepta2D', 'block', $html);
                            $html = str_replace('$acepta2P', 'relative', $html);
                            $html = str_replace('$acepta2', $acepta2, $html);
                        }
                        if ($acepta3 == '') {
                            $html = str_replace('$acepta3D', 'none', $html);
                            $html = str_replace('$acepta3P', 'absolute', $html);
                            $html = str_replace('$acepta3', '', $html);
                        } else {
                            $html = str_replace('$acepta3D', 'block', $html);
                            $html = str_replace('$acepta3P', 'relative', $html);
                            $html = str_replace('$acepta3', $acepta3, $html);
                        }
                        
                        $firma = $this->getFirma("sig", $vehiculo);
                        $html = str_replace('$firma', $firma, $html);
                        $html = str_replace('$cliente->nombre', $cliente->nombre, $html);
                        $html = str_replace('$cliente->direccion', $cliente->direccion, $html);
                        $html = str_replace('$cliente->telefono', $cliente->telefono, $html);
                        $html = str_replace('$cliente->correo', $cliente->correo, $html);
                        $html = str_replace('$cliente->numero_identificacion', $cliente->numero_identificacion, $html);
                        $data['aceptacion'] = $html;
                    }
                    break;
                default:
                    break;
            }
        }
        $data['presion_llantas'] = $this->presionLlantas($idpre_prerevision, $vehiculo);
        $data['fotos'] = $this->fotos($idpre_prerevision);
        $vapto = $this->getPL($idpre_prerevision, 'vapto');
        $nfuncionario = $this->getPL($idpre_prerevision, 'nfuncionario');
        $usuario_registro = $this->getPL($idpre_prerevision, 'usuario_registro');
        $nombre_user = $this->MPrerevision->getUser($usuario_registro);
        $observaciones = "";
        if ($vapto !== '' && $vapto !== null && $vapto !== "---") {
            if ($vapto == "1") {
                $vapto = "SI";
            } else {
                $vapto = "NO";
            }
            if ($nfuncionario == "") {
                $nfuncionario = "NO APLICA";
            }
            $observaciones = <<<EOF
                    
                    <br><br><strong>VISTO BUENO POR PARTE DEL ENCARGADO DEL OEC DE RECIBIR EL VEHICULO, DONDE GARANTIZA EL CUMPLIMIENTO DE LOS REQUISITOS PREVIOS A LA REVISIÓN TÉCNICO MECÁNICA Y DE GASES.</strong>
                    <br><br><table cellpadding="1" cellspacing="1" border="1" style="text-align:center" nobr="true">
                        <tr>
                            <td style="text-align: left" >Vehículo preparado para ser inspeccionado</td>
                            <td>$vapto</td>
                        </tr> 
                        <tr>
                            <td style="text-align: left" >Nombre del funcionario Responsable de la Preparación del Vehículo</td>
                            <td>$nombre_user->nombre</td>
                        </tr> 
                        <tr>
                            <td style="text-align: left" >Nombre del funcionario en Trabajo bajo tutela (si aplica)</td>
                            <td>$nfuncionario</td>
                        </tr> 
                    </table><br><br>
EOF;
        }
        if ($this->fechaAprobacionPre !== "") {
            if (intval($fechaPre) <= '20240128') {
                $data['fechaAprobacionPre'] = '2023-12-04';
                $data['versionPre'] = '13';
            } else if (intval($fechaPre) > '20240129' && intval($fechaPre) <= '20240620') {
                $data['fechaAprobacionPre'] = '2024-01-29';
                $data['versionPre'] = '14';
            } else if (intval($fechaPre) > '20240621' && intval($fechaPre) <= '20241028') {
                $data['fechaAprobacionPre'] = '2024-06-21';
                $data['versionPre'] = '15';
            } else if (intval($fechaPre) >= '20241029' && intval($fechaPre) <= '20260116') {
                $data['fechaAprobacionPre'] = '2024-10-29';
                $data['versionPre'] = '16';
            } else {
                $data['fechaAprobacionPre'] = '2026-01-17';
                $data['versionPre'] = '17';
            }
        } else {
            $data['fechaAprobacionPre'] = '';
            $data['versionPre'] = '';
        }


        $observaciones = $observaciones . $this->getPL($idpre_prerevision, 'observaciones');
        if ($observaciones == '') {
            $data['observaciones'] = "No registra.";
        } else {
            $data['observaciones'] = $observaciones;
        }
        $data['firmaEncargado'] = $this->getFirma('sigp', $vehiculo);
        $data['nombreUser'] = $nombre_user->nombre;
        $data['identificacionUser'] = $nombre_user->identificacion;
        $estado = $this->getPL($idpre_prerevision, 'estado');
        $articulo = $this->getPL($idpre_prerevision, 'articulo');
        if ($estado !== '---') {
            $data['resultados'] = $this->entregaResultados($vehiculo, $estado, $articulo);
        } else {
            $data['resultados'] = '';
        }
        $data['operarios'] = $this->getOperarios($idpre_prerevision);
        $data['documentos'] = $this->getDocumentos($idpre_prerevision);
        if ($savePdf == 1) {
            if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
                $this->ruta = "";
            } else {
                $this->ruta = "C:\\";
            }
            if (!is_dir($this->ruta . 'PDF')) {
                mkdir($this->ruta . 'PDF', 0777, true);
            }
            if (!is_dir($this->ruta . 'PDF\prerevision')) {
                mkdir($this->ruta . 'PDF\prerevision', 0777, true);
            }
            $data['tipo'] = 1;
            $data['url'] = $this->ruta . "PDF/prerevision/";
            $data['file'] = "Prerevision_" . $vehiculo->placa . '_' . $fechaPre . ".pdf";
            $url = $this->ruta . "PDF/prerevision/Prerevision_" . $vehiculo->placa . '_' . $fechaPre . ".pdf";
            $this->load->view('oficina/informes/VPrerevisionPDF', $data, true);
            $r = $this->enviarEmail($email, $url, $vehiculo->placa);
            //echo json_encode($r);
            //            redirect('oficina/informes/CPrerevision');
        } else {
            $data['tipo'] = 0;
            $data['url'] = $this->ruta . "PDF/prerevision/";
            $data['file'] = "Prerevision_" . $vehiculo->placa . '_' . $fechaPre . ".pdf";
            $this->load->view('oficina/informes/VPrerevisionPDF', $data);
        }
    }

    public function verEstado()
    {
        $idpre_prerevision = $this->input->post('idpre_prerevision');
        $data['fotos'] = $this->fotosVer($idpre_prerevision);
        $data['idprerevision'] = $idpre_prerevision;
          $this->load->view('oficina/informes/VGaleria', $data);
    }

    //    public function generar() {
    //        $idpre_prerevision = $this->input->post('idpre_prerevision');
    //        $Rcda = $this->Mcda->get();
    //        $cda = $Rcda->result();
    //        $encrptopenssl = New Opensslencryptdecrypt();
    //        $json = $encrptopenssl->decrypt(file_get_contents('recursos/prerevision.json', true));
    //        $informe = json_decode($json, true);
    //        $this->index = 0;
    //        $data['encabezado'] = "";
    //        $data['acepta'] = "";
    //        $data['acepta1'] = "";
    //        $data['acepta2'] = "";
    //        foreach ($informe as $i) {
    //            if ($i['iddatoinforme'] == '1') {
    //                $data['encabezado'] = $i['html'];
    //            }
    //            if ($i['id'] == 'acepta') {
    //                $data['acepta'] = $i['html'];
    //            }
    //            if ($i['id'] == 'acepta1') {
    //                $data['acepta1'] = $i['html'];
    //            }
    //            if ($i['id'] == 'acepta2') {
    //                $data['acepta2'] = $i['html'];
    //            }
    //        }
    //        $data['cda'] = $cda[0];
    //        $data['vehiculo'] = $this->MPrerevision->getInfoVehiculo($idpre_prerevision);
    //        $data['presion_llantas'] = $this->presionLlantas($idpre_prerevision, $data['vehiculo']);
    //        $data['lista_chequeo'] = $this->listaChequeo($idpre_prerevision);
    //        $data['fotos'] = $this->fotos($idpre_prerevision);
    //        $data['firmaEncargado'] = $this->getFirma('sigp', $data['vehiculo']);
    //        $data['condiciones'] = $this->getCondiciones();
    //        $data['aceptacion'] = $this->getAceptacionServicio($data['vehiculo'], $idpre_prerevision, $data);
    //        $estado = $this->getPL($idpre_prerevision, 'estado');
    //        if ($estado !== '---') {
    //            $data['resultados'] = $this->entregaResultados($data['vehiculo'], $estado);
    //        } else {
    //            $data['resultados'] = '';
    //        }
    //        $data['operarios'] = $this->getOperarios($idpre_prerevision);
    //        $data['documentos'] = $this->getDocumentos($idpre_prerevision);
    //
    //        $this->load->view('oficina/informes/VPrerevisionPDF', $data);
    //    }

    private function presionLlantas($ipp, $v)
    {
        $pl = '';
        $Rllanta_ejes = $this->getPL($ipp, 'llanta_ejes');
        $llantaEjes = explode("-", $Rllanta_ejes);
        $eje = 1;
        $encabezado2 = false;
        $encabezado4 = false;
        foreach ($llantaEjes as $le) {
            switch ($le) {
                case "1":
                    $nombreLlanta = 'Delantera';
                    if ($eje == 2)
                        $nombreLlanta = 'Trasera';
                    $ll = $this->rdnr($this->getPL($ipp, "llanta-$eje-1"));
                    $lla = $this->rdnr($this->getPL($ipp, "llanta-$eje-1-a"));
                    if (($this->mostrarAireAjustada && $this->mostrarAireDesajustada) || (!$this->mostrarAireAjustada && !$this->mostrarAireDesajustada)) {
                        $pl = $pl .
                            <<<EOF
                         <tr>
                                <td>$nombreLlanta</td>
                                <td colspan="4">$ll</td>
                                <td colspan="4">$lla</td>
                        </tr>      
EOF;
                    } else if ($this->mostrarAireDesajustada == FALSE) {
                        $pl = $pl .
                            <<<EOF
                         <tr>
                                <td>$nombreLlanta</td>
                                <td colspan="8">$lla</td>
                        </tr>      
EOF;
                    } else {
                        $pl = $pl .
                            <<<EOF
                         <tr>
                                <td>$nombreLlanta</td>
                                <td colspan="8">$ll</td>
                        </tr>      
EOF;
                    }

                    break;
                case "2":
                    $llI = $this->rdnr($this->getPL($ipp, "llanta-$eje-I"));
                    $llD = $this->rdnr($this->getPL($ipp, "llanta-$eje-D"));
                    $llIA = $this->rdnr($this->getPL($ipp, "llanta-$eje-I-a"));
                    $llDA = $this->rdnr($this->getPL($ipp, "llanta-$eje-D-a"));
                    if (!$encabezado2) {
                        $encabezado2 = true;
                        if (($this->mostrarAireAjustada && $this->mostrarAireDesajustada) || (!$this->mostrarAireAjustada && !$this->mostrarAireDesajustada)) {
                            $pl = $pl .
                                <<<EOF
                         <tr>	
                                <td></td>
                                <td colspan="2"><strong>Izquierda</strong></td>
                                <td colspan="2"><strong>Derecha</strong></td>
                                <td colspan="2"><strong>Izquierda</strong></td>
                                <td colspan="2"><strong>Derecha</strong></td>
                         </tr>
EOF;
                        } else {
                            $pl = $pl .
                                <<<EOF
                         <tr>	
                                <td></td>
                                <td colspan="4"><strong>Izquierda</strong></td>
                                <td colspan="4"><strong>Derecha</strong></td>
                         </tr>
EOF;
                        }
                    }
                    if (($this->mostrarAireAjustada && $this->mostrarAireDesajustada) || (!$this->mostrarAireAjustada && !$this->mostrarAireDesajustada)) {
                        $pl = $pl .
                            <<<EOF
                         <tr>
                                <td><strong>$eje</strong></td>
                                <td colspan="2">$llI</td>
                                <td colspan="2">$llD</td>
                                <td colspan="2">$llIA</td>
                                <td colspan="2">$llDA</td>
                        </tr>       
EOF;
                    } else if ($this->mostrarAireDesajustada == FALSE) {
                        $pl = $pl .
                            <<<EOF
                         <tr>
                                <td><strong>$eje</strong></td>
                                <td colspan="4">$llIA</td>
                                <td colspan="4">$llDA</td>
                        </tr>       
EOF;
                    } else {
                        $pl = $pl .
                            <<<EOF
                         <tr>
                                <td><strong>$eje</strong></td>
                                <td colspan="4">$llI</td>
                                <td colspan="4">$llD</td>
                        </tr>       
EOF;
                    }
                    break;
                case "4":
                    $llIE = $this->rdnr($this->getPL($ipp, "llanta-$eje-IE"));
                    $llII = $this->rdnr($this->getPL($ipp, "llanta-$eje-II"));
                    $llDE = $this->rdnr($this->getPL($ipp, "llanta-$eje-DE"));
                    $llDI = $this->rdnr($this->getPL($ipp, "llanta-$eje-DI"));
                    $llIEA = $this->rdnr($this->getPL($ipp, "llanta-$eje-IE-a"));
                    $llIIA = $this->rdnr($this->getPL($ipp, "llanta-$eje-II-a"));
                    $llDEA = $this->rdnr($this->getPL($ipp, "llanta-$eje-DE-a"));
                    $llDIA = $this->rdnr($this->getPL($ipp, "llanta-$eje-DI-a"));
                    if (!$encabezado4) {
                        $encabezado4 = true;
                        if (($this->mostrarAireAjustada && $this->mostrarAireDesajustada) || (!$this->mostrarAireAjustada && !$this->mostrarAireDesajustada)) {
                            $pl = $pl .
                                <<<EOF
                         <tr>	
                                <td></td>
                                <td><strong>Externa (S/A)</strong></td>
                                <td><strong>Interna (S/A)</strong></td>
                                <td><strong>Externa (S/A)</strong></td>
                                <td><strong>Interna (S/A)</strong></td>
                                <td><strong>Externa (S/A)</strong></td>
                                <td><strong>Interna (S/A)</strong></td>
                                <td><strong>Externa (S/A)</strong></td>
                                <td><strong>Interna (S/A)</strong></td>                                
                         </tr>
EOF;
                        } else {
                            $pl = $pl .
                                <<<EOF
                         <tr>	
                                <td></td>
                                <td colspan="2"><strong>Externa (S/A)</strong></td>
                                <td colspan="2"><strong>Interna (S/A)</strong></td>
                                <td colspan="2"><strong>Externa (S/A)</strong></td>
                                <td colspan="2"><strong>Interna (S/A)</strong></td>                         
                         </tr>
EOF;
                        }
                    }
                    if (($this->mostrarAireAjustada && $this->mostrarAireDesajustada) || (!$this->mostrarAireAjustada && !$this->mostrarAireDesajustada)) {

                        $pl = $pl .
                            <<<EOF
                         <tr>
                                <td><strong>$eje</strong></td>
                                <td>$llIE</td>
                                <td>$llII</td>
                                <td>$llDE</td>
                                <td>$llDI</td>
                                <td>$llIEA</td>
                                <td>$llIIA</td>
                                <td>$llDEA</td>
                                <td>$llDIA</td>
                        </tr>       
EOF;
                    } else if ($this->mostrarAireDesajustada == FALSE) {
                        $pl = $pl .
                            <<<EOF
                         <tr>
                                <td><strong>$eje</strong></td>
                                <td colspan="2">$llIEA</td>
                                <td colspan="2">$llIIA</td>
                                <td colspan="2">$llDEA</td>
                                <td colspan="2">$llDIA</td>
                        </tr>       
EOF;
                    } else {
                        $pl = $pl .
                            <<<EOF
                         <tr>
                                <td><strong>$eje</strong></td>
                                <td colspan="2">$llIE</td>
                                <td colspan="2">$llII</td>
                                <td colspan="2">$llDE</td>
                                <td colspan="2">$llDI</td>
                        </tr>       
EOF;
                    }

                    break;

                default:
                    break;
            }
            $eje++;
        }
        if ($v->tipo_vehiculo !== 'Motocicleta') {
            $llantaR = "";
            if ($this->getPL($ipp, 'llanta-R') !== "---") {
                $llantaR = $this->rdnr($this->getPL($ipp, 'llanta-R'));
            }
            $llantaR2 = "";
            if ($this->getPL($ipp, 'llanta-R2') !== "---") {
                $llantaR2 = $this->rdnr($this->getPL($ipp, 'llanta-R2'));
            }
            $llantaRA = "";
            if ($this->getPL($ipp, 'llanta-R-a') !== "---") {
                $llantaRA = $this->rdnr($this->getPL($ipp, 'llanta-R-a'));
            }
            $llantaR2A = "";
            if ($this->getPL($ipp, 'llanta-R2-a') !== "---") {
                $llantaR2A = $this->rdnr($this->getPL($ipp, 'llanta-R2-a'));
            }

            if ($llantaR2 == '0.00') {
                $llantaR2 = '';
            }

            if ($llantaR !== '---') {
                if (($this->mostrarAireAjustada && $this->mostrarAireDesajustada) || (!$this->mostrarAireAjustada && !$this->mostrarAireDesajustada)) {

                    if ($llantaR2A == '0.00') {
                        $llantaR2A = '';
                    }
                    $pl = $pl .
                        <<<EOF
                         <tr>
                                <td></td>
                                <td colspan="2">Repuesto 1</td>
                                <td colspan="2">Repuesto 2</td>
                                <td colspan="2">Repuesto 1</td>
                                <td colspan="2">Repuesto 2</td>
                        </tr>       
                         <tr>
                                <td>Repuestos</td>
                                <td colspan="2">$llantaR</td>
                                <td colspan="2">$llantaR2</td>
                                <td colspan="2">$llantaRA</td>
                                <td colspan="2">$llantaR2A</td>
                        </tr>       
EOF;
                } elseif ($this->mostrarAireDesajustada == FALSE) {
                    $pl = $pl .
                        <<<EOF
                         <tr>
                                <td></td>
                                <td colspan="4">Repuesto 1</td>
                                <td colspan="4">Repuesto 2</td>
                        </tr>       
                         <tr>
                                <td>Repuestos</td>
                                <td colspan="4">$llantaRA</td>
                                <td colspan="4">$llantaR2A</td>
                        </tr>       
EOF;
                } else {
                    $pl = $pl .
                        <<<EOF
                         <tr>
                                <td></td>
                                <td colspan="4">Repuesto 1</td>
                                <td colspan="4">Repuesto 2</td>
                        </tr>       
                         <tr>
                                <td>Repuestos</td>
                                <td colspan="4">$llantaR</td>
                                <td colspan="4">$llantaR2</td>
                        </tr>       
EOF;
                }
            }
        }
        if (($this->mostrarAireAjustada && $this->mostrarAireDesajustada) || (!$this->mostrarAireAjustada && !$this->mostrarAireDesajustada)) {
            $init = <<<EOF
        <tr>
        <td>Eje</td>
        <td colspan="4"><strong>Presión de aire inicial</strong></td>
        <td colspan="4"><strong>Presión de aire final ajustada por el usuario</strong></td>
    </tr>
EOF;
        } else {
            $init = <<<EOF
        <tr>
        <td>Eje</td>
        <td colspan="8"><strong>Presión de inflado</strong></td>
    </tr>
EOF;
        }

        return $init . $pl;
    }

    private function getPL($ipp, $id)
    {
        $dato = $this->MPrerevision->getPre_dato($ipp, $id);
        return $dato->valor;
    }

    private function getPLAcepta($ipp, $id)
    {
        $dato = $this->MPrerevision->getAceptaSINO($ipp, $id);
        return $dato;
    }

    private function listaChequeo($ipp)
    {
        $result = $this->MPrerevision->getPre_datoApr($ipp, 'chk-');
        $listaChequeo = '';
        foreach ($result->result() as $cl) {
            $cumple = '';
            switch ($cl->valor) {
                case 'SI':
                    $cumple = <<<EOF
                           <td>X</td>
                           <td></td>
                           <td></td>
EOF;
                    break;
                case 'NO':
                    $cumple = <<<EOF
                           <td></td>
                           <td>X</td>
                           <td></td>
EOF;
                    break;
                case 'NA':
                    $cumple = <<<EOF
                           <td></td>
                           <td></td>
                           <td>X</td>
EOF;
                    break;
                case ' ':
                    $cumple = <<<EOF
                           <td></td>
EOF;
                    break;
                default:
                    $cumple = <<<EOF
                           <td colspan="3">$cl->valor</td>
EOF;
                    break;
            }
            if ($cl->valor == ' ' || $cl->valor == '') {
                $background_color = 'background-color: lightgray';
                $font_weight = 'font-weight: bold';
                $colspan = 4;
            } else {
                $background_color = 'background-color: white';
                $font_weight = 'font-weight: normal';
                $colspan = '';
            }

            $listaChequeo = $listaChequeo . <<<EOF
                <tr>
                           <td style="text-align: left;$font_weight;text-align: justify;$background_color" colspan="$colspan">$cl->label</td>
                           $cumple
                </tr>
EOF;
        }
        return $listaChequeo;
    }

    private function fotos($ipp)
    {
        $this->sistemaOperativo = sistemaoperativo();
        $result = $this->MPrerevision->getPre_datoApr($ipp, 'foto');
        // echo 'entre';
        //  var_dump($result->num_rows());
        $fotos = '<table cellpadding="1" cellspacing="1" style="text-align:center;vertical-align: middle" nobr="true">';

        $encrptopenssl = new Opensslencryptdecrypt();
        $salto = -1;
        // echo "antes";
        $hay = false;
        if ($result->num_rows() !== 0) {
            foreach ($result->result() as $rta) {
                // echo $rta;
                $hay = true;
                if ($salto == 3) {
                    $salto = -1;
                }
                $salto++;
                if ($salto == 0) {
                    $fotos = $fotos . '<tr>';
                }
                if ($this->sistemaOperativo == "" || $this->sistemaOperativo == null) {
                    $img = $encrptopenssl->decrypt(file_get_contents($this->ruta . 'tcm/prerevision/' . str_replace('|', '/', $rta->valor) . '.dat', true));
                } else {
                    $img = $encrptopenssl->decrypt(file_get_contents($this->ruta . 'C:/tcm/prerevision/' . str_replace('|', '/', $rta->valor) . '.dat', true));
                }

                $img = explode(",", $img);
                $fotos = $fotos . <<<EOF
                 <td><img src="@$img[1]" width="155" height="100" /></td>
EOF;
                if ($salto == 3) {
                    $fotos = $fotos . '</tr>';
                }
            }
            if ($salto !== 3) {
                $fotos = $fotos . '</tr>';
            }
            $fotos = $fotos . '</table>';
            //  echo $fotos;
            if (!$hay) {
                $fotos = "";
            }
        } else {
            $fotos = "";
        }
        return $fotos;
    }

    private function fotosVer($ipp)
    {
        $this->sistemaOperativo = sistemaoperativo();
        $result = $this->MPrerevision->getPre_datoApr($ipp, 'foto');
        $fotos = '<table cellpadding="1" cellspacing="1" style="text-align:center;vertical-align: middle" nobr="true">';
        $encrptopenssl = new Opensslencryptdecrypt();
        $salto = -1;
        // echo "antes";
        $hay = false;
        if ($result->num_rows() !== 0) {
            foreach ($result->result() as $rta) {
                //                echo $rta;
                $hay = true;
                if ($salto == 3) {
                    $salto = -1;
                }
                $salto++;
                if ($salto == 0) {
                    $fotos = $fotos . '<tr>';
                }
                if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
                    $img = $encrptopenssl->decrypt(file_get_contents('tcm/prerevision/' . str_replace('|', '/', $rta->valor) . '.dat', true));
                } else {
                    $img = $encrptopenssl->decrypt(file_get_contents('C:/tcm/prerevision/' . str_replace('|', '/', $rta->valor) . '.dat', true));
                }

                $img = explode(",", $img);
                $fotos = $fotos . <<<EOF
                 <td><button type="submit" style="width: 155px;height: 100px;background: url('data:image/png;base64,$img[1]') no-repeat; background-size: 155px 100px;" value="data:image/png;base64,$img[1]" name="foto"></button></td>
EOF;
                if ($salto == 3) {
                    $fotos = $fotos . '</tr>';
                }
            }
            if ($salto !== 3) {
                $fotos = $fotos . '</tr>';
            }
            $fotos = $fotos . '</table>';
            //             echo $fotos;
            if (!$hay) {
                $fotos = "";
            }
        } else {
            $fotos = "";
        }
        return $fotos;
    }

    public function verFoto()
    {
        $foto = $this->input->post('foto');
        $idpre_prerevision = $this->input->post('idprerevision');
        $data['fotos'] = $this->fotosVer($idpre_prerevision);
        $data['idprerevision'] = $idpre_prerevision;
        $data['foto'] = $foto;
        $this->load->view('oficina/informes/VGaleria', $data);
    }

    private function getCondiciones()
    {
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('recursos/prerevision.json', true));
        $informe = json_decode($json, true);
        $condiciones = "";
        foreach ($informe as $i) {
            if ($i["zona"] == "condiciones") {
                $condiciones = substr($i["html"], 70, -4);
                break;
            }
        }
        return $condiciones;
    }

    private function getFirma($tipo, $datosPre)
    {
        $this->sistemaOperativo = sistemaoperativo();

        $fecha = $datosPre->fecha_prerevision;
        $fecha = explode("/", $fecha);
        $fecha = $fecha[0] . $fecha[1] . $fecha[2];
        $firma = '';
        if ($datosPre->ocacion == 'Primera vez') {
            $tipoFirma = $tipo . "_0.dat";
        } else {
            $tipoFirma = $tipo . "_1.dat";
        }
        $encrptopenssl = new Opensslencryptdecrypt();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            $file = 'tcm/prerevision/' . $fecha . '/' . $datosPre->placa . '/' . $tipoFirma;
        } else {
            $file = 'c:/tcm/prerevision/' . $fecha . '/' . $datosPre->placa . '/' . $tipoFirma;
        }

        if (file_exists($file)) {
            $firma = $encrptopenssl->decrypt(file_get_contents($file, true));
            $firma = explode(",", $firma);
            $firma = $firma[1];
        } else {
            if ($tipo == 'sigpos') {
                if ($datosPre->ocacion == 'Primera vez') {
                    $tipoFirma = "sig_0.dat";
                } else {
                    $tipoFirma = "sig_1.dat";
                }
                $firma = $encrptopenssl->decrypt(file_get_contents($file, true));
                $firma = explode(",", $firma);
                $firma = $firma[1];
            }
        }
        return $firma;
    }

    private function getAceptacionServicio($vehiculo, $ipp, $data)
    {
        $cliente = $this->MPrerevision->getCliente($vehiculo->placa);
        $firma = $this->getFirma("sig", $vehiculo);
        $si_no = $this->getPL($ipp, "acepta");
        $si_no1 = $this->getPL($ipp, "acepta1");
        $si_no2 = $this->getPL($ipp, "acepta2");
        $htmlacepta = "";
        if ($si_no !== "---") {
            $strpos = strpos($data['acepta'], "<ons-list>");
            $htmlacepta = $htmlacepta . str_replace("->", "-", substr($data['acepta'], 0, $strpos));
            if ($si_no == "ON") {
                $htmlacepta = $htmlacepta . '<table width="15%" style="text-align:center" nobr="true">
                    <tr>
                        <td><strong>SI</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1">X</td>
                        <td><strong>NO</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1"></td>
                    </tr>
                </table>';
            } else {
                $htmlacepta = $htmlacepta . '<table width="15%" style="text-align:center" nobr="true">
                    <tr>
                        <td><strong>SI</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1"></td>
                        <td><strong>NO</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1">X</td>
                    </tr>
                </table>';
            }
        }
        if ($si_no1 !== "---") {
            $strpos = strpos($data['acepta1'], "<ons-list>");
            $htmlacepta = $htmlacepta . str_replace("->", "-", substr($data['acepta1'], 0, $strpos));
            if ($si_no1 == "ON") {
                $htmlacepta = $htmlacepta . '<table width="15%" style="text-align:center" nobr="true">
                    <tr>
                        <td><strong>SI</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1">X</td>
                        <td><strong>NO</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1"></td>
                    </tr>
                </table>';
            } else {
                $htmlacepta = $htmlacepta . '<table width="15%" style="text-align:center" nobr="true">
                    <tr>
                        <td><strong>SI</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1"></td>
                        <td><strong>NO</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1">X</td>
                    </tr>
                </table>';
            }
        }
        if ($si_no2 !== "---") {
            $strpos = strpos($data['acepta2'], "<ons-list>");
            $htmlacepta = $htmlacepta . str_replace("->", "-", substr($data['acepta2'], 0, $strpos));
            if ($si_no2 == "ON") {
                $htmlacepta = $htmlacepta . '<table width="15%" style="text-align:center">
                    <tr>
                        <td><strong>SI</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1">X</td>
                        <td><strong>NO</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1"></td>
                    </tr>
                </table>';
            } else {
                $htmlacepta = $htmlacepta . '<table width="15%" style="text-align:center" nobr="true">
                    <tr>
                        <td><strong>SI</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1"></td>
                        <td><strong>NO</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1">X</td>
                    </tr>
                </table>';
            }
        }
        $aceptacion = <<<EOF
                <p style="text-align: justify">Declaro que: he leído, entiendo y acepto las condiciones de servicio del CDA., por lo tanto autorizo la inspección de mi vehículo. Así mismo, estoy de acuerdo con las observaciones realizadas en relación con el estado del vehículo para realizar el proceso de inspección.</p>
                <table  cellpadding="1" border="1" cellspacing="1" style="text-align:left;vertical-align: middle" nobr="true">
                    <tr>
                        <td><strong>NOMBRE</strong></td>
                        <td>$cliente->nombre</td>
                        <td rowspan="4"><img  width="190" height="55"  src="@$firma" /></td>
                    </tr>
                    <tr>
                        <td><strong>DIRECCION</strong></td>
                        <td>$cliente->direccion</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong>TELÉFONO</strong></td>
                        <td>$cliente->telefono</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong>EMAIL</strong></td>
                        <td>$cliente->correo</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td><strong>Documento No: </strong>$cliente->numero_identificacion</td>
                    </tr>
                </table>
                $htmlacepta             
EOF;
        return $aceptacion;
    }

    private function entregaResultados($vehiculo, $estado, $articulo)
    {
        $cliente = $this->MPrerevision->getCliente($vehiculo->placa);
        $firma = $this->getFirma("sigpos", $vehiculo);
        if ($estado == '1') {
            $resultado = <<<EOF
                <table width="80%" nobr="true">
                    <tr>
                        <td><strong>SI</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1">X</td>
                        <td><strong>NO</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1"></td>
                    </tr>
                </table>
EOF;
        } elseif ($estado == '0') {
            $resultado = <<<EOF
                <table width="80%" nobr="true">
                    <tr>
                        <td><strong>SI</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1"></td>
                        <td><strong>NO</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1">X</td>
                    </tr>
                </table>
EOF;
        } else {
            $resultado = <<<EOF
                <table width="80%" nobr="true">
                    <tr>
                        <td><strong>SI</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1"></td>
                        <td><strong>NO</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1"></td>
                    </tr>
                </table>
EOF;
        }
        if ($articulo == '1') {
            $resultadoArticulo = <<<EOF
                <table width="80%" nobr="true">
                    <tr>
                        <td><strong>SI</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1">X</td>
                        <td><strong>NO</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1"></td>
                    </tr>
                </table>
EOF;
        } elseif ($articulo == '0') {
            $resultadoArticulo = <<<EOF
                <table width="80%" nobr="true">
                    <tr>
                        <td><strong>SI</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1"></td>
                        <td><strong>NO</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1">X</td>
                    </tr>
                </table>
EOF;
        } else {
            $resultadoArticulo = <<<EOF
                <table width="80%" nobr="true">
                    <tr>
                        <td><strong>SI</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1"></td>
                        <td><strong>NO</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1"></td>
                    </tr>
                </table>
EOF;
        }
        $declaracion = "Declaro que: He recibido el Formato Uniforme de Resultados FUR y el Certificado de la Inspección (si aplica), junto con los documentos de la motocicleta, y he confrontado la información de la licencia de transito con los datos registrados en el FUR y certificado. Además que he recibo la motocicleta sin daños ocasionados, en el mismo estado y condiciones en que la entregue.";
        $conf = @file_get_contents("system/oficina.json");
        if (isset($conf)) {
            $encrptopenssl = new Opensslencryptdecrypt();
            $json = $encrptopenssl->decrypt($conf, true);
            $dat = json_decode($json, true);
            if ($dat) {
                foreach ($dat as $d) {
                    if ($d['nombre'] == "declaracion_entrega") {
                        $declaracion = $d['valor'];
                    }
                }
            }
        }
        $aceptacion = <<<EOF
                <table  cellpadding="1" border="1" cellspacing="1" style="text-align:left;vertical-align: middle" nobr="true">
                    <tr>
                        <td width="80%" ><p style="text-align: justify">$declaracion</p></td>
                        <td width="20%"><img  width="190" height="55"  src="@$firma" /><br><br><strong style="font-size: 6px; margin-top: 90px">FIRMA ENTREGA DE RESULTADOS</strong></td>
                     
                    </tr>
                    <tr>
                        <td width="80%">Inspección aprobada</td>
                        <td width="20%" style="text-align:center;vertical-align: middle">$resultado</td>
                        
                    </tr>
                    <tr>
                        <td width="80%" >El propietario, poseedor o tenedor del vehículo automotor SOLICITA que el FUR le sea
entregado a través de correo electrónico certificado? (resolución 20203040003625 de 2020
articulo 14)</td>
                        <td width="20%" style="text-align:center;vertical-align: middle">$resultadoArticulo</td>
                    </tr>
                    <tr>
                        <td ><strong>Nombre cliente: </strong>$cliente->nombre</td>
                        <td><strong>Documento No: </strong>$cliente->numero_identificacion</td>
                    </tr>
                </table>
EOF;
        return $aceptacion;
    }

    private function getOperarios($idpp)
    {
        $operarios = $this->MPrerevision->getOperarios($idpp);
        $resultado = <<<EOF
                <table>
                    <tr>
                        <td colspan="2"><strong>Operarios que intervinieron en la inspección</strong></td>
                    </tr>
                    <tr>
                        <td cellpadding="1" border="1" cellspacing="1" style="width:15px"><strong>No</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1" style="width:250px"><strong>OPERARIO</strong></td>
                    </tr>
EOF;
        $i = 1;
        $enc = true;
        foreach ($operarios->result() as $operario) {
            //             if ($operario->user !== "" && $enc) {
            //                 $enc = false;
            //                 $resultado = $resultado . <<<EOF
            //                 <tr>
            //                     <td cellpadding="1" border="1" cellspacing="1">$i</td>
            //                     <td cellpadding="1" border="1" cellspacing="1">$operario->user</td>
            //                 </tr>
            // EOF;
            //             }

            $resultado = $resultado . <<<EOF
                    <tr>
                        <td cellpadding="1" border="1" cellspacing="1">$i</td>
                        <td cellpadding="1" border="1" cellspacing="1">$operario->nombre</td>
                    </tr>
EOF;
            $i++;
        }

        $resultado = $resultado . "</table>";
        return $resultado;
    }

    private function getDocumentos($idpp)
    {
        $documentos = $this->MPrerevision->getDocumentos($idpp);
        if ($documentos !== "") {
            $resultado = <<<EOF
                <table >
                    <tr>
                        <td colspan="2"><strong>Documentos relacionados en la inspección</strong></td>
                    </tr>
                    <tr>
                        <td cellpadding="1" border="1" cellspacing="1" style="width:130px"><strong>Documento</strong></td>
                        <td cellpadding="1" border="1" cellspacing="1" style="width:150px"><strong>Relación</strong></td>
                    </tr>
                    <tr>
                        <td cellpadding="1" border="1" cellspacing="1">Número solicitud del RUNT</td>
                        <td cellpadding="1" border="1" cellspacing="1">$documentos->numero_solicitud</td>
                    </tr>
                    <tr>
                        <td cellpadding="1" border="1" cellspacing="1">Número certificado</td>
                        <td cellpadding="1" border="1" cellspacing="1">$documentos->numero_certificado</td>
                    </tr>
                    <tr>
                        <td cellpadding="1" border="1" cellspacing="1">Número consecutivo RUNT</td>
                        <td cellpadding="1" border="1" cellspacing="1">$documentos->consecutivo_runt</td>
                    </tr>
                    <tr>
                        <td cellpadding="1" border="1" cellspacing="1">PIN</td>
                        <td cellpadding="1" border="1" cellspacing="1">$documentos->pin0</td>
                    </tr>
                </table>
EOF;
        } else {
            $resultado = "";
        }

        return $resultado;
    }

    private function rdnr($valor)
    {
        $dato = '';
        if ($valor !== '') {
            if (floatval($valor) === 0.00 || floatval($valor) === 0.0 || floatval($valor) === 0) {
                $dato = "0.00";
            } else {
                if (intval($valor) < 10) {
                    $valorNegativo = false;
                    $dato = abs(round($valor, 2));
                    if ($valor < 0) {
                        $valorNegativo = true;
                        if (intval($valor) > -10) {
                            if (substr($dato, 2) == "") {
                                $dato = $dato . ".00";
                            } elseif (substr($dato, 3) == "" || substr($dato, 3) == '0') {
                                $dato = $dato . "0";
                            }
                        } elseif (intval($valor) <= -10 && intval($valor) > -100) {
                            $dato = abs(round($valor, 1));
                            if (substr($dato, 2) == "") {
                                $dato = $dato . ".0";
                            }
                        } else {
                            $dato = abs(round($valor));
                        }
                    } else {
                        if (substr($dato, 1) == "") {
                            $dato = $dato . ".00";
                        } elseif (substr($dato, 3) == "" || substr($dato, 3) == '0') {
                            $dato = $dato . "0";
                        }
                    }
                    if ($valorNegativo) {
                        $dato = "-" . $dato;
                    }
                } elseif (intval($valor) >= 10 && intval($valor) < 100) {
                    $dato = round($valor, 1);
                    if (substr($dato, 2) == "") {
                        $dato = $dato . ".0";
                    }
                } else {
                    $dato = round($valor);
                }
            }
        }
        return $dato;
    }

    function enviarEmail($email, $url, $placa)
    {
        //        echo $this->emailCDA;
        //        echo $this->pwEmailCDA;
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.googlemail.com',
            'smtp_port' => '465',
            'smtp_user' => $this->emailCDA,
            'smtp_pass' => $this->pwEmailCDA,
            'mailtype' => 'html',
            'smtp_crypto' => 'ssl',
            'newline' => "\r\n",
            'useragent' => $this->nombreCDA,
            'smtp_timeout' => '5',
            'wordwrap' => TRUE,
            'charset' => 'utf-8'
        );
        //        $data = $this->load->view('Viewemail/emailregistro','', TRUE);
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from($this->emailCDA, $this->nombreCDA, $this->emailCDA);
        $this->email->subject($this->asuntoEmailCDA . "Formato de prerevisión " . $placa);
        $this->email->attach($url);
        $this->email->message($this->vistaEmailCDA);
        $this->email->to($email);
        if ($this->email->send(FALSE)) {
            return 1;
            //            echo "enviado<br/>";
            //            echo $this->email->print_debugger(array('headers'));
        } else {
            return 0;
            //            echo "fallo <br/>";
            //            echo "error: " . $this->email->print_debugger(array('headers'));
        }
    }
}


