<?php
    $MAC = exec('arp -an');
//        $MAC = strtok($MAC, ' ');
        echo utf8_encode(strtolower($MAC));
//defined('BASEPATH') OR exit('No direct script access allowed');
//header("Access-Control-Allow-Origin: *");
//
//class Ccorasa extends CI_Controller {
//
//    public function __construct() {
//        parent::__construct();
//        $this->load->helper('form');
//        $this->load->helper('url');
//        $this->load->helper('security');
////        $this->load->model("Mutilitarios");
////        $this->load->model("Mcliente");
////        $this->load->model("Mprerevision");
////        $this->load->library('Opensslencryptdecrypt');
//    }
//
//    public function index() {
//        if ($this->input->post('trama')) {
//            $KEY = array(1, 0, 99, 53, 24, 99, 31, 85, 66, 46, 58, 65, 71, 93, 20);
//            $trama = explode(",", $this->input->post('trama'));
//            $posicion = $trama[sizeof($trama) - 1] - 170;
//            $inicio = $posicion + 1;
//            $descry = "";
//            foreach ($trama as $val) {
//                $v = ($val - 170) / ($KEY[$inicio] + 1);
//                $descry = $descry . "&#" . $v . ",";
//                $inicio++;
//                if ($inicio == 15) {
//                    $inicio = 0;
//                }
//            }
//            echo $descry;
//        } else {
//            echo "Esperando respuesta..";
//        }
//    }
//
//}
