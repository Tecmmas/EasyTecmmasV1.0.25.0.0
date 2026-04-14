<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MarcaModel
 *
 * @author arman
 */
class MarcaModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get($idmarca) {
        $data = $this->db->query("
            SELECT
                *
            FROM
                marca m
            WHERE
                m.idmarca='$idmarca'
            LIMIT
                1 ");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }
    
    public function getMarcaRunt($idmarca) {
        $data = $this->db->query("
            SELECT
                idmarcarunt idmarca,nombre
            FROM
                marcarunt m
            WHERE
                m.idmarcarunt='$idmarca'
            LIMIT
                1 ");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }
}
