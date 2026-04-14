<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mtaximetro extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getTaximetro_ht_fecha($idprueba) {
        $rta = $this->db->query("SELECT 
                                'tax' tipo_consulta,p.* 
                                FROM 
                                pruebas p 
                                WHERE 
                                (SELECT 
                                idhojapruebas 
                                FROM 
                                pruebas 
                                WHERE 
                                idprueba=$idprueba LIMIT 1)=p.idhojapruebas  AND
                                p.idtipo_prueba=6  and
                                p.estado=0
                                LIMIT 1");
        if ($rta->num_rows() > 0) {
            $r = $rta->result();
            $r[0]->enc="";
            return $r[0];
        } else {
            return (object) array('tipo_consulta' => 'tax');
        }
    }

    function getTaximetro($idprueba) {
        $rta = $this->db->query("SELECT 
                                'tax' tipo_consulta,p.* 
                                FROM 
                                pruebas p 
                                WHERE 
                                p.idprueba=$idprueba LIMIT 1;");
        $r = $rta->result();
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

}
