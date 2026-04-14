<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mconfig_prueba extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where('idconfig_prueba', $data['idconfig_prueba']);
        $query = $this->db->get('config_prueba');
        return $query;
    }

    function update($data) {
        $this->db->set('valor', $data['valor']);
        $this->db->where('idconfig_prueba', $data['idconfig_prueba']);
        $this->db->update('config_prueba', $data);
    }

    function insert($data) {
        $result = $this->get($data);
        if ($result->num_rows() == 0)
            $this->db->insert('config_prueba', $data);
        else
            $this->update($data);
    }

}
