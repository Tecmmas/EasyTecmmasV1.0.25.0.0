<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Msesion extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->dbutil();
        $this->db = $this->load->database('default', true);
        $this->myforge = $this->load->dbforge($this->db, TRUE);
    }

    public function setSesion($data) {
        $rtaSesion = $this->getSesion($data);
        if ($rtaSesion->num_rows() !== 0) {
            echo $this->updateSesion($data);
        } else {
            echo $this->db->insert("control_sesion", $data);
        }
    }

    public function updateSesion($data) {
        $this->db->set('fecha', 'NOW()', FALSE);
        $this->db->where('device', $data['device']);
        $this->db->where('user', $data['user']);
        $this->db->where('tipo', $data['tipo']);
        $this->db->update('control_sesion', $data);
    }

    public function updateSesionDevice($data) {
        $this->db->set('fecha', 'NOW()', FALSE);
        $this->db->set('estado', $data['estado'], FALSE);
        $this->db->set('ip', 'ip', FALSE);
        $this->db->where('device', $data['device']);
        $this->db->where('tipo', $data['tipo']);
        $this->db->update('control_sesion', $data);
    }

    public function getSesion($data) {
        $this->db->where('device', $data['device']);
        $this->db->where('user', $data['user']);
        $this->db->where('tipo', $data['tipo']);
        $this->db->where('ip', $data['ip']);
        $query = $this->db->get('control_sesion');
        return $query;
    }

    public function getSesionUser($user, $tipo, $ip) {
        $this->control_sesion();
        return $this->db->query("SELECT 
                *,TIMESTAMPDIFF(SECOND,cs.fecha,NOW()) tiempo 
                FROM 
                control_sesion cs 
                WHERE
                cs.user=$user AND
                cs.ip='$ip' AND
                cs.tipo=$tipo");
    }

    public function getSesionMaquina($tipo, $ip) {
        $this->control_sesion();
        return $this->db->query("SELECT 
                *
                FROM 
                control_sesion cs 
                WHERE
                cs.ip='$ip' AND
                cs.tipo=$tipo");
    }

    function control_sesion() {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'device' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE,
            ),
            'user' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
            ),
            'tipo' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
            ),
            'ip' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE,
            ),
            'estado' => array(
                'type' => 'TINYINT',
                'constraint' => 4,
                'null' => FALSE,
            ),
            'fecha' => array(
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ),
        );
        $this->myforge->add_key('id', TRUE);
        $this->myforge->add_field($fields);
        $attributes = array('ENGINE' => 'InnoDB');
        $this->myforge->create_table('control_sesion', TRUE, $attributes);
    }
}
