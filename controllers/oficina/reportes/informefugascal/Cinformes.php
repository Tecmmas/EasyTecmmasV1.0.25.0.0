<?php

defined("BASEPATH") OR exit("No direct script access allowed");
header("Access-Control-Allow-Origin: *");
ini_set("memory_limit", "-1");
set_time_limit(300);

class Cinformes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper("form");
        $this->load->helper("url");
        $this->load->helper("security");
        $this->load->helper('download');
        $this->load->helper('date');
        $this->load->model("oficina/reportes/informefugascal/Minformes");
        $this->load->library('tcpdf');
        $this->load->library('Opensslencryptdecrypt');
        $this->load->dbutil();
        espejoDatabase();
    }

    public function index() {
        if ($this->session->userdata("IdUsuario") == "" || $this->session->userdata("IdUsuario") == "1024") {
            redirect("Cindex");
        }
        $encrptopenssl = New Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $rta ['maquina'] = json_decode($json);
        $this->load->view('oficina/reportes/informefugascal/Vgases_fugas_cal', $rta);
    }

// crea el informe de fugas,calibracion, linealida etc.
    public function gases_opa_data() {
        date_default_timezone_set('America/bogota');
        $tipo_reporte = $this->input->post('tipo_reporte');
        $idcontrol_fug_cal = $this->input->post('idcontrol_fug_cal');
        $idmaquina = $this->input->post('idmaquina');
        $encrptopenssl = New Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $data = json_decode($json);
        foreach ($data as $item) {
            if ($item->idconf_maquina == $idmaquina) {
                $marca = $item->marca;
                $serie_maquina = $item->serie_maquina;
                $serie_banco = $item->serie_banco;
            }
        }
        switch ($tipo_reporte) {
            case 1:
                $rta ['tipoinforme'] = 1;
                $rta ['titulo'] = strtoupper('Reporte Calibracion');
                $rta ['cda'] = $this->infocda();
                $rta ['imagen']->logo = base64_encode($rta['cda']->logo);
                $rta ['usuariogeneracion'] = $this->session->userdata('IdUsuario'); //la variable esta asignada al reporte, falta sacar el dato
                $rta ['fechageneracion'] = date("Y-m-d H:i:s");
                $rta ['sede'] = $this->infosede();
                $rta ['marca'] = ucwords(strtolower($marca));
                $rta ['modelo'] = strtoupper($serie_banco);
                $rta ['serial'] = strtoupper($serie_maquina);
                $rta ['autor'] = 'TECMMAS S.A.S';
                $rta ['cal'] = $this->result_cal_data($idcontrol_fug_cal, $idmaquina);
                $rta ['nombreuser'] = $this->usuario_prueba($rta ['cal']->usuario);
                $rta ['n'] = 'Nitrogeno de balance';
                $this->load->view('oficina/reportes/informefugascal/VPDF_report_gases_opa', $rta);
                break;
            case 2:
                $rta ['tipoinforme'] = 2;
                $rta ['titulo'] = strtoupper('Reporte Fugas');
                $rta ['cda'] = $this->infocda();
                $rta ['imagen']->logo = base64_encode($rta['cda']->logo);
                $rta ['usuariogeneracion'] = $this->session->userdata('IdUsuario'); //la variable esta asignada al reporte, falta sacar el dato
                $rta ['fechageneracion'] = date("Y-m-d H:i:s");
                $rta ['sede'] = $this->infosede();
                $rta ['marca'] = ucwords(strtolower($marca));
                $rta ['modelo'] = strtoupper($serie_banco);
                $rta ['serial'] = strtoupper($serie_maquina);
                $rta ['cal'] = $this->result_cal_data($idcontrol_fug_cal, $idmaquina);
                $rta ['fug'] = $this->result_fug_data($idcontrol_fug_cal, $idmaquina);
                $rta ['nombreuser'] = $this->usuario_prueba($rta ['fug']->usuario);
                $rta ['autor'] = 'TECMMAS S.A.S';
                $this->load->view('oficina/reportes/informefugascal/VPDF_report_gases_opa', $rta);
                break;
            case 3:
                $rta ['tipoinforme'] = 3;
                $rta ['titulo'] = strtoupper('Reporte Verificacion');
                $rta ['cda'] = $this->infocda();
                $rta ['imagen']->logo = base64_encode($rta['cda']->logo);
                $rta ['usuariogeneracion'] = $this->session->userdata('IdUsuario'); //la variable esta asignada al reporte, falta sacar el dato
                $rta ['fechageneracion'] = date("Y-m-d H:i:s");
                $rta ['sede'] = $this->infosede();
                $rta ['marca'] = ucwords(strtolower($marca));
                $rta ['modelo'] = strtoupper($serie_banco);
                $rta ['serial'] = strtoupper($serie_maquina);
                $rta ['pef'] = '0.512'; //la variable esta asignada al reporte, falta sacar el dato
                $rta ['autor'] = 'TECMMAS S.A.S';
                $this->load->view('oficina/reportes/informefugascal/VPDF_report_gases_opa', $rta);
                break;
            case 4:
                $rta ['tipoinforme'] = 4;
                $rta ['titulo'] = strtoupper('Reporte linealidad');
                $rta ['cda'] = $this->infocda();
                $rta ['imagen']->logo = base64_encode($rta['cda']->logo);
                $rta ['usuariogeneracion'] = $this->session->userdata('IdUsuario'); //la variable esta asignada al reporte, falta sacar el dato
                $rta ['fechageneracion'] = date("Y-m-d H:i:s");
                $rta ['sede'] = $this->infosede();
                $rta ['marca'] = ucwords(strtolower($marca));
                $rta ['modelo'] = strtoupper($serie_banco);
                $rta ['serial'] = strtoupper($serie_maquina);
                $rta ['ltoe'] = '215'; //la variable esta asignada al reporte, falta sacar el dato
                $rta ['autor'] = 'TECMMAS S.A.S';
                $this->load->view('oficina/reportes/informefugascal/VPDF_report_gases_opa', $rta);
                break;
            default:

                break;
        }
    }

// carga la informacion de fechas para el reporte dependiendo de la maquina y el tipo de reporte
    function carga_select() {
        $idmaquina = $this->input->post('idmaquina');
        $idreporte = $this->input->post('idreporte');
        switch ($idreporte) {
            case 1:
                $data = $this->Minformes->infocalibracion($idmaquina);
                echo json_encode($data);
                break;
            case 2:
                $data = $this->Minformes->infofugas($idmaquina);
                echo json_encode($data);
                break;
            case 3:
//                $data = $this->Minformes->infoverificacion($idmaquina);
//                echo json_encode($data);
                echo json_encode('verificacion');
                break;
            case 4:
//                $data = $this->Minformes->infodisel($idmaquina);
//                echo json_encode($data);
                echo json_encode('linealidad');
                break;
            default:
                break;
        }
    }

// consulta la tabla de calibraciones
    public function result_cal_data($idcontrol_fug_cal, $idmaquina) {
        $data = $this->Minformes->result_cal_data($idcontrol_fug_cal, $idmaquina);
        $rta = $data->result();
        return $rta [0];
    }

//consulta la tabka de fugas
    public function result_fug_data($idcontrol_fug_cal, $idmaquina) {
        $data = $this->Minformes->result_fug_data($idcontrol_fug_cal, $idmaquina);
        $rta = $data->result();
        return $rta [0];
    }

//consulta el usuario que realizo fugas o calbracion
    public function usuario_prueba($usuario) {
        $data = $this->Minformes->usuario_prueba($usuario);
        $rta = $data->result();
        return $rta [0];
    }

//consulta la informacion del cda
    function infocda() {
        $data = $this->Minformes->infocda();
        $rta = $data->result();
        return $rta [0];
    }

//consulta la informacion de la tabla sede
    function infosede() {
        $data = $this->Minformes->infosede();
        $rta = $data->result();
        return $rta [0];
    }

}
