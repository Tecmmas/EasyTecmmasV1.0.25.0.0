<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mcontrol_verificacion extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function insertar($data) {
        $this->db->insert('control_verificacion', $data);
    }

    function get($idmaquina) {
        $query = $this->db->query("select 
            (select parametro FROM config_maquina WHERE idconfiguracion=14 And idmaquina = $idmaquina AND tipo_parametro='audi_hc_bajo' order by idconfig_maquina desc limit 1) audi_hc_bajo, 
            (select parametro FROM config_maquina WHERE idconfiguracion=14 And idmaquina = $idmaquina AND tipo_parametro='audi_hc_alto' order by idconfig_maquina desc limit 1) audi_hc_alto, 
            (select parametro FROM config_maquina WHERE idconfiguracion=14 And idmaquina = $idmaquina AND tipo_parametro='audi_co_alto' order by idconfig_maquina desc limit 1) audi_co_alto, 
            (select parametro FROM config_maquina WHERE idconfiguracion=14 And idmaquina = $idmaquina AND tipo_parametro='audi_co_bajo' order by idconfig_maquina desc limit 1) audi_co_bajo, 
            (select parametro FROM config_maquina WHERE idconfiguracion=14 And idmaquina = $idmaquina AND tipo_parametro='audi_co2_bajo' order by idconfig_maquina desc limit 1) audi_co2_bajo, 
            (select parametro FROM config_maquina WHERE idconfiguracion=14 And idmaquina = $idmaquina AND tipo_parametro='audi_co2_alto' order by idconfig_maquina desc limit 1) audi_co2_alto, 
            (select parametro FROM config_maquina WHERE idconfiguracion=14 And idmaquina = $idmaquina AND tipo_parametro='audi_hc_medio' order by idconfig_maquina desc limit 1) audi_hc_medio, 
            (select parametro FROM config_maquina WHERE idconfiguracion=14 And idmaquina = $idmaquina AND tipo_parametro='audi_co_medio' order by idconfig_maquina desc limit 1) audi_co_medio, 
            (select parametro FROM config_maquina WHERE idconfiguracion=14 And idmaquina = $idmaquina AND tipo_parametro='audi_co2_medio' order by idconfig_maquina desc limit 1) audi_co2_medio");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return "";
        }
    }

}
