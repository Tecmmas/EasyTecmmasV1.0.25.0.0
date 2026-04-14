<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MconsecutivoTC extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("idhojapruebas", $data['idhojapruebas']);
        $query = $this->db->get('consecutivotc');
        return $query;
    }

    function insert($data) {
        $this->db->insert('consecutivotc', $data);
    }

}
