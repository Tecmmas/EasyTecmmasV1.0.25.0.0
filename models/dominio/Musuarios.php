<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Musuarios extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("IdUsuario", $data['IdUsuario']);
        $query = $this->db->get('usuarios');
        return $query;
    }
    
    function getAll($data) {
        $query = $this->db->get('usuarios');
        return $query;
    }

    function getXperfil($idperfil) {
        $this->db->where('idperfil', $idperfil);
        $this->db->where('estado', '1');
        $query = $this->db->get('usuarios');
        return $query;
    }

    function getXnombreID($nombre) {
        $identificacion = "";
        $query = $this->db->query("SELECT identificacion FROM usuarios WHERE CONCAT(nombres,' ',apellidos)='$nombre' AND idperfil=3 LIMIT 1");
        if ($query->num_rows() > 0) {
            $rta = $query->result();
            $identificacion = $rta[0]->identificacion;
        }
        return $identificacion;
    }

}
