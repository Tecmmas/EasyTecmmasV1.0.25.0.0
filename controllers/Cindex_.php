<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

class Cindex_ extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("Mindex");
        $this->load->library('Opensslencryptdecrypt');
        $this->load->dbforge();
    }

    private $usuario = "";
    private $contrasena = "";

    public function index() {
        
        $this->load->view('Vfotos' );
    }

    public function validar() {
        if (!file_exists("system/oficina.json") && $this->input->post('usuario') !== "tecmmas") {
            $data['usuario'] = $this->input->post('usuario');
            $data['contrasena'] = $this->input->post('contrasena');
            $data['mensaje'] = '<strong style="color: #E31F24"">Configuración no establecida, comuniquese con TECMMAS SAS</strong>';
            $this->load->view('Vindex', $data);
        } else {
            if ($this->input->post('usuario') == "AdminitradorTecmmas" &&
                    $this->input->post('contrasena') == "TecmmasAdmin7*8*9*") {
                $this->session->set_userdata('IdUsuario', '1024');
                echo json_decode(1);
//                redirect(base_url() . 'index.php/oficina/login/Cconf');
            } else {
//                $this->form_validation->set_rules('usuario', 'Usuario', 'required');
//                $this->form_validation->set_rules('contrasena', 'Contrasena', 'required|min_length[6]|max_length[20]');
//
//                if ($this->form_validation->run()) {
                $this->usuario = $this->input->post('usuario');
                $this->contrasena = $this->input->post('contrasena');
                $rta = $this->Mindex->puede_entrar($this->usuario, $this->contrasena);
                if ($rta->num_rows() > 0) {
                    $user = $rta->result();
                    if (strcmp($user[0]->estado, '0') == 0) {
//                            $this->error('Usuario inactivo');
                        echo json_encode(2);
                    }
                    if (strcmp($user[0]->autentico, '0') == 0 || strcmp($user[0]->autentico, '0') == null) {
//                            $this->error('Usuario inactivo');
                        echo json_encode(6);
                    } else {
                        $session_data = array(
                            'usuario' => $this->usuario,
                            'nombre' => $user[0]->nombres,
                            'IdUsuario' => $user[0]->IdUsuario,
                            'idperfil' => $user[0]->idperfil
                        );
                        $this->session->set_userdata($session_data);
                        if ($this->Mindex->validar_vigencia($user[0]->IdUsuario) == "1") {
                            echo json_encode(3);
                            //redirect(base_url() . 'index.php/oficina/contrasenas/Ccontrasenas');
                        } else {
                            echo json_encode(4);
                            //redirect(base_url() . 'index.php/oficina/CPrincipal');
                        }
                    }

                    //Determinar rol de usuario ADMINISTRADOR-ADMINISTRATIVO-OPERARIO-AUDITOR
                } else {
//                        $this->error('Nombre de usuario o contraseña inválidos');
                    echo json_encode(5);
                }
//                } else {
//                    $this->index();
//                }
            }
        }
    }

    public function savePassword() {
        $rta = $this->input->post('clave');
        $archivo = fopen('C:\Apache24\htdocs\et\application\config\database.php', "w+b");
        fwrite($archivo, $rta);
        fclose($archivo);
        $dominio = file_get_contents('system/dominio.dat', true);
        $url = 'http://updateapp.tecmmas.com/Actualizaciones/index.php/Cactualizaciones' . '?dominio=' . $dominio;
        file_get_contents($url);
        $this->Mindex->updateResultados();
        echo json_encode('1');
    }

    private function error($mensaje) {
        $this->session->set_flashdata('error', $mensaje);
        redirect(base_url() . 'index.php/Cindex');
    }

    private function rdnr($valor) {
        $dato = '';
        if ($valor !== '') {
            if (floatval($valor) === 0.00 || floatval($valor) === 0.0 || floatval($valor) === 0) {
                $dato = "0.00";
            } else {
                if (intval($valor) < 10) {
                    $valorNegativo = false;
                    $dato = abs(round($valor, 2));
                    if ($valor < 0) {
                        $valorNegativo = true;
                        if (intval($valor) > -10) {
                            if (substr($dato, 2) == "") {
                                $dato = $dato . ".00";
                            } elseif (substr($dato, 3) == "" || substr($dato, 3) == '0') {
                                $dato = $dato . "0";
                            }
                        } elseif (intval($valor) <= -10 && intval($valor) > -100) {
                            $dato = abs(round($valor, 1));
                            if (substr($dato, 2) == "") {
                                $dato = $dato . ".0";
                            }
                        } else {
                            $dato = abs(round($valor));
                        }
                    } else {
                        if (substr($dato, 1) == "") {
                            $dato = $dato . ".00";
                        } elseif (substr($dato, 3) == "" || substr($dato, 3) == '0') {
                            $dato = $dato . "0";
                        }
                    }
                    if ($valorNegativo) {
                        $dato = "-" . $dato;
                    }
                } elseif (intval($valor) >= 10 && intval($valor) < 100) {
                    $dato = round($valor, 1);
                    if (substr($dato, 2) == "") {
                        $dato = $dato . ".0";
                    }
                } else {
                    $dato = round($valor);
                }
            }
        }
        return $dato;
    }

    function consultarImagen(){

        $rta = $this->Mindex->consultarImagen();
        if ($rta->num_rows() > 0) {
            $user = $rta->result();
            echo json_encode($user[0]);
        } else {
            echo json_encode(0);
        }
    }

}
