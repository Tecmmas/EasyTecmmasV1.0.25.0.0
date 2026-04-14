<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mbackup extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function inserbackup($namebackup, $user) {
        $query = $this->db->query("INSERT INTO backup VALUES (NULL,'$namebackup','$user','','','',CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP())");
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getresul_local() {
        $query = true;
        $mesaje = "";
        $this->db2 = $this->load->database('backup', true);
        $tecmmas = $this->db->query("SHOW TABLES ");
        $res = $tecmmas->result();
        foreach ($res as $bd) {
            if ($bd->Tables_in_tecmmas_bd !== 'backup') {
                $rta = $this->db->query("SELECT COUNT(*) AS 'res' FROM $bd->Tables_in_tecmmas_bd");
                $rta2 = $this->db2->query("SELECT COUNT(*) AS 'res' FROM $bd->Tables_in_tecmmas_bd");
                $data = $rta->result();
                $data2 = $rta2->result();
                if ($data[0]->res !== $data2[0]->res) {
                    $query = false;
                    $mesaje = $mesaje . "Tabla $bd->Tables_in_tecmmas_bd registros no coinciden bd_local= " . $data[0]->res . ' bd_resplado= ' . $data2[0]->res . '<br/>';
                }
            }
        }
        $imagenesbd = $this->db->query("SHOW DATABASES  like 'imagenes_bd'");
        if ($imagenesbd->num_rows() > 0) {
            $image = $this->db->query("SHOW TABLES FROM imagenes_bd");
            $r = $image->result();
            foreach ($r as $bd) {
                $rta = $this->db->query("SELECT COUNT(*) AS 'res' FROM imagenes_bd.$bd->Tables_in_imagenes_bd");
                $rta2 = $this->db2->query("SELECT COUNT(*) AS 'res' FROM imagenes_bd.$bd->Tables_in_imagenes_bd");
                $data = $rta->result();
                $data2 = $rta2->result();
                if ($data[0]->res !== $data2[0]->res) {
                    $query = false;
                    $mesaje = $mesaje . "En la base de datos imagenes_bd Tabla $bd->Tables_in_imagenes_bd registros no coinciden bd_local= " . $data[0]->res . ' bd_resplado= ' . $data2[0]->res . '<br/>';
                }
            }
        }
        if (!$query) {
            return $mesaje;
        } else {
            return $query;
        }
    }

    public function getresul_respaldo() {
        $this->db2 = $this->load->database('backup', true);
        $query = $this->db2->query("SELECT COUNT(*) AS 'res' FROM resultados");
        if ($query->num_rows() > 0) {
            $query = $query->result();
            return $query[0]->res;
        } else {
            return FALSE;
        }
    }

    public function getplacas($data) {
        $query = $this->db->query("SELECT v.numero_placa,
                                    DATE_FORMAT(h.fechainicial, '%Y-%m-%d %h:%m:%s') AS 'fecha',
                                    IF(h.estadototal=4,'Aprobada','Rechazada') AS 'resultado'
                                    FROM vehiculos v, hojatrabajo h
                                    WHERE v.idvehiculo=h.idvehiculo AND (h.reinspeccion = 0 or h.reinspeccion = 1) AND
                                    DATE_FORMAT(h.fechafinal,'%Y-%m-%d') between DATE_FORMAT('$data','%Y-%m-%d') AND DATE_FORMAT('$data','%Y-%m-%d') ORDER BY 2 DESC  ");
        return $query;
    }

    public function Updatebackup($html, $user, $idbackup) {
        $query = $this->db->query("UPDATE backup  SET fechageneracion=fechageneracion, fecharestauracion= CURRENT_TIMESTAMP(), html='$html', usuariores='$user', res=1 WHERE idbackup=$idbackup");
        if ($query) {
            return 1;
        } else {
            return false;
        }
    }

    public function gettable() {
        $data = $this->db->query("SELECT * FROM backup ORDER BY 1 DESC LIMIT 2 ");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        } else {
            return FALSE;
        }
    }

    public function informe_backup($fechainicial, $fechafinal) {
        $query = $this->db->query("SELECT c.nombre AS 'Nombre backup', c.usuario AS 'Usuario backup',c.fechageneracion AS 'Fecha generacion', c.html AS 'Informe',
                                    c.usuariores AS 'Usuario restauracion backup', if (c.res = 1, 'Restaurado', 'No se restuaro') AS 'Estado',
                                    c.fecharestauracion AS 'Fecha restauracion'
                                    FROM backup c WHERE 
                                    DATE_FORMAT(c.fechageneracion,'%Y-%m-%d') between DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d')");
        return $query;
    }

}
