<?php

defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

class Cpruebas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("pruebas/Mpruebas");
        $this->load->model("Mutilitarios");
        $this->load->model("Mprerevision");
        $this->load->model("dominio/MEventosindra");
        $this->load->model("dominio/Mprueba");
        $this->load->model("dominio/Mvehiculo");
        $this->load->model("dominio/Mpre_prerevision");
        $this->load->model("dominio/Mresultado");
        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
    }
    var $sistemaOperativo = "";

    public function index()
    {
        $idtipo_prueba = $this->input->post("idtipo_prueba");
        $reinspeccion = $this->input->post("reinspeccion");
        switch ($reinspeccion) {
            case 0:
                $reinspeccion = "";
                break;
            case 1:
                $reinspeccion = "(h.reinspeccion=1 or h.reinspeccion=0) and";
                break;
            case 2:
                $reinspeccion = "(h.reinspeccion=44441 or h.reinspeccion=4444) and";
                break;
            case 3:
                $reinspeccion = "h.reinspeccion=8888 and";
                break;
        }
        $tipo_vehiculo = $this->input->post("tipo_vehiculo");
        switch ($tipo_vehiculo) {
            case 0:
                $tipo_vehiculo = "";
                break;
            case 1:
                $tipo_vehiculo = "v.tipo_vehiculo=1 and";
                break;
            case 2:
                $tipo_vehiculo = "v.tipo_vehiculo=2 and";
                break;
            case 3:
                $tipo_vehiculo = "v.tipo_vehiculo=3 and (v.idclase<>14 and v.idclase<>19) and";
                break;
            case 4:
                $tipo_vehiculo = "(v.tipo_vehiculo=3 and (v.idclase=14 or v.idclase=19)) and";
                break;
            case 5:
                $tipo_vehiculo = "(v.tipo_vehiculo=1 or v.tipo_vehiculo=2) and";
                break;
            case 6:
                $tipo_vehiculo = "(v.tipo_vehiculo=1 or (v.idclase=14 or v.idclase=19)) and";
                break;
            case 7:
                $tipo_vehiculo = "(v.tipo_vehiculo=2 or (v.idclase=14 or v.idclase=19)) and";
                break;
            case 8:
                $tipo_vehiculo = "(v.tipo_vehiculo=3 and v.idclase=30) and";
                break;
        }
        $rta = $this->Mpruebas->getPruebas($idtipo_prueba, $reinspeccion, $tipo_vehiculo);
        //$pruebas = $rta->result();
        $pruebas = array();
        foreach ($rta->result() as $prueba) {
            $src = $this->obtenerFoto($prueba->numero_placa, $prueba->idclase, $prueba->taximetro);
            switch ($prueba->idservicio) {
                case 1:
                    $prueba->color_placa = "gold";
                    $prueba->color_letra = "black";
                    break;
                case 2:
                    $prueba->color_placa = "white";
                    $prueba->color_letra = "black";
                    break;
                case 3:
                    $prueba->color_placa = "gold";
                    $prueba->color_letra = "black";
                    break;
                case 4:
                    $prueba->color_placa = "blue";
                    $prueba->color_letra = "whitesmoke";
                    break;
                case 7:
                    $prueba->color_placa = "blue";
                    $prueba->color_letra = "whitesmoke";
                    break;
            }

            $prueba->src = $src;
            array_push($pruebas, $prueba);
        }
        echo json_encode($pruebas);
    }

    public function getDia()
    {
        $dia = strval($this->Mutilitarios->getNow());
        $dia = str_replace("-", "", $dia);
        $dia = substr($dia, 0, 8);
        return $dia;
    }

    public function insertarResultado()
    {
        $resultados['idprueba'] = $this->input->post('idprueba');
        $resultados['tiporesultado'] = $this->input->post('tiporesultado');
        $resultados['valor'] = $this->input->post('valor');
        $resultados['observacion'] = $this->input->post('observacion');
        $resultados['idconfig_prueba'] = $this->input->post('idconfig_prueba');
        $this->Mpruebas->insertarResultado($resultados);
    }

    public function insertarResultados()
    {
        $resultados = $this->input->post('resultados');
        foreach ($resultados as $r) {
            $resultado['idprueba'] = $r['idprueba'];
            $resultado['tiporesultado'] = $r['tiporesultado'];
            $resultado['valor'] = $r['valor'];
            $resultado['observacion'] = $r['observacion'];
            $resultado['idconfig_prueba'] = $r['idconfig_prueba'];
            $this->Mpruebas->insertarResultado($resultado);
        }
    }

    public function insertarPeriferico()
    {
        $reinspeccion = $this->input->post('reinspeccion');
        $prueba['idhojapruebas'] = $this->input->post('idhojapruebas');
        $prueba['fechainicial'] = $this->Mprueba->getFechaInicial($prueba['idhojapruebas'], $reinspeccion);
        $prueba['fechafinal'] = $this->Mutilitarios->getNow();
        $prueba['prueba'] = 0;
        $prueba['estado'] = 2;
        $prueba['idusuario'] = $this->input->post('idusuario');
        $prueba['idmaquina'] = $this->input->post('idmaquina');
        $prueba['idtipo_prueba'] = $this->input->post('idtipo_prueba');
        $this->Mpruebas->insertarPruebaPeriferico($prueba);
    }

    public function eliminarPeriferico()
    {
        $reinspeccion = $this->input->post('reinspeccion');
        $prueba['idhojapruebas'] = $this->input->post('idhojapruebas');
        $prueba['fechainicial'] = $this->Mprueba->getFechaInicial($prueba['idhojapruebas'], $reinspeccion);
        $prueba['idtipo_prueba'] = $this->input->post('idtipo_prueba');
        $this->Mprueba->eliminarPrueba($prueba);
    }

    function eliminarPruebaID()
    {
        $prueba['idprueba'] = $this->input->post('idprueba');
        $this->Mprueba->eliminarPruebaID($prueba);
    }

    public function insertarPrueba()
    {
        $prueba['idhojapruebas'] = $this->input->post('idhojapruebas');
        $prueba['fechainicial'] = $this->input->post('fechainicial');
        $prueba['prueba'] = 0;
        $prueba['estado'] = 0;
        $prueba['idusuario'] = $this->input->post('idusuario');
        $prueba['idtipo_prueba'] = $this->input->post('idtipo_prueba');
        $this->Mpruebas->insertarPrueba($prueba);
    }

    public function insertarPruebaExosto()
    {
        $prueba['idhojapruebas'] = $this->input->post('idhojapruebas');
        $prueba['fechainicial'] = $this->input->post('fechainicial');
        $prueba['estado'] = 0;
        $prueba['idusuario'] = $this->input->post('idusuario');
        $prueba['idtipo_prueba'] = $this->input->post('idtipo_prueba');
        echo $this->Mpruebas->insertarPruebaExosto($prueba);
    }

    public function actualizarPrueba()
    {
        $usuario = $this->Mpruebas->getUsuario($this->input->post('idusuario'));

        $pruebas['idprueba'] = $this->input->post('idprueba');
        $pruebas['idusuario'] = $this->input->post('idusuario');
        $pruebas['idmaquina'] = $this->input->post('idmaquina');
        $pruebas['estado'] = $this->input->post('estado');
        $valid = true;
        $mesaje = "";
        $res = $this->Mpruebas->actualizarPruebas($pruebas);
        if ($res == 1) {
            $hojapruebas = $this->Mpruebas->getHojaPruebas($pruebas['idprueba']);
            if ($hojapruebas !== "" && $hojapruebas !== null) {
                if ($this->input->post('observacion') !== "" && $this->input->post('observacion') !== NULL) {
                    $resultado['idprueba'] = $this->input->post('idprueba');
                    $resultado['tiporesultado'] = 'Observacion Aborto';
                    $resultado['valor'] = $this->input->post('observacion');
                    $resultado['observacion'] = 'Observacion Aborto';
                    $resultado['idconfig_prueba'] = '700';
                    $res = $this->Mpruebas->insertarResultado($resultado);
                    if ($res !== 1) {
                        $valid = false;
                        $mesaje = $mesaje + "<br>Transaccion incompleta Resultados. ";
                    }
                }
                //                if ($hojapruebas->reinspeccion == '0' || $hojapruebas->reinspeccion == '1') {
//                    $auditoria_sicov['id_revision'] = $hojapruebas->idhojapruebas;
//                    $auditoria_sicov['serial_equipo_medicion'] = $this->input->post('serie');
//                    $auditoria_sicov['ip_equipo_medicion'] = $this->input->post('ip');
//                    $auditoria_sicov['fecha_registro_bd'] = $this->Mutilitarios->getNow();
//                    $auditoria_sicov['fecha_evento'] = $this->Mutilitarios->getNow();
//                    $auditoria_sicov['tipo_operacion'] = '1';
//                    $auditoria_sicov['tipo_evento'] = '2';
//                    $auditoria_sicov['codigo_proveedor'] = '862';
//                    $auditoria_sicov['id_runt_cda'] = $this->getCodigoRuntCDA();
//                    $auditoria_sicov['identificacion_usuario'] = $usuario->identificacion;
//                    $auditoria_sicov['observacion'] = $this->input->post('observacion');
//                    switch ($this->input->post('idtipo_prueba')) {
//                        case 1:
////                    $this->auditLuxometro($auditoria_sicov, $pruebas['idprueba']);
//                            break;
//                        case 4:
////                    $this->auditSonometro($auditoria_sicov, $pruebas['idprueba']);
//                            break;
//                        case 3:
//                            //$this->auditGases($auditoria_sicov, $pruebas['idprueba']);
//                            break;
//                        case 8:
////                            $this->auditVisual($auditoria_sicov, $pruebas['idprueba']);
//                            break;
//                    }
//                }
            } else {
                $valid = false;
                $mesaje = $mesaje + "<br>Transaccion incompleta getHojatrabajo. ";
            }
        } else {
            $valid = false;
            $mesaje = "<br> Transaccion incompleta Actualizar Pruebas. ";
        }

        if (!$valid) {
            echo $mesaje;
        } else {
            echo 1;
        }
    }

    public function actualizarPruebaGet()
    {
        $usuario = $this->Mpruebas->getUsuario($this->input->get('idusuario'));
        echo '<strong>Usuario</strong><br>';
        var_dump($usuario);
        $pruebas['idprueba'] = $this->input->get('idprueba');
        $pruebas['idusuario'] = $this->input->get('idusuario');
        $pruebas['idmaquina'] = $this->input->get('idmaquina');
        $pruebas['estado'] = $this->input->get('estado');
        echo '<strong>Pruebas</strong><br>';
        var_dump($pruebas);
        $valid = true;
        $mesaje = "";
        $res = $this->Mpruebas->actualizarPruebas($pruebas);
        echo '<strong>Respuesta</strong><br>';
        var_dump($res);
        if ($res == 1) {
            $hojapruebas = $this->Mpruebas->getHojaPruebas($pruebas['idprueba']);
            if ($hojapruebas !== "" && $hojapruebas !== null) {
                if ($this->input->get('observacion') !== "" && $this->input->get('observacion') !== NULL) {
                    $resultado['idprueba'] = $this->input->get('idprueba');
                    $resultado['tiporesultado'] = 'Observacion Aborto';
                    $resultado['valor'] = $this->input->get('observacion');
                    $resultado['observacion'] = 'Observacion Aborto';
                    $resultado['idconfig_prueba'] = '700';
                    $res = $this->Mpruebas->insertarResultado($resultado);
                    if ($res !== 1) {
                        $valid = false;
                        $mesaje = $mesaje + "<br>Transaccion incompleta Resultados. ";
                    }
                }
            } else {
                $valid = false;
                $mesaje = $mesaje + "<br>Transaccion incompleta getHojatrabajo. ";
            }
        } else {
            $valid = false;
            $mesaje = "<br> Transaccion incompleta Actualizar Pruebas. ";
        }

        if (!$valid) {
            echo $mesaje;
        } else {
            echo 1;
        }
    }

    public function eliminarResultados()
    {
        $idprueba = $this->input->post('idprueba');
        $rta = $this->Mpruebas->eliminarResultados($idprueba);
    }

    public function actualizarPruebaExosto()
    {
        $usuario = $this->Mpruebas->getUsuario($this->input->post('idusuario'));
        //        $maquina = $this->Mpruebas->getMaquina($this->input->post('serie'), $this->input->post('idtipo_prueba'));
        $pruebas['idprueba'] = $this->input->post('idprueba');
        $pruebas['idusuario'] = $this->input->post('idusuario');
        //        $pruebas['idmaquina'] = $maquina->idmaquina;
        $pruebas['idmaquina'] = $this->input->post('idmaquina');
        $pruebas['estado'] = $this->input->post('estado');
        $pruebas['prueba'] = $this->input->post('prueba');
        $this->Mpruebas->actualizarPruebasExosto($pruebas);
        $hojapruebas = $this->Mpruebas->getHojaPruebas($pruebas['idprueba']);
        if ($hojapruebas->reinspeccion == '0' || $hojapruebas->reinspeccion == '1') {
            $auditoria_sicov['id_revision'] = $hojapruebas->idhojapruebas;
            $auditoria_sicov['serial_equipo_medicion'] = $this->input->post('serie');
            $auditoria_sicov['ip_equipo_medicion'] = $this->input->post('ip');
            $auditoria_sicov['fecha_registro_bd'] = $this->Mutilitarios->getNow();
            $auditoria_sicov['fecha_evento'] = $this->Mutilitarios->getNow();
            $auditoria_sicov['tipo_operacion'] = '1';
            $auditoria_sicov['tipo_evento'] = '2';
            $auditoria_sicov['codigo_proveedor'] = '862';
            $auditoria_sicov['id_runt_cda'] = $this->getCodigoRuntCDA();
            $auditoria_sicov['identificacion_usuario'] = $usuario->identificacion;
            $auditoria_sicov['observacion'] = '';
            switch ($this->input->post('idtipo_prueba')) {
                case 1:
                    //                    $this->auditLuxometro($auditoria_sicov, $pruebas['idprueba']);
                    break;
                case 4:
                    //                    $this->auditSonometro($auditoria_sicov, $pruebas['idprueba']);
                    break;
                case 3:
                    //                    var_dump($auditoria_sicov);
//                    var_dump($pruebas);
//                    $this->auditGases($auditoria_sicov, $pruebas['idprueba']);
                    break;
            }
        }
    }

    public function actualizarPruebaVisual()
    {
        $this->setConf();
        $usuario = $this->Mpruebas->getUsuario($this->input->post('idusuario'));
        $pruebas['idprueba'] = $this->input->post('idprueba');
        $pruebas['idusuario'] = $this->input->post('idusuario');
        $pruebas['idmaquina'] = $this->input->post('idmaquina');
        $pruebas['estado'] = $this->input->post('estado');
        $placa = $this->Mvehiculo->BuscarxIdprueba($this->input->post('idprueba'));
        $this->Mpruebas->actualizarPruebas($pruebas);
        $hojapruebas = $this->Mpruebas->getHojaPruebas($pruebas['idprueba']);
        if ($hojapruebas->reinspeccion == '0' || $hojapruebas->reinspeccion == '1') {
            $auditoria_sicov['id_revision'] = $hojapruebas->idhojapruebas;
            $auditoria_sicov['serial_equipo_medicion'] = $this->input->post('serial');
            $auditoria_sicov['ip_equipo_medicion'] = NULL;
            $auditoria_sicov['fecha_registro_bd'] = $this->Mutilitarios->getNow();
            $auditoria_sicov['fecha_evento'] = $this->Mutilitarios->getNow();
            $auditoria_sicov['tipo_operacion'] = '1';
            $auditoria_sicov['tipo_evento'] = '9';
            $auditoria_sicov['codigo_proveedor'] = '862';
            $auditoria_sicov['id_runt_cda'] = $this->idCdaRUNT;
            //            $auditoria_sicov['id_runt_cda'] = $this->getCodigoRuntCDA();
            $auditoria_sicov['usuario'] = $usuario->nombres . ' ' . $usuario->apellidos;
            $auditoria_sicov['identificacion_usuario'] = $usuario->identificacion;
            $auditoria_sicov['observacion'] = '';
            $auditoria_sicov['placa'] = $placa;
            $presiones = $this->getPresiones($placa, $hojapruebas->reinspeccion, $auditoria_sicov['fecha_registro_bd'], "1");
            $labrados = $this->getLabrados($hojapruebas->idhojapruebas);
            $this->auditVisualLlantas($auditoria_sicov, $pruebas['idprueba'], $this->input->post('defectos'), $labrados, $presiones);
        }
    }

    private function auditVisualLlantas($auditoria_sicov, $idprueba, $defectos, $labrados, $presiones)
    {
        $auditoria_sicov['trama'] = <<<EOF
{"derProfundidadEje1":"$labrados->eje1_izquierdo","derProfundidadExternaEje2":"$labrados->eje2_derecho","derProfundidadExternaEje3":"$labrados->eje3_derecho","derProfundidadExternaEje4":"$labrados->eje4_derecho","derProfundidadExternaEje5":"$labrados->eje5_derecho","izqProfundidadEje1":"$labrados->eje1_derecho","izqProfundidadExternaEje2":"$labrados->eje2_izquierdo","izqProfundidadExternaEje3":"$labrados->eje3_izquierdo","izqProfundidadExternaEje4":"$labrados->eje4_izquierdo","izqProfundidadExternaEje5":"$labrados->eje5_izquierdo","derProfundidadInternaEje2":"$labrados->eje2_derecho_interior","derProfundidadInternaEje3":"$labrados->eje3_derecho_interior","derProfundidadInternaEje4":"$labrados->eje4_derecho_interior","derProfundidadInternaEje5":"$labrados->eje5_derecho_interior","izqProfundidadInternaEje2":"$labrados->eje2_izquierdo_interior","izqProfundidadInternaEje3":"$labrados->eje3_izquierdo_interior","izqProfundidadInternaEje4":"$labrados->eje4_izquierdo_interior","izqProfundidadInternaEje5":"$labrados->eje5_izquierdo_interior","repuestoProfundidad":"$labrados->repuesto","Repuesto2Profundidad":"$labrados->repuesto2","derPresionEje1":"$presiones->llanta_1_D","derPresionExternaEje2":"$presiones->llanta_2_DE","derPresionExternaEje3":"$presiones->llanta_3_DE","derPresionExternaEje4":"$presiones->llanta_4_DE","derPresionExternaEje5":"$presiones->llanta_5_DE","IzqPresionEje1":"$presiones->llanta_1_I","IzqPresionExternaEje2":"$presiones->llanta_2_IE","IzqPresionExternaEje3":"$presiones->llanta_3_IE","IzqPresionExternaEje4":"$presiones->llanta_4_IE","IzqPresionExternaEje5":"$presiones->llanta_5_IE","derPresionInternaEje2":"$presiones->llanta_2_DI","derPresionInternaEje3":"$presiones->llanta_3_DI","derPresionInternaEje4":"$presiones->llanta_4_DI","derPresionInternaEje5":"$presiones->llanta_5_DI","IzqPresionInternaEje2":"$presiones->llanta_2_II","IzqPresionInternaEje3":"$presiones->llanta_3_II","IzqPresionInternaEje4":"$presiones->llanta_4_II","IzqPresionInternaEje5":"$presiones->llanta_5_II","RepuestoPresion":"$presiones->llanta_R","Repuesto2Presion":"$presiones->llanta_R2","tablaAfectada":"resultados","idRegistro":"$idprueba"}
EOF;
        $this->Mpruebas->insertarAuditoriaSicov($auditoria_sicov);
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

    private function getPresiones($placa, $reinspeccion, $fecha, $tipo)
    {
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
                    case 'llanta-R2-a':
                        $this->llanta_R2 = $d->valor;
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
                'llanta_1_I' => $this->rdnr($this->llanta_1_I),
                'llanta_1_D' => $this->rdnr($this->llanta_1_D),
                'llanta_2_IE' => $this->rdnr($this->llanta_2_IE),
                'llanta_2_DE' => $this->rdnr($this->llanta_2_DE),
                'llanta_2_II' => $this->rdnr($this->llanta_2_II),
                'llanta_2_DI' => $this->rdnr($this->llanta_2_DI),
                'llanta_3_II' => $this->rdnr($this->llanta_3_II),
                'llanta_3_IE' => $this->rdnr($this->llanta_3_IE),
                'llanta_3_DI' => $this->rdnr($this->llanta_3_DI),
                'llanta_3_DE' => $this->rdnr($this->llanta_3_DE),
                'llanta_4_II' => $this->rdnr($this->llanta_4_II),
                'llanta_4_IE' => $this->rdnr($this->llanta_4_IE),
                'llanta_4_DI' => $this->rdnr($this->llanta_4_DI),
                'llanta_4_DE' => $this->rdnr($this->llanta_4_DE),
                'llanta_5_II' => $this->rdnr($this->llanta_5_II),
                'llanta_5_IE' => $this->rdnr($this->llanta_5_IE),
                'llanta_5_DI' => $this->rdnr($this->llanta_5_DI),
                'llanta_5_DE' => $this->rdnr($this->llanta_5_DE),
                'llanta_R' => $this->rdnr($this->llanta_R),
                'llanta_R2' => $this->rdnr($this->llanta_R2)
            );
        return $presiones;
    }

    public function getLabrados($idhojapruebas)
    {
        $data['idhojapruebas'] = $idhojapruebas;
        $data['idtipo_prueba'] = "8";
        $data['order'] = "ASC";
        $result = $this->Mprueba->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            $data['idprueba'] = $r[0]->idprueba;
            $labrados = (object) 
                array(
                    'eje1_derecho' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje1_derecho', '')),
                    'eje1_derecho1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje1_derecho1', '')),
                    'eje1_derecho2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje1_derecho2', '')),
                    'eje2_derecho' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_derecho', '')),
                    'eje2_derecho1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_derecho1', '')),
                    'eje2_derecho2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_derecho2', '')),
                    'eje3_derecho' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_derecho', '')),
                    'eje3_derecho1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_derecho1', '')),
                    'eje3_derecho2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_derecho2', '')),
                    'eje4_derecho' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_derecho', '')),
                    'eje4_derecho1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_derecho1', '')),
                    'eje4_derecho2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_derecho2', '')),
                    'eje5_derecho' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_derecho', '')),
                    'eje5_derecho1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_derecho1', '')),
                    'eje5_derecho2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_derecho2', '')),
                    'eje2_derecho_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_derecho_interior', '')),
                    'eje2_derecho1_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_derecho1_interior', '')),
                    'eje2_derecho2_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_derecho2_interior', '')),
                    'eje3_derecho_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_derecho_interior', '')),
                    'eje3_derecho1_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_derecho_1interior', '')),
                    'eje3_derecho2_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_derecho_2interior', '')),
                    'eje4_derecho_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_derecho_interior', '')),
                    'eje4_derecho1_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_derecho1_interior', '')),
                    'eje4_derecho2_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_derecho2_interior', '')),
                    'eje5_derecho_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_derecho_interior', '')),
                    'eje5_derecho1_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_derecho1_interior', '')),
                    'eje5_derecho2_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_derecho2_interior', '')),
                    'eje1_izquierdo' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje1_izquierdo', '')),
                    'eje1_izquierdo1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje1_izquierdo1', '')),
                    'eje1_izquierdo2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje1_izquierdo2', '')),
                    'eje2_izquierdo' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_izquierdo', '')),
                    'eje2_izquierdo1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_izquierdo1', '')),
                    'eje2_izquierdo2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_izquierdo2', '')),
                    'eje3_izquierdo' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_izquierdo', '')),
                    'eje3_izquierdo1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_izquierdo1', '')),
                    'eje3_izquierdo2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_izquierdo2', '')),
                    'eje4_izquierdo' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_izquierdo', '')),
                    'eje4_izquierdo1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_izquierdo1', '')),
                    'eje4_izquierdo2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_izquierdo2', '')),
                    'eje5_izquierdo' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_izquierdo', '')),
                    'eje5_izquierdo1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_izquierdo1', '')),
                    'eje5_izquierdo2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_izquierdo2', '')),
                    'eje2_izquierdo_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_izquierdo_interior', '')),
                    'eje2_izquierdo1_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_izquierdo1_interior', '')),
                    'eje2_izquierdo2_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_izquierdo2_interior', '')),
                    'eje3_izquierdo_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_izquierdo_interior', '')),
                    'eje3_izquierdo1_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_izquierdo1_interior', '')),
                    'eje3_izquierdo2_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_izquierdo2_interior', '')),
                    'eje4_izquierdo_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_izquierdo_interior', '')),
                    'eje4_izquierdo1_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_izquierdo1_interior', '')),
                    'eje4_izquierdo2_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_izquierdo2_interior', '')),
                    'eje5_izquierdo_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_izquierdo_interior', '')),
                    'eje5_izquierdo1_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_izquierdo1_interior', '')),
                    'eje5_izquierdo2_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_izquierdo2_interior', '')),
                    'repuesto' => $this->rdnr($this->getResultado($data, 'Labrado_repuesto', '')),
                    'repuesto_1' => $this->rdnr($this->getResultado($data, 'Labrado_repuesto_1', '')),
                    'repuesto_2' => $this->rdnr($this->getResultado($data, 'Labrado_repuesto_2', '')),
                    'repuesto2' => $this->rdnr($this->getResultado($data, 'Labrado_repuesto2', '')),
                    'repuesto2_1' => $this->rdnr($this->getResultado($data, 'Labrado_repuesto2_1', '')),
                    'repuesto2_2' => $this->rdnr($this->getResultado($data, 'Labrado_repuesto2_2', ''))
                );

            //            if ($this->nombreClase->nombre !== "MOTOCICLETA") {
//
//                $labrados = (object)
//                        array(
//                            'eje1_derecho' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje1_derecho', '')),
//                            'eje1_derecho1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje1_derecho1', '')),
//                            'eje1_derecho2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje1_derecho2', '')),
//                            'eje2_derecho' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_derecho', '')),
//                            'eje2_derecho1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_derecho1', '')),
//                            'eje2_derecho2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_derecho2', '')),
//                            'eje3_derecho' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_derecho', '')),
//                            'eje3_derecho1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_derecho1', '')),
//                            'eje3_derecho2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_derecho2', '')),
//                            'eje4_derecho' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_derecho', '')),
//                            'eje4_derecho1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_derecho1', '')),
//                            'eje4_derecho2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_derecho2', '')),
//                            'eje5_derecho' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_derecho', '')),
//                            'eje5_derecho1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_derecho1', '')),
//                            'eje5_derecho2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_derecho2', '')),
//                            'eje2_derecho_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_derecho_interior', '')),
//                            'eje2_derecho1_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_derecho1_interior', '')),
//                            'eje2_derecho2_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_derecho2_interior', '')),
//                            'eje3_derecho_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_derecho_interior', '')),
//                            'eje3_derecho1_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_derecho_1interior', '')),
//                            'eje3_derecho2_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_derecho_2interior', '')),
//                            'eje4_derecho_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_derecho_interior', '')),
//                            'eje4_derecho1_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_derecho1_interior', '')),
//                            'eje4_derecho2_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_derecho2_interior', '')),
//                            'eje5_derecho_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_derecho_interior', '')),
//                            'eje5_derecho1_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_derecho1_interior', '')),
//                            'eje5_derecho2_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_derecho2_interior', '')),
//                            'eje1_izquierdo' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje1_izquierdo', '')),
//                            'eje1_izquierdo1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje1_izquierdo1', '')),
//                            'eje1_izquierdo2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje1_izquierdo2', '')),
//                            'eje2_izquierdo' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_izquierdo', '')),
//                            'eje2_izquierdo1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_izquierdo1', '')),
//                            'eje2_izquierdo2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_izquierdo2', '')),
//                            'eje3_izquierdo' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_izquierdo', '')),
//                            'eje3_izquierdo1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_izquierdo1', '')),
//                            'eje3_izquierdo2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_izquierdo2', '')),
//                            'eje4_izquierdo' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_izquierdo', '')),
//                            'eje4_izquierdo1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_izquierdo1', '')),
//                            'eje4_izquierdo2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_izquierdo2', '')),
//                            'eje5_izquierdo' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_izquierdo', '')),
//                            'eje5_izquierdo1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_izquierdo1', '')),
//                            'eje5_izquierdo2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_izquierdo2', '')),
//                            'eje2_izquierdo_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_izquierdo_interior', '')),
//                            'eje2_izquierdo1_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_izquierdo1_interior', '')),
//                            'eje2_izquierdo2_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_izquierdo2_interior', '')),
//                            'eje3_izquierdo_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_izquierdo_interior', '')),
//                            'eje3_izquierdo1_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_izquierdo1_interior', '')),
//                            'eje3_izquierdo2_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_izquierdo2_interior', '')),
//                            'eje4_izquierdo_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_izquierdo_interior', '')),
//                            'eje4_izquierdo1_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_izquierdo1_interior', '')),
//                            'eje4_izquierdo2_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_izquierdo2_interior', '')),
//                            'eje5_izquierdo_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_izquierdo_interior', '')),
//                            'eje5_izquierdo1_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_izquierdo1_interior', '')),
//                            'eje5_izquierdo2_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_izquierdo2_interior', '')),
//                            'repuesto' => $this->rdnr($this->getResultado($data, 'Labrado_repuesto', '')),
//                            'repuesto_1' => $this->rdnr($this->getResultado($data, 'Labrado_repuesto_1', '')),
//                            'repuesto_2' => $this->rdnr($this->getResultado($data, 'Labrado_repuesto_2', '')),
//                            'repuesto2' => $this->rdnr($this->getResultado($data, 'Labrado_repuesto2', '')),
//                            'repuesto2_1' => $this->rdnr($this->getResultado($data, 'Labrado_repuesto2_1', '')),
//                            'repuesto2_2' => $this->rdnr($this->getResultado($data, 'Labrado_repuesto2_2', '')));
//            } else {
//                $labrados = (object)
//                        array(
//                            'eje1_derecho' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje1_derecho', '')),
//                            'eje1_derecho1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje1_derecho1', '')),
//                            'eje1_derecho2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje1_derecho2', '')),
//                            'eje2_derecho' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_derecho', '')),
//                            'eje2_derecho1' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_derecho1', '')),
//                            'eje2_derecho2' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_derecho2', '')),
//                            'eje3_derecho' => '',
//                            'eje3_derecho1' => '',
//                            'eje3_derecho2' => '',
//                            'eje4_derecho' => '',
//                            'eje4_derecho1' => '',
//                            'eje4_derecho2' => '',
//                            'eje5_derecho' => '',
//                            'eje5_derecho1' => '',
//                            'eje5_derecho2' => '',
//                            'eje2_derecho_interior' => '',
//                            'eje2_derecho1_interior' => '',
//                            'eje2_derecho2_interior' => '',
//                            'eje3_derecho_interior' => '',
//                            'eje3_derecho1_interior' => '',
//                            'eje3_derecho2_interior' => '',
//                            'eje4_derecho_interior' => '',
//                            'eje4_derecho1_interior' => '',
//                            'eje4_derecho2_interior' => '',
//                            'eje5_derecho_interior' => '',
//                            'eje5_derecho1_interior' => '',
//                            'eje5_derecho2_interior' => '',
//                            'eje1_izquierdo' => '',
//                            'eje1_izquierdo1' => '',
//                            'eje1_izquierdo2' => '',
//                            'eje2_izquierdo' => '',
//                            'eje2_izquierdo1' => '',
//                            'eje2_izquierdo2' => '',
//                            'eje3_izquierdo' => '',
//                            'eje3_izquierdo1' => '',
//                            'eje3_izquierdo2' => '',
//                            'eje4_izquierdo' => '',
//                            'eje4_izquierdo1' => '',
//                            'eje4_izquierdo2' => '',
//                            'eje5_izquierdo' => '',
//                            'eje5_izquierdo1' => '',
//                            'eje5_izquierdo2' => '',
//                            'eje2_izquierdo_interior' => '',
//                            'eje2_izquierdo1_interior' => '',
//                            'eje2_izquierdo2_interior' => '',
//                            'eje3_izquierdo_interior' => '',
//                            'eje3_izquierdo1_interior' => '',
//                            'eje3_izquierdo2_interior' => '',
//                            'eje4_izquierdo_interior' => '',
//                            'eje4_izquierdo1_interior' => '',
//                            'eje4_izquierdo2_interior' => '',
//                            'eje5_izquierdo_interior' => '',
//                            'eje5_izquierdo1_interior' => '',
//                            'eje5_izquierdo2_interior' => '',
//                            'repuesto' => '',
//                            'repuesto_1' => '',
//                            'repuesto_2' => '',
//                            'repuesto2' => '',
//                            'repuesto2_1' => '',
//                            'repuesto2_2' => '');
//            }
//        } else {
//            $labrados = (object)
//                    array(
//                        'eje1_derecho' => '',
//                        'eje1_derecho1' => '',
//                        'eje1_derecho2' => '',
//                        'eje2_derecho' => '',
//                        'eje2_derecho1' => '',
//                        'eje2_derecho2' => '',
//                        'eje3_derecho' => '',
//                        'eje3_derecho1' => '',
//                        'eje3_derecho2' => '',
//                        'eje4_derecho' => '',
//                        'eje4_derecho1' => '',
//                        'eje4_derecho2' => '',
//                        'eje5_derecho' => '',
//                        'eje5_derecho1' => '',
//                        'eje5_derecho2' => '',
//                        'eje2_derecho_interior' => '',
//                        'eje2_derecho1_interior' => '',
//                        'eje2_derecho2_interior' => '',
//                        'eje3_derecho_interior' => '',
//                        'eje3_derecho1_interior' => '',
//                        'eje3_derecho2_interior' => '',
//                        'eje4_derecho_interior' => '',
//                        'eje4_derecho1_interior' => '',
//                        'eje4_derecho2_interior' => '',
//                        'eje5_derecho_interior' => '',
//                        'eje5_derecho1_interior' => '',
//                        'eje5_derecho2_interior' => '',
//                        'eje1_izquierdo' => '',
//                        'eje1_izquierdo1' => '',
//                        'eje1_izquierdo2' => '',
//                        'eje2_izquierdo' => '',
//                        'eje2_izquierdo1' => '',
//                        'eje2_izquierdo2' => '',
//                        'eje3_izquierdo' => '',
//                        'eje3_izquierdo1' => '',
//                        'eje3_izquierdo2' => '',
//                        'eje4_izquierdo' => '',
//                        'eje4_izquierdo1' => '',
//                        'eje4_izquierdo2' => '',
//                        'eje5_izquierdo' => '',
//                        'eje5_izquierdo1' => '',
//                        'eje5_izquierdo2' => '',
//                        'eje2_izquierdo_interior' => '',
//                        'eje2_izquierdo1_interior' => '',
//                        'eje2_izquierdo2_interior' => '',
//                        'eje3_izquierdo_interior' => '',
//                        'eje3_izquierdo1_interior' => '',
//                        'eje3_izquierdo2_interior' => '',
//                        'eje4_izquierdo_interior' => '',
//                        'eje4_izquierdo1_interior' => '',
//                        'eje4_izquierdo2_interior' => '',
//                        'eje5_izquierdo_interior' => '',
//                        'eje5_izquierdo1_interior' => '',
//                        'eje5_izquierdo2_interior' => '',
//                        'repuesto' => '',
//                        'repuesto_1' => '',
//                        'repuesto_2' => '',
//                        'repuesto2' => '',
//                        'repuesto2_1' => '',
//                        'repuesto2_2' => '');
        }
        return $labrados;
    }

    public function getResultado($data, $tiporesultado, $observacion)
    {
        $data['tiporesultado'] = $tiporesultado;
        if ($observacion <> '') {
            $data['observacion'] = "and observacion='$observacion'";
        } else {
            $data['observacion'] = '';
        }
        $result = $this->Mresultado->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return str_replace(",", ".", $r[0]->valor);
        } else {
            return '';
        }
    }

    public function cargarVehiculo()
    {
        $placa = $this->Mpruebas->obtenerPlacaIdprueba($this->input->post("idprueba"));
        $rtaVehiculo = $this->Mprerevision->cargarVehiculoLite($placa);
        if ($rtaVehiculo->num_rows() !== 0) {
            $vehiculo = $rtaVehiculo->result();
            $vehiculo[0]->src = $this->obtenerFoto($placa, $vehiculo[0]->idclase, $vehiculo[0]->taximetro);
            echo json_encode($vehiculo);
        } else {
            echo 'FALSE';
        }
    }

    private function obtenerFoto($numero_placa, $idclase, $taximetro)
    {
        $encrptopenssl = new Opensslencryptdecrypt();
        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            $aplicaC = "";
        } else {
            $aplicaC = "c:/";
        }
        $file = $aplicaC . "tcm/prerevision/" . $this->getDia() . "/" . $numero_placa . "/mini_0.dat";
        if (file_exists($file)) {
            $src = file_get_contents($file, true);
            $src = $encrptopenssl->decrypt($src);
        } else {
            $file = $aplicaC . "tcm/prerevision/" . $this->getDia() . "/" . $numero_placa . "/mini_1.dat";
            if (file_exists($file)) {
                $src = file_get_contents($file, true);
                $src = $encrptopenssl->decrypt($src);
            } else {
                switch ($idclase) {
                    case 1:
                        $src = "../../img/automovil.jpg";
                        break;
                    case 'AUTOMOVIL':
                        $src = "../../img/automovil.jpg";
                        break;
                    case 2:
                        $src = "../../img/bus.jpg";
                        break;
                    case 'BUS':
                        $src = "../../img/bus.jpg";
                        break;
                    case 3:
                        $src = "../../img/bus.jpg";
                        break;
                    case 'BUSETA':
                        $src = "../../img/bus.jpg";
                        break;
                    case 4:
                        $src = "../../img/pesado.jpg";
                        break;
                    case 'CAMION':
                        $src = "../../img/pesado.jpg";
                        break;
                    case 5:
                        $src = "../../img/camioneta.jpg";
                        break;
                    case 'CAMIONETA':
                        $src = "../../img/camioneta.jpg";
                        break;
                    case 6:
                        $src = "../../img/camioneta.jpg";
                        break;
                    case 'CAMPERO':
                        $src = "../../img/camioneta.jpg";
                        break;
                    case 7:
                        $src = "../../img/microbus.jpg";
                        break;
                    case 'MICROBUS':
                        $src = "../../img/microbus.jpg";
                        break;
                    case 8:
                        $src = "../../img/pesado.jpg";
                        break;
                    case 'TRACTOCAMION':
                        $src = "../../img/pesado.jpg";
                        break;
                    case 9:
                        $src = "../../img/pesado.jpg";
                        break;
                    case 'VOLQUETA':
                        $src = "../../img/pesado.jpg";
                        break;
                    case 10:
                        $src = "../../img/moto.jpg";
                        break;
                    case 'MOTOCICLETA':
                        $src = "../../img/moto.jpg";
                        break;
                    case 14:
                        $src = "../../img/motocarro.jpg";
                        break;
                    case 'MOTOCARRO':
                        $src = "../../img/motocarro.jpg";
                        break;
                    case 19:
                        $src = "../../img/motocarro.jpg";
                        break;
                    case 30:
                        $src = "../../img/cuatrimoto.jpg";
                        break;
                    case 'CUATRIMOTO':
                        $src = "../../img/cuatrimoto.jpg";
                        break;
                    default:
                        $src = "../../img/sinclase.jpg";
                        break;
                }
                if ($taximetro == 1) {
                    $src = "../../img/taxi.jpg";
                }
            }
        }
        return $src;
    }

    private function auditLuxometro($auditoria_sicov, $idprueba)
    {
        // $auditoria_sicov['trama'] = '{'
        //         . '"intensidadDerecha":"' . $this->Mpruebas->buscarResultado($idprueba, 14) . '",'
        //         . '"inclinacionDerecha":"' . $this->Mpruebas->buscarResultado($idprueba, 20) . '",'
        //         . '"intensidadIzquierda":"' . $this->Mpruebas->buscarResultado($idprueba, 16) . '",'
        //         . '"inclinacionIzquierda":"' . $this->Mpruebas->buscarResultado($idprueba, 19) . '",'
        //         . '"SumatoriaIntensidad":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
        //         . '"tablaAfectada":"resultados",'
        //         . '"idRegistro":"' . $idprueba . '"}';
        $auditoria_sicov['trama'] = '{'
            . '"derBajaIntensidadValor1":"' . $this->Mpruebas->buscarResultado($idprueba, 14) . '",'
            . '"derBajaIntensidadValor2":"' . $this->Mpruebas->buscarResultado($idprueba, 20) . '",'
            . '"derBajaIntensidadValor3":"' . $this->Mpruebas->buscarResultado($idprueba, 16) . '",'
            . '"derBajaSimultaneas":"' . $this->Mpruebas->buscarResultado($idprueba, 19) . '",'
            . '"izqBajaIntensidadValor1":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"izqBajaIntensidadValor2":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"izqBajaIntensidaValor3":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"IzqBajaSimultaneas":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"derBajaInclinacionValor1":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"derBajaInclinacionValor2":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"derBajaInclinacionValor3":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"izqBajaInclinacionValor1":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"izqBajaInclinacionValor2":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"izqBajaInclinacionValor3":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"sumatoriaIntensidad":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"derAltaIntensidadValor1":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"derAltaIntensidadValor2":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"derAltaIntensidadValor3":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"derAltasSimultaneas":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"izqAltaIntesidadValor1":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"izqAltaIntesidadValor2":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"izqAltaIntesidadValor3":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"izqAltasSimultaneas":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"derExplorardorasValor1":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"derExplorardorasValor2":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"derExplorardorasValor3":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"derExploradorasSimultaneas":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"izqExplorardorasValor1":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"izqExplorardorasValor2":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"izqExplorardorasValor3":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"izqExploradorasSimultaneas":"' . $this->Mpruebas->buscarResultado($idprueba, 18) . '",'
            . '"tablaAfectada":"resultados",'
            . '"idRegistro":"' . $idprueba . '"}';
        $this->Mpruebas->insertarAuditoriaSicov($auditoria_sicov);
    }

    private function auditSonometro($auditoria_sicov, $idprueba)
    {
        $auditoria_sicov['trama'] = '{'
            . '"ruidoEscape":"' . $this->Mpruebas->buscarResultado($idprueba, 165) . '",'
            . '"tablaAfectada":"resultados",'
            . '"idRegistro":"' . $idprueba . '"}';
        $this->Mpruebas->insertarAuditoriaSicov($auditoria_sicov);
    }

    private function auditGases($auditoria_sicov, $idprueba)
    {
        $dilu = "false";
        if ($this->Mpruebas->buscarResultado($idprueba, 99) !== "") {
            $dilu = "true";
        }
        // $auditoria_sicov['trama'] = '{'
        //         . '"tempRalenti":"' . $this->Mpruebas->buscarResultado($idprueba, 202) . '",'
        //         . '"tempCrucero":"' . $this->Mpruebas->buscarResultado($idprueba, 202) . '",'
        //         . '"rpmRalenti":"' . $this->Mpruebas->buscarResultado($idprueba, 86) . '",'
        //         . '"rpmCrucero":"' . $this->Mpruebas->buscarResultado($idprueba, 91) . '",'
        //         . '"CORalenti":"' . $this->Mpruebas->buscarResultado($idprueba, 88) . '",'
        //         . '"COCrucero":"' . $this->Mpruebas->buscarResultado($idprueba, 93) . '",'
        //         . '"CO2Ralenti":"' . $this->Mpruebas->buscarResultado($idprueba, 89) . '",'
        //         . '"CO2Crucero":"' . $this->Mpruebas->buscarResultado($idprueba, 94) . '",'
        //         . '"O2Ralenti":"' . $this->Mpruebas->buscarResultado($idprueba, 90) . '",'
        //         . '"O2Crucero":"' . $this->Mpruebas->buscarResultado($idprueba, 95) . '",'
        //         . '"HCRalenti":"' . $this->Mpruebas->buscarResultado($idprueba, 87) . '",'
        //         . '"HCCrucero":"' . $this->Mpruebas->buscarResultado($idprueba, 92) . '",'
        //         . '"NORalenti":"",'
        //         . '"NOCrucero":"",'
        //         . '"tempDiesel":"",'
        //         . '"rpmDiesel":"",'
        //         . '"ciclo1":"",'
        //         . '"ciclo2":"",'
        //         . '"ciclo3":"",'
        //         . '"ciclo4":"",'
        //         . '"resultadoValor":"",'
        //         . '"dilucion":"' . $dilu . '",'
        //         . '"revisionVisual":"' . $this->Mpruebas->buscarResultado($idprueba, 902) . '",'
        //         . '"tablaAfectada":"resultados",'
        //         . '"idRegistro":"' . $idprueba . '"}';
        $auditoria_sicov['trama'] = '{'
            . '"temperaturaAmbiente":"' . $this->Mpruebas->buscarResultado($idprueba, 202) . '",'
            . '"rpmRalenti":"' . $this->Mpruebas->buscarResultado($idprueba, 202) . '",'
            . '"tempRalenti":"' . $this->Mpruebas->buscarResultado($idprueba, 86) . '",'
            . '"humedadRelativa":"' . $this->Mpruebas->buscarResultado($idprueba, 91) . '",'
            . '"velocidadGobernada0":"' . $this->Mpruebas->buscarResultado($idprueba, 88) . '",'
            . '"velocidadGobernada1":"' . $this->Mpruebas->buscarResultado($idprueba, 93) . '",'
            . '"velocidadGobernada2":"' . $this->Mpruebas->buscarResultado($idprueba, 89) . '",'
            . '"velocidadGobernada3":"' . $this->Mpruebas->buscarResultado($idprueba, 94) . '",'
            . '"opacidad0":"' . $this->Mpruebas->buscarResultado($idprueba, 90) . '",'
            . '"opacidad1":"' . $this->Mpruebas->buscarResultado($idprueba, 95) . '",'
            . '"opacidad2":"' . $this->Mpruebas->buscarResultado($idprueba, 87) . '",'
            . '"opacidad3":"' . $this->Mpruebas->buscarResultado($idprueba, 92) . '",'
            . '"valorFinal":"",'
            . '"temperaturaInicial":"",'
            . '"temperaturaFinal":"",'
            . '"LTOEStandar":"",'
            . '"HCRalenti":"",'
            . '"CORalenti":"",'
            . '"CO2Ralenti":"",'
            . '"O2Ralenti":"",'
            . '"rpmCrucero":"",'
            . '"HCCrucero":"",'
            . '"COCrucero":"",'
            . '"CO2Crucero":"",'
            . '"O2Crucero":"",'
            . '"dilucion":"' . $dilu . '",'
            . '"catalizador":"",'
            . '"temperaturaPrueba":"",'
            . '"tablaAfectada":"resultados",'
            . '"idRegistro":"' . $idprueba . '"}';
        $this->Mpruebas->insertarAuditoriaSicov($auditoria_sicov);
    }

    private function getCodigoRuntCDA()
    {
        $sicov = $this->Mpruebas->getSicovRunt();
        $codigoRuntCDA = "";
        if ($sicov->valor == '1') {
            $array = explode('-', $sicov->adicional);
            if ($array[0] === 'INDRA') {
                $array1 = explode('|', $array[1]);
                if (count($array1) > 1) {
                    $codigoRuntCDA = $array1[1];
                }
            } else {
                $array1 = explode('@', $array[1]);
                $array2 = explode(':', $array1[0]);
                $array3 = explode('|', $array1[1]);
                $codigoRuntCDA = $array3[1];
            }
        }
        return $codigoRuntCDA;
    }

    function claveValida()
    {
        echo $this->Mpruebas->getUsuarioClave($this->input->post('passw'));
    }

    function insertarEventoIndra()
    {
        $idproveedor = '862';
        $fecha = $this->Mutilitarios->getNow();
        $nombrePrueba = $this->input->post('nombrePrueba');
        $placa = $this->input->post('placa');
        $serial = $this->input->post('serial');
        $tipoEvento = $this->input->post('tipoEvento');
        $cadena = $idproveedor . "|" . $fecha . "|" . $nombrePrueba . "|" . $placa . "|" . $serial . "|" . $tipoEvento . "|";
        //        $encrptopenssl = New Opensslencryptdecrypt();
//        $cadena = $encrptopenssl->encrypt_RIJNDAEL($this->formato_texto($cadena));
        $data['idelemento'] = $placa . "-" . $nombrePrueba;
        $data['cadena'] = $cadena;
        $data['fecha'] = $fecha;
        $data['tipo'] = 'e';
        $data['enviado'] = '0';
        $data['respuesta'] = 'Operación pendiente';
        echo $this->MEventosindra->insert($data);
    }

    function validarAuditoria()
    {
        //        $encrptopenssl = New Opensslencryptdecrypt();
        $cadena = 'CbOyODXYtUy9X87jjIiLKsozzcX7Tm4zI4V2wvY7FBFwV5aAo2JaKMVgu2PLa59S';
        $result = $this->desencrypt_MULTI($cadena);

        echo $result;
    }

    //    function desencrypt_MULTI($string) {
//        $key = "Jik8ThGv5TrVkIolM45YtfvEdgYhjukL";
//        $iv = "hjsyduiohjsyduio";
//        $output = openssl_decrypt($string, 'AES-256-CBC', $key, 0, $iv);
////        return preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $output);
//        return $output;
//    }
    function desencrypt_MULTI($string)
    {
        $key = "Jik8ThGv5TrVkIolM45YtfvEdgYhjukL";
        $iv = "hjsyduiohjsyduio";
        $output = openssl_decrypt($string, 'AES-256-CBC', $key, 0, $iv);
        return $output;
    }

    function encrypt_MULTI($string)
    {
        $key = "Jik8ThGv5TrVkIolM45YtfvEdgYhjukL";
        $iv = "hjsyduiohjsyduio";
        $output = openssl_encrypt($string, 'AES-256-CBC', $key, 0, $iv);
        return $output;
    }

    private function formato_texto($cadena)
    {
        $no_permitidas = array("Ñ", "ñ", "á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹", "'", "");
        $permitidas = array("N", "n", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E", "", "");
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

    var $idCdaRUNT;

    private function setConf()
    {
        $conf = @file_get_contents("system/oficina.json");
        if (isset($conf)) {
            $encrptopenssl = new Opensslencryptdecrypt();
            $json = $encrptopenssl->decrypt($conf, true);
            $dat = json_decode($json, true);
            if ($dat) {
                foreach ($dat as $d) {
                    if ($d['nombre'] == "idCdaRUNT") {
                        $this->idCdaRUNT = $d['valor'];
                    }
                }
            }
        }
    }

}
