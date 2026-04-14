<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OFCConsultarRuntModel
 *
 * @author arman
 */
class OFCConsultarRuntModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function BuscarTablaMarca() {
        $data = $this->db->query("
            show tables like '%marcarunt%' ");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    function BuscarTablaLinea() {
        $data = $this->db->query("
            show tables like '%linearunt%' ");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    function BuscarTablaColor() {
        $data = $this->db->query("
            show tables like '%colorrunt%' ");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    function BuscarRegistroRunt() {
        $data = $this->db->query("
            show columns from vehiculos where Field='registrorunt'");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    function CrearTablaMarca() {
        if (!$this->BuscarTablaMarca()) {
            try {
                $query = "CREATE TABLE `marcarunt` (
                            `idmarcaRUNT` INT(11) NOT NULL,
                            `nombre` VARCHAR(100) NOT NULL,
                            PRIMARY KEY (`idmarcaRUNT`))
                            ENGINE = MyISAM;";
                $this->db->query($query);
            } catch (Exception $ex) {
                echo($ex->getMessage());
                return false;
            }
        }
    }

    function CrearTablaLinea() {
        if (!$this->BuscarTablaLinea()) {
            try {
                $query = "CREATE TABLE `linearunt` (
                            `idlineaRUNT` INT(11) NOT NULL AUTO_INCREMENT,
                            `idmarcaRUNT` INT(11) NOT NULL,
                            `codigo` INT(11) NOT NULL,
                            `nombre` VARCHAR(100) NOT NULL,
                            PRIMARY KEY (`idlineaRUNT`))
                            ENGINE = MyISAM;";
                $this->db->query($query);
            } catch (Exception $ex) {
                echo($ex->getMessage());
                return false;
            }
        }
    }

    function CrearTablaColor() {
        if (!$this->BuscarTablaColor()) {
            try {
                $query = "CREATE TABLE `colorrunt` (
                            `idcolorRUNT` INT NOT NULL,
                            `nombre` VARCHAR(100) NOT NULL,
                            PRIMARY KEY (`idcolorRUNT`))ENGINE = MyISAM";
                $this->db->query($query);
            } catch (Exception $ex) {
                echo($ex->getMessage());
                return false;
            }
        }
    }

    function CrearRegistroRunt() {
        if (!$this->BuscarRegistroRunt()) {
            try {
                $query = "ALTER TABLE `vehiculos` 
                        ADD COLUMN `registrorunt` VARCHAR(1) NULL DEFAULT '0' AFTER `numejes`;";
                $this->db->query($query);
            } catch (Exception $ex) {
                echo($ex->getMessage());
                return false;
            }
        }
    }

    function InsertarColorRunt($colorrunt) {
        if (!$this->BuscarColor($colorrunt['idcolorRUNT'])) {
            return $this->db->insert('colorrunt', $colorrunt);
        }
    }

    function BuscarColor($idcolor) {
        $data = $this->db->query("
            SELECT
                idcolorRUNT
            FROM
                colorrunt c
            WHERE
                c.idcolorRUNT=$idcolor");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    function InsertarColorLocal($color) {
        if (!$this->BuscarColorLocal($color['idcolor'])) {
            return $this->db->insert('color', $color);
        }
    }

    function BuscarColorLocal($idcolor) {
        $data = $this->db->query("
            SELECT
                idcolor
            FROM
                color c
            WHERE
                c.idcolor=$idcolor");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    function InsertarMarcaRunt($marcarunt) {
        if (!$this->BuscarMarca($marcarunt['idmarcaRUNT'])) {
            return $this->db->insert('marcarunt', $marcarunt);
        }
    }

    function BuscarMarca($idmarca) {
        $data = $this->db->query("
            SELECT
                idmarcaRUNT
            FROM
                marcarunt m
            WHERE
                m.idmarcaRUNT=$idmarca");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    function InsertarMarcaLocal($marcarunt) {
        if (!$this->BuscarMarcaLocal($marcarunt['idmarca'])) {
            return $this->db->insert('marca', $marcarunt);
        }
    }

    function BuscarMarcaLocal($idmarca) {
        $data = $this->db->query("
            SELECT
                idmarca
            FROM
                marca m
            WHERE
                m.idmarca=$idmarca");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    function InsertarLineaRunt($linearunt) {
        if (!$this->BuscarLinea($linearunt['idmarcaRUNT'], $linearunt['codigo'])) {
            return $this->db->insert('linearunt', $linearunt);
        }
    }

    function InsertarLineaRunt2($linearunt) {
        $rta = $this->BuscarLinea($linearunt['idmarcaRUNT'], $linearunt['codigo']);
        if (!$rta) {
            $this->db->insert('linearunt', $linearunt);
            return $this->db->insert_id();
        }else{
            $rta = $rta->result();
            return $rta[0]->idlineaRunt;
        }
    }

    function BuscarLinea($idmarca, $codigo) {
        $data = $this->db->query("
            SELECT
                idlineaRunt
            FROM
                linearunt l
            WHERE
                l.idmarcaRUNT=$idmarca and l.codigo=$codigo");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    function InsertarLineaLocal($linea) {
        if (!$this->BuscarLinea($linea['idmarca'], $linea['idmintrans'])) {
            return $this->db->insert('linea', $linea);
        }
    }

    function BuscarLineaLocal($idmarca, $codigo) {
        $data = $this->db->query("
            SELECT
                idlinea
            FROM
                linea l
            WHERE
                l.idmarca=$idmarca and l.idmintrans=$codigo");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    function InsertarClase($clase) {
        if (!$this->BuscarClase($clase['idclase'])) {
            return $this->db->insert('clase', $clase);
        }
    }

    function BuscarClase($idclase) {
        $data = $this->db->query("
            SELECT
                idclase
            FROM
                clase c
            WHERE
                c.idclase=$idclase");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    function InsertarAseguradora($aseguradora) {
        if (!$this->BuscarAseguradora($aseguradora['nombre'])) {
            return $this->db->insert('aseguradoras', $aseguradora);
        }
    }

    function BuscarAseguradora($nombre) {
        $data = $this->db->query("
            SELECT
                a.idaseguradora
            FROM
                aseguradoras a
            WHERE
                a.nombre='$nombre'");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    function InsertarVehiculo($vehiculo) {
        if (!$this->BuscarVehiculo($vehiculo['numero_placa'])) {
            echo $this->db->insert('vehiculos', $vehiculo);
        } else {
            $this->db->where('numero_placa', $vehiculo['numero_placa']);
            echo $this->db->update('vehiculos', $vehiculo);
        }
    }

    function BuscarVehiculo($numero_placa) {
        $data = $this->db->query("
            SELECT
                v.idvehiculo
            FROM
                vehiculos v
            WHERE
                v.numero_placa='$numero_placa'");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    function InsertarSoat($soat) {
        if (!$this->BuscarSoat($soat['idaseguradora'], $soat['numero_soat'])) {
            return $this->db->insert('soat', $soat);
        } else {
            $this->db->where('idaseguradora', $soat['idaseguradora']);
            $this->db->where('numero_soat', $soat['numero_soat']);
            return $this->db->update('soat', $soat);
        }
    }

    function BuscarSoat($idaseguradora, $numero_soat) {
        $data = $this->db->query("
            SELECT
                s.idsoat
            FROM
                soat s
            WHERE
                s.idaseguradora='$idaseguradora' and s.numero_soat='$numero_soat'");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

}
