<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mclase extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("idclase", $data['idclase']);
        $query = $this->db->get('clase');
        return $query;
    }

    function getAll() {
        $query = $this->db->get('clase');
        return $query;
    }

}
