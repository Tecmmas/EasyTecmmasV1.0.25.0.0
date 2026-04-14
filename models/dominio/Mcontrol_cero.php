<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mcontrol_cero extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function insertar($data) {
        $this->db->insert('control_cero', $data);
    }

    function get($idmaquina) {
        $query = $this->db->query("
            SELECT 
                IF(TIMESTAMPDIFF(HOUR,c.fecha, NOW())>23,'N','S') tiempo,c.*
                FROM 
                control_cero c
                WHERE 
                c.idmaquina=$idmaquina
                ORDER BY c.idcontrol_cero DESC LIMIT 1");
        return $query;
    }

}
