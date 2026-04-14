<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mcamara extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    var $key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJVadQssw5c';

    function getFotos($idhojapruebas) {
        $rta = $this->db->query("SELECT 
                                'cam' tipo_consulta,p.* 
                                FROM 
                                pruebas p 
                                WHERE 
                                p.estado=0 and
                                p.idtipo_prueba=5 and
                                p.idhojapruebas=$idhojapruebas LIMIT 2;");
        $r = $rta->result();
        $r[0]->enc="";
        return $r[0];
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

    function getFoto($idhojapruebas, $order, $prueba) {
        $rta = $this->db->query("SELECT 
                'setFoto' funcionSet,p.idprueba,
                IFNULL((SELECT i.imagen FROM imagenes i WHERE i.idprueba=p.idprueba LIMIT 1) ,'') foto,p.prueba
                FROM 
                pruebas p,hojatrabajo h
                WHERE
                p.idhojapruebas=h.idhojapruebas AND
                p.estado<>3 and
                p.estado<>9 and
                p.estado<>5 and
                p.idtipo_prueba=5 AND
                p.prueba=$prueba AND
                h.idhojapruebas=$idhojapruebas
                ORDER BY 1 $order LIMIT 1");
        $r = $rta->result();
        return $r[0];
    }

    function guardarImagen($idprueba, $imagen, $idusuario, $idmaquina) {
        $this->db->trans_start();
        $img = $this->buscarImagen($idprueba);
        if ($img->num_rows > 0) {
            $this->db->set('imagen', $imagen, FALSE);
            $this->db->where('idprueba', $idprueba);
            $this->db->update("imagenes");
        } else {
            $data['idprueba'] = $idprueba;
            $data['imagen'] = $imagen;
            $this->db->insert("imagenes", $data);
        }
        $this->db->trans_complete();
        return $this->updatePrueba($idprueba, $idusuario, $idmaquina);
    }

    function buscarImagen($idprueba) {
        return $this->db->query("select *
                FROM
                imagenes i
                where
                i.idprueba=$idprueba");
    }

    function updatePrueba($idprueba, $idusuario, $idmaquina) {
        $this->db->set("fechainicial", "fechainicial", FALSE);
        $this->db->set("fechafinal", "now()", FALSE);
        $this->db->set("idusuario", $idusuario, FALSE);
        $this->db->set("estado", "2", FALSE);
        $this->db->set("idmaquina", $idmaquina, FALSE);
        $this->db->where('idprueba', $idprueba);
        $this->db->update("pruebas");
        $this->updateEnc($idprueba);
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
