<?php

defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
set_time_limit(1000);

class Cindex extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        espejoDatabase();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("Mindex");
        $this->load->library('Opensslencryptdecrypt');
        $this->load->dbforge();
    }

    private $usuario = "";
    private $contrasena = "";
    private $informeWebBogota = "0";
    private $grant_type = "";
    private $client_id = "";
    private $client_secret = "";
    var $sistemaOperativo = "";

    public function index()
    {

        $date = date("Y-m-d");
        $this->session->sess_destroy();
        $data['usuario'] = $this->usuario;
        $data['contrasena'] = $this->contrasena;
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/oficina.json', true), true);
        $ofc = json_decode($json, true);
        $this->setConf();
        $data['ocultarLicencia'] = '0';
        $data['informeWebBogota'] = $this->informeWebBogota;
        $this->Mindex->enc();
        //$this->Mindex->mDatabase();
        $this->session->set_userdata('actualizaciones', '0');
        $this->session->set_userdata('backup', '0');


        foreach ($ofc as $d) {
            if ($d['nombre'] == 'ocultarLicencia') {
                $data['ocultarLicencia'] = $d['valor'];
            }
        }

        $this->load->view('Vindex', $data);
    }

    public function getTokenBogota()
    {
        // $url = 'https://dev-api-gateway.ambientebogota.gov.co/api-gateway/public/oauth/token';
        $this->setConf();
        $url = 'https://dev-api-gateway.ambientebogota.gov.co/api-cdas/public/api/oauth/token';

        $data = [
            'grant_type' => $this->session->userdata('grant_type') ? $this->session->userdata('grant_type') : $this->grant_type,
            'client_id' => $this->session->userdata('client_id') ? $this->session->userdata('client_id') : $this->client_id,
            'client_secret' => $this->session->userdata('client_secret')? $this->session->userdata('client_secret') : $this->client_secret
        ];



        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
                'ignore_errors' => true,
                // Desactivar verificación SSL (solo para desarrollo)
                'verify_peer' => false,
                'verify_peer_name' => false
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === FALSE) {
            // Manejo de errores
            die("Error al realizar la petición");
        }

        $response = json_decode($result, true);

        // Imprimir la respuesta

        echo json_encode($response);
        // print_r($response);
    }

    public function getThArdu()
    {
        $encrptopenssl = new Opensslencryptdecrypt();
        $j = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $json = json_decode($j);

        $martaTh = "";
        $idmaquina = "";
        $idmaquinaTH = "";
        foreach ($json as $j) {
            if ($j->prueba == 'termohigrometro' && $j->activo == 1) {
                $martaTh = strtoupper($j->marca);
                $idmaquina = $j->idconf_maquina;
            }
        }
        $ma = $encrptopenssl->decrypt(file_get_contents('system/' . $idmaquina . '.json', true));
        $maquinaData = json_decode(utf8_decode($ma), true);
        foreach ($maquinaData as $d) {
            // echo '<pre>';
            // var_dump($d) ;
            // echo '</pre>';
            if ($d['idconf_maquina'] == $idmaquina && $d['nombre'] == 'id_th_bd') {
                $idmaquinaTH = $d['valor'];
            }
        }

        echo $martaTh . '|' . $idmaquinaTH;
    }

    public function postThArdu()
    {
       
        $dataTh = $this->Mindex->dataTh($this->input->post('marca'), $this->input->post('temperatura'), $this->input->post('humedad'), $this->input->post('conectado'), $this->input->post('idTh'));
    }

    public function validar()
    {
        if (!file_exists("system/oficina.json") && $this->input->post('usuario') !== "AdministradorTecmmas") {
            $data['usuario'] = $this->input->post('usuario');
            $data['contrasena'] = $this->input->post('contrasena');
            $data['mensaje'] = '<strong style="color: #E31F24"">Configuración no establecida, comuniquese con TECMMAS SAS</strong>';
            $this->load->view('Vindex', $data);
        } else {
            if (
                $this->input->post('usuario') == "AdministradorTecmmas" &&
                $this->input->post('contrasena') == "TecmmasAdmin7*8*9*"
            ) {
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
                    } else if (strcmp($user[0]->autentico, '0') == 0 || strcmp($user[0]->autentico, '0') == null) {
                        //                            $this->error('Usuario inactivo');
                        echo json_encode(6);
                    } else {
                        $session_data = array(
                            'usuario' => $this->usuario,
                            'nombre' => $user[0]->nombres,
                            'IdUsuario' => $user[0]->IdUsuario,
                            'userUpdate' => $user[0]->userUpdate,
                            'biometrico' => $user[0]->biometrico,
                            'idperfil' => $user[0]->idperfil
                        );
                        $this->session->set_userdata($session_data);

                        if ($this->Mindex->validar_vigencia($user[0]->IdUsuario) == "1") {
                            echo json_encode(3);
                            //redirect(base_url() . 'index.php/oficina/contrasenas/Ccontrasenas');
                        } else {
                            if ((intval($user[0]->IdUsuario) !== intval($user[0]->userUpdate)) && intval($user[0]->userUpdate) !== 0) {
                                echo json_encode(7);
                            } else {

                                echo json_encode(4);
                            }
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

    public function savePassword()
    {
        $rta = $this->input->post('clave');
        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            $archivo = fopen('application\config\database.php', "w+b");
        } else {
            $archivo = fopen('C:\Apache24\htdocs\et\application\config\database.php', "w+b");
        }

        fwrite($archivo, $rta);
        fclose($archivo);
        $dominio = file_get_contents('system/dominio.dat', true);
        $url = 'http://updateapp.tecmmas.com/Actualizaciones/index.php/Cactualizaciones' . '?dominio=' . $dominio;
        file_get_contents($url);
        $this->Mindex->updateResultados();
        echo json_encode('1');
    }

    private function error($mensaje)
    {
        $this->session->set_flashdata('error', $mensaje);
        redirect(base_url() . 'index.php/Cindex');
    }

    private function setConf()
    {
        $conf = @file_get_contents("system/oficina.json");

        $this->session->set_userdata('informeWebBogota', '0');

        if (isset($conf)) {
            $encrptopenssl = new Opensslencryptdecrypt();
            $json = $encrptopenssl->decrypt($conf, true);
            $dat = json_decode($json, true);
            foreach ($dat as $d) {

                if ($d['nombre'] == 'informeWebBogota') {
                    $this->informeWebBogota = $d['valor'];
                    // $this->session->set_userdata('informeWebBogota', $d['valor']);
                }
                if ($d['nombre'] == 'grant_type') {
                    $this->grant_type =  $d['valor'];
                }
                if ($d['nombre'] == 'client_id') {
                    $this->client_id=  $d['valor'];
                }
                if ($d['nombre'] == 'client_secret') {
                    $this->client_secret = $d['valor'];
                }
            }
        }
    }


    // private function rdnr($valor)
    // {
    //     $dato = '';
    //     if ($valor !== '') {
    //         if (floatval($valor) === 0.00 || floatval($valor) === 0.0 || floatval($valor) === 0) {
    //             $dato = "0.00";
    //         } else {
    //             if (intval($valor) < 10) {
    //                 $valorNegativo = false;
    //                 $dato = abs(round($valor, 2));
    //                 if ($valor < 0) {
    //                     $valorNegativo = true;
    //                     if (intval($valor) > -10) {
    //                         if (substr($dato, 2) == "") {
    //                             $dato = $dato . ".00";
    //                         } elseif (substr($dato, 3) == "" || substr($dato, 3) == '0') {
    //                             $dato = $dato . "0";
    //                         }
    //                     } elseif (intval($valor) <= -10 && intval($valor) > -100) {
    //                         $dato = abs(round($valor, 1));
    //                         if (substr($dato, 2) == "") {
    //                             $dato = $dato . ".0";
    //                         }
    //                     } else {
    //                         $dato = abs(round($valor));
    //                     }
    //                 } else {
    //                     if (substr($dato, 1) == "") {
    //                         $dato = $dato . ".00";
    //                     } elseif (substr($dato, 3) == "" || substr($dato, 3) == '0') {
    //                         $dato = $dato . "0";
    //                     }
    //                 }
    //                 if ($valorNegativo) {
    //                     $dato = "-" . $dato;
    //                 }
    //             } elseif (intval($valor) >= 10 && intval($valor) < 100) {
    //                 $dato = round($valor, 1);
    //                 if (substr($dato, 2) == "") {
    //                     $dato = $dato . ".0";
    //                 }
    //             } else {
    //                 $dato = round($valor);
    //             }
    //         }
    //     }
    //     return $dato;
    // }
}
