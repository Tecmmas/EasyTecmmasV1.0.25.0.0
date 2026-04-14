<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

class Cdb extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model("/oficina/reportes/db/Mdb");
        espejoDatabase();
        
    }

    public function index() {
        $this->load->view('oficina/reportes/db/Vdb');
    }
    
    public function ejcutarOp(){
        $rta = $this->Mdb->mDatabase();
        echo json_encode($rta);
    }
}
