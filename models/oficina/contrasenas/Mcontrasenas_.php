<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mcontrasenas extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getuser($iduser) {
        $query = $this->db->query("SELECT u.IdUsuario, u.idperfil, u.nombres, u.apellidos, u.fecha_actualizacion FROM usuarios u WHERE u.IdUsuario = $iduser");
        return $query;
    }

    public function getpassword($iduser, $contrasenna) {
        $query = $this->db->query("SELECT * FROM historico_pass h WHERE h.idusuario=$iduser AND h.password='$contrasenna'");
        return $query;
    }

    public function updatecontraadmin($iduser, $contrasenna, $fecha) {
        $query = $this->db->query("UPDATE usuarios  SET fecha_actualizacion = DATE_ADD(DATE_FORMAT(NOW(), '%Y/%m/%d'), INTERVAL 15 DAY), passwd='$contrasenna'  WHERE IdUsuario= $iduser");
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    public function insertcontraadmin($iduser, $contrasenna) {
        $query = $this->db->query("INSERT INTO historico_pass VALUES (NULL,$iduser,CURRENT_TIMESTAMP(),'$contrasenna')");
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    public function updatecontra($iduser, $contrasenna, $fecha) {
        $query = $this->db->query("UPDATE usuarios  SET fecha_actualizacion = DATE_ADD(DATE_FORMAT(NOW(), '%Y/%m/%d'), INTERVAL 30 DAY), passwd='$contrasenna'  WHERE IdUsuario= $iduser");
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    public function insertcontra($iduser, $contrasenna) {
        $query = $this->db->query("INSERT INTO historico_pass VALUES (NULL,$iduser,CURRENT_TIMESTAMP(),'$contrasenna')");
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

}
