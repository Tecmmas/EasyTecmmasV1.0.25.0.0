<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mth extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($idmaquina) {
        $rta = $this->db->query("SELECT 
                                    c.tipo_parametro,
                                    ifnull(AES_DECRYPT(c.parametro ,'353E9D61B66D77CAE6BF97DE8F7CAWYJFLLD2D765SD4894165SD81SD'), c.parametro) AS parametro
                                    FROM
                                    config_maquina c
                                    WHERE
                                    c.idmaquina=$idmaquina;");
        return $rta;
    }
    function getDiff($idmaquina) {
        $rta = $this->db->query("SELECT 
                                    IFNULL(
        TIMESTAMPDIFF(
            SECOND,
            STR_TO_DATE(
                IFNULL(AES_DECRYPT(c.parametro, '353E9D61B66D77CAE6BF97DE8F7CAWYJFLLD2D765SD4894165SD81SD'), c.parametro),
                '%Y-%m-%d %H:%i:%s'
            ),
            NOW()
        ),
        0
    ) AS diferencia
                                    FROM
                                    config_maquina c
                                    WHERE
                                    c.tipo_parametro='Last Update' and
                                    c.idmaquina=$idmaquina limit 1;");
        return $rta;
    }

}
