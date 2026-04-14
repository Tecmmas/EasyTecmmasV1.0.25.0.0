<?php

defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

class Cutilitarios extends CI_Controller
{

    var $vectorClases = "";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->helper('sistemaoperativo');
        $this->load->model("Mutilitarios");
        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
    }

    public $sistemaOperativo = "";

    public function index()
    {
        if ($this->session->userdata('IdUsuario') == '') {
            redirect('Cindex');
        }
    }

    private function setConf()
    {

        $conf = @file_get_contents("system/oficina.json");
        if (isset($conf)) {
            $encrptopenssl = new Opensslencryptdecrypt();
            $json = $encrptopenssl->decrypt($conf, true);
            $dat = json_decode($json, true);
            if ($dat) {
                foreach ($dat as $d) {
                    if ($d['nombre'] == "vectorClases") {
                        $this->vectorClases = $d['valor'];
                    }
                }
            }
        }
    }

    public function getNow()
    {
        echo $this->Mutilitarios->getNow();
    }

    public function getMarca()
    {
        echo file_get_contents('application/libraries/marca.json', true);
    }

    public function getLineas()
    {
        $idmarca = $this->input->post("idmarca");
        $lineas = json_decode(file_get_contents('application/libraries/linea.json', true));
        $datalin = [];
        foreach ($lineas as $linea) {
            if ($linea->idmarca == $idmarca) {
                $data['idlinea'] = $linea->idlinea;
                $data['nombre'] = $linea->nombre;
                array_push($datalin, $data);
            }
        }
        echo json_encode($datalin);
    }

    public function getColor()
    {
        echo file_get_contents('recursos/color.json', true);
    }

    public function getServicio()
    {
        echo file_get_contents('recursos/servicio.json', true);
    }

    public function getClase()
    {
        $this->setConf();
        //        echo $this->vectorClases;
        if ($this->vectorClases !== "") {
            $classes = json_decode(file_get_contents('recursos/clase.json', true));
            $newClases = array();
            for ($i = 0; $i < strlen($this->vectorClases); $i++) {
                $nombreClase = $this->confClases(substr($this->vectorClases, $i, 1), $i);
                foreach ($classes as $c) {
                    if ($nombreClase == $c->nombre) {
                        array_push($newClases, $c);
                    }
                }
            }
            echo json_encode($newClases);
        } else {
            echo file_get_contents('recursos/clase.json', true);
        }
    }

    public function getCombustible()
    {
        echo file_get_contents('recursos/combustible.json', true);
    }

    public function getCarroceria()
    {
        echo file_get_contents('recursos/carroceria.json', true);
    }

    public function getCiudad()
    {
        echo file_get_contents('recursos/ciudad.json', true);
    }

    public function getPais()
    {
        echo file_get_contents('recursos/pais.json', true);
    }

    public function getSensorial()
    {
        echo file_get_contents('recursos/sensorial.json', true);
    }

    public function getDefectos()
    {
        //        echo utf8_encode(file_get_contents('recursos/defectos.json', true));
        echo utf8_encode(file_get_contents('application/libraries/defectos.json', true));
    }

    //    private function formato_texto($cadena) {
    //        $no_permitidas = array("Ñ", "ñ", "á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹", "'", "");
    //        $permitidas = array("N", "n", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E", "", "");
    //        $texto = str_replace($no_permitidas, $permitidas, $cadena);
    //        return $texto;
    //    }

    public function CheckModulo()
    {
        $this->sistemaOperativo = sistemaoperativo();
        $this->crearDirTCM();
        $encrptopenssl = new Opensslencryptdecrypt();
        //        $filename = 'system/oficina.json';
        //        $file = fopen($filename, "r");
        //        $filesize = filesize($filename);
        //        $filetext = fread($file, $filesize);
        //        $json = $encrptopenssl->decrypt($filetext, true);
        $json = $encrptopenssl->decrypt(file_get_contents('system/oficina.json', true), true);
        echo $json;
    }

    public function getConfMaquina()
    {
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/' . $this->input->post('idconf_maquina') . '.json', true), true);
        echo $json;
    }

    private function crearDirTCM()
    {
        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            if (!is_dir("tcm")) {
                mkdir('tcm', 0777, true);
            }
        } else {
            if (!is_dir('c:/tcm')) {
                mkdir("c:/tcm", 0700);
            }
        }
    }

    private function crearDirPrerevision()
    {
        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            if (!is_dir("tcm/prerevision")) {
                mkdir('tcm/prerevision', 0777, true);
            }
        } else {
            if (!is_dir('c:/tcm/prerevision/')) {
                mkdir('c:/tcm/prerevision/', 0700);
            }
        }
    }

    private function crearDirUsuarios()
    {
        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            if (!is_dir("tcm/usuarios")) {
                mkdir('tcm/usuarios', 0777, true);
            }
        } else {
            if (!is_dir('c:/tcm/usuarios/')) {
                mkdir('c:/tcm/usuarios/', 0700);
            }
        }
    }

    private function crearDirPrerevisionDia()
    {
        $dia = $this->getDia();
        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            if (!is_dir("tcm/prerevision/" . $dia)) {
                mkdir('tcm/prerevision/' . $dia, 0777, true);
            }
        } else {
            if (!is_dir('c:/tcm/prerevision/' . $dia)) {
                mkdir('c:/tcm/prerevision/' . $dia, 0700);
            }
        }
    }

    public function crearDirPlacaPrerevision()
    {
        $this->crearDirTCM();
        $this->crearDirPrerevision();
        $this->crearDirPrerevisionDia();
        $this->sistemaOperativo = sistemaoperativo();
        $dia = $this->getDia();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {

            if (!is_dir("tcm/prerevision/" . $dia . "/" . $this->input->post('numero_placa'))) {
                mkdir('tcm/prerevision/' . $dia . "/" . $this->input->post('numero_placa'), 0777, true);
            }
        } else {
            if (!is_dir('c:/tcm/prerevision/' . $dia . "/" . $this->input->post('numero_placa'))) {
                mkdir('c:/tcm/prerevision/' . $dia . "/" . $this->input->post('numero_placa'), 0777, true);
            }
        }
    }

    public function crearDirUsuario()
    {
        $this->sistemaOperativo = sistemaoperativo();
        $this->crearDirTCM();
        $this->crearDirUsuarios();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            if (!is_dir("tcm/prerevision/" . $this->input->post('identificacion'))) {
                mkdir('tcm/prerevision/' . $this->input->post('identificacion'), 0777, true);
            }
        } else {
            if (!is_dir('c:/tcm/usuarios/' . $this->input->post('identificacion'))) {
                mkdir('c:/tcm/usuarios/' . $this->input->post('identificacion'), 0700);
            }
        }
    }

    public function validarFirma()
    {
        $identificacion = $this->input->post('identificacion');
        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            $file = "tcm/usuarios/" . $identificacion . "/sig.dat";


            if (file_exists($file)) {
                echo "TRUE";
            } else {
                echo "FALSE";
            }

            /* if (!is_dir("tcm/prerevision/" . $this->input->post('identificacion'))) {
                mkdir('tcm/prerevision/' . $this->input->post('identificacion'), 0777, true);
            } */

            /* if (file_exists("tcm/prerevision/$identificacion/sig.dat")) {
                echo 'TRUE';
            } else {
                echo 'FALSE';
            } */
        } else {
            $file = "c:/tcm/usuarios/$identificacion/sig.dat";

            if (file_exists($file)) {
                echo 'TRUE';
            } else {
                echo 'FALSE';
            }
        }
    }

    public function getDia()
    {
        $dia = strval($this->Mutilitarios->getNow());
        $dia = str_replace("-", "", $dia);
        $dia = substr($dia, 0, 8);
        return $dia;
    }

    function confClases($valor, $index)
    {

        switch ($index) {
            case "0":
                if ($valor == "1") {
                    return "AUTOMOVIL";
                } else {
                    return FALSE;
                }
                break;
            case "1":
                if ($valor == "1") {
                    return "BUS";
                } else {
                    return FALSE;
                }
                break;
            case "2":
                if ($valor == "1") {
                    return "BUSETA";
                } else {
                    return FALSE;
                }
                break;
            case "3":
                if ($valor == "1") {
                    return "CAMION";
                } else {
                    return FALSE;
                }
                break;
            case "4":
                if ($valor == "1") {
                    return "CAMIONETA";
                } else {
                    return FALSE;
                }
                break;
            case "5":
                if ($valor == "1") {
                    return "CAMPERO";
                } else {
                    return FALSE;
                }
                break;
            case "6":
                if ($valor == "1") {
                    return "MICROBUS";
                } else {
                    return FALSE;
                }
                break;
            case "7":
                if ($valor == "1") {
                    return "TRACTOCAMION";
                } else {
                    return FALSE;
                }
                break;
            case "8":
                if ($valor == "1") {
                    return "VOLQUETA";
                } else {
                    return FALSE;
                }
                break;
            case "9":
                if ($valor == "1") {
                    return "MOTOCICLETA";
                } else {
                    return FALSE;
                }
                break;
            case "10":
                if ($valor == "1") {
                    return "MAQ.AGRICOLA";
                } else {
                    return FALSE;
                }
                break;
            case "11":
                if ($valor == "1") {
                    return "MAQ.INDUSTRIAL";
                } else {
                    return FALSE;
                }
                break;
            case "12":
                if ($valor == "1") {
                    return "SEMIREMOLQUE";
                } else {
                    return FALSE;
                }
                break;
            case "13":
                if ($valor == "1") {
                    return "MOTOCARRO";
                } else {
                    return FALSE;
                }
                break;
            case "14":
                if ($valor == "1") {
                    return "REMOLQUE";
                } else {
                    return FALSE;
                }
                break;
            case "15":
                if ($valor == "1") {
                    return "SIN CLASE";
                } else {
                    return FALSE;
                }
                break;
            case "16":
                if ($valor == "1") {
                    return "MOTOTRICICLO";
                } else {
                    return FALSE;
                }
                break;
            case "17":
                if ($valor == "1") {
                    return "CUATRIMOTO";
                } else {
                    return FALSE;
                }
                break;
            case "18":
                if ($valor == "1") {
                    return "MAQ. CONSTRUCCION O MINERA";
                } else {
                    return FALSE;
                }
                break;
            case "19":
                if ($valor == "1") {
                    return "CICLOMOTOR";
                } else {
                    return FALSE;
                }
                break;
            case "20":
                if ($valor == "1") {
                    return "TRICIMOTO";
                } else {
                    return FALSE;
                }
                break;
            case "21":
                if ($valor == "1") {
                    return "CUADRICICLO";
                } else {
                    return FALSE;
                }
                break;
            case "22":
                if ($valor == "1") {
                    return "MOTOCICLO";
                } else {
                    return FALSE;
                }
                break;

            default:
                return FALSE;
                break;
        }
    }
}
