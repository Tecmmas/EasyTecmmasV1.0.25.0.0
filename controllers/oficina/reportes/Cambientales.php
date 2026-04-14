<?php

defined("BASEPATH") or exit("No direct script access allowed");
header("Access-Control-Allow-Origin: *");
ini_set("memory_limit", "-1");
set_time_limit(1000);

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class Cambientales extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("form");
        $this->load->helper("url");
        $this->load->helper("security");
        $this->load->helper('download');
        $this->load->model("oficina/reportes/Mambientales");
        $this->load->model("oficina/reportes/informefugascal/Minformes");
        $this->load->library('Opensslencryptdecrypt');
        $this->load->library('zip');
        $this->load->dbutil();
        espejoDatabase();
    }

    var $tipoInforme;
    var $clavePublica;
    var $clavePrivada;
    var $tipo_informe_fugas_cal_lin = "NA";
    var $nullData = 0;
    var $numeroExpediente = 0;
    var $razonSocialCda = 0;
    var $informeWebCornare = 0;
    var $informeWebBogota = 0;
    var $idsedeWebBogota = 0;

    public function index()
    {
        if ($this->session->userdata("IdUsuario") == "" || $this->session->userdata("IdUsuario") == "1024") {
            redirect("Cindex");
        }

        // if (!is_dir('C:\prueba')) {
        //     mkdir('C:\prueba', 0777, true);
        // }
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $rta['maquina'] = json_decode($json);
        $this->setConf();
        $data = $this->tipoInforme;
        $this->Mambientales->createTableControl();
        $dominio = file_get_contents('system/dominio.dat', true);
        if (!empty($data)) {

            $rta['tipoinforme'] = $data;
            $rta['informeWebBogota'] = $this->informeWebBogota;
            $rta['FugasCal'] = $this->tipo_informe_fugas_cal_lin;
            $rta['c'] = 0;
            $this->load->view('oficina/reportes/Vambientales', $rta);
        } else {
            $rta['message'] = 'No se asigno ningún tipo de informe, por favor comuníquese con el are de soporte.';
            $rta['heading'] = 'Error de configuración';
            $this->load->view('errors/html/error_general.php', $rta);
        }
        //        echo phpinfo();
        //        $rta ['tipoinforme'] = 'Carder';
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
                    if ($d['nombre'] == "tipoInforme") {
                        $this->tipoInforme = $d['valor'];
                    }
                    if ($d['nombre'] == "clavePrivada") {
                        $this->clavePrivada = $d['valor'];
                    }
                    if ($d['nombre'] == "clavePublica") {
                        $this->clavePublica = $d['valor'];
                    }
                    if ($d['nombre'] == "tipo_informe_fugas_cal_lin") {
                        $this->tipo_informe_fugas_cal_lin = $d['valor'];
                    }
                    if ($d['nombre'] == "NumeroExpediente") {
                        $this->numeroExpediente = $d['valor'];
                    }
                    if ($d['nombre'] == "razonSocialCda") {
                        $this->razonSocialCda = $d['valor'];
                    }
                    if ($d['nombre'] == "informeWebCornare") {
                        $this->informeWebCornare =  $d['valor'];
                    }
                    if ($d['nombre'] == "informeWebBogota") {
                        $this->informeWebBogota =  $d['valor'];
                    }
                    if ($d['nombre'] == "idsedeWebBogota") {
                        $this->idsedeWebBogota =  $d['valor'];
                    }
                }
            }
        }
    }

    function generar()
    {
        $this->setConf();
        $datoInforme = $this->tipo_informe_fugas_cal_lin;

        if ($datoInforme == "NA") {
            $datoInforme = $this->input->post('informeNewAnt');
        } else {
            $datoInforme = $this->tipo_informe_fugas_cal_lin;
        }
        $tipoinforme = $this->input->post('tipoinforme');
        $csvdowload = $this->input->post('csvdowload');
        $tipoinspeccion = $this->input->post('tipo_inspeccion');
        $idconf_maquina = $this->input->post('idconf_maquina');
        $fechainicial = $this->input->post('fechainicial');
        $fechafinal = $this->input->post('fechafinal');
        $prueba = $this->input->post('prueba');
        $serieanalizador = $this->input->post('serieanalizador');
        $idconf_linea_inspeccion = $this->input->post('idconf_linea_inspeccion');
        $this->form_validation->set_rules('fechainicial', 'fechafinal', 'required', array('required' => 'Campo obligatorio'));
        $this->form_validation->set_rules('fechafinal', 'fechafinal', 'required', array('required' => 'Campo obligatorio'));

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            switch ($tipoinforme) {
                case 'Carder':
                    $this->informecarder($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme);
                    break;
                case 'Corponarino':
                    $this->informecorponarino($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme);
                    break;
                case 'Metropolitana':
                    $this->informemetropolitana($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme);
                    break;
                case 'Car':
                    $this->informecar($tipoinspeccion, $idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $tipoinforme, $serieanalizador, $datoInforme, $csvdowload);
                    break;
                case 'Corantioquia':
                case 'Corpouraba':
                    $this->informecorantioquia($tipoinspeccion, $idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    break;
                case 'Bogota':
                    $this->informebogota($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $tipoinforme, $serieanalizador, $datoInforme, $csvdowload);
                    break;
                case 'Cormacarena':
                    $this->informecormacarena($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme);
                    break;
                case 'Cornare':
                    $this->informecornare($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme);
                    break;
                // case 'Corpouraba':
                //     $this->informecorpouraba($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme);
                //     break;
                case 'Sema':
                    $this->informesema($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme);
                    break;
                case 'Corpocaldas':
                    $this->informeCorpocaldas($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme);
                    break;
                case 'Corponor':
                    $this->informecorponor($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme);
                case 'Corpoboyaca':
                    $this->informeCorpoboyaca($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme);
                    break;
                case 'Corpocesar':
                    $this->informeCorpocesar($tipoinspeccion, $idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    break;
                case 'Cortolima':
                    $this->informeCortolima($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $tipoinforme, $datoInforme);
                    break;
                case 'Epa':
                    $this->informeEpa($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $tipoinforme, $datoInforme);
                    break;
                default:
                    break;
            }
        }
    }

    public function informecarder($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme)
    {
        switch ($prueba) {
            case 'analizador':
                if ($idconf_linea_inspeccion == 3 || $idconf_linea_inspeccion == 9 || $idconf_linea_inspeccion == 10) {
                    //                    $query = $this->Mambientales->informecarder_motos($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    $query = $this->Mambientales->informe_762($idconf_maquina, $fechainicial, $fechafinal, $datoInforme, 3, 3);
                    $filename = ' Informe Carder Motos';
                    $this->informe762($query, $filename, $idconf_maquina);
                    //                    $this->downloadinforme($query, $filename, $idconf_maquina);
                } else {
                    //                    $query = $this->Mambientales->informecarder_gasolina($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);

                    $query = $this->Mambientales->informe_762($idconf_maquina, $fechainicial, $fechafinal, $datoInforme, 1, 3);
                    $filename = ' Informe Carder Gasolina';
                    $this->informe762($query, $filename, $idconf_maquina);
                    //                    $this->downloadinforme($query, $filename, $idconf_maquina);
                }
                break;
            case 'opacidad':
                $query = $this->Mambientales->informe_762($idconf_maquina, $fechainicial, $fechafinal, $datoInforme, 2, 2);
                //                $query = $this->Mambientales->informecarder_disel($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                $filename = ' Informe Carder Diesel';
                $this->informe762($query, $filename, $idconf_maquina);
                //$this->downloadinforme($query, $filename, $idconf_maquina);
                break;
            default:
                echo 'ninguno';
                break;
        }
    }

    public function informecorponarino($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme)
    {
        switch ($prueba) {
            case 'analizador':
                if ($idconf_linea_inspeccion == 3 || $idconf_linea_inspeccion == 9 || $idconf_linea_inspeccion == 10) {
                    $query = $this->Mambientales->informecorponarino_motos($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    $filename = 'Informe Corponarino Motos';
                    $this->downloadinforme($query, $filename, $idconf_maquina);
                } else {
                    $query = $this->Mambientales->informecorponarino_gasolina($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    $filename = 'Informe Corponarino Gasolina';
                    $this->downloadinforme($query, $filename, $idconf_maquina);
                }
                break;
            case 'opacidad':
                $query = $this->Mambientales->informecorponarino_disel($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                $filename = 'Informe Corponarino Diesel';
                $this->downloadinforme($query, $filename, $idconf_maquina);
                break;
            default:
                break;
        }
    }

    public function informemetropolitana($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme)
    {
        switch ($prueba) {
            case 'analizador':
                if ($idconf_linea_inspeccion == 3 || $idconf_linea_inspeccion == 9 || $idconf_linea_inspeccion == 10) {
                    $query = $this->Mambientales->informe_metropolitana_motos($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    $filename = 'Informe Metropolitana Motos';
                    $this->downloadinforme($query, $filename, $idconf_maquina);
                } else {
                    $query = $this->Mambientales->informe_metropolitana_gasolina($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    $filename = 'Informe Metropolitana Gasolina';
                    $this->downloadinforme($query, $filename, $idconf_maquina);
                }
                break;
            case 'opacidad':
                $query = $this->Mambientales->informe_metropolitana_disel($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                $filename = 'Informe Metropolitana Diesel';
                $this->downloadinforme($query, $filename, $idconf_maquina);
                break;
            default:
                break;
        }
    }

    public function informecar($tipoinspeccion, $idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $tipoinforme, $serieanalizador, $datoInforme, $csvdowload)
    {
        date_default_timezone_set('America/bogota');
        $date = date("d-m-Y");
        $rta['cda'] = $this->infocda();
        $numero_resolucion = $rta['cda']->numero_resolucion;
        $serie = substr($serieanalizador, -4);
        // echo $idconf_linea_inspeccion . '<br>';
        //echo  $prueba;
        switch ($prueba) {
            case 'analizador':
                if ($idconf_linea_inspeccion == 3 || $idconf_linea_inspeccion == 9 || $idconf_linea_inspeccion == 10) {

                    $query = $this->Mambientales->informe_car_motos($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);

                    // $resolucion = str_pad($numero_resolucion, 5, "0", STR_PAD_LEFT);

                    $fileNamee = $numero_resolucion . ' ' . $date . ' ' . $serie;
                    $this->getInformacionAtalaya($query, $idconf_maquina, 1);
                    // $this->download_car_bogota($query, $filename, $idconf_maquina, $tipoinforme, $serieanalizador, $csvdowload);

                    //$this->download_car_bogota($query, $filename, $idconf_maquina, $tipoinforme, $serieanalizador, $csvdowload);
                } else {
                    $query = $this->Mambientales->informe_car_gasolina($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    $fileNamee = $numero_resolucion . ' ' . $date . ' ' . $serie;
                    $this->getInformacionAtalaya($query, $idconf_maquina, 1);
                    // $filename = 'G';
                    // $this->download_car_bogota($query, $filename, $idconf_maquina, $tipoinforme, $serieanalizador, $csvdowload);
                }
                break;
            case 'opacidad':
                $query = $this->Mambientales->informe_car_disel($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                $fileNamee = $numero_resolucion . ' ' . $date . ' ' . $serie;
                $this->getInformacionAtalaya($query, $idconf_maquina, 1);
                break;
            default:
                break;
        }
    }

    public function informecorantioquia($tipoinspeccion, $idconf_maquina, $fechainicial, $fechafinal,  $datoInforme)
    {
        $dowonload = 0;
        $motocarro = 0;
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $rta = json_decode($json);
        $res = $this->getInformacionAtalaya($this->Mambientales->datosGeneralesCorantioquia(), 3, $dowonload);
        $dagRta = [];
        $data1 = [];
        $data2 = [];
        $data3 = [];
        foreach ($rta as $item) {

            switch ($item->prueba) {
                case 'analizador':

                    if ($item->idconf_linea_inspeccion == 3 || $item->idconf_linea_inspeccion == 9 || $item->idconf_linea_inspeccion == 10) {

                        if ($tipoinspeccion) {
                            if ($tipoinspeccion == 1) {
                                $where = '(h.reinspeccion=0 or h.reinspeccion=1)';
                            } elseif ($tipoinspeccion == 4444) {
                                $where = '(h.reinspeccion=4444 or h.reinspeccion=44441)';
                            } else {
                                $where = 'h.reinspeccion=8888';
                            }
                            if ($item->activo == 1) {
                                $motocarro = 0;
                                $query = $this->Mambientales->informe_corantioquia_motos($where, $item->idconf_maquina, $fechainicial, $fechafinal, $datoInforme, $motocarro);
                                $data1['motos'] = $this->getInformacionAtalaya($query, $item->idconf_maquina, $dowonload);
                                array_push($dagRta, $data1);
                            }

                            // $this->exporExcelCorantioquia($res);
                            // $filename = "Informe corantioquia Motos";
                            //$this->downloadInforemeCorantioquia($query);
                        }
                    } else {
                        if ($tipoinspeccion) {
                            if ($tipoinspeccion == 1) {
                                $where = '(h.reinspeccion=0 or h.reinspeccion=1)';
                            } elseif ($tipoinspeccion == 4444) {
                                $where = '(h.reinspeccion=4444 or h.reinspeccion=44441)';
                            } else {
                                $where = 'h.reinspeccion=8888';
                            }
                            if ($item->activo == 1) {
                                //consulta para motocarro

                                $motocarro = 1;
                                $query = $this->Mambientales->informe_corantioquia_motos($where, $item->idconf_maquina, $fechainicial, $fechafinal, $datoInforme, $motocarro);
                                $data1['motos'] = $this->getInformacionAtalaya($query, $item->idconf_maquina, $dowonload);
                                array_push($dagRta, $data1);
                                $query = $this->Mambientales->informe_corantioquia_gasolina($where, $item->idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                                $data2['livianos'] = $this->getInformacionAtalaya($query, $item->idconf_maquina, $dowonload);
                                array_push($dagRta, $data2);
                            }
                        }
                    }
                    break;
                case 'opacidad':
                    if ($tipoinspeccion) {
                        if ($tipoinspeccion == 1) {
                            $where = '(h.reinspeccion=0 or h.reinspeccion=1)';
                        } elseif ($tipoinspeccion == 4444) {
                            $where = '(h.reinspeccion=4444 or h.reinspeccion=44441)';
                        } else {
                            $where = 'h.reinspeccion=8888';
                        }
                        if ($item->activo == 1) {
                            $query = $this->Mambientales->informe_corantioquia_disel($where, $item->idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                            $data3['diesel'] = $this->getInformacionAtalaya($query, $item->idconf_maquina, $dowonload);
                            array_push($dagRta, $data3);
                        }
                    }

                    break;
                default:
                    break;
            }
        }
        $this->exporExcelCorantioquia($res, $dagRta);
        // echo '<pre>';
        // var_dump($dagRta);
        // echo '</pre>';

    }

    public function informebogota($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $tipoinforme, $serieanalizador, $datoInforme, $csvdowload)
    {
        switch ($prueba) {
            case 'analizador':
                if ($idconf_linea_inspeccion == 3 || $idconf_linea_inspeccion == 9 || $idconf_linea_inspeccion == 10) {
                    $query = $this->Mambientales->informe_bogota_motos($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    $filename = 'M';
                    $this->download_car_bogota($query, $filename, $idconf_maquina, $tipoinforme, $serieanalizador, $csvdowload);
                } else {
                    $query = $this->Mambientales->informe_bogota_gasolina($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    $filename = 'G';
                    $this->download_car_bogota($query, $filename, $idconf_maquina, $tipoinforme, $serieanalizador, $csvdowload);
                }
                break;
            case 'opacidad':
                $query = $this->Mambientales->informe_bogota_disel($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                $filename = 'D';
                $this->download_car_bogota($query, $filename, $idconf_maquina, $tipoinforme, $serieanalizador, $csvdowload);
                break;
            default:
                break;
        }
    }

    public function informeCorpocesar($tipoinspeccion, $idconf_maquina, $fechainicial, $fechafinal,  $datoInforme)
    {
        $dowonload = 0;
        $motocarro = 0;
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $rta = json_decode($json);
        $res = $this->getInformacionAtalaya($this->Mambientales->datosGeneralesCorantioquia(), 3, $dowonload);
        $dagRta = [];
        $data1 = [];
        $data2 = [];
        $data3 = [];
        foreach ($rta as $item) {

            switch ($item->prueba) {
                case 'analizador':

                    if ($item->idconf_linea_inspeccion == 3 || $item->idconf_linea_inspeccion == 9 || $item->idconf_linea_inspeccion == 10) {

                        if ($tipoinspeccion) {
                            if ($tipoinspeccion == 1) {
                                $where = '(h.reinspeccion=0 or h.reinspeccion=1)';
                            } elseif ($tipoinspeccion == 4444) {
                                $where = '(h.reinspeccion=4444 or h.reinspeccion=44441)';
                            } else {
                                $where = 'h.reinspeccion=8888';
                            }
                            if ($item->activo == 1) {

                                $query = $this->Mambientales->informe_cesar_motos($where, $item->idconf_maquina, $fechainicial, $fechafinal, $datoInforme, $motocarro);

                                $data1['motos'] = $this->getInformacionAtalaya($query, $item->idconf_maquina, $dowonload);
                                array_push($dagRta, $data1);
                            }

                            // $this->exporExcelCorantioquia($res);
                            // $filename = "Informe corantioquia Motos";
                            //$this->downloadInforemeCorantioquia($query);
                        }
                    } else {
                        if ($tipoinspeccion) {
                            if ($tipoinspeccion == 1) {
                                $where = '(h.reinspeccion=0 or h.reinspeccion=1)';
                            } elseif ($tipoinspeccion == 4444) {
                                $where = '(h.reinspeccion=4444 or h.reinspeccion=44441)';
                            } else {
                                $where = 'h.reinspeccion=8888';
                            }
                            if ($item->activo == 1) {
                                //consulta para motocarro

                                //$motocarro = 1;
                                // $query = $this->Mambientales->informe_cesar_motos($where, $item->idconf_maquina, $fechainicial, $fechafinal, $datoInforme, $motocarro);
                                // $data1['motos'] = $this->getInformacionAtalaya($query, $item->idconf_maquina, $dowonload);
                                // array_push($dagRta, $data1);

                                $query = $this->Mambientales->informe_cesar_gasolina($where, $item->idconf_maquina, $fechainicial, $fechafinal, $datoInforme, $motocarro);
                                $data2['livianos'] = $this->getInformacionAtalaya($query, $item->idconf_maquina, $dowonload);
                                array_push($dagRta, $data2);
                            }
                        }
                    }
                    break;
                case 'opacidad':
                    if ($tipoinspeccion) {
                        if ($tipoinspeccion == 1) {
                            $where = '(h.reinspeccion=0 or h.reinspeccion=1)';
                        } elseif ($tipoinspeccion == 4444) {
                            $where = '(h.reinspeccion=4444 or h.reinspeccion=44441)';
                        } else {
                            $where = 'h.reinspeccion=8888';
                        }
                        if ($item->activo == 1) {
                            $query = $this->Mambientales->informe_cesar_disel($where, $item->idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                            $data3['diesel'] = $this->getInformacionAtalaya($query, $item->idconf_maquina, $dowonload);
                            array_push($dagRta, $data3);
                        }
                    }

                    break;
                default:
                    break;
            }
        }
        $this->exporExcelCorpocesar($res, $dagRta);
        //    echo '<pre>';
        //    var_dump($dagRta);
        //    echo '</pre>';

    }

    // public function informeCorpocesar($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $tipoinforme, $serieanalizador, $datoInforme, $csvdowload)
    // {
    //     $dowonload = 1;
    //     switch ($prueba) {
    //         case 'analizador':
    //             if ($idconf_linea_inspeccion == 3 || $idconf_linea_inspeccion == 9 || $idconf_linea_inspeccion == 10) {
    //                 $query = $this->Mambientales->informe_cesar_motos($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
    //                 $this->getInformacionAtalaya($query, $idconf_maquina, $dowonload);
    //                 //$this->download_car_bogota($query, $filename, $idconf_maquina, $tipoinforme, $serieanalizador, $csvdowload);
    //             } else {
    //                 $query = $this->Mambientales->informe_cesar_gasolina($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
    //                 $this->getInformacionAtalaya($query, $idconf_maquina, $dowonload);
    //                 //$this->download_car_bogota($query, $filename, $idconf_maquina, $tipoinforme, $serieanalizador, $csvdowload);
    //             }
    //             break;
    //         case 'opacidad':
    //             $query = $this->Mambientales->informe_cesar_disel($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
    //             $filename = 'D';
    //             $this->getInformacionAtalaya($query, $idconf_maquina, $dowonload);
    //             //$this->download_car_bogota($query, $filename, $idconf_maquina, $tipoinforme, $serieanalizador, $csvdowload);
    //             break;
    //         default:
    //             break;
    //     }
    // }

    //    public function informecar($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $tipoinforme, $serieanalizador, $datoInforme, $csvdowload) {
    //        switch ($prueba) {
    //            case 'analizador':
    //                if ($idconf_linea_inspeccion == 3 || $idconf_linea_inspeccion == 9 || $idconf_linea_inspeccion == 10) {
    //                    $query = $this->Mambientales->informe_bogota_motos($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
    //                    $filename = 'M';
    //                    $this->download_car_bogota($query, $filename, $idconf_maquina, $tipoinforme, $serieanalizador, $csvdowload);
    //                } else {
    //                    $query = $this->Mambientales->informe_bogota_gasolina($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
    //                    $filename = 'G';
    //                    $this->download_car_bogota($query, $filename, $idconf_maquina, $tipoinforme, $serieanalizador, $csvdowload);
    //                }
    //                break;
    //            case 'opacidad':
    //                $query = $this->Mambientales->informe_bogota_disel($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
    //                $filename = 'D';
    //                $this->download_car_bogota($query, $filename, $idconf_maquina, $tipoinforme, $serieanalizador, $csvdowload);
    //                break;
    //            default:
    //                break;
    //        }
    //    }

    public function informeCortolima($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $tipoinforme, $datoInforme)
    {
        switch ($prueba) {
            case 'analizador':
                if ($idconf_linea_inspeccion == 3 || $idconf_linea_inspeccion == 9 || $idconf_linea_inspeccion == 10) {
                    $query = $this->Mambientales->informe_cortolima_motos($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    $filename = 'Informe Cortolima Motos';
                    $this->downloadinforme($query, $filename, $idconf_maquina);
                } else {
                    // var_dump($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    $query = $this->Mambientales->informe_cortolima_gasolina($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);

                    $filename = 'Informe Cortolima Gasolina';
                    $this->downloadinforme($query, $filename, $idconf_maquina);
                }
                break;
            case 'opacidad':
                $query = $this->Mambientales->informe_cortolima_disel($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                $filename = 'Informe Cortolima Diesel';
                $this->downloadinforme($query, $filename, $idconf_maquina);
                break;
            default:
                break;
        }
    }
    public function informeEpa($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion,  $datoInforme)
    {

        $dowonload = 0;
        $motocarro = 0;
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $rta = json_decode($json);

        $dagRta = [];

        foreach ($rta as $item) {

            switch ($item->prueba) {
                case 'analizador':

                    if ($item->idconf_linea_inspeccion == 3 || $item->idconf_linea_inspeccion == 9 || $item->idconf_linea_inspeccion == 10) {


                        if ($item->activo == 1) {
                            $motocarro = 0;
                            $query = $this->Mambientales->informe_epa_nuevo($item->idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                            $res = $this->getInformacionAtalaya($query, $item->idconf_maquina, $dowonload = 0);
                            // var_dump($res);
                            array_push($dagRta, $res);
                        }

                        // $this->exporExcelCorantioquia($res);
                        // $filename = "Informe corantioquia Motos";
                        //$this->downloadInforemeCorantioquia($query);

                    } else {

                        if ($item->activo == 1) {
                            //consulta para motocarro

                            $motocarro = 1;
                            $query = $this->Mambientales->informe_epa_nuevo($item->idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                            $res1 = $this->getInformacionAtalaya($query, $item->idconf_maquina, $dowonload = 0);

                            array_push($dagRta, $res1);
                            $query = $this->Mambientales->informe_epa_nuevo($item->idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                            $res2 = $this->getInformacionAtalaya($query, $item->idconf_maquina, $dowonload = 0);
                            // var_dump($res2);
                            array_push($dagRta, $res2);
                        }
                    }
                    break;
                case 'opacidad':

                    if ($item->activo == 1) {
                        $query = $this->Mambientales->informe_epa_nuevo($item->idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                        $res = $this->getInformacionAtalaya($query, $item->idconf_maquina, $dowonload = 0);
                        array_push($dagRta, $res);
                    }


                    break;
                default:
                    break;
            }
        }

        $filename = 'Informe Epa';
        $val = (array) $dagRta[0][1];
        $head = array_keys($val);
        $head = $this->formato_texto_762($head);
        $this->getCsvDownloadBoyaca($head, $filename, $dagRta);

        // echo '<pre>';
        // var_dump($dagRta);
        // echo '</pre>';
        //  $this->downloadinforme($dagRta, 'Informe epa', $idconf_maquina);
        // switch ($prueba) {
        //     case 'analizador':
        //         if ($idconf_linea_inspeccion == 3 || $idconf_linea_inspeccion == 9 || $idconf_linea_inspeccion == 10) {
        //             $query = $this->Mambientales->informe_epa_motos($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
        //             $filename = 'Informe Epa Motos';
        //             $this->getInformacionAtalaya($query, $idconf_maquina, 1);
        //             //$this->downloadinforme($query, $filename, $idconf_maquina);
        //         } else {
        //             $query = $this->Mambientales->informe_epa_gasolina($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
        //             //var_dump($query);
        //             $filename = 'Informe Epa Gasolina';
        //             $this->getInformacionAtalaya($query, $idconf_maquina, 1);
        //             // $this->downloadinforme($query, $filename, $idconf_maquina);
        //         }
        //         break;
        //     case 'opacidad':
        //         $query = $this->Mambientales->informe_epa_disel($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
        //         $filename = 'Informe Epa Diesel';
        //         $this->getInformacionAtalaya($query, $idconf_maquina, 1);
        //         // $this->downloadinforme($query, $filename, $idconf_maquina);
        //         break;
        //     default:
        //         break;
        // }
    }

    public function informecormacarena($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme)
    {
        switch ($prueba) {
            case 'analizador':
                if ($idconf_linea_inspeccion == 3 || $idconf_linea_inspeccion == 9 || $idconf_linea_inspeccion == 10) {
                    $query = $this->Mambientales->informe_cormacarena_motos($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    $filename = 'Informe Cormacarena Motos';
                    $this->downloadinforme($query, $filename, $idconf_maquina);
                } else {
                    $query = $this->Mambientales->informe_cormacarena_gasolina($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    $filename = 'Informe Cormacarena Gasolina';
                    $this->downloadinforme($query, $filename, $idconf_maquina);
                }
                break;
            case 'opacidad':
                $query = $this->Mambientales->informe_cormacarena_disel($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                $filename = 'Informe Cormacarena Diesel';
                $this->downloadinforme($query, $filename, $idconf_maquina);
                break;
            default:
                break;
        }
    }

    public function informecornare($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme)
    {
        $dowonload = 1;
        switch ($prueba) {
            case 'analizador':
                if ($idconf_linea_inspeccion == 3 || $idconf_linea_inspeccion == 9 || $idconf_linea_inspeccion == 10) {
                    $query = $this->Mambientales->informe_cornare_motos($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);

                    $filename = 'Informe Cornare Motos';
                    $this->getInformacionAtalaya($query, $idconf_maquina, $dowonload);
                    //                    $this->downloadinforme($query, $filename, $idconf_maquina);
                } else {
                    $query = $this->Mambientales->informe_cornare_gasolina($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    $filename = 'Informe Cornare Gasolina';
                    $this->getInformacionAtalaya($query, $idconf_maquina, $dowonload);
                    //                    $this->downloadinforme($query, $filename, $idconf_maquina);
                }
                break;
            case 'opacidad':
                $query = $this->Mambientales->informe_cornare_disel($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);

                $filename = 'Informe Cornare Diesel';
                $this->getInformacionAtalaya($query, $idconf_maquina, $dowonload);
                //                $this->densidadK($query, $filename);
                //$this->downloadinforme($query, $filename, $idconf_maquina);
                break;
            default:
                break;
        }
    }

    public function informecorpouraba($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme)
    {
        $dowonload = 1;
        switch ($prueba) {
            case 'analizador':
                if ($idconf_linea_inspeccion == 3 || $idconf_linea_inspeccion == 9 || $idconf_linea_inspeccion == 10) {
                    $query = $this->Mambientales->informe_corpouraba_motos($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    var_dump($query);
                    $filename = 'Informe Corpouraba Motos';
                    // $this->getInformacionAtalaya($query, $idconf_maquina, $dowonload);
                    //$this->downloadinforme($query, $filename, $idconf_maquina);
                } else {
                    $query = $this->Mambientales->informe_corpouraba_gasolina($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    $filename = 'Informe Corpouraba Gasolina';
                    var_dump($query);
                    // $this->getInformacionAtalaya($query, $idconf_maquina, $dowonload);
                    //$this->downloadinforme($query, $filename, $idconf_maquina);
                }
                break;
            case 'opacidad':
                $query = $this->Mambientales->informe_corpouraba_disel($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                $filename = 'Informe Corpouraba Diesel';
                $this->getInformacionAtalaya($query, $idconf_maquina, $dowonload);
                //$this->downloadinforme($query, $filename, $idconf_maquina);
                break;
            default:
                break;
        }
    }

    public function informesema($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme)
    {
        switch ($prueba) {
            case 'analizador':
                if ($idconf_linea_inspeccion == 3 || $idconf_linea_inspeccion == 9 || $idconf_linea_inspeccion == 10) {
                    $query = $this->Mambientales->informe_sema_motos($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    $filename = 'Informe Sema Motos';
                    $this->downloadinforme($query, $filename, $idconf_maquina);
                } else {
                    echo "<script>alert('Informe inactivo')</script>";
                    $this->index();
                    //                    $query = $this->Mambientales->informe_sema_gasolina($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    //                    $filename = 'Informe Sema Gasolina';
                    //                    $this->downloadinforme($query, $filename, $idconf_maquina);
                }
                break;
            case 'opacidad':
                echo "<script>alert('Informe inactivo')</script>";
                $this->index();
                //                $query = $this->Mambientales->informe_sema_disel($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                //                $filename = 'Informe Sema Diesel';
                //                $this->downloadinforme($query, $filename, $idconf_maquina);
                break;
            default:
                break;
        }
    }

    public function informeCorpocaldas($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme)
    {
        switch ($prueba) {
            case 'analizador':
                if ($idconf_linea_inspeccion == 3 || $idconf_linea_inspeccion == 9 || $idconf_linea_inspeccion == 10) {
                    $query = $this->Mambientales->informeCorpocaldas($idconf_maquina, $fechainicial, $fechafinal, $datoInforme, 3, 3);
                    $filename = ' Informe Corpocaldas Motos';
                    $this->informe762($query, $filename, $idconf_maquina);
                } else {
                    $query = $this->Mambientales->informeCorpocaldas($idconf_maquina, $fechainicial, $fechafinal, $datoInforme, 1, 3);
                    $filename = ' Informe Corpocaldas Gasolina';
                    $this->informe762($query, $filename, $idconf_maquina);
                }
                break;
            case 'opacidad':
                $query = $this->Mambientales->informeCorpocaldas($idconf_maquina, $fechainicial, $fechafinal, $datoInforme, 2, 2);
                $filename = ' Informe Corpocaldas Diesel';
                $this->informe762($query, $filename, $idconf_maquina);
                break;
            default:
                echo 'ninguno';
                break;
        }
    }

    public function informe_dagma()
    {
        //        $encrptopenssl = New Opensslencryptdecrypt();
        //        $json = $encrptopenssl->decrypt(file_get_contents('system/oficina.json', true), true);
        $date = date("Y-m-d-H-i-s");
        $nombre = 'Informe Dagma';
        $tipoinforme = $this->input->post('tipoinforme');
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        //        $json = file_get_contents('system/lineas.json', true);
        $rta = json_decode($json);
        $check = $this->input->post('check-cvc');
        if ($check == 1) {
            $dagRta = [];
            $fechainicial = $this->input->post('fechainicial');
            $fechafinal = $this->input->post('fechafinal');
            $idconf_maquina = $this->input->post('idconf_maquina');
            $query = $this->Mambientales->informe_dagma_cvc($idconf_maquina, $fechainicial, $fechafinal);
            $filename = 'Informe Dagma Cvc';
            $this->informe762($query, $filename, $idconf_maquina);
        } else {
            $dagRta = [];
            foreach ($rta as $item) {
                if (($item->prueba == 'analizador' || $item->prueba == 'opacidad') && $item->activo == 1) {
                    $fechainicial = $this->input->post('fechainicial');
                    $fechafinal = $this->input->post('fechafinal');
                    $idconf_maquina = $item->idconf_maquina;
                    $query = $this->Mambientales->informe_dagma($idconf_maquina, $fechainicial, $fechafinal);
                    $delimiter = ";";
                    $newline = "\r\n";
                    $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
                    array_push($dagRta, $data);
                }
            }
            //            $encabezado = $consulta = <<<EOF
            //;FORMATO PARA LA ENTREGA DE INFORMACIÒN DE LOS CENTROS DE DIAGNOSTICO AUTOMOTOR;;;;;;;;;;;;;;;;;;;;;;;;
            //CDA;REGISTRO;FECHA;No CERTIFICADO;TIPO VEHICULO;TIPO SERVICIO VEHICULO;PLACA;MODELO;KILOMETRAJE;TIPO DE COMBUSTIBLE;APLICA SOLO PARA  VEHICULOS A GASOLINA;;;;;;;;APLICA SOLO PARA VEHICULOS A DIESEL ;;RESULTADO PRUEBA;RUIDO;;;;
            //;;;;;;;;;;Prueba Estatica (Ralentí);;;;Prueba Dinamica (Crucero);;;;;;;;;;;
            //;;;;;;;;;;CO(%);CO2(%);O2(%);HC(ppm);CO(%);CO2(%);O2(%);HC(ppm);NORMA (%);RESULTADO(%) OPACIDAD;;;;;;
            //EOF;
            $rta = '';
            $result = utf8_decode($this->formato_texto(implode($rta, $dagRta)));
            //            $result = $encabezado . $result;
            $filename = 'Informe Dagma';
            //            $reporte = fopen('C:/Informes_Ambientales/' . $filename . ' ' . $date . '.csv', 'w+b');
            //            fwrite($reporte, $result);
            //            fclose($reporte);
            //            $reporte = fopen('C:/Informes_Ambientales/' . $filename . ' ' . $date . '.txt', 'w+b');
            //            fwrite($reporte, $result);
            //            fclose($reporte);
            $nombrecsv = $filename . '.csv';
            $nombretxt = $filename . '.txt';
            $data = array(
                $nombrecsv => $result,
                $nombretxt => $result
            );
            $report = $this->zip->add_data($data);
            $this->zip->download($filename . ' ' . $date . ' ' . '.zip');
            force_download($nombre, $result);
        }
    }

    public function informes()
    {
        date_default_timezone_set('America/bogota');
        $date = date("Y-m-d-H-i-s");
        $encrptopenssl = new Opensslencryptdecrypt();
        $this->setConf();
        $datoInforme = $this->tipo_informe_fugas_cal_lin;
        if ($datoInforme == "NA") {
            $datoInforme = $this->input->post('informeNewAnt');
        } else {
            $datoInforme = $this->tipo_informe_fugas_cal_lin;
        }
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true), true);
        $rta = json_decode($json);
        $tipoinforme = $this->input->post('tipoinforme');
        switch ($tipoinforme) {
            // case 'Epa':
            //     $rtarest = [];
            //     foreach ($rta as $item) {
            //         if (($item->prueba == 'analizador' || $item->prueba == 'opacidad') && $item->activo == 1) {
            //             $fechainicial = $this->input->post('fechainicial');
            //             $fechafinal = $this->input->post('fechafinal');
            //             $idconf_maquina = $item->idconf_maquina;
            //             $query = $this->Mambientales->informe_epa($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
            //             $filename = 'Informe Epa';
            //             $delimiter = ";";
            //             $newline = "\r\n";
            //             $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
            //             array_push($rtarest, $data);
            //         }
            //     }
            //     $rta = '';
            //     $result = implode($rta, $rtarest);
            //     //                $reporte = fopen('C:/Informes_Ambientales/' . $filename . ' ' . $date . '.csv', 'w+b');
            //     //                fwrite($reporte, $result);
            //     //                fclose($reporte);
            //     //                $reporte = fopen('C:/Informes_Ambientales/' . $filename . ' ' . $date . '.txt', 'w+b');
            //     //                fwrite($reporte, $result);
            //     //                fclose($reporte);
            //     $nombrecsv = $filename . ' ' . $date . '.csv';
            //     $nombretxt = $filename . ' ' . $date . '.txt';
            //     $data = array(
            //         $nombrecsv => $result,
            //         $nombretxt => $result
            //     );
            //     $report = $this->zip->add_data($data);
            //     $this->zip->download('Informe Ambiental ' . $tipoinforme . ' ' . $date . '.zip');
            //     //                force_download($nombre, $result);
            //     break;
            case 'Superintendencia':
                $rtarest = [];
                foreach ($rta as $item) {
                    if (($item->prueba == 'analizador' || $item->prueba == 'opacidad') && $item->activo == 1) {
                        $fechainicial = $this->input->post('fechainicial');
                        $fechafinal = $this->input->post('fechafinal');
                        $idconf_maquina = $item->idconf_maquina;
                        $query = $this->Mambientales->informe_superintendencia($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                        $filename = 'Informe Superintendencia';
                        $delimiter = ";";
                        $newline = "\r\n";
                        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
                        array_push($rtarest, $data);
                    }
                }
                $rta = '';
                $result = implode($rta, $rtarest);
                //                $reporte = fopen('C:/Informes_Ambientales/' . $filename . ' ' . $date . '.csv', 'w+b');
                //                fwrite($reporte, $result);
                //                fclose($reporte);
                //                $reporte = fopen('C:/Informes_Ambientales/' . $filename . ' ' . $date . '.txt', 'w+b');
                //                fwrite($reporte, $result);
                //                fclose($reporte);
                $nombrecsv = $filename . ' ' . $date . '.csv';
                $nombretxt = $filename . ' ' . $date . '.txt';
                $data = array(
                    $nombrecsv => $result,
                    $nombretxt => $result
                );
                $report = $this->zip->add_data($data);
                $this->zip->download('Informe Ambiental ' . $tipoinforme . ' ' . $date . '.zip');
                //                force_download($nombre, $result);
                break;
            case 'Corpoboyaca':

                $rtarest = [];
                foreach ($rta as $item) {
                    if (($item->prueba == 'analizador' || $item->prueba == 'opacidad') && $item->activo == 1) {
                        $fechainicial = $this->input->post('fechainicial');
                        $fechafinal = $this->input->post('fechafinal');
                        $idconf_maquina = $item->idconf_maquina;
                        $query = $this->Mambientales->informe_Copoboyaca($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                        $filename = 'Informe Corpoboyaca';
                        $delimiter = ";";
                        $newline = "\r\n";
                        array_push($rtarest, $query);
                    }
                }
                $encrptopenssl = new Opensslencryptdecrypt();
                $j = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
                $json = json_decode(utf8_decode($j), true);
                $head = [];
                foreach ($rtarest as $val) {
                    foreach ($val as $value) {
                        foreach ($json as $v) {
                            if ($v['idconf_maquina'] == $value->SerialSonometro) {
                                $value->SerialSonometro = strtoupper($v['serie_maquina']);
                                $value->MarcaSonometro = strtoupper($v['marca']);
                                $value->ModeloSonometro = strtoupper($v['serie_banco']);
                            }
                            if ($v['idconf_maquina'] == $value->SerieAnalizador) {
                                $value->SerieAnalizador = strtoupper($v['serie_maquina']);
                                $value->MarcaAnalizador = strtoupper($v['marca']);
                                $value->ModeloAnalizador = strtoupper($v['serie_banco']);
                            }
                            if ($v['idconf_maquina'] == $value->SerieOpacimetro) {
                                $value->SerieOpacimetro = strtoupper($v['serie_maquina']);
                                $value->MarcaOpacimetro = strtoupper($v['marca']);
                                $value->ModeloOpacimetro = strtoupper($v['serie_banco']);
                            }
                        }
                    }
                }
                if (count($rtarest) > 1) {
                    $val = (array) $rtarest[0][0];
                } else {
                    $val = (array) $rtarest[0];
                }
                $head = array_keys($val);
                $name = "Informe Corpoboyaca";
                $this->getCsvDownloadBoyaca($head, $name, $rtarest);
                break;
            default:
                break;
        }
    }

    public function downloadInforemeCorantioquia($query)
    {
        date_default_timezone_set('America/bogota');
        $rta['cda'] = $this->infocda();
        $nombreCda = $rta['cda']->nombre_cda;
        $date = date("MY");
        $delimiter = ";";
        $newline = "\r\n";
        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        $nombrecsv = 'Reporte Informacion_' . $nombreCda . '_' . $date . '.csv';
        $nombretxt = 'Reporte Informacion_' . $nombreCda . '_' . $date . '.txt';
        $data = array(
            $nombrecsv => $data,
            $nombretxt => $data
        );
        $report = $this->zip->add_data($data);
        $this->zip->download('Reporte Informacion_' . $nombreCda . '_' . $date . '.zip');
    }

    public function downloadinforme($query, $filename, $idconf_maquina)
    {
        date_default_timezone_set('America/bogota');
        $date = date("Y-m-d-H-i-s");
        $delimiter = ";";
        $newline = "\r\n";
        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        $nombrecsv = 'Maquina ' . $idconf_maquina . ' ' . $filename . ' ' . $date . '.csv';
        $nombretxt = 'Maquina ' . $idconf_maquina . ' ' . $filename . ' ' . $date . '.txt';
        $data = array(
            $nombrecsv => $data,
            $nombretxt => $data
        );
        $report = $this->zip->add_data($data);
        $this->zip->download('Maquina ' . $idconf_maquina . ' ' . $filename . ' ' . $date . '.zip');
        //        force_download($nombre, $data);
    }

    public function download_car_bogota($query, $filename, $idconf_maquina, $tipoinforme, $serieanalizador, $csvdowload)
    {
        date_default_timezone_set('America/bogota');
        $date = date("d-m-Y");
        $rta['cda'] = $this->infocda();
        $numero_resolucion = $rta['cda']->numero_resolucion;

        $data2 = $this->newInformeBogota($query, $filename, $idconf_maquina);

        if (strlen($numero_resolucion) < 5) {
            $resolucion = str_pad($numero_resolucion, 5, "0", STR_PAD_LEFT);
            $serie = substr($serieanalizador, -4);
            //            $delimiter = ";";
            //            $newline = "\r\n";
            //            $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
            //            $nombrecsv = $numero_resolucion . ' ' . $date . ' ' . $serie . ' ' . $filename . '.csv';
            //            $nombretxt = $numero_resolucion . ' ' . $date . ' ' . $serie . ' ' . $filename . '.txt';
            //            $nombrepag = $numero_resolucion . ' ' . $date . ' ' . $serie . ' ' . $filename . '.pag';
            //            $data = array(
            //                $nombrecsv => $data,
            //                $nombretxt => $data,
            //                $nombrepag => $data
            //            );
            //            $report = $this->zip->add_data($data);
            //            $this->zip->download('Informe Ambiental ' . $tipoinforme . ' ' . $date . ' ' . $filename . '.zip');
        }
        $serie = substr($serieanalizador, -4);
        $numero_resolucion;
        if ($csvdowload == 1) {
            $nombrecsv = $numero_resolucion . ' ' . $date . ' ' . $serie . ' ' . $filename;
            $val = (array) $data2[0];
            $head = array_keys($val);
            // $head = $this->formato_texto_762($head);
            header('Content-type: application/csv');
            header('Content-Transfer-Encoding: binary; charset=utf-8');
            header('Content-Disposition: attachment; filename=' . $nombrecsv . '.csv');
            $fp = fopen("php://output", 'w');
            fputcsv($fp, (array) $head, ";");
            foreach ($query as $d) {
                fputcsv($fp, (array) $d, ";");
            }
        } else {



            //     Se pasa de objeto a array para poder pasarlo a un string       
            $data2 = json_decode(json_encode($data2), true);
            $res2 = "";
            for ($index = 0; $index < count($data2); $index++) {
                $res2 .= implode(";", (array) $data2[$index]);
            }
            $datosencriptados = $this->haciendo_sarta(utf8_decode($this->formato_texto($res2)));
            $nombretxt = $numero_resolucion . ' ' . $date . ' ' . $serie . ' ' . $filename . '.txt';
            $nombrepag = $numero_resolucion . ' ' . $date . ' ' . $serie . ' ' . $filename . '.pag';
            $data = array(
                $nombretxt => $res2,
                $nombrepag => $datosencriptados
            );
            $report = $this->zip->add_data($data);
            $this->zip->download('Informe Ambiental ' . $tipoinforme . ' ' . $date . ' ' . $filename . '.zip');
        }
    }

    function newInformeBogota($query, $name, $idconf_maquina)
    {
        $this->setConf();
        $encrptopenssl = new Opensslencryptdecrypt();
        $j = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $json = json_decode(utf8_decode($j), true);
        $ma = $encrptopenssl->decrypt(file_get_contents('system/' . $idconf_maquina . '.json', true));
        $maquinaData = json_decode(utf8_decode($ma), true);
        $head = [];
        $numeroAnalizador4t = 0;
        $numeroAnalizador2t = 0;
        $numeroAnalizadorotto = 0;
        $numeroOpa = 0;
        if (empty($query)) {
            $this->session->set_userdata('mesajeError', 'No se econtraron registros, por favor verifique el rango de fechas o comuniquese con el area de soporte.');
            redirect('oficina/reportes/Cambientales');
        }
        foreach ($json as $mas) {
            if ($mas['prueba'] == 'opacidad' && $mas['activo'] == 1)
                $numeroOpa++;
            if ($mas['prueba'] == 'analizador' && $mas['activo'] == 1) {
                $ma = $encrptopenssl->decrypt(file_get_contents('system/' . $mas['idconf_maquina'] . '.json', true));
                $maquina = json_decode(utf8_decode($ma), true);
                foreach ($maquina as $as) {
                    if ($as['nombre'] == 'cicloAnalizador') {
                        if (strtoupper($as['valor']) == 'OTTO')
                            $numeroAnalizadorotto++;
                        if (strtoupper($as['valor']) == '4T')
                            $numeroAnalizador4t++;
                        if (strtoupper($as['valor']) == '2T')
                            $numeroAnalizador2t++;
                    }
                }
            }
        }


        foreach ($query as $val) {
            foreach ($json as $v) {
                if ($v['idconf_maquina'] == $idconf_maquina) {
                    if (isset($val->Serie_Analizador))
                        $val->Serie_Analizador = strtoupper($v['serie_maquina']);
                    if (isset($val->Marca_Analizador))
                        $val->Marca_Analizador = strtoupper($v['marca']);
                    if (isset($val->SerieBanco))
                        $val->SerieBanco = strtoupper($v['serie_banco']);
                    if (isset($val->Serie_Banco))
                        $val->Serie_Banco = strtoupper($v['serie_banco']);
                    if (isset($val->Marca_del_medidor))
                        $val->Marca_del_medidor = strtoupper($v['marca']);
                    if (isset($val->Serie_del_medidor))
                        $val->Serie_del_medidor = strtoupper($v['serie_maquina']);
                }
            }
            foreach ($maquinaData as $m) {
                if ($m['idconf_maquina'] == $idconf_maquina) {
                    if ($m['nombre'] == "pef")
                        if (isset($val->Vr_PEF))
                            $val->Vr_PEF = $m['valor'];
                    if ($m['nombre'] == "ltoe")
                        if (isset($val->Ltoe))
                            $val->Ltoe = $m['valor'];
                    if ($m['nombre'] == "marcasoft")
                        if (isset($val->Marca_software_operacion))
                            $val->Marca_software_operacion = $m['valor'];
                    if ($m['nombre'] == "versionsoft")
                        if (isset($val->Version_software_operacion))
                            $val->Version_software_operacion = $m['valor'];
                    if (isset($val->Serial_banco))
                        if ($m['nombre'] == "noSerieBench")
                            $val->Serial_banco = $m['valor'];
                    if ($m['nombre'] == "noSerieBench")
                        if (isset($val->No_serie_electronico_del_analizador))
                            $val->No_serie_electronico_del_analizador = $m['valor'];
                    if ($m['nombre'] == "noSerieOpacimetro")
                        if (isset($val->Serie_electronico_medidor))
                            $val->Serie_electronico_medidor = $m['valor'];
                    //                    if ($m['nombre'] == 'cicloAnalizador') {
                    //                        if (strtoupper($as['valor']) == 'OTTO')
                    //                            if(isset ($val->))
                    //                    }
                    //exit;
                }
            }
            if (isset($val->No_total_equipos_opacimetros))
                $val->No_total_equipos_opacimetros = $numeroOpa;
            if (isset($val->Numero_total_de_analizadores_Otto))
                $val->Numero_total_de_analizadores_Otto = $numeroAnalizadorotto;
            if (isset($val->Numero_total_de_analizadores_mots_4T))
                $val->Numero_total_de_analizadores_mots_4T = $numeroAnalizador4t;
            if (isset($val->Numero_total_de_analizadores_mots_2T))
                $val->Numero_total_de_analizadores_mots_2T = $numeroAnalizador2t;
            if (isset($val->No_total_equipos_analizadores_motos_4T_2T))
                $val->No_total_equipos_analizadores_motos_4T_2T = ($numeroAnalizador4t + $numeroAnalizador2t);
            $opatotal = 0;
            if (isset($val->Numero_expe))
                $val->Numero_expe = $this->numeroExpediente;
            if (isset($val->expedienteCornare))
                $val->expedienteCornare = $this->numeroExpediente;
            if (isset($val->Razon_social))
                $val->Razon_social = $this->razonSocialCda;
            if (isset($val->Ciclo_preliminar_))
                $val->Ciclo_preliminar_m1 = $this->rdnr(abs(- (1 / 0.43) * log(1 - ((floatval($val->Ciclo_preliminar_)) / 100))));
            if (isset($val->Ciclo_1)) {
                $val->_1_m1 = $this->rdnr(abs(- (1 / 0.43) * log(1 - ((floatval($val->Ciclo_1)) / 100))));
                $opatotal = $opatotal + $val->_1_m1;
            }
            if (isset($val->Ciclo_2)) {
                $val->_2_m1 = $this->rdnr(abs(- (1 / 0.43) * log(1 - ((floatval($val->Ciclo_2)) / 100))));
                $opatotal = $opatotal + $val->_2_m1;
            }
            if (isset($val->Ciclo_3)) {
                $val->_3_m1 = $this->rdnr(abs(- (1 / 0.43) * log(1 - ((floatval($val->Ciclo_3)) / 100))));
                $opatotal = $opatotal + $val->_3_m1;
            }
            if (isset($val->_final_m1)) {
                $val->_final_m1 = $this->rdnr(abs(- (1 / 0.43) * log(1 - ((floatval($opatotal / 3)) / 100))));
            }
        }
        return $query;
    }

    function infocda()
    {
        $data = $this->Minformes->infocda();
        $rta = $data->result();
        return $rta[0];
    }

    public function haciendo_sarta($data)
    {
        $this->setConf();
        $clave_publica = $this->clavePublica;
        $clave_privada = $this->clavePrivada;
        $data1 = '';
        $cont = 0;
        for ($i = 0; $i < 128; $i++) {
            if ($cont < strlen($clave_publica)) {
                $data1 = $data1 . '' . substr($clave_publica, $cont, 1);
                $cont++;
            } else {
                $cont = 0;
                $data1 = $data1 . '' . substr($clave_publica, $cont, 1);
            }
        }
        $data2 = '';
        $cont1 = 0;
        for ($i = 0; $i < 128; $i++) {
            if ($cont1 < strlen($clave_privada)) {
                $data2 = $data2 . '' . substr($clave_privada, $cont1, 1);
                $cont1++;
            } else {
                $cont1 = 0;
                $data2 = $data2 . '' . substr($clave_privada, $cont1, 1);
            }
        }
        //        $pru = "";
        $sarta = "";
        for ($i = 0; $i < 128; $i++) {
            $uno = ord(substr($data1, $i, 1));
            $dos = ord(substr($data2, $i, 1));
            $res = $uno ^ $dos;
            //            $pru = $pru.chr($res);
            $sarta = $sarta . chr($res);
        }
        //        echo $sarta;
        $datosencriptados = substr($sarta, 1, 64);
        $i = 0;
        $j = 0;
        $longitud = strlen($data);
        for ($i = 1; $i < $longitud + 1; $i++) {
            if ($j > 128) {
                $j = 0;
            }
            $datosencriptados = $datosencriptados . chr(ord(substr($data, $i, 1)) ^ ord(substr($sarta, $j, 1)));
            $j = $j + 1;
        }
        $datosencriptados = $datosencriptados . substr($sarta, 65, 64);
        return $datosencriptados;
    }

    private function formato_texto($cadena)
    {
        $no_permitidas = array("Ñ", "ñ", "á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹", "'", "");
        $permitidas = array("N", "n", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E", "", "");
        $texto = str_replace($no_permitidas, $permitidas, $cadena);
        return $texto;
    }

    function informe762($query, $filename, $idconf_maquina)
    {
        $encrptopenssl = new Opensslencryptdecrypt();
        $j = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $json = json_decode(utf8_decode($j), true);
        $ma = $encrptopenssl->decrypt(file_get_contents('system/' . $idconf_maquina . '.json', true));
        $maquinaData = json_decode(utf8_decode($ma), true);
        $head = [];
        $numeroAnalizador4t = 0;
        $numeroAnalizador2t = 0;
        $numeroAnalizadorotto = 0;
        $numeroOpa = 0;

        if (empty($query)) {
            $this->session->set_userdata('mesajeError', 'No se econtraron registros, por favor verifique el rango de fechas o comuniquese con el area de soporte.');
            redirect('oficina/reportes/Cambientales');
        }
        foreach ($json as $mas) {
            if ($mas['prueba'] == 'opacidad' && $mas['activo'] == 1)
                $numeroOpa++;
            if ($mas['prueba'] == 'analizador' && $mas['activo'] == 1) {
                $ma = $encrptopenssl->decrypt(file_get_contents('system/' . $mas['idconf_maquina'] . '.json', true));
                $maquina = json_decode(utf8_decode($ma), true);
                foreach ($maquina as $as) {
                    if ($as['nombre'] == 'cicloAnalizador') {
                        if (strtoupper($as['valor']) == 'OTTO')
                            $numeroAnalizadorotto++;
                        if (strtoupper($as['valor']) == '4T')
                            $numeroAnalizador4t++;
                        if (strtoupper($as['valor']) == '2T')
                            $numeroAnalizador2t++;
                    }
                }
            }
        }


        foreach ($query as $val) {
            foreach ($json as $v) {
                if (isset($val->idsonometro)) {
                    if ($v['idconf_maquina'] == $val->idsonometro) {
                        $val->Marca_sonometro = strtoupper($v['marca']);
                        $val->Serie_sonometro = strtoupper($v['serie_maquina']);
                    }
                }

                if ($v['idconf_maquina'] == $idconf_maquina) {
                    if (isset($val->Serial_equipo_utilizado)) {
                        $val->Serial_equipo_utilizado = strtoupper($v['serie_maquina']);
                    }
                    if (isset($val->Serie_Analizador)) {
                        $val->Serie_Analizador = strtoupper($v['serie_maquina']);
                    }
                    if (isset($val->Marca_del_medidor)) {
                        $val->Marca_del_medidor = strtoupper($v['marca']);
                    }
                    if (isset($val->Marca_analizador)) {
                        $val->Marca_analizador = strtoupper($v['marca']);
                    }
                }
            }
            foreach ($maquinaData as $m) {
                if ($m['idconf_maquina'] == $idconf_maquina) {
                    if ($m['nombre'] == "pef") {
                        if (isset($val->Pef)) {
                            $val->Pef = $m['valor'];
                        }
                    }
                    if ($m['nombre'] == "ltoe") {
                        if (isset($val->Ltoe)) {
                            $val->Ltoe = $m['valor'];
                        }
                    }
                    if (isset($val->Razon_social))
                        $val->Razon_social = $this->razonSocialCda;

                    if ($m['nombre'] == "marcasoft") {
                        if (isset($val->Marca_software_operacion)) {
                            $val->Marca_software_operacion = $m['valor'];
                        }
                    }
                    if ($m['nombre'] == "nombreMarca") {
                        if (isset($val->Marca_analizador)) {
                            $val->Marca_analizador = $m['valor'];
                        }
                    }

                    if ($m['nombre'] == "versionsoft") {
                        if (isset($val->Version_software_operacion)) {
                            $val->Version_software_operacion = $m['valor'];
                        }
                    }



                    if (isset($val->Serial_banco))
                        if ($m['nombre'] == "noSerieBench")
                            $val->Serial_banco = $m['valor'];
                    if (isset($val->Serie_Banco))
                        if ($m['nombre'] == "noSerieBench")
                            $val->Serie_Banco = $m['valor'];
                    if ($m['nombre'] == "noSerieBench")
                        if (isset($val->No_serie_electronico_del_analizador))
                            $val->No_serie_electronico_del_analizador = $m['valor'];
                    if ($m['nombre'] == "noSerieOpacimetro")
                        if (isset($val->Serie_electronico_medidor))
                            $val->Serie_electronico_medidor = $m['valor'];

                    //exit;
                }
            }
            if (isset($val->Numero_total_de_equipos_opacimetros)) {
                $val->Numero_total_de_equipos_opacimetros = $numeroOpa;
            }
            if (isset($val->Numero_total_de_analizadores_Otto)) {
                $val->Numero_total_de_analizadores_Otto = $numeroAnalizadorotto;
            }
            if (isset($val->Numero_total_de_analizadores_mots_4T)) {
                $val->Numero_total_de_analizadores_mots_4T = $numeroAnalizador4t;
            }
            if (isset($val->Numero_total_de_analizadores_mots_2T)) {
                $val->Numero_total_de_analizadores_mots_2T = $numeroAnalizador2t;
            }
            $opatotal = 0;
            $val->Numero_expe = $this->numeroExpediente;
            // if ($val->Ciclo_preliminar_)
            //     $val->Ciclo_preliminar_m1 = $this->rdnr(abs(- (1 / 0.43) * log(1 - ((floatval($val->Ciclo_preliminar_)) / 100))));
            // if ($val->Ciclo_1) {
            //     $val->_1_m1 = $this->rdnr(abs(- (1 / 0.43) * log(1 - ((floatval($val->Ciclo_1)) / 100))));
            //     $opatotal = $opatotal + $val->_1_m1;
            // }
            // if ($val->Ciclo_2) {
            //     $val->_2_m1 = $this->rdnr(abs(- (1 / 0.43) * log(1 - ((floatval($val->Ciclo_2)) / 100))));
            //     $opatotal = $opatotal + $val->_2_m1;
            // }
            // if ($val->Ciclo_3) {
            //     $val->_3_m1 = $this->rdnr(abs(- (1 / 0.43) * log(1 - ((floatval($val->Ciclo_3)) / 100))));
            //     $opatotal = $opatotal + $val->_3_m1;
            // }
            // $val->_final_m1 = $this->rdnr(abs(- (1 / 0.43) * log(1 - ((floatval($opatotal / 3)) / 100))));
        }
        $val = (array) $query[0];
        $head = array_keys($val);
        $head = $this->formato_texto_762($head);
        $this->getCsvDownload($head, $filename, $query);
    }

    function densidadK($query, $filename)
    {
        $opatotal = 0;
        foreach ($query as $val) {
            if ($val->Resultado_inicial_opacidad_ciclo_preliminiar)
                $val->Ciclo_preliminar_m1 = $this->rdnr(abs(- (1 / 0.43) * log(1 - ((floatval($val->Resultado_inicial_opacidad_ciclo_preliminiar)) / 100))));
            if ($val->Resultado_opacidad_1er_ciclo) {
                $val->_1_m1 = $this->rdnr(abs(- (1 / 0.43) * log(1 - ((floatval($val->Resultado_opacidad_1er_ciclo)) / 100))));
                $opatotal = $opatotal + $val->_1_m1;
            }
            if ($val->Opa_opacidad_2do_ciclo) {
                $val->_2_m1 = $this->rdnr(abs(- (1 / 0.43) * log(1 - ((floatval($val->Opa_opacidad_2do_ciclo)) / 100))));
                $opatotal = $opatotal + $val->_2_m1;
            }
            if ($val->Opa_opacidad_3er_ciclo) {
                $val->_3_m1 = $this->rdnr(abs(- (1 / 0.43) * log(1 - ((floatval($val->Opa_opacidad_3er_ciclo)) / 100))));
                $opatotal = $opatotal + $val->_3_m1;
            }
            $val->Densidad_Humo_K = $this->rdnr(abs(- (1 / 0.43) * log(1 - ((floatval($opatotal / 3)) / 100))));
        }
        //        var_dump($query);
        $val = (array) $query[0];
        $head = array_keys($val);
        $head = $this->formato_texto_762($head);

        $this->getCsvDownload($head, $filename, $query);
    }

    function getCsvDownloadBoyaca($head, $name, $rta)
    {
        if (empty($fileName)) {
            $fileName = $name . date('Y-m-d H:i:s');
        }
        header('Content-type: application/csv');
        header('Content-Transfer-Encoding: binary; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $fileName . '.csv');

        $fp = fopen("php://output", 'w');
        fputcsv($fp, (array) $head, ";");
        $c = 0;
        foreach ($rta as $d) {
            foreach ($d as $val) {
                fputcsv($fp, (array) $val, ";");
            }
        }
        exit();
    }

    function getCsvDownload($head, $name, $rta)

    {
        $res = $rta;
        if ($this->informeWebCornare == 1) {
            $rta = str_replace(".", ",", json_encode($rta));
            $rta = json_decode($rta);
        }

        if (empty($fileName)) {
            $fileName = $name . date('Y-m-d H:i:s');
        }
        header('Content-type: application/csv');
        header('Content-Transfer-Encoding: binary; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $fileName . '.csv');

        $fp = fopen("php://output", 'w');
        fputcsv($fp, (array) $head, ";");
        // var_dump($rta);
        foreach ($res as $d) {

            //            foreach ($d as $val) {
            fputcsv($fp, (array) $d, ";");
            //            }
        }

        exit();
    }

    private function formato_texto_762($cadena)
    {
        $no_permitidas = array("Ciclo_1", "Ciclo_2", "Ciclo_3", "Promedio_final", "Ciclo_preliminar_m1", "_1_m1", "_2_m1", "_3_m1", "_final_m1", "Numero_expe", "_");
        $permitidas = array("Ciclo 1(%)", "Ciclo 2(%)", "Ciclo 3(%)", "Promedio final (%)", "Ciclo preliminar (m-1)", "Ciclo 1 (m-1)", "Ciclo 2 (m-1)", "Ciclo 3 (m-1)", "Promedio final 1 (m-1)", "Numero expediente autoridad ambiental", " ");
        $texto = str_replace($no_permitidas, $permitidas, $cadena);
        return $texto;
    }

    private function rdnr($valor)
    {
        $dato = '';
        if ($valor !== '') {
            if (floatval($valor) === 0.00 || floatval($valor) === 0.0 || floatval($valor) === 0) {
                $dato = "0.00";
            } else {
                if (intval($valor) < 10) {
                    $valorNegativo = false;
                    $dato = abs(round($valor, 2));
                    if ($valor < 0) {
                        $valorNegativo = true;
                        if (intval($valor) > -10) {
                            if (substr($dato, 2) == "") {
                                $dato = $dato . ".00";
                            } elseif (substr($dato, 3) == "" || substr($dato, 3) == '0') {
                                $dato = $dato . "0";
                            }
                        } elseif (intval($valor) <= -10 && intval($valor) > -100) {
                            $dato = abs(round($valor, 1));
                            if (substr($dato, 2) == "") {
                                $dato = $dato . ".0";
                            }
                        } else {
                            $dato = abs(round($valor));
                        }
                    } else {
                        if (substr($dato, 1) == "") {
                            $dato = $dato . ".00";
                        } elseif (substr($dato, 3) == "" || substr($dato, 3) == '0') {
                            $dato = $dato . "0";
                        }
                    }
                    if ($valorNegativo) {
                        $dato = "-" . $dato;
                    }
                } elseif (intval($valor) >= 10 && intval($valor) < 100) {
                    $dato = round($valor, 1);
                    if (substr($dato, 2) == "") {
                        $dato = $dato . ".0";
                    }
                } else {
                    $dato = round($valor);
                }
            }
        }
        return $dato;
    }

    function getInformacionAtalaya($query, $idconf_maquina, $download)
    {



        $this->setConf();
        date_default_timezone_set('America/bogota');
        $date = date("Y-m-d");
        $encrptopenssl = new Opensslencryptdecrypt();
        $j = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $json = json_decode(utf8_decode($j), true);
        $ma = $encrptopenssl->decrypt(file_get_contents('system/' . $idconf_maquina . '.json', true));
        $maquinaData = json_decode(utf8_decode($ma), true);
        //  var_dump($maquinaData);
        $numeroAnalizador4t = 0;
        $numeroAnalizador2t = 0;
        $numeroAnalizadorotto = 0;
        $numeroOpa = 0;
        $informeConcaptadorThTemp = 0;



        // if (empty($query)) {
        //     $this->session->set_userdata('mesajeError', 'No se econtraron registros, por favor verifique el rango de fechas o comuniquese con el area de soporte.');
        //     redirect('oficina/reportes/Cambientales');
        // }
        // var_dump($json);
        foreach ($json as $mas) {
            if ($mas['prueba'] == 'opacidad' && $mas['activo'] == 1)
                $numeroOpa++;
            if ($mas['prueba'] == 'analizador' && $mas['activo'] == 1) {
                $ma = $encrptopenssl->decrypt(file_get_contents('system/' . $mas['idconf_maquina'] . '.json', true));
                $maquina = json_decode(utf8_decode($ma), true);
                foreach ($maquina as $as) {
                    if ($as['nombre'] == 'cicloAnalizador') {
                        if (strtoupper($as['valor']) == 'OTTO')
                            $numeroAnalizadorotto++;
                        if (strtoupper($as['valor']) == '4T')
                            $numeroAnalizador4t++;
                        if (strtoupper($as['valor']) == '2T')
                            $numeroAnalizador2t++;
                    }
                }
            }
        }


        foreach ($query as $val) {

            if (isset($val->id_sede)) {
                //$this->setConf();
                $val->id_sede = $this->idsedeWebBogota;
                // $val->id_sede = "360";
            }


            //$val =  str_replace(".", ",", $val);

            if (isset($val->Diferencia_aritmetica)) {
                $datos = explode(",", $val->Diferencia_aritmetica);
                $min = min($datos);
                $max = max($datos);
                $val->Diferencia_aritmetica = (floatval($max) - floatval($min));
            }

            if (isset($val->diferenciasAritmeticas)) {
                $datos = explode(",", $val->diferenciasAritmeticas);
                $min = min($datos);
                $max = max($datos);

                $val->diferenciasAritmeticas = (floatval($max) - floatval($min));
            }



            foreach ($json as $v) {
                if (isset($val->idcaptador)) {
                    $informeConcaptadorThTemp = 1;
                    if ($v['prueba'] == 'captador' && $v['activo'] == 1 && $v['idconf_maquina'] == $val->idcaptador) {
                        $val->marca_rpm = $v['marca'];
                        $val->serial_rpm = $v['serie_maquina'];
                    }
                    // if ($v['prueba'] == 'sonometria' && $v['activo'] == 1 && $v['idconf_maquina'] == $val->idsonometro) {
                    //     $val->marca_sonometro = $v['marca'];
                    //     $val->serie_sonometro = $v['serie_maquina'];
                    // }
                    if ($v['prueba'] == 'termohigrometro' && $v['activo'] == 1 && $v['idconf_maquina'] == $val->idth) {
                        if (isset($val->marca_temp_a)) {
                            $val->marca_temp_a = $v['marca'];
                            $val->marca_hum_r = $v['marca'];
                        }
                        if (isset($val->serie_hum_a)) {
                            $val->serie_hum_a = $v['serie_maquina'];
                            $val->serie_hum_r = $v['serie_maquina'];
                        }
                    }
                    if ($v['prueba'] == 'perifericotemperatura' && $v['activo'] == 1 && $v['idconf_maquina'] == $val->idensortemp) {
                        $val->marca_tem_m  = $v['marca'];
                        $val->serial_tem_m = $v['serie_maquina'];
                    }
                }

                if (isset($val->idsonometro) && $v['prueba'] == 'sonometro' && $v['activo'] == 1 && $v['idconf_maquina'] == $val->idsonometro) {
                    $informeConcaptadorThTemp = 1;
                    $val->marca_sonometro = $v['marca'];
                    $val->serie_sonometro = $v['serie_maquina'];
                }

                if ($v['idconf_maquina'] == $idconf_maquina) {
                    if (isset($val->Razon_social))
                        $val->Razon_social = $this->razonSocialCda;

                    if (isset($val->No_serie_analizador))
                        $val->No_serie_analizador = strtoupper($v['serie_maquina']);
                    if (isset($val->numeroSerieAnalizador))
                        $val->numeroSerieAnalizador = strtoupper($v['serie_maquina']);
                    if (isset($val->Serie_analizador))
                        $val->Serie_analizador = strtoupper($v['serie_maquina']);

                    if (isset($val->No_serie_opaciemtro))
                        $val->No_serie_opaciemtro = strtoupper($v['serie_maquina']);
                    if (isset($val->numeroSerieOpacimetro))
                        $val->numeroSerieOpacimetro = strtoupper($v['serie_maquina']);

                    if (isset($val->No_serie_banco))
                        $val->No_serie_banco = strtoupper($v['serie_banco']);
                    if (isset($val->Serie_banco))
                        $val->Serie_banco = strtoupper($v['serie_banco']);
                    if (isset($val->numero_serie_banco))
                        $val->numero_serie_banco = strtoupper($v['serie_banco']);
                    if (isset($val->numeroSerieBanco))
                        $val->numeroSerieBanco = strtoupper($v['serie_banco']);
                    if (isset($val->Serie_del_medidor))
                        $val->Serie_del_medidor = strtoupper($v['serie_banco']);

                    if (isset($val->marca_bg))
                        $val->marca_bg = strtoupper($v['marca']);

                    if (isset($val->No_serie_electronico_del_opaciemtro))
                        $val->No_serie_electronico_del_opaciemtro = strtoupper($v['serie_banco']);
                    if (isset($val->Serie_electronico_medidor))
                        $val->Serie_electronico_medidor = strtoupper($v['serie_banco']);


                    if (isset($val->inspector_realiza_prueba))
                        $val->inspector_realiza_prueba = preg_replace('/\s+/', ' ', trim($val->inspector_realiza_prueba));

                    if (isset($val->causa_rechazo) && !empty($val->causa_rechazo)) {
                        // Decodificar el JSON de causa_rechazo
                        $val->causa_rechazo = json_decode($val->causa_rechazo, true);
                    }
                    // $val->causa_rechazo = json_decode($val->causa_rechazo, true);

                    // Verificar si fue exitoso o asignar array vacío si falla
                    // if (json_last_error() !== JSON_ERROR_NONE || !is_array($causa_rechazo_array)) {
                    //     $causa_rechazo_array = []; // Valor por defecto si no es un JSON válido
                    // }


                    foreach ($maquinaData as $m) {
                        if ($m['idconf_maquina'] == $idconf_maquina) {



                            if ($m['nombre'] == "nombreMarca") {
                                if (isset($val->Marca_analizador))
                                    $val->Marca_analizador = strtoupper($m['valor']);
                                if (isset($val->marca_equipo))
                                    $val->marca_equipo = strtoupper($m['valor']);
                                if (isset($val->marcaAnalizador))
                                    $val->marcaAnalizador = strtoupper($m['valor']);
                                if (isset($val->Marca_opaciemtro))
                                    $val->Marca_opaciemtro = strtoupper($m['valor']);
                                if (isset($val->Marca_opacimetro))
                                    $val->Marca_opacimetro = strtoupper($m['valor']);
                                if (isset($val->marcaOpacimetro))
                                    $val->marcaOpacimetro = strtoupper($m['valor']);
                            }
                            if ($m['nombre'] == "marcasoft") {
                                if (isset($val->Nombre_programa))
                                    $val->Nombre_programa = $m['valor'];
                                if (isset($val->Nombre_delsoftware_de_aplicacion))
                                    $val->Nombre_delsoftware_de_aplicacion = $m['valor'];
                                if (isset($val->nombreSoftwareAplicacion))
                                    $val->nombreSoftwareAplicacion = $m['valor'];
                                if (isset($val->Marca_software_operacion))
                                    $val->Marca_software_operacion = $m['valor'];
                                if (isset($val->nom_soft))
                                    $val->nom_soft = $m['valor'];
                                if (isset($val->nombre_software))
                                    $val->nombre_software = $m['valor'];
                            }
                            if ($m['nombre'] == "Version_programa") {
                                if (isset($val->Version_software_de_aplicacion))
                                    $val->Version_software_de_aplicacion = $m['valor'];
                                if (isset($val->Version_software_operacion))
                                    $val->Version_software_operacion = $m['valor'];
                                if (isset($val->versionSoftwareAplicacion))
                                    $val->versionSoftwareAplicacion = $m['valor'];
                                if (isset($val->Version_software_operacion))
                                    $val->Version_software_operacion = $m['valor'];
                            }

                            if ($m['nombre'] == "versionsoft") {
                                if (isset($val->Version_software_operacion))
                                    $val->Version_software_operacion = $m['valor'];
                                if (isset($val->Version_software_de_aplicacion))
                                    $val->Version_software_de_aplicacion = $m['valor'];
                                if (isset($val->versionSoftwareAplicacion))
                                    $val->versionSoftwareAplicacion = $m['valor'];
                                if (isset($val->ver_soft))
                                    $val->ver_soft = $m['valor'];
                                if (isset($val->version_software))
                                    $val->version_software = $m['valor'];
                                if (isset($val->Version_software_operacion))
                                    $val->Version_software_operacion = $m['valor'];
                            }
                            if ($m['nombre'] == "noSerieBench") {
                                if (isset($val->No_serie_electronico_del_analizador))
                                    $val->No_serie_electronico_del_analizador = $m['valor'];
                                if (isset($val->numero_serie_fisico))
                                    $val->numero_serie_fisico = $m['valor'];
                                if (isset($val->numero_serie_electronico))
                                    $val->numero_serie_electronico = $m['valor'];
                                if (isset($val->numeroSerieElectronico))
                                    $val->numeroSerieElectronico = $m['valor'];
                                if (isset($val->serial_e))
                                    $val->serial_e = $m['valor'];
                                if (isset($val->numeroSerieBanco))
                                    $val->numeroSerieBanco = $m['valor'];
                                if (isset($val->No_serie_banco))
                                    $val->No_serie_banco = $m['valor'];
                            }

                            if ($m['nombre'] == "noSerieOpacimetro") {
                                if (isset($val->Serie_electronico_medidor))
                                    $val->Serie_electronico_medidor = $m['valor'];
                                if (isset($val->numeroSerieElectronicoOpacimetro))
                                    $val->numeroSerieElectronicoOpacimetro = $m['valor'];
                                if (isset($val->numero_serie_fisico))
                                    $val->numero_serie_fisico = $m['valor'];
                                if (isset($val->numeroSerieOpacimetro))
                                    $val->numeroSerieOpacimetro = $m['valor'];
                                if (isset($val->No_serie_opacimetro))
                                    $val->No_serie_opacimetro = $m['valor'];
                            }
                            if ($m['nombre'] == "pef") {
                                if (isset($val->Pef))
                                    $val->Pef = $m['valor'];
                                if (isset($val->valorPef))
                                    $val->valorPef = $m['valor'];
                                if (isset($val->vr_pef_ltoe))
                                    $val->vr_pef_ltoe = $m['valor'];
                            }

                            if ($m['nombre'] == "ltoe") {
                                $valorFloat = (float)$m['valor'];
                                $valorDividido = $valorFloat / 1000;

                                if (isset($val->ltoe))
                                    $val->ltoe = $valorDividido;
                                if (isset($val->Ltoe))
                                    $val->Ltoe = $valorDividido;
                                if (isset($val->vr_pef_ltoe))
                                    $val->vr_pef_ltoe = $valorDividido;
                            }


                            //exit;
                        }
                    }
                }
            }
            if (isset($val->Numero_total_equipos_certificados))
                $val->Numero_total_equipos_certificados = ($numeroOpa + $numeroAnalizador2t + $numeroAnalizador4t + $numeroAnalizadorotto);
            if (isset($val->Numero_total_de_equipos_opacimetros))
                $val->Numero_total_de_equipos_opacimetros = $numeroOpa;
            if (isset($val->total_equipos_opacimetros))
                $val->total_equipos_opacimetros = $numeroOpa;
            if (isset($val->Numero_total_opacimetros))
                $val->Numero_total_opacimetros = $numeroOpa;
            if (isset($val->Numero_total_analizadores))
                $val->Numero_total_analizadores = $numeroAnalizadorotto;
            if (isset($val->Numero_total_analizadores_2t))
                $val->Numero_total_analizadores_2t = $numeroAnalizador2t;
            if (isset($val->total_equipos_analizadores_motos_2t))
                $val->total_equipos_analizadores_motos_2t = $numeroAnalizador2t;
            if (isset($val->Numero_total_de_analizadores_mots_2T))
                $val->Numero_total_de_analizadores_mots_2T = $numeroAnalizador2t;
            if (isset($val->Numero_total_analizadores_4t))
                $val->Numero_total_analizadores_4t = $numeroAnalizador4t;
            if (isset($val->total_equipos_analizadores_motos_4t))
                $val->total_equipos_analizadores_motos_4t = $numeroAnalizador4t;

            if (isset($val->Numero_total_de_analizadores_mots_4T))
                $val->Numero_total_de_analizadores_mots_4T = $numeroAnalizador4t;
            if (isset($val->No_total_equipos_analizadores_motos_4T_2T))
                $val->No_total_equipos_analizadores_motos_4T_2T = $numeroAnalizador4t + $numeroAnalizador2t;
            if (isset($val->Numero_total_de_analizadores_Otto))
                $val->Numero_total_de_analizadores_Otto = $numeroAnalizadorotto;
            if (isset($val->total_equipos_analizadores_chispa))
                $val->total_equipos_analizadores_chispa = $numeroAnalizadorotto;
            if (isset($val->Numero_expe))
                $val->Numero_expe = $this->numeroExpediente;
            if (isset($val->expedienteCornare))
                $val->expedienteCornare = $this->numeroExpediente;
            if (isset($val->expediente_autoridad_ambiental))
                $val->expediente_autoridad_ambiental = $this->numeroExpediente;

            //$this->downloadInforemeCorantioquia($query);
        }
        if ($download == 1) {
            date_default_timezone_set('America/bogota');
            $rta['cda'] = $this->infocda();
            $nombreCda = $rta['cda']->nombre_cda;
            $date = date("MY");
            $delimiter = ";";
            $newline = "\r\n";
            $nombrecsv = 'Reporte Informacion_' . $nombreCda . '_' . $date;

            // Remove 'idcaptador' column from the query results
            if ($informeConcaptadorThTemp == 1) {
                foreach ($query as $key => $row) {
                    unset($query[$key]->idcaptador);
                    unset($query[$key]->idsonometro);
                    unset($query[$key]->idth);
                    unset($query[$key]->idensortemp);
                }
            }



            $val = (array) $query[0];
            $head = array_keys($val);

            $this->getCsvDownload($head, $nombrecsv, $query);
        } else {
            return $query;
        }
    }

    function getInformeCarNew()
    {
        $this->setConf();
        $datoInforme = $this->tipo_informe_fugas_cal_lin;
        $idhojapruebas = "71237";
        $rta = $this->Mambientales->getPruebagases($idhojapruebas);
        foreach ($rta as $value) {
            $data = $this->Mambientales->informe_car_adutioria_new($value->idmaquina, $value->idprueba, $datoInforme);
            $this->envioCar($data, $value->idmaquina, $value->idprueba);
        }
    }

    public function informecorponor($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme)
    {
        switch ($prueba) {
            case 'analizador':
                if ($idconf_linea_inspeccion == 3 || $idconf_linea_inspeccion == 9 || $idconf_linea_inspeccion == 10) {
                    //                    $query = $this->Mambientales->informecarder_motos($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    $query = $this->Mambientales->informe_762($idconf_maquina, $fechainicial, $fechafinal, $datoInforme, 3, 3);


                    $filename = ' Informe Corponor Motos';
                    $this->informe762($query, $filename, $idconf_maquina);
                    //                    $this->downloadinforme($query, $filename, $idconf_maquina);
                } else {
                    //                    $query = $this->Mambientales->informecarder_gasolina($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);

                    $query = $this->Mambientales->informe_762($idconf_maquina, $fechainicial, $fechafinal, $datoInforme, 1, 3);
                    $filename = ' Informe Corponor Gasolina';
                    $this->informe762($query, $filename, $idconf_maquina);
                    //                    $this->downloadinforme($query, $filename, $idconf_maquina);
                }
                break;
            case 'opacidad':
                $query = $this->Mambientales->informe_762($idconf_maquina, $fechainicial, $fechafinal, $datoInforme, 2, 2);
                //                $query = $this->Mambientales->informecarder_disel($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                $filename = ' Informe Corponor Diesel';
                $this->informe762($query, $filename, $idconf_maquina);
                //$this->downloadinforme($query, $filename, $idconf_maquina);
                break;
            default:
                echo 'ninguno';
                break;
        }
    }

    public function informeCorpoboyaca($idconf_maquina, $fechainicial, $fechafinal, $prueba, $idconf_linea_inspeccion, $datoInforme)
    {
        switch ($prueba) {
            case 'analizador':
                if ($idconf_linea_inspeccion == 3 || $idconf_linea_inspeccion == 9 || $idconf_linea_inspeccion == 10) {
                    //                    $query = $this->Mambientales->informecarder_motos($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                    $query = $this->Mambientales->informe_762($idconf_maquina, $fechainicial, $fechafinal, $datoInforme, 3, 3);
                    $filename = ' Informe Corpoboyaca Motos';
                    $this->informe762($query, $filename, $idconf_maquina);
                    //                    $this->downloadinforme($query, $filename, $idconf_maquina);
                } else {
                    //                    $query = $this->Mambientales->informecarder_gasolina($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);

                    $query = $this->Mambientales->informe_762($idconf_maquina, $fechainicial, $fechafinal, $datoInforme, 1, 3);
                    $filename = ' Informe Corpoboyaca Gasolina';
                    $this->informe762($query, $filename, $idconf_maquina);
                    //                    $this->downloadinforme($query, $filename, $idconf_maquina);
                }
                break;
            case 'opacidad':
                $query = $this->Mambientales->informe_762($idconf_maquina, $fechainicial, $fechafinal, $datoInforme, 2, 2);
                //                $query = $this->Mambientales->informecarder_disel($idconf_maquina, $fechainicial, $fechafinal, $datoInforme);
                $filename = ' Informe Corpoboyaca Diesel';
                $this->informe762($query, $filename, $idconf_maquina);
                //$this->downloadinforme($query, $filename, $idconf_maquina);
                break;
            default:
                echo 'ninguno';
                break;
        }
    }

    function envioCar($data, $idmaquina, $idprueba)
    {
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $datos = json_decode($json);
        foreach ($datos as $item) {
            if ($item->idconf_maquina == $idmaquina) {
                $marca = $item->marca;
                $serie_maquina = $item->serie_maquina;
            } else {
                $marca = $data[0]->Marca_analizador;
                $serie_maquina = $data[0]->No_serie_analizador;
            }
            if ($item->idconf_maquina == $data[0]->idsonometro) {
                $marca_sonometro = $item->marca;
                $serie_sonometro = $item->serie_maquina;
            } else {
                $marca_sonometro = $data[0]->Marca_sonometro;
                $serie_sonometro = $data[0]->Serie_sonometro;
            }
        }
        $toCar = array(
            'meastype' => $data[0]->norma,
            'placa' => $data[0]->Placa,
            'measdata' => array(
                'med_vrpef' => $data[0]->Vr_PEF,
                'med_seriebanco' => $data[0]->No_de_serie_banco,
                'med_serieanalizado' => $data[0]->No_serie_analizador,
                'med_analizador' => $data[0]->Marca_analizador,
                'med_vrspanbajohc' => $data[0]->Vr_Span_Bajo_HC,
                'med_resvrspanbajohc' => $data[0]->Resultado_Vr_Span_Bajo_HC,
                'med_vrspanbajoco' => $data[0]->Vr_Span_Bajo_CO,
                'med_resvrspanbajoco' => $data[0]->Resultado_Vr_Span_Bajo_CO,
                'med_vrspanbajoco2' => $data[0]->Vr_Span_Bajo_CO2,
                'med_resvrspanbajoco2' => $data[0]->Resultado_Vr_Span_Bajo_CO2,
                'med_vrspanaltohc' => $data[0]->Vr_Span_Alto_HC,
                'med_resvrspanaltohc' => $data[0]->Resultado_Vr_Span_Alto_HC,
                'med_vrspanaltoco' => $data[0]->Vr_Span_Alto_CO,
                'med_resvrspanaltoco' => $data[0]->Resultado_Vr_Span_Alto_CO,
                'med_vrspanaltoco2' => $data[0]->Vr_Span_Alto_CO2,
                'med_resvrspanaltoco2' => $data[0]->Resultado_Vr_Span_Alto_CO2,
                'med_fverificacion' => $data[0]->Fecha_y_hora_ultima_verificacion_y_ajuste,
                'med_nomproveedor' => $data[0]->Nombre_proveedor,
                'med_nomprograma' => $data[0]->Nombre_programa,
                'med_verprograma' => $data[0]->Version_programa,
                'med_seriemedido' => $serie_maquina,
                'med_marcamedidor' => $marca,
                'med_vrplinealidad' => $data[0]->Vr_primer_punto_de_linealidad,
                'med_resplinealidad' => $data[0]->Resultado_primer_punto_de_linealidad,
                'med_vrslinealidad' => $data[0]->Vr_segundo_punto_de_linealidad,
                'med_resslinealidad' => $data[0]->Resultado_segundo_punto_de_linealidad,
                'med_vrtlinealidad' => $data[0]->Vr_tercer_punto_de_linealidad,
                'med_restlinealidad' => $data[0]->Resultado_tercer_punto_de_linealidad,
                'med_vrclinealidad' => $data[0]->Vr_cuarto_punto_de_linealidad,
                'med_resclinealidad' => $data[0]->Resultado_cuarto_punto_de_linealidad,
                'med_placa' => $data[0]->Placa
            ),
            'proofdata' => array(
                'ana_consecutivo' => $data[0]->No_de_consecutivo_prueba,
                'ana_finicio' => $data[0]->Fecha_y_hora_inicio_de_la_prueba,
                'ana_ffin' => $data[0]->Fecha_y_hora_final_de_la_prueba,
                'ana_faborto' => $data[0]->Fecha_y_hora_aborto_de_la_prueba,
                'ana_operador' => $data[0]->Operador_realiza_prueba,
                'ana_metodotemperatura' => $data[0]->Metodo_de_medicion_de_temperatura_motor,
                'ana_tempambiente' => $data[0]->Temperatura_ambiente,
                'ana_humedad' => $data[0]->Humedad_relativa,
                'ana_causalaborto' => $data[0]->Causal_aborto_analisis
            ),
            'custdata' => array(
                'dus_nombre' => $data[0]->Nombre_razon_social_propietario,
                'dus_tdocumento' => $data[0]->Tipo_documento,
                'dus_documento' => $data[0]->No_documento,
                'dus_direccion' => $data[0]->Direccion,
                'dus_telefono' => $data[0]->Telefono_2,
                'dus_celular' => $data[0]->Telefono_1,
                'dus_ciudad' => $data[0]->Ciudad
            ),
            'vehidata' => array(
                'dve_marca' => $data[0]->Marca,
                'dve_tipomotor' => $data[0]->tipomotor,
                'dve_linea' => $data[0]->Linea,
                'dve_diseno' => $data[0]->Carroceria,
                'dve_ano' => $data[0]->Ano_modelo,
                'dve_placa' => $data[0]->Placa,
                'dve_cilindraje' => $data[0]->Cilindraje,
                'dve_clase' => $data[0]->Clase,
                'dve_servicio' => $data[0]->Servicio,
                'dve_combustible' => $data[0]->Combustible,
                'dve_nomotor' => $data[0]->Numero_motor,
                'dve_vinserie' => $data[0]->Numero_VIN_serie,
                'dve_licencia' => $data[0]->No_licencia_transito,
                'dve_kilometraje' => $data[0]->Kilometraje,
                'dve_modmotor' => $data[0]->modificadion_motor,
                'dve_potencia' => $data[0]->Potencia_motor
            ),
            'revidata' => array(
                'rev_tuboescape' => $data[0]->Fugas_tubo_escape,
                'rev_silenciador' => $data[0]->Fugas_silenciador,
                'rev_adefescape' => $data[0]->Accesorios_o_deformaciones_en_el_tubo_de_escape_que_no_permitan_la_instalacion_sistema_de_muestreo,
                'rev_tapacombustible' => $data[0]->Presencia_tapa_Combustible_o_fugas_en_el_mismo,
                'rev_tapaaceite' => $data[0]->Presencia_Tapa_Aceite,
                'rev_filtroaire' => $data[0]->Ausencia_o_mal_estado_filtro_de_Aire,
                'rev_salidaadic' => $data[0]->Salidas_adicionales_diseno,
                'rev_pcv' => $data[0]->PCV_Sistema_recirculacion_de_gases_del_carter,
                'rev_hunegroazul' => $data[0]->Presencia_humo_negro_azul,
                'rev_fuerarango' => $data[0]->RPM_fuera_rango,
                'rev_refrigeracion' => $data[0]->Falla_sistema_de_refrigeracion,
                'rev_tempmotor' => $data[0]->Temperatura_motor,
                'rev_rpm' => $data[0]->Rpm_ralenti,
                'rev_hc' => $data[0]->Hc_ralenti,
                'rev_co' => $data[0]->Co_ralenti,
                'rev_co2' => $data[0]->Co2_ralenti,
                'rev_o2' => $data[0]->O2_ralenti,
                'rev_rpmcrucero' => $data[0]->Rpm_crucero,
                'rev_hccrucero' => $data[0]->Hc_crucero,
                'rev_cocrucero' => $data[0]->Co_crucero,
                'rev_co2crucero' => $data[0]->Co2_crucero,
                'rev_o2crucero' => $data[0]->O2_crucero,
                'rev_dilucion' => $data[0]->Presencia_de_dilucion,
                'rev_incumemision' => $data[0]->Incumplimiento_de_niveles_de_emision_gases,
                'rev_revinestable' => $data[0]->Revoluciones_instables_o_fuera_rango_disel,
                'rev_indmalfunc' => $data[0]->Indicacion_mal_funcionamiento_del_motor_disel,
                'rev_controlvel' => $data[0]->Funcionamiento_del_sistema_de_control_velocidad_de_motor_disel,
                'rev_dispositivosrpm' => $data[0]->Instalacion_dispositivos_que_alteren_rpm_disel,
                'rev_tempinicial' => $data[0]->Temperatura_inicial_de_motor_disel,
                'rev_velalcanzada' => $data[0]->Velocidad_no_alcanzada_5_seg_disel,
                'rev_rpmvelocidad' => $data[0]->Rpm_velocidad_gobernada_disel,
                'rev_fallamotor' => $data[0]->Falla_subita_motor_disel,
                'rev_resopacidadpre' => $data[0]->Resultado_ciclo_preliminar_disel,
                'rev_rpmgobernadapre' => $data[0]->RPM_gobernada_ciclo_preliminar_disel,
                'rev_resopacidadpciclo' => $data[0]->Resultado_opacidad_primer_ciclo_disel,
                'rev_rpmpciclo' => $data[0]->RPM_gobernada_primer_ciclo_disel,
                'rev_resopacidadsciclo' => $data[0]->Resultado_opacidad_segundo_ciclo_disel,
                'rev_rpmsciclo' => $data[0]->RPM_gobernada_segundo_ciclo,
                'rev_resopacidadtciclo' => $data[0]->Resultado_opacidad_tercer_ciclo,
                'rev_rpmtciclo' => $data[0]->RPM_gobernada_tercer_ciclo,
                'rev_ltoe' => $data[0]->LTOE,
                'rev_tempfinal' => $data[0]->Temperatura_final_del_motor_disel,
                'rev_fallatemp' => $data[0]->Falla_por_temperatura_motor_disel,
                'rev_inestabilidad' => $data[0]->Inestabilidad_durante_ciclos_de_medicion_disel,
                'rev_difaritmetica' => $data[0]->Diferencias_aritmetica_disel,
                'rev_resfinal' => $data[0]->Resultado_final_opa_disel,
                'rev_causarechazo' => $data[0]->Causas_rechazo_opa,
                'rev_concepto' => $data[0]->Concepto_tecnico
            ),
            'sondata' => array(
                'son_marca' => $marca_sonometro,
                'son_serie' => $serie_sonometro,
                'son_valor' => $data[0]->Valor_de_ruido_reportado
            )
        );
        //        echo $toCar;
        $toCar = json_encode($toCar);

        $request_headers = array(
            "Authorization:" . "b56c19aa217e36a6c182be3ce6fab1851c32a6860f74a312f2cf6d230f6c1573",
            "Content-Type:" . "application/json"
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://3.138.158.109:8480/cdapp/rest/final/medicionfinal');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $toCar);

        $season_data = curl_exec($ch);

        if (curl_errno($ch)) {
            print "Error: " . curl_error($ch);
            exit();
        }
        curl_close($ch);
        $json = json_decode($season_data, true);
        date_default_timezone_set('America/bogota');
        if ($json['resp'] == "OK") {
            $r['idprueba'] = $idprueba;
            $r['tipo'] = 'Envio car exitoso';
            $r['estado'] = 1;
            $r['usuario'] = $this->session->userdata("IdUsuario");
            $r['fecharegistro'] = date("Y-m-d H:i:s");
            $this->Mambientales->insertControlCar($r);
        } else {
            $r['idprueba'] = $idprueba;
            $r['tipo'] = 'Envio car error';
            $r['estado'] = 0;
            $r['usuario'] = $this->session->userdata("IdUsuario");
            $r['fecharegistro'] = date("Y-m-d H:i:s");
            $this->Mambientales->insertControlCar($r);
        }
    }

    var $arrayCar;

    function PqekRes()
    {
        $this->arrayCar["dtb_nombre"] = "";
        $this->arrayCar["dtb_tipodoc"] = "";
        $this->arrayCar["dtb_numdoc"] = "";
        $this->arrayCar["dtb_direccion"] = "";
        $this->arrayCar["dtb_telefono"] = "";
        $this->arrayCar["dtb_telefono2"] = "";
        $this->arrayCar["dtb_ciudad"] = "";
        $this->arrayCar["dbt_marca"] = "";
        $this->arrayCar["dbt_tipomotor"] = "";
        $this->arrayCar["dbt_linea"] = "";
        $this->arrayCar["dbt_diseno"] = "";
        $this->arrayCar["dbt_modelo"] = "";
        $this->arrayCar["dbt_placa"] = "";
        $this->arrayCar["dbt_cilindraje"] = "";
        $this->arrayCar["dbt_clase"] = "";
        $this->arrayCar["dbt_servicio"] = "";
        $this->arrayCar["dbt_combustible"] = "";
        $this->arrayCar["dbt_nomotor"] = "";
        $this->arrayCar["dbt_vinserie"] = "";
        $this->arrayCar["dbt_licencia"] = "";
        $this->arrayCar["dbt_kilometraje"] = "";
        $this->arrayCar["dtb_tipov"] = "";
        $toCar = array(
            'basic' => $this->arrayCar
        );
        $toCar = json_encode($toCar);

        $subscription_key = '';
        $host = '';
        $request_headers = array(
            "Authorization:" . "b56c19aa217e36a6c182be3ce6fab1851c32a6860f74a312f2cf6d230f6c1573",
            "Content-Type:" . "application/json"
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://3.138.158.109:8480/cdapp/rest/basico/registro');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $toCar);

        $season_data = curl_exec($ch);

        if (curl_errno($ch)) {
            print "Error: " . curl_error($ch);
            exit();
        }

        // Show me the result
        curl_close($ch);
        $json = json_decode($season_data, true);
        var_dump($json);
    }

    function getBitacoraGases()
    {
        $hc = [1796, 1796, 1796, 3390, 3390, 4490, 4490, 4860, 5170, 5170, 5430, 6560, 6560, 6410, 6410, 6340, 6340, 6270, 6270, 6190, 6190, 6190, 6100, 6100, 6020, 6020, 6020, 5880, 5880, 5880, 5820, 5820, 5790, 5790, 5750, 5750, 5750, 5750, 5740, 5740, 5740, 5800, 5800, 5800, 5830, 5880, 5880, 5880, 5880, 5950, 5950, 5980, 5980, 6000, 6000, 6020, 6020, 6020, 6020, 6020];
        $co = [2.31, 2.31, 2.31, 3.97, 3.97, 4.75, 4.75, 4.97, 5.12, 5.12, 5.21, 5.59, 5.59, 5.43, 5.43, 5.34, 5.34, 5.25, 5.25, 5.19, 5.19, 5.19, 5.14, 5.14, 5.09, 5.09, 5.09, 5, 5, 5, 4.98, 4.98, 4.97, 4.97, 4.96, 4.96, 4.96, 4.96, 4.96, 4.96, 4.96, 4.94, 4.94, 4.94, 4.93, 4.92, 4.92, 4.92, 4.92, 4.93, 4.93, 4.95, 4.95, 4.98, 4.98, 5, 5, 5.01, 5.01, 5.01];
        $co2 = [1.4, 1.4, 1.4, 2.4, 2.4, 3, 3, 3.1, 3.1, 3.1, 3.2, 3.8, 3.8, 4.2, 4.2, 4.4, 4.4, 4.5, 4.5, 4.7, 4.7, 4.7, 4.8, 4.8, 4.9, 4.9, 4.9, 5.1, 5.1, 5.1, 5.2, 5.2, 5.2, 5.2, 5.2, 5.2, 5.2, 5.2, 5.2, 5.2, 5.2, 5.1, 5.1, 5.1, 5.1, 5, 5, 5, 5, 5, 5, 4.9, 4.9, 4.9, 4.9, 4.9, 4.9, 4.9, 4.9, 4.9];
        $o2 = [16.5, 16.5, 16.5, 13.9, 13.9, 12.4, 12.4, 11.9, 11.6, 11.6, 11.3, 10.1, 10.1, 9.8, 9.8, 9.6, 9.6, 9.5, 9.5, 9.4, 9.4, 9.4, 9.3, 9.3, 9.2, 9.2, 9.2, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9.2, 9.2, 9.2, 9.3, 9.4, 9.4, 9.4, 9.4, 9.4, 9.4, 9.4, 9.4, 9.4, 9.4, 9.4, 9.4, 9.4, 9.4, 9.3];
        $rpm = [1380, 1460, 1340, 1310, 1320, 1320, 1340, 1350, 1340, 1340, 1320, 1370, 1380, 1400, 1400, 1420, 1400, 1380, 1380, 1380, 1400, 1410, 1400, 1390, 1390, 1400, 1400, 1400, 1400, 1410, 1380, 1400, 1410, 1400, 1400, 1400, 1400, 1400, 1380, 1370, 1390, 1400, 1420, 1400, 1380, 1390, 1410, 1400, 1410, 1390, 1410, 1420, 1380, 1370, 1390, 1390, 1420, 1420, 1420, 1440];
        $ultimosSegundosHC_1 = [-3, -3, -3, -2, 0, 0, 2, 3, 3, 3];
        $ultimosSegundosHC_2 = [-2, -2, -2, -1, 0, 0, 1, 2, 2, 2];
        $ultimosSegundosHC_3 = [-1, -1, -1, 0, 0, 0, 0, 1, 1, 1];
        $ultimosSegundosCO_1 = [-0.03, -0.03, -0.03, -0.02, 0, 0, 0.02, 0.03, 0.03, 0.03];
        $ultimosSegundosCO_2 = [-0.02, -0.02, -0.02, -0.01, 0, 0, 0.01, 0.02, 0.02, 0.02];
        $ultimosSegundosCO_3 = [-0.01, -0.01, -0.01, 0, 0, 0, 0, 0.01, 0.01, 0.01];

        $rta = $this->Mambientales->getBitacoraGases();
        if ($rta[0]->control == 0) {
            // se valida si aplica o no la correcion de oxigeno
            if (($rta[0]->o2_ralenti >= 11.0 && $rta[0]->tiempos == '2' && $rta[0]->tipo_vehiculo == 3 && $rta[0]->ano_modelo < 2010)) {
                $dfhc = 6001 - round($rta[0]->promhcra_ant);
                $dfco = 4.98 - $rta[0]->promcora_ant;
            } else if (($rta[0]->o2_ralenti >= 6.0 && $rta[0]->tiempos == '4' && $rta[0]->tipo_vehiculo == 3) || ($rta[0]->o2_ralenti >= 6.0 && $rta[0]->tiempos == '2' && $rta[0]->tipo_vehiculo == 3 && $rta[0]->ano_modelo >= 2010)) {
                $dfhc = 6001 - round($rta[0]->promhcra_ant);
                $dfco = 4.98 - $rta[0]->promcora_ant;
            } else {
                $dfhc = 6001 - round($rta[0]->hc_ralenti);
                $dfco = 4.98 - $rta[0]->co_ralenti;
            }
            $dfco2 = 4.91 - $rta[0]->co2_ralenti;
            $dfo2 = 9.39 - $rta[0]->o2_ralenti;
            $dfrpm = 1406 - $rta[0]->rpm_ralenti;
            // se calcula el modulo para poder sumarlo a las rpm y que de el promedio 
            $rpmreal = $rpm[0] - $dfrpm;
            $rpmmod = $rpmreal % 10;
            $t = 0.0;
            $hcfinal = [];
            $cofinal = [];
            $co2final = [];
            $o2final = [];
            $rpmfinal = [];
            $fechahora = [];
            $j_hc = 0;
            $rhc = rand(1, 3);
            $rco = rand(1, 3);
            $encontradoo2 = false;
            $o2v_ = 0;
            $rpmdata = ceil($dfrpm / 10) * 10;
            $ralentiData = [];
            for ($i = 1; $i <= 60; $i++) {
                if ($i > 1) {
                    $t = $t + 0.5;
                } else {
                    $t = $t;
                }
                $rpm_ = $rpm[$i - 1] - $rpmdata;
                $hc_ = $hc[$i - 1] - $dfhc;
                $co_ = round($co[$i - 1] - $dfco, 3);
                $co2_ = round($co2[$i - 1] - $dfco2, 2);
                $o2_ = round($o2[$i - 1] - $dfo2, 2);
                if ($o2_ > 18 && !$encontradoo2) {
                    $encontradoo2 = true;
                    $o2v_ = $o2_;
                }
                // cuadre de hc y co mediante los vectores de los ultimo 10 datos
                if ($i > 50) {
                    switch ($rhc) {
                        case 1:
                            $hc_ = $ultimosSegundosHC_1[$j_hc] + $hc_;
                            break;
                        case 2:
                            $hc_ = $ultimosSegundosHC_2[$j_hc] + $hc_;
                            break;
                        case 3:
                            $hc_ = $ultimosSegundosHC_3[$j_hc] + $hc_;
                            break;
                    }
                    switch ($rco) {
                        case 1:
                            $co_ = $ultimosSegundosCO_1[$j_hc] + $co_;
                            break;
                        case 2:
                            $co_ = $ultimosSegundosCO_2[$j_hc] + $co_;
                            break;
                        case 3:
                            $co_ = $ultimosSegundosCO_3[$j_hc] + $co_;
                            break;
                    }
                    //cuadre de rpm
                    if ($rpmmod > 0) {
                        $rpm_ = $rpm_ + 10;
                    }
                    $rpmmod--;
                    $j_hc++;
                }
                $arrayRal = [
                    "tiempo" => $t,
                    "hc" => $hc_,
                    "co" => $co_,
                    "co2" => $co2_,
                    "o2" => $o2_,
                    "rpm" => $rpm_
                ];

                array_push($ralentiData, $arrayRal);
            }

            // se cambian los datos negativos por el primer valor positivo del vector
            // cuadre HC raelnti
            $promediohc = 0;
            for ($a = 0; $a < count($ralentiData); $a++) {
                if ($ralentiData[$a]["hc"] < 0) {
                    $ralentiData[$a]['hc'] = $ralentiData[$a]['hc'] * -1;
                }
                if ($a >= 50) {
                    $promediohc = $promediohc + $ralentiData[$a]['hc'];
                }
            }

            //            echo floatval($rta[0]->hc_ralenti) ."<br>".floatval($promediohc / 10);
            if (($rta[0]->o2_ralenti >= 11.0 && $rta[0]->tiempos == '2' && $rta[0]->tipo_vehiculo == 3 && $rta[0]->ano_modelo < 2010)) {
                if (floatval($rta[0]->promhcra_ant) !== floatval($promediohc / 10)) {
                    $ralentiData = $this->promedioCalculo($rta[0]->promhcra_ant, $ralentiData, 0.1, 'hc');
                }
            } else if (($rta[0]->o2_ralenti >= 6.0 && $rta[0]->tiempos == '4' && $rta[0]->tipo_vehiculo == 3) || ($rta[0]->o2_ralenti >= 6.0 && $rta[0]->tiempos == '2' && $rta[0]->tipo_vehiculo == 3 && $rta[0]->ano_modelo >= 2010)) {
                if (floatval($rta[0]->promhcra_ant) !== floatval($promediohc / 10)) {
                    $ralentiData = $this->promedioCalculo($rta[0]->promhcra_ant, $ralentiData, 0.1, 'hc');
                }
            } else {
                if (floatval($rta[0]->hc_ralenti) !== floatval($promediohc / 10)) {
                    //                    echo floatval($rta[0]->hc_ralenti) . "<br>" . floatval($promediohc / 10);
                    $ralentiData = $this->promedioCalculo($rta[0]->hc_ralenti, $ralentiData, 0.1, 'hc');
                }
            }

            //
            //
            //            // cuadre CO raelnti
            $PromedioCo = 0;
            for ($b = 0; $b < count($ralentiData); $b++) {
                if ($ralentiData[$b]['co'] < 0) {
                    $ralentiData[$b]['co'] = $ralentiData[$b]['co'] * -1;
                }
                if ($b >= 50) {
                    $PromedioCo = $PromedioCo + $ralentiData[$b]['co'];
                }
            }
            if (($rta[0]->o2_ralenti >= 11.0 && $rta[0]->tiempos == '2' && $rta[0]->tipo_vehiculo == 3 && $rta[0]->ano_modelo < 2010)) {
                if (floatval($rta[0]->promcora_ant) !== floatval($PromedioCo / 10)) {
                    $ralentiData = $this->promedioCalculo($rta[0]->promcora_ant, $ralentiData, 0.0001, 'co');
                }
            } else if (($rta[0]->o2_ralenti >= 6.0 && $rta[0]->tiempos == '4' && $rta[0]->tipo_vehiculo == 3) || ($rta[0]->o2_ralenti >= 6.0 && $rta[0]->tiempos == '2' && $rta[0]->tipo_vehiculo == 3 && $rta[0]->ano_modelo >= 2010)) {
                if (floatval($rta[0]->promcora_ant) !== floatval($PromedioCo / 10)) {
                    $ralentiData = $this->promedioCalculo($rta[0]->promcora_ant, $ralentiData, 0.0001, 'co');
                }
            } else {
                if (floatval($rta[0]->co_ralenti) !== floatval($PromedioCo / 10)) {
                    $ralentiData = $this->promedioCalculo($rta[0]->co_ralenti, $ralentiData, 0.0001, 'co');
                }
            }
            //
            //
            //            // cuadre CO2 raelnti
            $promedioCO2 = 0;
            for ($c = 0; $c < count($ralentiData); $c++) {
                if ($ralentiData[$c]['co2'] < 0) {
                    $ralentiData[$c]['co2'] = $ralentiData[$c]['co2'] * -1;
                }
                if ($c >= 50) {
                    $promedioCO2 = $promedioCO2 + $ralentiData[$c]['co2'];
                }
            }
            if (floatval($rta[0]->co2_ralenti) !== floatval($promedioCO2 / 10)) {
                $ralentiData = $this->promedioCalculo($rta[0]->co2_ralenti, $ralentiData, 0.0001, 'co2');
            }

            for ($d = 0; $d < count($ralentiData); $d++) {
                if ($ralentiData[$d]['o2'] > 18) {
                    $ralentiData[$d]['o2'] = $o2v_;
                }
                if ($ralentiData[$d]['o2'] < 0) {
                    $ralentiData[$d]['o2'] = 0.0;
                }
            }

            if ($rta[0]->rpm_crucero > 0) {
                $r = $this->logCrucero($rta);
                $res = json_encode($r);
            } else {
                $res = "";
            }

            $datos["idprueba"] = $rta[0]->idprueba;
            $datos["exosto"] = 1;
            $datos["datos_ciclo_ralenti"] = json_encode($ralentiData);
            $datos["datos_ciclo_crucero"] = $res;
            $this->Mambientales->logGasesInsert($datos);
        }
    }

    public function logCrucero($rta)
    {
        $hc = [68, 68, 85, 85, 95, 95, 107, 107, 111, 121, 121, 121, 127, 127, 140, 140, 154, 154, 154, 172, 172, 172, 175, 175, 187, 187, 187, 187, 191, 193, 193, 193, 196, 196, 208, 208, 211, 211, 223, 224, 224, 224, 230, 230, 231, 231, 234, 234, 234, 234, 234, 234, 236, 236, 238, 238, 238, 245, 247, 253];
        $co = [0.15, 0.15, 0.19, 0.19, 0.22, 0.22, 0.24, 0.24, 0.26, 0.26, 0.26, 0.26, 0.29, 0.29, 0.3, 0.3, 0.33, 0.33, 0.33, 0.36, 0.36, 0.36, 0.37, 0.37, 0.38, 0.38, 0.39, 0.39, 0.4, 0.4, 0.4, 0.4, 0.4, 0.4, 0.41, 0.41, 0.41, 0.41, 0.42, 0.43, 0.43, 0.43, 0.44, 0.44, 0.44, 0.44, 0.45, 0.45, 0.45, 0.45, 0.45, 0.45, 0.45, 0.45, 0.45, 0.45, 0.45, 0.45, 0.45, 0.45];
        $co2 = [5.25, 5.25, 6.1, 6.1, 7.03, 7.03, 7.82, 7.82, 8.61, 9.31, 9.31, 9.31, 9.9, 9.9, 10.4, 10.4, 10.8, 10.8, 10.8, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12.6, 12.8, 12.8, 12.8, 13, 13, 13.2, 13.2, 13.3, 13.3, 13.5, 13.6, 13.6, 13.6, 13.7, 13.7, 13.8, 13.8, 13.8, 13.8, 13.9, 13.9, 13.9, 13.9, 14, 14, 14.1, 14.1, 14.1, 14.2, 14.2, 14.2];
        $o2 = [15.07, 15.07, 13.8, 13.8, 12.53, 12.53, 11.32, 11.32, 10.19, 9.13, 9.13, 9.13, 8.16, 8.16, 7.29, 7.29, 6.52, 6.52, 6.52, 5.27, 5.27, 5.27, 4.75, 4.75, 4.3, 4.3, 3.91, 3.91, 3.57, 3.27, 3.27, 3.27, 3.01, 3.01, 2.8, 2.8, 2.6, 2.6, 2.43, 2.29, 2.29, 2.29, 2.17, 2.17, 2.05, 2.05, 1.95, 1.95, 1.86, 1.79, 1.79, 1.79, 1.72, 1.72, 1.66, 1.66, 1.66, 1.6, 1.56, 1.51];
        $rpm = [2280, 2350, 2330, 2280, 2310, 2270, 2350, 2360, 2270, 2280, 2350, 2300, 2290, 2350, 2360, 2310, 2320, 2310, 2280, 2300, 2310, 2350, 2360, 2340, 2310, 2360, 2340, 2360, 2310, 2340, 2270, 2320, 2360, 2280, 2350, 2300, 2290, 2310, 2310, 2330, 2340, 2290, 2350, 2350, 2300, 2300, 2340, 2280, 2310, 2340, 2300, 2350, 2320, 2310, 2360, 2360, 2340, 2330, 2300, 2360];
        $ultimosSegundosHC_1 = [-3, -3, -3, -2, 0, 0, 2, 3, 3, 3];
        $ultimosSegundosHC_2 = [-2, -2, -2, -1, 0, 0, 1, 2, 2, 2];
        $ultimosSegundosHC_3 = [-1, -1, -1, 0, 0, 0, 0, 1, 1, 1];
        $ultimosSegundosCO_1 = [-0.03, -0.03, -0.03, -0.02, 0, 0, 0.02, 0.03, 0.03, 0.03];
        $ultimosSegundosCO_2 = [-0.02, -0.02, -0.02, -0.01, 0, 0, 0.01, 0.02, 0.02, 0.02];
        $ultimosSegundosCO_3 = [-0.01, -0.01, -0.01, 0, 0, 0, 0, 0.01, 0.01, 0.01];

        // se valida si aplica o no la correcion de oxigeno

        $dfhc = 239 - round($rta[0]->hc_crucero);
        $dfco = 0.45 - $rta[0]->co_crucero;
        $dfco2 = 14.07 - $rta[0]->co2_crucero;
        $dfo2 = 1.667 - $rta[0]->o2_crucero;
        $dfrpm = 2333 - $rta[0]->rpm_crucero;
        // se calcula el modulo para poder sumarlo a las rpm y que de el promedio 
        $rpmreal = $rpm[0] - $dfrpm;
        $rpmmod = $rpmreal % 10;
        $t = 0.0;
        $hcfinal = [];
        $cofinal = [];
        $co2final = [];
        $o2final = [];
        $rpmfinal = [];
        $fechahora = [];
        $j_hc = 0;
        $rhc = rand(1, 3);
        $rco = rand(1, 3);
        $encontradoo2 = false;
        $o2v_ = 0;
        $rpmdata = ceil($dfrpm / 10) * 10;
        $cruceroData = [];
        for ($i = 1; $i <= 60; $i++) {
            if ($i > 1) {
                $t = $t + 0.5;
            } else {
                $t = $t;
            }
            $rpm_ = $rpm[$i - 1] - $rpmdata;
            $hc_ = $hc[$i - 1] - $dfhc;
            $co_ = round($co[$i - 1] - $dfco, 3);
            $co2_ = round($co2[$i - 1] - $dfco2, 2);
            $o2_ = round($o2[$i - 1] - $dfo2, 2);
            if ($o2_ > 18 && !$encontradoo2) {
                $encontradoo2 = true;
                $o2v_ = $o2_;
            }
            // cuadre de hc y co mediante los vectores de los ultimo 10 datos
            if ($i > 50) {
                switch ($rhc) {
                    case 1:
                        $hc_ = $ultimosSegundosHC_1[$j_hc] + $hc_;
                        break;
                    case 2:
                        $hc_ = $ultimosSegundosHC_2[$j_hc] + $hc_;
                        break;
                    case 3:
                        $hc_ = $ultimosSegundosHC_3[$j_hc] + $hc_;
                        break;
                }
                switch ($rco) {
                    case 1:
                        $co_ = $ultimosSegundosCO_1[$j_hc] + $co_;
                        break;
                    case 2:
                        $co_ = $ultimosSegundosCO_2[$j_hc] + $co_;
                        break;
                    case 3:
                        $co_ = $ultimosSegundosCO_3[$j_hc] + $co_;
                        break;
                }
                //cuadre de rpm
                if ($rpmmod > 0) {
                    $rpm_ = $rpm_ + 10;
                }
                $rpmmod--;
                $j_hc++;
            }
            $arrayRal = [
                "tiempo" => $t,
                "hc" => $hc_,
                "co" => $co_,
                "co2" => $co2_,
                "o2" => $o2_,
                "rpm" => $rpm_
            ];

            array_push($cruceroData, $arrayRal);
        }
        // se cambian los datos negativos por el primer valor positivo del vector
        $promedioHC = 0;
        for ($c = 0; $c < count($cruceroData); $c++) {
            if ($cruceroData[$c]['hc'] < 0) {
                $cruceroData[$c]['hc'] = $cruceroData[$c]['hc'] * -1;
            }
            if ($c >= 50) {
                $promedioHC = $promedioHC + $cruceroData[$c]['hc'];
            }
        }
        if (floatval($rta[0]->hc_crucero) !== floatval($promedioHC / 10)) {
            $cruceroData = $this->promedioCalculo($rta[0]->hc_crucero, $cruceroData, 0.1, 'hc');
        }

        $promedioCO = 0;
        for ($c = 0; $c < count($cruceroData); $c++) {
            if ($cruceroData[$c]['co'] < 0) {
                $cruceroData[$c]['co'] = $cruceroData[$c]['co'] * -1;
            }
            if ($c >= 50) {
                $promedioCO = $promedioCO + $cruceroData[$c]['co'];
            }
        }
        if (floatval($rta[0]->co_crucero) !== floatval($promedioCO / 10)) {
            $cruceroData = $this->promedioCalculo($rta[0]->co_crucero, $cruceroData, 0.0001, 'co');
        }

        $promedioCO2 = 0;
        for ($c = 0; $c < count($cruceroData); $c++) {
            if ($cruceroData[$c]['co2'] < 0) {
                $cruceroData[$c]['co2'] = $cruceroData[$c]['co2'] * -1;
            }
            if ($c >= 50) {
                $promedioCO2 = $promedioCO2 + $cruceroData[$c]['co2'];
            }
        }
        if (floatval($rta[0]->co2_crucero) !== floatval($promedioCO2 / 10)) {
            $cruceroData = $this->promedioCalculo($rta[0]->co2_crucero, $cruceroData, 0.0001, 'co2');
        }

        for ($d = 0; $d < count($cruceroData); $d++) {
            if ($cruceroData[$d]['o2'] > 18) {
                $cruceroData[$d]['o2'] = $o2v_;
            }
            if ($cruceroData[$d]['o2'] < 0) {
                $cruceroData[$d]['o2'] = 0.0;
            }
        }
        return $cruceroData;
    }

    function promedioCalculo($rta, $ralentiData, $resolucion, $tipo)
    {
        do {
            $varPromedioCo_ = 0;
            for ($b = 0; $b < count($ralentiData); $b++) {
                if ($b >= 50) {
                    if ($rta == 0) {
                        $ralentiData[$b][$tipo] = 0;
                    } else {
                        if ($ralentiData[$b][$tipo] - $resolucion > 0) {
                            $ralentiData[$b][$tipo] = round($ralentiData[$b][$tipo] - $resolucion, 4);
                        }
                    }

                    $varPromedioCo_ = $varPromedioCo_ + $ralentiData[$b][$tipo];
                }
            }
            $var_ = $varPromedioCo_ / 10;
        } while ($rta < $var_);

        //        echo "rta:" . $rta . "<br>";
        //        echo "promedio: " . round($var_,3) . "<br>";

        if (floatval($rta) !== floatval($var_)) {
            for ($b = 0; $b < count($ralentiData); $b++) {
                if ($b >= 50) {
                    $ralentiData[$b][$tipo] = floatval($rta);
                }
            }
        }
        for ($b = 0; $b < count($ralentiData); $b++) {
            if ($b >= 50) {
                if ($tipo == "hc") {
                    $ralentiData[$b][$tipo] = round($ralentiData[$b][$tipo]);
                }
                if ($tipo == "co") {
                    $ralentiData[$b][$tipo] = round($ralentiData[$b][$tipo], 3);
                }
                if ($tipo == "co2") {
                    $ralentiData[$b][$tipo] = round($ralentiData[$b][$tipo], 2);
                }
            }
        }
        return $ralentiData;
    }

    public function time()
    {
        echo "password: ", random_int(100, 99999);
        //        $seconds = 1000;
        //        $r = $this->contador($seconds);
        //        if($r == 1){
        //            echo "password: ", random_int(100, 99999);
        //            $this->contador($seconds);
        //        }
    }

    public function contador($seconds)
    {
        while (0 == $seconds) {
            echo 'si';
        }
        return 1;
    }

    function enviarEmail()
    {

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.googlemail.com',
            'smtp_port' => '465',
            'smtp_user' => 'sistemas.tecmmas2@gmail.com',
            'smtp_pass' => 'uuzrdxmmekkymdcv',
            'mailtype' => 'html',
            'smtp_crypto' => 'ssl',
            'newline' => "\r\n",
            'useragent' => 'Tecmmas',
            'smtp_timeout' => '5',
            'wordwrap' => TRUE,
            'charset' => 'utf-8'
        );
        //        $data = $this->load->view('Viewemail/emailregistro','', TRUE);
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('sistemas.tecmmas2@gmail.com', '$this->nombreCDA', '$this->emailCDA');
        $this->email->subject('$this->asuntoEmailCDA' . "Formato de prerevision " . '$placa');
        //        $this->email->attach($url);
        $this->email->message('$this->vistaEmailCDA');
        $this->email->to('sistemas.tecmmas2@gmail.com');
        $this->email->print_debugger();

        if ($this->email->send(FALSE)) {
            //            return 1;
            echo "enviado<br/>";
            echo $this->email->print_debugger(array('headers'));
        } else {
            //            return 0;
            echo "fallo <br/>";
            echo "error: " . $this->email->print_debugger(array('headers'));
        }
    }

    function imageNot()
    {
        $data = $this->Mambientales->imageNot();
        $this->getSicov($data);
    }

    function getSicov($data)
    {
        $i = $this->Mambientales->getSicov();
        $array = [];
        foreach ($data as $m) {
            foreach ($i as $v) {
                if ($v->idelemento == $m->numero_placa) {
                    $rta = json_decode($v->cadena);
                    foreach ($rta as $d) {
                        if ($v->idelemento == $d->p_3_plac) {
                            $datos = explode(";", $d->p_foto);
                            for ($index = 0; $index < 2; $index++) {
                                $num = (int) $m->idprueba + 1;
                                $image = str_replace('\ ', '', $datos[$index]);
                                if ($index == 0) {
                                    $a = "insert into imagenes values(null," . $m->idprueba . ", 'data:image/jpeg;base64," . $image . "');";
                                } else {
                                    $a = "insert into imagenes values(null," . $num . ", 'data:image/jpeg;base64," . $image . "');";
                                }
                                array_push($array, $a);
                            }
                            //                        array_push($array, $datos);
                        }
                    }
                }
            }
        }

        $directorio = 'C:/Informes_Ambientales/';

        // Verificar y crear el directorio si no existe
        if (!file_exists($directorio)) {
            if (!mkdir($directorio, 0777, true)) {
                die('Error: No se pudo crear el directorio ' . $directorio);
            }
        }

        $archivo = $directorio . 'imagenes.sql';
        $reporte = fopen($archivo, 'w+b');

        if (!$reporte) {
            die('Error: No se pudo crear/abrir el archivo ' . $archivo);
        }

        for ($r = 0; $r < count($array); $r++) {
            echo '<br>';
            echo $array[$r];
            echo '</br>';
            fwrite($reporte, $array[$r]);
        }

        fclose($reporte);
        // $reporte = fopen('C:/Informes_Ambientales/imagenes.sql', 'w+b');
        // for ($r = 0; $r < count($array); $r++) {
        //     //        for ($r = 0; $r < 3; $r++) {
        //     echo '<br>';
        //     echo $array[$r];
        //     echo '</br>';
        //     fwrite($reporte, $array[$r]);
        // }
        // fclose($reporte);

        //        $result = implode(" ", $array);
        //        $reporte = fopen('C:/Informes_Ambientales/imagenes.txt', 'w+b');
        //        fwrite($reporte, $result);
        //        fclose($reporte);
    }

    function getPruebasGases()
    {
        $idhojapruebas = $this->input->post('idhojapruebas');
        $rta1 = [];
        $rta1 = $this->Mambientales->getPrueba($idhojapruebas);
        if (count($rta1) > 0) {
            echo json_encode($rta1);
        }
    }


    function envioinformeBogota()
    {

        $idconf_maquina =  $this->input->post('idmaquina');
        $token = $this->input->post('token');
        $idprueba = $this->input->post('idprueba');
        $tipo_vehiculo = (int) $this->input->post('tipo_vehiculo');
        $tipoCombustible = (int) $this->input->post('idtipocombustible');

        if ($tipo_vehiculo == 3) {
            $query = $this->Mambientales->informe_bogota_MotosWeb($idconf_maquina, $idprueba);
            $res = $this->getInformacionAtalaya($query, $idconf_maquina, 0);
            // } else if ($tipo_vehiculo == '1' || $tipo_vehiculo == '2') {
        } else if (($tipo_vehiculo == 1 || $tipo_vehiculo == 2) && $tipoCombustible !== 1) {
            // echo 'entre por gasolina: '. $tipo_vehiculo . ' - ' . $tipoCombustible;
            $query = $this->Mambientales->informe_bogota_GasolinaWeb($idconf_maquina, $idprueba);
            $res = $this->getInformacionAtalaya($query, $idconf_maquina, 0);
        } else if (($tipo_vehiculo == 1 || $tipo_vehiculo == 2) && $tipoCombustible == 1) {
            // echo 'entre por diesel';
            $query = $this->Mambientales->informe_bogota_DieselWeb($idconf_maquina, $idprueba);
            // var_dump($query);
            $res = $this->getInformacionAtalaya($query, $idconf_maquina, 0);
        }


        // Convertir el resultado a JSON
        $json_data = json_encode($res);

        $payload = [
            'data' => $json_data
        ];

        // var_dump($payload);


        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://dev-api-gateway.ambientebogota.gov.co/api-gateway/public/gestionarVehiculo');
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        // curl_setopt($ch, CURLOPT_HTTPHEADER, [
        //     'Authorization: Bearer ' . $token,
        //     'Content-Type: application/x-www-form-urlencoded',
        // ]);

        // curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

        // // Desactivar verificación SSL (solo para desarrollo)
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // // Ejecutar la petición
        // $response = curl_exec($ch);

        // // Obtener información de la respuesta
        // $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        // // Manejar errores de cURL
        // if (curl_errno($ch)) {
        //     $error_msg = curl_error($ch);
        //     curl_close($ch);
        //     echo json_encode(['error' => 'cURL Error: ' . $error_msg]);
        //     return;
        // }

        // // Cerrar cURL
        // curl_close($ch);

        // // Verificar si la respuesta está vacía
        // if (empty($response)) {
        //     echo json_encode([
        //         'error' => 'Empty response from API',
        //         'http_code' => $http_code
        //     ]);
        //     return;
        // }

        // // Verificar código HTTP
        // if ($http_code >= 400) {
        //     echo json_encode([
        //         'error' => 'HTTP Error: ' . $http_code,
        //         'response' => $response
        //     ]);
        //     return;
        // }

        // // Decodificar respuesta
        // $response_data = json_decode($response, true);

        // // Verificar si JSON es válido
        // if (json_last_error() !== JSON_ERROR_NONE) {
        //     echo json_encode([
        //         'error' => 'Invalid JSON response: ' . json_last_error_msg(),
        //         'raw_response' => $response
        //     ]);
        //     return;
        // }

        // // Verificar si la respuesta es null
        // if ($response_data === null) {
        //     echo json_encode([
        //         'error' => 'API returned null response',
        //         'http_code' => $http_code,
        //         'raw_response' => $response
        //     ]);
        //     return;
        // }

        // // Éxito
        // echo json_encode($response_data);



        $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://dev-api-gateway.ambientebogota.gov.co/api-gateway/public/gestionarVehiculo');
        curl_setopt($ch, CURLOPT_URL, 'https://dev-api-gateway.ambientebogota.gov.co/api-cdas/public/api/gestionarVehiculo');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload)); // Usa http_build_query
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/x-www-form-urlencoded', // Cambia a este content-type
        ]);

        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

        // Desactivar verificación SSL (solo para desarrollo)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // Ejecutar la petición
        $response = curl_exec($ch);

        // Manejar errores
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            echo json_encode(['errordata' => $error_msg]);
            return;
        }

        // Cerrar cURL
        curl_close($ch);

        // Decodificar respuesta
        $response_data = json_decode($response, true);

        echo json_encode($response_data);
    }

    function saveInfoEnvioBogota()
    {
        echo json_encode($this->Mambientales->saveInfoEnvioBogota($this->input->post('placa'), $this->input->post('idmaquina'), $this->input->post('idprueba'), $this->input->post('mensaje'), $this->input->post('estado')));
    }

    function updateInfoEnvioBogota()
    {
        echo json_encode($this->Mambientales->updateInfoEnvioBogota($this->input->post('idcontrolenvioapi'), $this->input->post('mensaje'), $this->input->post('estado')));
    }



    function getInformeCornareWeb()
    {
        $informeCornare = "";
        $idmaquina = $this->input->post('idmaquina');
        $idprueba = $this->input->post('idprueba');
        $tipo_vehiculo = $this->input->post('tipo_vehiculo');
        $tipoCombustible = $this->input->post('tipoCombustible');
        $rta = $this->Mambientales->getEnvioCornare($idprueba);
        if (!$rta->num_rows() > 0) {
            if ($tipo_vehiculo !== '3' && ($tipoCombustible == '2' || $tipoCombustible == '4' || $tipoCombustible == '3')) {
                $informe = $this->Mambientales->ntc4983($idmaquina, $idprueba);
            } elseif ($tipo_vehiculo !== '3' && $tipoCombustible == '1') {
                $informe = $this->Mambientales->ntc4231($idmaquina, $idprueba);
            } else {
                $informe = $this->Mambientales->ntc5365($idmaquina, $idprueba);
                $informe = str_replace(".", ",", $informe);
            }
            $download = 0;
            $informeCornare = $this->getInformacionAtalaya($informe, $idmaquina, $download);
        }
        echo json_encode($informeCornare);
    }

    function insertControl()
    {
        $idprueba = $this->input->post('idprueba');
        $this->Mambientales->insertControl($idprueba, $this->session->userdata("IdUsuario"));
    }

    public function exporExcelCorantioquia($datosGenerales, $registros)
    {
        $vectorMotos = [];
        $vectorLivianos = [];
        $vectorDiesel = [];
        foreach ($registros as $r) {
            if (isset($r['livianos'])) {
                array_push($vectorLivianos, $r);
            } elseif (isset($r['motos'])) {
                array_push($vectorMotos, $r);
            } elseif (isset($r['diesel'])) {
                array_push($vectorDiesel, $r);
            }
        }

        date_default_timezone_set('America/bogota');
        $rta['cda'] = $this->infocda();
        $nombreCda = $rta['cda']->nombre_cda;
        $date = date("MY");
        $nombrecsv = 'Reporte Informacion_' . $nombreCda . '_' . $date . '.csv';

        //$nombrecsv = "prueba";


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Transfer-Encoding: binary; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $nombrecsv . '.xlsx');

        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->mergeCells('A2:H2')->setCellValue('A2', 'INFORMACIÓN A REPORTAR POR LOS CENTROS DE DIAGNÓSTICO AUTOMOTOR - CDA s')->getStyle('A2:h2')->getAlignment()->setHorizontal('center');
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->mergeCells('A4:H4')->setCellValue('A4', 'DATOS GENERALES')->getStyle('A4:h4')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A5', 'Nombre o razon social:');
        $spreadsheet->getActiveSheet()->mergeCells('B5:H5')->setCellValue('B5', $datosGenerales[0]->Nombre_o_razon_social)->getStyle('B5:H5')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A6', 'Tipo de documento:');
        if ($datosGenerales[0]->TipoDocumento == 'C.C.') {
            $activeWorksheet->setCellValue('B6', 'CC    X');
        } else {
            $activeWorksheet->setCellValue('B6', 'CC');
        }
        if ($datosGenerales[0]->TipoDocumento == 'C.E.') {
            $activeWorksheet->setCellValue('C6', 'CE    X');
        } else {
            $activeWorksheet->setCellValue('C6', 'CE');
        }
        if ($datosGenerales[0]->TipoDocumento == 'NIT.') {
            $activeWorksheet->setCellValue('D6', 'NIT   X');
        } else {
            $activeWorksheet->setCellValue('D6', 'NIT');
        }
        $spreadsheet->getActiveSheet()->mergeCells('E6:H6');
        $activeWorksheet->setCellValue('A7', 'Numero de identificacion:');
        $spreadsheet->getActiveSheet()->mergeCells('B7:H7')->setCellValue('B7', $datosGenerales[0]->NumeroIdentificacion)->getStyle('B7:H7')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A8', 'Persona de contacto:');
        $spreadsheet->getActiveSheet()->mergeCells('B8:H8')->setCellValue('B8', $datosGenerales[0]->PersonaContacto)->getStyle('B8:H8')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A9', 'Correo electronico:');
        $spreadsheet->getActiveSheet()->mergeCells('B9:H9')->setCellValue('B9', $datosGenerales[0]->CorreoElectronico)->getStyle('B9:H9')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A10', 'Telefonos de contacto:');
        $spreadsheet->getActiveSheet()->mergeCells('B10:H10')->setCellValue('B10', $datosGenerales[0]->TelefonoContacto)->getStyle('B10:H10')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A11', 'Ciudad:');
        $spreadsheet->getActiveSheet()->mergeCells('B11:C11')->setCellValue('B11', $datosGenerales[0]->Ciudad)->getStyle('B11:C11')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('D11', 'Departamento:');
        $spreadsheet->getActiveSheet()->mergeCells('E11:H11')->setCellValue('E11', $datosGenerales[0]->Departamento)->getStyle('E11:H11')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A12', 'N° Resolución Certificación:');
        $spreadsheet->getActiveSheet()->mergeCells('B12:H12')->setCellValue('B12', $datosGenerales[0]->ResolucionCertificacion)->getStyle('B12:H12')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A13', 'Fecha Resolución (dd/mm/aaaa):');
        $spreadsheet->getActiveSheet()->mergeCells('B13:H13')->setCellValue('B13', $datosGenerales[0]->FechaResolucion)->getStyle('B13:H13')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A14', 'Clase de CDA:');
        $spreadsheet->getActiveSheet()->mergeCells('B14:H14')->setCellValue('B14', $datosGenerales[0]->ClaseCDA)->getStyle('B14:H14')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A15', 'N° Expediente:');
        $spreadsheet->getActiveSheet()->mergeCells('B15:H15')->setCellValue('B15', $datosGenerales[0]->Numero_expe)->getStyle('B15:H15')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A16', 'N° total equipos certificados:');
        $spreadsheet->getActiveSheet()->mergeCells('B16:H16')->setCellValue('B16', $datosGenerales[0]->Numero_total_equipos_certificados)->getStyle('B16:H16')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A17', 'N° total opacímetros:');
        $spreadsheet->getActiveSheet()->mergeCells('B17:H17')->setCellValue('B17', $datosGenerales[0]->Numero_total_opacimetros)->getStyle('B17:H17')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A18', 'N° total analizadores (otto y motos):');
        $spreadsheet->getActiveSheet()->mergeCells('B18:H18')->setCellValue('B18', $datosGenerales[0]->Numero_total_analizadores)->getStyle('B18:H18')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A19', 'N° total analizadores 2T:');
        $spreadsheet->getActiveSheet()->mergeCells('B19:H19')->setCellValue('B19', $datosGenerales[0]->Numero_total_analizadores_2t)->getStyle('B19:H19')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A20', 'N° totoal analizadores 4T:');
        $spreadsheet->getActiveSheet()->mergeCells('B20:H20')->setCellValue('B20', $datosGenerales[0]->Numero_total_analizadores_4t)->getStyle('B20:H20')->getAlignment()->setHorizontal('center');
        $dominio = file_get_contents('system/dominio.dat', true);
        if ($dominio == 'cdafrontino.tecmmas.com') {
            $activeWorksheet->setCellValue('A22', '');
        } else {
            $activeWorksheet->setCellValue('A22', 'Corantioquia está comprometida con el tratamiento legal, lícito, confidencial y seguro de sus datos personales.<br> Por favor consulte nuestra Política de Tratamiento de datos personales en nuestra página web: www.corantioquia.gov.co');
        }
        $activeWorksheet->setTitle('Datos generales');


        // // //Hoja 2
        $hoja2 = $spreadsheet->createSheet();
        $hoja2->mergeCells('A1:L1')->setCellValue('A1', 'DATOS DE LA PRUEBA')->getStyle('A1:L1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('A1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFDCE6F1');
        $hoja2->getStyle('A2:L2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFB8CCE4');

        $hoja2->mergeCells('M1:W1')->setCellValue('M1', 'DATOS DEL VEHICULO')->getStyle('M1:W1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('M1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFF2F2F2');
        $hoja2->getStyle('M2:W2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFD8D8D8');

        $hoja2->mergeCells('X1:AP1')->setCellValue('X1', 'DATOS DEL EQUIPO ANALIZADOR')->getStyle('X1:AP1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('X1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFEBF1DE');
        $hoja2->getStyle('X2:AP2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFD8E4BC');


        $hoja2->mergeCells('AQ1:AX1')->setCellValue('AQ1', 'RESULTADOS DE LA PRUEBA')->getStyle('AQ1:AX1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('AQ1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFDE9D9');
        $hoja2->getStyle('AQ2:AX2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFCD5B4');

        $hoja2->mergeCells('AY1:BE1')->setCellValue('AY1', 'CONDICIONES DE RECHAZO')->getStyle('AY1:BE1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('AY1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFFCC');
        $hoja2->getStyle('AY2:BE2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF99');
        $hoja2->setTitle('Motos');
        $i = 2;
        $m = 0;
        $incrementGlobal = 3;
        $letras = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ'];
        foreach ($vectorMotos as $mot) {
            foreach ($mot as  $mo) {
                foreach ($mo as $d) {
                    $keys = array_keys((array)$d);
                    while ($m < count($keys)) {
                        $hoja2->setCellValue($letras[$m] . $i, $keys[$m]);
                        $val = strval($keys[$m]);
                        $hoja2->setCellValue($letras[$m] . $incrementGlobal, $d->$val);
                        // $val = strval($keys[$m]);
                        // $hoja2->setCellValue($letras[$m] . $incrementGlobal, $d->$val);
                        // echo 'm' . $m . '-------';
                        // echo 'key' . count($keys) . '<br>';
                        // echo 'incrementGlobal' . $incrementGlobal . '<br>';
                        // echo 'encabezado   ' . $keys[$m]  . '-----';
                        // $val = strval($keys[$m]);
                        // echo 'valor' . $d->$val . '<br>';
                        $m++;
                    }
                    if ($m >= count($keys)) {
                        $m = 0;
                        $incrementGlobal++;
                    }
                }
            }
        }
        //Hoja 3
        $hoja3 = $spreadsheet->createSheet();
        $hoja3->mergeCells('A1:L1')->setCellValue('A1', 'DATOS DE LA PRUEBA')->getStyle('A1:L1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('A1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFDCE6F1');
        $hoja3->getStyle('A2:L2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFB8CCE4');

        $hoja3->mergeCells('M1:U1')->setCellValue('M1', 'DATOS DEL VEHICULO')->getStyle('M1:U1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('M1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFF2F2F2');
        $hoja3->getStyle('M2:U2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFD8D8D8');


        $hoja3->mergeCells('V1:AN1')->setCellValue('V1', 'DATOS DEL EQUIPO ANALIZADOR')->getStyle('V1:AN1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('V1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFEBF1DE');
        $hoja3->getStyle('V2:AN2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFD8E4BC');


        $hoja3->mergeCells('AO1:BA1')->setCellValue('AO1', 'RESULTADOS DE LA PRUEBA')->getStyle('AO1:BA1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('AO1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFDE9D9');
        $hoja3->getStyle('AO2:BA2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFCD5B4');


        $hoja3->mergeCells('BB1:BL1')->setCellValue('BB1', 'CONDICIONES DE RECHAZO')->getStyle('BB1:BL1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('BB1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFFCC');
        $hoja3->getStyle('BB2:BL2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF99');


        $hoja3->setTitle('Ciclo otto');
        $ii = 2;
        $mm = 0;
        $incrementGlobalL = 3;
        foreach ($vectorLivianos as $mot) {
            foreach ($mot as  $mo) {
                foreach ($mo as $d) {
                    $keys = array_keys((array)$d);
                    while ($mm < count($keys)) {
                        $hoja3->setCellValue($letras[$mm] . $ii, $keys[$mm]);
                        $val = strval($keys[$mm]);
                        $hoja3->setCellValue($letras[$mm] . $incrementGlobalL, $d->$val);
                        $mm++;
                    }
                    if ($mm >= count($keys)) {
                        $mm = 0;
                        $incrementGlobalL++;
                    }
                }
            }
        }
        //Hoja 4
        $hoja4 = $spreadsheet->createSheet();
        $hoja4->mergeCells('A1:L1')->setCellValue('A1', 'DATOS DE LA PRUEBA')->getStyle('A1:L1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('A1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFDCE6F1');
        $hoja4->getStyle('A2:L2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFB8CCE4');


        $hoja4->mergeCells('M1:W1')->setCellValue('M1', 'DATOS DEL VEHICULO')->getStyle('M1:W1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('M1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFF2F2F2');
        $hoja4->getStyle('M2:W2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFD8D8D8');

        $hoja4->mergeCells('X1:AH1')->setCellValue('X1', 'DATOS DEL MEDIDOR DE HUMOS')->getStyle('X1:AH1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('X1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFEBF1DE');
        $hoja4->getStyle('X2:AH2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFD8E4BC');


        $hoja4->mergeCells('AI1:AW1')->setCellValue('AI1', 'RESULTADOS DE LA PRUEBA')->getStyle('AI1:AW1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('AI1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFDE9D9');
        $hoja4->getStyle('AI2:AW2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFCD5B4');
        // $hoja4->mergeCells('AY1:BE1')->setCellValue('AY1', 'CONDICIONES DE RECHAZO')->getStyle('AY1:BE1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('AY1')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFF9E79F');
        $hoja4->setTitle('Ciclo Diesel');
        $iii = 2;
        $mmm = 0;
        $incrementGlobalD = 3;
        foreach ($vectorDiesel as $mot) {
            foreach ($mot as  $mo) {
                foreach ($mo as $d) {
                    $keys = array_keys((array)$d);
                    while ($mmm < count($keys)) {
                        $hoja4->setCellValue($letras[$mmm] . $iii, $keys[$mmm]);
                        $val = strval($keys[$mmm]);
                        $hoja4->setCellValue($letras[$mmm] . $incrementGlobalD, $d->$val);
                        $mmm++;
                    }
                    if ($mmm >= count($keys)) {
                        $mmm = 0;
                        $incrementGlobalD++;
                    }
                }
            }
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
    public function exporExcelCorpocesar($datosGenerales, $registros)
    {
        $vectorMotos = [];
        $vectorLivianos = [];
        $vectorDiesel = [];
        foreach ($registros as $r) {
            if (isset($r['livianos'])) {
                array_push($vectorLivianos, $r);
            } elseif (isset($r['motos'])) {
                array_push($vectorMotos, $r);
            } elseif (isset($r['diesel'])) {
                array_push($vectorDiesel, $r);
            }
        }

        date_default_timezone_set('America/bogota');
        $rta['cda'] = $this->infocda();
        $nombreCda = $rta['cda']->nombre_cda;
        $date = date("MY");
        $nombrecsv = 'Reporte Informacion_' . $nombreCda . '_' . $date . '.csv';

        //$nombrecsv = "prueba";


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Transfer-Encoding: binary; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $nombrecsv . '.xlsx');

        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->mergeCells('A2:H2')->setCellValue('A2', 'INFORMACIÓN A REPORTAR POR CENTROS DE DIAGNÓSTICO AUTOMOTOR A LAS AUTORIDADES AMBIENTALES')->getStyle('A2:h2')->getAlignment()->setHorizontal('center');
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->mergeCells('A4:H4')->setCellValue('A4', 'DATOS GENERALES')->getStyle('A4:h4')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A5', 'Nombre o razon social:');
        $spreadsheet->getActiveSheet()->mergeCells('B5:H5')->setCellValue('B5', $datosGenerales[0]->Nombre_o_razon_social)->getStyle('B5:H5')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A6', 'Tipo de documento:');
        if ($datosGenerales[0]->TipoDocumento == 'C.C.') {
            $activeWorksheet->setCellValue('B6', 'CC    X');
        } else {
            $activeWorksheet->setCellValue('B6', 'CC');
        }
        if ($datosGenerales[0]->TipoDocumento == 'C.E.') {
            $activeWorksheet->setCellValue('C6', 'CE    X');
        } else {
            $activeWorksheet->setCellValue('C6', 'CE');
        }
        if ($datosGenerales[0]->TipoDocumento == 'NIT.') {
            $activeWorksheet->setCellValue('D6', 'NIT   X');
        } else {
            $activeWorksheet->setCellValue('D6', 'NIT');
        }
        $spreadsheet->getActiveSheet()->mergeCells('E6:H6');
        $activeWorksheet->setCellValue('A7', 'Numero de identificacion:');
        $spreadsheet->getActiveSheet()->mergeCells('B7:H7')->setCellValue('B7', $datosGenerales[0]->NumeroIdentificacion)->getStyle('B7:H7')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A8', 'Persona de contacto:');
        $spreadsheet->getActiveSheet()->mergeCells('B8:H8')->setCellValue('B8', $datosGenerales[0]->PersonaContacto)->getStyle('B8:H8')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A9', 'Correo electronico:');
        $spreadsheet->getActiveSheet()->mergeCells('B9:H9')->setCellValue('B9', $datosGenerales[0]->CorreoElectronico)->getStyle('B9:H9')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A10', 'Telefonos de contacto:');
        $spreadsheet->getActiveSheet()->mergeCells('B10:H10')->setCellValue('B10', $datosGenerales[0]->TelefonoContacto)->getStyle('B10:H10')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A11', 'Ciudad:');
        $spreadsheet->getActiveSheet()->mergeCells('B11:C11')->setCellValue('B11', $datosGenerales[0]->Ciudad)->getStyle('B11:C11')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('D11', 'Departamento:');
        $spreadsheet->getActiveSheet()->mergeCells('E11:H11')->setCellValue('E11', $datosGenerales[0]->Departamento)->getStyle('E11:H11')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A12', 'N° Resolución Certificación:');
        $spreadsheet->getActiveSheet()->mergeCells('B12:H12')->setCellValue('B12', $datosGenerales[0]->ResolucionCertificacion)->getStyle('B12:H12')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A13', 'Fecha Resolución (dd/mm/aaaa):');
        $spreadsheet->getActiveSheet()->mergeCells('B13:H13')->setCellValue('B13', $datosGenerales[0]->FechaResolucion)->getStyle('B13:H13')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A14', 'Clase de CDA:');
        $spreadsheet->getActiveSheet()->mergeCells('B14:H14')->setCellValue('B14', $datosGenerales[0]->ClaseCDA)->getStyle('B14:H14')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A15', 'N° Expediente:');
        $spreadsheet->getActiveSheet()->mergeCells('B15:H15')->setCellValue('B15', $datosGenerales[0]->Numero_expe)->getStyle('B15:H15')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A16', 'N° total equipos certificados:');
        $spreadsheet->getActiveSheet()->mergeCells('B16:H16')->setCellValue('B16', $datosGenerales[0]->Numero_total_equipos_certificados)->getStyle('B16:H16')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A17', 'N° total opacímetros:');
        $spreadsheet->getActiveSheet()->mergeCells('B17:H17')->setCellValue('B17', $datosGenerales[0]->Numero_total_opacimetros)->getStyle('B17:H17')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A18', 'N° total analizadores (otto y motos):');
        $spreadsheet->getActiveSheet()->mergeCells('B18:H18')->setCellValue('B18', $datosGenerales[0]->Numero_total_analizadores)->getStyle('B18:H18')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A19', 'N° total analizadores 2T:');
        $spreadsheet->getActiveSheet()->mergeCells('B19:H19')->setCellValue('B19', $datosGenerales[0]->Numero_total_analizadores_2t)->getStyle('B19:H19')->getAlignment()->setHorizontal('center');
        $activeWorksheet->setCellValue('A20', 'N° totoal analizadores 4T:');
        $spreadsheet->getActiveSheet()->mergeCells('B20:H20')->setCellValue('B20', $datosGenerales[0]->Numero_total_analizadores_4t)->getStyle('B20:H20')->getAlignment()->setHorizontal('center');
        //$activeWorksheet->setCellValue('A22', 'Corantioquia está comprometida con el tratamiento legal, lícito, confidencial y seguro de sus datos personales.<br> Por favor consulte nuestra Política de Tratamiento de datos personales en nuestra página web: www.corantioquia.gov.co');
        $activeWorksheet->setTitle('Datos generales');


        // // //Hoja 2
        $hoja2 = $spreadsheet->createSheet();
        $hoja2->mergeCells('A1:J1')->setCellValue('A1', 'DATOS DE INICIO DE LA PRUEBA')->getStyle('A1:J1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('A1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF90F228');
        $hoja2->getStyle('A2:J2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF90F228');

        $hoja2->mergeCells('K1:T1')->setCellValue('K1', 'DATOS DEL VEHÍCULO INSPECCIONADO')->getStyle('K1:T1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('K1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF28C7F2');
        $hoja2->getStyle('K2:T2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF28C7F2');

        $hoja2->mergeCells('U1:AD1')->setCellValue('U1', 'RESULTADOS DE INSPECCIÓN')->getStyle('U1:AD1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('U1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF285CF2');
        $hoja2->getStyle('U2:AD2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF285CF2');


        $hoja2->mergeCells('AE1:AU1')->setCellValue('AE1', 'DATOS DEL EQUIPO ANALIZADOR')->getStyle('AE1:AU1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('AE1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFF0F34D');
        $hoja2->getStyle('AE2:AU2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFF0F34D');

        $hoja2->mergeCells('AV1:BY1')->setCellValue('AV1', 'CONDICIONES DE RECHAZO')->getStyle('AV1:BY1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('AV1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFFCC');
        $hoja2->getStyle('AV2:BY2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFFCC');

        $hoja2->mergeCells('BZ1:CD1')->setCellValue('BZ1', 'CONDICIONES DE ABORTO DE LA PRUEBA')->getStyle('BZ1:CD1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('BZ1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFF90C0C');
        $hoja2->getStyle('BZ2:CD2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFF90C0C');

        $hoja2->mergeCells('CE1:CE1')->setCellValue('CE1', 'RUIDO')->getStyle('CE1:CE1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('CE1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF0CF93E');
        $hoja2->getStyle('CE2:CE2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF0CF93E');

        $hoja2->mergeCells('CF1:CF1')->setCellValue('CF1', 'NORMA DE EMISIÓN APLICADA')->getStyle('CF1:CF1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('CF1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF0C3EF9');
        $hoja2->getStyle('CF2:CF2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF0C3EF9');

        $hoja2->setTitle('Motos');
        $i = 2;
        $m = 0;
        $incrementGlobal = 3;
        $letras = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ', 'CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ'];
        foreach ($vectorMotos as $mot) {
            foreach ($mot as  $mo) {
                foreach ($mo as $d) {
                    $keys = array_keys((array)$d);
                    while ($m < count($keys)) {
                        $hoja2->setCellValue($letras[$m] . $i, $keys[$m]);
                        $val = strval($keys[$m]);
                        $hoja2->setCellValue($letras[$m] . $incrementGlobal, $d->$val);
                        // $val = strval($keys[$m]);
                        // $hoja2->setCellValue($letras[$m] . $incrementGlobal, $d->$val);
                        // echo 'm' . $m . '-------';
                        // echo 'key' . count($keys) . '<br>';
                        // echo 'incrementGlobal' . $incrementGlobal . '<br>';
                        // echo 'encabezado   ' . $keys[$m]  . '-----';
                        // $val = strval($keys[$m]);
                        // echo 'valor' . $d->$val . '<br>';
                        $m++;
                    }
                    if ($m >= count($keys)) {
                        $m = 0;
                        $incrementGlobal++;
                    }
                }
            }
        }
        //Hoja 3
        $hoja3 = $spreadsheet->createSheet();
        $hoja3->mergeCells('A1:K1')->setCellValue('A1', 'DATOS DE INICIO DE LA PRUEBA')->getStyle('A1:K1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('A1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF90F228');
        $hoja3->getStyle('A2:K2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF90F228');

        $hoja3->mergeCells('L1:V1')->setCellValue('L1', 'DATOS DEL VEHÍCULO INSPECCIONADO')->getStyle('L1:V1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('L1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF28C7F2');
        $hoja3->getStyle('L2:V2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF28C7F2');

        $hoja3->mergeCells('W1:AL1')->setCellValue('W1', 'RESULTADOS DE INSPECCIÓN')->getStyle('W1:AL1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('W1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF285CF2');
        $hoja3->getStyle('W2:AL2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF285CF2');


        $hoja3->mergeCells('AM1:BE1')->setCellValue('AM1', 'DATOS DEL EQUIPO ANALIZADOR')->getStyle('AM1:BE1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('AM1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFF0F34D');
        $hoja3->getStyle('AM2:BE2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFF0F34D');

        $hoja3->mergeCells('BF1:CI1')->setCellValue('BF1', 'CONDICIONES DE RECHAZO')->getStyle('BF1:CI1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('BF1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFFCC');
        $hoja3->getStyle('BF2:CI2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFFCC');

        $hoja3->mergeCells('CJ1:CN1')->setCellValue('CJ1', 'CONDICIONES DE ABORTO DE LA PRUEBA')->getStyle('CJ1:CN1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('CJ1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFF90C0C');
        $hoja3->getStyle('CJ2:CN2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFF90C0C');

        $hoja3->mergeCells('CO1:CO1')->setCellValue('CO1', 'RUIDO')->getStyle('CO1:CO1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('CO1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF0CF93E');
        $hoja3->getStyle('CO2:CO2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF0CF93E');

        $hoja3->mergeCells('CP1:CP1')->setCellValue('CP1', 'NORMA DE EMISIÓN APLICADA')->getStyle('CP1:CP1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('CP1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF0C3EF9');
        $hoja3->getStyle('CP2:CP2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF0C3EF9');

        // $hoja3->mergeCells('A1:L1')->setCellValue('A1', 'DATOS DE LA PRUEBA')->getStyle('A1:L1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('A1')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFDCE6F1');
        // $hoja3->getStyle('A2:L2')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFB8CCE4');

        // $hoja3->mergeCells('M1:U1')->setCellValue('M1', 'DATOS DEL VEHICULO')->getStyle('M1:U1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('M1')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFF2F2F2');
        // $hoja3->getStyle('M2:U2')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFD8D8D8');


        // $hoja3->mergeCells('V1:AN1')->setCellValue('V1', 'DATOS DEL EQUIPO ANALIZADOR')->getStyle('V1:AN1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('V1')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFEBF1DE');
        // $hoja3->getStyle('V2:AN2')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFD8E4BC');


        // $hoja3->mergeCells('AO1:BA1')->setCellValue('AO1', 'RESULTADOS DE LA PRUEBA')->getStyle('AO1:BA1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('AO1')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFFDE9D9');
        // $hoja3->getStyle('AO2:BA2')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFFCD5B4');


        // $hoja3->mergeCells('BB1:BL1')->setCellValue('BB1', 'CONDICIONES DE RECHAZO')->getStyle('BB1:BL1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('BB1')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFFFFFCC');
        // $hoja3->getStyle('BB2:BL2')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFFFFF99');


        $hoja3->setTitle('Ciclo otto');
        $ii = 2;
        $mm = 0;
        $incrementGlobalL = 3;
        foreach ($vectorLivianos as $mot) {
            foreach ($mot as  $mo) {
                foreach ($mo as $d) {
                    $keys = array_keys((array)$d);
                    while ($mm < count($keys)) {
                        $hoja3->setCellValue($letras[$mm] . $ii, $keys[$mm]);
                        $val = strval($keys[$mm]);
                        $hoja3->setCellValue($letras[$mm] . $incrementGlobalL, $d->$val);
                        $mm++;
                    }
                    if ($mm >= count($keys)) {
                        $mm = 0;
                        $incrementGlobalL++;
                    }
                }
            }
        }
        //Hoja 4
        $hoja4 = $spreadsheet->createSheet();
        $hoja4->mergeCells('A1:L1')->setCellValue('A1', 'DATOS DE INICIO DE LA PRUEBA')->getStyle('A1:L1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('A1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF90F228');
        $hoja4->getStyle('A2:L2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF90F228');

        $hoja4->mergeCells('M1:V1')->setCellValue('M1', 'DATOS DEL VEHÍCULO INSPECCIONADO')->getStyle('M1:V1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('M1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF28C7F2');
        $hoja4->getStyle('M2:V2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF28C7F2');

        $hoja4->mergeCells('W1:AV1')->setCellValue('W1', 'RESULTADOS DE INSPECCIÓN')->getStyle('W1:AV1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('W1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF285CF2');
        $hoja4->getStyle('W2:AV2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF285CF2');


        $hoja4->mergeCells('AW1:BD1')->setCellValue('AW1', 'DATOS DEL EQUIPO ANALIZADOR')->getStyle('AW1:BD1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('AW1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFF0F34D');
        $hoja4->getStyle('AW2:BD2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFF0F34D');

        $hoja4->mergeCells('BE1:CH1')->setCellValue('BE1', 'CONDICIONES DE RECHAZO')->getStyle('BE1:CH1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('BE1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFFCC');
        $hoja4->getStyle('BE2:CH2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFFCC');

        $hoja4->mergeCells('CI1:CM1')->setCellValue('CI1', 'CONDICIONES DE ABORTO DE LA PRUEBA')->getStyle('CI1:CM1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('CI1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFF90C0C');
        $hoja4->getStyle('CI2:CM2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFF90C0C');

        $hoja4->mergeCells('CN1:CN1')->setCellValue('CN1', 'RUIDO')->getStyle('CN1:CN1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('CN1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF0CF93E');
        $hoja4->getStyle('CN2:CN2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF0CF93E');

        $hoja4->mergeCells('CO1:CO1')->setCellValue('CO1', 'NORMA DE EMISIÓN APLICADA')->getStyle('CO1:CO1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('CO1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF0C3EF9');
        $hoja4->getStyle('CO2:CO2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF0C3EF9');

        // $hoja4->mergeCells('A1:L1')->setCellValue('A1', 'DATOS DE LA PRUEBA')->getStyle('A1:L1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('A1')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFDCE6F1');
        // $hoja4->getStyle('A2:L2')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFB8CCE4');


        // $hoja4->mergeCells('M1:W1')->setCellValue('M1', 'DATOS DEL VEHICULO')->getStyle('M1:W1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('M1')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFF2F2F2');
        // $hoja4->getStyle('M2:W2')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFD8D8D8');

        // $hoja4->mergeCells('X1:AH1')->setCellValue('X1', 'DATOS DEL MEDIDOR DE HUMOS')->getStyle('X1:AH1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('X1')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFEBF1DE');
        // $hoja4->getStyle('X2:AH2')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFD8E4BC');


        // $hoja4->mergeCells('AI1:AW1')->setCellValue('AI1', 'RESULTADOS DE LA PRUEBA')->getStyle('AI1:AW1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('AI1')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFFDE9D9');
        // $hoja4->getStyle('AI2:AW2')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFFCD5B4');
        // $hoja4->mergeCells('AY1:BE1')->setCellValue('AY1', 'CONDICIONES DE RECHAZO')->getStyle('AY1:BE1')->getAlignment()->setHorizontal('center')->getActiveSheet()->getStyle('AY1')->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFF9E79F');
        $hoja4->setTitle('Ciclo Diesel');
        $iii = 2;
        $mmm = 0;
        $incrementGlobalD = 3;
        foreach ($vectorDiesel as $mot) {
            foreach ($mot as  $mo) {
                foreach ($mo as $d) {
                    $keys = array_keys((array)$d);
                    while ($mmm < count($keys)) {
                        $hoja4->setCellValue($letras[$mmm] . $iii, $keys[$mmm]);
                        $val = strval($keys[$mmm]);
                        $hoja4->setCellValue($letras[$mmm] . $incrementGlobalD, $d->$val);
                        $mmm++;
                    }
                    if ($mmm >= count($keys)) {
                        $mmm = 0;
                        $incrementGlobalD++;
                    }
                }
            }
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function getPendientes()
    {
        echo json_encode($this->Mambientales->getPendientes());
    }
}
