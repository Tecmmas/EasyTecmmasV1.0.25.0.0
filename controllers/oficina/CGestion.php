<?php

defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
ini_set('memory_limit', '-1');

set_time_limit(300);

class Cgestion extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("oficina/MGestion");
        $this->load->model("dominio/Mconfig_prueba");
        $this->load->model("dominio/MEventosindra");
        $this->load->model("dominio/Mvehiculo");
        $this->load->model("dominio/Mresultado");
        $this->load->library('encryption');
        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
    }

    public $sistemaOperativo = "";
    public function index()
    {
        if ($this->session->userdata('IdUsuario') == '' || $this->session->userdata('IdUsuario') == '1024') {
            redirect('Cindex');
        }
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/oficina.json', true), true);
        $ofc = json_decode($json, true);
        foreach ($ofc as $d) {
            $data[$d['nombre']] = $d['valor'];
        }

        $estadoSicovAlternativo = $this->Mconfig_prueba->getSicovAlternativoState();
        $data['sicovModoAlternativo'] = $estadoSicovAlternativo['activo'];
        $data['ipSicovAlternativo'] = $estadoSicovAlternativo['url'];
        $data['ipSicov2'] = $this->Mconfig_prueba->getSicov2Url();

        $this->load->view('oficina/VGestion', $data);
    }

    public function cargarVehiculos()
    {
        $data['vEnPista'] = $this->MGestion->getVehiculosEnPista();
        $data['vRechSinFirmar'] = $this->MGestion->getVehiculosRechazados();
        $data['vAproSinFirmar'] = $this->MGestion->getVehiculosAprobados();
        $data['vRechSinConsecutivo'] = $this->MGestion->getRechazadoSinCosecutivo();
        $data['vFinalizado'] = $this->MGestion->getVehiculoTerminado();
        $data['vAproSinConsecutivo'] = $this->MGestion->getAprobadoSinCosecutivo();
        echo json_encode($data);
    }

    public function migracionPrerevision()
    {
        $this->MGestion->migracionPrerevision();
    }

    public function cargarSICOV()
    {
        //        $sicov = $this->setConf();
        //        var_dump($sicov);
        $data['sicovEventos'] = $this->MEventosindra->getAllHoy($this->input->post("placa"));
        echo json_encode($data);
    }

    public function enviarEventosIndra()
    {
        $sicov["ipSicov"] = $this->input->post("ipSicov");
        $estadoSicovAlternativo = $this->Mconfig_prueba->getSicovAlternativoState();
        $sicov["sicovModoAlternativo"] = $estadoSicovAlternativo['activo'];
        $sicov["ipSicovAlternativo"] = $estadoSicovAlternativo['url'];
        $sicov["idCdaRUNT"] = $this->input->post("idCdaRUNT");
        $eventos = $this->MEventosindra->getEventos0();
        if ($eventos) {
            //            $e = $eventos[0];
            //            echo var_dump($e);
            foreach ($eventos as $e) {
                $this->enviar($sicov, $e);
                //                break;
            }
        }
    }

    public function getEstadoSicovAlternativo()
    {
        $estado = $this->Mconfig_prueba->getSicovAlternativoState();
        $version = md5($estado['activo'] . '|' . $estado['url']);

        echo json_encode(array(
            'success' => true,
            'estado' => $estado,
            'version' => $version
        ));
    }

    public function setEstadoSicovAlternativo()
    {
        $activo = $this->input->post('activo');
        $url = trim(strval($this->input->post('url')));

        if (strval($activo) === '1' && $url === '') {
            echo json_encode(array(
                'success' => false,
                'mensaje' => 'Debe ingresar la URL del direccionamiento alternativo'
            ));
            return;
        }

        if ($url !== '' && !$this->isValidSicovUrl($url)) {
            echo json_encode(array(
                'success' => false,
                'mensaje' => 'La URL debe estar en formato host, host:puerto o https://host/ruta'
            ));
            return;
        }

        $estado = $this->Mconfig_prueba->setSicovAlternativoState($activo, $url);
        $version = md5($estado['activo'] . '|' . $estado['url']);

        echo json_encode(array(
            'success' => true,
            'estado' => $estado,
            'version' => $version
        ));
    }

    public function setIpSicov2()
    {
        $url = trim(strval($this->input->post('url')));

        if ($url !== '' && !$this->isValidSicovUrl($url)) {
            echo json_encode(array(
                'success' => false,
                'mensaje' => 'La URL debe estar en formato host, host:puerto o https://host/ruta'
            ));
            return;
        }

        echo json_encode(array(
            'success' => true,
            'url' => $this->Mconfig_prueba->setSicov2Url($this->normalizarSicov2Url($url))
        ));
    }

    public function consultarAuditoria()
    {
        echo json_encode($this->MGestion->getAuditoria());
    }

    public function consultarPlacaSalaE()
    {
        echo json_encode($this->MGestion->getPlacaSalaE());
    }

    private function enviar($sicov, $ev)
    {

        $url = 'http://' . $sicov["ipSicov"] . '/sicov.asmx?WSDL';
        $datos_conexion = explode(":", $sicov["ipSicov"]);
        if ($sicov["sicovModoAlternativo"] == '1') {
            $ep = $this->sicovEndpoint($sicov["ipSicovAlternativo"], '/sicov.asmx?WSDL');
            $url            = $ep['url'];
            $datos_conexion = [$ep['host'], $ep['port']];
        }
        $host = $datos_conexion[0];
        if (count($datos_conexion) > 1) {
            $port = $datos_conexion[1];
        } else {
            $port = 80;
        }
        $waitTimeoutInSeconds = 2;
        error_reporting(0);
        if ($fp = fsockopen($host, $port, $errCode, $errStr, $waitTimeoutInSeconds)) {
            file_put_contents('encdes/salidaEVENTO.txt', "");
            file_put_contents('encdes/entradaEVENTO.txt', "");
            $client = new SoapClient($url);
            $msg = '';
            $datos_ = explode("|", $ev->cadena);
            $encrptopenssl = new Opensslencryptdecrypt();
            if (count($datos_) == 1) {
                $ev->cadena = $encrptopenssl->desencrypt_RIJNDAEL($ev->cadena);
                $datos_ = explode("|", $ev->cadena);
            }
            $cad = $datos_[0] . '|' . $datos_[1] . '|' . $datos_[2] . '|' . $datos_[3] . '|' . $datos_[4] . '|' . $datos_[5] . '||' . $sicov['idCdaRUNT'];
            if ($datos_[2] !== 'Ruidos') {
                $this->sistemaOperativo = sistemaoperativo();
                if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
                    $key = "v239pShjXXXXXXXXXXXXXXXXXXXXXXXX";
                    $iv = "sicovcontacindra";
                    $eve = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $cad, MCRYPT_MODE_CBC, $iv);
                    $eve = base64_encode($eve);
                } else {
                    $cad = str_replace(" ", "_", $cad);
                    $url = 'http://localhost:8093/enc/enc.php' . '?cad=' . $cad;
                    $eve = file_get_contents($url);
                }
                $evento = array(
                    'cadena' => $eve
                );
                // var_dump(  mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($eve), MCRYPT_MODE_CBC, $iv));

                $respuesta = $client->EnviarEventosSicov($evento);
                $respuesta = $respuesta->EnviarEventosSicovResult;
                if ($respuesta->codRespuesta == '1') {
                    $data['enviado'] = "1";
                    $estado = 'exito';
                    $msg = 'Operación Exitosa';
                } else {
                    $data['enviado'] = "2";
                    $msg = 'Operación Fallida';
                    $estado = 'error';
                }
                $data['ideventosindra'] = $ev->ideventosindra;
                $data['respuesta'] = $msg . '|' . $respuesta->codRespuesta . '|evento|' . $estado . '|' . $respuesta->msjRespuesta;
                $this->MEventosindra->update($data);
            } else {
                $data['enviado'] = "8";
                $data['ideventosindra'] = $ev->ideventosindra;
                $data['respuesta'] = "NA";
                $this->MEventosindra->update($data);
            }
        }
        if ($fp) {
            fclose($fp);
        }
    }

    private function formato_texto($cadena)
    {
        $no_permitidas = array("Ñ", "ñ", "á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹", "'", "");
        $permitidas = array("N", "n", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E", "", "");
        $texto = str_replace($no_permitidas, $permitidas, $cadena);
        return $texto;
    }

    /**
     * Resuelve el direccionamiento de SICOV: acepta host, host:puerto o URL completa.
     * Retorna ['url' => WSDL, 'host' => host para fsockopen, 'port' => puerto].
     */
    private function sicovEndpoint($valor, $rutaPorDefecto)
    {
        $valor = trim(strval($valor));

        if (preg_match('#^https?://#i', $valor)) {
            $p     = parse_url($valor);
            $https = strtolower($p['scheme']) === 'https';
            $host  = $p['host'] ?? '';
            $port  = $p['port'] ?? ($https ? 443 : 80);
            $url   = $p['scheme'] . '://' . $host . (isset($p['port']) ? ':' . $p['port'] : '') . ($p['path'] ?? '');
            $url  .= isset($p['query']) ? '?' . $p['query'] : '?WSDL';

            return ['url' => $url, 'host' => ($https ? 'ssl://' : '') . $host, 'port' => $port];
        }

        $datos = explode(':', $valor);

        return [
            'url'  => 'http://' . $valor . $rutaPorDefecto,
            'host' => $datos[0],
            'port' => count($datos) > 1 ? $datos[1] : 80,
        ];
    }

    /**
     * Si el usuario digita una URL completa para SICOV 2.0 se guarda ya lista como base de la API
     * (esquema://host[:puerto] + /api); con host o host:puerto se guarda tal cual.
     */
    private function normalizarSicov2Url($url)
    {
        if (!preg_match('#^https?://#i', $url)) {
            return $url;
        }
        $p      = parse_url($url);
        $origen = $p['scheme'] . '://' . $p['host'] . (isset($p['port']) ? ':' . $p['port'] : '');
        $path   = rtrim($p['path'] ?? '', '/');

        return $origen . (stripos($path, '/api') === 0 ? $path : '/api');
    }

    private function isValidSicovUrl($url)
    {
        // host, host:puerto o URL completa (http://host[:puerto]/ruta)
        return preg_match('/^[a-zA-Z0-9.-]+(?::[0-9]{1,5})?$/', $url) === 1
            || preg_match('#^https?://[a-zA-Z0-9.-]+(?::[0-9]{1,5})?(?:/[a-zA-Z0-9._~/%-]*)?(?:\?[a-zA-Z0-9._~=&%-]*)?$#i', $url) === 1;
    }

    public function getResultadoGases()
    {
        $idprueba = $this->input->post("idprueba");
        $rta = $this->Mresultado->getxIdprueba($idprueba);
        echo json_encode($rta->result());
    }

    public function ranTh()
    {
        $this->MGestion->ranTh();
    }

    public function ranTh1()
    {
        $idm = $this->input->post("idm");
        $this->MGestion->ranTh1($idm);
    }

    //    public function actualizarSalaE(){
    //        $dominio = $this->input->post('dominio');
    //        
    //    }
}
