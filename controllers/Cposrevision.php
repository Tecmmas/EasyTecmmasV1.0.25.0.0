<?php

defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

class Cposrevision extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("Mposrevision");
        $this->load->model("Mutilitarios");
        $this->load->model("Mprerevision");
        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
    }
    var $sistemaOperativo = "";

    //put your code here

    public function index()
    {
        if ($this->session->userdata('IdUsuario') == '') {
            redirect('Cindex');
        }
    }

    public function validarPlaca()
    {
        $rta = $this->Mposrevision->buscarPrerevision($this->input->post("numero_placa_ref"));
        if ($rta->num_rows() > 0) {
            echo json_encode($rta->result());
        } else {
            echo 'FALSE';
        }
    }

    public function guardarFirma()
    {
        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            $archivo = fopen(
                "tcm/prerevision/" . $this->getDia() . "/" . $this->input->post('placa') . "/" .
                "sigpos_" . $this->input->post('ocasion') . ".dat",
                "w+b"
            );
        } else {
            $archivo = fopen(
                "c:/tcm/prerevision/" . $this->getDia() . "/" . $this->input->post('placa') . "/" .
                "sigpos_" . $this->input->post('ocasion') . ".dat",
                "w+b"
            );
        }

        $encrptopenssl = new Opensslencryptdecrypt();
        //$plain_txt = "this is awsome";
        $firma = $encrptopenssl->encrypt($this->input->post('firma'));  //encypting plain text
//$testdec = $encrptopenssl->decrypt($testenc);    //decrypting plain texx
//$firma = $this->encrypt->enconde();
        fwrite($archivo, $firma);
        fclose($archivo);
    }

    public function leerFirma()
    {
        $this->sistemaOperativo = sistemaoperativo();
        $encrptopenssl = new Opensslencryptdecrypt();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            $file = "tcm/prerevision/" . $this->getDia() . "/" . $this->input->post('placa') . "/" .
            "sigpos_" . $this->input->post('ocasion') . ".dat";
        }else{
            $file = "c:/tcm/prerevision/" . $this->getDia() . "/" . $this->input->post('placa') . "/" .
            "sigpos_" . $this->input->post('ocasion') . ".dat";
        }
        if (file_exists($file)) {
            $firma = file_get_contents($file, true);
            echo $encrptopenssl->decrypt($firma);
        } else {
            echo "NA";
        }
    }

    public function getDia()
    {
        $dia = strval($this->Mutilitarios->getNow());
        $dia = str_replace("-", "", $dia);
        $dia = substr($dia, 0, 8);
        return $dia;
    }

    public function guardarPosrevision()
    {
        $pre_dato['valor'] = $this->input->post('estado');
        $pre_dato['idpre_prerevision'] = $this->input->post('idpre_prerevision');
        $preAtributo['id'] = 'estado';
        $preAtributo['label'] = 'Estado de la inspeccion';
        $preZona['nombre'] = 'inicio';
        $this->Mprerevision->guardarPreDato($pre_dato, $preAtributo, $preZona);
        $pre_dato['valor'] = $this->input->post('articulo');
        $pre_dato['idpre_prerevision'] = $this->input->post('idpre_prerevision');
        $preAtributo['id'] = 'articulo';
        $preAtributo['label'] = 'Fur entregado por email';
        $preZona['nombre'] = 'inicio';
        $this->Mprerevision->guardarPreDato($pre_dato, $preAtributo, $preZona);
        if ($this->input->post('numero_solicitud') !== "") {
            $pre_dato['valor'] = $this->input->post('numero_solicitud');
            $pre_dato['idpre_prerevision'] = $this->input->post('idpre_prerevision');
            $preAtributo['id'] = 'numero_solicitud';
            $preAtributo['label'] = 'Número solicitud del RUNT';
            $preZona['nombre'] = 'firma';
            $this->Mprerevision->guardarPreDato($pre_dato, $preAtributo, $preZona);
        }
    }

}
