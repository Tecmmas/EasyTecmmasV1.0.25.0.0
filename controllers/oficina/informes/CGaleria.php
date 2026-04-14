<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
ini_set('memory_limit', '-1');
set_time_limit(300);

class CGaleria extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("oficina/informes/MPrerevision");
        $this->load->model("dominio/Mcda");
        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
    }

    public function index() {
        if ($this->session->userdata('IdUsuario') == '' || $this->session->userdata('IdUsuario') == '1024') {
            redirect('Cindex');
        }
//        $data['prerevision'] = '';
//        $data['placa'] = '';
//        $data['rango'] = '';
        $idpre_prerevision = $this->input->post('idpre_prerevision');
        echo $idpre_prerevision;
//        $this->load->view('oficina/informes/VGaleria');
    }

}
