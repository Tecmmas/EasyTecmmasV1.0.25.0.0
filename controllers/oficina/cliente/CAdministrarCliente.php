<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
ini_set('memory_limit', '-1');

class CAdministrarCliente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("dominio/Mpropietario");
        $this->load->model("dominio/Mdepartamento");
        $this->load->model("dominio/Mciudad");
        espejoDatabase();
    }

    public function index() {
        if ($this->session->userdata('IdUsuario') == '' || $this->session->userdata('IdUsuario') == '1024') {
            redirect('Cindex');
        }
        if ($this->input->post('idcliente') !== null) {
            $cliente['idcliente'] = $this->input->post('idcliente');
            $rta = $this->Mpropietario->get($cliente);
            $r = $rta->result();
            $cliente = $r[0];
            $data['cliente'] = $cliente;
            $data['categoria_licencia'] = "<option value='$cliente->categoria_licencia'>$cliente->categoria_licencia</option>";
            $data['tipo_identificacion'] = $this->getTipoIdentificacion($cliente->tipo_identificacion);
            $data['ciudad'] = $this->getCiudad($cliente->cod_ciudad);
        } else {
            $data['categoria_licencia'] = "<option value=''></option>";
            $data['tipo_identificacion'] = "<option value=''></option>";
            $data['ciudad'] = "<option value=''></option>";
        }
        $data['ciudades'] = $this->getCiudades();
        $this->load->view('oficina/cliente/VAdministrarCliente', $data);
    }

    private function getCiudades() {
        $rtaDeptos = $this->Mdepartamento->getAll();
        $ciudades = "";
        foreach ($rtaDeptos->result() as $depto) {
            $ciudades = $ciudades . "<optgroup label='$depto->nombre'>";
            $dat['cod_depto'] = $depto->cod_depto;
            $rtaCiudad = $this->Mciudad->getXDepto($dat);
            foreach ($rtaCiudad->result() as $ciudad) {
                $ciudades = $ciudades . " <option value='$ciudad->cod_ciudad'>$ciudad->nombre</option>";
            }
            $ciudades = $ciudades . "</optgroup>";
        }
        return $ciudades;
    }

    private function getTipoIdentificacion($tipo) {
        $ti = "";
        switch ($tipo) {
            case "1":
                $ti = "<option value='1'>Cédula de ciudadanía</option>";
                break;
            case '2':
                $ti = "<option value='2'>Numero Identificación Tributaria (NIT)</option>";
                break;
            case '3':
                $ti = "<option value='3'>Cédula de extrangería</option>";
                break;
            case '4':
                $ti = "<option value='4'>Tarjeta de identidad</option>";
                break;
            case '5':
                $ti = "<option value='5'>N. único de Id. Personal</option>";
                break;
            case '6':
                $ti = "<option value='6'>Pasaporte</option>";
                break;
            default:
                break;
        }
        return $ti;
    }

    public function getCiudad($cod_ciudad) {
        $data['cod_ciudad'] = $cod_ciudad;
        $result = $this->Mciudad->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            $ciudad = $r[0];
            return "<option value='$ciudad->cod_ciudad'>$ciudad->nombre</option>";
        } else {
            return "<option value=''></option>";
        }
    }

    public function guardar() {
//        echo isset($_POST["btnnuevo"]);
        if (isset($_POST["btnnuevo"])) {
            redirect('oficina/cliente/CAdministrarCliente');
        } else {
            $cliente['idcliente'] = $this->input->post("idcliente");
            $cliente['tipo_identificacion'] = $this->input->post("tipo_identificacion");
            $cliente['numero_identificacion'] = $this->input->post("numero_identificacion");
            $cliente['nombre1'] = strtoupper($this->input->post("nombres"));
            $cliente['nombre2'] = "";
            $cliente['apellido1'] = strtoupper($this->input->post("apellidos"));
            $cliente['apellido2'] = "";
            $cliente['telefono1'] = $this->input->post("telefono1");
            $cliente['telefono2'] = $this->input->post("telefono2");
            $cliente['direccion'] = strtoupper($this->input->post("direccion"));
            $cliente['cod_ciudad'] = $this->input->post("cod_ciudad");
            $cliente['numero_licencia'] = $this->input->post("numero_licencia");
            $cliente['categoria_licencia'] = $this->input->post("categoria_licencia");
            $cliente['correo'] = strtolower($this->input->post("correo"));
            $cliente['cumpleanos'] = $this->input->post("cumpleanos");
            $this->form_validation->set_rules('tipo_identificacion', 'Tipo Identificación', 'required');
            if ($cliente['idcliente'] !== null && $cliente['idcliente'] !== "") {
                $this->form_validation->set_rules('numero_identificacion', 'Numero Identificación', 'required');
            } else {
                $this->form_validation->set_rules('numero_identificacion', 'Numero Identificación', 'required|is_unique[clientes.numero_identificacion]');
            }

            $this->form_validation->set_rules('nombres', 'Nombres', 'required');
            $this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
            $this->form_validation->set_rules('telefono1', 'Teléfono de contacto 1', 'required');
            $this->form_validation->set_rules('direccion', 'Dirección', 'required');
            $this->form_validation->set_rules('cod_ciudad', 'Ciudad', 'required');
            $this->form_validation->set_rules('correo', 'Correo', 'valid_email');
//            $this->form_validation->set_rules('cumpleanos', 'Fecha nacimiento', 'numeric');
            if ($this->form_validation->run()) {
                if ($cliente['idcliente'] !== null && $cliente['idcliente'] !== "") {
                    $this->Mpropietario->update($cliente);
                } else {
                    $cliente['idcliente'] = null;
                    $cliente['idcliente'] = $this->Mpropietario->insert($cliente);
                }
                $data = $this->setForm($cliente);
                $data['ciudades'] = $this->getCiudades();
                if (isset($_POST["guardar"])) {
                    $this->load->view('oficina/cliente/VAdministrarCliente', $data);
                }
                if (isset($_POST["btnguardarnuevo"])) {
                    $this->load->view('oficina/cliente/VAdministrarCliente');
                }
                if (isset($_POST["guardarfinalizar"])) {
                    redirect('oficina/cliente/Ccliente');
                }
            } else {
                if ($cliente['idcliente'] !== null && $cliente['idcliente'] !== "") {
                    $cliente['idcliente'] = $this->input->post('idcliente');
                    $rta = $this->Mpropietario->get($cliente);
                    $r = $rta->result();
                    $cliente = $r[0];
                    $data['cliente'] = $cliente;
                    $data['categoria_licencia'] = "<option value='$cliente->categoria_licencia'>$cliente->categoria_licencia</option>";
                    $data['tipo_identificacion'] = $this->getTipoIdentificacion($cliente->tipo_identificacion);
                    $data['ciudad'] = $this->getCiudad($cliente->cod_ciudad);
                } else {
                    $data = $this->setForm($cliente);
                }
                $data['ciudades'] = $this->getCiudades();
                $this->load->view('oficina/cliente/VAdministrarCliente', $data);
            }
        }
    }

    private function setForm($cliente) {
        $data['cliente'] = (object) array();
        if ($cliente['idcliente'] !== null && $cliente['idcliente'] !== "") {
            $data['cliente']->idcliente = $cliente['idcliente'];
        } else {
            $data['cliente']->idcliente = null;
        }
        if ($cliente['cod_ciudad'] !== null && $cliente['cod_ciudad'] !== "") {
            $data['ciudad'] = $this->getCiudad($cliente['cod_ciudad']);
        } else {
            $data['ciudad'] = "<option value=''></option>";
        }
        if ($cliente['categoria_licencia'] !== null && $cliente['categoria_licencia'] !== "") {
            $categoria_licencia = $cliente['categoria_licencia'];
            $data['categoria_licencia'] = "<option value='$categoria_licencia'>$categoria_licencia</option>";
        } else {
            $data['categoria_licencia'] = "<option value=''></option>";
        }
        if ($cliente['tipo_identificacion'] !== null && $cliente['tipo_identificacion'] !== "") {
            $data['tipo_identificacion'] = $this->getTipoIdentificacion($cliente['tipo_identificacion']);
        } else {
            $data['tipo_identificacion'] = "<option value=''></option>";
        }
        if ($cliente['nombre1'] !== null && $cliente['nombre1'] !== "") {
            $data['cliente']->nombre1 = $cliente['nombre1'];
        } else {
            $data['cliente']->nombre1 = "";
        }
        $data['cliente']->nombre2 = "";
        if ($cliente['apellido1'] !== null && $cliente['apellido1'] !== "") {
            $data['cliente']->apellido1 = $cliente['apellido1'];
        } else {
            $data['cliente']->apellido1 = "";
        }
        $data['cliente']->apellido2 = "";
        if ($cliente['numero_identificacion'] !== null && $cliente['numero_identificacion'] !== "") {
            $data['cliente']->numero_identificacion = $cliente['numero_identificacion'];
        } else {
            $data['cliente']->numero_identificacion = "";
        }
        if ($cliente['telefono1'] !== null && $cliente['telefono1'] !== "") {
            $data['cliente']->telefono1 = $cliente['telefono1'];
        } else {
            $data['cliente']->telefono1 = "";
        }
        if ($cliente['telefono2'] !== null && $cliente['telefono2'] !== "") {
            $data['cliente']->telefono2 = $cliente['telefono2'];
        } else {
            $data['cliente']->telefono2 = "";
        }
        if ($cliente['direccion'] !== null && $cliente['direccion'] !== "") {
            $data['cliente']->direccion = $cliente['direccion'];
        } else {
            $data['cliente']->direccion = "";
        }
        if ($cliente['numero_licencia'] !== null && $cliente['numero_licencia'] !== "") {
            $data['cliente']->numero_licencia = $cliente['numero_licencia'];
        } else {
            $data['cliente']->numero_licencia = "";
        }
        if ($cliente['correo'] !== null && $cliente['correo'] !== "") {
            $data['cliente']->correo = $cliente['correo'];
        } else {
            $data['cliente']->correo = "";
        }
        if ($cliente['cumpleanos'] !== null && $cliente['cumpleanos'] !== "") {
            $data['cliente']->cumpleanos = $cliente['cumpleanos'];
        } else {
            $data['cliente']->cumpleanos = "";
        }
        return $data;
    }

}




