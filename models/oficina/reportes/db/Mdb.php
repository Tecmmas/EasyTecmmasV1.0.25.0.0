<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mdb extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->dbutil();
    }

    public function mDatabase() {
        $result = $this->dbutil->optimize_database();
        if ($result !== FALSE) {
            return $result;
        }
    }

    

}

