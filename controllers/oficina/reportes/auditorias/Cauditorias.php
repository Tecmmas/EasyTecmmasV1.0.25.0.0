<?php

defined("BASEPATH") or exit("No direct script access allowed");
header("Access-Control-Allow-Origin: *");
ini_set("memory_limit", "-1");
set_time_limit(300);

class Cauditorias extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper("form");
        $this->load->helper("url");
        $this->load->helper("security");
        $this->load->helper('download');
        $this->load->model("oficina/reportes/auditorias/Mauditorias");
        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
//        $this->load->dbforge();
//        $this->load->dbutil();
    }

    public function index() {
//        if ($this->session->userdata("IdUsuario") == "" || $this->session->userdata("IdUsuario") == "1024") {
//            redirect("Cindex");
//        }
        date_default_timezone_set('America/bogota');
        $encrptopenssl = New Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $data ['maquina'] = json_decode($json);
//        var_dump($data);
        $this->load->view('oficina/reportes/auditorias/Vauditorias', $data);
    }

    function getDatos() {
        $placa = $this->input->post('placa');
        $idmaquina = $this->input->post('idmaquina');
        $fechai = $this->input->post('fechai');
        $tipoprueba = $this->input->post('tipoprueba');
        $wp = "";
        $wid = "";
        $wfi = "";
        if ($tipoprueba == 6) {
            if ($placa !== null && $placa !== "") {
                $wp = " AND v.numero_placa = '" . $placa . "'";
            }
            if ($idmaquina !== null && $idmaquina !== "") {
                $wid = " AND p.idmaquina = " . $idmaquina;
            }
            if ($fechai !== null && $fechai !== "") {
                $wfi = " AND p.fechainicial = " . $fechai;
            }
        } else {
            if ($placa !== null && $placa !== "") {
                $wp = " AND c.placa = '" . $placa . "'";
            }
            if ($idmaquina !== null && $idmaquina !== "") {
                $wid = " AND c.idmaquina = " . $idmaquina;
            }
            if ($fechai !== null && $fechai !== "") {
                $wfi = " AND c.fecha = " . $fechai;
            }
        }

        $where = $wp . $wid . $wfi;
        switch ($tipoprueba) {
            case 6:
                $rta = $this->Mauditorias->getDatosTaximetro($where);
                echo json_encode($rta);
                break;
            case 7:
                $rta = $this->Mauditorias->getDatosFrenos($where);
                echo json_encode($rta);
                break;
            case 9:
                $rta = $this->Mauditorias->getDatosSuspension($where);
                echo json_encode($rta);
                break;
            case 10:
                $rta = $this->Mauditorias->getDatosAlineacion($where);
                echo json_encode($rta);
                break;

            default:
                break;
        }
    }

    function getVector() {
        $id = $this->input->post('id');
        $tipoprueba = $this->input->post('tipoprueba');
        switch ($tipoprueba) {
            case 7:
                $rta = $this->Mauditorias->getVectorFrenos($id);
                echo json_encode($rta);
                break;
            case 9:
                $rta = $this->Mauditorias->getVectorSuspension($id);
                echo json_encode($rta);
                break;
            case 10:
                $rta = $this->Mauditorias->getVectorAlineacion($id);
                echo json_encode($rta);
                break;

            default:
                break;
        }
    }

}
