<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mpruebas extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('Opensslencryptdecrypt');
    }

    var $key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c';

    function getPruebas($idtipo_prueba, $reinspeccion, $tipo_vehiculo) {
        if ($idtipo_prueba == 7 || $idtipo_prueba == 9 || $idtipo_prueba == 10) {
            $idtipo_prueba = "(p.idtipo_prueba=7 || p.idtipo_prueba=9 || p.idtipo_prueba=10) and";
            $group = "group by v.numero_placa";
        } else {
            $idtipo_prueba = "p.idtipo_prueba=$idtipo_prueba and";
            $group = "group by p.idhojapruebas,p.idtipo_prueba";
        }
        $result = $this->db->query("
            select 
            p.idprueba,v.numero_placa,h.reinspeccion,v.idclase,v.tipo_vehiculo,v.taximetro,v.idservicio,v.tiempos
            from 
            pruebas p, hojatrabajo h,vehiculos v 
            where 
            p.idhojapruebas=h.idhojapruebas and
            v.idvehiculo=h.idvehiculo and
            $idtipo_prueba
            $reinspeccion
            $tipo_vehiculo
            p.estado=0 and h.estadototal<>5 and date_format(p.fechainicial,'%Y-%m-%d') = date_format(now(),'%Y-%m-%d')
            $group;");
        return $result;
    }

    function insertarResultado($resultados) {
        $this->db->trans_start();
        $fechaguardado = $this->getNow();
        $key = $this->key;
        $idprueba = $resultados['idprueba'];
        $tiporesultado = $resultados['tiporesultado'];
        $valor = $this->formato_texto($resultados['valor']);
        $observacion = $this->formato_texto($resultados['observacion']);
        $idconfig_prueba = $resultados['idconfig_prueba'];
        $res['idprueba'] = $idprueba;
        $res['tiporesultado'] = $tiporesultado;
        $res['valor'] = $valor;
        $res['fechaguardado'] = $fechaguardado;
        $res['observacion'] = $observacion;
        $res['idconfig_prueba'] = $idconfig_prueba;
        $enc = json_encode($res);
        $Q = <<<EOF
        INSERT INTO 
        resultados
        VALUES
        (null,'$idprueba','$tiporesultado','$valor','$fechaguardado','$observacion','$idconfig_prueba', AES_ENCRYPT('$enc','$key'))
EOF;
        $rta = $this->db->query($Q);

        if ($rta) {
            return 1;
        } else {
            return 0;
        }
        $this->db->trans_complete();
    }

    function insertarPrueba($prueba) {
        $this->db->trans_start();
        $fechainicial = $this->getNow();
        $key = $this->key;
        $idhojapruebas = $prueba['idhojapruebas'];
        $prueba_ = $prueba['prueba'];
        $estado = $prueba['estado'];
        $idusuario = $prueba['idusuario'];
        $idtipo_prueba = $prueba['idtipo_prueba'];
        $pru['idhojapruebas'] = $idhojapruebas;
        $pru['fechainicial'] = $fechainicial;
        $pru['prueba'] = "$prueba_";
        $pru['estado'] = "$estado";
        $pru['fechafinal'] = NULL;
        $pru['idmaquina'] = NULL;
        $pru['idusuario'] = $idusuario;
        $pru['idtipo_prueba'] = $idtipo_prueba;
        $enc = json_encode($pru);
        $Q = <<<EOF
        INSERT INTO 
        pruebas
        VALUES
        (null,'$idhojapruebas','$fechainicial','$prueba_','$estado',NULL,NULL,'$idusuario','$idtipo_prueba', AES_ENCRYPT('$enc','$key'))
EOF;
        $rta = $this->db->query($Q);
        if ($rta) {
            return 1;
        } else {
            return 0;
        }
        $this->db->trans_complete();
    }

    function insertarPruebaPeriferico($prueba) {
        $this->db->trans_start();
        $fechainicial = $this->getNow();
        $key = $this->key;
        $idhojapruebas = $prueba['idhojapruebas'];
        $prueba_ = $prueba['prueba'];
        $estado = $prueba['estado'];
        $idusuario = $prueba['idusuario'];
        $idtipo_prueba = $prueba['idtipo_prueba'];
        $pru['idhojapruebas'] = $idhojapruebas;
        $pru['fechainicial'] = $fechainicial;
        $pru['prueba'] = "$prueba_";
        $pru['estado'] = "$estado"; 
        $fechafinal = $prueba['fechafinal'];
        $pru['fechafinal'] = $prueba['fechafinal'];
        $idmaquina = $prueba['idmaquina'];
        $pru['idmaquina'] = $prueba['idmaquina'];
        $pru['idusuario'] = $idusuario;
        $pru['idtipo_prueba'] = $idtipo_prueba;
        $enc = json_encode($pru);
        $Q = <<<EOF
        INSERT INTO 
        pruebas
        VALUES
        (null,'$idhojapruebas','$fechainicial','$prueba_','$estado','$fechafinal','$idmaquina','$idusuario','$idtipo_prueba', AES_ENCRYPT('$enc','$key'))
EOF;
        $rta = $this->db->query($Q);
        if ($rta) {
            return 1;
        } else {
            return 0;
        }
        $this->db->trans_complete();
    }

    function insertarPruebaExosto($prueba) {
        $this->db->insert("pruebas", $prueba);
        return $this->db->insert_id();
    }

    function actualizarPruebas($pruebas) {
        $this->db->trans_start();
        $query = $this->db->query("UPDATE pruebas SET fechainicial=fechainicial, estado=" . $pruebas['estado'] . ", idusuario =" . $pruebas['idusuario'] . ",  "
                . "idmaquina =" . $pruebas['idmaquina'] . ",fechafinal = now()  WHERE idprueba=" . $pruebas['idprueba']);
        $this->updateEnc($pruebas['idprueba']);
        $this->db->trans_complete();
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    function eliminarResultados($idprueba) {
        $query = $this->db->query("DELETE FROM resultados  WHERE idprueba=$idprueba;");
    }

    function actualizarPruebasExosto($pruebas) {
        $this->db->set('fechafinal', 'NOW()', FALSE);
        $this->db->set('idusuario', $pruebas['idusuario']);
        $this->db->set('prueba', $pruebas['prueba']);
        $this->db->set('idmaquina', $pruebas['idmaquina']);
        $this->db->set('estado', $pruebas['estado']);
        $this->db->set('fechainicial', 'fechainicial', FALSE);
        $this->db->where('idprueba', $pruebas['idprueba']);
        $this->db->update("pruebas", $pruebas);
        $this->updateEnc($pruebas['idprueba']);
    }

    function obtenerPlacaIdprueba($idprueba) {
        $result = $this->db->query("select 
                        v.numero_placa
                        from 
                        vehiculos v,pruebas p, hojatrabajo h 
                        where
                        v.idvehiculo=h.idvehiculo and
                        p.idhojapruebas=h.idhojapruebas and
                        p.idprueba=$idprueba limit 1");
        $rta = $result->result();
        return $rta[0]->numero_placa;
    }

    function getMaquina($serie, $idtipo_prueba) {
        echo $serie;
        echo $idtipo_prueba;
        $this->db->where('serie', $serie);
        $this->db->where('idtipo_prueba', $idtipo_prueba);
        $query = $this->db->get('maquina');
        $rta = $query->result();
        return $rta[0];
    }

    function getUsuario($idusuario) {
        $this->db->trans_start();
        $this->db->where('IdUsuario', $idusuario);
        $query = $this->db->get('usuarios');
        $rta = $query->result();
        return $rta[0];
        $this->db->trans_complete();
    }

    function getUsuarioClave($passwd) {
        $key = $this->key;
        $where = "passwd=AES_ENCRYPT('$passwd','eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c') AND (idperfil='1' OR idperfil='3') and estado='1'";
        $this->db->where($where);
        $query = $this->db->get('usuarios');
        return $query->num_rows();
    }

    function getHojaPruebas($idprueba) {
        $this->db->trans_start();
        $result = $this->db->query("select 
                h.* 
                from 
                pruebas p,hojatrabajo h 
                where
                p.idhojapruebas=h.idhojapruebas and
                p.idprueba=$idprueba limit 1;");
        $rta = $result->result();
        return $rta[0];
        $this->db->trans_complete();
    }

    function getSicovRunt() {
        $result = $this->db->query("select valor,adicional from config_prueba where idconfig_prueba=502");
        $rta = $result->result();
        return $rta[0];
    }

    function buscarResultado($idprueba, $idconfig_prueba) {
        $result = $this->db->query("select valor from resultados where idprueba=$idprueba and idconfig_prueba=$idconfig_prueba limit 1");
        $rta = $result->result();
        $valor = "";
        if ($result->num_rows() > 0) {
            $valor = $rta[0]->valor;
        }
        return $valor;
    }

    function insertarAuditoriaSicov($auditoria_sicov) {
        echo $this->db->insert("auditoria_sicov", $auditoria_sicov);
    }

    function getNow() {
        $result = $this->db->query("select now() ahora");
        $result = $result->result();
        return $result[0]->ahora;
    }

    function updateEnc($id) {
        $pruebas['idprueba'] = $id;
        $idprueba = $pruebas['idprueba'];
        $query2 = $this->db->query("SELECT * FROM pruebas p WHERE p.idprueba = $idprueba LIMIT 1");
        $pru = $query2->result();
        $dat['idhojapruebas'] = $pru[0]->idhojapruebas;
        $dat['fechainicial'] = $pru[0]->fechainicial;
        $dat['prueba'] = $pru[0]->prueba;
        $dat['estado'] = $pru[0]->estado;
        $dat['fechafinal'] = $pru[0]->fechafinal;
        $dat['idmaquina'] = $pru[0]->idmaquina;
        $dat['idusuario'] = $pru[0]->idusuario;
        $dat['idtipo_prueba'] = $pru[0]->idtipo_prueba;
        $enc = json_encode($dat);
        $key = $this->key;
        $Q = <<<EOF
                UPDATE
                pruebas
                SET
                fechainicial=fechainicial, enc=(SELECT AES_ENCRYPT('$enc','$key'))
                WHERE
                idprueba=$idprueba;
EOF;
        $this->db->query($Q);
    }

    private function formato_texto($cadena) {
        $no_permitidas = array("Ñ", "ñ", "á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹", "'", "");
        $permitidas = array("N", "n", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E", "", "");
        $texto = str_replace($no_permitidas, $permitidas, $cadena);
        return $texto;
    }

}
