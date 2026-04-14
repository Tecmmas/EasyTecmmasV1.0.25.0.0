<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mcliente extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getCliente($cliente, $contrasena) {
        $this->db->where('username', $cliente);
        $this->db->where('passwd', $contrasena);
        $query = $this->db->get('clientes');
        return $query;
    }

    function getClienteId($id) {
        $this->db->where('IdCliente', $id);
        $query = $this->db->get('clientes');
        return $query;
    }

    function getClienteIdentificacion($numero_identificacion) {
        $this->db->where('numero_identificacion', $numero_identificacion);
        $query = $this->db->get('clientes');
        return $query;
    }

    function guardarCliente($cliente) {
        $cli = $this->getClienteIdentificacion($cliente['numero_identificacion']);
        if ($cli->num_rows() !== 0) {
            $this->db->where('numero_identificacion', $cliente['numero_identificacion']);
            $this->db->update("clientes", $cliente);
            $rta = $cli->result();
            return $rta[0]->idcliente;
        } else {
            $this->db->insert("clientes", $cliente);
            return $this->db->insert_id();
        }
    }

}
