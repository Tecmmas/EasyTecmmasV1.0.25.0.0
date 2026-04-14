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
        $sicov["sicovModoAlternativo"] = $this->input->post("sicovModoAlternativo");
        $sicov["ipSicovAlternativo"] = $this->input->post("ipSicovAlternativo");
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
            $url = 'http://' . $sicov["ipSicovAlternativo"] . '/sicov.asmx?WSDL';
            $datos_conexion = explode(":", $sicov["ipSicovAlternativo"]);
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
