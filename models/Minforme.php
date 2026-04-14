<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Minforme extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getInforme($nombre) {
        $this->db->where('nombre', $nombre);
        $query = $this->db->get('informe');
        $rta = $query->result();
        return $rta[0];
    }

    function getDatoInforme($idinforme) {
        $result = $this->db->query("select
                                    *
                                    from
                                    datoinforme
                                    where
                                    idinforme=$idinforme order by orden");
        return $result;
    }
//    
//    function getAtributoZona($idzonainforme){
//        $result = $this->db->query("select
//                                    d.html
//                                    from 
//                                    datoinforme d
//                                    where
//                                    d.idzonainforme=$idzonainforme
//                                    order by orden");
//        return $result;
//    }

}
