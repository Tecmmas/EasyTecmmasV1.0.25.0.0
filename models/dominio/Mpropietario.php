<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mpropietario extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("idcliente", $data['idcliente']);
        $query = $this->db->get('clientes');
        return $query;
    }

    function getAll() {
        $query = $this->db->get('clientes');
        return $query;
    }

    function getMatch($match) {
        $result = $this->db->query("SELECT 
            * 
            FROM 
            clientes c
            WHERE
            c.numero_identificacion LIKE '%$match%' OR
            c.nombre1 LIKE '%$match%' OR
            c.nombre2 LIKE '%$match%' OR
            c.apellido1 LIKE '%$match%' OR
            c.apellido2 LIKE '%$match%' OR
            c.telefono1 LIKE '%$match%'");
        return $result;
    }

    function insert($cliente) {
        $this->db->insert('clientes', $cliente);
        return $this->db->insert_id();
    }

    function update($cliente) {
        $this->db->where('idcliente', $cliente['idcliente']);
        echo $this->db->update('clientes', $cliente);
    }
    
}
