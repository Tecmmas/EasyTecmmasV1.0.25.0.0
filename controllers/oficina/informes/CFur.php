<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
ini_set('memory_limit', '-1');
set_time_limit(300);

class CFur extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("oficina/informes/MFur");
        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
    }

    public function index() {
        if ($this->session->userdata('IdUsuario') == '' || $this->session->userdata('IdUsuario') == '1024') {
            redirect('Cindex');
        }

        $this->load->view('oficina/informes/VFur');
    }

    var $envioCorreo = "0";

    private function setConf() {
        $conf = @file_get_contents("system/oficina.json");
        if (isset($conf)) {
            $encrptopenssl = New Opensslencryptdecrypt();
            $json = $encrptopenssl->decrypt($conf, true);
            $dat = json_decode($json, true);
            if ($dat) {
                foreach ($dat as $d) {
                    if ($d['nombre'] == "envioCorreo") {
                        $this->envioCorreo = $d['valor'];
                    }
                    if ($d['nombre'] == "firmaDigital") {
                        $this->session->set_userdata('firmaDigital', $d['valor']);
                    }
                }
            }
        }
    }

    public function consultar() {
        $encrptopenssl = New Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/oficina.json', true), true);
        $ofc = json_decode($json, true);
        $fechaInicial = '';
        $this->setConf();
        foreach ($ofc as $d) {
            if ($d['nombre'] == 'fechaInicioFur') {
                $fechaInicial = "AND DATE_FORMAT(h.fechainicial,'%Y-%m-%d')>=DATE_FORMAT('" . $d['valor'] . "','%Y-%m-%d')";
                break;
            }
        }
        $data['formatos'] = $this->MFur->consultar($this->input->post('placa'), $fechaInicial);
        $data['placa'] = $this->input->post('placa');
        $data['envioCorreo'] = $this->envioCorreo;
        $this->load->view('oficina/informes/VFur', $data);
    }

}
