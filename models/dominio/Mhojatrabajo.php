<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mhojatrabajo extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where("idhojapruebas", $data['idhojapruebas']);
        $query = $this->db->get('hojatrabajo');
        return $query;
    }

    function update($data) {
        $this->db->where('idhojapruebas', $data['idhojapruebas']);
//        $this->db->set('fechafinal', 'NOW()');
//        $this->db->set('jefelinea', "'" . $data['jefelinea'] . "'");
//        $this->db->set('estadototal', "'" . $data['estadototal'] . "'");
//        $this->db->set('fechainicial', 'fechainicial');
        $this->db->set('fechafinal', 'NOW()', FALSE);
        $this->db->set('jefelinea', "'" . $data['jefelinea'] . "'", FALSE);
        $this->db->set('estadototal', "'" . $data['estadototal'] . "'", FALSE);
        $this->db->set('fechainicial', 'fechainicial', FALSE);
        $this->db->update('hojatrabajo', $data);
    }

    function update_x($data) {
        $this->db->where('idhojapruebas', $data['idhojapruebas']);
//        $this->db->set('fechafinal', 'NOW()');
//        $this->db->set('sicov', "'" . $data['sicov'] . "'");
//        $this->db->set('estadototal', "'" . $data['estadototal'] . "'");
//        $this->db->set('fechainicial', 'fechainicial');
        $this->db->set('fechafinal', 'NOW()', FALSE);
        $this->db->set('sicov', "'" . $data['sicov'] . "'", FALSE);
        $this->db->set('estadototal', "'" . $data['estadototal'] . "'", FALSE);
        $this->db->set('fechainicial', 'fechainicial', FALSE);
        $this->db->update('hojatrabajo', $data);
        $this->updateVisorSicov($data);
    }
    
    function updateVisorSicov($data){
        $idhojapruebas = $data['idhojapruebas'];
        $sicov = $data['sicov'];
        $estadototal = $data['estadototal'];
        $reinspeccion = $data['reinspeccion'];
        $query = <<<EOF
                    UPDATE visor v set v.fecha = v.fecha, v.sicov = $sicov, v.estadototal = $estadototal  where v.idhojapruebas =  $idhojapruebas and v.reinspeccion = $reinspeccion
EOF;
        $rta = $this->db->query($query);
    }

    function update_JefePista($data) {
        $this->db->where('idhojapruebas', $data['idhojapruebas']);
        $this->db->set('fechafinal', 'fechafinal', FALSE);
        $this->db->set('jefelinea', "'" . $data['jefelinea'] . "'", FALSE);
        $this->db->set('fechainicial', 'fechainicial', FALSE);
        $this->db->update('hojatrabajo', $data);
    }

    function update_llamar($data) {
        $this->db->where('idhojapruebas', $data['idhojapruebas']);
        $this->db->set('fechafinal', 'fechafinal', FALSE);
        $this->db->set('llamar', $data['llamar'], FALSE);
        $this->db->set('fechainicial', 'fechainicial', FALSE);
        $this->db->update('hojatrabajo', $data);
    }

    function insert($data) {
        $this->db->insert('hojatrabajo', $data);
        return $this->db->insert_id();
    }

    function update_($data) {
        $this->db->set('fechainicial', 'fechainicial', FALSE);
        $this->db->set('fechafinal', 'now()', FALSE);
        $this->db->where('idhojapruebas', $data['idhojapruebas']);
        $this->db->update('hojatrabajo', $data);
    }

}
