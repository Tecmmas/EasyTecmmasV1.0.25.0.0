<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mvisual extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('Opensslencryptdecrypt');
    }

    var $key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c';

    function getDefectos($idprueba) {
        $rta = $this->db->query("SELECT 
                                'setLabrados' funcionSet,
                                r.idresultados,
                                r.idprueba,
                                r.tiporesultado,
                                r.valor,
                                r.fechaguardado,
                                r.observacion,
                                r.idconfig_prueba,
                                JSON_CONTAINS(
                                JSON_OBJECT(
                                'idprueba',CAST(idprueba AS CHAR(100000)),
                                'tiporesultado',CAST(tiporesultado AS CHAR(100000)),
                                'fechaguardado',CAST(fechaguardado AS CHAR(100000)),
                                'valor',CAST(valor AS CHAR(100000)),
                                'observacion',CAST(observacion AS CHAR(100000)),
                                'idconfig_prueba',CAST(idconfig_prueba AS CHAR(100000))),
                                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c')) autentico
                                FROM 
                                resultados r
                                WHERE 
                                r.idprueba=$idprueba;");
        return $rta;
    }

    function getObservaciones($codigo) {
        $rta = $this->db->query("SELECT 
                                'setObservaciones' funcionSet,o.* 
                                FROM 
                                observaciones o 
                                WHERE 
                                o.codigo='$codigo';");
        return $rta;
    }

    function insertarDefecto($idprueba, $valor) {
        $this->db->trans_start();
        $this->borrarDefecto($idprueba, $valor);
        $data['idprueba'] = $idprueba;
        $data['tiporesultado'] = 'defecto';
        $tiporesultado = 'defecto';
        $fechaguardado = $this->getNow();
        $data['fechaguardado'] = $fechaguardado;
        $data['valor'] = $valor;
        $observacion = "";
        $data['observacion'] = $observacion;
        $idconfig_prueba = "153";
        $data['idconfig_prueba'] = $idconfig_prueba;
        $enc = json_encode($data);
        $key = $this->key;
        $Q = <<<EOF
        INSERT INTO 
        resultados
        VALUES
        (null,'$idprueba','$tiporesultado','$valor','$fechaguardado','$observacion','$idconfig_prueba', AES_ENCRYPT('$enc','$key'))
EOF;
        echo $this->db->query($Q);
        $this->db->trans_complete();
    }

    function borrarDefecto($idprueba, $valor) {
        $this->db->where('idprueba', $idprueba);
        $this->db->where('valor', $valor);
        echo $this->db->delete('resultados');
    }

    function getObses($idprueba) {
        $rta = $this->db->query("SELECT 
                                'setLabrados' funcionSet,
                                r.idresultados,
                                r.idprueba,
                                r.tiporesultado,
                                r.valor,
                                r.fechaguardado,
                                r.observacion,
                                r.idconfig_prueba,
                                JSON_CONTAINS(
                                JSON_OBJECT(
                                'idprueba',CAST(idprueba AS CHAR(100000)),
                                'tiporesultado',CAST(tiporesultado AS CHAR(100000)),
                                'fechaguardado',CAST(fechaguardado AS CHAR(100000)),
                                'valor',CAST(valor AS CHAR(100000)),
                                'observacion',CAST(observacion AS CHAR(100000)),
                                'idconfig_prueba',CAST(idconfig_prueba AS CHAR(100000))),
                                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c')) autentico
                                FROM 
                                resultados r
                                WHERE 
                                r.idprueba=$idprueba and idconfig_prueba=77;");
        return $rta;
    }

    function insertarObse($data) {
        $this->db->trans_start();
        $idprueba = $data['idprueba'];
        $tiporesultado = $data['tiporesultado'];
        $fechaguardado = $this->getNow();
        $valor = $data['valor'];
        $observacion = $this->formato_texto($data['observacion']);
        $idconfig_prueba = $data['idconfig_prueba'];
        $enc = json_encode($data);
        $key = $this->key;
        $Q = <<<EOF
        INSERT INTO 
        resultados
        VALUES
        (null,'$idprueba','$tiporesultado','$valor','$fechaguardado','$observacion','$idconfig_prueba', AES_ENCRYPT('$enc','$key'))
EOF;
        echo $this->db->query($Q);
        $this->db->trans_complete();
    }

    function borrarObse($data) {
        $this->db->where('idprueba', $data['idprueba']);
        $this->db->where('tiporesultado', $data['tiporesultado']);
        $this->db->where('idconfig_prueba', '77');
        echo $this->db->delete('resultados');
    }

    function insertarObservacion($codigo, $observacion) {
        $data['codigo'] = $codigo;
        $data['observacion'] = $this->formato_texto($observacion);
        echo $this->db->insert('observaciones', $data);
    }

    function insertarOperarioSensorial($data) {
        error_reporting(E_ERROR);
        echo $this->db->insert('operario_sensorial', $data);
    }

    function borrarObservacion($codigo, $observacion) {
        $this->db->where('codigo', $codigo);
        $this->db->where('observacion', $observacion);
        echo $this->db->delete('observaciones');
    }

    function actualizarObservacion($idprueba, $codigo, $observacion) {
        $this->db->trans_start();
        $rta = $this->getDefecto($idprueba, $codigo);
        $rta = $rta->result();
        $data['idprueba'] = $rta[0]->idprueba;
        $data['tiporesultado'] = $rta[0]->tiporesultado;
        $data['valor'] = $rta[0]->valor;
        $data['fechaguardado'] = $rta[0]->fechaguardado;
        $data['observacion'] = $this->formato_texto($observacion);
        $observacion = $this->formato_texto($observacion);
        $data['idconfig_prueba'] = $rta[0]->idconfig_prueba;
        $enc = json_encode($data);
        $key = $this->key;
        $Q = <<<EOF
        UPDATE
        resultados
        SET
        observacion='$observacion', fechaguardado=fechaguardado, enc=(SELECT AES_ENCRYPT('$enc','$key'))
        WHERE
        idprueba=$idprueba and valor='$codigo';
EOF;
        echo $this->db->query($Q);
        $this->db->trans_complete();
    }

    function getDefecto($idprueba, $codigo) {
        $rta = $this->db->query("SELECT 
                                * 
                                FROM 
                                resultados r 
                                WHERE 
                                r.idprueba=$idprueba and r.valor='$codigo'");
        return $rta;
    }

    function insertarLabrado($idprueba, $tiporesultado, $valor) {
        $this->db->trans_start();
        $this->db->where('idprueba', $idprueba);
        $this->db->where('tiporesultado', $tiporesultado);
        $this->db->delete('resultados');        
        $data['idprueba'] = $idprueba;
        $data['tiporesultado'] = $tiporesultado;
        $fechaguardado = $this->getNow();
        $data['fechaguardado'] = $fechaguardado;
        $valor_ = str_replace(",", ".", $valor);
        $data['valor'] = $valor_;
        $observacion = "OBSERVACIONLABRADO";
        $data['observacion'] = $observacion;
        $idconfig_prueba = "96";
        $data['idconfig_prueba'] = $idconfig_prueba;
        $enc = json_encode($data);
        $key = $this->key;
        $Q = <<<EOF
        INSERT INTO 
        resultados
        VALUES
        (null,'$idprueba','$tiporesultado','$valor_','$fechaguardado','$observacion','$idconfig_prueba', AES_ENCRYPT('$enc','$key'))
EOF;
        echo $this->db->query($Q);
        $this->db->trans_complete();
    }

//    function insertarLabrado($idprueba, $tiporesultado, $valor) {
//        $this->db->trans_start();
//        
////        echo $this->db->insert('resultados', $data);
//        $this->db->trans_complete();
//    }

    function insertarObservacionesAdd($idprueba, $valor) {
        $this->db->trans_start();
        $this->db->where('idprueba', $idprueba);
        $this->db->where('tiporesultado', 'COMENTARIOSADICIONALES');
        $this->db->delete('resultados');
        $data['idprueba'] = $idprueba;
        $data['tiporesultado'] = 'COMENTARIOSADICIONALES';
        $tiporesultado = $data['tiporesultado'];
        $fechaguardado = $this->getNow();
        $data['fechaguardado'] = $fechaguardado;
        $valor_ = str_replace(",", ".", $valor);
        $data['valor'] = $this->formato_texto($valor_);
        $valor_ = $data['valor'];
        $observacion = "";
        $data['observacion'] = "";
        $idconfig_prueba = "153";
        $data['idconfig_prueba'] = $idconfig_prueba;
        $enc = json_encode($data);
        $key = $this->key;
        $Q = <<<EOF
        INSERT INTO 
        resultados
        VALUES
        (null,'$idprueba','$tiporesultado','$valor_','$fechaguardado','$observacion','$idconfig_prueba', AES_ENCRYPT('$enc','$key'))
EOF;
        echo $this->db->query($Q);
        $this->db->trans_complete();
    }

    function getObseAdd($idprueba) {
        $rta = $this->db->query("SELECT 
                                'setLabrados' funcionSet,
                                r.idresultados,
                                r.idprueba,
                                r.tiporesultado,
                                r.valor,
                                r.fechaguardado,
                                r.observacion,
                                r.idconfig_prueba,
                                JSON_CONTAINS(
                                JSON_OBJECT(
                                'idprueba',CAST(idprueba AS CHAR(100000)),
                                'tiporesultado',CAST(tiporesultado AS CHAR(100000)),
                                'fechaguardado',CAST(fechaguardado AS CHAR(100000)),
                                'valor',CAST(valor AS CHAR(100000)),
                                'observacion',CAST(observacion AS CHAR(100000)),
                                'idconfig_prueba',CAST(idconfig_prueba AS CHAR(100000))),
                                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c')) autentico
                                FROM 
                                resultados r
                                WHERE 
                                r.idprueba=$idprueba and tiporesultado='COMENTARIOSADICIONALES';");
        return $rta;
    }

    private function formato_texto($cadena) {
        $no_permitidas = array("Ñ", "ñ", "á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹", "'", "");
        $permitidas = array("N", "n", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E", "", "");
        $texto = str_replace($no_permitidas, $permitidas, $cadena);
        return $texto;
    }

    function borrarLabrado($idprueba, $tiporesultado) {
        $this->db->trans_start();
        $rta = $this->db->query("delete from resultados where idprueba = $idprueba and tiporesultado = '$tiporesultado'");
        echo $rta;
        $this->db->trans_complete();
    }

    function getLabrados($idprueba) {
        $rta = $this->db->query("SELECT 
                                'setLabrados' funcionSet,
                                r.idresultados,
                                r.idprueba,
                                r.tiporesultado,
                                r.valor,
                                r.fechaguardado,
                                r.observacion,
                                r.idconfig_prueba,
                                JSON_CONTAINS(
                                JSON_OBJECT(
                                'idprueba',CAST(idprueba AS CHAR(100000)),
                                'tiporesultado',CAST(tiporesultado AS CHAR(100000)),
                                'fechaguardado',CAST(fechaguardado AS CHAR(100000)),
                                'valor',CAST(valor AS CHAR(100000)),
                                'observacion',CAST(observacion AS CHAR(100000)),
                                'idconfig_prueba',CAST(idconfig_prueba AS CHAR(100000))),
                                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c')) autentico
                                FROM 
                                resultados r
                                WHERE 
                                r.idprueba=$idprueba and 
                                r.observacion='OBSERVACIONLABRADO';");
        return $rta;
    }

    function getHojaPruebas($idprueba) {
        $rta = $this->db->query("SELECT 
                'setHojaPruebas' funcionSet,h.* 
                FROM 
                pruebas p,hojatrabajo h 
                WHERE 
                h.idhojapruebas=p.idhojapruebas AND 
                p.idprueba=$idprueba");
        $r = $rta->result();
        return $r[0];
    }

    function getPruebasAsignadas($idhojapruebas, $reinspeccion) {
        $orderBy = 'DESC';
        if ($reinspeccion == '0' || $reinspeccion == '4444' || $reinspeccion == '8888') {
            $orderBy = '';
        }
        $fechaInicial = $this->getFechaInicial($idhojapruebas, $reinspeccion);
        $rta = $this->db->query("SELECT 
                p.idprueba, 
                p.idhojapruebas, 
                p.fechainicial, 
                p.prueba, 
                p.estado, 
                p.fechafinal, 
                p.idmaquina, 
                p.idusuario, 
                p.idtipo_prueba
                FROM 
                pruebas p
                WHERE 
                p.idhojapruebas=$idhojapruebas and
                (p.estado<>5 and p.estado<>3) and
                (p.fechainicial='$fechaInicial' or  p.fechainicial between '$fechaInicial' and DATE_ADD('$fechaInicial',INTERVAL 120 MINUTE))
                GROUP BY p.prueba,p.idtipo_prueba
                ORDER BY 1 $orderBy");
        return $rta;
    }

    function getFechaInicial($idhojapruebas, $reins) {
        $l = '';
        if ($reins == '1' || $reins == '44441') {
            $l = ',1';
        }
        $query = $this->db->query("
            SELECT  
                p.fechainicial,COUNT(*) c
            FROM 
            pruebas p 
            WHERE 
            p.idhojapruebas=$idhojapruebas
            GROUP BY 1 ORDER BY 2 DESC LIMIT 1$l");
        $r = $query->result();
        return $r[0]->fechainicial;
    }

    function actualizarPruebaXMaq($idprueba, $idmaquina, $idusuario) {
        $this->db->set('idmaquina', $idmaquina, false);
        $this->db->set('fechainicial', 'fechainicial', false);
        $tipoPrueba = $this->getTipoPrueba($idprueba);
        if ($tipoPrueba == '12' ||
                $tipoPrueba == '13' ||
                $tipoPrueba == '14' ||
                $tipoPrueba == '15' ||
                $tipoPrueba == '16' ||
                $tipoPrueba == '17' ||
                $tipoPrueba == '18' ||
                $tipoPrueba == '19') {
            $this->db->set('estado', '2', false);
            $this->db->set('idusuario', $idusuario, false);
            $this->db->set('fechafinal', 'now()', false);
        }
        $this->db->where('idprueba', $idprueba);
        $this->db->update('pruebas');
        $this->updateEnc($idprueba);
    }

    function getTipoPrueba($idprueba) {
        $rta = $this->db->query("SELECT p.idtipo_prueba FROM pruebas p WHERE p.idprueba=$idprueba");
        $r = $rta->result();
        return $r[0]->idtipo_prueba;
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

}
