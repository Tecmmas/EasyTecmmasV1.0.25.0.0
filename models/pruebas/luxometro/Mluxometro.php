<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mluxometro extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('Opensslencryptdecrypt');
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

    function getLuxometro($idprueba) {
        $rta = $this->db->query("
            SELECT 
                                'setLuxometro' funcionSet,p.* 
                                FROM 
                                pruebas p 
                                WHERE 
                                p.idprueba=$idprueba LIMIT 1");
        $r = $rta->result();
        $r[0]->enc = "";
        return $r[0];
    }

}
