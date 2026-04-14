<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MEventosindra extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("ideventosindra", $data['ideventosindra']);
        $query = $this->db->get('eventosindra');
        return $query;
    }

    function getAll() {
        $query = $this->db->get('eventosindra');
        return $query;
    }

    function getAllHoy($placa) {
        $query = <<<EOF
              SELECT
e.idelemento, e.fecha, e.tipo, e.enviado, e.respuesta
FROM eventosindra e
WHERE date_format(fecha,"%Y-%m-%d") =CURDATE() AND e.idelemento = ? ORDER BY e.ideventosindra DESC 
EOF;
        $rta = $this->db->query($query, array($placa));
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
        } else {
            $rta = '';
        }
        return $rta;
    }

    function getEventos0() {
        $query = <<<EOF
              SELECT
e.*
FROM eventosindra e
WHERE 
date_format(fecha,"%Y-%m-%d") =CURDATE() AND e.tipo = 'e' AND e.enviado = 0
EOF;
        $rta = $this->db->query($query);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
        } else {
            $rta = '';
        }
        return $rta;
    }

    function update($data) {
        $this->db->set('respuesta', $data['respuesta']);
        $this->db->set('enviado', $data['enviado']);
        $this->db->where('ideventosindra', $data['ideventosindra'], FALSE);
        $this->db->update('eventosindra', $data);
    }

    function insert($data) {
        $this->db->insert('eventosindra', $data);
    }

    function deleteEventos() {
        $query = <<<EOF
              DELETE
                FROM 
                eventosindra 
                WHERE 
                DATE_FORMAT(fecha,'%Y-%m-%d')<>DATE_FORMAT(NOW(),'%Y-%m-%d')
EOF;
        return $this->db->query($query);
    }

}
