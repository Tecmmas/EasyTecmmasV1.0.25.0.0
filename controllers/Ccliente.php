<?php

defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

class Ccliente extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("Mutilitarios");
        $this->load->model("Mcliente");
        $this->load->model("Mprerevision");
        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
    }

    var $sistemaOperativo = "";
    public function index()
    {
        if ($this->session->userdata('IdUsuario') == '') {
            redirect('Cindex');
        }
        $rta = $this->Musuario->getUsuarioId($this->input->post('IdUsuario'));
        $usuario = $rta->result();
        echo json_encode($usuario);
    }

    public function guardarFirma()
    {
        $placa = $this->input->post('placa');
        $dia = $this->getDia();
        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            if (!is_dir('tcm/prerevision/' . $dia . "/" . $placa)) {
                mkdir('tcm/prerevision/' . $dia . "/" . $placa, 0777, true);
            }
            $archivo = fopen(
                "tcm/prerevision/" . $this->getDia() . "/" . $placa . "/" .
                "sig_" . $this->input->post('ocasion') . ".dat",
                "w+b"
            );

        } else {
            if (!is_dir('c:/tcm/prerevision/' . $dia . "/" . $placa)) {
                mkdir('c:/tcm/prerevision/' . $dia . "/" . $placa, 0777, true);
            }
            $archivo = fopen(
                "c:/tcm/prerevision/" . $this->getDia() . "/" . $placa . "/" .
                "sig_" . $this->input->post('ocasion') . ".dat",
                "w+b"
            );
        }

        $encrptopenssl = new Opensslencryptdecrypt();
        $firma = $encrptopenssl->encrypt($this->input->post('firma'));
        fwrite($archivo, $firma);
        fclose($archivo);
    }


    public function leerFirma()
    {
        $encrptopenssl = new Opensslencryptdecrypt();
        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            $file = "tcm/prerevision/" . $this->getDia() . "/" . $this->input->post('placa') . "/" .
                "sig_" . $this->input->post('ocasion') . ".dat";
        } else {
            $file = "c:/tcm/prerevision/" . $this->getDia() . "/" . $this->input->post('placa') . "/" .
                "sig_" . $this->input->post('ocasion') . ".dat";
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
            $archivo = fopen(
                "tcm/prerevision/" . $this->getDia() . "/" . $this->input->post('placa') . "/" .
                $this->input->post('cons') . "_" .
                $this->input->post('ocasion') . ".dat",
                "w+b"
            );
        } else {
            $archivo = fopen(
                "c:/tcm/prerevision/" . $this->getDia() . "/" . $this->input->post('placa') . "/" .
                $this->input->post('cons') . "_" .
                $this->input->post('ocasion') . ".dat",
                "w+b"
            );

        }

        $encrptopenssl = new Opensslencryptdecrypt();
        //$plain_txt = "this is awsome";
        $foto = $encrptopenssl->encrypt($this->input->post('foto'));  //encypting plain text
        //$testdec = $encrptopenssl->decrypt($testenc);    //decrypting plain texx
        //$firma = $this->encrypt->enconde();
        fwrite($archivo, $foto);
        fclose($archivo);
        $rutaFoto = $this->getDia() . "|" . $this->input->post('placa') . "|" .
            $this->input->post('cons') . "_" .
            $this->input->post('ocasion');
        echo $rutaFoto;
    }

    public function borrarFoto()
    {
        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            $foto = "tcm\\prerevision\\" . $this->getDia() . "\\" . $this->input->post('placa') . "\\" .
                $this->input->post('cons') . "_" .
                $this->input->post('ocasion') . ".dat";
        } else {
            $foto = "c:\\tcm\\prerevision\\" . $this->getDia() . "\\" . $this->input->post('placa') . "\\" .
                $this->input->post('cons') . "_" .
                $this->input->post('ocasion') . ".dat";
        }
        unlink($foto);
        //        $rutaFoto = $this->getDia() . "|" . $this->input->post('placa') . "|" .
        //                $this->input->post('cons') . "_" .
        //                $this->input->post('ocasion');
        //        $this->Mprerevision->borrarFoto($rutaFoto);
        //echo $rutaFoto;
    }

    public function getDia()
    {
        $dia = strval($this->Mutilitarios->getNow());
        $dia = str_replace("-", "", $dia);
        $dia = substr($dia, 0, 8);
        return $dia;
    }
}
