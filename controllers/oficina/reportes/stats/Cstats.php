<?php

defined("BASEPATH") or exit("No direct script access allowed");
header("Access-Control-Allow-Origin: *");
ini_set("memory_limit", "-1");
set_time_limit(300);

class Cstats extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("form");
        $this->load->helper("url");
        $this->load->helper("security");
        $this->load->helper('download');
        $this->load->library('TCPDF');
        $this->load->model("oficina/reportes/stats/Mstats");
        $this->load->library('Opensslencryptdecrypt');
        $this->load->dbforge();
        $this->load->dbutil();
        espejoDatabase();
    }

    var $tipo_informe_fugas_cal_lin = "NA";
    var $horaCierre;
    var $espejoImagenes;

    public function index()
    {
        //        if ($this->session->userdata("IdUsuario") == "" || $this->session->userdata("IdUsuario") == "1024") {
        //            redirect("Cindex");
        //        }
        date_default_timezone_set('America/bogota');
        $this->setConf();
        $data['tipoinforme'] = $this->tipo_informe_fugas_cal_lin;
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $data['maquina'] = json_decode($json);
        $data['fecha'] = date("d-m-Y-H-i-s");
        $data['servicio'] = $this->Mstats->infoservicio();
        $data['clase'] = $this->Mstats->infoclase();
        $data['marca'] = $this->Mstats->infomarca();
        $data['tipov'] = $this->Mstats->infotipovehiculo();
        $data['combustible'] = $this->Mstats->infocombustible();
        $data['usuarios'] = $this->Mstats->infousuarios();
        $this->load->view('oficina/reportes/stats/Vstats', $data);
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
                    if ($d['nombre'] == "tipo_informe_fugas_cal_lin") {
                        $this->tipo_informe_fugas_cal_lin = $d['valor'];
                    }
                    if ($d['nombre'] == "horaCierre") {
                        $this->horaCierre = $d['valor'];
                    }
                    if ($d['nombre'] == "espejoImagenes") {
                        $this->espejoImagenes = $d['valor'];
                    }
                }
            }
        }
    }

    public function infolinea()
    {
        $idlinea = $this->input->post('idmarca');
        $rta = $this->Mstats->infolinea($idlinea);
        echo json_encode($rta);
    }

    public function get_informe_crm()
    {
        $fechainicial = $this->input->post('fechainicial');
        $fechafinal = $this->input->post('fechafinal');
        $tipoinspeccion = $this->input->post('tipoinspeccion');
        $tiposervicio = $this->input->post('tiposervicio');
        $selectmeses = $this->input->post('selectmeses');
        if ($tipoinspeccion == 1) {
            $inspeccion = '(h.reinspeccion = 1 OR h.reinspeccion= 0)';
        } else {
            $inspeccion = '(h.reinspeccion = 4444 OR h.reinspeccion= 44441)';
        }
        switch ($tiposervicio) {
            case 1:
                if ($tipoinspeccion == 1) {
                    $data = $this->Mstats->get_informe_crm($fechainicial, $fechafinal, $inspeccion);
                    $rta = $data->result();
                    echo json_encode($rta);
                } else {
                    $data = $this->Mstats->get_informe_crm_prev($fechainicial, $fechafinal, $inspeccion, $selectmeses);
                    $rta = $data->result();
                    echo json_encode($rta);
                }

                break;
            case 2:
                $servicio = 2;
                $data = $this->Mstats->get_informe_crm_servicio($fechainicial, $fechafinal, $inspeccion, $servicio);
                $rta = $data->result();
                echo json_encode($rta);
                break;
            default:
                $servicio = 3;
                $data = $this->Mstats->get_informe_crm_servicio($fechainicial, $fechafinal, $inspeccion, $servicio);
                $rta = $data->result();
                echo json_encode($rta);
                break;
        }
    }

    function statspruebas()
    {
        $fechainicialp = $this->input->post('fechainicialp');
        $fechafinalp = $this->input->post('fechafinalp');
        $selserviciop = $this->input->post('selserviciop');
        $selclasep = $this->input->post('selclasep');
        $selmarcap = $this->input->post('selmarcap');
        $sellineap = $this->input->post('sellineap');
        $seltipopruebap = $this->input->post('seltipopruebap');
        $selestadopruebasp = $this->input->post('selestadopruebasp');
        $seloperariop = $this->input->post('seloperariop');
        $selestadop = $this->input->post('selestadop');
        $selreinpeccionp = $this->input->post('selreinpeccionp');
        $seltipovehiculop = $this->input->post('seltipovehiculop');
        $selcombustiblep = $this->input->post('selcombustiblep');
        $seltiemposp = $this->input->post('seltiemposp');
        $tipo = $this->input->post('tipo');
        $whereservicio = '';
        $whereclase = '';
        $wheremarca = '';
        $wherelinea = '';
        $wheretipoprueba = '';
        $whereestadopruebas = '';
        $whereoperario = '';
        $whereestadov = '';
        $wherereins = '';
        $wheretipov = '';
        $wherecombustible = '';
        $wheretiempos = '';
        if ($selserviciop !== null) {
            $whereservicio = ' AND v.idservicio = ' . $selserviciop;
        }
        if ($selclasep !== null) {
            $whereclase = ' AND v.idclase = ' . $selclasep;
        }
        if ($selmarcap !== null) {
            $wheremarca = ' AND m.idmarca = ' . $selmarcap;
        }
        if ($sellineap !== null) {
            $wherelinea = ' AND l.idlinea = ' . $sellineap;
        }
        if ($seltipopruebap !== null) {
            $wheretipoprueba = ' AND p.idtipo_prueba = ' . $seltipopruebap;
        }
        if ($selestadopruebasp !== null) {
            $whereestadopruebas = ' AND p.estado = ' . $selestadopruebasp;
        }
        if ($seloperariop !== null) {
            if ($tipo == 2) {
                $whereoperario = ' AND p.idusuario = ' . $seloperariop;
            } else {
                $whereoperario = ' AND h.usuario = ' . $seloperariop;
            }
        }
        if ($selestadop !== null) {
            if ($selestadop == "3") {
                $whereestadov = ' AND (h.estadototal = ' . $selestadop . " OR h.estadototal = 7)";
            } else {
                $whereestadov = ' AND h.estadototal = ' . $selestadop;
            }
        }
        if ($selreinpeccionp !== null) {
            $wherereins = ' AND h.reinspeccion = ' . $selreinpeccionp;
        }
        if ($seltipovehiculop !== null) {
            $wheretipov = ' AND v.tipo_vehiculo = ' . $seltipovehiculop;
        }
        if ($selcombustiblep !== null) {
            $wherecombustible = ' AND v.idtipocombustible = ' . $selcombustiblep;
        }
        if ($seltiemposp !== null) {
            $wheretiempos = ' AND v.tiempos = ' . $seltiemposp;
        }
        $where = $whereservicio . $whereclase . $wheremarca . $wherelinea . $wheretipoprueba . $whereestadopruebas . $whereoperario . $wherereins . $whereestadov . $wheretipov . $wherecombustible . $wheretiempos;
        //        echo json_encode($where);
        if ($tipo == 1) {
            if ($where) {
                $rta = $this->Mstats->statspruebaswhere($where, $fechainicialp, $fechafinalp);
                echo json_encode($rta);
            } else {
                $rta = $this->Mstats->statspruebas($fechainicialp, $fechafinalp);
                echo json_encode($rta);
            }
        } else {
            $rta = $this->Mstats->statsPruebasResultados($where, $fechainicialp, $fechafinalp);
            echo json_encode($rta);
        }
    }

    function getresultados()
    {
        $this->setConf();
        $espejoImagenes = $this->espejoImagenes;
        $idprueba = $this->input->post('idprueba');
        $idtipo_prueba = $this->input->post('idtipo_prueba');
        if ($idtipo_prueba !== '5') {
            $rta = $this->Mstats->getresultados($idprueba);
            echo json_encode($rta);
        } else {
            if ($espejoImagenes == 1) {
                $rta = $this->Mstats->getResultadosImagenes($idprueba, 1);
                echo json_encode($rta);
            } else {
                $rta = $this->Mstats->getResultadosImagenes($idprueba, 0);
                echo json_encode($rta);
            }
        }
    }

    function statscertificados()
    {
        $fechainicialc = $this->input->post('fechainicialc');
        $fechafinalc = $this->input->post('fechafinalc');
        $inputplacac = $this->input->post('inputplacac');
        $selservicioc = $this->input->post('selservicioc');
        $selclasec = $this->input->post('selclasec');
        $selmarcac = $this->input->post('selmarcac');
        $sellineac = $this->input->post('sellineac');
        $selestadoc = $this->input->post('selestadoc');
        $selreinpeccionc = $this->input->post('selreinpeccionc');
        $seltipovehiculoc = $this->input->post('seltipovehiculoc');
        $selcombustiblec = $this->input->post('selcombustiblec');
        $whereplaca = '';
        $whereservicio = '';
        $whereclase = '';
        $wheremarca = '';
        $wherelinea = '';
        $whereestadov = '';
        $wherereins = '';
        $wheretipov = '';
        $wherecombustible = '';
        if (!empty($inputplacac)) {
            $whereplaca = ' AND v.numero_placa = ' . "'" . $inputplacac . "'";
        }
        if ($selservicioc !== null) {
            $whereservicio = ' AND v.idservicio = ' . $selservicioc;
        }
        if ($selclasec !== null) {
            $whereclase = ' AND v.idclase = ' . $selclasec;
        }
        if ($selmarcac !== null) {
            $wheremarca = ' AND m.idmarca = ' . $selmarcac;
        }
        if ($sellineac !== null) {
            $wherelinea = ' AND l.idlinea = ' . $sellineac;
        }
        if ($selestadoc !== null) {
            if ($selestadoc == "3") {
                $whereestadov = ' AND (h.estadototal = ' . $selestadoc . " OR h.estadototal = 7 OR cr.estado = 2)";
            } else {
                $whereestadov = ' AND h.estadototal = ' . $selestadoc;
            }
        }
        if ($selreinpeccionc !== null) {
            $wherereins = ' AND h.reinspeccion = ' . $selreinpeccionc;
        }
        if ($seltipovehiculoc !== null) {
            $wheretipov = ' AND v.tipo_vehiculo = ' . $seltipovehiculoc;
        }
        if ($selcombustiblec !== null) {
            $wherecombustible = ' AND v.idtipocombustible = ' . $selcombustiblec;
        }

        $where = $whereplaca . $whereservicio . $whereclase . $wheremarca . $wherelinea . $wherereins . $whereestadov . $wheretipov . $wherecombustible;


        $rta = $this->Mstats->statscertificadoswhere($where, $fechainicialc, $fechafinalc);
        echo json_encode($rta);
    }

    function logs()
    {
        $rta = $this->Mstats->logs();
        echo json_encode($rta);
    }

    function getresultadoslog()
    {
        $id = $this->input->post('idcontrol_prueba_gases');
        $rta = $this->Mstats->getresultadoslog($id);

        $idmaquina = $rta[0]->idmaquina;
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $data = json_decode($json);

        $ma = $encrptopenssl->decrypt(file_get_contents('system/' . $idmaquina . '.json', true));
        $maquinaData = json_decode(utf8_decode($ma), true);
        foreach ($maquinaData as $m) {
            if ($m['idconf_maquina'] == $idmaquina) {
                if ($m['nombre'] == "nombreMarca") {
                    $rta['marca'] = strtoupper($m['valor']);
                }
            }
            if ($m['idconf_maquina'] == $idmaquina) {
                if ($m['nombre'] == "marcasoft") {
                    $rta['marcasoft'] = strtoupper($m['valor']);
                }
            }
            if ($m['idconf_maquina'] == $idmaquina) {
                if ($m['nombre'] == "versionsoft") {
                    $rta['versionsoft'] = strtoupper($m['valor']);
                }
            }
        }
        foreach ($data as $item) {
            if ($item->idconf_maquina == $idmaquina) {
                $rta['serie_maquina'] = $item->serie_maquina;
                $rta['serie_banco'] = $item->serie_banco;
            }
        }




        // echo '<pre>';
        // var_dump($rta);
        // echo '</pre>';
        echo json_encode($rta);
    }

    function statscalibraciones()
    {
        $this->setConf();
        $fechainicialca = $this->input->post('fechainicialca');
        $fechafinalca = $this->input->post('fechafinalca');
        $selanalizador = $this->input->post('selanalizador');
        $selopcaidad = $this->input->post('selopcaidad');
        $seltiporeporte = $this->input->post('seltiporeporte');
        $seltiporeporteopacidad = $this->input->post('seltiporeporteopacidad');
        $tipoinforme = $this->tipo_informe_fugas_cal_lin;
        if ($tipoinforme == "NA") {
            $tipoinforme = $this->input->post('tipoinforme');
        } else {
            $tipoinforme = $this->tipo_informe_fugas_cal_lin;
        }

        //        echo 'Tipo informe'. $tipoinforme;
        if (isset($tipoinforme) && $tipoinforme == 1) {
            //            echo 'tablas nuevas';
            if ($selanalizador !== null) {
                switch ($seltiporeporte) {
                    case 1:
                        $rta = $this->Mstats->statscalibracionesnuevo($fechainicialca, $fechafinalca, $selanalizador);
                        echo json_encode($rta);
                        break;
                    case 2:
                        $rta = $this->Mstats->statsfugasnuevo($fechainicialca, $fechafinalca, $selanalizador);
                        echo json_encode($rta);
                        break;
                    default:
                        $rta = $this->Mstats->statsverificacion($fechainicialca, $fechafinalca, $selanalizador);
                        echo json_encode($rta);
                        break;
                }
            } else {
                switch ($seltiporeporteopacidad) {
                    case 1:
                        $rta = $this->Mstats->linealidadNuevo($fechainicialca, $fechafinalca, $selopcaidad);
                        echo json_encode($rta);
                        break;
                    case 2:
                        $rta = $this->Mstats->controlceroNuevo($fechainicialca, $fechafinalca, $selopcaidad);
                        echo json_encode($rta);
                        break;
                    default:
                        $rta = $this->Mstats->tiempoRespuesta($fechainicialca, $fechafinalca, $selopcaidad);
                        echo json_encode($rta);
                        break;
                }
            }
        } else {
            //            echo 'tablas anteriores.';
            if ($selanalizador !== null) {
                switch ($seltiporeporte) {
                    case 1:
                        $rta = $this->Mstats->statscalibraciones($fechainicialca, $fechafinalca, $selanalizador);
                        echo json_encode($rta);
                        break;
                    case 2:
                        $rta = $this->Mstats->statsfugas($fechainicialca, $fechafinalca, $selanalizador);
                        echo json_encode($rta);
                        break;
                    default:
                        //                        $rta = $this->Mstats->statsfugas($fechainicialca, $fechafinalca, $selanalizador);
                        echo json_encode('nodata');
                        break;
                }
            } else {
                $rta = $this->Mstats->statslinealidad($fechainicialca, $fechafinalca, $selopcaidad);
                echo json_encode($rta);
            }
        }
    }

    function reportpdfcalibraciones()
    {
        $this->setConf();
        date_default_timezone_set('America/bogota');
        $cadena = $this->input->post('fecha');
        $id = $this->input->post('id');
        $fecha = $this->formato_texto($cadena);
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $data = json_decode($json);

        $ma = $encrptopenssl->decrypt(file_get_contents('system/' . $id . '.json', true));
        $maquinaData = json_decode(utf8_decode($ma), true);
        foreach ($maquinaData as $m) {
            if ($m['idconf_maquina'] == $id) {
                if ($m['nombre'] == "nombreMarca") {
                    $marca = strtoupper($m['valor']);
                }
            }
        }
        foreach ($data as $item) {
            if ($item->idconf_maquina == $id) {
                $serie_maquina = $item->serie_maquina;
                $serie_banco = $item->serie_banco;
            }
        }
        $tipoinforme = $this->tipo_informe_fugas_cal_lin;
        if ($tipoinforme == "NA") {
            $tipoinforme = $this->input->post('tipoInforme');
        } else {
            $tipoinforme = $this->tipo_informe_fugas_cal_lin;
        }
        if (isset($tipoinforme) && $tipoinforme == 1) {
            $resdata = $this->Mstats->reportpdfcalibracionesnuevo($fecha, $id);
        } else {
            $resdata = $this->Mstats->reportpdfcalibraciones($fecha, $id);
        }
        $rta['tipoinforme'] = 1;
        $rta['titulo'] = strtoupper('Reporte Calibracion');
        $rta['cda'] = $this->infocda();
        $rta['imagen']->logo = "@" . base64_encode($rta['cda']->logo);
        $rta['usuariogeneracion'] = $this->Mstats->infousercreacion($iduser = $this->session->userdata('IdUsuario')); //la variable esta asignada al reporte, falta sacar el dato
        $rta['fechageneracion'] = date("Y-m-d H:i:s");
        $rta['sede'] = $this->infosede();
        $rta['marca'] = ucwords(strtolower($marca));
        $rta['modelo'] = strtoupper($serie_banco);
        $rta['serial'] = strtoupper($serie_maquina);
        $rta['cal'] = $resdata;
        $this->load->view('oficina/reportes/stats/VPDF_report_gases_opa', $rta);
    }

    function reportpdffugas()
    {
        $this->setConf();
        date_default_timezone_set('America/bogota');
        $cadena = $this->input->post('fecha');
        $id = $this->input->post('id');
        $fecha = $this->formato_texto($cadena);
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $data = json_decode($json);
        $ma = $encrptopenssl->decrypt(file_get_contents('system/' . $id . '.json', true));
        $maquinaData = json_decode(utf8_decode($ma), true);
        foreach ($maquinaData as $m) {
            if ($m['idconf_maquina'] == $id) {
                if ($m['nombre'] == "nombreMarca") {
                    $marca = strtoupper($m['valor']);
                }
            }
        }
        foreach ($data as $item) {
            if ($item->idconf_maquina == $id) {
                $serie_maquina = $item->serie_maquina;
                $serie_banco = $item->serie_banco;
            }
        }
        // foreach ($data as $item) {
        //     if ($item->idconf_maquina == $id) {
        //         $marca = $item->marca;
        //         $serie_maquina = $item->serie_maquina;
        //         $serie_banco = $item->serie_banco;
        //     }
        // }
        $tipoinforme = $this->tipo_informe_fugas_cal_lin;
        if ($tipoinforme == "NA") {
            $tipoinforme = $this->input->post('tipoInforme');
        } else {
            $tipoinforme = $this->tipo_informe_fugas_cal_lin;
        }
        if ($tipoinforme == 1) {
            $resdata = $this->Mstats->reportpdffugasnuevo($fecha, $id);
        } else {
            $resdata = $this->Mstats->reportpdffugas($fecha, $id);
        }
        $rta['tipoinforme'] = 2;
        $rta['titulo'] = strtoupper('Reporte Fugas');
        $rta['cda'] = $this->infocda();
        $rta['imagen']->logo = "@" . base64_encode($rta['cda']->logo);
        $rta['usuariogeneracion'] = $this->Mstats->infousercreacion($iduser = $this->session->userdata('IdUsuario')); //la variable esta asignada al reporte, falta sacar el dato
        //        $rta ['usuariogeneracion'] = 1; //la variable esta asignada al reporte, falta sacar el dato
        $rta['fechageneracion'] = date("Y-m-d H:i:s");
        $rta['sede'] = $this->infosede();
        $rta['marca'] = ucwords(strtolower($marca));
        $rta['modelo'] = strtoupper($serie_banco);
        $rta['serial'] = strtoupper($serie_maquina);
        $rta['fug'] = $resdata;
        $this->load->view('oficina/reportes/stats/VPDF_report_gases_opa', $rta);
    }

    function reportpdfcero()
    {
        $this->setConf();
        date_default_timezone_set('America/bogota');
        $cadena = $this->input->post('fecha');
        $id = $this->input->post('id');
        $fecha = $this->formato_texto($cadena);
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $data = json_decode($json);
        $ma = $encrptopenssl->decrypt(file_get_contents('system/' . $id . '.json', true));
        $maquinaData = json_decode(utf8_decode($ma), true);
        foreach ($maquinaData as $m) {
            if ($m['idconf_maquina'] == $id) {
                if ($m['nombre'] == "nombreMarca") {
                    $marca = strtoupper($m['valor']);
                }
            }
        }
        // foreach ($data as $item) {
        //     if ($item->idconf_maquina == $id) {
        //         $serie_maquina = $item->serie_maquina;
        //         $serie_banco = $item->serie_banco;
        //     }
        // }

        foreach ($data as $item) {
            if ($item->idconf_maquina == $id) {
                //$marca = $item->marca;
                $serie_maquina = $item->serie_maquina;
                $serie_banco = $item->serie_banco;
                if (strtoupper($item->marca) == "CAPELEC") {
                    $ltoe = "215";
                } else {
                    $ltoe = "N/A";
                }
            }
        }
        $tipoinforme = $this->tipo_informe_fugas_cal_lin;
        if ($tipoinforme == "NA") {
            $tipoinforme = $this->input->post('tipoInforme');
        } else {
            $tipoinforme = $this->tipo_informe_fugas_cal_lin;
        }
        if (isset($tipoinforme) && $tipoinforme == 1) {
            $resdata = $this->Mstats->controlceroNuevoPdf($fecha, $id);
        } else {
            $resdata = $this->Mstats->controlceroNuevoPdf($fecha, $id);
        }
        $rta['tipoinforme'] = 5;
        $rta['titulo'] = strtoupper('Reporte Control Cero');
        $rta['cda'] = $this->infocda();
        $rta['imagen']->logo = "@" . base64_encode($rta['cda']->logo);
        $rta['usuariogeneracion'] = $this->Mstats->infousercreacion($iduser = $this->session->userdata('IdUsuario')); //la variable esta asignada al reporte, falta sacar el dato
        //        $rta ['usuariogeneracion'] = $this->Mstats->infousercreacion($iduser = 1); //la variable esta asignada al reporte, falta sacar el dato
        $rta['fechageneracion'] = date("Y-m-d H:i:s");
        $rta['sede'] = $this->infosede();
        $rta['marca'] = ucwords(strtolower($marca));
        $rta['modelo'] = strtoupper($serie_banco);
        $rta['serial'] = strtoupper($serie_maquina);
        $rta['ltoe'] = $ltoe;
        $rta['cero'] = $resdata;
        $this->load->view('oficina/reportes/stats/VPDF_report_gases_opa', $rta);
    }

    function reportverificacion()
    {
        $id = $this->input->post('idcontrol_verificacion');
        $idmaquina = $this->input->post('idmaquina');
        $serie_maquina = "";
        $pef = "";
        $marcasoft = "Crear la variable marcasoft.";
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $data = json_decode($json);
        foreach ($data as $item) {
            if ($item->idconf_maquina == $idmaquina) {
                $serie_maquina = $item->serie_maquina;
            }
        }
        if ($conf = @file_get_contents("system/" . $idmaquina . ".json")) {
            $json = $encrptopenssl->decrypt($conf, true);
            $dat = json_decode($json, true);
            foreach ($dat as $d) {
                switch ($d['nombre']) {
                    case 'pef':
                        $pef = $d['valor'];
                        break;
                    case 'marcasoft':
                        $marcasoft = $d['valor'];
                        break;

                    default:
                        break;
                }
            }
        }

        $r = $this->infocda();
        $rta['verificacion'] = $this->Mstats->dataVerificacion($id);
        $rta2['seriemaquina'] = $serie_maquina;
        $rta2['nombrecda'] = $r->nombre_cda;
        $rta2['pef'] = $pef;
        $rta2['marcasoft'] = $marcasoft;
        $result = array_merge($rta, $rta2);
        echo json_encode($result);
    }

    function resTiempoRespuesta()
    {
        $id = $this->input->post('id');

        $rta = $this->Mstats->resTiempoRespuesta($id);
        $idmaquina = $rta[0]->idmaquina;
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $data = json_decode($json);

        $ma = $encrptopenssl->decrypt(file_get_contents('system/' . $idmaquina . '.json', true));
        $maquinaData = json_decode(utf8_decode($ma), true);
        foreach ($maquinaData as $m) {
            if ($m['idconf_maquina'] == $idmaquina) {
                if ($m['nombre'] == "nombreMarca") {
                    $rta['marca'] = strtoupper($m['valor']);
                }
            }
            if ($m['idconf_maquina'] == $idmaquina) {
                if ($m['nombre'] == "marcasoft") {
                    $rta['marcasoft'] = strtoupper($m['valor']);
                }
            }
            if ($m['idconf_maquina'] == $idmaquina) {
                if ($m['nombre'] == "versionsoft") {
                    $rta['versionsoft'] = strtoupper($m['valor']);
                }
            }
        }
        foreach ($data as $item) {
            if ($item->idconf_maquina == $idmaquina) {
                $rta['serie_maquina'] = $item->serie_maquina;
                $rta['serie_banco'] = $item->serie_banco;
            }
        }
        // var_dump($rta);
        echo json_encode($rta);
    }

    function reportpdflinealidad()
    {
        $this->setConf();
        $fecha = $this->input->post('fecha');
        $id = $this->input->post('id');
        date_default_timezone_set('America/bogota');
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $data = json_decode($json);
        foreach ($data as $item) {
            if ($item->idconf_maquina == $id) {
                $marca = $item->marca;
                $serie_maquina = $item->serie_maquina;
                $serie_banco = $item->serie_banco;
            }
        }
        $tipoinforme = $this->tipo_informe_fugas_cal_lin;
        if ($tipoinforme == "NA") {
            $tipoinforme = $this->input->post('tipoInforme');
        } else {
            $tipoinforme = $this->tipo_informe_fugas_cal_lin;
        }
        if (isset($tipoinforme) && $tipoinforme == 1) {
            $resdata = $this->Mstats->reportpdflinealidadNuevo($fecha, $id);
        } else {
            $resdata = $this->Mstats->reportpdflinealidad($fecha, $id);
        }
        $rta['tipoinforme'] = 4;
        $rta['titulo'] = strtoupper('Reporte Linealidad');
        $rta['cda'] = $this->infocda();
        $rta['imagen']->logo = "@" . base64_encode($rta['cda']->logo);
        $rta['usuariogeneracion'] = $this->Mstats->infousercreacion($iduser = $this->session->userdata('IdUsuario')); //la variable esta asignada al reporte, falta sacar el dato
        $rta['fechageneracion'] = date("Y-m-d H:i:s");
        $rta['sede'] = $this->infosede();
        $rta['marca'] = ucwords(strtolower($marca));
        $rta['modelo'] = strtoupper($serie_banco);
        $rta['serial'] = strtoupper($serie_maquina);
        $rta['lin'] = $resdata;
        $this->load->view('oficina/reportes/stats/VPDF_report_gases_opa', $rta);
    }

    function infocda()
    {
        $data = $this->Mstats->infocda();
        $rta = $data->result();
        return $rta[0];
    }

    // fin reportes fugas cal 
    //consulta la informacion de la tabla sede
    function infosede()
    {
        $data = $this->Mstats->infosede();
        $rta = $data->result();
        return $rta[0];
    }

    private function formato_texto($cadena)
    {
        $no_permitidas = array("/");
        $permitidas = array(" ");
        $texto = str_replace($no_permitidas, $permitidas, $cadena);
        return $texto;
    }

    //inciar agop

    function agop()
    {
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $data = json_decode($json);
        foreach ($data as $item) {
            if ($item->prueba == 'analizador' && $item->activo == 1) {
                $rta = $this->Mstats->infoCal($item->idconf_maquina);
                $rtafug = $this->Mstats->infoFug($item->idconf_maquina);

                if (empty($rta)) {
                    echo "<script>alert('No existe dato de la maquina. " . $item->idconf_maquina . ", no se pudo realizar el proceso.')</script>";
                } else {
                    $dataCal = $this->insertDataCalAgop($rta);
                }

                if (empty($rtafug)) {
                    echo "<script>alert('No existe dato de la maquina. " . $item->idconf_maquina . ", no se pudo realizar el proceso.')</script>";
                } else {
                    $dataFug = $this->insertDataFugAgop($rtafug);
                }
            } elseif ($item->prueba == 'opacidad' && $item->activo == 1) {
                $rtaOpa = $this->Mstats->infoOpa($item->idconf_maquina);
                if (empty($rtaOpa)) {
                    //echo "<script>alert('No existe dato de la maquina. " . $1204
                    echo "<script>alert('No existe dato de la maquina. " . $item->idconf_maquina . ", no se pudo realizar el proceso.')</script>";
                } else {
                    $dataFug = $this->insertDataOpaAgop($rtaOpa);
                }
            }
        }
        echo "<script>alert('Proceso finalizado.')</script>";
        //redirect("Cindex");
        $this->index();
    }

    function insertDataCalAgop($rta)
    {
        $exa_hc = 12;
        $exa_co = 0.02;
        $exa_co2 = 0.1;
        $rand = (rand(0 * 1000, 1 * 1000) / 1000);
        $lim_hc_min = ($rta->Span_alto_hc - $exa_hc);
        $lim_hc_max = ($rta->Span_alto_hc + $exa_hc);
        if (is_numeric($lim_hc_min) && is_numeric($lim_hc_max)) {
            $dataAlta = ((($lim_hc_max - $lim_hc_min) * $rand) + $lim_hc_min);
            $calAltaHc = round(($dataAlta * $rta->Pef));
        }
        $lim_co_min = ($rta->Span_alto_co - $exa_co);
        $lim_co_max = ($rta->Span_alto_co + $exa_co);
        if (is_numeric($lim_co_min) && is_numeric($lim_co_max)) {
            $dataAltaCo = round(((($lim_co_max - $lim_co_min) * $rand) + $lim_co_min), 2);
        }
        $lim_co2_min = ($rta->Span_alto_co2 - $exa_co2);
        $lim_co2_max = ($rta->Span_alto_co2 + $exa_co2);
        if (is_numeric($lim_co2_min) && is_numeric($lim_co2_max)) {
            $dataAltaCo2 = round(((($lim_co2_max - $lim_co2_min) * $rand) + $lim_co2_min), 2);
        }
        $lim_hc_min_baja = ($rta->Span_bajo_hc - $exa_hc);
        $lim_hc_max_baja = ($rta->Span_bajo_hc + $exa_hc);
        if (is_numeric($lim_hc_min_baja) && is_numeric($lim_hc_max_baja)) {
            $dataBajo = ((($lim_hc_max_baja - $lim_hc_min_baja) * $rand) + $lim_hc_min_baja);
            $calBajoHc = round(($dataBajo * $rta->Pef));
        }
        $lim_co_min_baja = ($rta->Span_bajo_co - $exa_co);
        $lim_co_max_baja = ($rta->Span_bajo_co + $exa_co);
        if (is_numeric($lim_co_min_baja) && is_numeric($lim_co_max_baja)) {
            $dataBajaCo = round(((($lim_co_max_baja - $lim_co_min_baja) * $rand) + $lim_co_min_baja), 2);
        }
        $lim_co2_min_baja = ($rta->Span_bajo_co2 - $exa_co2);
        $lim_co2_max_baja = ($rta->Span_bajo_co2 + $exa_co2);
        if (is_numeric($lim_co2_min_baja) && is_numeric($lim_co2_max_baja)) {
            $dataBajaCo2 = round(((($lim_co2_max_baja - $lim_co2_min_baja) * $rand) + $lim_co2_min_baja), 2);
        }


        date_default_timezone_set('America/bogota');
        $date = date("Y-m-d H:i:s");
        $data['fecha'] = $date;
        $data['idmaquina'] = $rta->Idmaquina;
        $data['usuario'] = $this->session->userdata('IdUsuario');
        $data['pef'] = $rta->Pef;
        $data['span_alto_hc'] = $rta->Span_alto_hc;
        $data['span_alto_co'] = $rta->Span_alto_co;
        $data['span_alto_co2'] = $rta->Span_alto_co2;
        $data['span_bajo_hc'] = $rta->Span_bajo_hc;
        $data['span_bajo_co'] = $rta->Span_bajo_co;
        $data['span_bajo_co2'] = $rta->Span_bajo_co2;
        $data['cal_alto_hc'] = $calAltaHc;
        $data['cal_alto_co'] = $dataAltaCo;
        $data['cal_alto_co2'] = $dataAltaCo2;
        $data['cal_alto_o2'] = rand(0, 1.9) / 10;
        //        $data ['cal_alto_hc'] = rand($rta->Span_alto_hc * $rta->Pef, $rta->Span_alto_hc * $rta->Pef + 20);
        //        $i = rand($rta->Span_alto_co * 10, $rta->Span_alto_co * 10.36) / 10.14;
        //        $data ['cal_alto_co'] = number_format($i, 2, '.', ' ');
        //        $i = rand($rta->Span_alto_co2 * 10, $rta->Span_alto_co2 * 10.45) / 10.26;
        //        $data ['cal_alto_co2'] = number_format($i, 2, '.', ' ');
        ////        $data ['cal_bajo_hc'] = rand($rta->Span_bajo_hc * $rta->Pef, $rta->Span_bajo_hc * $rta->Pef + 6);
        //        $data ['cal_bajo_hc'] = $dataBaja;
        ////        $i = rand($rta->Span_bajo_co * 10, $rta->Span_bajo_co * 10.95) / 10.91;
        //        $data ['cal_bajo_co'] = number_format($i, 2, '.', ' ');
        //        $i = rand($rta->Span_bajo_co2 * 10, $rta->Span_bajo_co2 * 10.65) / 10.15;
        //        $data ['cal_bajo_co2'] = number_format($i, 2, '.', ' ');
        $data['cal_bajo_hc'] = $calBajoHc;
        $data['cal_bajo_co'] = $dataBajaCo;
        $data['cal_bajo_co2'] = $dataBajaCo2;
        $data['cal_bajo_o2'] = rand(0, 1.9) / 10;
        $data['presion_base'] = rand($rta->Presion_base, $rta->Presion_base + 10);
        $data['presion_bomba'] = rand($rta->Presion_bomba, $rta->Presion_bomba + 10);
        $data['resultado'] = 'S';
        if ($this->Mstats->insertCal($data) == 1) {
            return true;
        };
    }

    function insertDataFugAgop($rtafug)
    {
        date_default_timezone_set('America/bogota');
        $date = date("Y-m-d H:i:s");
        $data['fecha'] = $date;
        $data['usuario'] = $this->session->userdata('IdUsuario');
        //        $data ['usuario'] = 23;
        $data['idmaquina'] = $rtafug->Id;
        $data['presion_base'] = $ps = rand($rtafug->presion_base, $rtafug->presion_base + 10);
        $data['presion_bomba'] = $ps;
        $data['presion_filtros'] = rand($rtafug->presion_filtros, $rtafug->presion_filtros - 5);
        $data['presion_bombaon'] = $pbon = $ps / 2 + rand(30, 50);
        $data['presion_bombaoff'] = $pboff = $pbon + rand(1, 15);
        $data['num_fuga'] = $nf = $pboff - $pbon;
        $data['por_num_fuga'] = $nf * 0.3;
        $data['aprobado'] = 'S';
        if ($this->Mstats->insertFug($data) == 1) {
            return true;
        };
    }

    // function insertDataOpaAgop($rtaOpa)
    // {
    //     date_default_timezone_set('America/bogota');
    //     $date = date("Y-m-d H:i:s");
    //     $data['fecha'] = $date;
    //     $data['idmaquina'] = $rtaOpa->idmaquina;
    //     $data['usuario'] = $this->session->userdata('IdUsuario');
    //     //        $data ['usuario'] = 23;
    //     $data['valor1'] = $rtaOpa->valor1;
    //     $data['valor2'] = $rtaOpa->valor2;
    //     $data['valor3'] = $rtaOpa->valor3;
    //     $data['valor4'] = $rtaOpa->valor4;
    //     $data['lectura1'] = $rtaOpa->lectura1;
    //     $data['lectura2'] = rand($rtaOpa->valor2, $rtaOpa->valor2 + 3);
    //     $data['lectura3'] = rand($rtaOpa->valor3, $rtaOpa->valor3 + 3);
    //     $data['lectura4'] = rand($rtaOpa->valor4, $rtaOpa->valor4 - 3);
    //     $data['desviacion1'] = $data['valor1'] - $data['lectura1'];
    //     $data['desviacion2'] = $data['valor2'] - $data['lectura2'];
    //     $data['desviacion3'] = $data['valor3'] - $data['lectura3'];
    //     $data['desviacion4'] = $data['valor4'] - $data['lectura4'];
    //     $data['aprobado'] = "S";
    //     if ($this->Mstats->insertOpa($data) == 1) {
    //         return true;
    //     };
    // }

    function insertDataOpaAgop($rtaOpa)
    {
        date_default_timezone_set('America/bogota');
        $date = date("Y-m-d H:i:s");
        $data['fecha'] = $date;
        $data['idmaquina'] = $rtaOpa->idmaquina;
        $data['usuario'] = $this->session->userdata('IdUsuario');
        // $data ['usuario'] = 23;
        $data['valor1'] = $rtaOpa->valor1;
        $data['valor2'] = $rtaOpa->valor2;
        $data['valor3'] = $rtaOpa->valor3;
        $data['valor4'] = $rtaOpa->valor4;

        // Cálculo de lecturas según la lógica VB.NET
        // Lectura 1: entre 0 y valor1
        $len_val1_min = 0;
        $len_val1_max = $rtaOpa->valor1;
        $data['lectura1'] = round((($len_val1_max - $len_val1_min) * mt_rand() / mt_getrandmax()) + $len_val1_min, 1);

        // Lectura 2: entre valor2 - 0.2 y valor2 + 0.2
        $len_val2_min = $rtaOpa->valor2 - 0.2;
        $len_val2_max = $rtaOpa->valor2 + 0.2;
        $data['lectura2'] = round((($len_val2_max - $len_val2_min) * mt_rand() / mt_getrandmax()) + $len_val2_min, 1);

        // Lectura 3: entre valor3 - 0.2 y valor3 + 0.2
        $len_val3_min = $rtaOpa->valor3 - 0.2;
        $len_val3_max = $rtaOpa->valor3 + 0.2;
        $data['lectura3'] = round((($len_val3_max - $len_val3_min) * mt_rand() / mt_getrandmax()) + $len_val3_min, 1);

        // Lectura 4: entre valor4 - 0.2 y 99.9
        $len_val4_min = $rtaOpa->valor4 - 0.2;
        $len_val4_max = 99.9;
        $data['lectura4'] = round((($len_val4_max - $len_val4_min) * mt_rand() / mt_getrandmax()) + $len_val4_min, 1);

        $data['desviacion1'] = $data['valor1'] - $data['lectura1'];
        $data['desviacion2'] = $data['valor2'] - $data['lectura2'];
        $data['desviacion3'] = $data['valor3'] - $data['lectura3'];
        $data['desviacion4'] = $data['valor4'] - $data['lectura4'];
        $data['aprobado'] = "S";

        if ($this->Mstats->insertOpa($data) == 1) {
            return true;
        };
    }

    // inicio bitacoras

    function bitacoras()
    {
        date_default_timezone_set('America/bogota');
        $date = date("h:i:s");
        if ($this->input->post('fechafinalbi') == null || $this->input->post('fechafinalbi') == "") {
            $fechafinal = null;
        } else {
            $fechafinal = $this->input->post('fechafinalbi') . ' ' . $date;
        }
        if ($this->input->post('IdUsuario') == null || $this->input->post('IdUsuario') == "") {
            $idusuario = $this->session->userdata('IdUsuario');
        } else {
            $idusuario = $this->input->post('IdUsuario');
        }
        $data['tipo'] = $this->input->post('tipobi');
        $data['gravedad'] = $this->input->post('gravedadbi');
        $data['estado'] = $this->input->post('estadobi');
        $data['idmaquina'] = $this->input->post('maquinabi');
        $data['fecha_apertura'] = $this->input->post('fechainicialbi') . ' ' . $date;
        $data['fecha_cierre'] = $fechafinal;
        $data['comentario'] = $this->input->post('html');
        $data['idusuario'] = $idusuario;         //guardar id usuario
        $rta = $this->Mstats->isertBitacora($data);
        echo json_encode($rta);
    }

    function getBitacoras()
    {
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $rtamaquina = json_decode($json);
        $rta = $this->Mstats->getBitacoras();
        foreach ($rtamaquina as $v) {
            foreach ($rta as $n) {
                if ($v->idconf_maquina == $n->idmaquina) {
                    $n->nombre = $v->nombre . ' ' . $v->marca . ' ' . $v->serie_maquina . ' ' . $v->serie_banco;
                }
                if ($n->comentario == 'Descripcion inicial: Inicio operación----Descripcion cierre: fin operación') {
                    if ($v->nombre == 'oficina')
                        $n->nombre = $v->nombre . ' ' . $v->marca . ' ' . $v->serie_maquina . ' ' . $v->serie_banco;
                }
            }
        }
        echo json_encode($rta);
    }

    function getLineasBItacoras()
    {
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $data = json_decode($json);
        echo json_encode($data);
    }

    function bitacorasOpen()
    {
        if ($this->input->post('idusuario') == null || $this->input->post('idusuario') == "") {
            //            $idusuario = $this->session->userdata('IdUsuario');
            $idusuario = $this->session->userdata('IdUsuario');
        } else {
            $idusuario = $this->input->post('idusuario');
        }
        $rta = $this->Mstats->bitacorasOpen($idusuario);
        echo json_encode($rta);
    }

    function updateBitacoras()
    {
        date_default_timezone_set('America/bogota');
        $date = date("h:i:s");
        $fechacierre = $this->input->post('fechacierre') . " " . $date;
        $descripcion = $this->input->post('descripcion');
        $idbitacora = $this->input->post('idbitacora');
        $rta = $this->Mstats->updateBitacoras($fechacierre, $descripcion, $idbitacora);
        echo json_encode($rta);
    }

    function getBitacoraInicioOperaciona()
    {
        $idusuario = $this->input->post('idusuario');
        $idmaquina = $this->input->post('idmaquina');
        $rta = $this->Mstats->getBitacoraInicioOperaciona($idusuario, $idmaquina);
        echo json_encode($rta);
    }

    function insertBitacoraInicio()
    {
        date_default_timezone_set('America/bogota');
        $this->setConf();
        $horaCierre = $this->horaCierre;
        if ($horaCierre == null || $horaCierre == "") {
            $hora = rand(18, 19) . ":" . rand(01, 59) . ":" . rand(01, 60);
        } else {
            $hora = $horaCierre;
        }
        $date = date("Y-m-d H:i:s");
        $data['tipo'] = 'Operacion';
        $data['gravedad'] = 'N/A';
        $data['estado'] = '2';
        $data['idmaquina'] = $this->input->post('idmaquina');
        $data['fecha_apertura'] = date("Y-m-d H:i:s");
        //        $data ['fecha_cierre'] = date("Y-m-d") . " " . $hora;
        $data['fecha_cierre'] = date("Y-m-d") . " " . $hora;
        $data['comentario'] = 'Descripcion inicial: Inicio operación----Descripcion cierre: fin operación';
        $data['idusuario'] = $this->input->post('idusuario');         //guardar id usuario
        $rta = $this->Mstats->isertBitacora($data);
        echo json_encode($rta);
    }

    function informePesv()
    {
        $fechainicial = $this->input->post('fechainicial');
        $fechafinal = $this->input->post('fechafinal');
        $rta = $this->Mstats->informePesv($fechainicial, $fechafinal);
        if (count($rta) > 0) {
            foreach ($rta as $val) {
                $res = $this->Mstats->informePesvPrere($val->numeroPlaca);
                if (count($res) > 0) {
                    $val->AuxPrerevision = $res[0]->AuxPrerevisionPre;
                    $val->IdentificacionP = $res[0]->IdentificacionPre;
                }
            }
            echo json_encode($rta);
        } else {
            echo json_encode([]);
        }
    }
}
