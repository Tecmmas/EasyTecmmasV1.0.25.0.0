<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mpais extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("idpais", $data['idpais']);
        $query = $this->db->get('paises');
        return $query;
    }

    function getAll() {
        $query = $this->db->get('paises');
        return $query;
    }

//    function 
}
