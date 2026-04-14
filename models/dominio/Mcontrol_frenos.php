<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mcontrol_frenos extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
        $this->myforge = $this->load->dbforge($this->db, TRUE);
    }

    function insertar($data) {
        $this->createTableControl();
        $this->db->insert('control_frenos', $data);
    }
    function createTableControl() {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'placa' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE,
            ),
            'idmaquina' => array(
                'type' => 'INT',
                'constraint' => '11',
                'null' => FALSE,
            ),
            'fecha' => array(
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ),
            'eje' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE,
            ),
             'llanta' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE,
            ),
            'valor' => array(
                'type' => 'FLOAT',
                'null' => FALSE,
            ),
            'vector' => array(
                'type' => 'LONGTEXT',
                'null' => FALSE,
            )
        );
        $this->myforge->add_key('id', TRUE);
        $this->myforge->add_field($fields);
        $attributes = array('ENGINE' => 'InnoDB');
        $this->myforge->create_table('control_frenos', TRUE, $attributes);
    }

//    function get($idmaquina) {
//        $query = $this->db->query("
//            SELECT 
//                IF(TIMESTAMPDIFF(HOUR,f.fecha, NOW())>23,'N','S') tiempo,f.*
//                FROM 
//                control_fugas f 
//                WHERE 
//                f.idmaquina=$idmaquina
//                ORDER BY f.idcontrol_fugas DESC LIMIT 1");
//        return $query;
//    }
}
