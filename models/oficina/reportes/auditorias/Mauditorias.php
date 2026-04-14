<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mauditorias extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->dbutil();
//        $this->db = $this->load->database('default', true);
//        $this->myforge = $this->load->dbforge($this->db, TRUE);
    }

    function getDatosFrenos($where) {
        $consulta = <<<EOF
               SELECT * FROM control_frenos c WHERE c.vector IS NOT NULL $where          
EOF;
        $rta = $this->db->query($consulta);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
            return $rta;
        } else {
            return [];
        }
    }

    function getVectorFrenos($id) {
        $consulta = <<<EOF
               SELECT c.vector, c.eje, c.llanta, c.valor FROM control_frenos c WHERE c.id = $id        
EOF;
        $rta = $this->db->query($consulta);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
            return $rta;
        } else {
            return [];
        }
    }

    function getDatosAlineacion($where) {
        $consulta = <<<EOF
               SELECT * FROM control_alineacion c WHERE c.vector IS NOT NULL $where          
EOF;
        $rta = $this->db->query($consulta);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
            return $rta;
        } else {
            return [];
        }
    }

    function getVectorAlineacion($id) {
        $consulta = <<<EOF
               SELECT c.vector, c.eje, c.valor FROM control_alineacion c WHERE c.id = $id        
EOF;
        $rta = $this->db->query($consulta);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
            return $rta;
        } else {
            return [];
        }
    }

    function getDatosSuspension($where) {
        $consulta = <<<EOF
               SELECT * FROM control_suspension c WHERE c.vector IS NOT NULL $where          
EOF;
        $rta = $this->db->query($consulta);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
            return $rta;
        } else {
            return [];
        }
    }

    function getDatosTaximetro($where) {
        $consulta = <<<EOF
               SELECT DISTINCT
                v.numero_placa AS 'placa',
                p.idmaquina AS 'idmaquina',
                p.fechainicial AS 'fecha',
                IFNULL((SELECT r.valor FROM resultados r WHERE r.idprueba = p.idprueba AND r.tiporesultado = 'error_tiempo_nuevo' LIMIT 1),'---') AS 'error_tiempo_nuevo',
                IFNULL((SELECT r.valor FROM resultados r WHERE r.idprueba = p.idprueba AND r.tiporesultado = 'error_distancia_nuevo' LIMIT 1),'---') AS 'error_distancia_nuevo',
                IFNULL((SELECT r.valor FROM resultados r WHERE r.idprueba = p.idprueba AND r.tiporesultado = 'vector_tiempo' LIMIT 1),'---') AS 'vector_tiempo',
                IFNULL((SELECT r.valor FROM resultados r WHERE r.idprueba = p.idprueba AND r.tiporesultado = 'vector_distancia' LIMIT 1),'---') AS 'vector_distancia'

                FROM 
                vehiculos v, hojatrabajo h, pruebas p
                WHERE 
                v.idvehiculo = h.idvehiculo AND h.idhojapruebas = p.idhojapruebas AND 
                (h.reinspeccion = 0 OR h.reinspeccion = 1) AND p.idtipo_prueba = 6
                  AND (p.estado <> 5 AND p.estado <> 9)  $where          
EOF;
        $rta = $this->db->query($consulta);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
            return $rta;
        } else {
            return [];
        }
    }

    function getVectorSuspension($id) {
        $consulta = <<<EOF
               SELECT c.vector, c.valor_minimo, c.peso FROM control_suspension c WHERE c.id = $id        
EOF;
        $rta = $this->db->query($consulta);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
            return $rta;
        } else {
            return [];
        }
    }

}
