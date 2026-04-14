<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Msede extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get() {
        $query = $this->db->get('sede');
        return $query;
    }
    
}
