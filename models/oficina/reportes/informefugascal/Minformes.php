<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Minformes extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function infofugas($idmaquina) {
        $query = $this->db->query("SELECT * FROM control_fugas c WHERE c.idmaquina=$idmaquina ORDER BY 1");
        return $query->result();
    }

    public function infocalibracion($idmaquina) {
        $query = $this->db->query("SELECT * FROM control_calibracion c WHERE c.idmaquina=$idmaquina ORDER BY 1");
        return $query->result();
    }

    public function infocda() {
        $query = $this->db->get('cda');
        return $query;
    }

    public function infosede() {
        $query = $this->db->query('SELECT s.*, c.nombre AS ciudad, d.nombre AS departamento
                           FROM sede s, ciudades c, deptos d
                            WHERE s.cod_ciudad=c.cod_ciudad AND c.cod_depto=d.cod_depto', FALSE);
        return $query;
    }
    
    public function result_cal_data($idcontrol_fug_cal, $idmaquina){
        $query = $this->db->query("SELECT * FROM control_calibracion c
                                   WHERE c.idmaquina = $idmaquina AND c.idcontrol_calibracion=$idcontrol_fug_cal", false );
        return $query;
    }
    
    public function result_fug_data($idcontrol_fug_cal, $idmaquina){
        $query = $this->db->query("SELECT * FROM control_fugas c
                                   WHERE c.idmaquina = $idmaquina AND c.idcontrol_fugas=$idcontrol_fug_cal", false );
        return $query;
    }
    public function usuario_prueba($usuario){
        $query = $this->db->query("SELECT CONCAT(u.nombres,' ',u.apellidos) AS nombre_user FROM usuarios u WHERE u.IdUsuario=$usuario", false );
        return $query;
    }

}
