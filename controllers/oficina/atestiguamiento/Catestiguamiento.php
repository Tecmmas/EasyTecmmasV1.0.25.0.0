<?php

defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
ini_set('memory_limit', '-1');
set_time_limit(0);

class Catestiguamiento extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        //        $this->load->model("oficina/fur/MFUR");
        $this->load->model("dominio/Mhojatrabajo");
        $this->load->model("dominio/Mvehiculo");
        $this->load->model("dominio/Mpropietario");
        $this->load->model("dominio/Mcda");
        $this->load->model("dominio/Msede");
        $this->load->model("dominio/Mciudad");
        $this->load->model("dominio/Mdepartamento");
        $this->load->model("dominio/Mpais");
        $this->load->model("dominio/Mservicio");
        $this->load->model("dominio/Mclase");
        $this->load->model("dominio/Mmarca");
        $this->load->model("dominio/Mlinea");
        $this->load->model("dominio/Mcolor");
        $this->load->model("dominio/Mcombustible");
        $this->load->model("dominio/Mcarroceria");
        $this->load->model("dominio/Mprueba");
        $this->load->model("dominio/Mresultado");
        $this->load->model("dominio/Mimagenes");
        $this->load->model("dominio/MconsecutivoTC");
        $this->load->model("dominio/Mconfig_prueba");
        $this->load->model("dominio/Mmaquina");
        $this->load->model("dominio/Musuarios");
        $this->load->model("dominio/Mcertificados");
        $this->load->model("dominio/Mpre_prerevision");
        $this->load->model("dominio/Mpre_atributo");
        $this->load->model("dominio/Mpre_dato");
        $this->load->model("dominio/MEventosindra");
        $this->load->model('GeneralModel');
        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
    }

    var $order;
    var $defectosMA;
    var $defectosMB;
    var $defectosSA;
    var $defectosSB;
    var $defectosEA;
    var $defectosEB;
    var $observaciones;
    var $aprobado;
    var $aprobadoE;
    var $nombreClase;
    var $defectos;
    var $arrayCi2;
    var $taxonomiaIndra;
    var $virtualRunt;
    var $idCdaRUNT;
    var $idSoftwareRunt;
    var $idConsecutivoRunt;
    var $software;
    var $nombreSicov;
    var $enpista;
    var $codigoOnac;
    var $ipSicov;
    var $sicovModoAlternativo;
    var $ipSicovAlternativo;
    var $usuarioSicov;
    var $claveSicov;
    var $mostrarFecha = '0';
    var $espejoImagenes = '0';
    var $desdeConsulta = "false";
    var $habilitarPerifericos = "0";
    var $horarioAtencion = "";
    public $sistemaOperativo = "";

    public function index() {
        $this->sistemaOperativo = sistemaoperativo();
        if (
                ($this->session->userdata('IdUsuario') == '' ||
                $this->session->userdata('IdUsuario') == '1024' ||
                $this->input->post('dato') == '') && $this->input->post('desdeVisor') == 'false'
        ) {
            redirect('Cindex');
        }
        $this->enpista = false;
        $this->mostrarFecha = '0';
        $this->setConf();
        //        $this->arrayCi2 = array();
        $this->taxonomiaIndra = "";
        $dat = explode("-", $this->input->post('dato'));
        $ocasion = $dat[1];
        if ($ocasion == "0" || $ocasion == "4444" || $ocasion == "8888") {
            $this->order = 'ASC';
        } else {
            $this->order = 'DESC';
        }
        $idhojaprueba = $dat[0];
        $tercer = "";
        if (isset($dat[2])) {
            $tercer = $dat[2];
        }
        if ($tercer == "1") {
            $this->enpista = true;
        }
        //        $idhojaprueba = 273956;
        $this->aprobado = true;
        $this->aprobadoE = true;
        $this->defectosMA = array();
        $this->defectosMB = array();
        $this->defectosSA = array();
        $this->defectosSB = array();
        $this->defectosEA = array();
        $this->defectosEB = array();
        $this->observaciones = array();

        $cons = "";
        $consecutivo = $this->getConsecutivo($idhojaprueba);
        if ($this->virtualRunt === "0") {
            $cons = $consecutivo . "-" . $ocasion;
        } else {
            $cons = $this->idCdaRUNT . $this->idSoftwareRunt . $this->idConsecutivoRunt;
        }
        $data['reins'] = $ocasion;
        $data['cda'] = $this->getCda();
        $data['cda']->logo = "@" . base64_encode($data['cda']->logo);
        $data['sede'] = $this->getSede();
        $data['ciudadCDA'] = $this->getCiudad($data['sede']->cod_ciudad);
        $data['departamentoCDA'] = $this->getDepartamento($data['ciudadCDA']->cod_depto);
        $data['hojatrabajo'] = $this->getHojatrabajo($idhojaprueba);
        $fechaMaquinas = '';
        if ($ocasion == "0" || $ocasion == '8888' || $ocasion == '4444') {
            $data['fechafur'] = $data['hojatrabajo']->fechainicial;
            $fechaMaquinas = $data['fechafur'];
            $pr2 = $this->getFechaLastReins($idhojaprueba, 'ASC');
            $data['ocasion'] = "false";
            $data['fechainicioprueba'] = "Fecha y hora inicial de la prueba: " . $data['fechafur'] . "<br>";
            if (isset($pr2->fechafinal)) {
                $data['fechafinalprueba'] = "Fecha y hora final de la prueba: " . $pr2->fechafinal;
            } else {
                $data['fechafinalprueba'] = "";
            }
        } else {
            $pr = $this->getFechaReins($idhojaprueba);
            $pr2 = $this->getFechaLastReins($idhojaprueba, 'DESC');
            $data['fechafur_ant'] = $data['hojatrabajo']->fechainicial;
            $data['fechafur'] = $pr->fechainicial;
            $data['ocasion'] = "true";
            $data['fechainicioprueba'] = "Fecha inicial de la prueba: " . $pr->fechainicial . "<br>";
            $fechaMaquinas = $pr->fechainicial;
            if (isset($pr2->fechafinal)) {
                $data['fechafinalprueba'] = "Fecha final de la prueba: " . $pr2->fechafinal;
            } else {
                $data['fechafinalprueba'] = "";
            }
        }
        $data['titulo'] = 'FORMULARIO DE ATESTIGUAMIENTO';
        $data['consecutivo'] = "<strong>N°: </strong>$idhojaprueba";
        $data['numeroOnac'] = '';
        $data['fur_aso'] = '';
        $data['infoOnac'] = '';
        $data['logoSuper'] = '';
        $data['escudoColombia'] = '';
        $data['tituloMinisterio'] = '';
        $data['tituloB'] = '<strong>B. RESULTADOS DE LA INSPECCIÓN MECANIZADA.</strong>';
        $data['tituloC'] = '<strong>C. DEFECTOS ENCONTRADOS EN LA INSPECCIÓN MECANIZADA.</strong>';
        $data['tituloD'] = '<strong>DEFECTOS ENCONTRADOS EN LA INSPECCIÓN SENSORIAL</strong>';
        $data['tituloE'] = '<strong>E. CONFORMIDAD DE LA INSPECCIÓN';

        $data['vehiculo'] = $this->getvehiculo($data['hojatrabajo']->idvehiculo);
        //------------------------------------------------------------------------------PRESIONES DE LLANTA
        if ($ocasion == '0' || $ocasion == '1') {
            $ti = '1';
        } elseif ($ocasion == '4444' || $ocasion == '44441') {
            $ti = '2';
        } else {
            $ti = '3';
        }
        $oc = '0';
        if ($data['ocasion'] == 'true') {
            $oc = '1';
        }
        $data['presion'] = $this->getPresiones($data['vehiculo']->numero_placa, $oc, $data['fechafur'], $ti);
        if ($this->histo_propietario !== '') {
            $data['vehiculo']->idpropietarios = $this->histo_propietario;
        }
        if ($this->histo_servicio !== '') {
            $data['vehiculo']->idservicio = $this->histo_servicio;
        }
        if ($this->histo_licencia !== '') {
            $data['vehiculo']->numero_tarjeta_propiedad = $this->histo_licencia;
        }
        if ($this->histo_color !== '') {
            $data['vehiculo']->idcolor = $this->histo_color;
        }
        //        if ($this->histo_combustible !== '') {
//            $data['vehiculo']->idtipocombustible = $this->histo_combustible;
//        }
        if ($this->histo_kilometraje !== '') {
            $data['vehiculo']->kilometraje = $this->histo_kilometraje;
        }
        if ($this->histo_blindaje !== '') {
            $data['vehiculo']->blindaje = $this->histo_blindaje;
        }
        if ($this->histo_polarizado !== '') {
            $data['vehiculo']->polarizado = $this->histo_polarizado;
        }
        if ($this->usuario_registro !== '') {
            $data['vehiculo']->usuario = $this->usuario_registro;
        }
        if ($this->chk_3 !== '') {
            $data['vehiculo']->chk_3 = $this->chk_3;
        }
        if ($this->fecha_final_certgas !== '') {
            $data['vehiculo']->fecha_final_certgas = $this->fecha_final_certgas;
        }
        if ($this->fecha_vencimiento_soat !== '') {
            $data['vehiculo']->fecha_vencimiento_soat = $this->fecha_vencimiento_soat;
        }

        if ($data['vehiculo']->kilometraje == '0' || $data['vehiculo']->kilometraje == '') {
            $data['vehiculo']->kilometraje = 'NO FUNCIONAL';
        }
        if ($data['vehiculo']->potencia_motor == '0' || $data['vehiculo']->potencia_motor == '') {
            $data['vehiculo']->potencia_motor = 'No aplica';
        }
        $data['vehiculo']->diametro_escape = floatval(str_replace(",", ".", $data['vehiculo']->diametro_escape)) * 10;
        $data['vehiculo']->diametro_escape = $this->rdnr($data['vehiculo']->diametro_escape);
        $data['servicio'] = $this->getServicio($data['vehiculo']->idservicio);
        $data['carroceria'] = $this->getCarroceria($data['vehiculo']->diseno);
        $data['clase'] = $this->getclase($data['vehiculo']->idclase);
        $this->nombreClase = $data['clase'];
        //        $this->nombreClase->nombre= "MOTOCICLETA";
       if ($data['vehiculo']->registrorunt == '1' && $data['vehiculo']->migrateLineaMarca == '0') {
            $data['linea'] = $this->getLinea($data['vehiculo']->idlinea, $data['vehiculo']);
            
            // var_dump($data['linea']);
        }else if($data['vehiculo']->migrateLineaMarca == '1'){
            
            $data['linea'] = $this->getLinea($data['vehiculo']->idlinea, $data['vehiculo']);
            //  var_dump($data['linea']);
        }else{
            $data['linea'] = $this->getLinea($data['vehiculo']->idlinea, $data['vehiculo']);

        }
        if ($data['vehiculo']->registrorunt == '1' && $data['vehiculo']->migrateLineaMarca == '0') {
            
            $data['marca'] = $this->getMarca($data['linea']->idmarcaRUNT, $data['vehiculo']);
        } else if ($data['vehiculo']->migrateLineaMarca == '1') {
            
            $data['marca'] = $this->getMarca($data['linea']->idmarcas, $data['vehiculo']);
        }else{
            $data['marca'] = $this->getMarca($data['linea']->idmarca, $data['vehiculo']);

        }
        $data['color'] = $this->getColor($data['vehiculo']->idcolor, $data['vehiculo']);
        $data['combustible'] = $this->getCombustible($data['vehiculo']->idtipocombustible);
        $data['pais'] = $this->getPais($data['vehiculo']->idpais);
        $data['propietario'] = $this->getPropietario($data['vehiculo']->idpropietarios);
        $data['tipoDocumento'] = $this->tipoDocumento($data['propietario']->tipo_identificacion);

        $data['ciudadPropietario'] = $this->getCiudad($data['propietario']->cod_ciudad);
        $data['departamentoPropietario'] = $this->getDepartamento($data['ciudadPropietario']->cod_depto);
        $data['blindaje'] = $this->getBlindaje($data['vehiculo']->blindaje);
        if (is_null($data['vehiculo']->num_pasajeros) || $data['vehiculo']->num_pasajeros == '') {
            $data['pasajeros'] = intval($data['vehiculo']->numsillas) - 1;
        } else {
            $data['pasajeros'] = intval($data['vehiculo']->num_pasajeros);
        }
        if ($data['vehiculo']->scooter === '1' && $data['vehiculo']->tipo_vehiculo !== '3') {
            $data['vehiculo']->convertidor = "SI";
        } elseif ($data['vehiculo']->scooter === '0' && $data['vehiculo']->tipo_vehiculo !== '3') {
            $data['vehiculo']->convertidor = "NO";
        } elseif ($data['vehiculo']->tipo_vehiculo == '3' && $data['vehiculo']->idtipocombustible == '2') {
            $data['vehiculo']->convertidor = "NO";
        } else {
            $data['vehiculo']->convertidor = "N.A.";
        }
        $idpre_prerevision = $this->getIdPre_prerevision($data['vehiculo']->numero_placa, $ocasion, $data['fechafur']);
        if ($idpre_prerevision !== '' && $idpre_prerevision !== NULL) {
            if (strlen($this->getFechaSoat($idpre_prerevision)) == 10) {
                $data['vehiculo']->fecha_vencimiento_soat = $this->getFechaSoat($idpre_prerevision);
                if ($data['vehiculo']->fecha_vencimiento_soat == '0000-00-00') {
                    $data['vehiculo']->fecha_vencimiento_soat = "";
                }
            } else {
                $data['vehiculo']->fecha_vencimiento_soat = '';
            }
            $data['vehiculo']->certificadoGas = $this->getCertificado($idpre_prerevision);
            if (strlen($this->getFechaCertificado($idpre_prerevision)) == 10) {
                $data['vehiculo']->fecha_final_certgas = $this->getFechaCertificado($idpre_prerevision);
                if ($data['vehiculo']->fecha_final_certgas == '0000-00-00') {
                    $data['vehiculo']->fecha_final_certgas = "";
                }
            } else {
                $data['vehiculo']->fecha_final_certgas = '';
            }
            $idusuario_ = $this->getUsuarioRegistro($idpre_prerevision);
        } else {
            $idusuario_ = $data['vehiculo']->usuario;
            $dat = '';
            switch ($data['vehiculo']->chk_3) {
                case 'NA':
                    $dat = "SI ( ) NO ( ) N/A (X)";
                    break;
                case 'NO':
                    $dat = "SI ( ) NO (X) N/A ( )";
                    break;
                case 'SI':
                    $dat = "SI (X) NO ( ) N/A ( )";
                    break;
                default:
                    $dat = "SI ( ) NO ( ) N/A (X)";
                    break;
            }
            $data['vehiculo']->certificadoGas = $dat;
            if ($data['vehiculo']->fecha_final_certgas == '0000-00-00') {
                $data['vehiculo']->fecha_final_certgas = "";
            }
            if ($data['vehiculo']->fecha_vencimiento_soat == '0000-00-00') {
                $data['vehiculo']->fecha_vencimiento_soat = "";
            }
        }
        //$usuario = $this->getUsuario($idusuario_);
        $data['vehiculo']->usuario_registro = "";
        $data['vehiculo']->documento_usuario = "";

        //------------------------------------------------------------------------------RESULTADOS
//------------------------------------------------------------------------------LUCES
        $data['luces'] = $this->getLuces($idhojaprueba);
        //------------------------------------------------------------------------------SUSPENSION
        $data['suspension'] = $this->getSuspension($idhojaprueba);
        //------------------------------------------------------------------------------FRENOS
        $data['frenos'] = $this->getFrenos($idhojaprueba, $data['vehiculo']);
        //------------------------------------------------------------------------------ALINEACION
        $data['alineacion'] = $this->getAlineacion($idhojaprueba);
        //------------------------------------------------------------------------------TAXIMETRO
        $data['taximetro'] = $this->getTaximetro($idhojaprueba);
        //------------------------------------------------------------------------------SONOMETRO
        $data['sonometro'] = $this->getSonometro($idhojaprueba);
        if ($data['sonometro']->valor_ruido_motor1 !== '') {
            array_push(
                    $this->observaciones,
                    (object) array(
                        "codigo" => 'Valor sonometría',
                        "descripcion" => $data['sonometro']->valor_ruido_motor1 . " dB"
                    )
            );
        }
        //------------------------------------------------------------------------------GASES
        $data['gases'] = $this->getGases($idhojaprueba, $data['vehiculo']);
        //------------------------------------------------------------------------------OPACIDAD        
        $data['opacidad'] = $this->getOpacidad($idhojaprueba, $data['vehiculo']);
        //------------------------------------------------------------------------------LABRADO        
        $data['labrado'] = $this->getLabrados($idhojaprueba);
        //------------------------------------------------------------------------------FOTOS
        if ($this->espejoImagenes == '1') {
            $this->Mimagenes->deleteImagenes();
            $this->MEventosindra->deleteEventos();
        }
        if ($this->input->post('desdeConsulta') !== NULL) {
            $this->desdeConsulta = $this->input->post('desdeConsulta');
        }
        //$data['fotografia'] = $this->getFotografias($idhojaprueba);
        $data['fotografia'] = "";
        //------------------------------------------------------------------------------MAQUINA
        $data['maquinas'] = $this->getMaquinas($idhojaprueba, $fechaMaquinas);
        //------------------------------------------------------------------------------INSPECTORES
        $data['inspectores'] = $data['maquinas'];
        //------------------------------------------------------------------------------SENSORIAL
        $this->setDefectos();
        $data['sensorial'] = $this->getSensorial($idhojaprueba, $data['vehiculo']);

        //------------------------------------------------------------------------------FIRMA
        if ($data['sensorial']->operario !== '' && $data['sensorial']->operario !== NULL) {
            //            if ($this->input->post('envioSicov') !== 'true' && $this->jefe_pista !== '') {
            $data['hojatrabajo']->jefelinea = $data['sensorial']->operario;
            //            }
            $data['firmaJefe'] = $this->getFirmaJefe($data['sensorial']->documento);
        } else {
            $data['firmaJefe'] = '';
        }
        //------------------------------------------------------------------------------DEFECTOS
        $data['defectosMecanizadosA'] = $this->defectosMA;
        $data['defectosMecanizadosB'] = $this->defectosMB;
        $data['defectosSensorialesA'] = $this->defectosSA;
        $data['defectosSensorialesB'] = $this->defectosSB;
        $data['defectosEnsenanzaA'] = $this->defectosEA;
        $data['defectosEnsenanzaB'] = $this->defectosEB;
        //------------------------------------------------------------------------------NÚMEROS DE LOS FUR ASOCIADOS AL VEHÍCULO PARA LA REVISIÓN
        if ($this->virtualRunt == "0" && ($ocasion == '0' || $ocasion == '1')) {
            if ($ocasion == "0") {
                $data['num_fur_aso'] = "No: $consecutivo-0";
            } else {
                $fechafur_ant = $data['fechafur_ant'];
                $data['num_fur_aso'] = "No: $consecutivo-1";
            }
        } else {
            $data['num_fur_aso'] = $cons;
        }
        //------------------------------------------------------------------------------I. SOFTWARE Y/O APLICATIVOS CON LA VERSIÓN UTILIZADA:
        $data['software'] = $this->software;
        //------------------------------------------------------------------------------F. COMENTARIOS U OBSERVACIONES ADICIONALES:
        $data['observaciones'] = $this->observaciones;
        //------------------------------------------------------------------------------DIAGNOSTICO
        $data['apro'] = $this->getDiagnostico($data['vehiculo']);
        $data['aproE'] = $this->getDiagnosticoE($data['vehiculo']);

        if ($data['hojatrabajo']->estadototal !== '7' && $data['hojatrabajo']->estadototal !== '4') {
            $this->segundo_envio = false;
            if ($this->input->post('envio') !== NULL && $this->input->post('envio') == '2') {
                $this->segundo_envio = true;
            }
            if ($this->segundo_envio) {
                $data['numero_consecutivo'] = $this->getNumero_consecutivo($idhojaprueba);
                $data['numero_sustrato'] = substr($data['numero_consecutivo'], 1);
            } else {
                $data['numero_sustrato'] = '';
                $data['numero_consecutivo'] = '';
            }
        } else {
            $data['numero_consecutivo'] = $this->getNumero_consecutivo($idhojaprueba);
            $data['numero_sustrato'] = substr($data['numero_consecutivo'], 1);
        }
        if ($this->mostrarFecha == '0') {
            $data['fechainicioprueba'] = "";
            $data['fechafinalprueba'] = "";
        }

        if ($this->input->post('desdeVisor') === 'true') {
            if ($this->rechazadoCB) {
                echo "APROBADO: SI_____ NO__X__|APROBADO: SI_____ NO__X__|" . $data['sensorial']->idprueba;
            } else {
                echo "APROBADO: SI__X__ NO_____|APROBADO: SI__X__ NO_____|" . $data['sensorial']->idprueba;
            }
        } else {
            if ($this->input->post('envioSicov') !== 'true') {
                //                if ($this->jefe_pista !== '') {
//                    $data["hojatrabajo"]->jefelinea = $this->jefe_pista;
//                }
                $data['horarioAtencion'] = $this->horarioAtencion;
                $this->load->view('oficina/atestiguamiento/Vatestiguamiento', $data);
            } else {
                if ($this->input->post('envioSicov') === 'true') {
                    $data['idhojapruebas'] = $idhojaprueba;
                    $this->guardarJefePista($data, $oc, $ti);
                    if (strtoupper($this->nombreSicov) == "CI2") {
                        $this->buildCi2($data);
                    } else {
                        $data['sicovModoAlternativo'] = $this->input->post('sicovModoAlternativo');
                        $this->buildIndra($data);
                    }
                }
            }
        }
    }

    public function guardarJefePista($data, $ocasion, $ti) {
        $id = 'jefe_pista';
        $numero_placa_ref = $data['vehiculo']->numero_placa;
        $reinspeccion = $ocasion;
        $tipo_inspeccion = $ti;
        $valor = $data['hojatrabajo']->jefelinea;
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
    //Datos versionados del vehiculo
    var $histo_propietario = '';
    var $histo_servicio = '';
    var $histo_licencia = '';
    var $histo_color = '';
    var $histo_combustible = '';
    var $histo_kilometraje = '';
    var $histo_blindaje = '';
    var $histo_polarizado = '';
    var $usuario_registro = '';
    var $histo_cliente = '';
    var $chk_3 = '';
    var $fecha_final_certgas = '';
    var $fecha_vencimiento_soat = '';
    var $jefe_pista = '';

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
                    case 'histo_propietario':
                        $this->histo_propietario = $d->valor;
                        break;
                    case 'histo_servicio':
                        $this->histo_servicio = $d->valor;
                        break;
                    case 'histo_licencia':
                        $this->histo_licencia = $d->valor;
                        break;
                    case 'histo_color':
                        $this->histo_color = $d->valor;
                        break;
                    case 'histo_combustible':
                        $this->histo_combustible = $d->valor;
                        break;
                    case 'histo_kilometraje':
                        $this->histo_kilometraje = $d->valor;
                        break;
                    case 'histo_blindaje':
                        $this->histo_blindaje = $d->valor;
                        break;
                    case 'histo_polarizado':
                        $this->histo_polarizado = $d->valor;
                        break;
                    case 'usuario_registro':
                        $this->usuario_registro = $d->valor;
                        break;
                    case 'histo_cliente':
                        $this->histo_cliente = $d->valor;
                        break;
                    case 'chk-3':
                        $this->chk_3 = $d->valor;
                        break;
                    case 'fecha_final_certgas':
                        $this->fecha_final_certgas = $d->valor;
                        break;
                    case 'fecha_vencimiento_soat':
                        $this->fecha_vencimiento_soat = $d->valor;
                        break;
                    case 'jefe_pista':
                        //                        $this->jefe_pista = $d->valor;
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

    private function setConf() {
        $conf = @file_get_contents("system/oficina.json");
        if (isset($conf)) {
            $encrptopenssl = new Opensslencryptdecrypt();
            $json = $encrptopenssl->decrypt($conf, true);
            $dat = json_decode($json, true);
            $nomSoftware = "";
            if ($dat) {
                foreach ($dat as $d) {
                    if ($d['nombre'] == "virtualRUNT") {
                        $this->virtualRunt = $d['valor'];
                    }
                    if ($d['nombre'] == "idCdaRUNT") {
                        $this->idCdaRUNT = $d['valor'];
                    }
                    if ($d['nombre'] == "idSoftwareRunt") {
                        $this->idSoftwareRunt = $d['valor'];
                    }
                    if ($d['nombre'] == "idConsecutivoRunt") {
                        $this->idConsecutivoRunt = $d['valor'];
                    }
                    if ($d['nombre'] == "codigoOnac") {
                        $this->codigoOnac = $d['valor'];
                    }
                    if ($d['nombre'] == "software") {
                        $nomSoftware = $nomSoftware . $d['valor'] . " - ";
                    }
                    if ($d['nombre'] == "sicov") {
                        $this->nombreSicov = strtoupper($d['valor']);
                    }
                    if ($d['nombre'] == "ipSicov") {
                        $this->ipSicov = $d['valor'];
                    }
                    if ($d['nombre'] == "sicovModoAlternativo") {
                        $this->sicovModoAlternativo = $d['valor'];
                    }
                    if ($d['nombre'] == "ipSicovAlternativo") {
                        $this->ipSicovAlternativo = $d['valor'];
                    }
                    if ($d['nombre'] == "usuarioSicov") {
                        $this->usuarioSicov = $d['valor'];
                    }
                    if ($d['nombre'] == "claveSicov") {
                        $this->claveSicov = $d['valor'];
                    }
                    if ($d['nombre'] == "mostrarFecha") {
                        $this->mostrarFecha = $d['valor'];
                    }
                    if ($d['nombre'] == "espejoImagenes") {
                        $this->espejoImagenes = $d['valor'];
                    }
                    if ($d['nombre'] == "habilitarPerifericos") {
                        $this->habilitarPerifericos = $d['valor'];
                    }
                    if ($d['nombre'] == "horarioAtencion") {
                        $this->horarioAtencion = $d['valor'];
                    }
                }
                $this->software = substr($nomSoftware, 0, strlen($nomSoftware) - 2);
            }
        } else {
            $this->software = "EasyTecmmas v1.0";
        }
    }

    private function getNumero_consecutivo($idhojapruebas) {
        $data['idhojapruebas'] = $idhojapruebas;
        if ($this->aprobado) {
            $data['estado'] = '1';
        } else {
            $data['estado'] = '2';
        }
        $result = $this->Mcertificados->getHT($data);

        if ($result->num_rows() > 0) {
            $r = $result->result();
            if ($this->aprobado) {
                return "A" . $r[0]->consecutivo_runt;
            } else {
                return "R" . $r[0]->consecutivo_runt_rechazado;
            }
        } else {
            return '';
        }
    }

    private function getNumero_sustrato($idhojapruebas) {
        $data['idhojapruebas'] = $idhojapruebas;
        if ($this->aprobado) {
            $data['estado'] = '1';
        } else {
            $data['estado'] = '2';
        }
        $result = $this->Mcertificados->getHT($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0]->numero_certificado;
        } else {
            return '';
        }
    }

    private function setDefectos() {
        $this->defectos = array();
        if ($this->nombreClase->nombre === "MOTOCICLETA" || $this->nombreClase->nombre === "MOTOCICLO") {
            $nombre_defecto = "motocicletas y motociclos";
        } else if ($this->nombreClase->nombre === "CICLOMOTOR") {
            $nombre_defecto = "ciclomotor";
        } else if ($this->nombreClase->nombre === "TRICIMOTO") {
            $nombre_defecto = "tricimoto";
        } else if ($this->nombreClase->nombre === "CUATRIMOTO") {
            $nombre_defecto = "cuatrimotos";
        } else if ($this->nombreClase->nombre === "MOTOTRICICLO") {
            $nombre_defecto = "mototriciclos";
        } else if ($this->nombreClase->nombre === "CUADRICICLO") {
            $nombre_defecto = "cuadriciclo";
        } else if ($this->nombreClase->nombre === "MOTOCARRO") {
            $nombre_defecto = "motocarro";
        } else if ($this->nombreClase->nombre === "REMOLQUE") {
            $nombre_defecto = "remolque";
        } else {
            $nombre_defecto = "liviano pesado";
        }
        $def = json_decode(utf8_encode(file_get_contents('application/libraries/defectos.json', true)));
        foreach ($def as $d) {
            if ($nombre_defecto == $d->nombre_defecto || $d->nombre_defecto == 'ensenanza') {
                array_push($this->defectos, $d);
            }
        }
    }

    //------------------------------------------------------------------------------Obtener datos del cda
    public function getCda() {
        $result = $this->Mcda->get();
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            return 'NA';
        }
    }

    //------------------------------------------------------------------------------Obtener consecutivo
    public function getConsecutivo($idhojapruebas) {
        $data['idhojapruebas'] = $idhojapruebas;
        $result = $this->MconsecutivoTC->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0]->idconsecutivotc;
        } else {
            return $idhojapruebas;
        }
    }

    //------------------------------------------------------------------------------Obtener número ONAC
    public function getNumeroOnac() {
        $data['idconfig_prueba'] = '183';
        $result = $this->Mconfig_prueba->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0]->valor;
        } else {
            return '';
        }
    }

    public function getSede() {
        $result = $this->Msede->get();
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            return 'NA';
        }
    }

    public function getHojatrabajo($idhojapruebas) {
        $data['idhojapruebas'] = $idhojapruebas;
        $result = $this->Mhojatrabajo->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            return 'NA';
        }
    }

    public function getFechaReins($idhojapruebas) {
        $data['idhojapruebas'] = $idhojapruebas;
        $result = $this->Mprueba->getLast($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            return 'NA';
        }
    }

    public function getFechaLastReins($idhojapruebas, $order) {
        $data['idhojapruebas'] = $idhojapruebas;
        $result = $this->Mprueba->getLastFecha($data, $order);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            return 'NA';
        }
    }

    public function getVehiculo($idvehiculo) {
        $data['idvehiculo'] = $idvehiculo;
        $result = $this->Mvehiculo->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            return 'NA';
        }
    }

    public function getPropietario($idpropietario) {
        $data['idcliente'] = $idpropietario;
        $result = $this->Mpropietario->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            return 'NA';
        }
    }

    public function getCiudad($cod_ciudad) {
        $data['cod_ciudad'] = $cod_ciudad;
        $result = $this->Mciudad->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            return 'NA';
        }
    }

    public function getDepartamento($cod_depto) {
        $data['cod_depto'] = $cod_depto;
        $result = $this->Mdepartamento->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            return 'NA';
        }
    }

    public function getPais($idpais) {
        $data['idpais'] = $idpais;
        $result = $this->Mpais->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            return 'NA';
        }
    }

  public function getLinea($idlinea, $vehiculo) {
        if ($vehiculo->registrorunt == '1'  &&  $vehiculo->migrateLineaMarca == '0') {
            $data['idlineaRUNT'] = $idlinea;
            $result = $this->Mlinea->get($data);
        } else if( $vehiculo->registrorunt == '1'  &&  $vehiculo->migrateLineaMarca == '1'){ 
            $data['idlinea'] = $idlinea;
            $result = $this->Mlinea->getmigrateLineaMarca($data);
        }else{
            $data['idlinea'] = $idlinea;
            $result = $this->Mlinea->get2($data);

        }
        
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            echo "<script>
            alert('Error al cargar el FUR: Se requiere actualizar línea y marca del vehículo. Complete esta información en el sistema y si el problema continúa, contacte a soporte técnico.');
            window.location.href = '" . base_url('index.php/oficina/CGestion') . "';
        </script>";
        exit;
        }
    }

    public function getMarca($idmarca, $vehiculo) {
        // var_dump($vehiculo);
        // var_dump($idmarca);
        if ($vehiculo->registrorunt == '1' &&  $vehiculo->migrateLineaMarca == '0') {
            
            $data['idmarcaRUNT'] = $idmarca;
            $result = $this->Mmarca->get($data);
        } else if ($vehiculo->registrorunt == '1' &&  $vehiculo->migrateLineaMarca == '1') {
            // echo 'elseif';
            $data['idmarca'] = $idmarca;
            $result = $this->Mmarca->getmigrateLineaMarca($data);
        }else{
            $data['idmarca'] = $idmarca;
            $result = $this->Mmarca->get2($data);
        }
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            echo "<script>
            alert('Error al cargar el FUR: Se requiere actualizar línea y marca del vehículo. Complete esta información en el sistema y si el problema continúa, contacte a soporte técnico.');
            window.location.href = '" . base_url('index.php/oficina/CGestion') . "';
        </script>";
        exit;
            // echo "<script>alert('Por favor Actualizar líneas y marcas del vehículo.');</script>";
            // return 'NA';
        }
    }

    public function getServicio($idservicio) {
        $data['idservicio'] = $idservicio;
        $result = $this->Mservicio->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            return 'NA';
        }
    }

    public function getClase($idclase) {
        $data['idclase'] = $idclase;
        $result = $this->Mclase->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            return 'NA';
        }
    }

    public function getColor($idcolor, $vehiculo) {
        if ($vehiculo->registrorunt == '1') {
            $data['idcolorRUNT'] = $idcolor;
            $result = $this->Mcolor->get($data);
        } else {
            $data['idcolor'] = $idcolor;
            $result = $this->Mcolor->get2($data);
        }
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            return 'NA';
        }
    }

    public function getCombustible($idcombustible) {
        $data['idtipocombustible'] = $idcombustible;
        $result = $this->Mcombustible->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            return 'NA';
        }
    }

    public function getCarroceria($idcarroceria) {
        $data['idcarroceria'] = $idcarroceria;
        $result = $this->Mcarroceria->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            return 'NA';
        }
    }

    public function getUsuario($IdUsuario) {
        $data['IdUsuario'] = $IdUsuario;
        $result = $this->Musuarios->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            return 'NA';
        }
    }

    //------------------------------------------------------------------------------LUCES
    var $ifdefLuzMinBaja;
    var $ifdefInclinacionLuces;
    var $ifdefIntensidadTotal;

    public function getLuces($idhojapruebas) {
        $this->ifLuzMinBaja = false;
        $this->ifdefInclinacionLuces = false;
        $this->ifdefIntensidadTotal = false;
        $data['idhojapruebas'] = $idhojapruebas;
        $data['idtipo_prueba'] = "1";
        $data['order'] = $this->order;
        $result = $this->Mprueba->get($data);
        //        $aprobadoLuces = true;
        if ($result->num_rows() > 0) {
            $r = $result->result();
            $data['idprueba'] = $r[0]->idprueba;
            $operario = $this->getUsuario($r[0]->idusuario);
            if ($r[0]->estado == '1') {
                $this->aprobado = false;
                //                $aprobadoLuces = false;
            }
            //            $lucesParam = new luces_param();
            $rango_min_inc = $this->getRango_min_inc();
            $rango_max_inc = $this->getRango_max_inc();
            $min_luz_baja = $this->getMin_luz_baja();
            $max_luz_total = $this->getMax_luz_total();
            $simultanea = $this->getResultado($data, 'independiente', '');
            //            $valor_antiniebla_izquierda_1 = $this->getResultadoIDCF($data, 191);
            $intensidad_total = $this->evalLuzMaxTotal($this->getResultado($data, 'intensidad_total', ''), $max_luz_total);
            $alta_izquierda = $this->getResultado($data, '1', 'alta_izquierda');
            $alta_derecha = $this->getResultado($data, '1', 'alta_derecha');
            if ($simultanea === '0') {
                $simultaneaAlta = 'NO';
                $simultaneaBaja = 'NO';
                $simultaneaAntiniebla = 'SI';
            } else {
                $simultaneaAlta = 'SI';
                $simultaneaBaja = 'SI';
                $simultaneaAntiniebla = 'SI';
            }
            if ($this->nombreClase->nombre == 'MOTOCICLETA' || $this->nombreClase->nombre == 'MOTOCARRO') {
                $simultaneaBaja = '';
                $simultaneaAlta = '';
                $simultaneaAntiniebla = '';
                $max_luz_total = '';
                $intensidad_total = '';
                $alta_izquierda = '';
                $alta_derecha = '';
            }
            $valor_antiniebla_derecha_1 = $this->rdnr($this->getResultado($data, '1', 'antis_derecha'));
            $valor_antiniebla_derecha_2 = $this->rdnr($this->getResultado($data, '2', 'antis_derecha'));
            $valor_antiniebla_derecha_3 = $this->rdnr($this->getResultado($data, '3', 'antis_derecha'));
            $valor_antiniebla_derecha_4 = $this->rdnr($this->getResultado($data, '4', 'antis_derecha'));
            $valor_antiniebla_derecha_5 = $this->rdnr($this->getResultado($data, '5', 'antis_derecha'));
            $valor_antiniebla_izquierda_1 = $this->rdnr($this->getResultado($data, '1', 'antis_izquierda'));
            $valor_antiniebla_izquierda_2 = $this->rdnr($this->getResultado($data, '2', 'antis_izquierda'));
            $valor_antiniebla_izquierda_3 = $this->rdnr($this->getResultado($data, '3', 'antis_izquierda'));
            $valor_antiniebla_izquierda_4 = $this->rdnr($this->getResultado($data, '4', 'antis_izquierda'));
            $valor_antiniebla_izquierda_5 = $this->rdnr($this->getResultado($data, '5', 'antis_izquierda'));
            if (
                    $valor_antiniebla_derecha_1 == '' &&
                    $valor_antiniebla_derecha_2 == '' &&
                    $valor_antiniebla_derecha_3 == '' &&
                    $valor_antiniebla_derecha_4 == '' &&
                    $valor_antiniebla_derecha_5 == '' &&
                    $valor_antiniebla_izquierda_1 == '' &&
                    $valor_antiniebla_izquierda_2 == '' &&
                    $valor_antiniebla_izquierda_3 == '' &&
                    $valor_antiniebla_izquierda_4 == '' &&
                    $valor_antiniebla_izquierda_5 == ''
            ) {
                $simultaneaAntiniebla = "";
            }
            $luces = (object)
                    array(
                        'idprueba' => $r[0]->idprueba,
                        'valor_baja_derecha_1' => $this->evalLuzMinBaja($this->rdnr($this->getResultado($data, '1', 'baja_derecha')), $min_luz_baja),
                        'valor_baja_derecha_2' => $this->evalLuzMinBaja($this->rdnr($this->getResultado($data, '2', 'baja_derecha')), $min_luz_baja),
                        'valor_baja_derecha_3' => $this->evalLuzMinBaja($this->rdnr($this->getResultado($data, '3', 'baja_derecha')), $min_luz_baja),
                        'valor_baja_derecha_4' => $this->evalLuzMinBaja($this->rdnr($this->getResultado($data, '4', 'baja_derecha')), $min_luz_baja),
                        'valor_baja_derecha_5' => $this->evalLuzMinBaja($this->rdnr($this->getResultado($data, '5', 'baja_derecha')), $min_luz_baja),
                        'inclinacion_baja_derecha_1' => $this->evalInclinacionLuces($this->rdnr($this->getResultado($data, '1', 'inclinacion_derecha')), $rango_min_inc, $rango_max_inc),
                        'inclinacion_baja_derecha_2' => $this->evalInclinacionLuces($this->rdnr($this->getResultado($data, '2', 'inclinacion_derecha')), $rango_min_inc, $rango_max_inc),
                        'inclinacion_baja_derecha_3' => $this->evalInclinacionLuces($this->rdnr($this->getResultado($data, '3', 'inclinacion_derecha')), $rango_min_inc, $rango_max_inc),
                        'inclinacion_baja_derecha_4' => $this->evalInclinacionLuces($this->rdnr($this->getResultado($data, '4', 'inclinacion_derecha')), $rango_min_inc, $rango_max_inc),
                        'inclinacion_baja_derecha_5' => $this->evalInclinacionLuces($this->rdnr($this->getResultado($data, '5', 'inclinacion_derecha')), $rango_min_inc, $rango_max_inc),
                        'valor_alta_derecha_1' => $this->rdnr($alta_derecha),
                        'valor_alta_derecha_2' => $this->rdnr($this->getResultado($data, '2', 'alta_derecha')),
                        'valor_alta_derecha_3' => $this->rdnr($this->getResultado($data, '3', 'alta_derecha')),
                        'valor_alta_derecha_4' => $this->rdnr($this->getResultado($data, '4', 'alta_derecha')),
                        'valor_alta_derecha_5' => $this->rdnr($this->getResultado($data, '5', 'alta_derecha')),
                        'valor_antiniebla_derecha_1' => $valor_antiniebla_derecha_1,
                        'valor_antiniebla_derecha_2' => $valor_antiniebla_derecha_2,
                        'valor_antiniebla_derecha_3' => $valor_antiniebla_derecha_3,
                        'valor_antiniebla_derecha_4' => $valor_antiniebla_derecha_4,
                        'valor_antiniebla_derecha_5' => $valor_antiniebla_derecha_5,
                        'valor_baja_izquierda_1' => $this->evalLuzMinBaja($this->rdnr($this->getResultado($data, '1', 'baja_izquierda')), $min_luz_baja),
                        'valor_baja_izquierda_2' => $this->evalLuzMinBaja($this->rdnr($this->getResultado($data, '2', 'baja_izquierda')), $min_luz_baja),
                        'valor_baja_izquierda_3' => $this->evalLuzMinBaja($this->rdnr($this->getResultado($data, '3', 'baja_izquierda')), $min_luz_baja),
                        'valor_baja_izquierda_4' => $this->evalLuzMinBaja($this->rdnr($this->getResultado($data, '4', 'baja_izquierda')), $min_luz_baja),
                        'valor_baja_izquierda_5' => $this->evalLuzMinBaja($this->rdnr($this->getResultado($data, '5', 'baja_izquierda')), $min_luz_baja),
                        'inclinacion_baja_izquierda_1' => $this->evalInclinacionLuces($this->rdnr($this->getResultado($data, '1', 'inclinacion_izquierda')), $rango_min_inc, $rango_max_inc),
                        'inclinacion_baja_izquierda_2' => $this->evalInclinacionLuces($this->rdnr($this->getResultado($data, '2', 'inclinacion_izquierda')), $rango_min_inc, $rango_max_inc),
                        'inclinacion_baja_izquierda_3' => $this->evalInclinacionLuces($this->rdnr($this->getResultado($data, '3', 'inclinacion_izquierda')), $rango_min_inc, $rango_max_inc),
                        'inclinacion_baja_izquierda_4' => $this->evalInclinacionLuces($this->rdnr($this->getResultado($data, '4', 'inclinacion_izquierda')), $rango_min_inc, $rango_max_inc),
                        'inclinacion_baja_izquierda_5' => $this->evalInclinacionLuces($this->rdnr($this->getResultado($data, '5', 'inclinacion_izquierda')), $rango_min_inc, $rango_max_inc),
                        'valor_alta_izquierda_1' => $this->rdnr($alta_izquierda),
                        'valor_alta_izquierda_2' => $this->rdnr($this->getResultado($data, '2', 'alta_izquierda')),
                        'valor_alta_izquierda_3' => $this->rdnr($this->getResultado($data, '3', 'alta_izquierda')),
                        'valor_alta_izquierda_4' => $this->rdnr($this->getResultado($data, '4', 'alta_izquierda')),
                        'valor_alta_izquierda_5' => $this->rdnr($this->getResultado($data, '5', 'alta_izquierda')),
                        'valor_antiniebla_izquierda_1' => $valor_antiniebla_izquierda_1,
                        'valor_antiniebla_izquierda_2' => $valor_antiniebla_izquierda_2,
                        'valor_antiniebla_izquierda_3' => $valor_antiniebla_izquierda_3,
                        'valor_antiniebla_izquierda_4' => $valor_antiniebla_izquierda_4,
                        'valor_antiniebla_izquierda_5' => $valor_antiniebla_izquierda_5,
                        'intensidad_minima' => $min_luz_baja,
                        'inclinacion_rango' => "$rango_min_inc a $rango_max_inc",
                        'intensidad_total' => $this->rdnr($intensidad_total),
                        'intensidad_maxima' => $max_luz_total,
                        'simultaneaBaja' => $simultaneaBaja,
                        'simultaneaAlta' => $simultaneaAlta,
                        'simultaneaAntiniebla' => $simultaneaAntiniebla,
                        'operario' => $operario->nombres . " " . $operario->apellidos,
                        'documento' => $operario->identificacion
            );
        } else {
            $luces = (object)
                    array(
                        'idprueba' => '',
                        'valor_baja_derecha_1' => '',
                        'valor_baja_derecha_2' => '',
                        'valor_baja_derecha_3' => '',
                        'valor_baja_derecha_4' => '',
                        'valor_baja_derecha_5' => '',
                        'inclinacion_baja_derecha_1' => '',
                        'inclinacion_baja_derecha_2' => '',
                        'inclinacion_baja_derecha_3' => '',
                        'inclinacion_baja_derecha_4' => '',
                        'inclinacion_baja_derecha_5' => '',
                        'valor_alta_derecha_1' => '',
                        'valor_alta_derecha_2' => '',
                        'valor_alta_derecha_3' => '',
                        'valor_alta_derecha_4' => '',
                        'valor_alta_derecha_5' => '',
                        'valor_antiniebla_derecha_1' => '',
                        'valor_antiniebla_derecha_2' => '',
                        'valor_antiniebla_derecha_3' => '',
                        'valor_antiniebla_derecha_4' => '',
                        'valor_antiniebla_derecha_5' => '',
                        'valor_baja_izquierda_1' => '',
                        'valor_baja_izquierda_2' => '',
                        'valor_baja_izquierda_3' => '',
                        'valor_baja_izquierda_4' => '',
                        'valor_baja_izquierda_5' => '',
                        'inclinacion_baja_izquierda_1' => '',
                        'inclinacion_baja_izquierda_2' => '',
                        'inclinacion_baja_izquierda_3' => '',
                        'inclinacion_baja_izquierda_4' => '',
                        'inclinacion_baja_izquierda_5' => '',
                        'valor_alta_izquierda_1' => '',
                        'valor_alta_izquierda_2' => '',
                        'valor_alta_izquierda_3' => '',
                        'valor_alta_izquierda_4' => '',
                        'valor_alta_izquierda_5' => '',
                        'valor_antiniebla_izquierda_1' => '',
                        'valor_antiniebla_izquierda_2' => '',
                        'valor_antiniebla_izquierda_3' => '',
                        'valor_antiniebla_izquierda_4' => '',
                        'valor_antiniebla_izquierda_5' => '',
                        'intensidad_minima' => '',
                        'inclinacion_rango' => '',
                        'intensidad_total' => '',
                        'intensidad_maxima' => '',
                        'simultaneaBaja' => '',
                        'simultaneaAlta' => '',
                        'simultaneaAntiniebla' => '',
                        'operario' => '',
                        'documento' => ''
            );
        }
        //        if (!$aprobadoLuces) {
//            
//        }
        return $luces;
    }

    //..............................................................................EVAL LUCES

    function evalInclinacionLuces($dato, $rangoMin, $rangoMax) {
        if ($dato !== '') {
            if (floatval($rangoMin) <= floatval($dato) && floatval($rangoMax) >= floatval($dato)) {
                return $dato;
            } else {
                $this->setDefLuz();
                return $dato . "*";
            }
        }
    }

    function setDefLuz() {
        if (!$this->ifdefInclinacionLuces) {
            $this->ifdefInclinacionLuces = true;
            switch ($this->nombreClase->nombre) {
                case "MOTOCICLETA":
                    array_push(
                            $this->defectosMA,
                            (object) array(
                                "codigo" => '1.2.4.7.2',
                                "descripcion" => 'La desviación de cualquier haz de luz en posición de bajas está por fuera del rango 0.5 y 3.5%, siendo 0 el horizonte y 3.5% la desviación hacia el piso.',
                                "grupo" => 'LUCES',
                                "tipo" => 'A'
                            )
                    );
                    break;
                case "MOTOCARRO":
                    array_push(
                            $this->defectosMA,
                            (object) array(
                                "codigo" => '1.4.4.12.2',
                                "descripcion" => 'La desviación de cualquier haz de luz en posición de bajas está por fuera del rango 0.5 y 3.5%, siendo 0 el horizonte y 3.5% la desviación hacia el piso.',
                                "grupo" => 'LUCES',
                                "tipo" => 'A'
                            )
                    );
                    break;
                default:
                    array_push(
                            $this->defectosMA,
                            (object) array(
                                "codigo" => '1.1.4.14.3',
                                "descripcion" => 'La desviación de cualquier haz de luz en posición de bajas está por fuera del rango 0.5 y 3.5%, siendo 0 el horizonte y 3.5% la desviación hacia el piso.',
                                "grupo" => 'LUCES',
                                "tipo" => 'A'
                            )
                    );
                    break;
            }
        }
    }

    function evalLuzMinBaja($dato, $luzMin) {
        if ($dato !== '') {
            if (floatval($luzMin) <= floatval($dato)) {
                return $dato;
            } else {
                if (!$this->ifdefLuzMinBaja) {
                    $this->ifdefLuzMinBaja = true;
                    switch ($this->nombreClase->nombre) {
                        case "MOTOCICLETA":
                            array_push(
                                    $this->defectosMA,
                                    (object) array(
                                        "codigo" => '1.2.4.7.1',
                                        "descripcion" => 'La intensidad de la luz menor a 2,5 klux a 1 m o 4 lux a 25 m. Se debe acelerar la moto hasta lograr la mayor intensidad de luz.',
                                        "grupo" => 'LUCES',
                                        "tipo" => 'A'
                                    )
                            );
                            break;
                        case "MOTOCARRO":
                            array_push(
                                    $this->defectosMA,
                                    (object) array(
                                        "codigo" => '1.4.4.12.1',
                                        "descripcion" => 'La intensidad de la luz menor a 2.5 klux a 1 m o 4 lux a 25 m. NOTA: Cuando sea necesario, se debe acelerar al motocarro hasta lograr la mayor intensidad de luz.',
                                        "grupo" => 'LUCES',
                                        "tipo" => 'A'
                                    )
                            );
                            break;
                        default:
                            array_push(
                                    $this->defectosMA,
                                    (object) array(
                                        "codigo" => '1.1.4.14.1',
                                        "descripcion" => 'La intensidad en algún haz de luz baja, es inferior a los 2,5 Klux a 1 m ó 4 lux a 25 m.',
                                        "grupo" => 'LUCES',
                                        "tipo" => 'A'
                                    )
                            );
                            break;
                    }
                }
                return $dato . "*";
            }
        }
    }

    function evalLuzMaxTotal($dato, $luzMax) {
        if ($dato !== '' && $this->nombreClase->nombre !== 'MOTOCICLETA' && $this->nombreClase->nombre !== 'MOTOCARRO') {
            if (floatval($luzMax) >= floatval($dato)) {
                return $dato;
            } else {
                if (!$this->ifdefIntensidadTotal) {
                    $this->ifdefIntensidadTotal = true;
                    array_push(
                            $this->defectosMA,
                            (object) array(
                                "codigo" => '1.1.4.14.2',
                                "descripcion" => 'La intensidad sumada de todas las luces que se puedan encender simultáneamente, no puede ser superior a los 225 klux a 1 m de distancia o 360 lux a 25 m.',
                                "grupo" => 'LUCES',
                                "tipo" => 'A'
                            )
                    );
                }
                return $dato . "*";
            }
        }
    }

    //------------------------------------------------------------------------------SUSPENSION
    var $ifdefSuspension;

    public function getSuspension($idhojapruebas) {
        $this->ifdefSuspension = false;
        $data['idhojapruebas'] = $idhojapruebas;
        $data['idtipo_prueba'] = "9";
        $data['order'] = $this->order;
        $result = $this->Mprueba->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            $data['idprueba'] = $r[0]->idprueba;
            $operario = $this->getUsuario($r[0]->idusuario);
            if ($r[0]->estado == '1') {
                $this->aprobado = false;
            }
            //            $suspensionParam = new suspension_param();
            $min = $this->min();
            $suspension = (object)
                    array(
                        'idprueba' => $r[0]->idprueba,
                        'delantera_derecha' => $this->evalSuspension($this->rdnr($this->getResultadoIDCF($data, 142)), $min),
                        'trasera_derecha' => $this->evalSuspension($this->rdnr($this->getResultadoIDCF($data, 144)), $min),
                        'delantera_izquierda' => $this->evalSuspension($this->rdnr($this->getResultadoIDCF($data, 143)), $min),
                        'trasera_izquierda' => $this->evalSuspension($this->rdnr($this->getResultadoIDCF($data, 145)), $min),
                        'minima' => $min,
                        'operario' => $operario->nombres . " " . $operario->apellidos,
                        'documento' => $operario->identificacion
            );
        } else {
            $suspension = (object)
                    array(
                        'idprueba' => '',
                        'delantera_derecha' => '',
                        'trasera_derecha' => '',
                        'delantera_izquierda' => '',
                        'trasera_izquierda' => '',
                        'minima' => '',
                        'operario' => '',
                        'documento' => ''
            );
        }
        return $suspension;
    }

    //..............................................................................EVAL SUSPENSION
    function evalSuspension($dato, $min) {
        if ($dato !== '' && $this->nombreClase->nombre !== 'MOTOCICLETA' && $this->nombreClase->nombre !== 'MOTOCARRO') {
            if (floatval($min) <= floatval($dato)) {
                return $dato;
            } else {
                $this->setDefSus();
                return $dato . "*";
            }
        }
    }

    function setDefSus() {
        if (!$this->ifdefSuspension) {
            $this->ifdefSuspension = true;
            array_push(
                    $this->defectosMA,
                    (object) array(
                        "codigo" => '1.1.8.33.1',
                        "descripcion" => 'Adherencia registrada en cualquier rueda inferior al 40%.',
                        "grupo" => 'SUSPENSION (SUSPENSION, RINES Y LLANTAS)',
                        "tipo" => 'A'
                    )
            );
        }
    }

    //------------------------------------------------------------------------------FRENOS
    var $ifDefDesequilibrioB;
    var $ifDefDesequilibrioA;
    var $ifDefEficaciaTotalA;
    var $ifDefEficaciaAuxilB;

    public function getFrenos($idhojapruebas, $vehiculo) {
        $this->ifDefDesequilibrioB = false;
        $this->ifDefDesequilibrioA = false;
        $this->ifDefEficaciaTotalA = false;
        $this->ifDefEficaciaAuxilB = false;
        $data['idhojapruebas'] = $idhojapruebas;
        $data['idtipo_prueba'] = "7";
        $data['order'] = $this->order;
        $result = $this->Mprueba->get($data);
        //-----------------------------------------BUSCAR PESOS EN SUSPENSION
        $data2['idhojapruebas'] = $idhojapruebas;
        $data2['idtipo_prueba'] = "9";
        $data2['order'] = $this->order;
        $result2 = $this->Mprueba->get($data2);
        if ($result2->num_rows() > 0) {
            $r = $result2->result();
            $data2['idprueba'] = $r[0]->idprueba;
        } else {
            $data2['idprueba'] = "";
        }

        //        echo $vehiculo->numejes;
        if ($result->num_rows() > 0) {
            $r = $result->result();
            $data['idprueba'] = $r[0]->idprueba;
            $operario = $this->getUsuario($r[0]->idusuario);
            if ($r[0]->estado == '1') {
                $this->aprobado = false;
            }
            //            $frenosParam = new frenos_param();
            $min_des_B = $this->min_des_B($vehiculo->tipo_vehiculo);
            $max_des_B = $this->max_des_B($vehiculo->tipo_vehiculo);
            $min_des_A = $this->min_des_A($vehiculo->tipo_vehiculo);
            $max_des_A = $this->max_des_A($vehiculo->tipo_vehiculo);
            $efi_min_total = $this->efi_min($vehiculo->tipo_vehiculo, 'total');
            $efi_min_auxil = $this->efi_min($vehiculo->tipo_vehiculo, 'auxil');
            $peso_1_derecho = $this->getResultadoIDCF_tipo($data, '1', 146);
            $peso_2_derecho = $this->getResultadoIDCF_tipo($data, '2', 146);
            $peso_3_derecho = $this->getResultadoIDCF_tipo($data, '3', 146);
            $peso_4_derecho = $this->getResultadoIDCF_tipo($data, '4', 146);
            $peso_5_derecho = $this->getResultadoIDCF_tipo($data, '5', 146);
            $peso_1_izquierdo = $this->getResultadoIDCF_tipo($data, '1', 147);
            $peso_2_izquierdo = $this->getResultadoIDCF_tipo($data, '2', 147);
            $peso_3_izquierdo = $this->getResultadoIDCF_tipo($data, '3', 147);
            $peso_4_izquierdo = $this->getResultadoIDCF_tipo($data, '4', 147);
            $peso_5_izquierdo = $this->getResultadoIDCF_tipo($data, '5', 147);
            //Si no encuentra pesos en la prueba de frenos, los busca en suspensión
            if (
                    $data2['idprueba'] !== "" &&
                    $peso_1_derecho == "" &&
                    $peso_2_derecho == "" &&
                    $peso_1_izquierdo == "" &&
                    $peso_2_izquierdo == ""
            ) {
                $peso_1_derecho = $this->getResultadoIDCF_tipo($data2, '1', 146);
                $peso_2_derecho = $this->getResultadoIDCF_tipo($data2, '2', 146);
                $peso_1_izquierdo = $this->getResultadoIDCF_tipo($data2, '1', 147);
                $peso_2_izquierdo = $this->getResultadoIDCF_tipo($data2, '2', 147);
            }

            $sum_peso_derecho = intval($peso_1_derecho) +
                    intval($peso_2_derecho) +
                    intval($peso_3_derecho) +
                    intval($peso_4_derecho) +
                    intval($peso_5_derecho);
            $sum_peso_izquierdo = intval($peso_1_izquierdo) +
                    intval($peso_2_izquierdo) +
                    intval($peso_3_izquierdo) +
                    intval($peso_4_izquierdo) +
                    intval($peso_5_izquierdo);
            if (intval($vehiculo->numejes) == 2) {
                $freno_1_derecho = $this->getResultadoIDCF_tipo($data, '1', 148);
                $freno_1_izquierdo = $this->getResultadoIDCF_tipo($data, '1', 149);
                $freno_2_derecho = $this->getResultadoIDCF_tipo($data, '2', 148);
                $freno_2_izquierdo = $this->getResultadoIDCF_tipo($data, '2', 149);
                $freno_3_derecho = '';
                $freno_3_izquierdo = '';
                $freno_4_derecho = '';
                $freno_4_izquierdo = '';
                $freno_5_derecho = '';
                $freno_5_izquierdo = '';
            } else if (intval($vehiculo->numejes) == 3) {
                $freno_1_derecho = $this->getResultadoIDCF_tipo($data, '1', 148);
                $freno_1_izquierdo = $this->getResultadoIDCF_tipo($data, '1', 149);
                $freno_2_derecho = $this->getResultadoIDCF_tipo($data, '2', 148);
                $freno_2_izquierdo = $this->getResultadoIDCF_tipo($data, '2', 149);
                $freno_3_derecho = $this->getResultadoIDCF_tipo($data, '3', 148);
                $freno_3_izquierdo = $this->getResultadoIDCF_tipo($data, '3', 149);
                $freno_4_derecho = '';
                $freno_4_izquierdo = '';
                $freno_5_derecho = '';
                $freno_5_izquierdo = '';
            } else if (intval($vehiculo->numejes) == 4) {
                $freno_1_derecho = $this->getResultadoIDCF_tipo($data, '1', 148);
                $freno_1_izquierdo = $this->getResultadoIDCF_tipo($data, '1', 149);
                $freno_2_derecho = $this->getResultadoIDCF_tipo($data, '2', 148);
                $freno_2_izquierdo = $this->getResultadoIDCF_tipo($data, '2', 149);
                $freno_3_derecho = $this->getResultadoIDCF_tipo($data, '3', 148);
                $freno_3_izquierdo = $this->getResultadoIDCF_tipo($data, '3', 149);
                $freno_4_derecho = $this->getResultadoIDCF_tipo($data, '4', 148);
                $freno_4_izquierdo = $this->getResultadoIDCF_tipo($data, '4', 149);
                $freno_5_derecho = '';
                $freno_5_izquierdo = '';
            } else if (intval($vehiculo->numejes) == 5) {
                $freno_1_derecho = $this->getResultadoIDCF_tipo($data, '1', 148);
                $freno_1_izquierdo = $this->getResultadoIDCF_tipo($data, '1', 149);
                $freno_2_derecho = $this->getResultadoIDCF_tipo($data, '2', 148);
                $freno_2_izquierdo = $this->getResultadoIDCF_tipo($data, '2', 149);
                $freno_3_derecho = $this->getResultadoIDCF_tipo($data, '3', 148);
                $freno_3_izquierdo = $this->getResultadoIDCF_tipo($data, '3', 149);
                $freno_4_derecho = $this->getResultadoIDCF_tipo($data, '4', 148);
                $freno_4_izquierdo = $this->getResultadoIDCF_tipo($data, '4', 149);
                $freno_5_derecho = $this->getResultadoIDCF_tipo($data, '5', 148);
                $freno_5_izquierdo = $this->getResultadoIDCF_tipo($data, '5', 149);
            }

            $desequilibrio1 = $this->getResultadoIDCF_tipo($data, '1', 150);
            $desequilibrio2 = $this->getResultadoIDCF_tipo($data, '2', 150);
            $desequilibrio3 = $this->getResultadoIDCF_tipo($data, '3', 150);
            $desequilibrio4 = $this->getResultadoIDCF_tipo($data, '4', 150);
            $desequilibrio5 = $this->getResultadoIDCF_tipo($data, '5', 150);
            $eficacia_total = $this->getResultadoIDCF_tipo($data, 'eficacia_total', 151);
            $eficacia_auxiliar = $this->getResultadoIDCF_tipo($data, 'eficacia_auxiliar', 152);

            $sum_freno_aux_derecho = $this->getSumFuerzaAux($data, $vehiculo->numejes, 148);
            $sum_freno_aux_izquierdo = $this->getSumFuerzaAux($data, $vehiculo->numejes, 149);
            //            if ($vehiculo->tipo_vehiculo === '3' ) {
            if ($this->nombreClase->nombre === 'MOTOCICLETA') {
                $efi_min_auxil = '';
                $sum_freno_aux_derecho = '';
                $sum_freno_aux_izquierdo = '';
                $sum_peso_derecho = '';
                $sum_peso_izquierdo = '';
                $min_des_A = '';
                $min_des_B = '';
            }


            $frenos = (object)
                    array(
                        'idprueba' => $r[0]->idprueba,
                        'peso_1_derecho' => $this->rdnr($peso_1_derecho),
                        'peso_2_derecho' => $this->rdnr($peso_2_derecho),
                        'peso_3_derecho' => $this->rdnr($peso_3_derecho),
                        'peso_4_derecho' => $this->rdnr($peso_4_derecho),
                        'peso_5_derecho' => $this->rdnr($peso_5_derecho),
                        'peso_1_izquierdo' => $this->rdnr($peso_1_izquierdo),
                        'peso_2_izquierdo' => $this->rdnr($peso_2_izquierdo),
                        'peso_3_izquierdo' => $this->rdnr($peso_3_izquierdo),
                        'peso_4_izquierdo' => $this->rdnr($peso_4_izquierdo),
                        'peso_5_izquierdo' => $this->rdnr($peso_5_izquierdo),
                        'freno_1_derecho' => $this->rdnr($freno_1_derecho),
                        'freno_2_derecho' => $this->rdnr($freno_2_derecho),
                        'freno_3_derecho' => $this->rdnr($freno_3_derecho),
                        'freno_4_derecho' => $this->rdnr($freno_4_derecho),
                        'freno_5_derecho' => $this->rdnr($freno_5_derecho),
                        'freno_1_izquierdo' => $this->rdnr($freno_1_izquierdo),
                        'freno_2_izquierdo' => $this->rdnr($freno_2_izquierdo),
                        'freno_3_izquierdo' => $this->rdnr($freno_3_izquierdo),
                        'freno_4_izquierdo' => $this->rdnr($freno_4_izquierdo),
                        'freno_5_izquierdo' => $this->rdnr($freno_5_izquierdo),
                        'desequilibrio_1' => $this->evalFrenosDesequilibrio($this->rdnr($desequilibrio1), $min_des_B, $max_des_B, $min_des_A, $max_des_A),
                        'desequilibrio_2' => $this->evalFrenosDesequilibrio($this->rdnr($desequilibrio2), $min_des_B, $max_des_B, $min_des_A, $max_des_A),
                        'desequilibrio_3' => $this->evalFrenosDesequilibrio($this->rdnr($desequilibrio3), $min_des_B, $max_des_B, $min_des_A, $max_des_A),
                        'desequilibrio_4' => $this->evalFrenosDesequilibrio($this->rdnr($desequilibrio4), $min_des_B, $max_des_B, $min_des_A, $max_des_A),
                        'desequilibrio_5' => $this->evalFrenosDesequilibrio($this->rdnr($desequilibrio5), $min_des_B, $max_des_B, $min_des_A, $max_des_A),
                        'eficacia_total' => $this->evalEfiTotal($this->rdnr($eficacia_total), $efi_min_total),
                        'eficacia_auxiliar' => $this->evalEfiAuxil($this->rdnr($eficacia_auxiliar), $efi_min_auxil),
                        'sum_peso_derecho' => $this->rdnr($sum_peso_derecho),
                        'sum_peso_izquierdo' => $this->rdnr($sum_peso_izquierdo),
                        'sum_freno_aux_derecho' => $this->rdnr($sum_freno_aux_derecho),
                        'sum_freno_aux_izquierdo' => $this->rdnr($sum_freno_aux_izquierdo),
                        'n_desequilibrio_A' => $min_des_A,
                        'n_desequilibrio_B' => $min_des_B,
                        'n_eficacia_total' => $efi_min_total,
                        'n_eficacia_auxiliar' => $efi_min_auxil,
                        'operario' => $operario->nombres . " " . $operario->apellidos,
                        'documento' => $operario->identificacion
            );
        } else {
            $frenos = (object)
                    array(
                        'idprueba' => '',
                        'peso_1_derecho' => '',
                        'peso_2_derecho' => '',
                        'peso_3_derecho' => '',
                        'peso_4_derecho' => '',
                        'peso_5_derecho' => '',
                        'peso_1_izquierdo' => '',
                        'peso_2_izquierdo' => '',
                        'peso_3_izquierdo' => '',
                        'peso_4_izquierdo' => '',
                        'peso_5_izquierdo' => '',
                        'freno_1_derecho' => '',
                        'freno_2_derecho' => '',
                        'freno_3_derecho' => '',
                        'freno_4_derecho' => '',
                        'freno_5_derecho' => '',
                        'freno_1_izquierdo' => '',
                        'freno_2_izquierdo' => '',
                        'freno_3_izquierdo' => '',
                        'freno_4_izquierdo' => '',
                        'freno_5_izquierdo' => '',
                        'desequilibrio_1' => '',
                        'desequilibrio_2' => '',
                        'desequilibrio_3' => '',
                        'desequilibrio_4' => '',
                        'desequilibrio_5' => '',
                        'eficacia_total' => '',
                        'eficacia_auxiliar' => '',
                        'sum_peso_derecho' => '',
                        'sum_peso_izquierdo' => '',
                        'sum_freno_aux_derecho' => '',
                        'sum_freno_aux_izquierdo' => '',
                        'n_desequilibrio_A' => '',
                        'n_desequilibrio_B' => '',
                        'n_eficacia_total' => '',
                        'n_eficacia_auxiliar' => '',
                        'operario' => '',
                        'documento' => ''
            );
        }
        return $frenos;
    }

    //..............................................................................EVAL FRENOS
    function evalFrenosDesequilibrio($dato, $minB, $maxB, $minA, $maxA) {
        if ($dato !== '' && $this->nombreClase->nombre !== 'MOTOCICLETA') {
            if (floatval($dato) < floatval($minB)) {
                return $dato;
            } else {
                if (floatval($dato) >= floatval($minB) && floatval($dato) < floatval($maxB)) {
                    if (!$this->ifDefDesequilibrioB) {
                        $this->ifDefDesequilibrioB = true;
                        if ($this->nombreClase->nombre == "MOTOCARRO") {
                            array_push(
                                    $this->defectosMB,
                                    (object) array(
                                        "codigo" => '1.4.6.20.2',
                                        "descripcion" => 'Desequilibrio de las fuerzas de frenado entre las ruedas de un mismo eje, en cualquiera de sus ejes, entre el 20% y 30%.',
                                        "grupo" => 'FRENOS',
                                        "tipo" => 'B'
                                    )
                            );
                        } else {
                            array_push(
                                    $this->defectosMB,
                                    (object) array(
                                        "codigo" => '1.1.7.31.2',
                                        "descripcion" => 'Desequilibrio de las fuerzas de frenado entre las ruedas de un mismo eje, en cualquiera de sus ejes, entre el 20% y 30%.',
                                        "grupo" => 'FRENOS',
                                        "tipo" => 'B'
                                    )
                            );
                        }
                    }
                } elseif (floatval($dato) >= floatval($minA)) {
                    if (!$this->ifDefDesequilibrioA) {
                        $this->ifDefDesequilibrioA = true;
                        if ($this->nombreClase->nombre == "MOTOCARRO") {
                            array_push(
                                    $this->defectosMA,
                                    (object) array(
                                        "codigo" => '1.4.6.20.1',
                                        "descripcion" => 'Desequilibrio de las fuerzas de frenado entre las ruedas de un mismo eje, en cualquiera de sus ejes, superior el 30%.',
                                        "grupo" => 'FRENOS',
                                        "tipo" => 'A'
                                    )
                            );
                        } else {
                            array_push(
                                    $this->defectosMA,
                                    (object) array(
                                        "codigo" => '1.1.7.31.1',
                                        "descripcion" => 'Desequilibrio de las fuerzas de frenado entre las ruedas de un mismo eje, en cualquiera de sus ejes, superior el 30%.',
                                        "grupo" => 'FRENOS',
                                        "tipo" => 'A'
                                    )
                            );
                        }
                    }
                }
                return $dato . "*";
            }
        }
    }

    function evalEfiTotal($dato, $min) {
        if ($dato !== '') {
            if (floatval($dato) >= floatval($min)) {
                return $dato;
            } else {
                $this->setDefFren();
                return $dato . "*";
            }
        }
    }

    private function setDefFren() {
        if (!$this->ifDefEficaciaTotalA) {
            $this->ifDefEficaciaTotalA = true;
            switch ($this->nombreClase->nombre) {
                case "MOTOCICLETA":
                    array_push(
                            $this->defectosMA,
                            (object) array(
                                "codigo" => '1.2.6.15.1',
                                "descripcion" => 'Eficacia de frenado inferior el 30%.',
                                "grupo" => 'FRENOS',
                                "tipo" => 'A'
                            )
                    );
                    break;
                case "MOTOCARRO":
                    array_push(
                            $this->defectosMA,
                            (object) array(
                                "codigo" => '1.4.6.19.1',
                                "descripcion" => 'Eficacia de frenado inferior el 30%.',
                                "grupo" => 'FRENOS',
                                "tipo" => 'A'
                            )
                    );
                    break;
                default:
                    array_push(
                            $this->defectosMA,
                            (object) array(
                                "codigo" => '1.1.7.30.1',
                                "descripcion" => 'Eficacia de frenado inferior al 50%.',
                                "grupo" => 'FRENOS',
                                "tipo" => 'A'
                            )
                    );
                    break;
            }
        }
    }

    function evalEfiAuxil($dato, $min) {
        if ($dato !== '' && $this->nombreClase->nombre !== 'MOTOCICLETA') {
            if (floatval($dato) >= floatval($min)) {
                return $dato;
            } else {
                if (!$this->ifDefEficaciaAuxilB) {
                    $this->ifDefEficaciaAuxilB = true;
                    switch ($this->nombreClase->nombre) {
                        case "MOTOCARRO":
                            array_push(
                                    $this->defectosMB,
                                    (object) array(
                                        "codigo" => '1.4.6.20.3',
                                        "descripcion" => 'Freno de estacionamiento (de parqueo de mano) con una eficacia inferior el 18%.',
                                        "grupo" => 'FRENOS',
                                        "tipo" => 'B'
                                    )
                            );
                            break;
                        default:
                            array_push(
                                    $this->defectosMB,
                                    (object) array(
                                        "codigo" => '1.1.7.30.2',
                                        "descripcion" => 'Freno de estacionamiento (de parqueo de mano) con una eficacia inferior el 18%.',
                                        "grupo" => 'FRENOS',
                                        "tipo" => 'B'
                                    )
                            );
                            break;
                    }
                }
                return $dato . "*";
            }
        }
    }

    //------------------------------------------------------------------------------ALINEADOR
    var $ifDefAlineadorA;
    var $ifDefAlineadorB;

    public function getAlineacion($idhojapruebas) {
        $this->ifDefAlineadorA = false;
        $this->ifDefAlineadorB = false;
        $data['idhojapruebas'] = $idhojapruebas;
        $data['idtipo_prueba'] = "10";
        $data['order'] = $this->order;
        $result = $this->Mprueba->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            $data['idprueba'] = $r[0]->idprueba;
            if ($r[0]->estado == '1') {
                $this->aprobado = false;
            }
            $operario = $this->getUsuario($r[0]->idusuario);
            //            $alineacionParam = new alineacion_param();
            $minmax = $this->minmaxAli();
            $alineacion = (object)
                    array(
                        'idprueba' => $r[0]->idprueba,
                        'alineacion_1' => $this->evalAlineacion($this->rdnr($this->getResultadoIDCF_tipo($data, '1', 141)), $minmax),
                        'alineacion_2' => $this->evalAlineacionT($this->rdnr($this->getResultadoIDCF_tipo($data, '2', 141)), $minmax),
                        'alineacion_3' => $this->evalAlineacionT($this->rdnr($this->getResultadoIDCF_tipo($data, '3', 141)), $minmax),
                        'alineacion_4' => $this->evalAlineacionT($this->rdnr($this->getResultadoIDCF_tipo($data, '4', 141)), $minmax),
                        'alineacion_5' => $this->evalAlineacionT($this->rdnr($this->getResultadoIDCF_tipo($data, '5', 141)), $minmax),
                        'minmax' => "(+/-)" . $minmax,
                        'operario' => $operario->nombres . " " . $operario->apellidos,
                        'documento' => $operario->identificacion
            );
        } else {
            $alineacion = (object)
                    array(
                        'idprueba' => '',
                        'alineacion_1' => '',
                        'alineacion_2' => '',
                        'alineacion_3' => '',
                        'alineacion_4' => '',
                        'alineacion_5' => '',
                        'minmax' => '',
                        'operario' => '',
                        'documento' => ''
            );
        }
        return $alineacion;
    }

    //..............................................................................EVAL ALINEACION
    function evalAlineacion($dato, $minMax) {
        if ($dato !== '' && $this->nombreClase->nombre !== 'MOTOCICLETA' && $this->nombreClase->nombre !== 'MOTOCARRO') {
            if (floatval($minMax) * -1 <= floatval($dato) && floatval($minMax) >= floatval($dato)) {
                return $dato;
            } else {
                $this->setDefAli();
                return $dato . "*";
            }
        }
    }

    private function setDefAli() {
        if (!$this->ifDefAlineadorA) {
            $this->ifDefAlineadorA = true;
            array_push(
                    $this->defectosMA,
                    (object) array(
                        "codigo" => '1.1.10.36.1',
                        "descripcion" => 'Desviación lateral en el primer eje superior a ±10 [m/km]',
                        "grupo" => 'DIRECCION',
                        "tipo" => 'A'
                    )
            );
        }
    }

    function evalAlineacionT($dato, $minMax) {
        if ($dato !== '' && $this->nombreClase->nombre !== 'MOTOCICLETA' && $this->nombreClase->nombre !== 'MOTOCARRO') {
            if (floatval($minMax) * -1 <= floatval($dato) && floatval($minMax) >= floatval($dato)) {
                return $dato;
            } else {
                if (!$this->ifDefAlineadorB) {
                    $this->ifDefAlineadorB = true;
                    array_push(
                            $this->defectosMB,
                            (object) array(
                                "codigo" => '1.1.10.36.2',
                                "descripcion" => 'Desviación lateral para los demás ejes superior a ±10 [m/km].',
                                "grupo" => 'DIRECCION',
                                "tipo" => 'B'
                            )
                    );
                }
                return $dato . "*";
            }
        }
    }

    //------------------------------------------------------------------------------TAXIMETRO
    var $ifDefTaximetroT;
    var $ifDefTaximetroD;

    public function getTaximetro($idhojapruebas) {
        $this->ifDefTaximetroT = false;
        $this->ifDefTaximetrodD = false;
        $data['idhojapruebas'] = $idhojapruebas;
        $data['idtipo_prueba'] = "6";
        $data['order'] = $this->order;
        $result = $this->Mprueba->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            $data['idprueba'] = $r[0]->idprueba;
            if ($r[0]->estado == '1') {
                $this->aprobado = false;
            }
            $operario = $this->getUsuario($r[0]->idusuario);
            //            $taximetroParam = new taximetro_param();
            $minmax = $this->minmaxTax();
            $tieneTaximetro = $this->getResultadoDefecto($data, 89, 'Inspeccion visual taximetro');
            if ($tieneTaximetro == 'true')
                $tieneTaximetro = 'false';
            $taximetroVisible = $this->getResultadoDefecto($data, 92, 'Inspeccion visual taximetro');
            if ($taximetroVisible == 'true')
                $taximetroVisible = 'false';
            $taximetro = (object)
                    array(
                        'idprueba' => $r[0]->idprueba,
                        'r_llanta' => $this->getResultado($data, 'Rllanta', ''),
                        'tiempo' => $this->evalTaximetroTiempo($this->rdnr($this->getResultado($data, 'error_tiempo_nuevo', '')), $minmax),
                        'distancia' => $this->evalTaximetroDistancia($this->rdnr($this->getResultado($data, 'error_distancia_nuevo', '')), $minmax),
                        'minmax' => "(+/-)" . $minmax,
                        'aplicaTaximetro' => 'true',
                        'tieneTaximetro' => $tieneTaximetro,
                        'taximetroVisible' => $taximetroVisible,
                        'operario' => $operario->nombres . " " . $operario->apellidos,
                        'documento' => $operario->identificacion
            );
        } else {
            $taximetro = (object)
                    array(
                        'idprueba' => '',
                        'r_llanta' => '',
                        'tiempo' => '',
                        'distancia' => '',
                        'minmax' => '',
                        'aplicaTaximetro' => 'false',
                        'tieneTaximetro' => '',
                        'taximetroVisible' => '',
                        'operario' => '',
                        'documento' => ''
            );
        }
        return $taximetro;
    }

    //------------------------------------------------------------------------------SONOMETRO


    public function getSonometro($idhojapruebas) {
        $data['idhojapruebas'] = $idhojapruebas;
        $data['idtipo_prueba'] = "4";
        $data['order'] = $this->order;
        $result = $this->Mprueba->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            $data['idprueba'] = $r[0]->idprueba;
            $operario = $this->getUsuario($r[0]->idusuario);
            $sonometro = (object)
                    array(
                        'idprueba' => $r[0]->idprueba,
                        'valor_ruido_motor1' => $this->rdnr($this->getResultado($data, 'valor_ruido_motor1', '')),
                        'maximo_ruido_motor' => $this->rdnr($this->getResultado($data, 'maximo_ruido_motor', '')),
                        'operario' => $operario->nombres . " " . $operario->apellidos,
                        'documento' => $operario->identificacion
            );
        } else {
            $sonometro = (object)
                    array(
                        'idprueba' => '',
                        'valor_ruido_motor1' => '',
                        'maximo_ruido_motor' => '',
                        'operario' => '',
                        'documento' => ''
            );
        }
        return $sonometro;
    }

    //..............................................................................EVAL TAXIMETRO


    function evalTaximetroTiempo($dato, $minMax) {
        if ($dato !== '') {
            if (floatval($minMax) * -1 <= floatval($dato) && floatval($minMax) >= floatval($dato)) {
                return $dato;
            } else {
                $this->setDefTax();
                return $dato . "*";
            }
        }
    }

    private function setDefTax() {
        if (!$this->ifDefTaximetroT) {
            $this->ifDefTaximetroT = true;
            array_push(
                    $this->defectosMA,
                    (object) array(
                        "codigo" => '1.1.9.34.3',
                        "descripcion" => 'Error en la medida de tiempo, por fuera de ± 2%, tomada en un tiempo cualquiera entre 60 s a 180 s.',
                        "grupo" => 'TAXIMETROS',
                        "tipo" => 'A'
                    )
            );
        }
    }

    function evalTaximetroDistancia($dato, $minMax) {
        if ($dato !== '') {
            if (floatval($minMax) * -1 <= floatval($dato) && floatval($minMax) >= floatval($dato)) {
                return $dato;
            } else {
                if (!$this->ifDefTaximetroD) {
                    $this->ifDefTaximetroD = true;
                    array_push(
                            $this->defectosMA,
                            (object) array(
                                "codigo" => '1.1.9.34.2',
                                "descripcion" => 'Error en la medida de distancia, por fuera de ± 2%, tomada en una distancia cualquiera entre 300 m y 1 km.',
                                "grupo" => 'TAXIMETROS',
                                "tipo" => 'A'
                            )
                    );
                }
                return $dato . "*";
            }
        }
    }

    //------------------------------------------------------------------------------GASES
    var $ifDefGases;

    public function getGases($idhojapruebas, $vehiculo) {
        $this->ifDefGases = false;
        $data['idhojapruebas'] = $idhojapruebas;
        $data['idtipo_prueba'] = "3";
        $data['order'] = $this->order;
        $result = $this->Mprueba->get($data);
        $aprobadoGases = true;
        if ($result->num_rows() > 0) {
            $r = $result->result();
            $data['idprueba'] = $r[0]->idprueba;
            $operario = $this->getUsuario($r[0]->idusuario);

            if ($r[0]->estado == '1') {
                $this->aprobado = false;
                $aprobadoGases = false;
            }
            //            $gasesParam = new gases_param();
            $CoFlag = $this->getCoFlag($vehiculo->ano_modelo, $vehiculo->tipo_vehiculo);
            $CoFlag_ = $this->getCoFlag($vehiculo->ano_modelo, $vehiculo->tipo_vehiculo);
            $Co2Flag = $this->getCo2Flag($vehiculo->tipo_vehiculo);
            $Co2Flag_ = $this->getCo2Flag($vehiculo->tipo_vehiculo);
            $O2Flag = $this->getO2Flag($vehiculo->tipo_vehiculo);
            $O2Flag_ = $this->getO2Flag($vehiculo->tipo_vehiculo);
            $HcFlag = $this->getHcFlag($vehiculo->ano_modelo, $vehiculo->tipo_vehiculo, $vehiculo->tiempos);
            $HcFlag_ = $this->getHcFlag($vehiculo->ano_modelo, $vehiculo->tipo_vehiculo, $vehiculo->tiempos);
            if ($r[0]->estado !== '0') {
                $rpm_ralenti = $this->rdnr($this->getResultado($data, 'rpm_ralenti', ''));
                if ($vehiculo->tipo_vehiculo !== "3") {
                    $co_ralenti = $this->evalGases($this->getResultado($data, 'co_ralenti', ''), $CoFlag, "<=", 2);
                    $hc_ralenti = $this->evalGases($this->getResultado($data, 'hc_ralenti', ''), $HcFlag, "<=", 0);
                    $co2_ralenti = $this->evalGases($this->getResultado($data, 'co2_ralenti', ''), $Co2Flag, ">=", 1);
                    $o2_ralenti = $this->evalGases($this->getResultado($data, 'o2_ralenti', ''), $O2Flag, "<=", 1);
                    $hc_crucero = $this->evalGases($this->getResultado($data, 'hc_crucero', ''), $HcFlag, "<=", 0);
                    $co_crucero = $this->evalGases($this->getResultado($data, 'co_crucero', ''), $CoFlag, "<=", 2);
                    $co2_crucero = $this->evalGases($this->getResultado($data, 'co2_crucero', ''), $Co2Flag, ">=", 1);
                    $o2_crucero = $this->evalGases($this->getResultado($data, 'o2_crucero', ''), $O2Flag, "<=", 1);
                    $rpm_crucero = $this->rdnr($this->getResultado($data, 'rpm_crucero', ''));
                } else {
                    if (intval($vehiculo->numero_exostos) > 1) {
                        $data['idprueba'] = intval($data['idprueba']) - (intval($vehiculo->numero_exostos) - 1);
                        $co_ralenti = $this->evalGases($this->getResultadoMaxGases($data, 'co_ralenti'), $CoFlag, "<=", 2);
                        $hc_ralenti = $this->evalGases($this->getResultadoMaxGases($data, 'hc_ralenti'), $HcFlag, "<=", 0);
                        $co2_ralenti = $this->rdnr($this->getResultadoMaxGases($data, 'co2_ralenti'));
                        $o2_ralenti = $this->rdnr($this->getResultadoMaxGases($data, 'o2_ralenti'));
                        $rpm_ralenti = $this->rdnr($this->getResultadoMaxGases($data, 'rpm_ralenti'));
                        $data['idprueba'] = intval($data['idprueba']) + (intval($vehiculo->numero_exostos) - 1);
                    } else {
                        $co_ralenti = $this->evalGases($this->getResultado($data, 'co_ralenti', ''), $CoFlag, "<=", 2);
                        $hc_ralenti = $this->evalGases($this->getResultado($data, 'hc_ralenti', ''), $HcFlag, "<=", 0);
                        $co2_ralenti = $this->rdnr($this->getResultado($data, 'co2_ralenti', ''));
                        $o2_ralenti = $this->rdnr($this->getResultado($data, 'o2_ralenti', ''));
                    }
                    $co2_crucero = '';
                    $o2_crucero = '';
                    $hc_crucero = '';
                    $co_crucero = '';
                    $rpm_crucero = '';
                }
            } else {
                $co_ralenti = '';
                $hc_ralenti = '';
                $co2_ralenti = '';
                $hc_crucero = '';
                $co_crucero = '';
                $co2_crucero = '';
                $o2_crucero = '';
                $o2_ralenti = '';
                $rpm_ralenti = '';
                $rpm_crucero = '';
            }
            $CoFlag = '&lt;= ' . $CoFlag;
            if ($vehiculo->tipo_vehiculo !== "3") {
                $Co2Flag = " &gt;= " . $Co2Flag;
                $O2Flag = "&lt;= " . $O2Flag;
            } else {
                $Co2Flag = "";
                $Co2Flag_ = "";
                $O2Flag = "";
                $O2Flag_ = "";
            }
            $HcFlag = "&lt;= " . $HcFlag;
            //            echo($vehiculo->scooter);
            $temperatura_ambiente = $this->rdnr($this->getResultado($data, 'temperatura_ambiente', ''));
            $humedad = $this->rdnr($this->getResultado($data, 'humedad', ''));
            if ($vehiculo->tipo_vehiculo !== "3") {
                if ($vehiculo->convertidor == "SI") {
                    $temperatura = "";
                } elseif ($vehiculo->convertidor == "N.A.") {
                    $temperatura = "0";
                } else {
                    $temperatura = round($this->getResultado($data, 'temperatura_aceite', ''));
                }
            } else {
                if ($vehiculo->scooter == "1") {
                    $temperatura = "0";
                } else {
                    if (intval($vehiculo->numero_exostos) > 1) {
                        $data['idprueba'] = intval($data['idprueba']) - (intval($vehiculo->numero_exostos) - 1);
                        $temperatura = $this->rdnr($this->getResultadoMaxGases($data, 'temperatura_aceite'));
                        $temperatura_ambiente = $this->rdnr($this->getResultadoMaxGases($data, 'temperatura_ambiente'));
                        $humedad = $this->rdnr($this->getResultadoMaxGases($data, 'humedad'));
                        $data['idprueba'] = intval($data['idprueba']) + (intval($vehiculo->numero_exostos) - 1);
                    } else {
                        $temperatura = round($this->getResultadoTmpMot($data, 'temperatura_aceite', ''));
                    }
                }
            }


            $gases = (object)
                    array(
                        'idprueba' => $r[0]->idprueba,
                        'rpm_ralenti' => $rpm_ralenti,
                        'co_ralenti' => $co_ralenti,
                        'co2_ralenti' => $co2_ralenti,
                        'o2_ralenti' => $o2_ralenti,
                        'hc_ralenti' => $hc_ralenti,
                        'rpm_crucero' => $rpm_crucero,
                        'co_crucero' => $co_crucero,
                        'co2_crucero' => $co2_crucero,
                        'o2_crucero' => $o2_crucero,
                        'hc_crucero' => $hc_crucero,
                        'temperatura' => $this->rdnr($temperatura),
                        'temperatura_ambiente' => $temperatura_ambiente,
                        'humedad' => $humedad,
                        'CoFlag' => $CoFlag,
                        'Co2Flag' => $Co2Flag,
                        'O2Flag' => $O2Flag,
                        'HcFlag' => $HcFlag,
                        'CoFlag_' => $CoFlag_,
                        'Co2Flag_' => $Co2Flag_,
                        'O2Flag_' => $O2Flag_,
                        'HcFlag_' => $HcFlag_,
                        'fugasTuboEscape' => $this->getResultadoDefecto($data, 328, 'T'),
                        'fugasSilenciador' => $this->getResultadoDefecto($data, 378, 'T'),
                        'tapaCombustible' => $this->getResultadoDefecto($data, 331, 'T'),
                        'tapaAceite' => $this->getResultadoDefecto($data, 330, 'T'),
                        'salidasAdicionales' => $this->getResultadoDefecto($data, 329, 'T'),
                        'instalacionAccesorios' => $this->getResultadoDefecto($data, 335, 'T'),
                        'fallaSistemaRefrigeracion' => $this->getResultadoDefecto($data, 336, 'T'),
                        'filtroAire' => $this->getResultadoDefecto($data, 334, 'T'),
                        'sistemaRecirculacion' => $this->getResultadoDefecto($data, 337, 'T'),
                        'presenciaHumos' => $this->getResultadoDefecto($data, 333, 'T'),
                        'revolucionesFueraRango' => $this->getResultadoDefecto($data, 332, 'T'),
                        'lucesNoEncienden' => $this->getResultadoDefecto($data, 750, 'T'),
                        'soporteCentral' => $this->getResultadoDefecto($data, 751, 'T'),
                        'dilucion' => $this->getResultadoDefecto($data, 'DILUSION EXCESIVA', 'observaciones'),
                        'operario' => $operario->nombres . " " . $operario->apellidos,
                        'documento' => $operario->identificacion
            );
            if ($r[0]->estado == '0') {
                $gases = $this->getGasesEmpty();
            }
            if ($vehiculo->tipo_vehiculo !== "3") {
                $this->setDefAnormalesGas($gases->fugasTuboEscape, '3.1.1.1.1', "Existencia de fugas en el tubo, uniones del múltiple y silenciador del sistema de escape del vehículo.");
                $this->setDefAnormalesGas($gases->fugasSilenciador, '3.1.1.1.1', "Existencia de fugas en el tubo, uniones del múltiple y silenciador del sistema de escape del vehículo.");
                $this->setDefAnormalesGas($gases->salidasAdicionales, '3.1.1.1.2', "Salidas adicionales en el sistema de escape diferentes a las de diseño original del vehículo.");
                $this->setDefAnormalesGas($gases->tapaAceite, '3.1.1.1.3', "Ausencia de tapones de aceite o fugas en el mismo.");
                $this->setDefAnormalesGas($gases->tapaCombustible, '3.1.1.1.4', "Ausencia de tapas o tapones de combustible o fugas del mismo.");
                $this->setDefAnormalesGas($gases->filtroAire, '3.1.1.1.5', "Sistema de admisión de aire en mal estado (filtro roto o deformado) o ausencia del filtro de aire.");
                $this->setDefAnormalesGas($gases->sistemaRecirculacion, '3.1.1.1.6', "Desconexión del sistema de recirculación de gases provenientes del Cárter del Motor. (Por ejemplo válvula de ventilación positiva del Cárter).");
                $this->setDefAnormalesGas($gases->instalacionAccesorios, '3.1.1.1.7', "Instalación de accesorios o deformaciones en el tubo de escape que no permitan la introducción de la sonda.");
                $this->setDefAnormalesGas($gases->fallaSistemaRefrigeracion, '3.1.1.1.8', "Incorrecta operación del sistema de refrigeración, cuya verificación se hará por medio de inspección.");
                $this->setDefAnormalesGas($gases->presenciaHumos, '3.1.1.1.9', "Presencia de humo negro o azul.");
                $this->setDefAnormalesGas($gases->revolucionesFueraRango, '3.1.1.1.10', "Revoluciones fuera de rango.");
                $this->setDefAnormalesGas($gases->lucesNoEncienden, '1.1.6.16.1', "Las luces del vehículo no encienden.");
                if ($this->defAnormaGases) {
                    $gases->temperatura = '';
                    $gases->rpm_ralenti = '';
                    $gases->co_ralenti = '';
                    $gases->co2_ralenti = '';
                    $gases->o2_ralenti = '';
                    $gases->hc_ralenti = '';
                    $gases->rpm_crucero = '';
                    $gases->co_crucero = '';
                    $gases->co2_crucero = '';
                    $gases->o2_crucero = '';
                    $gases->hc_crucero = '';
                }
            } else {
                $this->setDefAnormalesGas($gases->fugasTuboEscape, '4.1.1.1.1', "Existencia de fugas en el tubo, uniones del múltiple y silenciador del sistema de escape del vehículo.");
                $this->setDefAnormalesGas($gases->fugasSilenciador, '4.1.1.1.1', "Existencia de fugas en el tubo, uniones del múltiple y silenciador del sistema de escape del vehículo.");
                $this->setDefAnormalesGas($gases->salidasAdicionales, '4.1.1.1.2', "Salidas adicionales en el sistema de escape diferentes a las de diseño original del vehículo.");
                $this->setDefAnormalesGas($gases->tapaAceite, '4.1.1.1.3', "Ausencia de tapones de aceite o fugas en el mismo.");
                $this->setDefAnormalesGas($gases->tapaCombustible, '4.1.1.1.4', "Presencia tapa llenado combustible.");
                $this->setDefAnormalesGas($gases->revolucionesFueraRango, '4.1.1.1.5', "Revoluciones fuera de rango.");
                $this->setDefAnormalesGas($gases->salidasAdicionales, '4.1.1.1.6', "Salidas adicionales a las del diseño.");
                $this->setDefAnormalesGas($gases->presenciaHumos, '4.1.1.1.7', "Presencia de humo negro o azul (solo para motores 4T).");
                if ($this->nombreClase->nombre == 'MOTOCARRO') {
                    $this->setDefAnormalesGas($gases->lucesNoEncienden, '1.4.5.13.1', "Las luces del vehículo no encienden.");
                } else {
                    $this->setDefAnormalesGas($gases->lucesNoEncienden, '1.2.5.8.1', "Las luces del vehículo no encienden.");
                    $this->setDefAnormalesGas($gases->soporteCentral, '1.2.5.8.1', "El vehículo no tiene soporte central.");
                }
                if ($this->defAnormaGases) {
                    $gases->rpm_ralenti = '';
                    $gases->co_ralenti = '';
                    $gases->co2_ralenti = '';
                    $gases->o2_ralenti = '';
                    $gases->hc_ralenti = '';
                }
            }
        } else {
            $gases = $this->getGasesEmpty();
        }
        if (!$aprobadoGases) {
            $this->setDefGas();
        }
        return $gases;
    }

    var $defAnormaGases = false;

    private function setDefAnormalesGas($defecto_, $codigo, $descripcion) {
        if ($defecto_ == 'true') {
            $this->defAnormaGases = true;
            array_push(
                    $this->observaciones,
                    (object) array(
                        "codigo" => $codigo,
                        "descripcion" => $descripcion
                    )
            );
        }
    }

    private function getGasesEmpty() {
        $gases = (object)
                array(
                    'idprueba' => '',
                    'rpm_ralenti' => '',
                    'co_ralenti' => '',
                    'co2_ralenti' => '',
                    'o2_ralenti' => '',
                    'hc_ralenti' => '',
                    'rpm_crucero' => '',
                    'co_crucero' => '',
                    'co2_crucero' => '',
                    'o2_crucero' => '',
                    'hc_crucero' => '',
                    'temperatura' => '',
                    'temperatura_ambiente' => '',
                    'humedad' => '',
                    'CoFlag' => '',
                    'Co2Flag' => '',
                    'O2Flag' => '',
                    'HcFlag' => '',
                    'CoFlag_' => '',
                    'Co2Flag_' => '',
                    'O2Flag_' => '',
                    'HcFlag_' => '',
                    'fugasTuboEscape' => '',
                    'fugasSilenciador' => '',
                    'tapaCombustible' => '',
                    'tapaAceite' => '',
                    'salidasAdicionales' => '',
                    'instalacionAccesorios' => '',
                    'fallaSistemaRefrigeracion' => '',
                    'filtroAire' => '',
                    'sistemaRecirculacion' => '',
                    'presenciaHumos' => '',
                    'revolucionesFueraRango' => '',
                    'lucesNoEncienden' => '',
                    'soporteCentral' => '',
                    'dilucion' => '',
                    'operario' => '',
                    'documento' => ''
        );
        return $gases;
    }

    //..............................................................................EVAL GASES
    function evalGases($dato, $flag, $cond, $numDec) {
        if ($cond == "<=") {
            if (floatval($dato) <= floatval($flag)) {
                return $this->rdnr(floatval($dato));
            } else {
                $this->setDefGas();
                //                echo strval(round(floatval($dato), $numDec). "*");
                return $this->rdnr(floatval($dato)) . "*";
            }
        } else {
            if (floatval($dato) >= floatval($flag)) {
                return round(floatval($dato), $numDec);
            } else {
                $this->setDefGas();
                return $this->rdnr(floatval($dato)) . "*";
            }
        }
    }

    function setDefGas() {
        if (!$this->ifDefGases) {
            $this->ifDefGases = true;
            switch ($this->nombreClase->nombre) {
                case "MOTOCICLETA":
                    array_push(
                            $this->defectosMA,
                            (object) array(
                                "codigo" => '1.2.5.8.1',
                                "descripcion" => 'Concentraciones de gases y sustancias contaminantes mayores a las establecidas por la autoridad competente.',
                                "grupo" => 'EMISIONES(GASES, ELEMENTOS PARA PRODUCIR RUIDO, PITO)',
                                "tipo" => 'A'
                            )
                    );
                    break;
                case "MOTOCARRO":
                    array_push(
                            $this->defectosMA,
                            (object) array(
                                "codigo" => '1.4.5.13.1',
                                "descripcion" => 'Concentraciones de gases y sustancias contaminantes mayores a las establecidas por la autoridad competente. NOTA Las emisiones de gases contaminantes se verificaran según el tipo de motor y de combustible.',
                                "grupo" => 'EMISIONES(GASES, ELEMENTOS PARA PRODUCIR RUIDO, PITO)',
                                "tipo" => 'A'
                            )
                    );
                    break;
                default:
                    array_push(
                            $this->defectosMA,
                            (object) array(
                                "codigo" => '1.1.6.16.1',
                                "descripcion" => 'Los vehículos cuyas emisiones de gases de escape tengan concentración de gases y sustancias contaminantes mayores a las establecidas por los requisitos legales ambientales definidas por las autoridades competentes',
                                "grupo" => 'EMISIONES(GASES, ELEMENTOS PARA PRODUCIR RUIDO, PITO)',
                                "tipo" => 'A'
                            )
                    );
                    break;
            }
        }
    }

    //------------------------------------------------------------------------------OPACIDAD
    var $ifDefopacidad;

    public function getOpacidad($idhojapruebas, $vehiculo) {
        $this->ifDefopacidad = false;
        $data['idhojapruebas'] = $idhojapruebas;
        $data['idtipo_prueba'] = "2";
        $data['order'] = $this->order;
        $result = $this->Mprueba->get($data);
        $aprobadoOpacidad = true;
        if ($result->num_rows() > 0) {
            $r = $result->result();
            $data['idprueba'] = $r[0]->idprueba;
            $ltoe = '';
            $conf = @file_get_contents("system/" . $r[0]->idmaquina . ".json");
            if (isset($conf)) {
                $encrptopenssl = new Opensslencryptdecrypt();
                $json = $encrptopenssl->decrypt($conf, true);
                $dat = json_decode($json, true);
                if ($dat) {
                    foreach ($dat as $d) {
                        if ($d['nombre'] == "ltoe") {
                            $ltoe = $d['valor'];
                        }
                    }
                }
            }
            $operario = $this->getUsuario($r[0]->idusuario);
            if ($r[0]->estado == '1') {
                $this->aprobado = false;
                $aprobadoOpacidad = false;
            }
            //            $opacidadParam = new opacidad_param();
            $max = $this->max_opacidad($vehiculo->ano_modelo);
            $rpm_ciclo1 = $this->rdnr($this->getResultadoIDCF($data, 41));
            $mod1 = intval($rpm_ciclo1) % 10;
            $rpm_ciclo1 = intval($rpm_ciclo1) - $mod1;
            $rpm_ciclo2 = $this->rdnr($this->getResultadoIDCF($data, 63));
            $mod2 = intval($rpm_ciclo2) % 10;
            $rpm_ciclo2 = intval($rpm_ciclo2) - $mod2;
            $rpm_ciclo3 = $this->rdnr($this->getResultadoIDCF($data, 64));
            $mod3 = intval($rpm_ciclo3) % 10;
            $rpm_ciclo3 = intval($rpm_ciclo3) - $mod3;
            $rpm_ciclo4 = $this->rdnr($this->getResultadoIDCF($data, 65));
            $mod4 = intval($rpm_ciclo4) % 10;
            $rpm_ciclo4 = intval($rpm_ciclo4) - $mod4;
            $tmp_inicial = $this->rdnr($this->getResultadoIDCF($data, 224));
            $tmp_final = $this->rdnr($this->getResultadoIDCF($data, 39));
            if (intval($tmp_final) < intval($tmp_inicial)) {
                $tmp_inicial = $tmp_final;
                $tmp_final = $tmp_inicial;
            }
            $opacidad = (object)
                    array(
                        'idprueba' => $r[0]->idprueba,
                        'op_ciclo1' => $this->rdnr($this->getResultadoIDCF($data, 34)),
                        'op_ciclo2' => $this->rdnr($this->getResultadoIDCF($data, 35)),
                        'op_ciclo3' => $this->rdnr($this->getResultadoIDCF($data, 36)),
                        'op_ciclo4' => $this->rdnr($this->getResultadoIDCF($data, 37)),
                        'rpm_ciclo1' => $rpm_ciclo1,
                        'rpm_ciclo2' => $rpm_ciclo2,
                        'rpm_ciclo3' => $rpm_ciclo3,
                        'rpm_ciclo4' => $rpm_ciclo4,
                        'opacidad_total' => $this->evalOpacidad($this->rdnr($this->getResultadoIDCF($data, 61)), $max),
                        'rpm_ralenti' => $this->rdnr($this->getResultadoIDCF($data, 38)),
                        'temp_inicial' => $tmp_inicial,
                        'temp_final' => $tmp_final,
                        'temp_ambiente' => $this->rdnr($this->getResultadoIDCF($data, 200)),
                        'humedad' => $this->rdnr($this->getResultadoIDCF($data, 201)),
                        'ltoe' => $ltoe,
                        'fugasTuboEscape' => $this->getResultadoDefecto($data, 348, 'defecto'),
                        'fugasSilenciador' => $this->getResultadoDefecto($data, 349, 'defecto'),
                        'tapaCombustible' => $this->getResultadoDefecto($data, 350, 'defecto'),
                        'tapaAceite' => $this->getResultadoDefecto($data, 351, 'defecto'),
                        'sistemaMuestreo' => $this->getResultadoDefecto($data, 352, 'defecto'),
                        'salidasAdicionales' => $this->getResultadoDefecto($data, 353, 'defecto'),
                        'filtroAire' => $this->getResultadoDefecto($data, 354, 'defecto'),
                        'sistemaRefrigeracion' => $this->getResultadoDefecto($data, 355, 'defecto'),
                        'revolucionesFueraRango' => $this->getResultadoDefecto($data, 356, 'defecto'),
                        'velocidadGiro' => $this->getResultadoDefecto($data, 379, 'defecto'),
                        'malFuncionamientoMotor' => $this->getResultadoDefecto($data, 405, 'defecto'),
                        'gobernadaNoAlcanzada' => $this->getResultadoDefecto($data, 358, 'defecto'),
                        'diferenciaAritmetica1' => $this->getResultadoDefecto($data, 149, 'defecto'),
                        'diferenciaAritmetica2' => $this->getResultadoDefecto($data, 340, 'defecto'),
                        'fallaSubitaMotor' => $this->getResultadoDefecto($data, 357, 'defecto'),
                        'max' => $max,
                        'operario' => $operario->nombres . " " . $operario->apellidos,
                        'documento' => $operario->identificacion
            );
            $this->setDefAnormalesGas($opacidad->fugasTuboEscape, '2.1.1.1.1', "Existencia de fugas en el tubo, uniones del múltiple y silenciador del sistema de escape del vehículo.");
            $this->setDefAnormalesGas($opacidad->fugasSilenciador, '2.1.1.1.1', "Existencia de fugas en el tubo, uniones del múltiple y silenciador del sistema de escape del vehículo.");
            $this->setDefAnormalesGas($opacidad->salidasAdicionales, '2.1.1.1.2', "Salidas adicionales en el sistema de escape diferentes a las de diseño original del vehículo.");
            $this->setDefAnormalesGas($opacidad->tapaAceite, '2.1.1.1.3', "Ausencia de tapones de aceite o fugas en el mismo.");
            $this->setDefAnormalesGas($opacidad->tapaCombustible, '2.1.1.1.4', "Ausencia de tapones de combustible o fugas en el mismo.");
            $this->setDefAnormalesGas($opacidad->sistemaMuestreo, '2.1.1.1.5', "Instalación de accesorios o deformaciones en el tubo de escape que no permitan la introducción del acople.");
            $this->setDefAnormalesGas($opacidad->sistemaRefrigeracion, '2.1.1.1.6', "Incorrecta operación del sistema de refrigeración, cuya verificación se hará por medio de inspección. NOTA 1 esta inspección puede consistir en verificación fugas, verificación del estado del ventilador del sistema, vibraciones o posibles contactos por deflexión de los alabes del ventilador a altas revoluciones o elementos con sujeción inadecuada, entre otros.");
            $this->setDefAnormalesGas($opacidad->filtroAire, '2.1.1.1.7', "Ausencia o incorrecta instalación del filtro de aire.");
            $this->setDefAnormalesGas($opacidad->velocidadGiro, '2.1.1.1.8', "Activación de dispositivos instalados en el Motor o en el vehículo que alteren las características normales de velocidad de giro y que tengan como efecto la modificación de los resultados de la prueba de opacidad o que impidan su ejecución adecuada. Si no pueden ser desactivados antes de la siguiente prueba, el vehículo es rechazado por operación inadecuada.");
            $this->setDefAnormalesGas($opacidad->gobernadaNoAlcanzada, '2.1.1.1.9', "Durante la medición no se alcanza la velocidad gobernada antes de 5 segundos.");
            $this->setDefAnormalesGas($opacidad->malFuncionamientoMotor, '2.1.1.1.10', "Indicación de mal funcionamiento del motor.");
            $this->setDefAnormalesGas($opacidad->diferenciaAritmetica1, '2.1.1.1.12', "La diferencia aritmética entre el valor mayor y menor de opacidad de las tres (3) aceleraciones, especificados en el numeral 3.2.4. (NTC4231)");
            $this->setDefAnormalesGas($opacidad->diferenciaAritmetica2, '2.1.1.1.12', "La diferencia aritmética entre el valor mayor y menor de opacidad de las tres (3) aceleraciones, especificados en el numeral 3.2.4. (NTC4231)");
            $this->setDefAnormalesGas($opacidad->fallaSubitaMotor, '2.1.1.1.13', "Falla súbita del motor y /o sus accesorios.");
            if ($this->defAnormaGases) {
                $opacidad->op_ciclo1 = '';
                $opacidad->op_ciclo2 = '';
                $opacidad->op_ciclo3 = '';
                $opacidad->op_ciclo4 = '';
                $opacidad->rpm_ciclo1 = '';
                $opacidad->rpm_ciclo2 = '';
                $opacidad->rpm_ciclo3 = '';
                $opacidad->rpm_ciclo4 = '';
                $opacidad->opacidad_total = '';
                $opacidad->rpm_ralenti = '';
                $opacidad->temp_inicial = '';
                $opacidad->temp_final = '';
            }
        } else {
            $opacidad = (object)
                    array(
                        'idprueba' => '',
                        'op_ciclo1' => '',
                        'op_ciclo2' => '',
                        'op_ciclo3' => '',
                        'op_ciclo4' => '',
                        'rpm_ciclo1' => '',
                        'rpm_ciclo2' => '',
                        'rpm_ciclo3' => '',
                        'rpm_ciclo4' => '',
                        'opacidad_total' => '',
                        'rpm_ralenti' => '',
                        'temp_inicial' => '',
                        'temp_final' => '',
                        'temp_ambiente' => '',
                        'humedad' => '',
                        'ltoe' => '',
                        'fugasTuboEscape' => '',
                        'fugasSilenciador' => '',
                        'tapaCombustible' => '',
                        'tapaAceite' => '',
                        'sistemaMuestreo' => '',
                        'salidasAdicionales' => '',
                        'filtroAire' => '',
                        'sistemaRefrigeracion' => '',
                        'revolucionesFueraRango' => '',
                        'velocidadGiro' => '',
                        'malFuncionamientoMotor' => '',
                        'gobernadaNoAlcanzada' => '',
                        'diferenciaAritmetica1' => '',
                        'diferenciaAritmetica2' => '',
                        'fallaSubitaMotor' => '',
                        'max' => '',
                        'operario' => '',
                        'documento' => ''
            );
        }
        if (!$aprobadoOpacidad) {
            $this->setDefOpa();
        }
        return $opacidad;
    }

    //..............................................................................EVAL OPACIDAD
    function evalOpacidad($dato, $max) {
        if ($dato !== '') {
            if (floatval($max) >= floatval($dato)) {
                return $dato;
            } else {
                $this->setDefOpa();
                return $dato . "*";
            }
        }
    }

    private function setDefOpa() {
        if (!$this->ifDefopacidad) {
            $this->ifDefopacidad = true;
            array_push(
                    $this->defectosMA,
                    (object) array(
                        "codigo" => '2.1.1.1.11',
                        "descripcion" => 'Incumplimiento de niveles máximos permitidos por la autoridad competente.',
                        "grupo" => 'EMISIONES(GASES, ELEMENTOS PARA PRODUCIR RUIDO, PITO)',
                        "tipo" => 'A'
                    )
            );
        }
    }

    //------------------------------------------------------------------------------SENSORIAL
    public function getSensorial($idhojapruebas, $v) {
        $data['idhojapruebas'] = $idhojapruebas;
        $data['idtipo_prueba'] = "8";
        $data['order'] = $this->order;
        $result = $this->Mprueba->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            $data['idprueba'] = $r[0]->idprueba;
            $operario = $this->getUsuario($r[0]->idusuario);
            if ($r[0]->estado == '1') {
                $this->aprobado = false;
            }
            $visual = (object) array(
                        'operario' => $operario->nombres . " " . $operario->apellidos,
                        'documento' => $operario->identificacion,
                        'idprueba' => $r[0]->idprueba,
                        'fotosProfundidad' => $this->getFotosProfundidad($data['idprueba']),
                        'fotosCintas' => $this->getCintasReflectivas($data['idprueba']),
                        'fotosLuzFrenado' => $this->getLuzFrenado($data['idprueba']),
            );
            $rta = $this->getResultadoAll($data, 'defecto', 153);
            $obsAdd = false;
            foreach ($this->defectos as $d) {
                $encontrado = false;
                if ($rta !== '') {
                    foreach ($rta as $r) {
                        //                        echo $r->valor . '-' . $d->codigo. '<br>';
                        $na = explode("-", $r->valor);
                        if ($r->valor == $d->codigo || $na[0] == $d->codigo) {

                            $encontrado = true;
                            $res = 'SI';
                            if (count($na) > 1) {
                                $res = 'NA';
                            }
                            array_push(
                                    $this->defectosSA,
                                    (object) array(
                                        "codigo" => $d->codigo,
                                        "descripcion" => $d->descripcion,
                                        "grupo" => $d->nombre_grupo,
                                        "tipo" => $res
                                    )
                            );

                            if ($r->observacion !== '') {
                                array_push(
                                        $this->observaciones,
                                        (object) array(
                                            "codigo" => $d->codigo,
                                            "descripcion" => $r->observacion
                                        )
                                );
                            }

                            break;
                        }

                        if ($r->tiporesultado == 'COMENTARIOSADICIONALES') {
                            if (!$obsAdd) {
                                $obsAdd = true;
                                array_push(
                                        $this->observaciones,
                                        (object) array(
                                            "codigo" => 'Comentarios adicionales',
                                            "descripcion" => $r->valor
                                        )
                                );
                            }
                        }
                    }
                }
                if (!$encontrado) {
                    $tipo_ = "NO";
                    if ($v->taximetro == 0 && $d->nombre_grupo == 'TAXIMETROS') {
                        $tipo_ = "NA";
                    }
                    if ($v->idservicio != 2) {
                        if ($d->nombre_grupo == 'SALIDA DE EMERGENCIA' || $d->nombre_grupo == 'PLACAS LATERALES') {
                            $tipo_ = "NA";
                        }
                    }
                    if ($v->ensenanza == 0 && ($d->nombre_grupo == 'ENSEÑANZA' || $d->nombre_grupo == 'ENSENANZA' || strlen(strstr($d->nombre_grupo, 'ENSE')) > 0)) {
                        $tipo_ = "NA";
                    }




                    array_push(
                            $this->defectosSA,
                            (object) array(
                                "codigo" => $d->codigo,
                                "descripcion" => $d->descripcion,
                                "grupo" => $d->nombre_grupo,
                                "tipo" => $tipo_
                            )
                    );
                }
            }
        } else {
            $visual = (object)
                    array(
                        'operario' => "",
                        'documento' => "",
                        'idprueba' => "",
                        'fotosProfundidad' => [],
                        'fotosCintas' => [],
                        'fotosLuzFrenado' => [],
            );
        }

        return $visual;

        //            var $defectosSA;
//    var $defectosSB;
    }

    //------------------------------------------------------------------------------LABRADO
    public function getLabrados($idhojapruebas) {
        $data['idhojapruebas'] = $idhojapruebas;
        $data['idtipo_prueba'] = "8";
        $data['order'] = $this->order;
        $result = $this->Mprueba->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            $data['idprueba'] = $r[0]->idprueba;

            if ($this->nombreClase->nombre !== "MOTOCICLETA") {

                $labrados = (object)
                        array(
                            'eje1_derecho' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje1_derecho', '')),
                            'eje2_derecho' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_derecho', '')),
                            'eje3_derecho' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_derecho', '')),
                            'eje4_derecho' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_derecho', '')),
                            'eje5_derecho' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_derecho', '')),
                            'eje2_derecho_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_derecho_interior', '')),
                            'eje3_derecho_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_derecho_interior', '')),
                            'eje4_derecho_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_derecho_interior', '')),
                            'eje5_derecho_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_derecho_interior', '')),
                            'eje1_izquierdo' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje1_izquierdo', '')),
                            'eje2_izquierdo' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_izquierdo', '')),
                            'eje3_izquierdo' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_izquierdo', '')),
                            'eje4_izquierdo' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_izquierdo', '')),
                            'eje5_izquierdo' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_izquierdo', '')),
                            'eje2_izquierdo_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje2_izquierdo_interior', '')),
                            'eje3_izquierdo_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje3_izquierdo_interior', '')),
                            'eje4_izquierdo_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje4_izquierdo_interior', '')),
                            'eje5_izquierdo_interior' => $this->rdnr($this->getResultado($data, 'Labrado_llanta_eje5_izquierdo_interior', '')),
                            'repuesto' => $this->rdnr($this->getResultado($data, 'Labrado_repuesto', '')),
                            'repuesto2' => $this->rdnr($this->getResultado($data, 'Labrado_repuesto2', ''))
                );
            } else {
                //                echo "clase ". $this->nombreClase->nombre;
                $labrados = (object)
                        array(
                            'eje1_derecho' => $this->getResultado($data, 'Labrado_llanta_eje1_derecho', ''),
                            'eje2_derecho' => $this->getResultado($data, 'Labrado_llanta_eje2_derecho', ''),
                            'eje3_derecho' => '',
                            'eje4_derecho' => '',
                            'eje5_derecho' => '',
                            'eje2_derecho_interior' => '',
                            'eje3_derecho_interior' => '',
                            'eje4_derecho_interior' => '',
                            'eje5_derecho_interior' => '',
                            'eje1_izquierdo' => '',
                            'eje2_izquierdo' => '',
                            'eje3_izquierdo' => '',
                            'eje4_izquierdo' => '',
                            'eje5_izquierdo' => '',
                            'eje2_izquierdo_interior' => '',
                            'eje3_izquierdo_interior' => '',
                            'eje4_izquierdo_interior' => '',
                            'eje5_izquierdo_interior' => '',
                            'repuesto' => '',
                            'repuesto2' => ''
                );
            }
        } else {
            $labrados = (object)
                    array(
                        'eje1_derecho' => '',
                        'eje2_derecho' => '',
                        'eje3_derecho' => '',
                        'eje4_derecho' => '',
                        'eje5_derecho' => '',
                        'eje2_derecho_interior' => '',
                        'eje3_derecho_interior' => '',
                        'eje4_derecho_interior' => '',
                        'eje5_derecho_interior' => '',
                        'eje1_izquierdo' => '',
                        'eje2_izquierdo' => '',
                        'eje3_izquierdo' => '',
                        'eje4_izquierdo' => '',
                        'eje5_izquierdo' => '',
                        'eje2_izquierdo_interior' => '',
                        'eje3_izquierdo_interior' => '',
                        'eje4_izquierdo_interior' => '',
                        'eje5_izquierdo_interior' => '',
                        'repuesto' => '',
                        'repuesto2' => ''
            );
        }
        return $labrados;
    }

    private function getFotosProfundidad($idprueba) {
                $url = "http://localhost:3800/api/profundidad-labrado/fotos/" . $idprueba;
    $opts = [
        "http" => [
            "method" => "GET",
            "timeout" => 10
        ]
    ];
    $context = stream_context_create($opts);
    $response = @file_get_contents($url, false, $context);

    if ($response === false) {
        return [];
    }

    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return [];
    }

    return $data;
    }

    private function getCintasReflectivas($idprueba) {
        $url = "http://localhost:3800/api/cinta-reflectiva/fotos/" . $idprueba;
        $opts = [
            "http" => [
                "method" => "GET",
                "timeout" => 10
        ]
    ];
    $context = stream_context_create($opts);
    $response = @file_get_contents($url, false, $context);

    if ($response === false) {
        return [];
    }

    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return [];
    }

    return $data;
    }

    private function getLuzFrenado($idprueba) {
        $url = "http://localhost:3800/api/luz-frenado/fotos/" . $idprueba;
        $opts = [
            "http" => [
                "method" => "GET",
                "timeout" => 10
        ]
    ];
    $context = stream_context_create($opts);
    $response = @file_get_contents($url, false, $context);

    if ($response === false) {
        return [];
    }

    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return [];
    }

    return $data;
    }

    //------------------------------------------------------------------------------FOTOGRAFIA  
    public function getFotografias($idhojapruebas) {
        $data['idhojapruebas'] = $idhojapruebas;
        $data['idtipo_prueba'] = "5";
        $data['order'] = $this->order;
        $result = $this->Mprueba->get5($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            if (isset($r[0]->idprueba)) {
                $data['idprueba'] = $r[0]->idprueba;
                $imagen1 = $this->getimagen($data);
                if ($imagen1 !== '') {
                    $imagen = explode(",", $imagen1);
                    $imagen1 = $imagen[1];
                }
            } else {
                $imagen1 = '';
            }

            if (isset($r[1]->idprueba)) {
                $data['idprueba'] = $r[1]->idprueba;
                $imagen2 = $this->getimagen($data);
                if ($imagen2 !== '') {
                    $imagen = explode(",", $imagen2);
                    $imagen2 = $imagen[1];
                }
            } else {
                $imagen2 = '';
            }
            //            if (substr($imagen1, 0, 23) !== 'data:image/jpeg;base64,') {
//            $imagen1 = base64_encode($imagen1);
//            } else {
//                $imagen = explode(",", $imagen1);
//                $imagen1 = $imagen[1];
//            }
//            if (substr($imagen2, 0, 23) !== 'data:image/jpeg;base64,') {
//            $imagen2 = base64_encode($imagen2);
//            } else {
//                $imagen = explode(",", $imagen2);
//                $imagen2 = $imagen[1];
//            }
            if ($imagen1 !== '') {
                $imagen1 = '@' . $imagen1;
            }
            if ($imagen2 !== '') {
                $imagen2 = '@' . $imagen2;
            }
            $imagenes = (object)
                    array(
                        'imagen1' => $imagen1,
                        'imagen2' => $imagen2
            );
        } else {
            $imagenes = (object)
                    array(
                        'imagen1' => '',
                        'imagen2' => ''
            );
        }
        return $imagenes;
    }

    var $perEncontrado = true;

    //------------------------------------------------------------------------------MAQUINAS
    public function getMaquinas($idhojapruebas, $fechainicial) {
        $data['idhojapruebas'] = $idhojapruebas;
        $data['fechainicial'] = $fechainicial;
        $data['order'] = $this->order;
        //------------------------------------------------------------------------------luxometro        
        $data['idtipo_prueba'] = "1";
        $luxometro = $this->getNombreMaquina($data, "Luxometro");
        //------------------------------------------------------------------------------opacimetro        
        $data['idtipo_prueba'] = "2";
        $opacimetro = $this->getNombreMaquina($data, "Opacimetro");
        //------------------------------------------------------------------------------gases
        $data['idtipo_prueba'] = "3";
        $gases = $this->getNombreMaquina($data, "Analizador de gases");
        //------------------------------------------------------------------------------sonometria
        $data['idtipo_prueba'] = "4";
        $sonometro = $this->getNombreMaquina($data, "Sonómetro");
        //------------------------------------------------------------------------------fotos
        $data['idtipo_prueba'] = "5";
        $fotos = $this->getNombreMaquina($data, "Cámara");
        //------------------------------------------------------------------------------taximetro
        $data['idtipo_prueba'] = "6";
        $taximetro = $this->getNombreMaquina($data, "Taxímetro");
        //------------------------------------------------------------------------------frenos
        $data['idtipo_prueba'] = "7";
        $frenos = $this->getNombreMaquina($data, "Frenómetro");
        //------------------------------------------------------------------------------visual
        $data['idtipo_prueba'] = "8";
        $visual = $this->getNombreMaquina($data, "Visual");
        //------------------------------------------------------------------------------suspension
        $data['idtipo_prueba'] = "9";
        $suspension = $this->getNombreMaquina($data, "Banco de suspensión");
        //------------------------------------------------------------------------------alineador
        $data['idtipo_prueba'] = "10";
        $alineador = $this->getNombreMaquina($data, "Alineador");
        //------------------------------------------------------------------------------termohigrometro
        $data['idtipo_prueba'] = "12";
        $termohigrometro = $this->getNombreMaquina($data, "Termohigómetro");
        //------------------------------------------------------------------------------profundimetro
        $data['idtipo_prueba'] = "13";
        $profundimetro = $this->getNombreMaquina($data, "Profundímetro");
        //------------------------------------------------------------------------------captador
        $data['idtipo_prueba'] = "14";
        $captador = $this->getNombreMaquina($data, "Captador");
        //------------------------------------------------------------------------------pie de rey
        $data['idtipo_prueba'] = "15";
        $piederey = $this->getNombreMaquina($data, "Pie de rey");
        //------------------------------------------------------------------------------detector de holguras
        $data['idtipo_prueba'] = "16";
        $detector = $this->getNombreMaquina($data, "Detector de holguras");
        //------------------------------------------------------------------------------elevador de motos
        $data['idtipo_prueba'] = "17";
        $elevador = $this->getNombreMaquina($data, "Elevador");
        if ($this->habilitarPerifericos == '1') {
            //------------------------------------------------------------------------------Sensor rpm
            $data['idtipo_prueba'] = "21";
            $sensorRPM = $this->getNombreMaquina($data, "Sensor RPM");
            //------------------------------------------------------------------------------Sonda temperatura
            $data['idtipo_prueba'] = "22";
            $sondaTMP = $this->getNombreMaquina($data, "Sonda Temperatura");
        } else {
            $sensorRPM = "";
            $sondaTMP = "";
        }

        if ($opacimetro == "" && $gases == "") {
            $sensorRPM = "";
            $sondaTMP = "";
            $termohigrometro = "";
            $captador = "";
        }

        $maquinas = (object)
                array(
                    'nombreLuxometro' => $luxometro,
                    'nombreOpacimetro' => $opacimetro,
                    'nombreGases' => $gases,
                    'nombreSonometro' => $sonometro,
                    'nombreFotos' => $fotos,
                    'nombreTaximetro' => $taximetro,
                    'nombreFrenos' => $frenos,
                    'nombreVisual' => $visual,
                    'nombreSuspension' => $suspension,
                    'nombreAlineador' => $alineador,
                    'nombreTermohigrometro' => $termohigrometro,
                    'nombreProfundimetro' => $profundimetro,
                    'nombreCaptador' => $captador,
                    'nombreDetector' => $detector,
                    'nombreElevador' => $elevador,
                    'nombrePiederey' => $piederey,
                    'nombreSensorRPM' => $sensorRPM,
                    'nombreSondaTMP' => $sondaTMP
        );
        return $maquinas;
    }

    //------------------------------------------------------------------------------NOMBRE MAQUINA
    public function getNombreMaquina($data, $nombrePrueba) {
        $rta = $this->Mprueba->getMaq($data);
        if ($rta->num_rows() > 0) {
            $r = $rta->result();
            $data['idmaquina'] = $r[0]->idmaquina;
            $data['IdUsuario'] = $r[0]->idusuario;
            if (($nombrePrueba == "Sensor RPM" || $nombrePrueba == "Sonda Temperatura") && $data['idmaquina'] == '') {
                $data['idmaquina'] = "0";
                $data['IdUsuario'] = "0";
                $nombre = $this->getMaquinaDat($data);
            } else {
                if ($data['idmaquina'] == '') {
                    $nombre = "";
                } else {
                    $nombre = $this->getMaquinaDat($data);
                }
            }
        } else {
            $nombre = "";
        }
        return $nombre;
    }

    public function getNombreMaquina55($data, $nombrePrueba) {
        $rta = $this->Mprueba->get55maquina($data);
        if ($rta->num_rows() > 0) {
            $r = $rta->result();
            $nombre = $this->getMaquinaDat($r[0]->idmaquina);
            //            $nombre = $nombrePrueba . " -> " . $r[0]->nombrereal . "<br>";
        } else {
            $nombre = "";
        }
        return $nombre;
    }

    private function getMaquinaDat($data) {
        $nombreMaquina = "";
        $marcaMaquina = "";
        $serialMaquina = "";
        $referenciaMaquina = "";
        $pefMaquina = "";
        $ltoeMaquina = "";
        $noSerieBench = "";
        $periferico = "";
        $encontrada = false;
        $per = "";
        $this->perEncontrado = false;
        //        echo $data['idmaquina'] . "<br>";
        if ($conf = @file_get_contents("system/lineas.json")) {
            $encrptopenssl = new Opensslencryptdecrypt();
            $json = $encrptopenssl->decrypt($conf, true);
            $dat = json_decode($json, true);
            foreach ($dat as $d) {
                if ($d['conf_idtipo_prueba'] == $data['idtipo_prueba'] && ($d['conf_idtipo_prueba'] == '21' || $d['conf_idtipo_prueba'] == '22') && !$this->perEncontrado) {
                    $this->perEncontrado = true;
                    $per = $d;
                }
                if ($d['idconf_maquina'] == $data['idmaquina']) {
                    if ($d['conf_idtipo_prueba'] == '21' || $d['conf_idtipo_prueba'] == '22') {
                        $encontrada = true;
                    }
                    $nombreMaquina = $d['nombre'];
                    $serialMaquina = $d['serie_maquina'];
                    $referenciaMaquina = $d['serie_banco'];
                    if (intval($d['conf_idtipo_prueba']) > 10) {
                        $periferico = "S";
                    } else {
                        $periferico = "N";
                    }
                    if ($conf = @file_get_contents("system/" . $data['idmaquina'] . ".json")) {
                        $json = $encrptopenssl->decrypt($conf, true);
                        $dat = json_decode($json, true);
                        foreach ($dat as $d) {
                            switch ($d['nombre']) {
                                case 'nombreMarca':
                                    $marcaMaquina = $d['valor'];
                                    break;
                                case 'ltoe':
                                    $ltoeMaquina = $d['valor'];
                                    break;
                                case 'pef':
                                    $pefMaquina = $d['valor'];
                                    break;
                                case 'noSerieBench':
                                    $noSerieBench = $d['valor'];
                                    break;
                                default:
                                    break;
                            }
                        }
                    }
                    break;
                }
            }
        }
        if ($encontrada == false && ($data['idtipo_prueba'] == '22' || $data['idtipo_prueba'] == '21')) {
            //            var_dump($data);
            $nombreMaquina = $per['nombre'];
            $serialMaquina = $per['serie_maquina'];
            $referenciaMaquina = $per['serie_banco'];
            $periferico = "S";
            if ($conf = @file_get_contents("system/" . $per['idconf_maquina'] . ".json")) {
                $json = $encrptopenssl->decrypt($conf, true);
                $dat = json_decode($json, true);
                foreach ($dat as $d) {
                    switch ($d['nombre']) {
                        case 'nombreMarca':
                            $marcaMaquina = $d['valor'];
                            break;
                        default:
                            break;
                    }
                }
            }
        }
        $ru = $this->Musuarios->get($data);
        if ($ru->num_rows()) {
            $r = $ru->result();
            $usuario = $r[0]->nombres . ' ' . $r[0]->apellidos;
        } else {
            $usuario = '';
        }

        $maquina = $nombreMaquina . "$" . $marcaMaquina . "$" . $serialMaquina . "$" .
                $referenciaMaquina . "$" . $pefMaquina . "$" . $ltoeMaquina . "$" .
                $noSerieBench . "$" . $periferico . "$" . $usuario . "^";
        //        echo $maquina . '<br>';
        return strtoupper($maquina);
    }

    //------------------------------------------------------------------------------INSPECTORES
    public function getInspectores($idhojapruebas) {
        $data['idhojapruebas'] = $idhojapruebas;
        $rta = $this->Mprueba->getInspectores($data);
        $inspectores = "";
        if ($rta->num_rows() > 0) {
            foreach ($rta->result() as $r) {
                $inspectores = $inspectores . "- " . $r->operarios . "<br>";
            }
        }
        return $inspectores;
    }

    //------------------------------------------------------------------------------JEFE TECNICO
    public function getJefeTecnico0() {
        $data['idconfig_prueba'] = '182';
        $result = $this->Mconfig_prueba->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0]->valor;
        } else {
            return '';
        }
    }

    public function getJefeTecnico1($IDCP) {
        $data['idhojapruebas'] = $IDCP;
        $result = $this->Mresultado->getIDCP($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return str_replace(",", ".", $r[0]->valor);
        } else {
            return '';
        }
    }

    //------------------------------------------------------------------------------RESULTADO
    public function getResultado($data, $tiporesultado, $observacion) {
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

    public function getResultadoTmpMot($data, $tiporesultado, $observacion) {
        $data['tiporesultado'] = $tiporesultado;
        if ($observacion <> '') {
            $data['observacion'] = "and observacion='$observacion'";
        } else {
            $data['observacion'] = '';
        }
        $result = $this->Mresultado->getTmpMot($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return str_replace(",", ".", $r[0]->valor);
        } else {
            return '0';
        }
    }

    //------------------------------------------------------------------------------RESULTADO
    public function getResultadoDefecto($data, $valor, $tiporesultado) {
        $data['tiporesultado'] = $tiporesultado;
        $data['valor'] = $valor;
        $result = $this->Mresultado->getDefT($data);
        if ($result->num_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
    }

    //------------------------------------------------------------------------------RESULTADO MAX GASES
    public function getResultadoMaxGases($data, $tiporesultado) {
        $data['tiporesultado'] = $tiporesultado;
        $result = $this->Mresultado->getMaxGases($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            //            var_dump($r);
            return str_replace(",", ".", $r[0]->valor);
        } else {
            return '';
        }
    }

    //------------------------------------------------------------------------------RESULTADO idconfig_prueba
    public function getResultadoIDCF($data, $IDCP) {
        $data['idconfig_prueba'] = $IDCP;
        $result = $this->Mresultado->getIDCP($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return str_replace(",", ".", $r[0]->valor);
        } else {
            return '';
        }
    }

    //------------------------------------------------------------------------------RESULTADO idconfig_prueba_tipo
    public function getResultadoIDCF_tipo($data, $tipo, $IDCP) {
        $data['idconfig_prueba'] = $IDCP;
        $data['tiporesultado'] = $tipo;
        $result = $this->Mresultado->getIDCP_tipo($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return str_replace(",", ".", $r[0]->valor);
        } else {
            return '';
        }
    }

    //------------------------------------------------------------------------------RESULTADO idconfig_prueba_tipo
    public function getSumFuerzaAux($data, $tipo, $IDCP) {
        $data['idconfig_prueba'] = $IDCP;
        $data['tiporesultado'] = $tipo;
        $result = $this->Mresultado->getSumFuerzaAux($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return str_replace(",", ".", $r[0]->valor);
        } else {
            return '';
        }
    }

    //------------------------------------------------------------------------------RESULTADO sensorial
    public function getResultadoAll($data, $tipo, $IDCP) {
        $data['idconfig_prueba'] = $IDCP;
        $data['tiporesultado'] = $tipo;
        $result = $this->Mresultado->getDef($data);
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return '';
        }
    }

    //------------------------------------------------------------------------------IMAGEN
    public function getImagen($data) {
        if ($this->espejoImagenes == '1') {
            if ($this->desdeConsulta !== "true") {
                $result = $this->Mimagenes->get($data);
            } else {
                $result = $this->Mimagenes->get2($data);
            }
        } else {
            $result = $this->Mimagenes->get($data);
        }
        if ($result->num_rows() > 0) {
            $r = $result->result();
            //            $imagen = explode(",", $r[0]->imagen);
            return $r[0]->imagen;
        } else {
            return '';
        }
    }

    //------------------------------------------------------------------------------MAQUINA
    public function getMaquina($data) {
        $result = $this->Mmaquina->get($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0];
        } else {
            return '';
        }
    }

    public function subChar() {
        
    }

    public function tipoDocumento($tipoDoc) {
        if ($tipoDoc === "1") {
            return "CC(X) NIT( )";
        } else {
            return "CC( ) NIT(X)";
        }
    }

    public function getBlindaje($blindaje) {
        if ($blindaje === "1") {
            return "SI(X) NO( )";
        } else {
            return "SI( ) NO(X)";
        }
    }

    private function getIdPre_prerevision($numero_placa, $reins, $fecha) {
        $data['fecha'] = $fecha;
        $data['numero_placa_ref'] = $numero_placa;
        $data['reinspeccion'] = $reins;
        $result = $this->Mpre_prerevision->getXofi($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0]->idpre_prerevision;
        } else {
            return '';
        }
    }

    private function getIdPre_atributo($id) {
        $data['id'] = $id;
        $result = $this->Mpre_atributo->getXid($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0]->idpre_atributo;
        } else {
            return '';
        }
    }

    private function getFechaSoat($idpre_prerevision) {
        $data['idpre_prerevision'] = $idpre_prerevision;
        $data['idpre_atributo'] = $this->getIdPre_atributo("fecha_vencimiento_soat");
        $result = $this->Mpre_dato->getXatripre($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            $r[0]->valor = str_replace("-", "", $r[0]->valor);
            return substr($r[0]->valor, 0, 4) . "-" . substr($r[0]->valor, 4, 2) . "-" . substr($r[0]->valor, 6, 2);
        } else {
            return '';
        }
    }

    private function getFechaCertificado($idpre_prerevision) {
        $data['idpre_prerevision'] = $idpre_prerevision;
        $data['idpre_atributo'] = $this->getIdPre_atributo("fecha_final_certgas");
        $result = $this->Mpre_dato->getXatripre($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            $r[0]->valor = str_replace("-", "", $r[0]->valor);
            return substr($r[0]->valor, 0, 4) . "-" . substr($r[0]->valor, 4, 2) . "-" . substr($r[0]->valor, 6, 2);
        } else {
            return '';
        }
    }

    private function getUsuarioRegistro($idpre_prerevision) {
        $data['idpre_prerevision'] = $idpre_prerevision;
        $data['idpre_atributo'] = $this->getIdPre_atributo("usuario_registro");
        $result = $this->Mpre_dato->getXatripre($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            return $r[0]->valor;
        } else {
            return '';
        }
    }

    private function getCertificado($idpre_prerevision) {
        $data['idpre_prerevision'] = $idpre_prerevision;
        $data['idpre_atributo'] = $this->getIdPre_atributo("chk-3");
        $result = $this->Mpre_dato->getXatripre($data);
        if ($result->num_rows() > 0) {
            $r = $result->result();
            switch ($r[0]->valor) {
                case 'NA':
                    $dat = "SI ( ) NO ( ) N/A (X)";
                    break;
                case 'NO':
                    $dat = "SI ( ) NO (X) N/A ( )";
                    break;
                case 'SI':
                    $dat = "SI (X) NO ( ) N/A ( )";
                    break;
                default:
                    $dat = "SI ( ) NO ( ) N/A (X)";
                    break;
            }
            return $dat;
            //            return substr($r[0]->valor, 0, 4) . "-" . substr($r[0]->valor, 4, 2) . "-" . substr($r[0]->valor, 6, 2);
        } else {
            return '';
        }
    }

    var $rechazadoCB = false;

    private function getDiagnostico($vehiculo) {
        $totalB = count($this->defectosMB) + count($this->defectosSB) + count($this->defectosEB);
        if (count($this->defectosMA) > 0 || count($this->defectosSA) > 0 || count($this->defectosEA) > 0) {
            $this->aprobado = false;
            $this->rechazadoCB = true;
        }
        if ($vehiculo->idservicio == '2' && $vehiculo->tipo_vehiculo !== '3') {
            if ($totalB >= 5) {
                $this->aprobado = false;
                $this->rechazadoCB = true;
            }
        } else {
            if (
                    ($this->nombreClase->nombre == "MOTOCARRO" ||
                    $this->nombreClase->nombre == "CUATRIMOTO" ||
                    $this->nombreClase->nombre == "MOTOTRICICLO" ||
                    $this->nombreClase->nombre == "CUADRICICLO") && $totalB >= 7
            ) {
                $this->aprobado = false;
                $this->rechazadoCB = true;
            }
            if (
                    ($this->nombreClase->nombre == "MOTOCICLETA" ||
                    $this->nombreClase->nombre == "CICLOMOTOR" ||
                    $this->nombreClase->nombre == "TRICIMOTO") && $totalB >= 5
            ) {
                $this->aprobado = false;
                $this->rechazadoCB = true;
            }
            if (
                    $vehiculo->ensenanza == '1' &&
                    $this->nombreClase->nombre !== "CUATRIMOTO" &&
                    $this->nombreClase->nombre !== "MOTOTRICICLO" &&
                    $this->nombreClase->nombre !== "CUADRICICLO" &&
                    $this->nombreClase->nombre !== "CICLOMOTOR" &&
                    $this->nombreClase->nombre !== "TRICIMOTO" &&
                    $totalB >= 5
            ) {
                $this->aprobado = false;
                $this->aprobadoE = false;
                $this->rechazadoCB = true;
            }
            if (
                    $vehiculo->ensenanza == '1' &&
                    ($this->nombreClase->nombre == "CUATRIMOTO" ||
                    $this->nombreClase->nombre == "MOTOTRICICLO" ||
                    $this->nombreClase->nombre == "CUADRICICLO" ||
                    $this->nombreClase->nombre == "CICLOMOTOR" ||
                    $this->nombreClase->nombre == "TRICIMOTO") &&
                    $totalB >= 1
            ) {
                $this->aprobado = false;
                $this->aprobadoE = false;
                $this->rechazadoCB = true;
            }
            if (
                    $vehiculo->ensenanza == '0' &&
                    $this->nombreClase->nombre !== "MOTOCARRO" &&
                    $this->nombreClase->nombre !== "CUATRIMOTO" &&
                    $this->nombreClase->nombre !== "MOTOTRICICLO" &&
                    $this->nombreClase->nombre !== "CUADRICICLO" &&
                    $this->nombreClase->nombre !== "MOTOCICLETA" &&
                    $this->nombreClase->nombre !== "CICLOMOTOR" &&
                    $this->nombreClase->nombre !== "TRICIMOTO" &&
                    $totalB >= 10
            ) {
                $this->aprobado = false;
                $this->rechazadoCB = true;
            }
        }
        if ($this->aprobado) {
            $apro = "APROBADO: SI__X__ NO_____";
        } else {
            $apro = "APROBADO: SI_____ NO__X__";
        }
        if ($this->enpista) {
            $apro = "APROBADO: SI_____ NO_____";
        }

        return $apro;
    }

    private function getDiagnosticoE($vehiculo) {
        if ($vehiculo->ensenanza == '1') {
            if (count($this->defectosEA) > 0) {
                $this->aprobadoE = false;
                $aproE = "APROBADO: SI_____ NO__X__";
            } else if ($this->aprobadoE) {
                $aproE = "APROBADO: SI__X__ NO_____";
            } else {
                $aproE = "APROBADO: SI_____ NO__X__";
            }
        } else {
            $aproE = "APROBADO: SI____ NO____";
        }
        if ($this->enpista) {
            $aproE = "APROBADO: SI_____ NO_____";
        }
        return $aproE;
    }

    //--------------------------------------------------------------------------
    private function getFirmaJefe($documento) {
        $encrptopenssl = new Opensslencryptdecrypt();
        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            $file = 'tcm/usuarios/' . $documento . '/sig.dat';
        } else {
            $file = 'C:/tcm/usuarios/' . $documento . '/sig.dat';
        }

        if (file_exists($file)) {
            $firma = $encrptopenssl->decrypt(file_get_contents($file, true));
            $firma = explode(",", $firma);
            $firma = $firma[1];
        } else {
            $firma = '';
        }
        return $firma;
    }

    var $segundo_envio;

    //______________________________________________________________________________TRAMA CI2
    private function buildCi2($data) {
        //______________________________________________________________________DATOS DE VALIDACION
        $this->setDatCi2("usuario", $this->usuarioSicov);
        $this->setDatCi2("clave", $this->claveSicov);
        $this->setDatCi2("p_pin", $data['hojatrabajo']->pin0);
        $this->setDatCi2("p_3_plac", $data['vehiculo']->numero_placa);
        $this->setDatCi2("p_e_con_run", $data['numero_consecutivo']);
        $this->setDatCi2("p_tw01", $data['numero_sustrato']);
        if ($data['apro'] == 'APROBADO: SI__X__ NO_____') {
            $aprobado = "SI";
        } else {
            $aprobado = "NO";
        }
        $this->setDatCi2("p_e_apr", $aprobado);
        $this->setDatCi2("p_fur_num", $data['fur_aso']); //.......................PENDIENTE
//______________________________________________________________________DATOS DEL CDA
        $this->setDatCi2("p_fur_aso", $data['fur_aso']);
        $this->setDatCi2("p_cda", $data['cda']->nombre_cda);
        $this->setDatCi2("p_nit", $data['cda']->numero_cda);
        $this->setDatCi2("p_dir", $data['sede']->direccion);
        $this->setDatCi2("p_div", $data['sede']->cod_ciudad . '000');
        $this->setDatCi2("p_ciu", $data['ciudadCDA']->nombre);
        $this->setDatCi2("p_tel", $data['sede']->telefono_uno);
        $this->setDatCi2("p_ema", $data['sede']->email);
        //______________________________________________________________________FECHA PRUEBA
        $fechaFur = date_format(date_create($data['fechafur']), 'd/m/Y H:i');
        $this->setDatCi2("p_1_fec_pru", str_replace("/", "", $fechaFur));
        //______________________________________________________________________DATOS DEL PROPIETARIO
        $this->setDatCi2("p_2_nom_raz", $data['propietario']->nombre1 . " " .
                $data['propietario']->nombre2 . " " .
                $data['propietario']->apellido1 . " " .
                $data['propietario']->apellido2);
        if ($data['propietario']->tipo_identificacion == 6) {
            $data['propietario']->tipo_identificacion = 5;
        }
        $this->setDatCi2("p_2_doc_tip", $data['propietario']->tipo_identificacion);
        $this->setDatCi2("p_2_doc", $data['propietario']->numero_identificacion);
        $this->setDatCi2("p_2_dir", $data['propietario']->direccion);
        $this->setDatCi2("p_2_tel", $data['propietario']->telefono1);
        $this->setDatCi2("p_2_ciu", $data['ciudadPropietario']->nombre);
        $this->setDatCi2("p_2_dep", $data['departamentoPropietario']->nombre);
        $this->setDatCi2("p_2_ema", $data['propietario']->correo);

        if ($data['vehiculo']->kilometraje === 'NO FUNCIONAL') {
            $data['vehiculo']->kilometraje = "0";
        }

        if ($data['vehiculo']->potencia_motor === 'No aplica') {
            $data['vehiculo']->potencia_motor = "0";
        }
        //______________________________________________________________________DATOS DEL VEHICULO
        $this->setDatCi2("p_3_mar", strtoupper($data['marca']->nombre));
        $this->setDatCi2("p_3_lin", strtoupper($data['linea']->nombre));
        $this->setDatCi2("p_3_cla", strtoupper($data['clase']->nombre));
        $this->setDatCi2("p_3_mod", $data['vehiculo']->ano_modelo);
        $this->setDatCi2("p_3_cil", $data['vehiculo']->cilindraje);
        $this->setDatCi2("p_3_ser", strtoupper($data['servicio']->nombre));
        $this->setDatCi2("p_3_vin", $data['vehiculo']->numero_vin);
        $this->setDatCi2("p_3_mot", $data['vehiculo']->numero_motor);
        $this->setDatCi2("p_3_lic", $data['vehiculo']->numero_tarjeta_propiedad);
        $this->setDatCi2("p_3_com", strtoupper($data['combustible']->nombre));
        $this->setDatCi2("p_3_col", strtoupper($data['color']->nombre));
        $this->setDatCi2("p_3_nac", strtoupper($data['pais']->nombre));
        $fechaMat = date_format(date_create($data['vehiculo']->fecha_matricula), 'd/m/Y');
        $this->setDatCi2("p_3_fec_lic", str_replace("/", "", $fechaMat));
        $this->setDatCi2("p_3_tip_mot", $data['vehiculo']->tiempos . " T");
        $this->setDatCi2("p_3_kil", $data['vehiculo']->kilometraje);
        $this->setDatCi2("p_3_sil", $data['pasajeros']);
        if ($data['vehiculo']->blindaje == "1") {
            $blindaje = "SI";
        } else {
            $blindaje = "NO";
        }
        $this->setDatCi2("p_3_vid_pol", '');
        $this->setDatCi2("p_3_bli", $blindaje);
        $this->setDatCi2("p_3_pot", $data['vehiculo']->potencia_motor);
        $this->setDatCi2("p_3_tip_car", $data['carroceria']->nombre);
        $fechaSoat = date_format(date_create($data['vehiculo']->fecha_vencimiento_soat), 'd/m/Y');
        $this->setDatCi2("p_3_fec_ven_soa", str_replace("/", "", $fechaSoat));
        switch ($data['vehiculo']->certificadoGas) {
            case 'SI ( ) NO ( ) N/A (X)':
                $dat = "NA";
                break;
            case 'SI ( ) NO (X) N/A ( )':
                $dat = "NO";
                break;
            case 'SI (X) NO ( ) N/A ( )':
                $dat = "SI";
                break;
            default:
                $dat = "NA";
                break;
        }

        $this->setDatCi2("p_3_con_gnv", $dat);

        if ($dat == 'NA' || $dat == 'NO') {
            $this->setDatCi2("p_3_fec_ven_gnv", "");
        } else {
            $fechaGNV = date_format(date_create($data['vehiculo']->fecha_final_certgas), 'd/m/Y');
            $this->setDatCi2("p_3_fec_ven_gnv", str_replace("/", "", $fechaGNV));
        }
        //______________________________________________________________________SONOMETRO
        $this->setDatCi2("p_4_rui_val", $data['sonometro']->valor_ruido_motor1);
        $this->setDatCi2("p_4_rui_max", $data['sonometro']->maximo_ruido_motor);
        //______________________________________________________________________LUCES BAJAS
        $this->setDatCi2("p_5_der_int_b1", $data['luces']->valor_baja_derecha_1);
        $this->setDatCi2("p_5_der_int_b2", $data['luces']->valor_baja_derecha_2);
        $this->setDatCi2("p_5_der_int_b3", $data['luces']->valor_baja_derecha_3);
        $this->setDatCi2("p_5_der_min", $data['luces']->intensidad_minima);
        $this->setDatCi2("p_5_der_inc_b1", $data['luces']->inclinacion_baja_derecha_1);
        $this->setDatCi2("p_5_der_inc_b2", $data['luces']->inclinacion_baja_derecha_2);
        $this->setDatCi2("p_5_der_inc_b3", $data['luces']->inclinacion_baja_derecha_3);
        $this->setDatCi2("p_5_der_ran", $data['luces']->inclinacion_rango);
        $this->setDatCi2("p_5_sim_der_b", $data['luces']->simultaneaBaja);
        $this->setDatCi2("p_5_izq_int_b1", $data['luces']->valor_baja_izquierda_1);
        $this->setDatCi2("p_5_izq_int_b2", $data['luces']->valor_baja_izquierda_2);
        $this->setDatCi2("p_5_izq_int_b3", $data['luces']->valor_baja_izquierda_3);
        $this->setDatCi2("p_5_izq_min", $data['luces']->intensidad_minima);
        $this->setDatCi2("p_5_izq_inc_b1", $data['luces']->inclinacion_baja_izquierda_1);
        $this->setDatCi2("p_5_izq_inc_b2", $data['luces']->inclinacion_baja_izquierda_2);
        $this->setDatCi2("p_5_izq_inc_b3", $data['luces']->inclinacion_baja_izquierda_3);
        $this->setDatCi2("p_5_izq_ran", $data['luces']->inclinacion_rango);
        $this->setDatCi2("p_5_sim_izq_b", $data['luces']->simultaneaBaja);
        //______________________________________________________________________LUCES ALTAS
        $this->setDatCi2("p_5_der_int_a1", $data['luces']->valor_alta_derecha_1);
        $this->setDatCi2("p_5_der_int_a2", $data['luces']->valor_alta_derecha_2);
        $this->setDatCi2("p_5_der_int_a3", $data['luces']->valor_alta_derecha_3);
        $this->setDatCi2("p_5_der_min_a", ''); //..................................PENDIENTE
        $this->setDatCi2("p_5_sim_der_a", $data['luces']->simultaneaAlta);
        $this->setDatCi2("p_5_izq_int_a1", $data['luces']->valor_alta_izquierda_1);
        $this->setDatCi2("p_5_izq_int_a2", $data['luces']->valor_alta_izquierda_2);
        $this->setDatCi2("p_5_izq_int_a3", $data['luces']->valor_alta_izquierda_3);
        $this->setDatCi2("p_5_izq_min_a", ''); //..................................PENDIENTE
        $this->setDatCi2("p_5_sim_izq_a", $data['luces']->simultaneaAlta);
        //______________________________________________________________________LUCES ANTINIEBLAS
        $this->setDatCi2("p_5_der_int_e1  ", $data['luces']->valor_antiniebla_derecha_1);
        $this->setDatCi2("p_5_der_int_e2", $data['luces']->valor_antiniebla_derecha_2);
        $this->setDatCi2("p_5_der_int_e3", $data['luces']->valor_antiniebla_derecha_3);
        $this->setDatCi2("p_5_der_min_e", ''); //..................................PENDIENTE
        $this->setDatCi2("p_5_sim_der_e", $data['luces']->simultaneaAntiniebla);
        $this->setDatCi2("p_5_izq_int_e1", $data['luces']->valor_antiniebla_izquierda_1);
        $this->setDatCi2("p_5_izq_int_e2", $data['luces']->valor_antiniebla_izquierda_2);
        $this->setDatCi2("p_5_izq_int_e3", $data['luces']->valor_antiniebla_izquierda_3);
        $this->setDatCi2("p_5_izq_min_e", ''); //..................................PENDIENTE
        $this->setDatCi2("p_5_sim_izq_e", $data['luces']->simultaneaAntiniebla);
        //______________________________________________________________________SUMA LUCES
        $this->setDatCi2("p_6_int", $data['luces']->intensidad_total);
        $this->setDatCi2("p_6_max", $data['luces']->intensidad_maxima);
        //______________________________________________________________________SUSPENSION
        $this->setDatCi2("p_7_del_der_val", $data['suspension']->delantera_derecha);
        $this->setDatCi2("p_7_del_izq_val", $data['suspension']->delantera_izquierda);
        $this->setDatCi2("p_7_tra_der_val", $data['suspension']->trasera_derecha);
        $this->setDatCi2("p_7_tra_izq_val", $data['suspension']->trasera_izquierda);
        $this->setDatCi2("p_7_min", $data['suspension']->minima);
        //______________________________________________________________________FRENO
        $this->setDatCi2("p_8_efi_tot", $data['frenos']->eficacia_total);
        $this->setDatCi2("p_8_efi_tot_min", $data['frenos']->n_eficacia_total);
        $this->setDatCi2("p_8_ej1_izq_fue", $data['frenos']->freno_1_izquierdo);
        $this->setDatCi2("p_8_ej1_izq_pes", $data['frenos']->peso_1_izquierdo);
        $this->setDatCi2("p_8_ej1_der_fue", $data['frenos']->freno_1_derecho);
        $this->setDatCi2("p_8_ej1_der_pes", $data['frenos']->peso_1_derecho);
        $this->setDatCi2("p_8_ej1_des", $data['frenos']->desequilibrio_1);
        $this->setDatCi2("p_8_ej1_ran", $data['frenos']->n_desequilibrio_B);
        $this->setDatCi2("p_8_ej1_max", $data['frenos']->n_desequilibrio_A);
        $this->setDatCi2("p_8_ej2_izq_fue", $data['frenos']->freno_2_izquierdo);
        $this->setDatCi2("p_8_ej2_izq_pes", $data['frenos']->peso_2_izquierdo);
        $this->setDatCi2("p_8_ej2_der_fue", $data['frenos']->freno_2_derecho);
        $this->setDatCi2("p_8_ej2_der_pes", $data['frenos']->peso_2_derecho);
        $this->setDatCi2("p_8_ej2_des", $data['frenos']->desequilibrio_2);
        $this->setDatCi2("p_8_ej2_ran", $data['frenos']->n_desequilibrio_B);
        $this->setDatCi2("p_8_ej2_max", $data['frenos']->n_desequilibrio_A);
        $this->setDatCi2("p_8_ej3_izq_fue", $data['frenos']->freno_3_izquierdo);
        $this->setDatCi2("p_8_ej3_izq_pes", $data['frenos']->peso_3_izquierdo);
        $this->setDatCi2("p_8_ej3_der_fue", $data['frenos']->freno_3_derecho);
        $this->setDatCi2("p_8_ej3_der_pes", $data['frenos']->peso_3_derecho);
        $this->setDatCi2("p_8_ej3_des", $data['frenos']->desequilibrio_3);
        $this->setDatCi2("p_8_ej3_ran", $data['frenos']->n_desequilibrio_B);
        $this->setDatCi2("p_8_ej3_max", $data['frenos']->n_desequilibrio_A);
        $this->setDatCi2("p_8_ej4_izq_fue", $data['frenos']->freno_4_izquierdo);
        $this->setDatCi2("p_8_ej4_izq_pes", $data['frenos']->peso_4_izquierdo);
        $this->setDatCi2("p_8_ej4_der_fue", $data['frenos']->freno_4_derecho);
        $this->setDatCi2("p_8_ej4_der_pes", $data['frenos']->peso_4_derecho);
        $this->setDatCi2("p_8_ej4_des", $data['frenos']->desequilibrio_4);
        $this->setDatCi2("p_8_ej4_ran", $data['frenos']->n_desequilibrio_B);
        $this->setDatCi2("p_8_ej4_max", $data['frenos']->n_desequilibrio_A);
        $this->setDatCi2("p_8_ej5_izq_fue", $data['frenos']->freno_5_izquierdo);
        $this->setDatCi2("p_8_ej5_izq_pes", $data['frenos']->peso_5_izquierdo);
        $this->setDatCi2("p_8_ej5_der_fue", $data['frenos']->freno_5_derecho);
        $this->setDatCi2("p_8_ej5_der_pes", $data['frenos']->peso_5_derecho);
        $this->setDatCi2("p_8_ej5_des", $data['frenos']->desequilibrio_5);
        $this->setDatCi2("p_8_ej5_ran", $data['frenos']->n_desequilibrio_B);
        $this->setDatCi2("p_8_ej5_max", $data['frenos']->n_desequilibrio_A);
        //______________________________________________________________________FRENO AUXILIAR
        $this->setDatCi2("p_8_efi_aux", $data['frenos']->eficacia_auxiliar);
        $this->setDatCi2("p_8_efi_aux_min", $data['frenos']->n_eficacia_auxiliar);
        $this->setDatCi2("p_8_sum_izq_aux_fue", $data['frenos']->sum_freno_aux_izquierdo);
        $this->setDatCi2("p_8_sum_izq_aux_pes", $data['frenos']->sum_peso_izquierdo);
        $this->setDatCi2("p_8_sum_der_aux_fue", $data['frenos']->sum_freno_aux_derecho);
        $this->setDatCi2("p_8_sum_der_aux_pes", $data['frenos']->sum_peso_derecho);
        //______________________________________________________________________DESVIACION LATERAL
        $this->setDatCi2("p_9_ej1", $data['alineacion']->alineacion_1);
        $this->setDatCi2("p_9_ej2", $data['alineacion']->alineacion_2);
        $this->setDatCi2("p_9_ej3", $data['alineacion']->alineacion_3);
        $this->setDatCi2("p_9_ej4", $data['alineacion']->alineacion_4);
        $this->setDatCi2("p_9_ej5", $data['alineacion']->alineacion_5);
        $this->setDatCi2("p_9_max", $data['alineacion']->minmax);
        //______________________________________________________________________DISPOSITIVOS DE COBRO
        $this->setDatCi2("p_10_ref_com_lla", $data['taximetro']->r_llanta);
        $this->setDatCi2("p_10_err_dis", $data['taximetro']->distancia);
        $this->setDatCi2("p_10_err_tie", $data['taximetro']->tiempo);
        $this->setDatCi2("p_10_max", $data['taximetro']->minmax);
        //______________________________________________________________________GASES
        $this->setDatCi2("p_11_co_ral_val", $data['gases']->co_ralenti);
        $this->setDatCi2("p_11_co_ral_nor", $data['gases']->CoFlag_);
        $this->setDatCi2("p_11_co2_ral_val", $data['gases']->co2_ralenti);
        $this->setDatCi2("p_11_co2_ral_nor", $data['gases']->Co2Flag_);
        $this->setDatCi2("p_11_o2_ral_val", $data['gases']->o2_ralenti);
        $this->setDatCi2("p_11_o2_ral_nor", $data['gases']->O2Flag_);
        $this->setDatCi2("p_11_hc_ral_val", $data['gases']->hc_ralenti);
        $this->setDatCi2("p_11_hc_ral_nor", $data['gases']->HcFlag_);
        $this->setDatCi2("p_11_co_cru_val", $data['gases']->co_crucero);
        $this->setDatCi2("p_11_co_cru_nor", $data['gases']->CoFlag_);
        $this->setDatCi2("p_11_co2_cru_val", $data['gases']->co2_crucero);
        $this->setDatCi2("p_11_co2_cru_nor", $data['gases']->Co2Flag_);
        $this->setDatCi2("p_11_o2_cru_val", $data['gases']->o2_crucero);
        $this->setDatCi2("p_11_o2_cru_nor", $data['gases']->O2Flag_);
        $this->setDatCi2("p_11_hc_cru_val", $data['gases']->hc_crucero);
        $this->setDatCi2("p_11_hc_cru_nor", $data['gases']->HcFlag_);
        if ($data['gases']->temperatura == "") {
            $data['gases']->temperatura = "0";
        }
        $this->setDatCi2("p_11_tem_ral", $data['gases']->temperatura);
        $this->setDatCi2("p_11_rpm_ral", $data['gases']->rpm_ralenti);
        $this->setDatCi2("p_11_tem_cru", $data['gases']->temperatura);
        $this->setDatCi2("p_11_rpm_cru", $data['gases']->rpm_crucero);
        $this->setDatCi2("p_11_no_ral_val", '');
        $this->setDatCi2("p_11_no_ral_nor", '');
        $this->setDatCi2("p_11_no_cru_val", '');
        $this->setDatCi2("p_11_no_cru_nor", '');
        $this->setDatCi2("p_11_cat", $data['vehiculo']->convertidor);
        $this->setDatCi2("p_11_hum_amb", $data['gases']->temperatura_ambiente);
        $this->setDatCi2("p_11_hum_rel", $data['gases']->humedad);
        //______________________________________________________________________OPACIDAD
        $this->setDatCi2("p_11_b_ci1", $data['opacidad']->op_ciclo1);
        $this->setDatCi2("p_11_b_ci2", $data['opacidad']->op_ciclo2);
        $this->setDatCi2("p_11_b_ci3", $data['opacidad']->op_ciclo3);
        $this->setDatCi2("p_11_b_ci4", $data['opacidad']->op_ciclo4);
        $this->setDatCi2("p_11_b_c1_gob", $data['opacidad']->rpm_ciclo1);
        $this->setDatCi2("p_11_b_c2_gob", $data['opacidad']->rpm_ciclo2);
        $this->setDatCi2("p_11_b_c3_gob", $data['opacidad']->rpm_ciclo3);
        $this->setDatCi2("p_11_b_c4_gob", $data['opacidad']->rpm_ciclo4);
        $this->setDatCi2("p_11_b_res_val", $data['opacidad']->opacidad_total);
        $this->setDatCi2("p_11_b_res_nor", $data['opacidad']->max);
        $this->setDatCi2("p_11_b_rpm", $data['opacidad']->rpm_ralenti);
        $this->setDatCi2("p_11_b_tem_ini", $data['opacidad']->temp_final);
        $this->setDatCi2("p_11_b_tem_fin", $data['opacidad']->temp_inicial);
        $this->setDatCi2("p_11_b_tem_amb", $data['opacidad']->temp_ambiente);
        $this->setDatCi2("p_11_b_hum", $data['opacidad']->humedad);
        $this->setDatCi2("p_11_b_lot", $data['vehiculo']->diametro_escape);
        $this->setDatCi2("p_v01", '');
        $this->setDatCi2("p_v02", '');
        $this->setDatCi2("p_v03", '');
        //______________________________________________________________________DEFECTOS MECANIZADOS
        $c_cod = "";
        $c_des = "";
        $c_gru = "";
        $c_tip_def_a = "";
        $c_tip_def_b = "";
        $c_tip_def_a_tot = "0";
        $c_tip_def_b_tot = "0";
        if (count($data['defectosMecanizadosA']) > 0) {
            $c_tip_def_a_tot = count($data['defectosMecanizadosA']);
            foreach ($data['defectosMecanizadosA'] as $def) {
                $c_cod = $c_cod . $def->codigo . ";";
                $c_des = $c_des . $def->descripcion . ";";
                $c_gru = $c_gru . $def->grupo . ";";
                $c_tip_def_a = $c_tip_def_a . "X;";
                $c_tip_def_b = $c_tip_def_b . ";";
            }
        }
        if (count($data['defectosMecanizadosB']) > 0) {
            $c_tip_def_b_tot = count($data['defectosMecanizadosB']);
            foreach ($data['defectosMecanizadosB'] as $def) {
                $c_cod = $c_cod . $def->codigo . ";";
                $c_des = $c_des . $def->descripcion . ";";
                $c_gru = $c_gru . $def->grupo . ";";
                $c_tip_def_a = $c_tip_def_a . ";";
                $c_tip_def_b = $c_tip_def_b . "X;";
            }
        }
        $this->setDatCi2("p_c_cod", $c_cod);
        $this->setDatCi2("p_c_des", $c_des);
        $this->setDatCi2("p_c_gru", $c_gru);
        $this->setDatCi2("p_c_tip_def_a", $c_tip_def_a);
        $this->setDatCi2("p_c_tip_def_b", $c_tip_def_b);
        $this->setDatCi2("p_c_tip_def_a_tot", $c_tip_def_a_tot);
        $this->setDatCi2("p_c_tip_def_b_tot", $c_tip_def_b_tot);
        //______________________________________________________________________DEFECTOS SENSORIALES
        $d_cod = "";
        $d_des = "";
        $d_gru = "";
        $d_tip_def_a = "";
        $d_tip_def_b = "";
        $d_tip_def_a_tot = "0";
        $d_tip_def_b_tot = "0";
        if (count($data['defectosSensorialesA']) > 0) {
            $d_tip_def_a_tot = count($data['defectosSensorialesA']);
            foreach ($data['defectosSensorialesA'] as $def) {
                $d_cod = $d_cod . $def->codigo . ";";
                $d_des = $d_des . $def->descripcion . ";";
                $d_gru = $d_gru . $def->grupo . ";";
                $d_tip_def_a = $d_tip_def_a . "X;";
                $d_tip_def_b = $d_tip_def_b . ";";
            }
        }
        if (count($data['defectosSensorialesB']) > 0) {
            $d_tip_def_b_tot = count($data['defectosSensorialesB']);
            foreach ($data['defectosSensorialesB'] as $def) {
                $d_cod = $d_cod . $def->codigo . ";";
                $d_des = $d_des . $def->descripcion . ";";
                $d_gru = $d_gru . $def->grupo . ";";
                $d_tip_def_a = $d_tip_def_a . ";";
                $d_tip_def_b = $d_tip_def_b . "X;";
            }
        }
        $this->setDatCi2("p_d_cod", $d_cod);
        $this->setDatCi2("p_d_des", $d_des);
        $this->setDatCi2("p_d_gru", $d_gru);
        $this->setDatCi2("p_d_tip_def_a", $d_tip_def_a);
        $this->setDatCi2("p_d_tip_def_b", $d_tip_def_b);
        $this->setDatCi2("p_d_tip_def_a_tot", $d_tip_def_a_tot);
        $this->setDatCi2("p_d_tip_def_b_tot", $d_tip_def_b_tot);
        //______________________________________________________________________DEFECTOS ENSENANZA
        $d1_cod = "";
        $d1_des = "";
        $d1_gru = "";
        $d1_tip_def_a = "";
        $d1_tip_def_b = "";
        $d1_tip_def_a_tot = "0";
        $d1_tip_def_b_tot = "0";
        if (count($data['defectosEnsenanzaA']) > 0) {
            $d1_tip_def_a_tot = count($data['defectosEnsenanzaA']);
            foreach ($data['defectosEnsenanzaA'] as $def) {
                $d1_cod = $d1_cod . $def->codigo . ";";
                $d1_des = $d1_des . $def->descripcion . ";";
                $d1_gru = $d1_gru . $def->grupo . ";";
                $d1_tip_def_a = $d1_tip_def_a . "X;";
                $d1_tip_def_b = $d1_tip_def_b . ";";
            }
        }
        if (count($data['defectosEnsenanzaB']) > 0) {
            $d1_tip_def_b_tot = count($data['defectosEnsenanzaB']);
            foreach ($data['defectosEnsenanzaB'] as $def) {
                $d1_cod = $d1_cod . $def->codigo . ";";
                $d1_des = $d1_des . $def->descripcion . ";";
                $d1_gru = $d1_gru . $def->grupo . ";";
                $d1_tip_def_a = $d1_tip_def_a . ";";
                $d1_tip_def_b = $d1_tip_def_b . "X;";
            }
        }
        $this->setDatCi2("p_d1_cod", $d1_cod);
        $this->setDatCi2("p_d1_des", $d1_des);
        $this->setDatCi2("p_d1_gru", $d1_gru);
        $this->setDatCi2("p_d1_tip_def_a", $d1_tip_def_a);
        $this->setDatCi2("p_d1_tip_def_b", $d1_tip_def_b);
        $this->setDatCi2("p_d1_tip_def_a_tot", $d1_tip_def_a_tot);
        $this->setDatCi2("p_d1_tip_def_b_tot", $d1_tip_def_b_tot);
        //______________________________________________________________________PROFUNDIDAD DE LABRADO
        $this->setDatCi2("p_d2_ej1_izq", $data['labrado']->eje1_izquierdo);
        $this->setDatCi2("p_d2_ej2_izq_r1", $data['labrado']->eje2_izquierdo);
        $this->setDatCi2("p_d2_ej2_izq_r2", $data['labrado']->eje2_izquierdo_interior);
        $this->setDatCi2("p_d2_ej3_izq_r1", $data['labrado']->eje3_izquierdo);
        $this->setDatCi2("p_d2_ej3_izq_r2", $data['labrado']->eje3_izquierdo_interior);
        $this->setDatCi2("p_d2_ej4_izq_r1", $data['labrado']->eje4_izquierdo);
        $this->setDatCi2("p_d2_ej4_izq_r2", $data['labrado']->eje4_izquierdo_interior);
        $this->setDatCi2("p_d2_ej5_izq_r1", $data['labrado']->eje5_izquierdo);
        $this->setDatCi2("p_d2_ej5_izq_r2", $data['labrado']->eje5_izquierdo_interior);
        $this->setDatCi2("p_d2_ej1_der", $data['labrado']->eje1_derecho);
        $this->setDatCi2("p_d2_ej2_der_r1", $data['labrado']->eje2_derecho);
        $this->setDatCi2("p_d2_ej2_der_r2", $data['labrado']->eje2_derecho_interior);
        $this->setDatCi2("p_d2_ej3_der_r1", $data['labrado']->eje3_derecho);
        $this->setDatCi2("p_d2_ej3_der_r2", $data['labrado']->eje3_derecho_interior);
        $this->setDatCi2("p_d2_ej4_der_r1", $data['labrado']->eje4_derecho);
        $this->setDatCi2("p_d2_ej4_der_r2", $data['labrado']->eje4_derecho_interior);
        $this->setDatCi2("p_d2_ej5_der_r1", $data['labrado']->eje5_derecho);
        $this->setDatCi2("p_d2_ej5_der_r2", $data['labrado']->eje5_derecho_interior);
        $this->setDatCi2("p_d2_rep_r1", $data['labrado']->repuesto);
        $this->setDatCi2("p_d2_rep_r2", $data['labrado']->repuesto2);
        //______________________________________________________________________ENSENANZA RESUL
        if ($data['vehiculo']->ensenanza == '1') {
            if ($data['aproE'] == 'APROBADO: SI__X__ NO_____') {
                $aprobadoE = "SI";
            } else {
                $aprobadoE = "NO";
            }
        } else {
            $aprobadoE = "";
        }
        $this->setDatCi2("p_e1_apr", $aprobadoE);
        //______________________________________________________________________OBSERVACIONES
        $obs = '';
        if (count($data['observaciones']) > 0) {
            foreach ($data['observaciones'] as $o) {
                $obs = $obs . "$o->codigo: $o->descripcion;";
            }
        }
        $this->setDatCi2("p_f_com_obs", $obs);

        $luxometro = explode("$", $data['maquinas']->nombreLuxometro);
        $luxometroOperario = '';
        if (count($luxometro) > 1) {
            $luxometroOperario = $luxometro[0] . "_" . str_replace('^', '', $luxometro[8]) . ";";
            $luxometro = $luxometro[0] . "_" . $luxometro[1] . "_" . $luxometro[2] . "_" . $luxometro[3] . "_" . $luxometro[4] . "_" . $luxometro[5] . ";";
        } else {
            $luxometro = '';
        }
        $opacimetro = explode("$", $data['maquinas']->nombreOpacimetro);
        $opacimetroOperario = '';
        //        var_dump($opacimetro);
        if (count($opacimetro) > 1) {
            $opacimetroOperario = $opacimetro[0] . "_" . str_replace('^', '', $opacimetro[8]) . ";";
            $opacimetro = $opacimetro[0] . "_" . $opacimetro[1] . "_" . $opacimetro[2] . "_" . $opacimetro[3] . "_" . $opacimetro[4] . "_" . $opacimetro[5] . ";";
        } else {
            $opacimetro = '';
        }
        $gases = explode("$", $data['maquinas']->nombreGases);
        $gasesOperario = '';
        if (count($gases) > 1) {
            $gasesOperario = $gases[0] . "_" . str_replace('^', '', $gases[8]) . ";";
            $gases = $gases[0] . "_" . $gases[1] . "_" . $gases[2] . "_" . $gases[3] . "_" . $gases[4] . "_" . $gases[5] . ";";
        } else {
            $gases = '';
        }
        $fotos = explode("$", $data['maquinas']->nombreFotos);
        $fotosOperario = '';
        if (count($fotos) > 1) {
            $fotosOperario = $fotos[0] . "_" . str_replace('^', '', $fotos[8]) . ";";
            $fotos = $fotos[0] . "_" . $fotos[1] . "_" . $fotos[2] . "_" . $fotos[3] . "_" . $fotos[4] . "_" . $fotos[5] . ";";
        } else {
            $fotos = '';
        }
        $taximetro = explode("$", $data['maquinas']->nombreTaximetro);
        $taximetroOperario = '';
        if (count($taximetro) > 1) {
            $taximetroOperario = $taximetro[0] . "_" . str_replace('^', '', $taximetro[8]) . ";";
            $taximetro = $taximetro[0] . "_" . $taximetro[1] . "_" . $taximetro[2] . "_" . $taximetro[3] . "_" . $taximetro[4] . "_" . $taximetro[5] . ";";
        } else {
            $taximetro = '';
        }
        $frenos = explode("$", $data['maquinas']->nombreFrenos);
        $frenosOperario = '';
        if (count($frenos) > 1) {
            $frenosOperario = $frenos[0] . "_" . str_replace('^', '', $frenos[8]) . ";";
            $frenos = $frenos[0] . "_" . $frenos[1] . "_" . $frenos[2] . "_" . $frenos[3] . "_" . $frenos[4] . "_" . $frenos[5] . ";";
        } else {
            $frenos = '';
        }
        $visual = explode("$", $data['maquinas']->nombreVisual);
        $visualOperario = '';
        if (count($visual) > 1) {
            $visualOperario = $visual[0] . "_" . str_replace('^', '', $visual[8]) . ";";
            $visual = $visual[0] . "_" . $visual[1] . "_" . $visual[2] . "_" . $visual[3] . "_" . $visual[4] . "_" . $visual[5] . ";";
        } else {
            $visual = '';
        }
        $suspension = explode("$", $data['maquinas']->nombreSuspension);
        $suspensionOperario = '';
        if (count($suspension) > 1) {
            $suspensionOperario = $suspension[0] . "_" . str_replace('^', '', $suspension[8]) . ";";
            $suspension = $suspension[0] . "_" . $suspension[1] . "_" . $suspension[2] . "_" . $suspension[3] . "_" . $suspension[4] . "_" . $suspension[5] . ";";
        } else {
            $suspension = '';
        }
        $alineador = explode("$", $data['maquinas']->nombreAlineador);
        $alineadorOperario = '';
        if (count($alineador) > 1) {
            $alineadorOperario = $alineador[0] . "_" . str_replace('^', '', $alineador[8]) . ";";
            $alineador = $alineador[0] . "_" . $alineador[1] . "_" . $alineador[2] . "_" . $alineador[3] . "_" . $alineador[4] . "_" . $alineador[5] . ";";
        } else {
            $alineador = '';
        }
        $th = explode("$", $data['maquinas']->nombreTermohigrometro);
        if (count($th) > 1) {
            $th = $th[0] . "_" . $th[1] . "_" . $th[2] . "_" . $th[3] . "_" . $th[4] . "_" . $th[5] . ";";
        } else {
            $th = '';
        }
        $profundimetro = explode("$", $data['maquinas']->nombreProfundimetro);
        if (count($profundimetro) > 1) {
            $profundimetro = $profundimetro[0] . "_" . $profundimetro[1] . "_" . $profundimetro[2] . "_" . $profundimetro[3] . "_" . $profundimetro[4] . "_" . $profundimetro[5] . ";";
        } else {
            $profundimetro = '';
        }
        $captador = explode("$", $data['maquinas']->nombreCaptador);
        if (count($captador) > 1) {
            $captador = $captador[0] . "_" . $captador[1] . "_" . $captador[2] . "_" . $captador[3] . "_" . $captador[4] . "_" . $captador[5] . ";";
        } else {
            $captador = '';
        }
        $piederey = explode("$", $data['maquinas']->nombrePiederey);
        if (count($piederey) > 1) {
            $piederey = $piederey[0] . "_" . $piederey[1] . "_" . $piederey[2] . "_" . $piederey[3] . "_" . $piederey[4] . "_" . $piederey[5] . ";";
        } else {
            $piederey = '';
        }
        //______________________________________________________________________OPERARIOS
        $operarios = $luxometroOperario . $opacimetroOperario . $gasesOperario . $fotosOperario . $taximetroOperario . $frenosOperario . $visualOperario . $suspensionOperario . $alineadorOperario;
        //        $this->setDatCi2("h_nom_ope_rea_rev_tec", str_replace("<br>", ";", $data['inspectores']));
        $this->setDatCi2("p_h_nom_ope_rea_rev_tec", $operarios);
        //______________________________________________________________________PERISFERICOS

        $maquinas = $luxometro . $opacimetro . $gases . $fotos . $taximetro . $frenos . $visualOperario . $suspension . $alineador . $th . $profundimetro . $captador . $piederey;
        $this->setDatCi2("p_h_equ_rev", $maquinas);
        //______________________________________________________________________SOFTWARE
        $this->setDatCi2("p_i_sof_rev", $data["software"]);
        //______________________________________________________________________JEFE DE PISTA
        $this->setDatCi2("p_g_nom_fir_dir_tec", $data['hojatrabajo']->jefelinea);
        //______________________________________________________________________CAUSA RECHAZO
        if ($aprobado == 'NO') {
            $this->setDatCi2("p_causa_rechazo", $c_cod . $d_cod . $d1_cod);
        } else {
            $this->setDatCi2("p_causa_rechazo", '');
        }
        //______________________________________________________________________FOTO
        $fotos = str_replace("@", "", $data['fotografia']->imagen1) . ";" . str_replace("@", "", $data['fotografia']->imagen2);
        $this->setDatCi2("p_foto", $fotos);
        //______________________________________________________________________________ENVIAR A CI2

        $url = 'http://' . $this->ipSicov . '/ci2_cda_ws/sincrofur.asmx?wsdl';
        $datos_conexion = explode(":", $this->ipSicov);
        if ($this->sicovModoAlternativo == '1') {
            $url = 'http://' . $this->ipSicovAlternativo . '/ci2_cda_ws/sincrofur.asmx?wsdl';
            $datos_conexion = explode(":", $this->ipSicovAlternativo);
        }
        $host = $datos_conexion[0];
        if (count($datos_conexion) > 1) {
            $port = $datos_conexion[1];
        } else {
            $port = 80;
        }
        $waitTimeoutInSeconds = 2;
        error_reporting(0);
        if ($data['ocasion'] === 'true') {
            $ocasion = '2';
        } else {
            $ocasion = '1';
        }
        if ($fp = fsockopen($host, $port, $errCode, $errStr, $waitTimeoutInSeconds)) {
            $client = new SoapClient($url);
            $fur = array(
                'fur' => $this->arrayCi2
            );

            $respuesta = $client->ingresar_fur_v2($fur);
            $rtaCP = $respuesta->ingresar_fur_v2Result;
            //        $rtaCP = new stdClass();
//        $rtaCP->CodigoRespuesta = '0000';
//        $rtaCP->MensajeRespuesta = 'Transacción exitosa';

            $tipo = 'f';
            if ($rtaCP->CodigoRespuesta == '0000') {
                $estado = 'exito';
                $datos['idhojapruebas'] = $data['idhojapruebas'];
                $datos['sicov'] = '1';
                if (!$this->segundo_envio) {
                    if ($aprobado == 'NO') {
                        $datos['estadototal'] = '3';
                    } else {
                        $datos['estadototal'] = '2';
                    }
                } else {
                    if ($aprobado == 'NO') {
                        $datos['estadototal'] = '7';
                    } else {
                        $datos['estadototal'] = '4';
                    }
                    $tipo = 'r';
                }
                $this->Mhojatrabajo->update_x($datos);
            } else {
                if ($this->segundo_envio) {
                    $tipo = 'r';
                }
                $estado = 'error';
            }
            $mensaje = $this->mensajesCI2($rtaCP->CodigoRespuesta, $rtaCP->CodigoRespuesta . '|' . $ocasion . '|' . $estado . '|' . $rtaCP->MensajeRespuesta);
            $this->insertarEvento($data['vehiculo']->numero_placa, json_encode($fur), $tipo, '1', $mensaje);
        } else {
            $mensaje = $this->mensajesCI2('1000', '1000' . '|' . $ocasion . '|1|No hay conexión con sicov');
            $this->insertarEvento($data['vehiculo']->numero_placa, '', 'f', '1', $mensaje);
        }
        echo $mensaje;
    }

    private function insertarEvento($idelemento, $cadena, $tipo, $enviado, $respuesta) {
        $data['idelemento'] = $idelemento;
        $data['cadena'] = $cadena;
        $data['tipo'] = $tipo;
        $data['enviado'] = $enviado;
        $data['respuesta'] = $respuesta;
        $this->MEventosindra->insert($data);
    }

    private function setDatCi2($campo, $valor) {
        $dato = $this->formato_texto($valor);
        if ($this->segundo_envio) {
            switch ($campo) {
                case 'usuario':
                    break;
                case 'clave':
                    break;
                case 'p_pin':
                    break;
                case 'p_3_plac':
                    break;
                case 'p_e_con_run':
                    break;
                case 'p_tw01':
                    break;
                default:
                    $dato = '';
                    break;
            }
        }
        $this->arrayCi2[$campo] = $dato;
    }

    private function mensajesCI2($codigo, $detalle) {
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

    //______________________________________________________________________________TRAMA INDRA
    private function buildIndra($data) {
        //------------------------------------------------------------------------------IdProveedor
        $IdProveedor = "862";
        //------------------------------------------------------------------------------Propietario
        switch ($data['propietario']->tipo_identificacion) {
            case '1':
                $tipoDocumento = "C";
                break;
            case '2':
                $tipoDocumento = "N";
                break;
            case '3':
                $tipoDocumento = "E";
                break;
            case '4':
                $tipoDocumento = "T";
                break;
            case '5':
                $tipoDocumento = "U";
                break;
            case '6':
                $tipoDocumento = "P";
                break;
        }
        $propietario = $data['propietario']->nombre1 . " " .
                $data['propietario']->nombre2 . " " .
                $data['propietario']->apellido1 . " " .
                $data['propietario']->apellido2 . ";" .
                $tipoDocumento . ";" .
                $data['propietario']->numero_identificacion . ";" .
                $data['propietario']->direccion . ";" .
                $data['propietario']->telefono1 . ";" .
                $data['ciudadPropietario']->nombre . ";" .
                $data['departamentoPropietario']->nombre . ";" .
                $data['propietario']->correo;
        //------------------------------------------------------------------------------Vehiculos
        if ($data['vehiculo']->idservicio == 3) {
            $servicio = 1;
        } else if ($data['vehiculo']->idservicio == 4) {
            $servicio = 3;
        } else if ($data['vehiculo']->idservicio == 1) {
            $servicio = 4;
        } else {
            $servicio = $data['vehiculo']->idservicio;
        }

        if ($data['vehiculo']->idclase == 13) {
            $clase = 41;
        } else if ($data['vehiculo']->idclase == 16) {
            $clase = 43;
        } else if ($data['vehiculo']->idclase == 9) {
            $clase = 42;
        } else if ($data['vehiculo']->idclase == 15) {
            $clase = 24;
        } else {
            $clase = $data['vehiculo']->idclase;
        }

        if ($data['vehiculo']->idtipocombustible == 1) {
            $combustible = 3;
        } else if ($data['vehiculo']->idtipocombustible == 2) {
            $combustible = 1;
        } else if ($data['vehiculo']->idtipocombustible == 3) {
            $combustible = 2;
        } else {
            $combustible = $data['vehiculo']->idtipocombustible;
        }
        if ($data['vehiculo']->tiempos == 2) {
            $tiempos = 1;
        } else if ($data['vehiculo']->tiempos == 4) {
            $tiempos = 2;
        } else {
            $tiempos = -1;
        }

        if ($data['vehiculo']->blindaje == "1") {
            $blindaje = "true";
        } else {
            $blindaje = "false";
        }
        if ($data['apro'] == 'APROBADO: SI__X__ NO_____') {
            $aprobado = "1";
        } else {
            $aprobado = "2";
        }
        switch ($data['vehiculo']->certificadoGas) {
            case 'SI ( ) NO ( ) N/A (X)':
                $conversionGas = "NA";
                break;
            case 'SI ( ) NO (X) N/A ( )':
                $conversionGas = "NO";
                break;
            case 'SI (X) NO ( ) N/A ( )':
                $conversionGas = "SI";
                break;
            default:
                $conversionGas = "NA";
                break;
        }
        $fechacer = '';
        if ($conversionGas == 'NA' || $conversionGas == 'NO') {
            $fechacer = '';
        } else {
            $fechacer = date_format(date_create($data['vehiculo']->fecha_final_certgas), 'Y-m-d');
        }

        if ($data['vehiculo']->kilometraje === 'NO FUNCIONAL') {
            $data['vehiculo']->kilometraje = "0";
        }

        if ($data['vehiculo']->potencia_motor === 'No aplica') {
            $data['vehiculo']->potencia_motor = "0";
        }

        $vehiculo = $data['vehiculo']->usuario_registro . ";" .
                $data['vehiculo']->documento_usuario . ";" .
                $data['vehiculo']->numero_placa . ";" .
                $data['pais']->nombre . ";" .
                $servicio . ";" .
                $clase . ";" .
                $data['marca']->nombre . ";" .
                $data['linea']->nombre . ";" .
                $data['vehiculo']->ano_modelo . ";" .
                $data['vehiculo']->numero_tarjeta_propiedad . ";" .
                $data['vehiculo']->fecha_matricula . " 00:00:00;" .
                $data['color']->nombre . ";" .
                $combustible . ";" .
                $data['vehiculo']->numero_vin . ";" .
                $data['vehiculo']->numero_motor . ";" .
                $tiempos . ";" .
                $data['vehiculo']->cilindraje . ";" .
                $data['vehiculo']->kilometraje . ";" .
                $data['pasajeros'] . ";" .
                $blindaje . ";" .
                $data['ocasion'] . ";" .
                date_format(date_create($data['fechafur']), 'Y-m-d H:i:s') . ";" .
                $aprobado . ";" .
                $data['vehiculo']->potencia_motor . ";" .
                $data['vehiculo']->diseno . ";" .
                date_format(date_create($data['vehiculo']->fecha_vencimiento_soat), 'Y-m-d') . ";" .
                $conversionGas . ";" .
                $fechacer;

        //------------------------------------------------------------------------------Fotos
        $fotos = $data['vehiculo']->numero_placa . ";" .
                str_replace("@", "", $data['fotografia']->imagen1) . ";" .
                str_replace("@", "", $data['fotografia']->imagen2);
        //------------------------------------------------------------------------------Gases
        $diesel = "";
        $gasesCarro = "";
        $gasesMoto = "";
        if ($combustible == 3) {
            $diesel = $data['opacidad']->operario . ";" .
                    $data['opacidad']->documento . ";" .
                    $data['opacidad']->temp_ambiente . ";" .
                    $data['opacidad']->rpm_ralenti . ";" .
                    $data['opacidad']->rpm_ciclo1 . ";" .
                    $data['opacidad']->rpm_ciclo2 . ";" .
                    $data['opacidad']->rpm_ciclo3 . ";" .
                    $data['opacidad']->rpm_ciclo4 . ";" .
                    $data['opacidad']->op_ciclo1 . ";" .
                    $data['opacidad']->op_ciclo2 . ";" .
                    $data['opacidad']->op_ciclo3 . ";" .
                    $data['opacidad']->op_ciclo4 . ";" .
                    $data['opacidad']->opacidad_total . ";" .
                    $data['opacidad']->temp_inicial . ";" .
                    $data['opacidad']->temp_final . ";" .
                    $data['opacidad']->humedad . ";" .
                    $data['vehiculo']->diametro_escape . "|" . //cambiar
                    $data['opacidad']->fugasTuboEscape . ";" .
                    $data['opacidad']->fugasSilenciador . ";" .
                    $data['opacidad']->tapaCombustible . ";" .
                    $data['opacidad']->tapaAceite . ";" .
                    $data['opacidad']->sistemaMuestreo . ";" .
                    $data['opacidad']->salidasAdicionales . ";" .
                    $data['opacidad']->filtroAire . ";" .
                    $data['opacidad']->sistemaRefrigeracion . ";" .
                    $data['opacidad']->revolucionesFueraRango . "|";
            $diesel = str_replace(".", ",", str_replace("*", "", $diesel));
        } elseif ($combustible == 1 || $combustible == 2 || $combustible == 4) {
            if ($data['vehiculo']->tipo_vehiculo !== "3") {
                $gasesCarro = $data['gases']->operario . "';" .
                        $data['gases']->documento . ";" .
                        $data['gases']->rpm_ralenti . ";" .
                        $data['gases']->hc_ralenti . ";" .
                        $data['gases']->co_ralenti . ";" .
                        $data['gases']->co2_ralenti . ";" .
                        $data['gases']->o2_ralenti . ";" .
                        $data['gases']->rpm_crucero . ";" .
                        $data['gases']->hc_crucero . ";" .
                        $data['gases']->co_crucero . ";" .
                        $data['gases']->co2_crucero . ";" .
                        $data['gases']->o2_crucero . ";" .
                        $data['gases']->dilucion . ";" .
                        substr($data['vehiculo']->convertidor, 0, 1) . ";" .
                        $data['gases']->temperatura . ";" .
                        $data['gases']->temperatura_ambiente . ";" .
                        $data['gases']->humedad . "|" .
                        $data['gases']->fugasTuboEscape . ";" .
                        $data['gases']->fugasSilenciador . ";" .
                        $data['gases']->tapaCombustible . ";" .
                        $data['gases']->tapaAceite . ";" .
                        $data['gases']->salidasAdicionales . ";" .
                        $data['gases']->presenciaHumos . ";" .
                        $data['gases']->revolucionesFueraRango . ";" .
                        $data['gases']->fallaSistemaRefrigeracion . "|";
                $gasesCarro = str_replace(".", ",", str_replace("*", "", $gasesCarro));
            } else {
                $gasesMoto = $data['gases']->operario . "';" .
                        $data['gases']->documento . ";" .
                        $data['gases']->temperatura . ";" .
                        $data['gases']->rpm_ralenti . ";" .
                        $data['gases']->hc_ralenti . ";" .
                        $data['gases']->co_ralenti . ";" .
                        $data['gases']->co2_ralenti . ";" .
                        $data['gases']->o2_ralenti . ";" .
                        $data['gases']->temperatura_ambiente . ";" .
                        $data['gases']->humedad . "|" .
                        $data['gases']->revolucionesFueraRango . ";" .
                        $data['gases']->fugasTuboEscape . ";" .
                        $data['gases']->fugasSilenciador . ";" .
                        $data['gases']->tapaCombustible . ";" .
                        $data['gases']->tapaAceite . ";" .
                        $data['gases']->salidasAdicionales . ";" .
                        $data['gases']->presenciaHumos . "|";
                $gasesMoto = str_replace(".", ",", str_replace("*", "", $gasesMoto));
            }
        } else {
            $diesel = "||";
            $gasesCarro = "";
            $gasesMoto = "";
        }
        //------------------------------------------------------------------------------Luces
        $luces = $data['luces']->operario . ";" .
                $data['luces']->documento . ";" .
                $data['luces']->valor_baja_derecha_1 . ";" .
                $data['luces']->valor_baja_derecha_2 . ";" .
                $data['luces']->valor_baja_derecha_3 . ";" .
                substr($data['luces']->simultaneaBaja, 0, 1) . ";" .
                $data['luces']->valor_baja_izquierda_1 . ";" .
                $data['luces']->valor_baja_izquierda_2 . ";" .
                $data['luces']->valor_baja_izquierda_3 . ";" .
                substr($data['luces']->simultaneaBaja, 0, 1) . ";" .
                $data['luces']->inclinacion_baja_derecha_1 . ";" .
                $data['luces']->inclinacion_baja_derecha_2 . ";" .
                $data['luces']->inclinacion_baja_derecha_3 . ";" .
                $data['luces']->inclinacion_baja_izquierda_1 . ";" .
                $data['luces']->inclinacion_baja_izquierda_2 . ";" .
                $data['luces']->inclinacion_baja_izquierda_3 . ";" .
                $data['luces']->intensidad_total . ";" .
                $data['luces']->valor_alta_derecha_1 . ";" .
                $data['luces']->valor_alta_derecha_2 . ";" .
                $data['luces']->valor_alta_derecha_3 . ";" .
                substr($data['luces']->simultaneaAlta, 0, 1) . ";" .
                $data['luces']->valor_alta_izquierda_1 . ";" .
                $data['luces']->valor_alta_izquierda_2 . ";" .
                $data['luces']->valor_alta_izquierda_3 . ";" .
                substr($data['luces']->simultaneaAlta, 0, 1) . ";" .
                $data['luces']->valor_antiniebla_derecha_1 . ";" .
                $data['luces']->valor_antiniebla_derecha_2 . ";" .
                $data['luces']->valor_antiniebla_derecha_3 . ";" .
                substr($data['luces']->simultaneaAntiniebla, 0, 1) . ";" .
                $data['luces']->valor_antiniebla_izquierda_1 . ";" .
                $data['luces']->valor_antiniebla_izquierda_2 . ";" .
                $data['luces']->valor_antiniebla_izquierda_3 . ";" .
                substr($data['luces']->simultaneaAntiniebla, 0, 1);
        $luces = str_replace(".", ",", str_replace("*", "", $luces));
        //------------------------------------------------------------------------------FAS
        $fas = $data['frenos']->operario . ";" .
                $data['frenos']->documento . ";" .
                $data['vehiculo']->numejes . ";" .
                $data['frenos']->eficacia_total . ";" .
                $data['frenos']->eficacia_auxiliar . ";" .
                $data['frenos']->desequilibrio_1 . ";" .
                $data['frenos']->desequilibrio_2 . ";" .
                $data['frenos']->desequilibrio_3 . ";" .
                $data['frenos']->desequilibrio_4 . ";" .
                $data['frenos']->desequilibrio_5 . ";" .
                '' . ";" .
                $data['frenos']->freno_1_izquierdo . ";" .
                $data['frenos']->freno_2_izquierdo . ";" .
                $data['frenos']->freno_3_izquierdo . ";" .
                $data['frenos']->freno_4_izquierdo . ";" .
                $data['frenos']->freno_5_izquierdo . ";" .
                '' . ";" .
                $data['frenos']->freno_1_derecho . ";" .
                $data['frenos']->freno_2_derecho . ";" .
                $data['frenos']->freno_3_derecho . ";" .
                $data['frenos']->freno_4_derecho . ";" .
                $data['frenos']->freno_5_derecho . ";" .
                '' . ";" .
                $data['frenos']->peso_1_derecho . ";" .
                $data['frenos']->peso_2_derecho . ";" .
                $data['frenos']->peso_3_derecho . ";" .
                $data['frenos']->peso_4_derecho . ";" .
                $data['frenos']->peso_5_derecho . ";" .
                '' . ";" .
                $data['frenos']->peso_1_izquierdo . ";" .
                $data['frenos']->peso_2_izquierdo . ";" .
                $data['frenos']->peso_3_izquierdo . ";" .
                $data['frenos']->peso_4_izquierdo . ";" .
                $data['frenos']->peso_5_izquierdo . ";" .
                '' . ";" .
                $data['alineacion']->alineacion_1 . ";" .
                $data['alineacion']->alineacion_2 . ";" .
                $data['alineacion']->alineacion_3 . ";" .
                $data['alineacion']->alineacion_4 . ";" .
                $data['alineacion']->alineacion_5 . ";" .
                '' . ";" .
                $data['suspension']->delantera_izquierda . ";" .
                $data['suspension']->trasera_izquierda . ";" .
                $data['suspension']->delantera_derecha . ";" .
                $data['suspension']->trasera_derecha . ";" .
                $data['frenos']->sum_freno_aux_derecho . ";" .
                $data['frenos']->sum_peso_derecho . ";" .
                $data['frenos']->sum_freno_aux_izquierdo . ";" .
                $data['frenos']->sum_peso_izquierdo;
        $fas = str_replace(".", ",", str_replace("*", "", $fas));
        //------------------------------------------------------------------------------Sensorial
        $defectos = "";
        if (count($data['defectosMecanizadosA']) > 0) {
            foreach ($data['defectosMecanizadosA'] as $def) {
                $defectos = $defectos . $def->codigo . "_";
            }
        }
        if (count($data['defectosMecanizadosB']) > 0) {
            foreach ($data['defectosMecanizadosB'] as $def) {
                $defectos = $defectos . $def->codigo . "_";
            }
        }
        if (count($data['defectosSensorialesA']) > 0) {
            foreach ($data['defectosSensorialesA'] as $def) {
                $defectos = $defectos . $def->codigo . "_";
            }
        }
        if (count($data['defectosSensorialesB']) > 0) {
            foreach ($data['defectosSensorialesB'] as $def) {
                $defectos = $defectos . $def->codigo . "_";
            }
        }
        if (count($data['defectosEnsenanzaA']) > 0) {
            foreach ($data['defectosEnsenanzaA'] as $def) {
                $defectos = $defectos . $def->codigo . "_";
            }
        }
        if (count($data['defectosEnsenanzaB']) > 0) {
            foreach ($data['defectosEnsenanzaB'] as $def) {
                $defectos = $defectos . $def->codigo . "_";
            }
        }

        if (strlen($defectos) > 0) {
            $defectos = substr($defectos, 0, strlen($defectos) - 1);
        }

        $sensorial = $data['sensorial']->operario . ";" .
                $data['sensorial']->documento . ";" .
                $defectos;
        //------------------------------------------------------------------------------Taximetro
        $taximetro = $data['taximetro']->operario . ";" .
                $data['taximetro']->documento . ";" .
                $data['taximetro']->aplicaTaximetro . ";" .
                $data['taximetro']->tieneTaximetro . ";" .
                $data['taximetro']->taximetroVisible . ";" .
                $data['taximetro']->r_llanta . ";" .
                $data['taximetro']->distancia . ";" .
                $data['taximetro']->tiempo;
        $taximetro = str_replace(".", ",", str_replace("*", "", $taximetro));
        //------------------------------------------------------------------------------Observaciones
        $observaciones = '';
        if (count($data['observaciones']) > 0) {
            foreach ($data['observaciones'] as $o) {
                $observaciones = $observaciones . "$o->codigo: $o->descripcion" . "_";
            }
        }
        //------------------------------------------------------------------------------Certificado
        $certificado = $data['fur_aso'] . ";" .
                $this->idCdaRUNT;
        //        $certificado = $data['numero_sustrato'] . ";" .
//                $data['numero_consecutivo'] . ";" .
//                $data['fur_aso'] . ";" .
//                $this->idCdaRUNT;
//------------------------------------------------------------------------------Estructura de llantas
        $llantas = $data['sensorial']->operario . ";" .
                $data['sensorial']->documento . ";" .
                $data['labrado']->eje1_derecho . ";" .
                $data['labrado']->eje2_derecho . ";" .
                $data['labrado']->eje3_derecho . ";" .
                $data['labrado']->eje4_derecho . ";" .
                $data['labrado']->eje5_derecho . ";" .
                $data['labrado']->eje1_izquierdo . ";" .
                $data['labrado']->eje2_izquierdo . ";" .
                $data['labrado']->eje3_izquierdo . ";" .
                $data['labrado']->eje4_izquierdo . ";" .
                $data['labrado']->eje5_izquierdo . ";" .
                $data['labrado']->eje2_derecho_interior . ";" .
                $data['labrado']->eje3_derecho_interior . ";" .
                $data['labrado']->eje4_derecho_interior . ";" .
                $data['labrado']->eje5_derecho_interior . ";" .
                $data['labrado']->eje2_izquierdo_interior . ";" .
                $data['labrado']->eje3_izquierdo_interior . ";" .
                $data['labrado']->eje4_izquierdo_interior . ";" .
                $data['labrado']->eje5_izquierdo_interior . ";" .
                $data['labrado']->repuesto . ";" .
                $data['labrado']->repuesto2 . ";" .
                $this->llanta_1_D . ";" .
                $this->llanta_2_DE . ";" .
                $this->llanta_3_DE . ";" .
                $this->llanta_4_DE . ";" .
                $this->llanta_5_DE . ";" .
                $this->llanta_1_I . ";" .
                $this->llanta_2_IE . ";" .
                $this->llanta_3_IE . ";" .
                $this->llanta_4_IE . ";" .
                $this->llanta_5_IE . ";" .
                $this->llanta_2_DI . ";" .
                $this->llanta_3_DI . ";" .
                $this->llanta_4_DI . ";" .
                $this->llanta_5_DI . ";" .
                $this->llanta_2_II . ";" .
                $this->llanta_3_II . ";" .
                $this->llanta_4_II . ";" .
                $this->llanta_5_II . ";" .
                $this->llanta_R . ";" .
                $this->llanta_R2;

        $llantas = str_replace(".", ",", str_replace("*", "", $llantas));
        //------------------------------------------------------------------------------Máquinas
        $luxometro = "";
        $opacimetro = "";
        $analizador = "";
        $camara = "";
        $taximetroMaq = "";
        $frenometro = "";
        $suspension = "";
        $alineador = "";
        $termohigrometro = "";
        $profundimetro = "";
        $captador = "";
        $pierey = "";
        $elevador = "";
        $detector = "";
        $sensorRPM = "";
        $sondaTMP = "";

        if ($data["maquinas"]->nombreLuxometro !== '') {
            $maq = explode("$", $data["maquinas"]->nombreLuxometro);
            $luxometro = <<<EOF
                {"nombre": "$maq[0]","marca": "$maq[1]","noserie": "$maq[2]",
                "pef": "$maq[4]","ltoe": "$maq[5]","NoSerieBench": "$maq[6]",
                "Esperiferico": "$maq[7]","Prueba": "2"},
EOF;
        }
        if ($data["maquinas"]->nombreOpacimetro !== '') {
            $maq = explode("$", $data["maquinas"]->nombreOpacimetro);
            $opacimetro = <<<EOF
                {"nombre": "$maq[0]","marca": "$maq[1]","noserie": "$maq[2]",
                "pef": "$maq[4]","ltoe": "$maq[5]","NoSerieBench": "$maq[6]",
                "Esperiferico": "$maq[7]","Prueba": "1"},
EOF;
        }
        if ($data["maquinas"]->nombreGases !== '') {
            $maq = explode("$", $data["maquinas"]->nombreGases);
            $analizador = <<<EOF
                {"nombre": "$maq[0]","marca": "$maq[1]","noserie": "$maq[2]",
                "pef": "$maq[4]","ltoe": "$maq[5]","NoSerieBench": "$maq[6]",
                "Esperiferico": "$maq[7]","Prueba": "1"},
EOF;
        }
        if ($data["maquinas"]->nombreFotos !== '') {
            $maq = explode("$", $data["maquinas"]->nombreFotos);
            $camara = <<<EOF
                {"nombre": "$maq[0]","marca": "$maq[1]","noserie": "$maq[2]",
                 "pef": "$maq[4]","ltoe": "$maq[5]","NoSerieBench": "$maq[6]",
                "Esperiferico": "$maq[7]","Prueba": "4"},
EOF;
        }
        if ($data["maquinas"]->nombreTaximetro !== '') {
            $maq = explode("$", $data["maquinas"]->nombreTaximetro);
            $taximetroMaq = <<<EOF
                {"nombre": "$maq[0]","marca": "$maq[1]","noserie": "$maq[2]",
                 "pef": "$maq[4]","ltoe": "$maq[5]","NoSerieBench": "$maq[6]",
                "Esperiferico": "$maq[7]","Prueba": "5"},
EOF;
        }
        if ($data["maquinas"]->nombreFrenos !== '') {
            $maq = explode("$", $data["maquinas"]->nombreFrenos);
            $frenometro = <<<EOF
                {"nombre": "$maq[0]","marca": "$maq[1]","noserie": "$maq[2]",
                 "pef": "$maq[4]","ltoe": "$maq[5]","NoSerieBench": "$maq[6]",
                "Esperiferico": "$maq[7]","Prueba": "6"},
EOF;
        }
        if ($data["maquinas"]->nombreSuspension !== '') {
            $maq = explode("$", $data["maquinas"]->nombreSuspension);
            $suspension = <<<EOF
                {"nombre": "$maq[0]","marca": "$maq[1]","noserie": "$maq[2]",
                 "pef": "$maq[4]","ltoe": "$maq[5]","NoSerieBench": "$maq[6]",
                "Esperiferico": "$maq[7]","Prueba": "8"},
EOF;
        }
        if ($data["maquinas"]->nombreAlineador !== '') {
            $maq = explode("$", $data["maquinas"]->nombreAlineador);
            $alineador = <<<EOF
                {"nombre": "$maq[0]","marca": "$maq[1]","noserie": "$maq[2]",
                 "pef": "$maq[4]","ltoe": "$maq[5]","NoSerieBench": "$maq[6]",
                "Esperiferico": "$maq[7]","Prueba": "7"},
EOF;
        }
        if ($data["maquinas"]->nombreTermohigrometro !== '') {
            $maq = explode("$", $data["maquinas"]->nombreTermohigrometro);
            $termohigrometro = <<<EOF
                {"nombre": "$maq[0]","marca": "$maq[1]","noserie": "$maq[2]",
                 "pef": "$maq[4]","ltoe": "$maq[5]","NoSerieBench": "$maq[6]",
                "Esperiferico": "$maq[7]","Prueba": "1"},
EOF;
        }
        if ($data["maquinas"]->nombreProfundimetro !== '') {
            $maq = explode("$", $data["maquinas"]->nombreProfundimetro);
            $profundimetro = <<<EOF
                {"nombre": "$maq[0]","marca": "$maq[1]","noserie": "$maq[2]",
                 "pef": "$maq[4]","ltoe": "$maq[5]","NoSerieBench": "$maq[6]",
                "Esperiferico": "$maq[7]","Prueba": "8"},
EOF;
        }
        if ($data["maquinas"]->nombreCaptador !== '') {
            $maq = explode("$", $data["maquinas"]->nombreCaptador);
            $captador = <<<EOF
                {"nombre": "$maq[0]","marca": "$maq[1]","noserie": "$maq[2]",
                 "pef": "$maq[4]","ltoe": "$maq[5]","NoSerieBench": "$maq[6]",
                "Esperiferico": "$maq[7]","Prueba": "1"},
EOF;
        }
        if ($data["maquinas"]->nombreDetector !== '') {
            $maq = explode("$", $data["maquinas"]->nombreDetector);
            $detector = <<<EOF
                {"nombre": "$maq[0]","marca": "$maq[1]","noserie": "$maq[2]",
                 "pef": "$maq[4]","ltoe": "$maq[5]","NoSerieBench": "$maq[6]",
                "Esperiferico": "$maq[7]","Prueba": "8"},
EOF;
        }
        if ($data["maquinas"]->nombreElevador !== '') {
            $maq = explode("$", $data["maquinas"]->nombreElevador);
            $elevador = <<<EOF
                {"nombre": "$maq[0]","marca": "$maq[1]","noserie": "$maq[2]",
                 "pef": "$maq[4]","ltoe": "$maq[5]","NoSerieBench": "$maq[6]",
                "Esperiferico": "$maq[7]","Prueba": "8"},
EOF;
        }
        if ($data["maquinas"]->nombrePiederey !== '') {
            $maq = explode("$", $data["maquinas"]->nombrePiederey);
            $pierey = <<<EOF
                {"nombre": "$maq[0]","marca": "$maq[1]","noserie": "$maq[2]",
                 "pef": "$maq[4]","ltoe": "$maq[5]","NoSerieBench": "$maq[6]",
                "Esperiferico": "$maq[7]","Prueba": "8"},
EOF;
        }
        if ($data["maquinas"]->nombreSensorRPM !== '') {
            $maq = explode("$", $data["maquinas"]->nombreSensorRPM);
            $sensorRPM = <<<EOF
                {"nombre": "$maq[0]","marca": "$maq[1]","noserie": "$maq[2]",
                 "pef": "$maq[4]","ltoe": "$maq[5]","NoSerieBench": "$maq[6]",
                "Esperiferico": "$maq[7]","Prueba": "8"},
EOF;
        }
        if ($data["maquinas"]->nombreSondaTMP !== '') {
            $maq = explode("$", $data["maquinas"]->nombreSondaTMP);
            $sondaTMP = <<<EOF
                {"nombre": "$maq[0]","marca": "$maq[1]","noserie": "$maq[2]",
                 "pef": "$maq[4]","ltoe": "$maq[5]","NoSerieBench": "$maq[6]",
                "Esperiferico": "$maq[7]","Prueba": "8"},
EOF;
        }

        $maquinas = <<<EOF
{"Equipos": [$luxometro$opacimetro$analizador$camara$taximetroMaq$frenometro$suspension$alineador$termohigrometro$profundimetro$captador$pierey$elevador$detector$sensorRPM$sondaTMP]}                
EOF;
        $maquinas = str_replace(",]}", "]}", $maquinas);

        //------------------------------------------------------------------------------Software
        $software = $data["software"];
        //------------------------------------------------------------------------------Jefe linea
        $jefeLinea = $data['hojatrabajo']->jefelinea . ";" . $this->Musuarios->getXnombreID($data['hojatrabajo']->jefelinea);
        //------------------------------------------------------------------------------Numero fur
        $taxonomia = //
                $IdProveedor . "|" .
                $propietario . "|" .
                $vehiculo . "|" .
                $fotos . "|" .
                $diesel . $gasesCarro . $gasesMoto .
                $luces . "|" .
                $fas . "|" .
                $sensorial . "|" .
                $taximetro . "|" .
                $observaciones . "|" .
                $certificado . "|" .
                $llantas . "|" .
                $maquinas . "|" .
                $software . "|" .
                $jefeLinea . "|" .
                $data['fur_aso'] . ";" . trim(date_format(date_create($data['fechafur']), 'Y-m-d H:i:s'));

        if ($data['ocasion'] === 'true') {
            $ocasion = '2';
        } else {
            $ocasion = '1';
        }
        $url = 'http://' . $this->ipSicov . '/sicov.asmx?WSDL';
        $datos_conexion = explode(":", $this->ipSicov);
        if ($data['sicovModoAlternativo'] == '1') {
            $url = 'http://' . $this->ipSicovAlternativo . '/sicov.asmx?WSDL';
            $datos_conexion = explode(":", $this->ipSicovAlternativo);
        }
        $host = $datos_conexion[0];
        if (count($datos_conexion) > 1) {
            $port = $datos_conexion[1];
        } else {
            $port = 80;
        }
        $waitTimeoutInSeconds = 2;
        error_reporting(0);
        $this->sistemaOperativo = sistemaoperativo();
        if ($fp = fsockopen($host, $port, $errCode, $errStr, $waitTimeoutInSeconds)) {
            $client = new SoapClient($url);
            $datos['idhojapruebas'] = $data['idhojapruebas'];
            $msg = '';
            $encrptopenssl = new Opensslencryptdecrypt();
            if (!$this->segundo_envio) {
                file_put_contents('encdes/salidaFUR.txt', "");
                file_put_contents('encdes/entradaFUR.txt', "");
                $tipo = 'f';
                file_put_contents('encdes/entradaFUR.txt', $this->formato_texto($taxonomia));
                if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
                    exec('encdes/openFUR.bat');
                } else {
                    exec('C:/Apache24/htdocs/et/encdes/openFUR.bat');
                }
                usleep(500);
                $fur_ = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', file_get_contents('encdes/salidaFUR.txt'));
                $fur = array(
                    'cadena' => $fur_
                );
                $respuesta = $client->EnviarFurSicov($fur);
                $respuesta = $respuesta->EnviarFurSicovResult;
                //                var_dump($fur);
                if ($respuesta->codRespuesta == '1') {
                    $datos['sicov'] = '1';
                    $estado = 'exito';
                    $msg = 'Operación Exitosa';
                    if ($aprobado !== '1') {
                        $datos['estadototal'] = '3';
                    } else {
                        $datos['estadototal'] = '2';
                    }
                    $this->Mhojatrabajo->update_x($datos);
                } else {
                    $msg = 'Operación Fallida';
                    $estado = 'error';
                }
            } else {
                $extranjero = "S";
                if ($data['pais']->nombre == 'COLOMBIA')
                    $extranjero = "N";
                $tipo = 'r';
                $runt = array(
                    'nombreEmpleado' => $data['vehiculo']->usuario_registro,
                    'numeroIdentificacion' => $data['vehiculo']->documento_usuario,
                    'placa' => $data['vehiculo']->numero_placa,
                    'extranjero' => $extranjero,
                    'consecutivoRUNT' => substr($data['numero_consecutivo'], 1),
                    'IdRunt' => $this->idCdaRUNT,
                    'direccionIpEquipo' => $_SERVER['REMOTE_ADDR']
                );
                $respuesta = $client->EnviarRuntSicov($runt);
                $respuesta = $respuesta->EnviarRuntSicovResult;
                if ($respuesta->codRespuesta == '1') {
                    $datos['sicov'] = '1';
                    $estado = 'exito';
                    $msg = 'Operación Exitosa';
                    if ($aprobado !== '1') {
                        $datos['estadototal'] = '7';
                    } else {
                        $datos['estadototal'] = '4';
                    }
                    $this->Mhojatrabajo->update_x($datos);
                } else {
                    $msg = 'Operación Fallida';
                    $estado = 'error';
                }
            }
            $mensaje = $msg . '|' . $respuesta->codRespuesta . '|' . $ocasion . '|' . $estado . '|' . $respuesta->msjRespuesta;
            $this->insertarEvento($data['vehiculo']->numero_placa, $this->formato_texto($taxonomia), $tipo, '1', $mensaje);
        } else {
            $mensaje = 'Operación fallida|0|' . $ocasion . '|error|Sin conexión a sicov';
            $this->insertarEvento($data['vehiculo']->numero_placa, '', 'f', '1', $mensaje);
        }
        if ($fp) {
            fclose($fp);
        }
        echo $mensaje;
    }

    private function formato_texto($cadena) {
        $no_permitidas = array("Ñ", "ñ", "á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹", "'", "");
        $permitidas = array("N", "n", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E", "", "");
        $texto = str_replace($no_permitidas, $permitidas, $cadena);
        return $texto;
    }

    private function rdnr($valor) {
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

    //--------------------------------------------------------------------------PARAMETROS 
    //--------------------------------------------------------------------------Opacidad
    function max_opacidad($modelo) {
        $flag = 0;
        $mod = intval($modelo);
        if ($mod >= 1998) {
            $flag = 35;
        } else if ($mod < 1998 && $mod >= 1985) {
            $flag = 40;
        } else if ($mod < 1985 && $mod >= 1971) {
            $flag = 45;
        } else if ($mod < 1971) {
            $flag = 50;
        }
        return $flag;
    }

    //--------------------------------------------------------------------------Gases
    function getCoFlag($modelo, $tipoVeh) {
        $flag = 0;
        $mod = intval($modelo);
        if ($tipoVeh === "3") {
            $flag = 4.5;
        } else {
            if ($mod <= 1970) {
                $flag = 5.0;
            } else if ($mod > 1970 && $mod <= 1984) {
                $flag = 4.0;
            } else if ($mod > 1984 && $mod <= 1997) {
                $flag = 3.0;
            } else if ($mod > 1997) {
                $flag = 1.0;
            }
        }
        return $flag;
    }

    function getCo2Flag($tipoVeh) {
        $flag = 0;
        if ($tipoVeh === "3") {
            $flag = 0;
        } else {
            $flag = 7.0;
        }
        return $flag;
    }

    function getO2Flag($tipoVeh) {
        $flag = 0;
        if ($tipoVeh === "3") {
            $flag = 20.9;
        } else {
            $flag = 5.0;
        }
        return $flag;
    }

    function getHcFlag($modelo, $tipoVeh, $tiempos) {
        $flag = 0;
        $mod = intval($modelo);
        if ($tipoVeh === "3") {
            if ($tiempos == "2") {
                if ($mod > 2009) {
                    $flag = 2000;
                } else {
                    $flag = 10000;
                }
            } else {
                $flag = 2000;
            }
        } else {
            if ($mod <= 1970) {
                $flag = 800;
            } else if ($mod > 1970 && $mod <= 1984) {
                $flag = 650;
            } else if ($mod > 1984 && $mod <= 1997) {
                $flag = 400;
            } else if ($mod > 1997) {
                $flag = 200;
            }
        }
        return $flag;
    }

    //--------------------------------------------------------------------------Frenos
    function min_des_B() {
        return 20;
    }

    function max_des_B() {
        return 30;
    }

    function min_des_A() {
        return 30;
    }

    function max_des_A() {
        return 40;
    }

    function efi_min($tipoVeh, $tipoEfi) {
        if ($tipoVeh === "3") {
            if ($tipoEfi === "total") {
                return 30;
            } else {
                return 18;
            }
        } else {
            if ($tipoEfi === "total") {
                return 50;
            } else {
                return 18;
            }
        }
    }

    //--------------------------------------------------------------------------Luces
    function getRango_min_inc() {
        return 0.5;
    }

    function getRango_max_inc() {
        return 3.5;
    }

    function getMin_luz_baja() {
        return 2.5;
    }

    function getMax_luz_total() {
        return 225;
    }

    //--------------------------------------------------------------------------Suspension
    function min() {
        return 40;
    }

    //--------------------------------------------------------------------------Taxímetro
    function minmaxTax() {
        return 2;
    }

    //--------------------------------------------------------------------------Alineación
    function minmaxAli() {
        return 10;
    }

}
