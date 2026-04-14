<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MPrincipal extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    
//    function puede_entrar($usuario, $contrasena) {
//        $this->db->where('username', $usuario);
//        $this->db->where('passwd', $contrasena);
//        $query = $this->db->get('usuarios');
//        return $query;
//    }

}
