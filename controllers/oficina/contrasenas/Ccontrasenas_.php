<?php

defined("BASEPATH") OR exit("No direct script access allowed");
header("Access-Control-Allow-Origin: *");
ini_set("memory_limit", "-1");
set_time_limit(300);

class Ccontrasenas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper("form");
        $this->load->helper("url");
        $this->load->helper("security");
        $this->load->helper('download');
        $this->load->model('oficina/contrasenas/Mcontrasenas');
    }

    public function index() {
        if ($this->session->userdata("IdUsuario") == "" || $this->session->userdata("IdUsuario") == "1024") {
            redirect("Cindex");
        }
//        $iduser = 23;
        $iduser = $this->session->userdata("IdUsuario");
        $rta ['user'] = $this->getuser($iduser);
        $this->load->view('oficina/contrasenas/Vcontrasenas', $rta);
    }

    public function updatecontra() {
        $contrasenna = $this->input->post('contrasenna');
        $idperfil = $this->input->post('idperfil');
        $iduser = $this->input->post('iduser');
        $fecha = $this->input->post('fecha');
        if ($idperfil == 1 || $idperfil == 3) {
            $data = $this->Mcontrasenas->updatecontraadmin($iduser, $contrasenna, $fecha);
            $rta = $this->Mcontrasenas->insertcontraadmin($iduser, $contrasenna);
            if ($data == 1 && $rta == 1) {
                redirect("Cindex");
                $this->error('La contraseña fue actualizada correctamente');
            } else {
                $this->error('La contraseña no pudo ser actualizada comuníquese con el administrador del sistema por favor');
            }
        } else {
            $data = $this->Mcontrasenas->updatecontra($iduser, $contrasenna, $fecha);
            $rta = $this->Mcontrasenas->insertcontra($iduser, $contrasenna);
            if ($data == 1 && $rta == 1) {
                redirect("Cindex");
                $this->error('La contraseña fue actualizada correctamente');
            } else {
                $this->error('La contraseña no pudo ser actualizada comuníquese con el administrador del sistema por favor');
            }
        }
    }

    public function getuser($iduser) {
        $data = $this->Mcontrasenas->getuser($iduser);
        $rta = $data->result();
        return $rta [0];
    }

    public function getpassword() {
        $iduser = $this->input->post('iduser');
        $contrasenna = $this->input->post('contrasenna');
        $data = $this->Mcontrasenas->getpassword($iduser, $contrasenna);
        if ($data->num_rows() > 0) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }

    private function error($mensaje) {
        $this->session->set_flashdata('error', $mensaje);
        redirect("oficina/contrasenas/Ccontrasenas");
    }

}
