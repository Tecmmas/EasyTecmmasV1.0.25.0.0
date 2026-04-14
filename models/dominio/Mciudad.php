<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mciudad extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("cod_ciudad", $data['cod_ciudad']);
        $query = $this->db->get('ciudades');
        return $query;
    }
    
    function getXDepto($data) {
        $this->db->where("cod_depto", $data['cod_depto']);
        $query = $this->db->get('ciudades');
        return $query;
    }

}
