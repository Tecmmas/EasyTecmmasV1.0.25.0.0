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
        $this->load->model("dominio/Mcontrol_linealidad");
        $this->load->model("dominio/Mcontrol_respuesta");
        $this->load->model("dominio/Mcontrol_cero");
        espejoDatabase();
//        $this->load->library('Opensslencryptdecrypt');
    }

    public function linealidad() {
        $linealidad = $this->input->post('linealidad');
        $this->Mcontrol_linealidad->insertar($linealidad);
    }

    public function respuesta() {
        $respuesta = $this->input->post('respuesta');
        $this->Mcontrol_respuesta->insertar($respuesta);
    }

    public function controlcero() {
        $cero = $this->input->post('cero');
        $this->Mcontrol_cero->insertar($cero);
    }

    public function getLastLinealidad() {
        $idmaquina = $this->input->post('idmaquina');
        $rta = $this->Mcontrol_linealidad->get($idmaquina);
        $linealidad = $rta->result();
        echo json_encode($linealidad);
    }

    public function getLastCero() {
        $idmaquina = $this->input->post('idmaquina');
        $rta = $this->Mcontrol_cero->get($idmaquina);
        $cero = $rta->result();
        echo json_encode($cero);
    }

}
