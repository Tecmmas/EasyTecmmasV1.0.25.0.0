<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mcertificados extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("idcertificado", $data['idcertificado']);
        $query = $this->db->get('certificados');
        return $query;
    }

    function getHT($data) {
        $this->db->where("idhojapruebas", $data['idhojapruebas']);
        $this->db->where("estado", $data['estado']);
        $query = $this->db->get('certificados');
        return $query;
    }

    function insert($data) {
        $rta = $this->getHT($data);
        if ($rta->num_rows() > 0) {
            $cert = $rta->result();
            $this->db->where("id_certificado", $cert[0]->id_certificado);
            $this->db->update('certificados', $data);
        } else {
            $this->db->insert('certificados', $data);
        }
        $this->cerrtificadoVisor($data);
    }
    
    function cerrtificadoVisor($data){
        $idhojapruebas = $data['idhojapruebas']; 
        $query = <<<EOF
                    UPDATE visor v set v.fecha = v.fecha, v.certificado = 1 where v.idhojapruebas =  $idhojapruebas
EOF;
        $rta = $this->db->query($query);
    }

    function delete($data) {
        $this->db->where("idhojaprueba", $data["idhojaprueba"]);
        $this->db->where("estado", $data["estado"]);
        $this->db->update('certificados');
    }

}
