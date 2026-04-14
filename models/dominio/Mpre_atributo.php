<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mpre_atributo extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("idpre_atributo", $data['idpre_atributo']);
        $query = $this->db->get('pre_atributo');
        return $query;
    }

    function getXid($data) {
        $this->db->where("id", $data['id']);
        $query = $this->db->get('pre_atributo');
        return $query;
    }

    function insert($data) {
        echo $this->db->insert('pre_atributo', $data);
    }

}
