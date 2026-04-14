<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mcolor extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("idcolorRUNT", $data['idcolorRUNT']);
        $query = $this->db->get('colorrunt');
        return $query;
    }

    function get2($data) {
        $this->db->where("idcolor", $data['idcolor']);
        $query = $this->db->get('color');
        return $query;
    }

}
