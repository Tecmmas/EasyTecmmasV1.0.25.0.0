<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
ini_set('memory_limit', '-1');

class Cauditoria extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("dominio/Mcontrol_suspension");
        $this->load->model("dominio/Mcontrol_frenos");
        $this->load->model("dominio/Mcontrol_alineacion");
        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
    }

    public function suspension() {
        $suspension = $this->input->post('control_suspension');
        $this->Mcontrol_suspension->insertar($suspension);
    }

    public function frenos() {
        $frenos = $this->input->post('control_frenos');
        $this->Mcontrol_frenos->insertar($frenos);
    }

    public function alineacion() {
        $alineacion = $this->input->post('control_alineacion');
        $this->Mcontrol_alineacion->insertar($alineacion);
    }

}
