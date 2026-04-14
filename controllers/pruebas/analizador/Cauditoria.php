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
        $this->load->model("dominio/Mcontrol_fugas");
        $this->load->model("dominio/Mcontrol_calibracion");
        $this->load->model("dominio/Mcontrol_verificacion");
        $this->load->model("dominio/Mcontrol_prueba_gases");
        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
    }

    public function fugas() {
        $fugas = $this->input->post('fugas');
        $this->Mcontrol_fugas->insertar($fugas);
    }

    public function calibracion() {
        $calibracion = $this->input->post('calibracion');
        $this->Mcontrol_calibracion->insertar($calibracion);
    }

    public function verificacion() {
        $verificacion = $this->input->post('verificacion');
        $this->Mcontrol_verificacion->insertar($verificacion);
    }

    public function prueba_gases() {
        $prueba_gases = $this->input->post('prueba_gases');
        $this->Mcontrol_prueba_gases->insertar($prueba_gases);
    }

    public function getLastCalibracion() {
        $idmaquina = $this->input->post('idmaquina');
        $rta = $this->Mcontrol_calibracion->get($idmaquina);
        $calibracion = $rta->result();
        echo json_encode($calibracion);
    }

    public function getLastFugas() {
        $idmaquina = $this->input->post('idmaquina');
        $rta = $this->Mcontrol_fugas->get($idmaquina);
        $fugas = $rta->result();
        echo json_encode($fugas);
    }

    public function obtenerVerificacion() {
        $idmaquina = $this->input->post('idmaquina');
        $rta = $this->Mcontrol_verificacion->get($idmaquina);
        echo json_encode($rta);
    }

    public function insertarDivisores() {
        $tipo = $this->input->post("tipo");
        $divisores = $this->input->post("divisores");
        $idmaquina = $this->input->post("idmaquina");
        $archivo = fopen("system/" . $tipo . "_" . $idmaquina . ".dat", "w+b");
        $encrptopenssl = New Opensslencryptdecrypt();
        $divisores = $encrptopenssl->encrypt($divisores);
        fwrite($archivo, $divisores);
        fclose($archivo);
    }

    public function obtenerDivisores() {
        $tipo = $this->input->post("tipo");
        $idmaquina = $this->input->post("idmaquina");
        $file = "system/" . $tipo . "_" . $idmaquina . ".dat";
        if (file_exists($file)) {
            $encrptopenssl = New Opensslencryptdecrypt();
            echo $encrptopenssl->decrypt(file_get_contents($file, true));
        } else {
            echo "na";
        }
    }

}
