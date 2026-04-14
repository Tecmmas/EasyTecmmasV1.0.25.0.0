<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mfrenometro extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getFrenometro_ht_fecha($idprueba) {
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

    function getFrenometro($idprueba) {
        $rta = $this->db->query("SELECT 
                                'frn' tipo_consulta,p.* 
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

    function getIdPruebaTP($idHojaPruebas, $idTP) {
        $rta = $this->db->query("SELECT 
                p.* 
                FROM 
                pruebas p,hojatrabajo h 
                WHERE 
                h.idhojapruebas=p.idhojapruebas AND 
                h.idhojapruebas=$idHojaPruebas AND
                p.idtipo_prueba=$idTP AND p.estado=0");
        $r = $rta->result();
         $r[0]->enc="";
        return $r[0];
    }

    function getIdPruebaDefLab($idHojaPruebas) {
        $rta = $this->db->query("SELECT 
                p.* 
                FROM 
                pruebas p,hojatrabajo h 
                WHERE 
                h.idhojapruebas=p.idhojapruebas AND 
                h.idhojapruebas=$idHojaPruebas AND
                p.idtipo_prueba=8  order by 1 desc limit 1");
        //p.idtipo_prueba=8 AND p.estado=1 order by 1 desc limit 1
        $r = $rta->result();
         $r[0]->enc="";
        return $r[0];
    }

    function actualizarEjesLlantas($numero_placa, $numejes, $numero_llantas) {
        $this->db->set('numejes', $numejes);
        $this->db->set('numero_llantas', $numero_llantas);
        $this->db->where('numero_placa', $numero_placa);
        return $this->db->update('vehiculos');
    }

}
