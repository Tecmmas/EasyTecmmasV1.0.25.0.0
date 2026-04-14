<?php

defined("BASEPATH") or exit("No direct script access allowed");
header("Access-Control-Allow-Origin: *");
ini_set("memory_limit", "-1");
set_time_limit(300);

class Cusuarios extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("form");
        $this->load->helper("url");
        $this->load->helper("security");
        $this->load->model("oficina/usuarios/Musuarios");
        espejoDatabase();
    }

    public function index()
    {
        if ($this->session->userdata("IdUsuario") == "" || $this->session->userdata("IdUsuario") == "1024") {
            redirect("Cindex");
        }

        $rta['usuarios'] = $this->Musuarios->infoUsuarios();
        $this->load->view('oficina/usuarios/Vgetusuarios', $rta);
    }

    public function getUsuarios()
    {
        
        $idusuario = $this->input->post('idusuario');
        if (isset($idusuario)) {
            $rta['usuario'] = $this->Musuarios->getUsuarios($idusuario);
            $this->setConf();
            $this->load->view('oficina/usuarios/Vusuarios', $rta);
        } else {
            $this->load->view('oficina/usuarios/Vusuarios');
        }
    }

    public function crearUsuario()
    {
        if (isset($_POST["btnnuevo"])) {
            redirect('oficina/usuarios/Cusuarios/getUsuarios');
        } else {
            // @phpstan-ignore-next-line
            
            $IdUsuario = $this->input->post('idusuario');
            $idusuarioUpdate = $this->input->post('idusuarioUpdate');
            $tipo_identificacion = $this->input->post('tipo_identificacion');
            $identificacion = $this->input->post('numero_identificacion');
            $nombres = strtoupper($n = $this->input->post('nombres'));
            $apellidos = strtoupper($n = $this->input->post('apellidos'));
            $idperfil = $this->input->post('tipo_perfil');
            $username = $this->input->post('usuario');
            $passwd = $this->input->post('contrasena');
            $contrasenaold = $this->input->post('contrasenaold');
            $equipo_asignado = $this->input->post('equipo_asignado');
            $estado = $this->input->post('estado');
            $base64Huella = $this->input->post('base64Huella');
            $this->form_validation->set_rules('nombres', 'Nombres', 'required');
            $this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
            $this->form_validation->set_rules('tipo_identificacion', 'Tipo documento', 'required');
            $this->form_validation->set_rules('numero_identificacion', 'Numero documento', 'required');
            $this->form_validation->set_rules('tipo_perfil', 'Perfil', 'required');
            $this->form_validation->set_rules('usuario', 'Usuario', 'required');
            $this->form_validation->set_rules('contrasena', 'Contraseña', 'required');
            $this->form_validation->set_rules('confirmcontrasena', 'Confirmar contraseña', 'required');
            $this->form_validation->set_rules('estado', 'Estado', 'required');
            if ($this->form_validation->run()) {
                if ($IdUsuario !== null && $IdUsuario !== "") {
                    if ($contrasenaold !== $passwd) {
                        $this->Musuarios->update($IdUsuario, $tipo_identificacion, $identificacion, $nombres, $apellidos, $idperfil, $username, $passwd, $estado, $contrasenaold,strtoupper( $equipo_asignado), $idusuarioUpdate, $base64Huella);
                        // $this->Musuarios->insertcontrasenaold($IdUsuario, $contrasenaold);
                    } else {
                        $this->Musuarios->update($IdUsuario, $tipo_identificacion, $identificacion, $nombres, $apellidos, $idperfil, $username, $passwd, $estado, $contrasenaold,strtoupper( $equipo_asignado), $idusuarioUpdate, $base64Huella);
                    }
                } else {
                    $IdUsuario = null;
                    $IdUsuario = $this->Musuarios->insert($tipo_identificacion, $identificacion, $nombres, $apellidos, $idperfil, $username, $passwd, $estado,strtoupper( $equipo_asignado), $idusuarioUpdate, $base64Huella);
                }
                if ($_POST["guardarref"] == 'guardarref' && $_POST["guardarref"] !==  null) {
                    $mensaje = 'Registro guardado';
                    $this->session->set_flashdata('error', $mensaje);
                    $rta['usuario'] = $this->Musuarios->getUsuarios($IdUsuario);
                    $this->load->view('oficina/usuarios/Vusuarios', $rta);
                }
                if ($_POST["btnguardarnuevoref"] == 'btnguardarnuevoref' && $_POST["btnguardarnuevoref"] !== null) {
                    $mensaje = '';
                    $this->session->set_flashdata('error', $mensaje);
                    $this->load->view('oficina/usuarios/Vusuarios');
                }
                if ($_POST["guardarfinalizarref"] == 'guardarfinalizarref' && $_POST["guardarfinalizarref"] !== null) {
                    $rta['usuarios'] = $this->Musuarios->infoUsuarios();
                    $this->load->view('oficina/usuarios/Vgetusuarios', $rta);
                }
            } else {
                $data['tipoidentificacion'] = $this->tipoIdentificacion($tipo_identificacion);
                $data['perfil'] = $this->perfil($idperfil);
                $data['identificacion'] = $identificacion;
                $data['nombres'] = $nombres;
                $data['apellidos'] = $apellidos;
                $data['contrasena'] = $passwd;
                $data['usuarios'] = $username;
                $data['equipo_asignado'] = strtoupper( $equipo_asignado);
                if ($estado == 1) {
                    $name = "Activo";
                } else {
                    $name = "Inactivo";
                }
                $data['estado'] = "<option value='$estado'>$name</option>";
                $this->load->view('oficina/usuarios/Vusuarios', $data);
            }
        }
    }

    function tipoIdentificacion($tipo_identificacion)
    {
        if ($tipo_identificacion !== null && $tipo_identificacion !== "") {
            $rta = $this->Musuarios->gettipoIdentificacion($tipo_identificacion);
            $data = "<option value='$tipo_identificacion'>$rta</option>";
        } else {
            $data = null;
        }
        return $data;
    }

    function perfil($idperfil)
    {
        if ($idperfil !== null && $idperfil !== "") {
            $rta = $this->Musuarios->gettipoIdperfil($idperfil);
            $data = "<option value='$idperfil'>$rta</option>";
        } else {
            $data = null;
        }
        return $data;
    }


    private function setConf()
    {
        $conf = @file_get_contents("system/oficina.json");
        $this->session->set_userdata('huellaDigital', '0');

        if (isset($conf)) {
            $encrptopenssl = new Opensslencryptdecrypt();
            $json = $encrptopenssl->decrypt($conf, true);
            $dat = json_decode($json, true);
            foreach ($dat as $d) {
                //                echo $conf;
                if ($d['nombre'] == "huellaDigital") {
                     $this->session->set_userdata('huellaDigital', $d['valor']);
                    // $this->session->set_userdata('huellaDigital', '0');
                }
                
            }
        }
    }
}
