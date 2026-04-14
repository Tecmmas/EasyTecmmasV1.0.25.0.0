<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mcontrol_fugas extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function insertar($data) {
        $this->db->insert('control_fugas', $data);
    }

    function get($idmaquina) {
        $query = $this->db->query("
            SELECT 
                IF(TIMESTAMPDIFF(HOUR,f.fecha, NOW())>23,'N','S') tiempo,f.*
                FROM 
                control_fugas f 
                WHERE 
                f.idmaquina=$idmaquina
                ORDER BY f.idcontrol_fugas DESC LIMIT 1");
        return $query;
    }

}
