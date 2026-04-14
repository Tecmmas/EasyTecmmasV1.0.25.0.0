<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mcarroceria extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("idcarroceria", $data['idcarroceria']);
        $query = $this->db->get('carroceria');
        return $query;
    }
    function getAll() {
        $query = $this->db->get('carroceria');
        return $query;
    }

}
