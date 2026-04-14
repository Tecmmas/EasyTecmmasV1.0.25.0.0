<?php

defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
ini_set('memory_limit', '-1');

//set_time_limit(300);

class CGPrueba extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("oficina/gestion/MGPrueba");
        $this->load->model("dominio/Mcarroceria");
        $this->load->model("dominio/Mvehiculo");
        $this->load->model("dominio/Mhojatrabajo");
        $this->load->model("dominio/Mcertificados");
        $this->load->model("dominio/Mconfig_prueba");
        $this->load->model("dominio/Musuarios");
        $this->load->model("dominio/Mhojatrabajo");
        $this->load->model("dominio/MEventosindra");
        $this->load->model("dominio/Mpre_prerevision");
        $this->load->model("dominio/Mpre_atributo");
        $this->load->model("dominio/Mpre_dato");
        $this->load->model("Mutilitarios");
        $this->load->helper('download');
        $this->load->dbutil();

        $this->load->library('Opensslencryptdecrypt');
    }

    var $llanta_1_I = '';
    var $llanta_1_D = '';
    var $llanta_2_IE = '';
    var $llanta_2_DE = '';
    var $llanta_2_II = '';
    var $llanta_2_DI = '';
    var $llanta_3_II = '';
    var $llanta_3_IE = '';
    var $llanta_3_DI = '';
    var $llanta_3_DE = '';
    var $llanta_4_II = '';
    var $llanta_4_IE = '';
    var $llanta_4_DI = '';
    var $llanta_4_DE = '';
    var $llanta_5_II = '';
    var $llanta_5_IE = '';
    var $llanta_5_DI = '';
    var $llanta_5_DE = '';
    var $llanta_R = '';
    var $llanta_R2 = '';

    public function index() {
        if ($this->session->userdata('IdUsuario') == '' || $this->session->userdata('IdUsuario') == '1024') {
            redirect('Cindex');
        }
    }

    public function CGVenPista() {
        $datos = explode('-', $this->input->post('dato'));
        if ($datos[1] == '0' || $datos[1] == '4444' || $datos[1] == '8888') {
            $ocacion = 'PRIMERA VEZ';
        } else {
            $ocacion = 'SEGUNDA VEZ';
        }
        if ($datos[1] == '0' || $datos[1] == '1') {
            $ti = "1";
            if ($datos[1] == '0') {
                $reinspeccion = 0;
            } else {
                $reinspeccion = 1;
            }
        } elseif ($datos[1] == '4444' || $datos[1] == '44441') {
            $ti = "2";
            if ($datos[1] == '4444') {
                $reinspeccion = 0;
            } else {
                $reinspeccion = 1;
            }
        } else {
            $ti = "3";
            $reinspeccion = 0;
        }
        $data['dato'] = $this->input->post('dato') . "-1";
        $data['vehiculo'] = $this->MGPrueba->getVehiculoEnPista($datos[0]);
        $data['ocacion'] = $ocacion;
        $data['idhojapruebas'] = $datos[0];
        $data['pendientes'] = $this->MGPrueba->pruebasPendientes($datos[0]);
//        $data['presion'] = $this->getPresiones($data['vehiculo']->numero_placa, $reinspeccion, $this->Mutilitarios->getNow(), $ti);
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/oficina.json', true), true);
        $ofc = json_decode($json, true);
        foreach ($ofc as $d) {
            $data[$d['nombre']] = $d['valor'];
        }
        $rta = $this->MGPrueba->getPlaca($datos[0]);
        $data['placaR'] = $rta->result();
        $this->load->view('oficina/gestion/VGVenPista', $data);
    }

    public function CGVfinalizado() {
        $datos = explode('-', $this->input->post('dato'));
        if ($datos[1] == '0' || $datos[1] == '4444' || $datos[1] == '8888') {
            $ocacion = 'PRIMERA VEZ';
        } else {
            $ocacion = 'SEGUNDA VEZ';
        }
        $data['dato'] = $this->input->post('dato');
        $data['vehiculo'] = $this->MGPrueba->getVehiculoEnPista($datos[0]);
        $data['ocacion'] = $ocacion;
        $data['idhojapruebas'] = $datos[0];
        if (isset($datos[2])) {
            $data['res'] = $datos[2];
        }
        $data['reinspeccion'] = $datos[1];
        $this->load->view('oficina/gestion/VGVfinalizado', $data);
    }

    public function CGVrechaSinFirmar() {
        $data = $this->cargar($this->input->post('dato'));
        $datos = explode("-", $this->input->post('dato'));
        $datHT['jefelinea'] = $data['jefePista']->valor;
        $datHT['idhojapruebas'] = $datos[0];
        if ($datos[1] !== '0' && $datos[1] !== '1') {
            $datHT['estadototal'] = '3';
        } else {
            $datHT['estadototal'] = '1';
        }
//        $rta = $this->MGPrueba->getPlaca($data['vehiculo']->numero_placa);
        $rta = $this->MGPrueba->getPlaca($datos[0]);
        $data['placaR'] = $rta->result();
        $this->Mhojatrabajo->update($datHT);
        $this->load->view('oficina/gestion/VGVrechaSinFirmar', $data);
    }

    //     public function guardarJefeLinea($placa,$id) {
    //        $id = $this->input->post('id');
    //        $numero_placa_ref = $this->input->post('numero_placa_ref');
    //        $reinspeccion = $this->input->post('reinspeccion');
    //        $tipo_inspeccion = $this->input->post('tipo_inspeccion');
    //        $valor = $this->input->post('valor');
    //        $pre_prerevision['numero_placa_ref'] = $numero_placa_ref;
    //        $pre_prerevision['reinspeccion'] = $reinspeccion;
    //        $pre_prerevision['tipo_inspeccion'] = $tipo_inspeccion;
    //        $idpre_prerevision = $this->Mpre_prerevision->getXidPre($pre_prerevision);
    //        $pre_atributo['id'] = $id;
    //        $idpre_atributo = $this->Mpre_atributo->getXid($pre_atributo);
    //        $rta_pre = $idpre_atributo->result();
    //        $pre_dato['idpre_atributo'] = $rta_pre[0]->idpre_atributo;
    //        $pre_dato['idpre_zona'] = '0';
    //        $pre_dato['idpre_prerevision'] = $idpre_prerevision;
    //        $pre_dato['valor'] = $valor;
    //        $this->Mpre_dato->guardar($pre_dato);
    //    }


    public function CGVrechaEnvioFirmar() {
        $datHT['idhojapruebas'] = $this->input->post('idhojapruebas');
        $datHT['estadototal'] = '3';
        $datHT['sicov'] = '1';
        $this->Mhojatrabajo->update_x($datHT);
        $this->insertarEvento($this->input->post('placa'), "idUsuario: " . $this->session->userdata('IdUsuario'), "f", "1", "Acción de usuario: Transacción exitosa|X|" . $this->input->post('ocasion') . "|1|Estado cambiado por el usuario de RECHAZADO SIN FIRMAR a RECHAZADO SIN CONSECUTIVO");
    }

    public function CGVaproSinFirmar() {
        $data = $this->cargar($this->input->post('dato'));
        $datos = explode("-", $this->input->post('dato'));
        $datHT['jefelinea'] = $data['jefePista']->valor;
        $datHT['idhojapruebas'] = $datos[0];
        if ($datos[1] !== '0' && $datos[1] !== '1') {
            $datHT['estadototal'] = '2';
        } else {
            $datHT['estadototal'] = '1';
        }
        $rta = $this->MGPrueba->getPlaca($datos[0]);
        $data['placaR'] = $rta->result();
        $this->Mhojatrabajo->update($datHT);
        $this->load->view('oficina/gestion/VGVaproSinFirmar', $data);
    }

    public function CGVaproEnvioFirmar() {
        $datHT['idhojapruebas'] = $this->input->post('idhojapruebas');
        $datHT['estadototal'] = '2';
        $datHT['sicov'] = '1';
        $this->Mhojatrabajo->update_x($datHT);
        $this->insertarEvento($this->input->post('placa'), "idUsuario: " . $this->session->userdata('IdUsuario'), "f", "1", "Acción de usuario: Transacción exitosa|X|" . $this->input->post('ocasion') . "|1|Estado cambiado por el usuario de APROBADO SIN FIRMAR a APROBADO SIN CONSECUTIVO");
    }

    public function CGVrechaSinConsecutivo() {
        $data = $this->cargar2($this->input->post('dato'));
        $this->load->view('oficina/gestion/VGVrechaSinConsecutivo', $data);
    }

    public function CGVrechaEnvioAnulacion() {
        $datHT['idhojapruebas'] = $this->input->post('idhojapruebas');
        $datHT['estadototal'] = '1';
        $datHT['sicov'] = '0';
        $this->Mhojatrabajo->update_x($datHT);
        $this->insertarEvento($this->input->post('placa'), "idUsuario: " . $this->session->userdata('IdUsuario'), "r", "1", "Acción de usuario: Transacción exitosa|X|" . $this->input->post('ocasion') . "|1|Estado cambiado por el usuario de RECHAZADO SIN CONSECUTIVO a RECHAZADO SIN FIRMAR");
    }

    public function CGVaproSinConsecutivo() {
        $data = $this->cargar2($this->input->post('dato'));
        $this->load->view('oficina/gestion/VGVaproSinConsecutivo', $data);
    }

    public function CGVaproEnvioAnulacion() {
        $datHT['idhojapruebas'] = $this->input->post('idhojapruebas');
        $datHT['estadototal'] = '1';
        $datHT['sicov'] = '0';
        $this->Mhojatrabajo->update_x($datHT);
        $this->insertarEvento($this->input->post('placa'), "idUsuario: " . $this->session->userdata('IdUsuario'), "r", "1", "Acción de usuario: Transacción exitosa|X|" . $this->input->post('ocasion') . "|1|Estado cambiado por el usuario de APROBADO SIN CONSECUTIVO a APROBADO SIN FIRMAR");
    }

    private function cargar($dato) {
        $datos = explode('-', $dato);
        if ($datos[1] == '0' || $datos[1] == '4444' || $datos[1] == '8888') {
            $ocacion = 'PRIMERA VEZ';
        } else {
            $ocacion = 'SEGUNDA VEZ';
        }
        $data['dato'] = $dato;
        $data['vehiculo'] = $this->MGPrueba->getVehiculoEnPista($datos[0]);
//        $data['vehiculo'] = $this->MGPrueba->getVehiculoEnPista($datos);
        $data['rechazadas'] = $this->MGPrueba->pruebasRechazadas($data['vehiculo']->numero_placa);
        $data['ocacion'] = $ocacion;
        $data['idhojapruebas'] = $datos[0];
        $data['reinspeccion'] = $datos[1];
        $data['placa'] = $data['vehiculo']->numero_placa;
        $data['mensajeExito'] = "";
        $data['jefePista'] = $this->getJefePista('182');
        $data['jefesPista'] = $this->getJefesdePista();
        return $data;
    }

    private function cargar2($dato) {
        $datos = explode('-', $dato);
        if ($datos[1] == '0' || $datos[1] == '4444' || $datos[1] == '8888') {
            $ocacion = 'PRIMERA VEZ';
        } else {
            $ocacion = 'SEGUNDA VEZ';
        }
        $data['dato'] = $dato;
        $data['vehiculo'] = $this->MGPrueba->getVehiculoEnPista($datos[0]);
        $data['ocacion'] = $ocacion;
        $data['idhojapruebas'] = $datos[0];
        $data['reinspeccion'] = $datos[1];
        $data['placa'] = $data['vehiculo']->numero_placa;
        return $data;
    }

    private function insertarEvento($idelemento, $cadena, $tipo, $enviado, $respuesta) {
        $data['idelemento'] = $idelemento;
        $data['cadena'] = $cadena;
        $data['tipo'] = $tipo;
        $data['enviado'] = $enviado;
        $data['respuesta'] = $respuesta;
        $this->MEventosindra->insert($data);
    }

    private function getJefePista($idCP) {
        $data['idconfig_prueba'] = $idCP;
        $result = $this->Mconfig_prueba->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            return '';
        }
    }

    private function getJefesdePista() {
        $result = $this->Musuarios->getXperfil('3');
        if ($result->num_rows() > 0) {
            return $result;
        } else {
            return '';
        }
    }

    public function setJefePista() {
        $jefe = $this->input->post('jefepista');
        $datHT['jefelinea'] = $jefe;
        $datHT['idhojapruebas'] = $this->input->post('idhojapruebas');
        $this->Mhojatrabajo->update_JefePista($datHT);
        $datCP['valor'] = $jefe;
        $datCP['idconfig_prueba'] = '182';
        $this->Mconfig_prueba->update($datCP);
    }

    public function actualizarEnvioSicov() {
        $datHT['idhojapruebas'] = $this->input->post('idhojapruebas');
        $datHT['sicov'] = '1';
        $this->Mhojatrabajo->update_($datHT);
    }

    public function Cllamar() {
        $dato = explode('-', $this->input->post('dato'));
        $llamar = $this->input->post('llamar');
        $datHT['llamar'] = $llamar;
        $datHT['idhojapruebas'] = $dato[0];
        $this->Mhojatrabajo->update_llamar($datHT);
        redirect('/oficina/Cgestion');
    }

    public function guardarConsecutivoAprobado() {
        $data['idhojapruebas'] = $this->input->post('idhojapruebas');
        $data['numero_certificado'] = $this->input->post('consecutivorunt');
        $data['fechaimpresion'] = $this->Mutilitarios->getNow();
        $data['fecha_vigencia'] = $this->Mutilitarios->getFechaSumY(1);
        $data['usuario'] = $this->session->userdata('IdUsuario');
        $data['estado'] = '1';
        $data['consecutivo_runt'] = $this->input->post('consecutivorunt');
        $data['consecutivo_runt_rechazado'] = '';
        $this->Mcertificados->insert($data);
    }

    public function guardarConsecutivoRechazado() {
        $data['idhojapruebas'] = $this->input->post('idhojapruebas');
        $data['numero_certificado'] = '';
        $data['fechaimpresion'] = $this->Mutilitarios->getNow();
        $data['fecha_vigencia'] = '0000-00-00';
        $data['usuario'] = $this->session->userdata('IdUsuario');
        $data['estado'] = '2';
        $data['consecutivo_runt'] = '';
        $data['consecutivo_runt_rechazado'] = $this->input->post('consecutivorunt');
        $this->Mcertificados->insert($data);
    }

    public function guardarPresion() {
        $id = $this->input->post('id');
        $numero_placa_ref = $this->input->post('numero_placa_ref');
        $reinspeccion = $this->input->post('reinspeccion');
        $tipo_inspeccion = $this->input->post('tipo_inspeccion');
        $valor = $this->input->post('valor');
        $pre_prerevision['numero_placa_ref'] = $numero_placa_ref;
        $pre_prerevision['reinspeccion'] = $reinspeccion;
        $pre_prerevision['tipo_inspeccion'] = $tipo_inspeccion;
        $idpre_prerevision = $this->Mpre_prerevision->getXidPre($pre_prerevision);
        $pre_atributo['id'] = $id;
        $idpre_atributo = $this->Mpre_atributo->getXid($pre_atributo);
        $rta_pre = $idpre_atributo->result();
        $pre_dato['idpre_atributo'] = $rta_pre[0]->idpre_atributo;
        $pre_dato['idpre_zona'] = '0';
        $pre_dato['idpre_prerevision'] = $idpre_prerevision;
        $pre_dato['valor'] = $valor;
        $this->Mpre_dato->guardar($pre_dato);
    }

    private function getPresiones($placa, $reinspeccion, $fecha, $tipo) {
        $data['numero_placa_ref'] = $placa;
        $data['reinspeccion'] = $reinspeccion;
        $data['tipo_inspeccion'] = $tipo;
        $data['fecha_prerevision'] = $fecha;
        $dat_pre = $this->Mpre_prerevision->getDatos($data);
        if ($dat_pre) {
            foreach ($dat_pre->result() as $d) {
                switch ($d->id) {
                    case 'llanta-1-1-a':
                        $this->llanta_1_D = $d->valor;
                        break;
                    case 'llanta-2-1-a':
                        $this->llanta_2_DE = $d->valor;
                        break;
                    case 'llanta-1-D-a':
                        $this->llanta_1_D = $d->valor;
                        break;
                    case 'llanta-1-D-a':
                        $this->llanta_1_D = $d->valor;
                        break;
                    case 'llanta-1-I-a':
                        $this->llanta_1_I = $d->valor;
                        break;
                    case 'llanta-2-D-a':
                        $this->llanta_2_DE = $d->valor;
                        break;
                    case 'llanta-2-I-a':
                        $this->llanta_2_IE = $d->valor;
                        break;
                    case 'llanta-R-a':
                        $this->llanta_R = $d->valor;
                        break;
                    case 'llanta-2-DI-a':
                        $this->llanta_2_DI = $d->valor;
                        break;
                    case 'llanta-2-II-a':
                        $this->llanta_2_II = $d->valor;
                        break;
                    case 'llanta-2-DE-a':
                        $this->llanta_2_DE = $d->valor;
                        break;
                    case 'llanta-2-IE-a':
                        $this->llanta_2_IE = $d->valor;
                        break;
                    case 'llanta-3-DI-a':
                        $this->llanta_3_DI = $d->valor;
                        break;
                    case 'llanta-3-II-a':
                        $this->llanta_3_II = $d->valor;
                        break;
                    case 'llanta-3-DE-a':
                        $this->llanta_3_DE = $d->valor;
                        break;
                    case 'llanta-3-IE-a':
                        $this->llanta_3_IE = $d->valor;
                        break;
                    case 'llanta-4-DI-a':
                        $this->llanta_4_DI = $d->valor;
                        break;
                    case 'llanta-4-II-a':
                        $this->llanta_4_II = $d->valor;
                        break;
                    case 'llanta-4-DE-a':
                        $this->llanta_4_DE = $d->valor;
                        break;
                    case 'llanta-4-IE-a':
                        $this->llanta_4_IE = $d->valor;
                        break;
                    case 'llanta-5-DI-a':
                        $this->llanta_5_DI = $d->valor;
                        break;
                    case 'llanta-5-II-a':
                        $this->llanta_5_II = $d->valor;
                        break;
                    case 'llanta-5-DE-a':
                        $this->llanta_5_DE = $d->valor;
                        break;
                    case 'llanta-5-IE-a':
                        $this->llanta_5_IE = $d->valor;
                        break;
                    default:
                        break;
                }
            }
        }
        $presiones = (object)
                array(
                    'llanta_1_I' => $this->llanta_1_I,
                    'llanta_1_D' => $this->llanta_1_D,
                    'llanta_2_IE' => $this->llanta_2_IE,
                    'llanta_2_DE' => $this->llanta_2_DE,
                    'llanta_2_II' => $this->llanta_2_II,
                    'llanta_2_DI' => $this->llanta_2_DI,
                    'llanta_3_II' => $this->llanta_3_II,
                    'llanta_3_IE' => $this->llanta_3_IE,
                    'llanta_3_DI' => $this->llanta_3_DI,
                    'llanta_3_DE' => $this->llanta_3_DE,
                    'llanta_4_II' => $this->llanta_4_II,
                    'llanta_4_IE' => $this->llanta_4_IE,
                    'llanta_4_DI' => $this->llanta_4_DI,
                    'llanta_4_DE' => $this->llanta_4_DE,
                    'llanta_5_II' => $this->llanta_5_II,
                    'llanta_5_IE' => $this->llanta_5_IE,
                    'llanta_5_DI' => $this->llanta_5_DI,
                    'llanta_5_DE' => $this->llanta_5_DE,
                    'llanta_R' => $this->llanta_R,
                    'llanta_R2' => $this->llanta_R2
        );
        return $presiones;
    }

    //---------------------------------------INTEGRACION 20210320 BRAYAN LEON    
    function getPruebas() {
        $idhojapruebas = $this->input->post('idhojapruebas');
        $reinspeccion = $this->input->post('reinspeccion');
        switch ($reinspeccion) {
            case 0:
            case 4444:
            case 8888:
                $rta = $this->MGPrueba->getPruebasprimera($idhojapruebas);
                echo json_encode($rta);
                break;
            case 1:
            case 44441:
                $rta = $this->MGPrueba->getPruebassegunda($idhojapruebas);
                echo json_encode($rta);
                break;
            default:
                break;
        }
    }

    function getPruebasvisual() {
        $idhojapruebas = $this->input->post('idhojapruebas');
        $reinspeccion = $this->input->post('reinspeccion');
        switch ($reinspeccion) {
            case 0:
            case 4444:
            case 8888:
                $rta = $this->MGPrueba->getPruebasVisualprimera($idhojapruebas);
                echo json_encode($rta);
                break;
            case 1:
            case 44441:
                $rta = $this->MGPrueba->getPruebasVisualsegunda($idhojapruebas);
                echo json_encode($rta);
                break;
            default:
                break;
        }
    }

    function getCreateCaptador() {
        $idhojapruebas = $this->input->post('idhojapruebas');
        $fechainicial = $this->input->post('fechainicial');
        $rta = $this->MGPrueba->getCreateCaptador($idhojapruebas, $fechainicial);
        echo json_encode($rta);
    }

    function updateVisual() {
        $idhojapruebas = $this->input->post('idhojapruebas');
        $idvisual = $this->input->post('idvisual');
        $rtah = $this->MGPrueba->updateHojatrabajo($idhojapruebas);
        $rtav = $this->MGPrueba->updateVisual($idhojapruebas, $idvisual);
        if ($rtah == 1 && $rtav == 1) {
            $rta = 1;
            echo json_encode($rta);
        }
    }

    function updatePruebasVisual() {
        $idhojapruebas = $this->input->post('idhojapruebas');
        $idtipoprueba = $this->input->post('idtipoprueba');
        $idtipo_prueba = $this->input->post('idtipo_prueba');
        switch ($idtipo_prueba) {
            case 21:
            case 22:
                $rta = $this->MGPrueba->deletePerifericos($idhojapruebas, $idtipoprueba);
                echo json_encode($rta);
                break;
            default:
                $rta = $this->MGPrueba->updatePruebasVisual($idhojapruebas, $idtipoprueba);
                echo json_encode($rta);
                break;
        }
    }

    function updatePruebas() {
        $idhojapruebas = $this->input->post('idhojapruebas');
        $idtipoprueba = $this->input->post('idprueba');
        $idtipo_prueba = $this->input->post('idtipo_prueba');
        $rtah = $this->MGPrueba->updateHojatrabajo($idhojapruebas);
        $rtapru = $this->MGPrueba->updatePruebas($idhojapruebas, $idtipoprueba, $idtipo_prueba);
        if ($rtah == 1 && $rtapru == 1) {
            $rta = 1;
            echo json_encode($rta);
        }
    }

    //-------------------------------------------------------- fin de reasignacion individual------------------------------------------//
    public function Vpin_estado() {
        //        $placa = 'CQZ501';
        //        $data = $this->MGPrueba->getPlaca($placa);
        //        $rta['placa'] = $data->result();
        $this->load->view('oficina/configprueba/Vcambiarpinyestado', $rta);
    }

    function updateEstadoPin() {
        $estado = $this->input->post('estado');
        $pin = $this->input->post('pin');
        $idhojapruebas = $this->input->post('idhojapruebas');
        if ($estado <> 0) {
            $rta = $this->MGPrueba->getHojatrabajoPin($estado, $pin, $idhojapruebas);
            echo json_encode('El estado y pin fueron actualizados.');
        } else {
            $rta = $this->MGPrueba->getHojatrabajoPinEstado($pin, $idhojapruebas);
            echo json_encode('El pin fue actualizado.');
        }
    }

    //-------------------------------------------------------- fin de actualizacion estado y pin ------------------------------------------//
    function reConfvehiculosPruebas() {
        $selectrecofprueba = $this->input->post('selectrecofprueba');
        $idhojapruebas = $this->input->post('idhojapruebas');
        $pfechainicial = $this->input->post('pfechainicial');
        $servicio = $this->input->post('servicio');
        $combustible = $this->input->post('combustible');
        $tipovehiculo = $this->input->post('tipovehiculo');
        $placa = $this->input->post('placa');
        switch ($selectrecofprueba) {
            case 1:
                $servicio = 2;
                $rtah = $this->MGPrueba->Createtaximetro($idhojapruebas, $pfechainicial);
                $rtav = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtah == 1 && $rtav == 1) {
                    echo json_encode('Se asigno la prueba taxímetro y se modifico el servicio a público.');
                }
                break;
            case 2:
                $servicio = 3;
                $rtah = $this->MGPrueba->deleteTaximetro($idhojapruebas);
                $rtav = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtah == 1 && $rtav == 1) {
                    echo json_encode('Se elimino la prueba taxímetro y se modifico el servicio a particular.');
                }
                break;
            case 3:
                $rtah = $this->MGPrueba->livianoapesado($idhojapruebas, $pfechainicial);
                $combustible = 1;
                $tipovehiculo = 2;
                $rtav = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtah == 1 && $rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de liviano a pesado.');
                }
                break;
            case 4:
                $rtah = $this->MGPrueba->pesadoliviano($idhojapruebas, $pfechainicial);
                $combustible = 2;
                $tipovehiculo = 1;
                $rtav = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtah == 1 && $rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de pesado a liviano.');
                }
                break;
            case 5:
                $rtah = $this->MGPrueba->motoLiviano($idhojapruebas, $pfechainicial);
                $tipovehiculo = 1;
                $rtav = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtah == 1 && $rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de moto a liviano.');
                }
                break;
            case 6:
                $rtah = $this->MGPrueba->livianoMoto($idhojapruebas, $pfechainicial);
                $tipovehiculo = 3;
                $rtav = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtah == 1 && $rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de liviano a moto.');
                }
                break;
            case 7:
                $rtah = $this->MGPrueba->pesadoMoto($idhojapruebas, $pfechainicial);
                $combustible = 2;
                $tipovehiculo = 3;
                $rtav = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtah == 1 && $rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de pesado a moto.');
                }
                break;
            case 8:
                $rtah = $this->MGPrueba->motoPesado($idhojapruebas, $pfechainicial);
                $combustible = 1;
                $tipovehiculo = 2;
                $rtav = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtah == 1 && $rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de moto a pesado.');
                }
                break;
            case 9:
                //Particular a pÃºblico
                $servicio = 2;
                $rtav = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de particular a público.');
                }
                break;
            case 10:
                //PÃºblico a prarticula
                $servicio = 3;
                $rtav = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                if ($rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de público a particular.');
                }
                break;
            case 11:
                //gasolina a disel
                $combustible = 1;
                $rtav = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                $this->MGPrueba->AsignarDisel($idhojapruebas);
                if ($rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de gasolina a disel.');
                }
                break;
            case 12:
                //disel a gasolina
                $combustible = 2;
                $rtav = $this->MGPrueba->Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo);
                $this->MGPrueba->AsignarGasolina($idhojapruebas);
                if ($rtav == 1) {
                    echo json_encode('Se reconfiguro la prueba de disel a gasolina.');
                }
                break;
            default:
                //asignar sonometro
                $rtah = $this->MGPrueba->asignarSonometro($idhojapruebas, $pfechainicial);
                if ($rtah == 1) {
                    echo json_encode('Se asigno la prueba de sonometria.');
                }
                break;
        }
    }

    //-------------------------------------------------------- fin de reconfiguracion de pruebas ------------------------------------------//
    function cancelarPruebas() {
        $idhojapruebas = $this->input->post('idhojapruebas');
        $reinspeccion = $this->input->post('reinspeccion');
        $rta = $this->MGPrueba->cancelarPruebas($idhojapruebas, $reinspeccion);
        if ($rta == 1) {
            echo json_encode('La prueba se cancelo.');
        }
    }

    //-------------------------------------------------------- fin cancelacion de pruebas ------------------------------------------//
    public function registroentrada() {
        $this->load->view('oficina/gestion/Vregistroentrada');
    }

    function registroentradaselect() {
        $fechainicial = $this->input->post('fechainicial');
        $fechafinal = $this->input->post('fechafinal');
        $idseleccion = $this->input->post('idseleccion');
        $tip = '';
        $where = '';
        if (strval($idseleccion)  !== "" || $idseleccion !== null ) {
            $tip = "pp.tipo_inspeccion = " . $idseleccion . " AND ";
        }
        if ($fechainicial !== "" && $fechafinal !== "") {
            $where = "DATE_FORMAT(pp.fecha_prerevision,'%Y-%m-%d') BETWEEN '$fechainicial' AND '$fechafinal'";
        } else {
            $where = "DATE_FORMAT(pp.fecha_prerevision,'%Y-%m-%d')=DATE_FORMAT(NOW(),'%Y-%m-%d')";
        }
        $w = $tip . $where;
        $rta = $this->MGPrueba->registroentrada($w);
        echo json_encode($rta);
    }

    function download() {
        $query = $this->MGPrueba->registroentrada();
        $filename = 'Informe registro entrada.csv';
        $delimiter = ";";
        $newline = "\r\n";
        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        force_download($filename, $data);
    }

    private function error($mensaje) {
        $this->session->set_flashdata('error', $mensaje);
    }

}
