<?php

class ResultadosModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function Insert($data) {
        return $this->db->insert('resultados', $data);
    }

}
