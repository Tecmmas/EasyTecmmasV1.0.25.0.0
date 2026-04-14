<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
ini_set('memory_limit', '-1');
set_time_limit(0);

class Cconf extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model('dominio/Mcda');
        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
    }

    public function index() {
        // if ($this->session->userdata('IdUsuario') !== '1024') {
        //     redirect('Cindex');
        // }
        if (!$data['conf'] = @file_get_contents("system/oficina.json")) {
            $this->load->view('oficina/login/Vconf', $data);
        } else {
            $this->load->view('oficina/login/Vconf');
        }
    }

    public function solicitar() {
        $this->form_validation->set_rules('url', 'Url Cliente', 'required');
        if ($this->form_validation->run()) {
            if ($this->cdaValido($this->getCdaLocal(), $this->getCdaUrl($this->input->post('url')))) {
                $codigoOficina = $this->oficinaValida($this->input->post('url'));
                if ($codigoOficina !== "") {
                    if ($dat = $this->getConfOficina($this->input->post('url'), $codigoOficina)) {
                        $data['conf'] = $dat;
                        $data['url'] = $this->input->post('url');
//                        $this->showConf($data);
                    }
                    $this->getMaquinas($this->input->post('url'));
                } else {

                    //traping de error
                }
            } else {
                $data['mensaje'] = '<strong style="color: red">Dominio no válido o no corresponde a este CDA</strong>';
            }
        }
        $data['url'] = $this->input->post('url');
        $this->load->view('oficina/login/Vconf', $data);
    }

    private function getCdaLocal() {
        $result = $this->Mcda->get();
        if ($result->num_rows() > 0) {
            $rta = $result->result();
            return $rta[0]->nombre_cda;
        } else {
            return '';
        }
    }

    private function getCdaUrl($url) {
        try {
            $url = "http://" . $url . "/cda/index.php/Cservicio/getCda";
            if (!$data = @file_get_contents($url)) {
                return ''; //trapin de error
            } else {
                return $data;
            }
        } catch (Exception $exc) {
            echo '0001';
        }
    }

    private function oficinaValida($url) {
        try {
            $url = "http://" . $url . "/cda/index.php/Cservicio/getLineas";
            if (!$data = @file_get_contents($url)) {
//                echo '0001'; //trapin de error
            } else {
                $encrptopenssl = New Opensslencryptdecrypt();
                $json = $encrptopenssl->decrypt($data, true);
                $dat = json_decode($json, true);
                $existe = false;
                $codigoOf = "";
                foreach ($dat as $d) {
                    if ("oficina" === $d['nombre']) {
                        $existe = true;
                        $codigoOf = $d['idconf_maquina'];
                        break;
                    }
                }
                if ($existe) {
                    return $codigoOf;
                } else {
                    return "";
                }
//                $archivo = fopen("system/" . $this->input->post("file") . ".json", "w+b");
//                fwrite($archivo, file_get_contents($url));
//                fclose($archivo);
//                echo "0000";
            }
        } catch (Exception $exc) {
//            echo '0001';
        }
    }

    private function cdaValido($cdaLocal, $cdaUrl) {
        if ($cdaLocal == $cdaUrl) {
            return true;
        } else {
            return false;
        }
    }

    private function getMaquinas($url2) {
        try {
            $url = "http://" . $url2 . "/cda/index.php/Cservicio/getLineas";
            if (!$data = @file_get_contents($url)) {
                //Trapping
            } else {
                $archivo = fopen("system/lineas.json", "w+b");
                fwrite($archivo, file_get_contents($url));
                fclose($archivo);
                $encrptopenssl = New Opensslencryptdecrypt();
                $json = $encrptopenssl->decrypt($data, true);
                $dat = json_decode($json, true);
                foreach ($dat as $d) {
                    $this->getConfMaquina($url2, $d['idconf_maquina']);
                    usleep(100);
                }
            }
        } catch (Exception $exc) {
//            echo '0001';
        }
    }

    public function getConfMaquina($url, $idconf_maquina) {
        try {
            $url = "http://" . $url . "/cda/index.php/Cservicio/getConfMaquina?idmaquina=" . $idconf_maquina;
            $archivo = fopen("system/" . $idconf_maquina . ".json", "w+b");
            if (!$data = @file_get_contents($url)) {
                echo '0001';
            } else {
                fwrite($archivo, file_get_contents($url));
                fclose($archivo);
//                echo "0000";
            }
        } catch (Exception $exc) {
            echo '0001';
        }
    }

    private function getConfOficina($url, $idOficina) {
        try {
            $url = "http://" . $url . "/cda/index.php/Cservicio/getConfMaquina?idmaquina=" . $idOficina;
//            $archivo = fopen("system/oficina.json", "w+b");
            if (!$data = file_get_contents($url)) {
                return false; //Traping de error
            } else {
                $archivo = fopen("system/oficina.json", "w+b");
                fwrite($archivo, $data);
                fclose($archivo);
                return $data;
            }
        } catch (Exception $exc) {
            return false;
        }
    }

}
