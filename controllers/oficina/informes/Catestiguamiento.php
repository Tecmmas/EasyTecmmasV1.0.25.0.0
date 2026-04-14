<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
ini_set('memory_limit', '-1');
set_time_limit(300);

class Catestiguamiento extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("oficina/informes/MFur");
        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
    }

    var $nameBdImages = "imagenes_bd";

    public function index() {
        if ($this->session->userdata('IdUsuario') == '' || $this->session->userdata('IdUsuario') == '1024') {
            redirect('Cindex');
        }

        $this->load->view('oficina/informes/Vatestiguamiento');
    }

    public function consultar() {
        $encrptopenssl = New Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/oficina.json', true), true);
        $ofc = json_decode($json, true);
        $fechaInicial = '';
        foreach ($ofc as $d) {
            if ($d['nombre'] == 'fechaInicioFur') {
                $fechaInicial = "AND DATE_FORMAT(h.fechainicial,'%Y-%m-%d')>=DATE_FORMAT('" . $d['valor'] . "','%Y-%m-%d')";
                break;
            }
            if ($d['nombre'] == 'nameBdImages') {
                $this->nameBdImages = $d['valor'];
            }
        }
        $data['formatos'] = $this->MFur->consultar($this->input->post('placa'), $fechaInicial);
        $data['placa'] = $this->input->post('placa');
        $this->load->view('oficina/informes/Vatestiguamiento', $data);
    }

}
