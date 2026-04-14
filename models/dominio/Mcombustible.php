<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mcombustible extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where('idtipocombustible', $data['idtipocombustible']);
        $query = $this->db->get('tipo_combustible');
        return $query;
    }

}
