<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

class CgetSerial extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
    }

    public function index() {
        $MAC = exec('getmac');
        $MAC = strtok($MAC, ' ');
        echo strtolower($MAC);
    }

}
