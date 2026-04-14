<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mcontrol_linealidad extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function insertar($data) {
        $this->db->insert('control_linealidad', $data);
    }

    function get($idmaquina) {
        $query = $this->db->query("
            SELECT 
                IF(TIMESTAMPDIFF(HOUR,l.fecha, NOW())>23,'N','S') tiempo,l.*
                FROM 
                control_linealidad l 
                WHERE 
                l.idmaquina=$idmaquina
                ORDER BY l.id DESC LIMIT 1");
        return $query;
    }

}
