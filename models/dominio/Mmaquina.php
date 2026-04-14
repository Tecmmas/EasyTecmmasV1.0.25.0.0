<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mmaquina extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("idmaquina", $data['idmaquina']);
        $query = $this->db->get('maquina');
        return $query;
    }

}
