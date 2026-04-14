<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

class CanalizadorSim extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->library('Encry');
        espejoDatabase();
    }

    public function index() {
        $this->load->view('pruebas/utils/VanalizadorSim');
    }

    function setData() {
        $enc = new Encry();
        $trama = $this->input->post('trama');
        $fileName = $enc->encrypt("12700110w");
        $this->Warchivo($_SERVER['DOCUMENT_ROOT'] . "et/data/" . $fileName . ".dat", "w+", $trama);
    }

    private function Warchivo($archivo, $tipo, $conten) {
        $enc = new Encry();
        $content = $enc->encrypt($conten);
        try {
            $file = fopen($archivo, $tipo);
            fwrite($file, $content);
            fclose($file);
            usleep(500);
        } catch (Exception $exc) {
            $this->Warchivo($archivo, $tipo, $content);
        }
    }

}
