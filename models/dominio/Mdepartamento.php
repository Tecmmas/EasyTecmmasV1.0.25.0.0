<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mdepartamento extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("cod_depto", $data['cod_depto']);
        $query = $this->db->get('deptos');
        return $query;
    }
    function getAll() {
        $query = $this->db->get('deptos');
        return $query;
    }

}
