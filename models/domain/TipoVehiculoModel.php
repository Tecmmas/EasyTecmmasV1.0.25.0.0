<?php

class TipoVehiculoModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get($idtipo_vehiculo) {
        $data = $this->db->query("
            SELECT
                *
            FROM
                tipo_vehiculo tv
            WHERE
                tv.idtipo_vehiculo='$idtipo_vehiculo'
            LIMIT
                1 ");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

}
