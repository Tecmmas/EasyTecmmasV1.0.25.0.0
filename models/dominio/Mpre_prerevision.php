<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mpre_prerevision extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("idpre_prerevision", $data['idpre_prerevision']);
        $query = $this->db->get('pre_prerevision');
        return $query;
    }

    function getHistoVehiculo($idpre_prerevision) {
        $this->db->where("idpre_prerevision", $idpre_prerevision);
        $query = $this->db->get('histo_vehiculo');
        return $query;
    }

    function getXidPre($data) {
        $this->db->where("numero_placa_ref", $data['numero_placa_ref']);
        $this->db->where("reinspeccion", $data['reinspeccion']);
        $this->db->where("tipo_inspeccion", $data['tipo_inspeccion']);
        $this->db->order_by('idpre_prerevision', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('pre_prerevision');
        $rta = $query->result();
        return $rta[0]->idpre_prerevision;
    }

    function getXofi($data) {
//        $this->db->where("idpre_prerevision", $data['idpre_prerevision']);
        $this->db->where('date_format(fecha_prerevision,"%Y-%m-%d")', 'date_format("' . $data['fecha'] . '","%Y-%m-%d")', FALSE);
        $this->db->where("numero_placa_ref", $data['numero_placa_ref']);
        $this->db->where("reinspeccion", $data['reinspeccion']);
        $this->db->select_max('idpre_prerevision');
        $query = $this->db->get('pre_prerevision');
        return $query;
    }

    function getDatos($data) {
        $placa = $data['numero_placa_ref'];
        $reinspeccion = $data['reinspeccion'];
        $fecha = $data['fecha_prerevision'];
        $tipo = $data['tipo_inspeccion'];
        $r = $this->db->query("
            SELECT 
                pa.id,pd.valor,p.actualizado,p.idpre_prerevision
                FROM 
                pre_prerevision p,pre_atributo pa, pre_dato pd
                WHERE
                p.idpre_prerevision=pd.idpre_prerevision AND
                pd.idpre_atributo=pa.idpre_atributo AND
                p.numero_placa_ref='$placa' AND
                p.reinspeccion=$reinspeccion AND
                p.tipo_inspeccion=$tipo AND
                DATE_FORMAT(p.fecha_prerevision,'%Y%M%d') = DATE_FORMAT('$fecha','%Y%M%d')
                ");
        if ($r->num_rows() > 0) {
            return $r;
        } else {
            return FALSE;
        }
    }

}
