<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mprueba extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
        $this->myforge = $this->load->dbforge($this->db, TRUE);
    }

    var $key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c';

    function get($data) {
        $idhojapruebas = $data['idhojapruebas'];
        $idtipo_prueba = $data['idtipo_prueba'];
        $order = $data['order'];
        $query = $this->db->query("
            SELECT
                p.idprueba, p.idhojapruebas, p.fechainicial, p.prueba, p.estado, p.fechafinal, p.idmaquina, p.idusuario, p.idtipo_prueba,JSON_CONTAINS(JSON_OBJECT(
                'idhojapruebas',CAST(p.idhojapruebas AS CHAR(100000)),
                'fechainicial',CAST(p.fechainicial AS CHAR(100000)),
                'prueba',CAST(p.prueba AS CHAR(100000)),
                'estado',CAST(p.estado AS CHAR(100000)),
                'fechafinal',CAST(p.fechafinal AS CHAR(100000)),
                'idmaquina',CAST(p.idmaquina AS CHAR(100000)),
                'idusuario',CAST(p.idusuario AS CHAR(100000)),
                'idtipo_prueba',CAST(p.idtipo_prueba AS CHAR(100000))),
                AES_DECRYPT(p.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c')) autentico,
                JSON_OBJECT(
                'idhojapruebas',CAST(p.idhojapruebas AS CHAR(100000)),
                'fechainicial',CAST(p.fechainicial AS CHAR(100000)),
                'prueba',CAST(p.prueba AS CHAR(100000)),
                'estado',CAST(p.estado AS CHAR(100000)),
                'fechafinal',CAST(p.fechafinal AS CHAR(100000)),
                'idmaquina',CAST(p.idmaquina AS CHAR(100000)),
                'idusuario',CAST(p.idusuario AS CHAR(100000)),
                'idtipo_prueba',CAST(p.idtipo_prueba AS CHAR(100000))) new,
                AES_DECRYPT(p.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c') old
            FROM
                pruebas p
            WHERE
                p.idhojapruebas = $idhojapruebas and
                p.idtipo_prueba = $idtipo_prueba and
                (p.estado <> 5 and p.estado <> 9)
            ORDER BY 1 $order
            LIMIT 1");
        return $query;
    }

    function getOperariosSensorial($idprueba) {
        $count = <<<EOF
               SELECT 
                  u.IdUsuario
                FROM 
                operario_sensorial os,
                usuarios u
                WHERE
                os.idprueba=$idprueba AND
                os.idusuario=u.IdUsuario
                GROUP BY 1                
EOF;
        $r = $this->db->query($count);
        if ($r->num_rows() > 1) {
            $consulta = <<<EOF
               SELECT
               CASE
                   WHEN os.idsensorial=1  THEN "Inspección visual (Revision exterior)"
                   WHEN os.idsensorial=2  THEN "Inspección visual (Vidrios)"
                   WHEN os.idsensorial=3  THEN "Inspección visual (Rines y llantas)"
                   WHEN os.idsensorial=4  THEN "Inspección visual (Dirección)"
                   WHEN os.idsensorial=5  THEN "Inspección visual (Motor, tansmisión y combustible)"
                   WHEN os.idsensorial=6  THEN "Inspección visual (Revisión interior)"
                   WHEN os.idsensorial=7  THEN "Inspección visual (Emisiones(gases, elementos para producir ruido))"
                   WHEN os.idsensorial=8  THEN "Inspección visual (Luces)"
                   WHEN os.idsensorial=9  THEN "Inspección visual (Salida de emergencia)"
                   WHEN os.idsensorial=10  THEN "Inspección visual (Frenos)"
                   WHEN os.idsensorial=11  THEN "Inspección visual (Suspensión (suspensión, rines y llantas))"
                   WHEN os.idsensorial=12  THEN "Inspección visual (Taxímetros)"
                   WHEN os.idsensorial=13  THEN "Inspección visual (Placas laterales)"
                   WHEN os.idsensorial=14  THEN "Inspección visual (Enseñanza)"
                   WHEN os.idsensorial=15  THEN "Inspección visual (Profundidad de labrado)"
                   ELSE "Inspección visual"
                END sensorial ,
                CONCAT( u.nombres,' ',u.apellidos) operario
                FROM 
                operario_sensorial os,
                usuarios u
                WHERE
                os.idprueba=$idprueba AND
                os.idusuario=u.IdUsuario
EOF;
            $rta = $this->db->query($consulta);
            return $rta->result();
        } else {
            return '';
        }
    }

    function getxId($idprueba) {
        $query = $this->db->query("
            SELECT
                *,JSON_CONTAINS(JSON_OBJECT(
                'idhojapruebas',CAST(p.idhojapruebas AS CHAR(100000)),
                'fechainicial',CAST(p.fechainicial AS CHAR(100000)),
                'prueba',CAST(p.prueba AS CHAR(100000)),
                'estado',CAST(p.estado AS CHAR(100000)),
                'fechafinal',CAST(p.fechafinal AS CHAR(100000)),
                'idmaquina',CAST(p.idmaquina AS CHAR(100000)),
                'idusuario',CAST(p.idusuario AS CHAR(100000)),
                'idtipo_prueba',CAST(p.idtipo_prueba AS CHAR(100000))),
                AES_DECRYPT(p.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c')) autentico,
                JSON_OBJECT(
                'idhojapruebas',CAST(p.idhojapruebas AS CHAR(100000)),
                'fechainicial',CAST(p.fechainicial AS CHAR(100000)),
                'prueba',CAST(p.prueba AS CHAR(100000)),
                'estado',CAST(p.estado AS CHAR(100000)),
                'fechafinal',CAST(p.fechafinal AS CHAR(100000)),
                'idmaquina',CAST(p.idmaquina AS CHAR(100000)),
                'idusuario',CAST(p.idusuario AS CHAR(100000)),
                'idtipo_prueba',CAST(p.idtipo_prueba AS CHAR(100000))) new,
                AES_DECRYPT(p.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c') old
            FROM
                pruebas p
            WHERE
                p.idprueba = $idprueba");
        return $query;
    }

    function getMaq($data) {
        $idhojapruebas = $data['idhojapruebas'];
        $idtipo_prueba = $data['idtipo_prueba'];
//        $fechainicial = $data['fechainicial'];
        $order = $data['order'];
        if ($order == 'DESC') {
            $query = $this->db->query("
            SELECT 
            IF((SELECT COUNT(*) FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 and p.estado <> 9 AND p.idtipo_prueba=$idtipo_prueba)>1,
            (SELECT p.idmaquina FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 and p.estado <> 9 AND p.estado<>3 AND p.idtipo_prueba=$idtipo_prueba ORDER BY p.idprueba DESC LIMIT 1),'') idmaquina,
            IF((SELECT COUNT(*) FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 and p.estado <> 9 AND p.idtipo_prueba=$idtipo_prueba)>1,
            (SELECT p.idusuario FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 and p.estado <> 9 AND p.estado<>3 AND p.idtipo_prueba=$idtipo_prueba ORDER BY p.idprueba DESC LIMIT 1),'') idusuario");
        } else {
            $query = $this->db->query("
            SELECT 
            (SELECT p.idmaquina FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 and p.estado <> 9 AND p.idtipo_prueba=$idtipo_prueba ORDER BY p.idprueba LIMIT 1) idmaquina,
            (SELECT p.idusuario FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 and p.estado <> 9 AND p.idtipo_prueba=$idtipo_prueba ORDER BY p.idprueba LIMIT 1) idusuario");
        }
        return $query;
    }

//    function getMaq($data) {
//        $idhojapruebas = $data['idhojapruebas'];
//        $idtipo_prueba = $data['idtipo_prueba'];
//        $fechainicial = $data['fechainicial'];
//        $order = $data['order'];
//        $query = $this->db->query("
//            SELECT
//                *
//            FROM
//                pruebas p
//            WHERE
//                p.idhojapruebas = $idhojapruebas and
//                p.idtipo_prueba = $idtipo_prueba and
//                p.fechainicial = '$fechainicial' and
//                (p.estado <> 5)
//            ORDER BY 1 $order
//            LIMIT 1");
//        return $query;
//    }

    function get5($data) {
        $idhojapruebas = $data['idhojapruebas'];
        $idtipo_prueba = $data['idtipo_prueba'];
        $order = $data['order'];
        $where = "(p.estado <> 0 and p.estado <> 5 and p.estado <> 9)";
        if ($order === 'DESC') {
            $where = "(p.estado <> 0 and p.estado <> 5 and p.estado <> 9 and p.estado <> 3)";
        }
        $query = $this->db->query("
            SELECT
                *
            FROM
                pruebas p
            WHERE
                p.idhojapruebas = $idhojapruebas and
                p.idtipo_prueba = $idtipo_prueba and
                 $where
            ORDER BY p.fechainicial, p.prueba asc
            LIMIT 2");
        return $query;
    }

    function get55maquina($data) {
        $idhojapruebas = $data['idhojapruebas'];
        $idtipo_prueba = $data['idtipo_prueba'];
        $order = $data['order'];
        $query = $this->db->query("
            SELECT
                m.*
            FROM
                pruebas p, maquina m
            WHERE
                p.idhojapruebas = $idhojapruebas and
                m.idmaquina=p.idmaquina and
                m.idtipo_prueba=$idtipo_prueba and
                p.idtipo_prueba = '55' and
                (p.estado <> 0 and p.estado <> 5 and p.estado <> 9)
            ORDER BY 1 $order
            LIMIT 1");
        return $query;
    }

    function getInspectores($data) {
        $idhojapruebas = $data['idhojapruebas'];
        $query = $this->db->query("
            SELECT 
                CONCAT(tp.nombre,'-',u.nombres,' ',u.apellidos) operarios
            FROM 
                pruebas p,usuarios u,tipo_prueba tp,maquina m
            WHERE 
                p.idhojapruebas=$idhojapruebas AND
                m.idtipo_prueba=tp.idtipo_prueba AND
                p.idmaquina=m.idmaquina AND
                u.IdUsuario=p.idusuario 
            GROUP BY 1");
        return $query;
    }

    function getInspector($data) {
        $idhojapruebas = $data['idhojapruebas'];
        $query = $this->db->query("
            SELECT 
                CONCAT(tp.nombre,'-',u.nombres,' ',u.apellidos) operarios
            FROM 
                pruebas p,usuarios u,tipo_prueba tp,maquina m
            WHERE 
                p.idhojapruebas=$idhojapruebas AND
                m.idtipo_prueba=tp.idtipo_prueba AND
                p.idmaquina=m.idmaquina AND
                u.IdUsuario=p.idusuario 
            GROUP BY 1");
        return $query;
    }

    function getLast($data) {
        $idhojapruebas = $data['idhojapruebas'];
        $query = $this->db->query("
            SELECT
                *
            FROM
                pruebas p
            WHERE
                p.idhojapruebas = $idhojapruebas and
               (p.estado <> 0 and p.estado <> 5 and p.estado <> 9) and
                p.idtipo_prueba<>21 AND p.idtipo_prueba<>22
            ORDER BY p.fechainicial DESC
            LIMIT 1");
        return $query;
    }

    function getLastFecha($data, $order) {
        $idhojapruebas = $data['idhojapruebas'];
        $query = $this->db->query("
            SELECT 
                max(p.fechafinal) fechafinal
                FROM 
                pruebas p 
                WHERE 
                p.idhojapruebas=$idhojapruebas AND
                (p.estado <> 0 and p.estado <> 5 and p.estado <> 9) and
                p.idtipo_prueba<>21 AND p.idtipo_prueba<>22
                GROUP BY p.fechainicial ORDER BY p.fechainicial $order LIMIT 1");
        return $query;
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

    function insert($data, $juez) {
        $this->db->trans_start();
        $key = $this->key;
        $idhojapruebas = $data['idhojapruebas'];
        $fechainicial = $data['fechainicial'];
        $prueba = $data['prueba'];
        $estado = $data['estado'];
        $fechafinal = $data['fechafinal'];
        $idmaquina = null;
        $idusuario = $data['idusuario'];
        $idtipo_prueba = $data['idtipo_prueba'];
        $pru['idhojapruebas'] = "$idhojapruebas";
        $pru['fechainicial'] = $fechainicial;
        $pru['prueba'] = $prueba;
        $pru['estado'] = $estado;
        $pru['fechafinal'] = $fechafinal;
        $pru['idmaquina'] = $idmaquina;
        $pru['idusuario'] = $idusuario;
        $pru['idtipo_prueba'] = $idtipo_prueba;
        $enc = json_encode($pru);
        $Q = <<<EOF
        INSERT INTO 
        pruebas
        VALUES
        (null,'$idhojapruebas','$fechainicial','$prueba','$estado',NULL,NULL,'$idusuario','$idtipo_prueba', AES_ENCRYPT('$enc','$key'))
EOF;
        $this->db->query($Q);
        $this->db->trans_complete();
    }

    function update($data) {
        unset($data['fechainicial']);
        unset($data['fechafinal']);
        unset($data['idusuario']);
//        unset($data['idmaquina']);
        unset($data['estado']);
        $this->db->set('fechainicial', 'fechainicial', FALSE);
        $this->db->set('fechafinal', 'fechafinal', FALSE);
        $this->db->set('idusuario', 'idusuario', FALSE);
//        $this->db->set('idmaquina', 'idmaquina', FALSE);
        $this->db->set('estado', '3', FALSE);
        $this->db->where('idhojapruebas', $data['idhojapruebas']);
        $this->db->where('idtipo_prueba', $data['idtipo_prueba']);
        $this->db->where('prueba', $data['prueba']);
        $this->db->where('estado', '1');
        $this->db->where('estado <>', '5');
        $this->db->where('estado <>', '9');
        $this->db->update('pruebas', $data);
        $this->updateEnc3($data['idhojapruebas'], $data['idtipo_prueba'], $data['prueba']);
    }

    function update_($data) {
        unset($data['fechainicial']);
        unset($data['fechafinal']);
        unset($data['idusuario']);
        unset($data['estado']);
        $this->db->set('fechainicial', 'fechainicial', FALSE);
        $this->db->set('fechafinal', 'fechafinal', FALSE);
        $this->db->set('idusuario', 'idusuario', FALSE);
        $this->db->set('estado', '3', FALSE);
        $this->db->where('idhojapruebas', $data['idhojapruebas']);
        $this->db->where('idtipo_prueba', $data['idtipo_prueba']);
        $this->db->where('prueba', $data['prueba']);
        $this->db->where('estado <>', '5');
        $this->db->where('estado <>', '9');
        $this->db->update('pruebas', $data);
        $this->updateEnc3($data['idhojapruebas'], $data['idtipo_prueba'], $data['prueba']);
    }

    function update_B($idprueba) {
        $this->db->set('fechainicial', 'fechainicial', FALSE);
        $this->db->set('fechafinal', 'fechafinal', FALSE);
        $this->db->set('idusuario', 'idusuario', FALSE);
        $this->db->set('estado', '1', FALSE);
        $this->db->where('idprueba', $idprueba);
        $this->db->update('pruebas');
        $this->updateEnc($idprueba);
    }

    function update_XExosto($valor, $idprueba, $idhojatrabajo) {
        $this->db->query("
            UPDATE 
                pruebas 
                SET 
                prueba=$valor,fechainicial=fechainicial
                WHERE 
                idprueba=$idprueba and
                idhojapruebas=$idhojatrabajo AND
                idtipo_prueba=3 AND
                (estado=1 OR estado=2) AND
                prueba<>0;");
//        $query->result();
        $this->updateEnc($idprueba);
    }

    function actualizarEstado($idprueba, $estado) {
        $this->db->set('fechainicial', 'fechainicial', FALSE);
        $this->db->set('fechafinal', 'fechafinal', FALSE);
        $this->db->set('idusuario', 'idusuario', FALSE);
        $this->db->set('estado', $estado, FALSE);
        $this->db->where('idprueba', $idprueba);
        $this->db->update('pruebas');
        $this->updateEnc($idprueba);
    }

    function eliminarPrueba($data) {
        $this->db->where('idhojapruebas', $data['idhojapruebas']);
        $this->db->where('fechainicial', $data['fechainicial']);
        $this->db->where('idtipo_prueba', $data['idtipo_prueba']);
        $this->db->delete('pruebas');
    }

    function eliminarPruebaID($data) {
        $this->db->where('idprueba', $data['idprueba']);
        $this->db->delete('pruebas');
    }

    function desencrypt_MULTI($string) {
        $key = "Jik8ThGv5TrVkIolM45YtfvEdgYhjukL";
        $iv = "hjsyduiohjsyduio";
        $output = openssl_decrypt($string, 'AES-256-CBC', $key, 0, $iv);
        return $output;
    }

    function encrypt_MULTI($string) {
        $key = "Jik8ThGv5TrVkIolM45YtfvEdgYhjukL";
        $iv = "hjsyduiohjsyduio";
        $output = openssl_encrypt($string, 'AES-256-CBC', $key, 0, $iv);
        return $output;
    }

    function insertVisor($vehiculo) {
        $this->db->trans_start();
        $cadena = $this->db->query("insert visor values (null, " . $vehiculo['idhojapruebas'] . ", " . $vehiculo['reinspeccion'] . "," . $vehiculo['servicio'] . ", '" . $vehiculo['placa'] . "'," . $vehiculo['luces'] . ", " . $vehiculo['gases'] . "," . $vehiculo['opacidad'] . ", " . $vehiculo['sonometro'] . ", " . $vehiculo['visual'] . ", " . $vehiculo['camara0'] . ", " . $vehiculo['camara1'] . ", " . $vehiculo['alineacion'] . ", " . $vehiculo['frenos'] . ", " . $vehiculo['suspension'] . ", " . $vehiculo['taximetro'] . ",0,0,1, NOW())");
        $this->db->trans_complete();
    }

    public function creteTableVisor() {
        $fields = array(
            'idvisor' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'idhojapruebas' => array(
                'type' => 'INT',
                'constraint' => '10',
                'null' => FALSE,
            ),
            'reinspeccion' => array(
                'type' => 'INT',
                'constraint' => '10',
                'null' => FALSE,
            ),
            'servicio' => array(
                'type' => 'INT',
                'constraint' => '10',
                'null' => FALSE,
            ),
            'placa' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => FALSE,
            ),
            'luces' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ),
            'gases' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ),
            'opacidad' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ),
            'sonometro' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ),
            'visual' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ),
            'camara0' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ),
            'camara1' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ),
            'alineacion' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ),
            'frenos' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ),
            'suspension' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ),
            'taximetro' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ),
            'certificado' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ),
            'sicov' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ),
            'estadototal' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ),
            'fecha' => array(
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ),
        );
        $this->myforge->add_key('idvisor', TRUE);
        $this->myforge->add_field($fields);
        $attributes = array('ENGINE' => 'MyISAM');
        $this->myforge->create_table('visor', TRUE, $attributes);
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
        if ($query2->num_rows() !== 0) {
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

    function updateEnc3($idhojapruebas, $idtipo_prueba, $prueba) {
        $query2 = $this->db->query("SELECT * FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas and p.idtipo_prueba=$idtipo_prueba and p.prueba=$prueba and p.estado=3 LIMIT 1");
//            echo "SELECT * FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas and p.idtipo_prueba=$idtipo_prueba and p.prueba=$prueba and p.estado=3 LIMIT 1";
        if ($query2->num_rows() !== 0) {
            $pru = $query2->result();
            $pruebas['idprueba'] = $pru[0]->idprueba;
            $idprueba = $pruebas['idprueba'];
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

}
