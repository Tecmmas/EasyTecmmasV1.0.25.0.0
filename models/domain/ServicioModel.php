<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ServicioModel
 *
 * @author arman
 */
class ServicioModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get($idservicio) {
        $data = $this->db->query("
            SELECT
                *
            FROM
                servicio s
            WHERE
                s.idservicio='$idservicio'
            LIMIT
                1 ");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

}
