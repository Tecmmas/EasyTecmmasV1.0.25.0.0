<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mcda extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get()
    {
        return $this->db->get('cda');
    }

    function getVersion($fechainicial)
    {
        $query = <<< EOF
                SELECT * 
                    FROM cda c
                    WHERE c.fechavigencia IS NULL OR  CAST('$fechainicial' AS DATE) <= CAST(c.fechavigencia AS DATE)
EOF;
        $result = $this->db->query($query);
        return $result;
    }
}
