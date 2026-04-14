<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mimagenes extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("idprueba", $data['idprueba']);
        $query = $this->db->get('imagenes');
        return $query;
    }

    function get2($data, $db) {
        $this->db->where("idprueba", $data['idprueba']);
        $query = $this->db->get($db.".imagenes");
        //$query = $this->db->get("imagenes_bd.imagenes");
        return $query;
    }

    function deleteImagenes() {
        if ($this->getTrigger()) {
            $query = <<<EOF
              DELETE
                FROM 
                imagenes 
                WHERE 
                idprueba IN 
                (SELECT 
                p.idprueba FROM 
                pruebas p WHERE 
                DATE_FORMAT(p.fechainicial,'%Y-%m-%d')<>DATE_FORMAT(NOW(),'%Y-%m-%d'))
EOF;
            return $this->db->query($query);
        }
    }

    function getTrigger() {
        $query = <<<EOF
        SHOW TRIGGERS LIKE 'imagenes%'
EOF;
        $rta = $this->db->query($query);
        if ($rta->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
