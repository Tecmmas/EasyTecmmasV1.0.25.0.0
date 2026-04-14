<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MPrueba extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    var $key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c';


    function guardarResultado($resultados) {
        echo $this->db->insert('resultados', $resultados);
    }

    function actualizarPrueba($pruebas) {
        $this->db->where('idprueba', $pruebas['idprueba']);
        echo $this->db->update('pruebas', $pruebas);
        $this->updateEnc($pruebas['idprueba']);
    }

    function guardarAuditoria($auditoria_sicov) {
        echo $this->db->insert('auditoria_sicov', $auditoria_sicov);
    }

    function getHojaPruebas($idHojaPruebas) {
        $this->db->where('idhojapruebas', $idHojaPruebas);
        $query = $this->db->get('hojatrabajo', 1);
        return $query->result();
    }

    function getPruebas($idPrueba) {
        $this->db->where('idprueba', $idPrueba);
        $query = $this->db->get('pruebas', 1);
        return $query->result();
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
