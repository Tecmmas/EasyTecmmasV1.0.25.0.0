<?php

defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
ini_set('memory_limit', '-1');

class CRauditoriaCap extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("dominio/MauditoriaCap");
        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
    }

    public function get()
    {
        $rta = $this->MauditoriaCap->get();
        $dat = $rta->result();
        echo json_encode($dat);
    }

}
