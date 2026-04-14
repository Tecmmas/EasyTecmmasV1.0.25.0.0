<?php

defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
ini_set('memory_limit', '-1');
ini_set('soap.wsdl_cache_enabled', 0);
ini_set('soap.wsdl_cache_ttl', 0);
set_time_limit(1000);

class Cpruebas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("oficina/pruebas/MPruebas");
        $this->load->model("dominio/Mhojatrabajo");
        $this->load->model("dominio/MconsecutivoTC");
        $this->load->model("dominio/Mprueba");
        $this->load->model("dominio/Mvehiculo");
        $this->load->model("Mutilitarios");
        $this->load->model("dominio/MEventosindra");
        $this->load->model("oficina/reportes/Mambientales");
        $this->load->model("Mprerevision");
        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
    }

    public $juez             = "0";
    public $CARinformeActivo = '0';
    public $ipCAR            = '0';

    public function index()
    {
        if ($this->session->userdata('IdUsuario') == '' || $this->session->userdata('IdUsuario') == '1024') {
            redirect('Cindex');
        }
        $encrptopenssl = new Opensslencryptdecrypt();
        $json          = $encrptopenssl->decrypt(file_get_contents('system/oficina.json', true), true);
        $ofc           = json_decode($json, true);
        foreach ($ofc as $d) {
            $data[$d['nombre']] = $d['valor'];
            if ($d['nombre'] == 'juez') {
                $this->juez = $d['valor'];
            }
            if ($d['nombre'] == "idCdaRUNT") {
                $data['idCdaRUNT'] = $d['valor'];
            }
        }
        if ($this->juez == "1") {
            $resTh       = $this->MPruebas->getEvalTH();
            $r           = $resTh->result();
            $data['eTh'] = $r[0]->res;
        } else {
            $data['eTh'] = "0";
        }
        // $this->consultarPinCI2();
        // $this->consultarPinPlacaCI2();

        $this->load->view('oficina/pruebas/Vpruebas', $data);
    }

    private function setConf()
    {
        $conf = @file_get_contents("system/oficina.json");
        if (isset($conf)) {
            $encrptopenssl = new Opensslencryptdecrypt();
            $json          = $encrptopenssl->decrypt($conf, true);
            $dat           = json_decode($json, true);
            if ($dat) {
                foreach ($dat as $d) {
                    if ($d['nombre'] == "CARinformeActivo") {
                        $this->CARinformeActivo = $d['valor'];
                    }
                    if ($d['nombre'] == "ipCAR") {
                        $this->ipCAR = $d['valor'];
                    }
                }
            }
        }
    }

    public function gestionar()
    {
        if ($this->input->post('button') == 'Consultar') {
            $this->consultar(trim($this->input->post('placa')));
        }
    }

    public function getNumFactura()
    {
        $factura = $this->MPruebas->getUltimaFactura();
        echo intval($factura + 1);
    }

    public function consultar()
    {
        $vehiculos = $this->MPruebas->consultarPlaca($this->input->post('placa'));
        $filas     = "";
        if ($vehiculos->num_rows() > 0) {
            foreach ($vehiculos->result() as $v) {
//                var_dump($v);
                $numero_placa     = $v->numero_placa;
                $tipo             = $v->tipo_vehiculo;
                $clase            = $v->clase;
                $tipo_combustible = $v->tipo_combustible;
//                $aplicaRes2703 = $v->aplicaRes2703;
                //                $autoregulado = $v->autoregulado;
                $RTEMec     = "";
                $preventiva = "";
                if ($v->RTEMecReins == '0') {
                    $RTEMec = "<input type='button' id='rtmec-$numero_placa'  title='$numero_placa' value='Primera vez' class='btn bot_azul btn-block' onclick='asignarRTMec1ra(this)'  data-toggle='modal' data-target='#RTmecModal'/>";
                } elseif ($v->RTEMecReins == '2') {
                    $RTEMec = "<label style='color: brown;font-size: 20px'><strong>EN INSPECCIÓN</strong></label>";
                } else {
                    $RTEMec = "<input type='button'  title='$numero_placa' id='$v->RTEMecReins' value='Segunda vez' class='btn bot_rojo btn-block' onclick='asignarRTMec2da(this.title,this.id)' data-toggle='modal' data-target='#RTmecModal'/>";
                }
                if ($v->PreventivaReins == '0') {
                    $preventiva = "<input type='button'  title='$numero_placa' value='Primera vez' class='btn bot_verde btn-block' onclick='asignarPreventiva1ra(this)' data-toggle='modal' data-target='#RTmecModal'/>";
                } elseif ($v->PreventivaReins == '2') {
                    $preventiva = "<label style='color:  brown;font-size: 20px'><strong>EN INSPECCIÓN</strong></label>";
                } else {
                    $preventiva = "<input type='button'  title='$numero_placa' id='$v->PreventivaReins' value='Segunda vez' class='btn bot_rojo btn-block' onclick='asignarPreventiva2da(this.title,this.id)' data-toggle='modal' data-target='#RTmecModal'//>";
                }

                if ($v->PruebaLibreReins == '0') {
                    $libre = "<input type='button' id='libre-$numero_placa' title='$numero_placa' value='Prueba libre' class='btn bot_oro btn-block' onclick='asignarPruebaLibre(this)' data-toggle='modal' data-target='#RTmecModal'/>";
                } else {
                    $libre = "<label style='color:  brown;font-size: 20px'><strong>EN INSPECCIÓN</strong></label>";
                }

                $filas = $filas . "<tr>";
                $filas = $filas . "<td align='center' style='font-size:25px'><strong>$numero_placa</strong></td>";
                $filas = $filas . "<td align='center'>$tipo</td>";
                $filas = $filas . "<td align='center'>$clase</td>";
                $filas = $filas . "<td align='center'>$tipo_combustible</td>";
                $filas = $filas . "<td align='center'>$RTEMec</td>";
                $filas = $filas . "<td align='center'>$preventiva</td>";
                $filas = $filas . "<td align='center'>$libre</td>";
                $filas = $filas . "</tr>";
            }
        }
        echo "$filas";
    }

    public function asignarRTMec1ra()
    {
        $r        = $this->MPruebas->consultarPlaca($this->input->post('numero_placa'));
        $rta      = $r->result();
        $vehiculo = $rta[0];
        echo json_encode($vehiculo);
    }

    public function asignarRTMec2da()
    {
        $r                = $this->MPruebas->consultarPlaca($this->input->post('numero_placa'));
        $rta              = $r->result();
        $vehiculo         = $rta[0];
        $rp               = $this->MPruebas->getPruebas($this->input->post('idhojapruebas'));
        $rtap             = $rp->result();
        $pruebas          = $rtap;
        $dato['vehiculo'] = $vehiculo;
        $dato['pruebas']  = $pruebas;
        echo json_encode($dato);
    }

    public function validarPrerevision()
    {
        $num = $this->MPruebas->validarPrerevision($this->input->post('numero_placa'));
        if ($num === 0) {
            echo '0';
        } else {
            echo '1';
        }
    }

    public function validarFactura()
    {
        $num = $this->MPruebas->validarFactura($this->input->post('noFactura'));
        if ($num === 0) {
            echo '0';
        } else {
            echo '1';
        }
    }

    public function insertarPruebas()
    {
        $this->setConf();
//        echo $this->session->userdata('IdUsuario');
        if ($this->session->userdata('IdUsuario') !== null && $this->session->userdata('IdUsuario') !== "" && ! is_null($this->session->userdata('IdUsuario'))) {
            $ahora                       = $this->Mutilitarios->getNow();
            $datos                       = $this->input->post('pruebas');
            $hojatrabajo['idvehiculo']   = $datos['idvehiculo'];
            $hojatrabajo['reinspeccion'] = $datos['reinspeccion'];
            if ($datos['reinspeccion'] == '1') {
                $hojatrabajo['llamar'] = '0';
            }
            $hojatrabajo['estadototal'] = '1';
            $hojatrabajo['usuario']     = $this->session->userdata('IdUsuario');
            $hojatrabajo['sicov']       = '0';
            $this->Mvehiculo->actualizarAplicaRes2703($this->input->post('aplicares2703'),
                $this->input->post('numero_placa'));
            $this->Mvehiculo->actualizarAutoregulado($this->input->post('autoregulado'),
                $this->input->post('numero_placa'));
//        if ($hojatrabajo['reinspeccion'] == '0' || $hojatrabajo['reinspeccion'] == '1') {
            $r        = $this->Mvehiculo->getXplacaLite($this->input->post('numero_placa'));
            $rta      = $r->result();
            $vehiculo = $rta[0];
            $rtaPre   = $this->Mvehiculo->BuscarPrerevision($vehiculo->numero_placa, $hojatrabajo['reinspeccion']);
            if ($rtaPre->num_rows() == 0) {
                $pr                                      = $this->Mvehiculo->insertarPrerevision($this->input->post('numero_placa'), $hojatrabajo['reinspeccion']);
                $histoVehiculo['histo_servicio']         = $vehiculo->idservicio;
                $histoVehiculo['histo_propietario']      = $vehiculo->idpropietarios;
                $histoVehiculo['histo_licencia']         = $vehiculo->numero_tarjeta_propiedad;
                $histoVehiculo['histo_color']            = $vehiculo->idcolor;
                $histoVehiculo['histo_combustible']      = $vehiculo->idtipocombustible;
                $histoVehiculo['histo_kilometraje']      = $vehiculo->kilometraje;
                $histoVehiculo['histo_blindaje']         = $vehiculo->blindaje;
                $histoVehiculo['histo_polarizado']       = $vehiculo->polarizado;
                $histoVehiculo['usuario_registro']       = $vehiculo->usuario;
                $histoVehiculo['histo_cliente']          = $vehiculo->idcliente;
                $histoVehiculo['numero_certificado_gas'] = $vehiculo->chk_3;
                $histoVehiculo['fecha_final_certgas']    = $vehiculo->fecha_final_certgas;
                $histoVehiculo['fecha_vencimiento_soat'] = $vehiculo->fecha_vencimiento_soat;
                $histoVehiculo['nombre_empresa']         = $vehiculo->nombre_empresa;
                $histoVehiculo['idpre_prerevision']      = $pr['idpre_prerevision'];
                $histoVehiculo['tipo_inspeccion']        = $pr['tipo_inspeccion'];
                $histoVehiculo['reinspeccion']           = $pr['reinspeccion'];
                $this->Mprerevision->guardarHistoVehiculo($histoVehiculo);
                // $this->Mvehiculo->insertPreDato($idpre_prerevision, $this->Mvehiculo->BuscarPreAtributo('histo_propietario'), $vehiculo->idpropietarios);
                // $this->Mvehiculo->insertPreDato($idpre_prerevision, $this->Mvehiculo->BuscarPreAtributo('histo_servicio'), $vehiculo->idservicio);
                // $this->Mvehiculo->insertPreDato($idpre_prerevision, $this->Mvehiculo->BuscarPreAtributo('histo_licencia'), $vehiculo->numero_tarjeta_propiedad);
                // $this->Mvehiculo->insertPreDato($idpre_prerevision, $this->Mvehiculo->BuscarPreAtributo('histo_color'), $vehiculo->idcolor);
                // $this->Mvehiculo->insertPreDato($idpre_prerevision, $this->Mvehiculo->BuscarPreAtributo('histo_combustible'), $vehiculo->idtipocombustible);
                // $this->Mvehiculo->insertPreDato($idpre_prerevision, $this->Mvehiculo->BuscarPreAtributo('histo_kilometraje'), $vehiculo->kilometraje);
                // $this->Mvehiculo->insertPreDato($idpre_prerevision, $this->Mvehiculo->BuscarPreAtributo('histo_blindaje'), $vehiculo->blindaje);
                // $this->Mvehiculo->insertPreDato($idpre_prerevision, $this->Mvehiculo->BuscarPreAtributo('histo_polarizado'), $vehiculo->polarizado);
                // $this->Mvehiculo->insertPreDato($idpre_prerevision, $this->Mvehiculo->BuscarPreAtributo('usuario_registro'), $vehiculo->usuario);
                // $this->Mvehiculo->insertPreDato($idpre_prerevision, $this->Mvehiculo->BuscarPreAtributo('histo_cliente'), $vehiculo->idcliente);
                // $this->Mvehiculo->insertPreDato($idpre_prerevision, $this->Mvehiculo->BuscarPreAtributo('chk-3'), $vehiculo->chk_3);
                // $this->Mvehiculo->insertPreDato($idpre_prerevision, $this->Mvehiculo->BuscarPreAtributo('fecha_final_certgas'), $vehiculo->fecha_final_certgas);
                // $this->Mvehiculo->insertPreDato($idpre_prerevision, $this->Mvehiculo->BuscarPreAtributo('fecha_vencimiento_soat'), $vehiculo->fecha_vencimiento_soat);
                // $this->Mvehiculo->insertPreDato($idpre_prerevision, $this->Mvehiculo->BuscarPreAtributo('nombre_empresa'), $vehiculo->nombre_empresa);
            }
//        }

            if ($datos['idhojapruebas'] == '') {
                $hojatrabajo['pin0']         = $datos['pin0'];
                $hojatrabajo['factura']      = $datos['factura'];
                $hojatrabajo['fechainicial'] = $ahora;
                $hojatrabajo['pin1']         = $datos['pin1'];
                $idhojapruebas               = $this->Mhojatrabajo->insert($hojatrabajo);
                if ($hojatrabajo['reinspeccion'] == '0') {
                    $d['idhojapruebas'] = $idhojapruebas;
                    $this->MconsecutivoTC->insert($d);
                }
            } else {
                $hojatrabajo['idhojapruebas'] = $datos['idhojapruebas'];
                $idhojapruebas                = $datos['idhojapruebas'];
                $this->Mhojatrabajo->update_($hojatrabajo);
            }

            //visor

            $visor['idhojapruebas'] = $idhojapruebas;
            $visor['reinspeccion']  = $hojatrabajo['reinspeccion'];
            $visor['servicio']      = $vehiculo->idservicio;
            $visor['placa']         = $this->input->post('numero_placa');
            $visor['luces']         = "NULL";
            $visor['gases']         = "NULL";
            $visor['opacidad']      = "NULL";
            $visor['sonometro']     = "NULL";
            $visor['visual']        = "NULL";
            $visor['camara0']       = "NULL";
            $visor['camara1']       = "NULL";
            $visor['alineacion']    = "NULL";
            $visor['frenos']        = "NULL";
            $visor['suspension']    = "NULL";
            $visor['taximetro']     = "NULL";

            $prueba['idhojapruebas'] = $idhojapruebas;
            $prueba['fechainicial']  = $ahora;
            $prueba['fechafinal']    = null;
//            $prueba['idmaquina'] = NULL;
            $prueba['prueba']    = '0';
            $prueba['estado']    = '0';
            $prueba['idusuario'] = $this->session->userdata('IdUsuario');
            $res                 = "";
            if ($datos['luxometro'] == "true") {
                $visor['luces']          = "0";
                $prueba['idtipo_prueba'] = "1";
                $this->Mprueba->update($prueba);
                $this->Mprueba->insert($prueba, $this->juez);
            }
            if ($datos['opacidad'] == "true") {
                $visor['opacidad'] = "0";
                if ($this->CARinformeActivo == "1") {
                    $data = $this->Mambientales->informe_car_new_basic($idhojapruebas);
                    $res  = $this->BasicCar($data);
                }
                $prueba['idtipo_prueba'] = "2";
                $this->Mprueba->update($prueba);
                $this->Mprueba->insert($prueba, $this->juez);
            }
            if ($datos['gases'] == "true") {
                $visor['gases'] = "0";
                if ($this->CARinformeActivo == "1") {
                    $data = $this->Mambientales->informe_car_new_basic($idhojapruebas);
                    $res  = $this->BasicCar($data);
                }
                $prueba['idtipo_prueba'] = "3";
                $this->Mprueba->update($prueba);
                $this->Mprueba->insert($prueba, $this->juez);
            }
            if ($datos['sonometro'] == "true") {
                $visor['sonometro']      = "0";
                $prueba['idtipo_prueba'] = "4";
                $this->Mprueba->update($prueba);
                $this->Mprueba->insert($prueba, $this->juez);
            }
            if ($datos['camara'] == "true") {
                $visor['camara0']        = "0";
                $visor['camara1']        = "0";
                $prueba['idtipo_prueba'] = "5";
                $this->Mprueba->update_($prueba);
                $this->Mprueba->insert($prueba, $this->juez);
                $prueba['prueba'] = "1";
                $this->Mprueba->update_($prueba);
                $this->Mprueba->insert($prueba, $this->juez);
                $prueba['prueba'] = "0";
            }
            if ($datos['taximetro'] == "true") {
                $visor['taximetro']      = "0";
                $prueba['idtipo_prueba'] = "6";
                $this->Mprueba->update($prueba);
                $this->Mprueba->insert($prueba, $this->juez);
            }
            if ($datos['frenometro'] == "true") {
                $visor['frenos']         = "0";
                $prueba['idtipo_prueba'] = "7";
                $this->Mprueba->update($prueba);
                $this->Mprueba->insert($prueba, $this->juez);
            }
            if ($datos['visual'] == "true") {
                $visor['visual']         = "0";
                $prueba['idtipo_prueba'] = "8";
                $this->Mprueba->update_($prueba);
                $this->Mprueba->insert($prueba, $this->juez);
            }
            if ($datos['suspension'] == "true") {
                $visor['suspension']     = "0";
                $prueba['idtipo_prueba'] = "9";
                $this->Mprueba->update($prueba);
                $this->Mprueba->insert($prueba, $this->juez);
            }

            if ($datos['alineacion'] == "true") {
                $visor['alineacion']     = "0";
                $prueba['idtipo_prueba'] = "10";
                $this->Mprueba->update($prueba);
                $this->Mprueba->insert($prueba, $this->juez);
            }

            if ($datos['termohigrometro'] == "true") {
                $prueba['idtipo_prueba'] = "12";
                $this->Mprueba->update_($prueba);
                $this->Mprueba->insert($prueba, $this->juez);
            }
            if ($datos['profundimetro'] == "true") {
                $prueba['idtipo_prueba'] = "13";
                $this->Mprueba->update_($prueba);
                $this->Mprueba->insert($prueba, $this->juez);
            }
            if ($datos['captador'] == "true") {
                $prueba['idtipo_prueba'] = "14";
                $this->Mprueba->update_($prueba);
                $this->Mprueba->insert($prueba, $this->juez);
            }
            if ($datos['piederey'] == "true") {
                $prueba['idtipo_prueba'] = "15";
                $this->Mprueba->update_($prueba);
                $this->Mprueba->insert($prueba, $this->juez);
            }
            if ($datos['detectorholguras'] == "true") {
                $prueba['idtipo_prueba'] = "16";
                $this->Mprueba->update_($prueba);
                $this->Mprueba->insert($prueba, $this->juez);
            }
            if ($datos['elevador'] == "true") {
                $prueba['idtipo_prueba'] = "17";
                $this->Mprueba->update_($prueba);
                $this->Mprueba->insert($prueba, $this->juez);
            }
            $r_ = [
                'cadena'        => json_encode($res),
                'idhojapruebas' => $idhojapruebas,
//                'basic' => json_encode($basic),
            ];
            $this->Mprueba->insertVisor($visor);
            echo json_encode($r_);
        } else {
            echo "FALSE";
        }
    }

    public function BasicCar($data)
    {
        $this->arrayCar["dtb_nombre"]      = $data[0]->Nombre_razon_social_propietario;
        $this->arrayCar["dtb_tipodoc"]     = $data[0]->Tipo_documento;
        $this->arrayCar["dtb_numdoc"]      = $data[0]->No_documento;
        $this->arrayCar["dtb_direccion"]   = $data[0]->Direccion;
        $this->arrayCar["dtb_telefono"]    = $data[0]->Telefono_1;
        $this->arrayCar["dtb_telefono2"]   = $data[0]->Telefono_2;
        $this->arrayCar["dtb_ciudad"]      = $data[0]->Ciudad;
        $this->arrayCar["dbt_marca"]       = $data[0]->Marca;
        $this->arrayCar["dbt_tipomotor"]   = $data[0]->tipomotor;
        $this->arrayCar["dbt_linea"]       = $data[0]->Linea;
        $this->arrayCar["dbt_diseno"]      = $data[0]->Carroceria;
        $this->arrayCar["dbt_modelo"]      = $data[0]->Ano_modelo;
        $this->arrayCar["dbt_placa"]       = $data[0]->Placa;
        $this->arrayCar["dbt_cilindraje"]  = $data[0]->Cilindraje;
        $this->arrayCar["dbt_clase"]       = $data[0]->Clase;
        $this->arrayCar["dbt_servicio"]    = $data[0]->Servicio;
        $this->arrayCar["dbt_combustible"] = $data[0]->Combustible;
        $this->arrayCar["dbt_nomotor"]     = $data[0]->Numero_motor;
        $this->arrayCar["dbt_vinserie"]    = $data[0]->Numero_VIN_serie;
        $this->arrayCar["dbt_licencia"]    = $data[0]->No_licencia_transito;
        $this->arrayCar["dbt_kilometraje"] = $data[0]->Kilometraje;
        $this->arrayCar["dtb_tipov"]       = $data[0]->Kilometraje;
        $basic                             = [
            'basic' => $this->arrayCar,
        ];
        return $basic;
    }

    public function actualizarPruebaXB()
    {
        $this->Mprueba->update_B($this->input->post('idprueba'));
    }

    public function insertarPrueba()
    {
//        $data =
    }

    public function quemarPIN()
    {
        $url            = 'http://' . $this->input->post('ipSicov') . '/ci2_cda_ws/sincrofur.asmx?wsdl';
        $datos_conexion = explode(":", $this->input->post('ipSicov'));
        if ($this->input->post('sicovModoAlternativo') == '1') {
            $url            = 'http://' . $this->input->post('ipSicovAlternativo') . '/ci2_cda_ws/sincrofur.asmx?wsdl';
            $datos_conexion = explode(":", $this->input->post('ipSicovAlternativo'));
        }
        $host = $datos_conexion[0];
        if (count($datos_conexion) > 1) {
            $port = $datos_conexion[1];
        } else {
            $port = 80;
        }
        $waitTimeoutInSeconds = 2;
        error_reporting(0);
        if ($this->input->post('p_tipo_rtm') === '1') {
            $ocasion = '2';
        } else {
            $ocasion = '1';
        }
        if ($fp = fsockopen($host, $port, $errCode, $errStr, $waitTimeoutInSeconds)) {
            $client = new SoapClient($url);
            $pin    = [
                'PIN' => [
                    'usuario'    => $this->input->post('usuarioSicov'),
                    'clave'      => $this->input->post('claveSicov'),
                    'p_tipo_rtm' => $this->input->post('p_tipo_rtm'),
                    'p_pin'      => $this->input->post('p_pin'),
                    'p_placa'    => $this->input->post('p_placa'),
                ]];
            $respuesta = $client->utilizar_pin($pin);
            $rtaCP     = $respuesta->utilizar_pinResult;
//            $rtaCP = new stdClass();
            //            $rtaCP->CodigoRespuesta = '0000';
            //            $rtaCP->MensajeRespuesta = 'Transacción exitosa';
            $estado = 'exito';
            if ($rtaCP->CodigoRespuesta !== '0000') {
                $estado = 'error';
            }

            $mensaje = $this->mensajesCI2($rtaCP->CodigoRespuesta, $rtaCP->CodigoRespuesta . '|' . $this->input->post('p_tipo_rtm') . '|' . $estado . '|' . $rtaCP->MensajeRespuesta);
            $this->insertarEvento($this->input->post('p_placa'), json_encode($pin), 'p', '1', $mensaje);
        } else {
            $mensaje = $this->mensajesCI2('1000', '1000' . '|' . $ocasion . '|1|No hay conexión con sicov');
            $this->insertarEvento($this->input->post('p_placa'), '', 'p', '1', $mensaje);
        }
        if ($fp) {
            fclose($fp);
        }
        echo $mensaje;
    }

    public function verificarPIN()
    {
        $placa          = $this->input->post('placa');
        $codigoRUNT     = $this->input->post('codigoRUNT');
        $url            = 'http://' . $this->input->post('ipSicov') . '/sicov.asmx?WSDL';
        $datos_conexion = explode(":", $this->input->post('ipSicov'));
        if ($this->input->post('sicovModoAlternativo') == '1') {
            $url            = 'http://' . $this->input->post('ipSicovAlternativo') . '/sicov.asmx?WSDL';
            $datos_conexion = explode(":", $this->input->post('ipSicovAlternativo'));
        }
        $host = $datos_conexion[0];
        if (count($datos_conexion) > 1) {
            $port = $datos_conexion[1];
        } else {
            $port = 80;
        }
        $waitTimeoutInSeconds = 2;
        error_reporting(0);
        if ($fp = fsockopen($host, $port, $errCode, $errStr, $waitTimeoutInSeconds)) {
//            echo $url;
            $client = new SoapClient($url);
            $runt   = [
                'placa'      => $placa,
                'codigoRunt' => $codigoRUNT,
                'fecha'      => $this->Mutilitarios->getCurtDate(),
            ];

//            var_dump($client);

            $respuesta = $client->getInfoPin($runt);
            $respuesta = $respuesta->getInfoPinResult;
            $mensaje   = json_encode($respuesta);
            $this->insertarEvento($placa, $respuesta->codRespuesta, 'p', '1', $respuesta->msjRespuesta);
        } else {
            $mensaje = '';
            $this->insertarEvento($placa, '', 'p', '1', 'No hay conexión con sicov para verificación de PIN');
        }
        if ($fp) {
            fclose($fp);
        }
        echo $mensaje;
    }

    public function quemadoSicov()
    {
        $idelemento = $this->input->post('placa');
        $cadena     = "IdUsuario: " . $this->session->userdata('IdUsuario');
        $tipo       = "p";
        $enviado    = "1";
        $respuesta  = "Acción de usuario: Transacción exitosa|X|" . $this->input->post('reinspeccion') . "|1|El PIN ha sido quemado desde SICOV";
        $this->insertarEvento($idelemento, $cadena, $tipo, $enviado, $respuesta);
    }


    private function insertarEvento($idelemento, $cadena, $tipo, $enviado, $respuesta)
    {
        $data['idelemento'] = $idelemento;
        $data['cadena']     = $cadena;
        $data['tipo']       = $tipo;
        $data['enviado']    = $enviado;
        $data['respuesta']  = $respuesta;
        $this->MEventosindra->insert($data);
    }

    private function mensajesCI2($codigo, $detalle)
    {
        $msg = 'Código de respuesta no válido: Revise la conexión con CI2';
        switch ($codigo) {
            case '0000':
                $msg = 'Transacción exitosa|' . $detalle;
                break;
            case '1000':
                $msg = 'Transacción Fallida|' . $detalle;
                break;
            case '1001':
                $msg = 'Dato no puede ser nulo|' . $detalle;
                break;
            case '1002':
                $msg = 'Valor no válido|' . $detalle;
                break;
            case '1003':
                $msg = 'Formato no válido|' . $detalle;
                break;
            case '1004':
                $msg = 'Campo obligatorio|' . $detalle;
                break;
            case '1005':
                $msg = 'Longitud no permitida|' . $detalle;
                break;
            case '1006':
                $msg = 'Dato no existe|' . $detalle;
                break;
            case '2001':
                $msg = 'Usuario y clave no válidos|' . $detalle;
                break;
            case '2002':
                $msg = 'Usuario no permitido|' . $detalle;
                break;
            case '2003':
                $msg = 'CDA no permitido|' . $detalle;
                break;
            case '2004':
                $msg = 'Vehículo no permitido|' . $detalle;
                break;
            case '2005':
                $msg = 'PIN ANULADO|' . $detalle;
                break;
            case '2006':
                $msg = 'PIN DISPONIBLE|' . $detalle;
                break;
            case '2007':
                $msg = 'PIN UTILIZADO|' . $detalle;
                break;
            case '2008':
                $msg = 'PIN REPORTADO CON FUR|' . $detalle;
                break;
            case '2009':
                $msg = 'PIN NO VALIDO|' . $detalle;
                break;
            case '2010':
                $msg = 'Pendiente por procesar|' . $detalle;
                break;
            case '2011':
                $msg = 'La solicitud está pendiente por reportar resultado|' . $detalle;
                break;
            case '2012':
                $msg = 'Código RUNT ya está registrado|' . $detalle;
                break;
        }
        return $msg;
    }

    public function insertVisor()
    {
        $vehiculo = $this->input->post('vehiculo');
        $rta      = $this->Mprueba->insertVisor($vehiculo);
        echo json_encode($rta);
    }

}
