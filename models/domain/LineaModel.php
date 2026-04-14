<?php

class LineaModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get($idlinea) {
        $data = $this->db->query("
            SELECT
                *
            FROM
                linea l
            WHERE
                l.idlinea='$idlinea'
            LIMIT
                1 ");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }
    
    public function getLineaRunt($idlinea) {
        $data = $this->db->query("
            SELECT
                idlinearunt idlinea,idmarcarunt idmarca,nombre
            FROM
                linearunt l
            WHERE
                l.idlinearunt='$idlinea'
            LIMIT
                1 ");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

}
