<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mresultado extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $idprueba = $data['idprueba'];
        $tiporesultado = $data['tiporesultado'];
//        $order = $data['order'];
        $observacion = $data['observacion'];
        $query = $this->db->query("
            SELECT
                *,JSON_CONTAINS(JSON_OBJECT(
                'idprueba',CAST(r.idprueba AS CHAR(100000)),
                'tiporesultado',CAST(r.tiporesultado AS CHAR(100000)),
                'valor',CAST(r.valor AS CHAR(100000)),
                'fechaguardado',CAST(r.fechaguardado AS CHAR(100000)),
                'observacion',CAST(r.observacion AS CHAR(100000)),
                'idconfig_prueba',CAST(r.idconfig_prueba AS CHAR(100000))),
                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c')) autentico,
                JSON_OBJECT(
                'idprueba',CAST(r.idprueba AS CHAR(100000)),
                'tiporesultado',CAST(r.tiporesultado AS CHAR(100000)),
                'valor',CAST(r.valor AS CHAR(100000)),
                'fechaguardado',CAST(r.fechaguardado AS CHAR(100000)),
                'observacion',CAST(r.observacion AS CHAR(100000)),
                'idconfig_prueba',CAST(r.idconfig_prueba AS CHAR(100000))) new,
                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c') old
            FROM
                resultados r
            WHERE
                r.idprueba = $idprueba and
                r.tiporesultado = '$tiporesultado'
                $observacion
            ORDER BY 1 DESC
            LIMIT 1");
        return $query;
    }

    function getIdprueba($idprueba, $tiporesultado) {
        $query = $this->db->query("
            SELECT
                *,JSON_CONTAINS(JSON_OBJECT(
                'idprueba',CAST(r.idprueba AS CHAR(100000)),
                'tiporesultado',CAST(r.tiporesultado AS CHAR(100000)),
                'valor',CAST(r.valor AS CHAR(100000)),
                'fechaguardado',CAST(r.fechaguardado AS CHAR(100000)),
                'observacion',CAST(r.observacion AS CHAR(100000)),
                'idconfig_prueba',CAST(r.idconfig_prueba AS CHAR(100000))),
                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c')) autentico,
                JSON_OBJECT(
                'idprueba',CAST(r.idprueba AS CHAR(100000)),
                'tiporesultado',CAST(r.tiporesultado AS CHAR(100000)),
                'valor',CAST(r.valor AS CHAR(100000)),
                'fechaguardado',CAST(r.fechaguardado AS CHAR(100000)),
                'observacion',CAST(r.observacion AS CHAR(100000)),
                'idconfig_prueba',CAST(r.idconfig_prueba AS CHAR(100000))) new,
                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c') old
            FROM
                resultados r
            WHERE
                r.idprueba = $idprueba and
                r.tiporesultado = '$tiporesultado'
            ORDER BY 1
            LIMIT 1");
        return $query;
    }

    function getxIdprueba($idprueba) {
        $query = $this->db->query("
            SELECT
              v.numero_placa,
              abs(round(v.diametro_escape * 10,1)) AS  'LTOE',
				  IFNULL((SELECT if(v.tipo_vehiculo = 1,'4983',if(v.tipo_vehiculo = 2,'4231', '5365')) FROM vehiculos v WHERE v.idvehiculo = h.idvehiculo ), '---') AS 'norma',
                                  				  ifnull((select 'SI' from resultados where idprueba=p.idprueba and tiporesultado='defecto' and valor=341  order by 1 desc limit 1),'NO') AS 'Falla_por_temperatura_motor_disel',
				    r.idconfig_prueba,r.tiporesultado, r.valor
FROM
                vehiculos v, hojatrabajo h, pruebas p, resultados r
WHERE
            v.idvehiculo = h.idvehiculo  AND h.idhojapruebas = p.idhojapruebas AND p.idprueba = r.idprueba AND 
            p.idprueba = $idprueba");
        return $query;
    }

    function getTmpMot($data) {
        $idprueba = $data['idprueba'];
        $tiporesultado = $data['tiporesultado'];
        $order = $data['order'];
        $observacion = $data['observacion'];
        $query = $this->db->query("
            SELECT
                *,JSON_CONTAINS(JSON_OBJECT(
                'idprueba',CAST(r.idprueba AS CHAR(100000)),
                'tiporesultado',CAST(r.tiporesultado AS CHAR(100000)),
                'valor',CAST(r.valor AS CHAR(100000)),
                'fechaguardado',CAST(r.fechaguardado AS CHAR(100000)),
                'observacion',CAST(r.observacion AS CHAR(100000)),
                'idconfig_prueba',CAST(r.idconfig_prueba AS CHAR(100000))),
                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c')) autentico,
                JSON_OBJECT(
                'idprueba',CAST(r.idprueba AS CHAR(100000)),
                'tiporesultado',CAST(r.tiporesultado AS CHAR(100000)),
                'valor',CAST(r.valor AS CHAR(100000)),
                'fechaguardado',CAST(r.fechaguardado AS CHAR(100000)),
                'observacion',CAST(r.observacion AS CHAR(100000)),
                'idconfig_prueba',CAST(r.idconfig_prueba AS CHAR(100000))) new,
                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c') old
            FROM
                resultados r
            WHERE
                r.idprueba = $idprueba and
                r.valor <> '0' and    
                r.tiporesultado = '$tiporesultado'
                $observacion
            ORDER BY 1 $order
            LIMIT 1");
        return $query;
    }

    function getDefT($data) {
        $idprueba = $data['idprueba'];
        $tiporesultado = $data['tiporesultado'];
        $valor = $data['valor'];
        $order = $data['order'];
        $query = $this->db->query("
            SELECT
                *,JSON_CONTAINS(JSON_OBJECT(
                'idprueba',CAST(r.idprueba AS CHAR(100000)),
                'tiporesultado',CAST(r.tiporesultado AS CHAR(100000)),
                'valor',CAST(r.valor AS CHAR(100000)),
                'fechaguardado',CAST(r.fechaguardado AS CHAR(100000)),
                'observacion',CAST(r.observacion AS CHAR(100000)),
                'idconfig_prueba',CAST(r.idconfig_prueba AS CHAR(100000))),
                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c')) autentico,
                JSON_OBJECT(
                'idprueba',CAST(r.idprueba AS CHAR(100000)),
                'tiporesultado',CAST(r.tiporesultado AS CHAR(100000)),
                'valor',CAST(r.valor AS CHAR(100000)),
                'fechaguardado',CAST(r.fechaguardado AS CHAR(100000)),
                'observacion',CAST(r.observacion AS CHAR(100000)),
                'idconfig_prueba',CAST(r.idconfig_prueba AS CHAR(100000))) new,
                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c') old
            FROM
                resultados r
            WHERE
                r.idprueba = $idprueba and
                r.tiporesultado = '$tiporesultado' and
                r.valor = '$valor'
            ORDER BY 1 $order
            LIMIT 1");
        return $query;
    }

    function getIDCP($data) {
        $idprueba = $data['idprueba'];
        $idconfig_prueba = $data['idconfig_prueba'];
        $order = $data['order'];
        $query = $this->db->query("
            SELECT
                *,JSON_CONTAINS(JSON_OBJECT(
                'idprueba',CAST(r.idprueba AS CHAR(100000)),
                'tiporesultado',CAST(r.tiporesultado AS CHAR(100000)),
                'valor',CAST(r.valor AS CHAR(100000)),
                'fechaguardado',CAST(r.fechaguardado AS CHAR(100000)),
                'observacion',CAST(r.observacion AS CHAR(100000)),
                'idconfig_prueba',CAST(r.idconfig_prueba AS CHAR(100000))),
                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c')) autentico,
                JSON_OBJECT(
                'idprueba',CAST(r.idprueba AS CHAR(100000)),
                'tiporesultado',CAST(r.tiporesultado AS CHAR(100000)),
                'valor',CAST(r.valor AS CHAR(100000)),
                'fechaguardado',CAST(r.fechaguardado AS CHAR(100000)),
                'observacion',CAST(r.observacion AS CHAR(100000)),
                'idconfig_prueba',CAST(r.idconfig_prueba AS CHAR(100000))) new,
                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c') old
            FROM
                resultados r
            WHERE
                r.idprueba = $idprueba and
                r.idconfig_prueba = '$idconfig_prueba'
            ORDER BY 1 $order
            LIMIT 1");
        return $query;
    }

    function getIDCP_tipo($data) {
        $idprueba = $data['idprueba'];
        $tiporesultado = $data['tiporesultado'];
        $idconfig_prueba = $data['idconfig_prueba'];
        $order = $data['order'];
        $query = $this->db->query("
            SELECT
                *,JSON_CONTAINS(JSON_OBJECT(
                'idprueba',CAST(r.idprueba AS CHAR(100000)),
                'tiporesultado',CAST(r.tiporesultado AS CHAR(100000)),
                'valor',CAST(r.valor AS CHAR(100000)),
                'fechaguardado',CAST(r.fechaguardado AS CHAR(100000)),
                'observacion',CAST(r.observacion AS CHAR(100000)),
                'idconfig_prueba',CAST(r.idconfig_prueba AS CHAR(100000))),
                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c')) autentico,
                JSON_OBJECT(
                'idprueba',CAST(r.idprueba AS CHAR(100000)),
                'tiporesultado',CAST(r.tiporesultado AS CHAR(100000)),
                'valor',CAST(r.valor AS CHAR(100000)),
                'fechaguardado',CAST(r.fechaguardado AS CHAR(100000)),
                'observacion',CAST(r.observacion AS CHAR(100000)),
                'idconfig_prueba',CAST(r.idconfig_prueba AS CHAR(100000))) new,
                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c') old
            FROM
                resultados r
            WHERE
                r.idprueba = $idprueba and
                r.tiporesultado = '$tiporesultado' and
                r.idconfig_prueba = '$idconfig_prueba'
            ORDER BY 1 $order
            LIMIT 1");
        return $query;
    }

    function getDef($data) {
        $idprueba = $data['idprueba'];
        $tiporesultado = $data['tiporesultado'];
        $idconfig_prueba = $data['idconfig_prueba'];
        $order = $data['order'];
        $query = $this->db->query("
            SELECT
                *,JSON_CONTAINS(JSON_OBJECT(
                'idprueba',CAST(r.idprueba AS CHAR(100000)),
                'tiporesultado',CAST(r.tiporesultado AS CHAR(100000)),
                'valor',CAST(r.valor AS CHAR(100000)),
                'fechaguardado',CAST(r.fechaguardado AS CHAR(100000)),
                'observacion',CAST(r.observacion AS CHAR(100000)),
                'idconfig_prueba',CAST(r.idconfig_prueba AS CHAR(100000))),
                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c')) autentico,
                JSON_OBJECT(
                'idprueba',CAST(r.idprueba AS CHAR(100000)),
                'tiporesultado',CAST(r.tiporesultado AS CHAR(100000)),
                'valor',CAST(r.valor AS CHAR(100000)),
                'fechaguardado',CAST(r.fechaguardado AS CHAR(100000)),
                'observacion',CAST(r.observacion AS CHAR(100000)),
                'idconfig_prueba',CAST(r.idconfig_prueba AS CHAR(100000))) new,
                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c') old
            FROM
                resultados r
            WHERE
                r.idprueba = $idprueba and
                (r.tiporesultado = '$tiporesultado' OR  r.tiporesultado = 'COMENTARIOSADICIONALES') and
                r.idconfig_prueba = '$idconfig_prueba'
            ORDER BY 1 $order");
        return $query;
    }

    function getObses($idprueba) {
//        $idconfig_prueba = '77';
        $query = $this->db->query("
            SELECT
                *,JSON_CONTAINS(JSON_OBJECT(
                'idprueba',CAST(r.idprueba AS CHAR(100000)),
                'tiporesultado',CAST(r.tiporesultado AS CHAR(100000)),
                'valor',CAST(r.valor AS CHAR(100000)),
                'fechaguardado',CAST(r.fechaguardado AS CHAR(100000)),
                'observacion',CAST(r.observacion AS CHAR(100000)),
                'idconfig_prueba',CAST(r.idconfig_prueba AS CHAR(100000))),
                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c')) autentico,
                JSON_OBJECT(
                'idprueba',CAST(r.idprueba AS CHAR(100000)),
                'tiporesultado',CAST(r.tiporesultado AS CHAR(100000)),
                'valor',CAST(r.valor AS CHAR(100000)),
                'fechaguardado',CAST(r.fechaguardado AS CHAR(100000)),
                'observacion',CAST(r.observacion AS CHAR(100000)),
                'idconfig_prueba',CAST(r.idconfig_prueba AS CHAR(100000))) new,
                AES_DECRYPT(r.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c') old
            FROM
                resultados r
            WHERE
                r.idprueba = $idprueba and
                (r.idconfig_prueba = 77 or  r.idconfig_prueba = 96) 
            ORDER BY 1 DESC");
        return $query;
    }

    function getSumFuerzaAux($data) {
        $idprueba = $data['idprueba'];
        $tiporesultado = $data['tiporesultado'];
        $idconfig_prueba = $data['idconfig_prueba'];
        $order = $data['order'];
        $query = $this->db->query("
            SELECT 
                sum(r.valor) valor
                FROM 
                resultados r 
                WHERE 
                r.tiporesultado>$tiporesultado AND 
                r.idprueba=$idprueba AND 
                r.idconfig_prueba=$idconfig_prueba 
                GROUP BY r.idconfig_prueba
                ORDER BY 1 $order");
        return $query;
    }

    function getMaxGases($data) {
        $idprueba = $data['idprueba'];
        $idhojapruebas = $data['idhojapruebas'];
        $tiporesultado = $data['tiporesultado'];
//        $order = $data['order'];
//        $observacion = $data['observacion'];
        
        $query = $this->db->query("
            SELECT 
                max(cast(r.valor AS decimal(20, 2))) valor
                FROM 
                resultados r, 
                pruebas p 
                WHERE 
                r.tiporesultado='$tiporesultado' AND 
                p.prueba=$idprueba AND 
                r.idprueba=p.idprueba AND 
                p.idhojapruebas=$idhojapruebas
                order by r.fechaguardado desc limit 1");
        return $query;
    }

    function getMaxRpmGases($data) {
        $idprueba = $data['idprueba'];
        $idhojapruebas = $data['idhojapruebas'];
        $query = $this->db->query("
            SELECT 
                max(cast(r.valor AS decimal(20, 2))) valor
                FROM 
                resultados r, 
                pruebas p 
                WHERE 
                r.tiporesultado='T' AND 
                r.valor='332' AND 
                p.prueba=$idprueba AND 
                r.idprueba=p.idprueba AND 
                p.idhojapruebas=$idhojapruebas
                order by r.fechaguardado desc limit 1");
        return $query;
    }

}
