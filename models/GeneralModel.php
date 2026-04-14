<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GeneralModel
 *
 * @author arman
 */
class GeneralModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getFechaActual() {
        $data = $this->db->query("select now() fecha");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data[0]->fecha;
        } else {
            return FALSE;
        }
    }

    function getSicovName() {
        $data = $this->db->query("select valor,adicional from config_prueba where idconfig_prueba=502");
        if ($data->num_rows() > 0) {
            $s = $data->result();
            if ($s[0]->valor == "1") {
                $sicov = explode("-", $s[0]->adicional);
                return $sicov[0];
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    function getUserSicov() {
        $data = $this->db->query("select valor,adicional from config_prueba where idconfig_prueba=502");
        if ($data->num_rows() > 0) {
            $s = $data->result();
            if ($s[0]->valor == "1") {
                $sicov = explode("-", $s[0]->adicional);
                if ($sicov[0] == "CI2") {
                    $a2 = explode("@", $sicov[1]);
                    $a3 = explode(":", $a2[0]);
                    $a5 = explode("|", $a2[1]);
                    $dato['Usuario'] = $a3[0];
                    $dato['Clave'] = $a3[1];
                    $dato['RUNTCda'] = $a5[1];
                    return $dato;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    function getRegistroRunt($placa){
        $data = $this->db->query("select registrorunt from vehiculos where numero_placa='$placa' limit 1");
        if ($data->num_rows() > 0) {
            $s = $data->result();
            if ($s[0]->registrorunt == "1") {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

}
