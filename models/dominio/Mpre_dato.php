<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mpre_dato extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("idpre_dato", $data['idpre_dato']);
        $query = $this->db->get('pre_dato');
        return $query;
    }

    function getXatripre($data) {
        $this->db->where("idpre_prerevision", $data['idpre_prerevision']);
        $this->db->where("idpre_atributo", $data['idpre_atributo']);
        $query = $this->db->get('pre_dato');
        return $query;
    }

    function guardar($data) {
        $rta = $this->getXatripre($data);
        if ($rta->num_rows() > 0) {
            $this->db->set("valor", $data['valor']);
            $this->db->where("idpre_prerevision", $data['idpre_prerevision']);
            $this->db->where("idpre_atributo", $data['idpre_atributo']);
            $this->db->update('pre_dato');
        } else {
            $this->db->insert('pre_dato', $data);
        }
    }

}
