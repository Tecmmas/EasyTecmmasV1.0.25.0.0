<?php

class PruebasModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    var $key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c';

    public function get($estado, $idtipo_prueba, $idhojapruebas) {
        $data = $this->db->query("
            SELECT 
                p.idprueba
            FROM 
                pruebas p
            WHERE 
                p.estado=$estado and
                p.idtipo_prueba=$idtipo_prueba and
                p.idhojapruebas=$idhojapruebas
            ORDER BY
                1 desc
            LIMIT
                1");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    public function update($data) {
        $this->db->set('fechafinal', 'NOW()', FALSE);
        $this->db->set('fechainicial', 'fechainicial', FALSE);
        $this->db->where('idprueba', $data['idprueba']);
        $this->db->update('pruebas', $data);
        $this->updateEnc($data['idprueba']);
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
