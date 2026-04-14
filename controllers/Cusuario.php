<?php

defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

class Cusuario extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("Musuario");
        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
    }
    var $sistemaOperativo = "";

    public function index()
    {
        //        if ($this->session->userdata('IdUsuario') == '') {
//            redirect('Cindex');
//        }
        $this->Musuario->CrearTablaOpciones();
        $rta1 = $this->Musuario->getUsuarioId($this->input->post('IdUsuario'));
        $rta2 = $this->Musuario->getOpciones($this->input->post('IdUsuario'));
        $data['usuario'] = $rta1->result();
        $data['opciones'] = $rta2->result();
        echo json_encode($data);
    }

    public function guardarFirma()
    {
        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            if (!is_dir("tcm/usuarios/" . $this->input->post('identificacion'))) {
                mkdir("tcm/usuarios/" . $this->input->post('identificacion'), 0777, true);
            }
            $archivo = fopen("tcm/usuarios/" . $this->input->post('identificacion') . "/sig.dat", "w+b");
        } else {
            $archivo = fopen("c:/tcm/usuarios/" . $this->input->post('identificacion') . "/sig.dat", "w+b");
        }

        $encrptopenssl = new Opensslencryptdecrypt();
        $firma = $encrptopenssl->encrypt($this->input->post('firma'));  //encypting plain text
        fwrite($archivo, $firma);
        fclose($archivo);
    }

    public function leerFirma()
    {
        $encrptopenssl = new Opensslencryptdecrypt();
        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            $file = "tcm/usuarios/" . $this->input->post('identificacion') . "/sig.dat";
        } else {
            $file = "c:/tcm/usuarios/" . $this->input->post('identificacion') . "/sig.dat";
        }

        if (file_exists($file)) {
            $firma = file_get_contents($file, true);
            echo $encrptopenssl->decrypt($firma);
        } else {
            echo "NA";
        }
    }

    public function guardarFoto()
    {

        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            $archivo = fopen("tcm/usuarios/" . $this->input->post('identificacion') . "/sig.dat", "w+b");
        } else {
            $archivo = fopen("c:/tcm/usuarios/" . $this->input->post('identificacion') . "/sig.dat", "w+b");
        }

        $encrptopenssl = new Opensslencryptdecrypt();
        $firma = $encrptopenssl->encrypt($this->input->post('firma'));  //encypting plain text
        fwrite($archivo, $firma);
        fclose($archivo);
    }

    public function actualizarOpcion()
    {
        $opcion['idusuario'] = $this->input->post('idusuario');
        $opcion['nombre'] = $this->input->post('nombre');
        $opcion['valor'] = $this->input->post('valor');
        $this->Musuario->actualizarOpcion($opcion);
    }

    public function cargarOpciones()
    {
        $rta2 = $this->Musuario->getOpciones($this->input->post('IdUsuario'));
        $data = $rta2->result();
        echo json_encode($data);
    }

}
