<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
ini_set('memory_limit', '-1');

class Ccliente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model('dominio/Mpropietario');
        espejoDatabase();
    }

    public function index() {
        if ($this->session->userdata('IdUsuario') == '' || $this->session->userdata('IdUsuario') == '1024') {
            redirect('Cindex');
        }
        $this->load->view('oficina/cliente/VCliente');
    }

    public function getCliente() {
        if ($this->input->post('match') !== '') {
            $clientes = $this->Mpropietario->getMatch($this->input->post('match'));
            $datos = '';
            if ($clientes->num_rows() > 0) {
                foreach ($clientes->result() as $c) {
                    $datos = $datos . <<<EOF
            <tr>
                <td>$c->numero_identificacion</td>
                <td>$c->nombre1 $c->nombre2</td>
                <td>$c->apellido1 $c->apellido2</td>
                <td>$c->direccion</td>
                <td>$c->telefono1</td>
                <td>$c->correo</td>
                <td><form action='../CAdministrarCliente' method='post'>
                        <input name='idcliente' type='hidden' value='$c->idcliente'>
                        <input name='button' class='btn btn-block'  style='width: content-box;
                                                                            border-radius: 10px 10px 10px 10px;
                                                                            background: whitesmoke;
                                                                            border: solid gold;
                                                                            color: black' type='submit' value='Ver/Editar' />   
                    </form>
                </td>     
            </tr>
EOF;
                }
            }
            $data['clientes'] = $datos;
        }
        $data['item'] = $this->input->post('match');
        $this->load->view('oficina/cliente/VCliente', $data);
    }

}
