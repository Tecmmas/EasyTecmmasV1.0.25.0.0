<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

class Cinforme extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("Minforme");
        espejoDatabase();
    }

    public function index() {
        if ($this->session->userdata('IdUsuario') == '') {
            redirect('Cindex');
        }
        $informe = $this->Minforme->getInforme($this->input->post('informe'));
        $zona = $this->Minforme->getDatoInforme($informe->idinforme);
        $data["zona"] = $zona->result();
        echo json_encode($data);
    }

}
