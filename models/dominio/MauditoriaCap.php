<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MauditoriaCap extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        $this->db->where("idconfiguracion", '200');
        $query = $this->db->get('config_maquina');
        return $query;
    }

}
