<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

class Csesion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
//        $this->load->model("Musuario");
        $this->load->model("Msesion");
        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
    }

    public function index() {
        if ($this->session->userdata('IdUsuario') == '') {
            redirect('Cindex');
        }
    }

    public function setSesion() {
        $sesion = $this->input->post("control_sesion");
        $this->Msesion->setSesion($sesion);
    }

    public function updateSesionDevice() {
        $data['tipo'] = $this->input->post("tipo");
//        $data['user'] = $this->input->post("user");
        $data['estado'] = $this->input->post("estado");
        $data['device'] = $this->input->post("device");
        $this->Msesion->updateSesionDevice($data);
    }

    public function getSesion() {
        $sesion = $this->input->post("control_sesion");
        $rta = $this->Msesion->getSesion($sesion);
        if ($rta->num_rows() > 0) {
            echo json_encode($rta->result());
        } else {
            echo 'FALSE';
        }
    }

    public function getSesionUser() {
        $user = $this->input->post("user");
        $tipo = 1;
        $ip = 0;
        $rta = $this->Msesion->getSesionUser($user, $tipo, $ip);
        if ($rta->num_rows() > 0) {
            echo json_encode($rta->result());
        } else {
            echo 'FALSE';
        }
    }
    public function getSesionMaquina() {
        $tipo = 2;
        $ip = $this->input->post("ip");
        $rta = $this->Msesion->getSesionMaquina($tipo, $ip);
        if ($rta->num_rows() > 0) {
            echo json_encode($rta->result());
        } else {
            echo 'FALSE';
        }
    }

}
