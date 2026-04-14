<?php

class VehiculoModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get($numero_placa) {
        $data = $this->db->query("
            SELECT
                *
            FROM
                vehiculos v
            WHERE
                v.numero_placa='" . $numero_placa . "'
            LIMIT
                1 ");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    public function update($data) {
        $this->db->where("numero_placa", $data['numero_placa']);
        $this->db->update('vehiculos', $data);
    }

}
