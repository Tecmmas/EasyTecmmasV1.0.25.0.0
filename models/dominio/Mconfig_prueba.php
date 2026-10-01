<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mconfig_prueba extends CI_Model {

    private $idSicovAlternativoActivo = 40000;
    private $idSicovAlternativoUrl = 40001;
    private $idSicov2Url = 40002;

    function __construct() {
        parent::__construct();
    }

    function get($data) {
        $this->db->where('idconfig_prueba', $data['idconfig_prueba']);
        $query = $this->db->get('config_prueba');
        return $query;
    }

    function update($data) {
        $this->db->set('valor', $data['valor']);
        $this->db->where('idconfig_prueba', $data['idconfig_prueba']);
        $this->db->update('config_prueba', $data);
    }

    function insert($data) {
        $result = $this->get($data);
        if ($result->num_rows() == 0)
            $this->db->insert('config_prueba', $data);
        else
            $this->update($data);
    }

    function getValorById($idconfig_prueba) {
        $this->db->select('valor');
        $this->db->where('idconfig_prueba', intval($idconfig_prueba));
        $query = $this->db->get('config_prueba');
        if ($query->num_rows() > 0) {
            return $query->row()->valor;
        }
        return null;
    }

    function getSicovAlternativoState() {
        $activo = $this->getValorById($this->idSicovAlternativoActivo);
        $url = $this->getValorById($this->idSicovAlternativoUrl);

        if ($activo === null || $activo === '') {
            $activo = '0';
        } else {
            $activo = trim(strval($activo)) === '1' ? '1' : '0';
        }

        if ($url === null) {
            $url = '';
        } else {
            $url = trim(strval($url));
        }

        return array(
            'activo' => $activo,
            'url' => $url
        );
    }

    function setSicovAlternativoState($activo, $url) {
        $activo = trim(strval($activo)) === '1' ? '1' : '0';
        $url = trim(strval($url));

        $dataActivo = array(
            'idconfig_prueba' => $this->idSicovAlternativoActivo,
            'idconfiguracion' => '34',
            'valor' => $activo,
            'descripcion' => 'sicov alternativo activo',
            'adicional' => ''
        );

        $dataUrl = array(
            'idconfig_prueba' => $this->idSicovAlternativoUrl,
            'idconfiguracion' => '34',
            'valor' => $url,
            'descripcion' => 'sicov alternativo url',
            'adicional' => ''
        );

        $this->insert($dataActivo);
        $this->insert($dataUrl);

        return $this->getSicovAlternativoState();
    }

    function getSicov2Url() {
        $url = $this->getValorById($this->idSicov2Url);
        return $url === null ? '' : trim(strval($url));
    }

    function setSicov2Url($url) {
        $url = trim(strval($url));

        $this->insert(array(
            'idconfig_prueba' => $this->idSicov2Url,
            'idconfiguracion' => '34',
            'valor' => $url,
            'descripcion' => 'sicov 2.0 url',
            'adicional' => ''
        ));

        return $this->getSicov2Url();
    }

}
