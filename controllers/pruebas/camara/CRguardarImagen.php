<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
ini_set('memory_limit', '-1');

class CRguardarImagen extends CI_Controller  {

    var $path;

    public function __construct() {
        parent::__construct();
        $this->load->helper(['jwt', 'authorization']);
        $this->path = $_SERVER['DOCUMENT_ROOT'] . "et/data/";
        $this->load->library('Encry');
        $this->load->model("Mutilitarios");
        $this->load->model("pruebas/camara/Mcamara");
        espejoDatabase();
    }

    public function guardarImagenPOST() {
        $idprueba = $this->input->post("idprueba");
        $imagen = $this->input->post("imagen");
        $idusuario = $this->input->post("idusuario");
        $idmaquina = $this->input->post("idmaquina");
        $this->Mcamara->guardarImagen($idprueba, $imagen, $idusuario, $idmaquina);
    }

}
