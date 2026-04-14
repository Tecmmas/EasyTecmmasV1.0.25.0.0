<?php

class LoginModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function Ingresar($username, $passwd)
    {
        $data = $this->db->query("
            SELECT
                *
            FROM
                usuarios u
            WHERE
                u.username='$username' and u.passwd='$passwd'
            LIMIT
                1");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function getCda()
    {
        $data = $this->db->query("
            SELECT
                nombre_cda
            FROM
                cda
            LIMIT
                1");
        if ($data->num_rows() > 0) {
            $d = $data->result();
            return $d[0]->nombre_cda;
        } else {
            return false;
        }
    }

    public function validarCronAudit()
    {
        $data = $this->db->query("
            show tables like '%cron_audit%' ");
        if ($data->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getTriggers()
    {
        $data = $this->db->query("SHOW TRIGGERS");
        return $data->result();
    }

    public function verificar2703()
    {
        $data = $this->db->query("SELECT *
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = 'vehiculos'
            AND COLUMN_NAME = 'aplicares2703'");
        return $data->result();
    }

    public function crearTablaPerifericos()
    {
        $data = $this->db->query("SHOW TABLES LIKE 'perifericos'");
        if ($data->num_rows() == 0) {
            $this->db->query("
				CREATE TABLE perifericos (
					id INT(11) NOT NULL AUTO_INCREMENT,
					idprueba INT(11) NOT NULL,
					idperiferico VARCHAR(50) NOT NULL,
					PRIMARY KEY (id)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");
        }
    }

}
