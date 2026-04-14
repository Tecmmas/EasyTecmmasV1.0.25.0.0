<?php

use SebastianBergmann\Environment\Console;

defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
//ini_set('memory_limit', '-1');
//set_time_limit(5);

ini_set('memory_limit', '-1');
set_time_limit(0);

class Cprerevision extends CI_Controller
{

    public $exactitud;
    public $generalLedger = "0";
    public $consePre = "0";
    var $sistemaOperativo = "";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("Mprerevision");
        $this->load->model("Mcliente");
        $this->load->model("OFCConsultarRuntModel");
        $this->load->model("Mutilitarios");
        $this->load->model("Musuario");
        $this->load->model("dominio/Msede");
        $this->load->library('Opensslencryptdecrypt');
        $this->exactitud = 65;
        espejoDatabase();
    }

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
                    if ($d['nombre'] == "generalLedger") {
                        $this->generalLedger = $d['valor'];
                    }
                    if ($d['nombre'] == "consePre") {
                        $this->consePre = $d['valor'];
                    }
                }
            }
        }
    }

    public function getConsecutivo()
    {
        $this->setConf();
        $tipo = $this->input->post('tipo');
        $cons = $this->Mprerevision->getConsecutivo($tipo, $this->consePre);
        if ($tipo == 1) {
            $cons = "TCM" . $cons;
        } else if ($tipo == 2) {
            $cons = "PRV" . $cons;
        } else {
            $cons = "PLB" . $cons;
        }
        echo $cons;
    }

    public function getInforme()
    {
        $encrptopenssl = new Opensslencryptdecrypt();
        $frm = $encrptopenssl->decrypt(file_get_contents('recursos/prerevision.json', true));
        $informe = json_decode($frm);
        $formulario = "";
        foreach ($informe as $i) {
            if ($i->zona == "formulario") {
                $formulario = $i->html;
                break;
            }
        }
        echo $formulario;
    }

    public $index;
    public $vehiculo;

    public function guardarDatoPrerevision()
    {
        //        var_dump($this->input->post('datos'));
        $this->setConf();
        $this->sistemaOperativo = sistemaoperativo();
        $cliente['nombre2'] = "";
        $cliente['apellido2'] = "";
        $cliente['telefono2'] = '';
        $cliente['numero_licencia'] = '';
        $cliente['categoria_licencia'] = '';
        $cliente['correo'] = '';
        $cliente['direccion'] = '';
        $cliente['telefono1'] = '';
        $propietario['nombre2'] = "";
        $propietario['apellido2'] = "";
        $propietario['telefono2'] = '';
        $propietario['numero_licencia'] = '';
        $propietario['categoria_licencia'] = '';
        $propietario['correo'] = '';
        $propietario['direccion'] = '';
        $propietario['telefono1'] = '';
        $datos = $this->input->post('datos');

        // console.log($datos);

        $key = array_keys($datos[0]);
        $i = 0;
        $this->index = 0;
        foreach ($datos[0] as $d) {
            //  echo $key[$i] . ": " . $d . "\n";
            $dto = explode("|", $d);
            switch ($dto[1]) {
                case 'vehiculos':
                    if ($key[$i] == 'scoote') {
                        $vehiculo['scooter'] = $dto[0];
                    } else {
                        $vehiculo[$key[$i]] = $dto[0];
                    }

                    break;
                case 'clientes':
        //             
                    $pro = explode("-", $key[$i]);
                    $cliente[$pro[0]] = $dto[0];
                //    var_dump($cliente);

                    $ifPropietario = "";
                    if (sizeof($pro) > 1) {
                        $ifPropietario = $pro[1];
                    }
                    if ($ifPropietario == "p") {
                        $propietario[$pro[0]] = $dto[0];
                    } else {
                        $cliente[$key[$i]] = $dto[0];
                    }
                    break;
                case "pre_prerevision":
                    $pre_prerevision[$key[$i]] = $dto[0];
                    break;
                default:
                    switch ($key[$i]) {
                        case 'chk-3':
                            $vehiculo['chk_3'] = $dto[0];
                            break;
                        case 'fecha_vencimiento_soat':
                             $vehiculo['fecha_vencimiento_soat'] = $dto[0];
                            break;
                        case 'fecha_final_certgas':
                            $vehiculo['fecha_final_certgas'] = $dto[0];
                            break;
                        case 'usuario':
                            $vehiculo['usuario'] = $dto[0];
                            break;
                        default:
                            break;
                    }
                    if (count($dto) > 2) {
                        $pre_datos[$this->index]['valor'] = $dto[0] . "|" . $dto[1] . "|" . $dto[2];
                    } else {
                        $pre_datos[$this->index]['valor'] = $dto[0];
                    }
                    $pre_datos[$this->index]['atributo'] = $key[$i];
                    $pre_datos[$this->index]['zona'] = "";
                    $pre_datos[$this->index]['label'] = "";
                    $pre_datos[$this->index]['orden'] = "";
                    $this->index++;
                    break;
            }
            $i++;
        }


        // $cliente['cumpleanos'] = $cliente['cumpleanos-p'];
        // unset($cliente['cumpleanos-p']);
        //var_dump($cliente);

        if ($cliente['cumpleanos'] !== '' && $cliente['cumpleanos'] !== null) {
            $cliente['cumpleanos'] = substr($cliente['cumpleanos'], 0, 4) . "-" . substr($cliente['cumpleanos'], 4, 2) . "-" . substr($cliente['cumpleanos'], 7, 2);
        } else {
            $cliente['cumpleanos'] = '1900-01-01';
        }
        $Rsede = $this->Msede->get();
        $sede = $Rsede->result();
        //$cliente['cod_ciudad'] = $cliente['cod_ciudad'];
        // if(isset($cliente['idciudadnew'])){
        //     $cliente['cod_ciudad'] = $cliente['idciudadnew'];
        // }
        $cliente['cod_ciudad'] = $this->Mprerevision->validarCiudad($cliente['cod_ciudad']);
        if ($cliente['cod_ciudad'] == '' || $cliente['cod_ciudad'] == null) {
            $cliente['cod_ciudad'] = $sede[0]->cod_ciudad;
        }
        $propietario['cod_ciudad'] = $propietario['cod_ciudad'];
        $propietario['cod_ciudad'] = $this->Mprerevision->validarCiudad($propietario['cod_ciudad']);
        if ($propietario['cod_ciudad'] == '' || $propietario['cod_ciudad'] == null) {
            $propietario['cod_ciudad'] = $sede[0]->cod_ciudad;
        }
        if ($propietario["numero_identificacion"] == null) {
            $cliente['propietario'] = 1;
        } else {
            $cliente['propietario'] = 0;
            $propietario['propietario'] = 1;
            if ($propietario['cumpleanos'] !== '' && $propietario['cumpleanos'] !== null) {
                $propietario['cumpleanos'] = substr($propietario['cumpleanos'], 0, 4) . "-" . substr($propietario['cumpleanos'], 4, 2) . "-" . substr($propietario['cumpleanos'], 7, 2);
            } else {
                $propietario['cumpleanos'] = '1900-01-01';
            }
        }
        
        //        $vehiculo["numero_llantas"] = $this->input->post("numero_llantas");
        //        $vehiculo["numejes"] = $this->input->post("numejes");
        //        $vehiculo["usuario"] = $pre_datos["usuario"];
        //            $pre_datos[$this->index]['atributo'] = 'usuario_registro';
        //            $pre_datos[$this->index]['zona'] = '0';
        //            $pre_datos[$this->index]['label'] = 'usuario_registro';
        //            $pre_datos[$this->index]['orden'] = '0';
        //            $pre_datos[$this->index]['valor'] = $vehiculo["usuario"];

        $this->guardarVehiculo($vehiculo, $cliente, $propietario);
        $pre_datos = $this->asignarHisto($pre_datos, "usuario_registro", $vehiculo["usuario"], "usuario_registro");
        $pre_datos = $this->asignarHisto($pre_datos, "histo_propietario", $this->vehiculo["idpropietarios"], "histo_propietario");
        $pre_datos = $this->asignarHisto($pre_datos, "histo_cliente", $this->vehiculo["idcliente"], "histo_cliente");
        $pre_datos = $this->asignarHisto($pre_datos, "histo_servicio", $this->vehiculo["idservicio"], "histo_servicio");
        $pre_datos = $this->asignarHisto($pre_datos, "histo_licencia", $this->vehiculo["numero_tarjeta_propiedad"], "histo_licencia");
        $pre_datos = $this->asignarHisto($pre_datos, "histo_color", $this->vehiculo["idcolor"], "histo_color");
        $pre_datos = $this->asignarHisto($pre_datos, "histo_combustible", $this->vehiculo["idtipocombustible"], "histo_combustible");
        $pre_datos = $this->asignarHisto($pre_datos, "histo_kilometraje", $this->vehiculo["kilometraje"], "histo_kilometraje");
        $pre_datos = $this->asignarHisto($pre_datos, "histo_blindaje", $this->vehiculo["blindaje"], "histo_blindaje");
        $pre_datos = $this->asignarHisto($pre_datos, "histo_polarizado", $this->vehiculo["polarizado"], "histo_polarizado");
        $this->guardarPrerevision($pre_prerevision, $pre_datos);
        $this->copiarFirma($vehiculo["numero_placa"], $vehiculo["usuario"], $pre_prerevision["reinspeccion"]);
        if ($this->generalLedger == "1") {

            if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
                if (!is_dir('GeneralLedger')) {
                    mkdir('GeneralLedger', 0777, true);
                }
            } else {
                if (!is_dir('C:\GeneralLedger')) {
                    mkdir('C:\GeneralLedger', 0777, true);
                }
            }

            $id = "";
            switch ($cliente['tipo_identificacion']) {
                case "1":
                    $id = "CC";
                    break;
                case "2":
                    $id = "NI";
                    break;
                case "3":
                    $id = "CE";
                    break;
                case "4":
                    $id = "TI";
                    break;
                case "6":
                    $id = "PA";
                    break;
                default:
                    $id = "CC";
                    break;
            }
            if ($id == "NI") {
                $_nr = $cliente['nombre1'] . " " . $cliente['nombre2'] . " " . $cliente['apellido1'] . " " . $cliente['apellido2'] . ";;;;";
            } else {
                $_nr = $cliente['nombre1'] . " " . $cliente['nombre2'] . " " . $cliente['apellido1'] . " " . $cliente['apellido2'] . ';' . $cliente['nombre1'] . ';' . $cliente['nombre2'] . ';' . $cliente['apellido1'] . ';' . $cliente['apellido2'];
            }
            if ($vehiculo['idservicio'] != "2") {
                $vehiculo['idservicio'] = "1";
            }
            switch ($vehiculo['tipo_vehiculo']) {
                case "1":
                    $vehiculo['tipo_vehiculo'] = "2";
                    break;
                case "2":
                    $vehiculo['tipo_vehiculo'] = "3";
                    break;
                case "3":
                    $vehiculo['tipo_vehiculo'] = "1";
                    break;
                default:
                    $vehiculo['tipo_vehiculo'] = "2";
                    break;
            }
            $cadena = $id . ';"";' . $cliente["numero_identificacion"] . ';"";' . $_nr . ';' . $cliente['direccion'] . ';' . $cliente['telefono1'] . ';' . $cliente['cod_ciudad'] . ';;' . $cliente['correo'] . ';;' . $vehiculo['numero_placa'] . ';' . $vehiculo['ano_modelo'] . ';' . $vehiculo['idservicio'] . ';' . $vehiculo['tipo_vehiculo'];
            if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
                $reporte = fopen('GeneralLedger/' . $vehiculo["numero_placa"] . '.txt', 'w+b');
                fwrite($reporte, $cadena);
                fclose($reporte);
                $d = "cd c:/
                 RD /S /Q GeneralLedger
                exit";
                $archivo = fopen('system/GeneralLedger.bat', "w+b");
                fwrite($archivo, $d);
                fclose($archivo);
                shell_exec('start system/GeneralLedger.bat');
            } else {
                $reporte = fopen('C:/GeneralLedger/' . $vehiculo["numero_placa"] . '.txt', 'w+b');
                fwrite($reporte, $cadena);
                fclose($reporte);
                $d = "cd c:/
                     RD /S /Q GeneralLedger
                    exit";
                $archivo = fopen('system/GeneralLedger.bat', "w+b");
                fwrite($archivo, $d);
                fclose($archivo);
                shell_exec('start C:/Apache24/htdocs/et/system/GeneralLedger.bat');
            }
        }
        echo "Operacion exitosa";

        //        var_dump($vehiculo);
        //        var_dump($pre_datos);
        //        var_dump($propietario);
        //        try {
        //            $encrptopenssl = New Opensslencryptdecrypt();
        //            $json = $encrptopenssl->decrypt(file_get_contents('recursos/prerevision.json', true));
        //            $informe = json_decode($json, true);
        //            //  var_dump($informe);
        //            $this->index = 0;
        //            $pre_datos = [];
        //            foreach ($informe as $i) {
        //                $dat = explode("|", $this->input->post($i["id"]));
        //                $val = $dat[0];
        //                $tabla = $dat[1];
        //                if ($tabla == "vehiculos") {
        //                    $vehiculo[$i["id"]] = $val;
        //                } else if ($tabla == "clientes") {
        //                    $pro = explode("-", $i["id"]);
        //                    $ifPropietario = "";
        //                    if (sizeof($pro) > 1)
        //                        $ifPropietario = $pro[1];
        //                    if ($ifPropietario == "p") {
        //                        $propietario[$pro[0]] = $val;
        //                    } else {
        //                        $cliente[$i["id"]] = $val;
        //                    }
        //                } else if ($tabla == "pre_prerevision") {
        //                    $pre_prerevision[$i["id"]] = $val;
        //                } else {
        //                    switch ($i["id"]) {
        //                        case 'chk-3':
        //                            $vehiculo['chk_3'] = $val;
        //                            break;
        //                        case 'fecha_vencimiento_soat':
        //                            $vehiculo['fecha_vencimiento_soat'] = $val;
        //                            break;
        //                        case 'fecha_final_certgas':
        //                            $vehiculo['fecha_final_certgas'] = $val;
        //                            break;
        //                        default:
        //                            break;
        //                    }
        //                    $pre_datos[$this->index]['atributo'] = $i["id"];
        //                    $pre_datos[$this->index]['zona'] = $i["zona"];
        //                    $pre_datos[$this->index]['label'] = $i["label"];
        //                    $pre_datos[$this->index]['orden'] = $i["orden"];
        //                    $pre_datos[$this->index]['valor'] = $this->input->post($i["id"]);
        //                    $this->index++;
        //                }
        //            }
        //
        //            for ($i = 1; $i < 6; $i++) {
        //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-1", $this->input->post("llanta-" . $i . "-1"), "Presion llanta " . $i);
        //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-D", $this->input->post("llanta-" . $i . "-D"), "Presion llanta eje " . $i . " derecha");
        //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-I", $this->input->post("llanta-" . $i . "-I"), "Presion llanta eje " . $i . " izquierda");
        //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-DI", $this->input->post("llanta-" . $i . "-DI"), "Presion llanta eje " . $i . " derecha interna");
        //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-DE", $this->input->post("llanta-" . $i . "-DE"), "Presion llanta eje " . $i . " derecha externa");
        //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-II", $this->input->post("llanta-" . $i . "-II"), "Presion llanta eje " . $i . " izquierda interna");
        //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-IE", $this->input->post("llanta-" . $i . "-IE"), "Presion llanta eje " . $i . " izquierda externa");
        //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-1-a", $this->input->post("llanta-" . $i . "-1-a"), "Presion llanta " . $i . " ajustada");
        //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-D-a", $this->input->post("llanta-" . $i . "-D-a"), "Presion llanta eje " . $i . " derecha ajustada");
        //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-I-a", $this->input->post("llanta-" . $i . "-I-a"), "Presion llanta eje " . $i . " izquierda ajustada");
        //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-DI-a", $this->input->post("llanta-" . $i . "-DI-a"), "Presion llanta eje " . $i . " derecha interna ajustada");
        //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-DE-a", $this->input->post("llanta-" . $i . "-DE-a"), "Presion llanta eje " . $i . " derecha externa ajustada");
        //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-II-a", $this->input->post("llanta-" . $i . "-II-a"), "Presion llanta eje " . $i . " izquierda interna ajustada");
        //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-IE-a", $this->input->post("llanta-" . $i . "-IE-a"), "Presion llanta eje " . $i . " izquierda externa ajustada");
        //            }
        //            $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-R", $this->input->post("llanta-R"), "Presion llanta de repuesto");
        //            $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-R2", $this->input->post("llanta-R2"), "Presion llanta 2 de repuesto");
        //            $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-R-a", $this->input->post("llanta-R-a"), "Presion llanta de repuesto ajustada");
        //            $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-R2-a", $this->input->post("llanta-R2-a"), "Presion llanta 2 de repuesto ajustada");
        //            $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta_ejes", $this->input->post("llanta_ejes"), "Configuracion inferior del vehiculo");
        //            if ($cliente['cumpleanos'] !== '' && $cliente['cumpleanos'] !== NULL) {
        //                $cliente['cumpleanos'] = substr($cliente['cumpleanos'], 0, 4) . "-" . substr($cliente['cumpleanos'], 4, 2) . "-" . substr($cliente['cumpleanos'], 7, 2);
        //            } else {
        //                $cliente['cumpleanos'] = '1900-01-01';
        //            }
        //            $Rsede = $this->Msede->get();
        //            $sede = $Rsede->result();
        //            $cliente['cod_ciudad'] = $this->validarDatoJson($cliente['cod_ciudad'], "ciudad");
        //            if ($cliente['cod_ciudad'] == '' || $cliente['cod_ciudad'] == NULL) {
        //                $cliente['cod_ciudad'] = $sede[0]->cod_ciudad;
        //            }
        //            $propietario['cod_ciudad'] = $this->validarDatoJson($propietario['cod_ciudad'], "ciudad");
        //            if ($propietario['cod_ciudad'] == '' || $propietario['cod_ciudad'] == NULL) {
        //                $propietario['cod_ciudad'] = $sede[0]->cod_ciudad;
        //            }
        //            if ($propietario["numero_identificacion"] == NULL) {
        //                $cliente['propietario'] = 1;
        //            } else {
        //                $cliente['propietario'] = 0;
        //                $propietario['propietario'] = 1;
        //                if ($propietario['cumpleanos'] !== '' && $propietario['cumpleanos'] !== NULL) {
        //                    $propietario['cumpleanos'] = substr($propietario['cumpleanos'], 0, 4) . "-" . substr($propietario['cumpleanos'], 4, 2) . "-" . substr($propietario['cumpleanos'], 7, 2);
        //                } else {
        //                    $propietario['cumpleanos'] = '1900-01-01';
        //                }
        //            }
        //            $cliente['nombre2'] = "";
        //            $cliente['apellido2'] = "";
        //            $propietario['nombre2'] = "";
        //            $propietario['apellido2'] = "";
        //            $vehiculo["numero_llantas"] = $this->input->post("numero_llantas");
        //            $vehiculo["numejes"] = $this->input->post("numejes");
        //            $vehiculo["usuario"] = $this->input->post("usuario");
        ////            $pre_datos[$this->index]['atributo'] = 'usuario_registro';
        ////            $pre_datos[$this->index]['zona'] = '0';
        ////            $pre_datos[$this->index]['label'] = 'usuario_registro';
        ////            $pre_datos[$this->index]['orden'] = '0';
        ////            $pre_datos[$this->index]['valor'] = $vehiculo["usuario"];
        //
        //            $this->guardarVehiculo($vehiculo, $cliente, $propietario);
        //            $pre_datos = $this->asignarHisto($pre_datos, "usuario_registro", $vehiculo["usuario"], "usuario_registro");
        //            $pre_datos = $this->asignarHisto($pre_datos, "histo_propietario", $this->vehiculo["idpropietarios"], "histo_propietario");
        //            $pre_datos = $this->asignarHisto($pre_datos, "histo_cliente", $this->vehiculo["idcliente"], "histo_cliente");
        //            $pre_datos = $this->asignarHisto($pre_datos, "histo_servicio", $this->vehiculo["idservicio"], "histo_servicio");
        //            $pre_datos = $this->asignarHisto($pre_datos, "histo_licencia", $this->vehiculo["numero_tarjeta_propiedad"], "histo_licencia");
        //            $pre_datos = $this->asignarHisto($pre_datos, "histo_color", $this->vehiculo["idcolor"], "histo_color");
        //            $pre_datos = $this->asignarHisto($pre_datos, "histo_combustible", $this->vehiculo["idtipocombustible"], "histo_combustible");
        //            $pre_datos = $this->asignarHisto($pre_datos, "histo_kilometraje", $this->vehiculo["kilometraje"], "histo_kilometraje");
        //            $pre_datos = $this->asignarHisto($pre_datos, "histo_blindaje", $this->vehiculo["blindaje"], "histo_blindaje");
        //            $pre_datos = $this->asignarHisto($pre_datos, "histo_polarizado", $this->vehiculo["polarizado"], "histo_polarizado");
        //            $this->guardarPrerevision($pre_prerevision, $pre_datos);
        //            $this->copiarFirma($vehiculo["numero_placa"], $vehiculo["usuario"], $pre_prerevision["reinspeccion"]);
        //            echo "Operación exitosa";
        //        } catch (Exception $exc) {
        //            echo "Error: " . $exc->getTraceAsString();
        //        }
    }

    //    public function guardarDatoPrerevision() {
    //        try {
    //            $encrptopenssl = New Opensslencryptdecrypt();
    //            $json = $encrptopenssl->decrypt(file_get_contents('recursos/prerevision.json', true));
    //            $informe = json_decode($json, true);
    //            //  var_dump($informe);
    //            $this->index = 0;
    //            $pre_datos = [];
    //            foreach ($informe as $i) {
    //                $dat = explode("|", $this->input->post($i["id"]));
    //                $val = $dat[0];
    //                $tabla = $dat[1];
    //                if ($tabla == "vehiculos") {
    //                    $vehiculo[$i["id"]] = $val;
    //                } else if ($tabla == "clientes") {
    //                    $pro = explode("-", $i["id"]);
    //                    $ifPropietario = "";
    //                    if (sizeof($pro) > 1)
    //                        $ifPropietario = $pro[1];
    //                    if ($ifPropietario == "p") {
    //                        $propietario[$pro[0]] = $val;
    //                    } else {
    //                        $cliente[$i["id"]] = $val;
    //                    }
    //                } else if ($tabla == "pre_prerevision") {
    //                    $pre_prerevision[$i["id"]] = $val;
    //                } else {
    //                    switch ($i["id"]) {
    //                        case 'chk-3':
    //                            $vehiculo['chk_3'] = $val;
    //                            break;
    //                        case 'fecha_vencimiento_soat':
    //                            $vehiculo['fecha_vencimiento_soat'] = $val;
    //                            break;
    //                        case 'fecha_final_certgas':
    //                            $vehiculo['fecha_final_certgas'] = $val;
    //                            break;
    //                        default:
    //                            break;
    //                    }
    //                    $pre_datos[$this->index]['atributo'] = $i["id"];
    //                    $pre_datos[$this->index]['zona'] = $i["zona"];
    //                    $pre_datos[$this->index]['label'] = $i["label"];
    //                    $pre_datos[$this->index]['orden'] = $i["orden"];
    //                    $pre_datos[$this->index]['valor'] = $this->input->post($i["id"]);
    //                    $this->index++;
    //                }
    //            }
    //
    //            for ($i = 1; $i < 6; $i++) {
    //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-1", $this->input->post("llanta-" . $i . "-1"), "Presion llanta " . $i);
    //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-D", $this->input->post("llanta-" . $i . "-D"), "Presion llanta eje " . $i . " derecha");
    //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-I", $this->input->post("llanta-" . $i . "-I"), "Presion llanta eje " . $i . " izquierda");
    //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-DI", $this->input->post("llanta-" . $i . "-DI"), "Presion llanta eje " . $i . " derecha interna");
    //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-DE", $this->input->post("llanta-" . $i . "-DE"), "Presion llanta eje " . $i . " derecha externa");
    //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-II", $this->input->post("llanta-" . $i . "-II"), "Presion llanta eje " . $i . " izquierda interna");
    //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-IE", $this->input->post("llanta-" . $i . "-IE"), "Presion llanta eje " . $i . " izquierda externa");
    //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-1-a", $this->input->post("llanta-" . $i . "-1-a"), "Presion llanta " . $i . " ajustada");
    //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-D-a", $this->input->post("llanta-" . $i . "-D-a"), "Presion llanta eje " . $i . " derecha ajustada");
    //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-I-a", $this->input->post("llanta-" . $i . "-I-a"), "Presion llanta eje " . $i . " izquierda ajustada");
    //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-DI-a", $this->input->post("llanta-" . $i . "-DI-a"), "Presion llanta eje " . $i . " derecha interna ajustada");
    //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-DE-a", $this->input->post("llanta-" . $i . "-DE-a"), "Presion llanta eje " . $i . " derecha externa ajustada");
    //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-II-a", $this->input->post("llanta-" . $i . "-II-a"), "Presion llanta eje " . $i . " izquierda interna ajustada");
    //                $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-" . $i . "-IE-a", $this->input->post("llanta-" . $i . "-IE-a"), "Presion llanta eje " . $i . " izquierda externa ajustada");
    //            }
    //            $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-R", $this->input->post("llanta-R"), "Presion llanta de repuesto");
    //            $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-R2", $this->input->post("llanta-R2"), "Presion llanta 2 de repuesto");
    //            $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-R-a", $this->input->post("llanta-R-a"), "Presion llanta de repuesto ajustada");
    //            $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta-R2-a", $this->input->post("llanta-R2-a"), "Presion llanta 2 de repuesto ajustada");
    //            $pre_datos = $this->asignarPresionLlantas($pre_datos, "llanta_ejes", $this->input->post("llanta_ejes"), "Configuracion inferior del vehiculo");
    //            if ($cliente['cumpleanos'] !== '' && $cliente['cumpleanos'] !== NULL) {
    //                $cliente['cumpleanos'] = substr($cliente['cumpleanos'], 0, 4) . "-" . substr($cliente['cumpleanos'], 4, 2) . "-" . substr($cliente['cumpleanos'], 7, 2);
    //            } else {
    //                $cliente['cumpleanos'] = '1900-01-01';
    //            }
    //            $Rsede = $this->Msede->get();
    //            $sede = $Rsede->result();
    //            $cliente['cod_ciudad'] = $this->validarDatoJson($cliente['cod_ciudad'], "ciudad");
    //            if ($cliente['cod_ciudad'] == '' || $cliente['cod_ciudad'] == NULL) {
    //                $cliente['cod_ciudad'] = $sede[0]->cod_ciudad;
    //            }
    //            $propietario['cod_ciudad'] = $this->validarDatoJson($propietario['cod_ciudad'], "ciudad");
    //            if ($propietario['cod_ciudad'] == '' || $propietario['cod_ciudad'] == NULL) {
    //                $propietario['cod_ciudad'] = $sede[0]->cod_ciudad;
    //            }
    //            if ($propietario["numero_identificacion"] == NULL) {
    //                $cliente['propietario'] = 1;
    //            } else {
    //                $cliente['propietario'] = 0;
    //                $propietario['propietario'] = 1;
    //                if ($propietario['cumpleanos'] !== '' && $propietario['cumpleanos'] !== NULL) {
    //                    $propietario['cumpleanos'] = substr($propietario['cumpleanos'], 0, 4) . "-" . substr($propietario['cumpleanos'], 4, 2) . "-" . substr($propietario['cumpleanos'], 7, 2);
    //                } else {
    //                    $propietario['cumpleanos'] = '1900-01-01';
    //                }
    //            }
    //            $cliente['nombre2'] = "";
    //            $cliente['apellido2'] = "";
    //            $propietario['nombre2'] = "";
    //            $propietario['apellido2'] = "";
    //            $vehiculo["numero_llantas"] = $this->input->post("numero_llantas");
    //            $vehiculo["numejes"] = $this->input->post("numejes");
    //            $vehiculo["usuario"] = $this->input->post("usuario");
    ////            $pre_datos[$this->index]['atributo'] = 'usuario_registro';
    ////            $pre_datos[$this->index]['zona'] = '0';
    ////            $pre_datos[$this->index]['label'] = 'usuario_registro';
    ////            $pre_datos[$this->index]['orden'] = '0';
    ////            $pre_datos[$this->index]['valor'] = $vehiculo["usuario"];
    //
    //            $this->guardarVehiculo($vehiculo, $cliente, $propietario);
    //            $pre_datos = $this->asignarHisto($pre_datos, "usuario_registro", $vehiculo["usuario"], "usuario_registro");
    //            $pre_datos = $this->asignarHisto($pre_datos, "histo_propietario", $this->vehiculo["idpropietarios"], "histo_propietario");
    //            $pre_datos = $this->asignarHisto($pre_datos, "histo_cliente", $this->vehiculo["idcliente"], "histo_cliente");
    //            $pre_datos = $this->asignarHisto($pre_datos, "histo_servicio", $this->vehiculo["idservicio"], "histo_servicio");
    //            $pre_datos = $this->asignarHisto($pre_datos, "histo_licencia", $this->vehiculo["numero_tarjeta_propiedad"], "histo_licencia");
    //            $pre_datos = $this->asignarHisto($pre_datos, "histo_color", $this->vehiculo["idcolor"], "histo_color");
    //            $pre_datos = $this->asignarHisto($pre_datos, "histo_combustible", $this->vehiculo["idtipocombustible"], "histo_combustible");
    //            $pre_datos = $this->asignarHisto($pre_datos, "histo_kilometraje", $this->vehiculo["kilometraje"], "histo_kilometraje");
    //            $pre_datos = $this->asignarHisto($pre_datos, "histo_blindaje", $this->vehiculo["blindaje"], "histo_blindaje");
    //            $pre_datos = $this->asignarHisto($pre_datos, "histo_polarizado", $this->vehiculo["polarizado"], "histo_polarizado");
    //            $this->guardarPrerevision($pre_prerevision, $pre_datos);
    //            $this->copiarFirma($vehiculo["numero_placa"], $vehiculo["usuario"], $pre_prerevision["reinspeccion"]);
    //            echo "Operación exitosa";
    //        } catch (Exception $exc) {
    //            echo "Error: " . $exc->getTraceAsString();
    //        }
    //    }

    private function asignarPresionLlantas($pre_datos, $id, $valor, $label)
    {
        if ($valor !== '' and $valor != null) {
            $pre_datos[$this->index]['atributo'] = $id;
            $pre_datos[$this->index]['zona'] = 'paire';
            $pre_datos[$this->index]['label'] = $label;
            $pre_datos[$this->index]['orden'] = '';
            $pre_datos[$this->index]['valor'] = $valor;
            $this->index++;
        }
        return $pre_datos;
    }

    private function asignarHisto($pre_datos, $id, $valor, $label)
    {
        if ($valor !== '' and $valor != null) {
            $pre_datos[$this->index]['atributo'] = $id;
            $pre_datos[$this->index]['zona'] = '0';
            $pre_datos[$this->index]['label'] = $label;
            $pre_datos[$this->index]['orden'] = '0';
            $pre_datos[$this->index]['valor'] = $valor;
            $this->index++;
        }
        return $pre_datos;
    }

    private function guardarVehiculo($vehiculo, $cliente, $propietario)
    {
        // $idmarca = $this->validarDatoJson($vehiculo["idmarca"], "marca");
        // $vehiculo["idcolor"] =  $this->validarDatoJson($vehiculo["idcolor"], "color");
        $vehiculo["idcolor"] = $vehiculo["idcolor"] ;
        $vehiculo["idclase"] = $this->Mprerevision->validarClase($vehiculo["idclase"]);




        //  $vehiculo["idlinea"] = $this->validarLinea($vehiculo["idlinea"], $idmarca);
         var_dump('---------------------------------------------------------------');
         var_dump($vehiculo["idlinea"]);

        $vehiculo["idlinea"] = $this->Mprerevision->validarLinea($vehiculo["idlinea"]);

        // $vehiculo["idlinea"] = $vehiculo["idlinea"];

        $vehiculo["idservicio"] = $this->validarDatoJson($vehiculo["idservicio"], "servicio");

        $vehiculo["idtipocombustible"] = $this->validarDatoJson($vehiculo["idtipocombustible"], "combustible");
        $vehiculo["idpais"] = $this->validarDatoJson($vehiculo["idpais"], "pais");
        $vehiculo["diseno"] = $this->validarDatoJson($vehiculo["diseno"], "carroceria");
        $vehiculo["idsoat"] = 1;
        $vehiculo["registrorunt"] = 1;
        // $vehiculo["cilindros"] = 1;
        if ($vehiculo["tiempos"] == '5' || $vehiculo["tiempos"] == '0') {
            $vehiculo["tiempos"] = 4;
        }
        $vehiculo['fecha_matricula'] = substr($vehiculo['fecha_matricula'], 0, 4) . "-" . substr($vehiculo['fecha_matricula'], 4, 2) . "-" . substr($vehiculo['fecha_matricula'], 6, 2);

        $propietario['nombre1'] = $this->quitar_tildes($propietario['nombre1']);
        $propietario['apellido1'] = $this->quitar_tildes($propietario['apellido1']);
        $propietario['telefono1'] = $propietario['telefono1'];
        $propietario['telefono2'] = $propietario['telefono2'];
        $propietario['direccion'] = $this->quitar_tildes($propietario['direccion']);
        $propietario['numero_licencia'] = $propietario['numero_licencia'];
        $propietario['categoria_licencia'] = $propietario['categoria_licencia'];
        $propietario['correo'] = $propietario['correo'];
        $vehiculo["idpropietarios"] = $this->validarCliente($propietario);
        $vehiculo['numero_vin'] = $vehiculo['numero_chasis'];
        if ($cliente["numero_identificacion"] == null) {
            $vehiculo["idcliente"] = $vehiculo["idpropietarios"];
        } else {

            $cliente['nombre1'] = $this->quitar_tildes($cliente['nombre1']);
            $cliente['apellido1'] = $this->quitar_tildes($cliente['apellido1']);
            $cliente['telefono1'] = $cliente['telefono1'];
            $cliente['telefono2'] = $cliente['telefono2'];
            $cliente['direccion'] = $this->quitar_tildes($cliente['direccion']);
            $cliente['numero_licencia'] = $cliente['numero_licencia'];
            $cliente['categoria_licencia'] = $cliente['categoria_licencia'];
            $cliente['correo'] = $cliente['correo'];
            $vehiculo["idcliente"] = $this->validarCliente($cliente);
        }
        unset($vehiculo["idmarca"]);
        unset($vehiculo['numero_chasis']);
        $this->vehiculo['idpropietarios'] = $vehiculo["idpropietarios"];
        $this->vehiculo['idcliente'] = $vehiculo["idcliente"];
        $this->vehiculo['idservicio'] = $vehiculo["idservicio"];
        $this->vehiculo['numero_tarjeta_propiedad'] = $vehiculo["numero_tarjeta_propiedad"];
        $this->vehiculo['idcolor'] = $vehiculo["idcolor"];
        $this->vehiculo['idtipocombustible'] = $vehiculo["idtipocombustible"];
        $this->vehiculo['kilometraje'] = $vehiculo["kilometraje"];
        $this->vehiculo['blindaje'] = $vehiculo["blindaje"];
        $this->vehiculo['polarizado'] = $vehiculo["polarizado"];
        $this->Mprerevision->guardarVehiculo($vehiculo);
    }

    private function guardarPrerevision($pre_prerevision, $pre_datos)
    {
        $idprerevision = $this->Mprerevision->guardarPrerevision($pre_prerevision);
        foreach ($pre_datos as $pd) {
            if ($pd["valor"] !== null) {
                $pre_dato['valor'] = $pd["valor"];
                $pre_dato['idpre_prerevision'] = $idprerevision;
                $preAtributo['id'] = $pd["atributo"];
                $preAtributo['label'] = $pd["label"];
                //        if ($pd["orden"] !== NULL) {
                $preAtributo['orden'] = $pd["orden"];
                //        }
                $preZona['nombre'] = $pd["zona"];
                switch ($pd["atributo"]) {
                    case 'histo_propietario':
                        $histoVehiculo['histo_propietario'] = $pre_dato['valor'];
                        break;
                    case 'histo_servicio':
                        $histoVehiculo['histo_servicio'] = $pre_dato['valor'];
                        break;
                    case 'histo_licencia':
                        $histoVehiculo['histo_licencia'] = $pre_dato['valor'];
                        break;
                    case 'histo_color':
                        $histoVehiculo['histo_color'] = $pre_dato['valor'];
                        break;
                    case 'histo_combustible':
                        $histoVehiculo['histo_combustible'] = $pre_dato['valor'];
                        break;
                    case 'histo_kilometraje':
                        $histoVehiculo['histo_kilometraje'] = $pre_dato['valor'];
                        break;
                    case 'histo_blindaje':
                        $histoVehiculo['histo_blindaje'] = $pre_dato['valor'];
                        break;
                    case 'histo_polarizado':
                        $histoVehiculo['histo_polarizado'] = $pre_dato['valor'];
                        break;
                    case 'usuario_registro':
                        $histoVehiculo['usuario_registro'] = $pre_dato['valor'];
                        break;
                    case 'histo_cliente':
                        $histoVehiculo['histo_cliente'] = $pre_dato['valor'];
                        break;
                    case 'chk-3':
                        $histoVehiculo['numero_certificado_gas'] = $pre_dato['valor'];
                        break;
                    case 'fecha_final_certgas':
                        $histoVehiculo['fecha_final_certgas'] = $pre_dato['valor'];
                        break;
                    case 'fecha_vencimiento_soat':
                        $histoVehiculo['fecha_vencimiento_soat'] = $pre_dato['valor'];
                        break;
                    case 'nombre_empresa':
                        $histoVehiculo['nombre_empresa'] = $pre_dato['valor'];
                        break;
                    default:
                        break;
                }
                $this->Mprerevision->guardarPreDato($pre_dato, $preAtributo, $preZona);
            }
        }
        $histoVehiculo['idpre_prerevision'] = $idprerevision;
        $histoVehiculo['tipo_inspeccion'] = $pre_prerevision['tipo_inspeccion'];
        $histoVehiculo['reinspeccion'] = $pre_prerevision['reinspeccion'];
        $this->Mprerevision->guardarHistoVehiculo($histoVehiculo);
    }

    private function validarCliente($cliente)
    {
        return $this->Mcliente->guardarCliente($cliente);
    }

    private function validarDatoJson($nombre, $entidad)
    {
        $codigo = "";
        $json = file_get_contents('recursos/' . $entidad . '.json', true);
        $datos = json_decode($json, true);
        foreach ($datos as $dat) {
            if ($dat["nombre"] == $nombre) {
                $codigo = $dat["codigo"];
                break;
            }
        }
        switch ($entidad) {
            case 'marca':
                $marca['idmarcaRUNT'] = $codigo;
                $marca['nombre'] = $nombre;
                $this->OFCConsultarRuntModel->InsertarMarcaRunt($marca);
                $marca2['idmarca'] = $codigo;
                $marca2['nombre'] = $nombre;
                $this->OFCConsultarRuntModel->InsertarMarcaLocal($marca2);
                break;
            case 'color':
                $color['idcolorRUNT'] = $codigo;
                $color['nombre'] = $nombre;
                $this->OFCConsultarRuntModel->InsertarColorRunt($color);
                $color2['idcolor'] = $codigo;
                $color2['nombre'] = $nombre;
                $this->OFCConsultarRuntModel->InsertarColorLocal($color2);
                break;
        }
        return $codigo;
    }


    private function validarLinea($nombre, $idMarca)
    {
        $codigo = "";
        $json = file_get_contents('application/libraries/linea.json', true);
        $datos = json_decode($json, true);
        foreach ($datos as $dat) {
            if (strtoupper($dat["nombre"]) == $nombre && $dat["idmarca"] == $idMarca) {
                $codigo = $dat["codigo"];
                break;
            }
        }
        $linea['idmarcaRUNT'] = $idMarca;
        $linea['codigo'] = $codigo;
        $linea['nombre'] = $nombre;
        $linea['idlineaRUNT'] = $this->OFCConsultarRuntModel->InsertarLineaRunt2($linea);
        $linea2['idmarca'] = $idMarca;
        $linea2['idmintrans'] = $codigo;
        $linea2['idrunt'] = $codigo;
        $linea2['nombre'] = $nombre;
        $this->OFCConsultarRuntModel->InsertarLineaLocal($linea2);
        return $linea['idlineaRUNT'];
    }

    private function copiarFirma($numero_placa, $id, $reins)
    {
        $rta1 = $this->Musuario->getUsuarioId($id);
        $rta = $rta1->result();
        $dia = $this->getDia();
        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            $firma1 = "tcm/usuarios/" . $rta[0]->identificacion . "/sig.dat";
            $firma2 = "tcm/prerevision/" . $dia . "/" . $numero_placa . "/sigp_" . $reins . ".dat";
        } else {
            $firma1 = "c:/tcm/usuarios/" . $rta[0]->identificacion . "/sig.dat";
            $firma2 = "c:/tcm/prerevision/" . $dia . "/" . $numero_placa . "/sigp_" . $reins . ".dat";
        }

        if (!copy($firma1, $firma2)) {
            echo "Error al copiar firma";
        }
    }

    public function cargarVehiculo()
    {
        $rtaVehiculo = $this->Mprerevision->cargarVehiculo($this->input->post("numero_placa"));
        if ($rtaVehiculo->num_rows() !== 0) {
            echo json_encode($rtaVehiculo->result());
        } else {
            echo 'FALSE';
        }
    }

    public function getDia()
    {
        $dia = strval($this->Mutilitarios->getNow());
        $dia = str_replace("-", "", $dia);
        $dia = substr($dia, 0, 8);
        return $dia;
    }

    public function getLlantaEjes()
    {
        $rta = $this->Mprerevision->llantaEjes($this->input->post("numero_placa"));
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
            echo $rta[0]->valor;
        } else {
            echo 'NA';
        }
    }

    private function quitar_tildes($cadena)
    {
        $no_permitidas = array("Ñ", "ñ", "á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹");
        $permitidas = array("N", "n", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E");
        $texto = str_replace($no_permitidas, $permitidas, $cadena);
        return $texto;
    }

    private function quitar_espacios($cadena)
    {
        return str_replace($cadena, " ", "");
    }

    public function scannerLicenciaTransito()
    {
        $cadena = $this->input->post("cadena");
        $datos_licencia = array(
            'NO.',
            'PLACA',
            'MARCA',
            'LÍNEA',
            'MODELO',
            'CILINDRADA CC',
            'COLOR',
            'SERVICIO',
            'CLASE DE VEHÍCULO',
            'TIPO CARROCERIA',
            'COMBUSTIBLE',
            'CAPACIDAD Kg/PSJ',
            'MOTOR',
            'VIN',
            'SERIE',
            'CHASIS',
        );
        $datos = explode("|", $cadena);
        $palabra = "";
        // no se ha encontrado la distancia más corta, aun
        $result = "";
        foreach ($datos as $dato) {
            $percent = 0;
            $item = explode("%", $dato);
            if (count($item) > 1) {
                $c = explode(",", $item[1]);
                $palabra = $item[0];
                foreach ($datos_licencia as $dl) {
                    similar_text($dl, $palabra, $percent);
                    if ($percent > $this->exactitud) {
                        if ($dl == "NO.") {
                            $h = intval($c[7]) - intval($c[1]);
                            $cby1 = intval($c[5]) - intval($h);
                            $cby2 = intval($c[5]) + intval($h);
                            $cbx1 = intval($c[4]);
                            $cbx2 = intval($c[4]) * 2;
                            $valor = $this->buscarValor($cby1, $cby2, $cbx1, $cbx2, $cadena);
                        } elseif ($dl == "CHASIS") {
                            $h = intval($c[7]) - intval($c[1]);
                            $cby1 = intval($c[5]);
                            $cby2 = intval($c[5]) + intval($h) * 3;
                            $cbx1 = intval($c[4]);
                            $cbx2 = intval($c[4]) + intval($h) * 15;
                            $valor = $this->buscarValorPuntoFinal($cby1, $cby2, $cbx1, $cbx2, $cadena);
                            if (substr($valor, 0, 2) == "N ") {
                                $valor = substr($valor, 2);
                            }
                        } else {
                            $h = intval($c[7]) - intval($c[1]);
                            $cby1 = intval($c[7]);
                            $cby2 = intval($c[7]) + intval($h) * 3;
                            $cbx1 = intval($c[6]) - intval($h);
                            $cbx2 = intval($c[6]) + intval($h);
                            $valor = $this->buscarValor($cby1, $cby2, $cbx1, $cbx2, $cadena);
                        }

                        $result = $result . $dl . ":" . $valor . "|";
                        break;
                    }
                }
            }
        }
        echo $result;
    }

    public function scannerLicenciaConduccion()
    {
        $cadena = $this->input->post("cadena");
        $datos_licencia = array(
            'NOMBRE',
            'NACIMIENTO',
            'NO. ',
        );
        $datos = explode("|", $cadena);
        $palabra = "";
        $result = "";
        foreach ($datos as $dato) {
            $percent = 0;
            $item = explode("%", $dato);
            if (count($item) > 1) {
                $c = explode(",", $item[1]);
                $palabra = $item[0];
                foreach ($datos_licencia as $dl) {
                    if ($dl == 'NO. ') {
                        similar_text($dl, substr($palabra, 0, 4), $percent);
                        if ($percent > $this->exactitud) {
                            $valor = substr($palabra, 4);
                            $result = $result . $dl . ":" . $valor . "|";
                            break;
                        }
                    } else {
                        similar_text($dl, $palabra, $percent);
                        if ($percent > $this->exactitud) {
                            $h = intval($c[7]) - intval($c[1]);
                            $cby1 = intval($c[7]);
                            $cby2 = intval($c[7]) + intval($h) * 3;
                            $cbx1 = intval($c[6]);
                            $cbx2 = intval($c[6]) + intval($h) * 10;
                            $valor = $this->buscarValor($cby1, $cby2, $cbx1, $cbx2, $cadena);
                            $result = $result . $dl . ":" . $valor . "|";
                            break;
                        }
                    }
                }
            }
        }
        echo $result;
    }

    public function scannerCedulaCiudadania()
    {
        $cadena = $this->input->post("cadena");
        $datos_licencia = array(
            'NUMERO',
            'APELLIDOS',
            'NOMBRES',
        );
        $datos = explode("|", $cadena);
        $palabra = "";
        $result = "";
        $yNum = 0;
        $xNum = 0;
        $yNam1 = 0;
        $xNam1 = 0;
        $yNam2 = 0;
        $xNam2 = 0;
        $yApe1 = 0;
        $xApe1 = 0;
        $yApe2 = 0;
        $xApe2 = 0;
        foreach ($datos as $dato) {
            $percent = 0;
            $item = explode("%", $dato);
            if (count($item) > 1) {
                $c = explode(",", $item[1]);
                $palabra = $item[0];
                foreach ($datos_licencia as $dl) {
                    if ($dl == 'NUMERO') {
                        similar_text($dl, $palabra, $percent);
                        if ($percent > $this->exactitud) {
                            $yNum = intval($c[5]);
                            $xNum = intval($c[4]);
                            $h = intval($c[7]) - intval($c[1]);
                            $cby1 = intval($c[3]) - intval($h) * 3;
                            $cby2 = intval($c[3]) + intval($h) * 1;
                            $cbx1 = intval($c[4]);
                            $cbx2 = intval($c[4]) + intval($h) * 7;
                            $valor = $this->buscarValor($cby1, $cby2, $cbx1, $cbx2, $cadena);
                            $result = $result . $dl . ":" . $valor . "|";
                            break;
                        }
                    } elseif ($dl == 'APELLIDOS') {
                        similar_text($dl, $palabra, $percent);
                        if ($percent > $this->exactitud) {
                            $yApe1 = intval($c[3]);
                            $xApe1 = intval($c[2]);
                            $yApe2 = intval($c[5]);
                            $xApe2 = intval($c[4]);
                            break;
                        }
                    } elseif ($dl == 'NOMBRES') {
                        similar_text($dl, $palabra, $percent);
                        if ($percent > $this->exactitud) {
                            $yNam1 = intval($c[3]);
                            $xNam1 = intval($c[2]);
                            $yNam2 = intval($c[5]);
                            $xNam2 = intval($c[4]);
                            break;
                        }
                    }
                }
            }
        }
        $valor = $this->buscarValor($yApe2, $yNam1, 0, $xNam2, $cadena);
        $result = $result . "NOMBRES:" . $valor . "|";
        $valor = $this->buscarValor($yNum, $yApe1, 0, $xApe2, $cadena);
        $result = $result . "APELLIDOS:" . $valor . "|";
        echo $result;
    }

    private function buscarValor($cby1, $cby2, $cbx1, $cbx2, $cadena)
    {
        $valor = "*****";
        $datos = explode("|", $cadena);
        foreach ($datos as $dato) {
            $item = explode("%", $dato);
            if (count($item) > 1) {
                $c = explode(",", $item[1]);
                if (
                    $c[0] >= $cbx1 &&
                    $c[0] <= $cbx2 &&
                    $c[1] >= $cby1 &&
                    $c[1] <= $cby2
                ) {
                    $valor = $item[0];
                    break;
                }
            }
        }
        return $valor;
    }

    private function buscarValorPuntoFinal($cby1, $cby2, $cbx1, $cbx2, $cadena)
    {
        $valor = "*****";
        $datos = explode("|", $cadena);
        foreach ($datos as $dato) {
            $item = explode("%", $dato);
            if (count($item) > 1) {
                $c = explode(",", $item[1]);
                if (
                    $c[2] >= $cbx1 &&
                    $c[2] <= $cbx2 &&
                    $c[3] >= $cby1 &&
                    $c[3] <= $cby2
                ) {
                    $valor = $item[0];
                    break;
                }
            }
        }
        return $valor;
    }
}
