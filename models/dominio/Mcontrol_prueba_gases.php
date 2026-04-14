<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mcontrol_prueba_gases extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function insertar($data) {
        $this->db->insert('control_prueba_gases', $data);
    }

}
