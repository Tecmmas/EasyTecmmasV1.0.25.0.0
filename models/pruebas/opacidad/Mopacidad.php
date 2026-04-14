<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mopacidad extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getGases($idprueba) {
        $rta = $this->db->query("SELECT 
                                'opa' tipo_consulta,p.* 
                                FROM 
                                pruebas p 
                                WHERE 
                                p.idprueba=$idprueba LIMIT 1;");
        $r = $rta->result();
        $r[0]->enc="";
        return $r[0];
    }

    function getDatosGenerales($idmaquina) {
        $rta = $this->db->query("SELECT 
        (SELECT numero_id FROM cda limit 1) num_cda,
        (SELECT nombre_cda FROM cda limit 1) nombre_cda,
        (SELECT COUNT(*) FROM certificados limit 1) num_certificados,
        (SELECT c.fecha FROM control_linealidad c WHERE c.idmaquina=$idmaquina ORDER BY c.id DESC LIMIT 1) fecha_linealidad,
        (SELECT DATE_ADD(c.fecha, INTERVAL 1 DAY) FROM control_linealidad c WHERE c.idmaquina=$idmaquina ORDER BY c.id DESC LIMIT 1) fecha_linealidad_proxima,
        (SELECT c.fecha FROM control_cero c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_cero DESC LIMIT 1) fecha_cero,
        (SELECT DATE_ADD(c.fecha, INTERVAL 1 DAY) FROM control_cero c WHERE c.idmaquina=$idmaquina ORDER BY c.idcontrol_cero DESC LIMIT 1) fecha_cero_proxima,
        (SELECT p.fechafinal FROM pruebas p WHERE (p.estado=1 or p.estado=2) and p.idtipo_prueba=2 and p.idmaquina=$idmaquina order by p.idprueba desc limit 1) fecha_ultima_prueba,
        IFNULL((SELECT if(TIMESTAMPDIFF(MINUTE,p.fechafinal,NOW())>60,'S','N')
                FROM pruebas p WHERE (p.estado=1 or p.estado=2) and p.idtipo_prueba=2 and p.idmaquina=$idmaquina AND p.estado<>9 AND p.estado<>5  AND p.estado<>0
                 order by p.idprueba desc LIMIT 1),'S') solicitar_cero1,
IFNULL((SELECT if(TIMESTAMPDIFF(MINUTE,c.fecha,NOW())>60,'S','N') FROM control_cero c WHERE c.idmaquina=$idmaquina AND c.aprobado='S' ORDER BY c.idcontrol_cero DESC LIMIT 1),'S') solicitar_cero2");
        $r = $rta->result();
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

}
