<?php

class ClaseModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get($idclase) {
        $data = $this->db->query("
            SELECT
                *
            FROM
                clase c
            WHERE
                c.idclase='$idclase'
            LIMIT
                1 ");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

}
