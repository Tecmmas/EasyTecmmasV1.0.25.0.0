<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CPistaPrincipal extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("MPistaPrincipal");
        espejoDatabase();
    }

    public function index() {
        $data['pruebas'] = $this->MPistaPrincipal->ListarPruebas();
        $this->load->view('VPistaPrincipal',$data);
    }

}
