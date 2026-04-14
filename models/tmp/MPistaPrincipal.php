<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MPistaPrincipal extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function ListarPruebas() {
        $result = $this->db->query("select 
                    p.idprueba,p.fechainicial fecha,v.numero_placa placa
                    from
                    pruebas p, hojatrabajo h, vehiculos v 
                    where 
                    p.idtipo_prueba=10 and
                    p.estado=0 and
                    h.idhojapruebas=p.idhojapruebas and
                    h.idvehiculo=v.idvehiculo and
                    (h.reinspeccion=0 or h.reinspeccion=1)");
        return $result;
    }

}
