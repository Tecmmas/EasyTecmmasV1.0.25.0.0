<?php

class CDAModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get($idcda) {
        $data = $this->db->query("
            SELECT
                *
            FROM
                cda c
            WHERE
                c.idcda='$idcda'
            LIMIT
                1 ");
        if ($data->num_rows() > 0) {
            $rta = $data->result();
            return $rta[0];
        } else {
            return FALSE;
        }
    }

}
