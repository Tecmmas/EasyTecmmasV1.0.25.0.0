<?php

defined("BASEPATH") OR exit("No direct script access allowed");
header("Access-Control-Allow-Origin: *");
ini_set("memory_limit", "-1");

class Cadicionales extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->helper("security");
//        $this->load->model("oficina/reportes/adicionales/Madicionales");
        $this->load->library('Opensslencryptdecrypt');
        $this->load->dbutil();
        espejoDatabase();
    }

    var $dominio;

    public function index() {
        $this->dominio = file_get_contents('system/dominio.dat', true);
        $encrptopenssl = New Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $data ['maquina'] = json_decode($json);
        $this->load->view('oficina/reportes/adicionales/Vadicionales', $data);
    }

    public function getMetrologia() {
        $tipo = $this->input->post('tipo');
        $certificado = $this->input->post('certificado');
        $empresa = $this->input->post('empresa');
        $fechavencimiento = $this->input->post('fechavencimiento');
        $fechavencimiento = str_replace(" ", "", $fechavencimiento);
        $maquina = $this->input->post('maquina');
        $maquina = str_replace(" ", "", $maquina);
        $dominio = file_get_contents('system/dominio.dat', true);
        $url = 'http://' . $dominio . '/cda/index.php/Cadicionales' . '?tipo=' . $tipo . '&certificado=' . $certificado . '&empresa=' . $empresa . '&maquina=' . $maquina . '&fechavencimiento=' . $fechavencimiento;
        $res = file_get_contents($url);
        echo json_encode($res);
    }

    public function updateMetrologia() {
        $idmetrologia = $this->input->post('idmetrologia');
        $tipo = $this->input->post('tipo');
        $certificado = $this->input->post('certificado');
        $empresa = $this->input->post('empresa');
        $fechavencimiento = $this->input->post('fechavencimiento');
        $fechavencimiento = str_replace(" ", "", $fechavencimiento);
        $maquina = $this->input->post('maquina');
        $maquina = str_replace(" ", "", $maquina);
        $dominio = file_get_contents('system/dominio.dat', true);
        $url = 'http://' . $dominio . '/cda/index.php/Cadicionales/updateMetrologia' . '?tipo=' . $tipo . '&certificado=' . $certificado . '&empresa=' . $empresa . '&maquina=' . $maquina . '&fechavencimiento=' . $fechavencimiento. '&idmetrologia=' . $idmetrologia;
        $res = file_get_contents($url);
        echo json_encode($res);
    }
    
    public function deleteMetrologia(){
        $idmetrologia = $this->input->post('idmetrologia');
        $dominio = file_get_contents('system/dominio.dat', true);
        $url = 'http://' . $dominio . '/cda/index.php/Cadicionales/deleteMetrologia' . '?idmetrologia=' . $idmetrologia;
        $res = file_get_contents($url);
    }

    private function setConf() {
        $conf = @file_get_contents("system/oficina.json");
        if (isset($conf)) {
            $encrptopenssl = New Opensslencryptdecrypt();
            $json = $encrptopenssl->decrypt($conf, true);
            $dat = json_decode($json, true);
            if ($dat) {
                foreach ($dat as $d) {
                    if ($d['nombre'] == "tipoInforme") {
                        $this->tipoInforme = $d['valor'];
                    }
                    if ($d['nombre'] == "clavePrivada") {
                        $this->clavePrivada = $d['valor'];
                    }
                    if ($d['nombre'] == "clavePublica") {
                        $this->clavePublica = $d['valor'];
                    }
                    if ($d['nombre'] == "tipo_informe_fugas_cal_lin") {
                        $this->tipo_informe_fugas_cal_lin = $d['valor'];
                    }
                }
            }
        }
    }

}
