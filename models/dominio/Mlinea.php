<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mlinea extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("idlineaRUNT", $data['idlineaRUNT']);
        $query = $this->db->get('linearunt');
        return $query;
    }

    function get2($data) {
        $this->db->where("idlinea", $data['idlinea']);
        $query = $this->db->get('linea');
        return $query;
    }
    function getmigrateLineaMarca($data) {
        $this->db->where("idlineas", $data['idlinea']);
        $query = $this->db->get('newlineas');
        return $query;
    }
    
}
