<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mjefe2 extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("idhojapruebas", $data['idhojapruebas']);
        $query = $this->db->get('jefe2');
        return $query;
    }

    function insert($data) {
        return $this->db->insert('jefe2', $data);
    }

}
