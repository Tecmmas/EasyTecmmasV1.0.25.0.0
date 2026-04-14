<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manalizador extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getGases($idprueba) {
        $rta = $this->db->query("SELECT 
                                'ana' tipo_consulta,p.* 
                                FROM 
                                pruebas p 
                                WHERE 
                                p.idprueba=$idprueba LIMIT 1;");
        $r =  $rta->result();
        $r[0]->enc="";
        return $r[0];
    }

    function getHojaPruebas($idprueba) {
        $rta = $this->db->query("SELECT 
                'setHojaPruebas' funcionSet,h.* 
                FROM 
                pruebas p,hojatrabajo h 
                WHERE 
                h.idhojapruebas=p.idhojapruebas AND 
                p.idprueba=$idprueba");
        $r = $rta->result();
        return $r[0];
    }


    function get1024() {
        $rta = $this->db->query("SELECT 
                c.valor
                FROM 
                config_prueba c
                WHERE 
                c.idconfig_prueba=1024 limit 1");
        $r = $rta->result();
        return $r[0];
    }

    function get1025() {
        $rta = $this->db->query("SELECT 
                c.valor
                FROM 
                config_prueba c
                WHERE 
                c.idconfig_prueba=1025 limit 1");
        $r = $rta->result();
        return $r[0];
    }

    function getDatosGenerales($idmaquina) {
        $rta = $this->db->query("SELECT 
        (SELECT numero_id FROM cda limit 1) num_cda,
        (SELECT nombre_cda FROM cda limit 1) nombre_cda,
        (SELECT COUNT(*) FROM certificados limit 1) num_certificados,
        (SELECT c.fecha FROM control_fugas c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_fugas DESC LIMIT 1) fecha_fugas,
        (SELECT DATE_ADD(c.fecha, INTERVAL 1 DAY) FROM control_fugas c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_fugas DESC LIMIT 1) fecha_fugas_proxima,
        (SELECT c.idcontrol_calibracion FROM control_calibracion c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_calibracion DESC LIMIT 1) idcontrol_calibracion,
            
        (SELECT c.span_alto_co FROM control_calibracion c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_calibracion DESC LIMIT 1) span_alto_co,    
        (SELECT c.span_alto_co2 FROM control_calibracion c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_calibracion DESC LIMIT 1) span_alto_co2,    
        (SELECT c.span_alto_hc FROM control_calibracion c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_calibracion DESC LIMIT 1) span_alto_hc,    
        (SELECT c.span_bajo_co FROM control_calibracion c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_calibracion DESC LIMIT 1) span_bajo_co,    
        (SELECT c.span_bajo_co2 FROM control_calibracion c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_calibracion DESC LIMIT 1) span_bajo_co2,    
        (SELECT c.span_bajo_hc FROM control_calibracion c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_calibracion DESC LIMIT 1) span_bajo_hc,    
        (SELECT c.cal_alto_co FROM control_calibracion c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_calibracion DESC LIMIT 1) cal_alto_co,    
        (SELECT c.cal_alto_co2 FROM control_calibracion c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_calibracion DESC LIMIT 1) cal_alto_co2,    
        (SELECT c.cal_alto_o2 FROM control_calibracion c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_calibracion DESC LIMIT 1) cal_alto_o2,    
        (SELECT c.cal_alto_hc FROM control_calibracion c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_calibracion DESC LIMIT 1) cal_alto_hc,    
        (SELECT c.cal_bajo_co FROM control_calibracion c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_calibracion DESC LIMIT 1) cal_bajo_co,    
        (SELECT c.cal_bajo_co2 FROM control_calibracion c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_calibracion DESC LIMIT 1) cal_bajo_co2,    
        (SELECT c.cal_bajo_o2 FROM control_calibracion c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_calibracion DESC LIMIT 1) cal_bajo_o2,    
        (SELECT c.cal_bajo_hc FROM control_calibracion c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_calibracion DESC LIMIT 1) cal_bajo_hc,    
            
        (SELECT c.fecha FROM control_calibracion c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_calibracion DESC LIMIT 1) fecha_calibracion,
        (SELECT DATE_ADD(c.fecha, INTERVAL 3 DAY) FROM control_calibracion c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_calibracion DESC LIMIT 1) fecha_calibracion_proxima");
        $r = $rta->result();
        return $r[0];
    }

    function update1024() {
        echo $this->db->query("UPDATE 
                config_prueba c 
                SET 
                c.valor='' 
                WHERE 
                c.idconfig_prueba=1024");
//        $r = $rta->result();
//        return $r[0];
    }

}
