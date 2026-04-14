<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mcontrol_calibracion extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function insertar($data) {
        $this->db->insert('control_calibracion', $data);
    }

    function get($idmaquina) {
        $query = $this->db->query("
            SELECT 
                IF(TIMESTAMPDIFF(HOUR,c.fecha, NOW())>71,'N','S') tiempo,c.*
                FROM 
                control_calibracion c 
                WHERE 
                c.idmaquina=$idmaquina
                ORDER BY c.idcontrol_calibracion DESC LIMIT 1");
        return $query;
    }

}
