<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mservicio extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("idservicio", $data['idservicio']);
        $query = $this->db->get('servicio');
        return $query;
    }

}
