<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mindex extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->dbutil();
    }

    public function mDatabase() {
        $result = $this->dbutil->optimize_database();
        if ($result !== FALSE) {
            
            echo '<pre>';
            print_r($result);
            echo '</pre>';
        }
    }

    function puede_entrar($usuario, $contrasena) {
        $this->db->where('username', $usuario);
        $this->db->where('passwd', $contrasena);
        $query = $this->db->get('usuarios');
        return $query;
    }

    function validar_vigencia($idUsuario) {
        $result = $this->db->query("select 1 from usuarios u WHERE u.fecha_actualizacion<CURDATE() AND u.IdUsuario=" . $idUsuario);
        if ($result->num_rows() > 0) {
            return "1";
        } else {
            return "0";
        }
    }

    function parametroGases() {
//        $this->db->query("UPDATE parametros_ano_modelo p SET p.co = '4.0', p.hc = '650' WHERE p.rango_final = 1984 AND p.idtipo_combustible = 2 AND p.tipo_vehiculo = 1");
//        $this->db->query("UPDATE parametros_ano_modelo p SET p.co = '3.0', p.hc = '400' WHERE p.rango_final = 1997 AND p.idtipo_combustible = 2 AND p.tipo_vehiculo = 1");    
//        $this->db->query("UPDATE parametros_ano_modelo p SET p.co = '1.0', p.hc = '200' WHERE p.rango_final = 2009 AND p.idtipo_combustible = 2 AND p.tipo_vehiculo = 1");    
//        $this->db->query("UPDATE parametros_ano_modelo p SET p.co = '0.8', p.hc = '160' WHERE p.rango_inicial = 1998 AND p.idtipo_combustible = 2 AND p.tipo_vehiculo = 1");    
//        $this->db->query("UPDATE parametros_ano_modelo p SET p.co = '3.5', p.hc = '8000' WHERE p.rango_final = 2009 AND p.idtipo_combustible = 2 AND p.tipo_vehiculo = 3");    
//        $this->db->query("UPDATE parametros_ano_modelo p SET p.co = '3.5', p.hc = '1.600' WHERE p.rango_inicial = 1600 AND p.idtipo_combustible = 2 AND p.tipo_vehiculo = 3");    
//        $this->db->query("UPDATE parametros_ano_modelo p SET p.co = '3.5', p.hc = '1.300' WHERE p.tiempos = 4 AND  p.idtipo_combustible = 2 AND p.tipo_vehiculo = 3");    
        $this->db->query("UPDATE parametros_ano_modelo p SET p.co = '4.0', p.hc = '650', p.rango_inicial=0, p.rango_final=1984 WHERE  p.id_parametro=1");
        $this->db->query("UPDATE parametros_ano_modelo p SET p.co = '3.0', p.hc = '400', p.rango_inicial=1985, p.rango_final=1997 WHERE  p.id_parametro=2");
        $this->db->query("UPDATE parametros_ano_modelo p SET p.co = '1.0', p.hc = '200', p.rango_inicial=1998, p.rango_final=2009 WHERE  p.id_parametro=3");
        $this->db->query("UPDATE parametros_ano_modelo p SET p.co = '0.8', p.hc = '160', p.rango_inicial=2010, p.rango_final=3000 WHERE  p.id_parametro=4");
        $this->db->query("UPDATE parametros_ano_modelo p SET p.co = '3.5', p.hc = '8000' WHERE  p.id_parametro=5");
        $this->db->query("UPDATE parametros_ano_modelo p SET p.co = '3.5', p.hc = '1600' WHERE  p.id_parametro=15");
        $this->db->query("UPDATE parametros_ano_modelo p SET p.co = '3.5', p.hc = '1300' WHERE  p.id_parametro=6");
    }

}
