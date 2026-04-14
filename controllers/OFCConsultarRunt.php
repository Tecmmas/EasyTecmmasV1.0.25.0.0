<?php

header("Access-Control-Allow-Origin: *");
ini_set('memory_limit', '-1');
set_time_limit(0);

class OFCConsultarRunt extends CI_Controller
{

    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('OFCConsultarRuntModel');
        $this->load->model('GeneralModel');
        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
    }

    public function Index()
    {
        if ($this->session->userdata('IdUsuario')) {
            $nombreSicov = $this->GeneralModel->getSicovName();
            $data['nombreSicov'] = $nombreSicov;
            if ($nombreSicov == "CI2") {
                $this->ValidarTablas();
                $this->CrearClases();
            }
            $this->load->view("OFCConsultarRuntView", $data);
        } else {
            redirect('Cindex');
        }
    }

    public function Consultar()
    {
        $placa = $this->input->post('placa');
        $this->setConf();
        if (strtoupper($this->nombreSicov) == "CI2") {
            $datoSicov = $this->GeneralModel->getUserSicov();
            //            $Usuario = $datoSicov['Usuario'];
            //            $Clave = $datoSicov['Clave'];
            $client = new SoapClient('http://192.168.248.90/ci2_cda_ws/sincrofur.asmx?wsdl');
            $param = array(
                'dato' => array(
                    'Usuario' => $this->usuarioSicov,
                    'Clave' => $this->claveSicov,
                    'Placa' => $placa
                )
            );
            $respuesta = $client->ConsultaRunt($param);
            $respuesta->sicov = 'CI2';
            echo json_encode($respuesta);
        } else if (strtoupper($this->nombreSicov) == "INDRA") {
            $extranjero = 'N';
            $ip = $this->ipSicov;
            $url = 'http://' . $ip . '/sicov.asmx?WSDL';
            $client = new SoapClient($url);
            $runt = array(
                'placa' => $placa,
                'extranjero' => $extranjero
            );
            $respuesta = $client->getInfoVehiculo($runt);
            $respuesta = $respuesta->getInfoVehiculoResult;
            $respuesta->sicov = 'INDRA';
            echo json_encode($respuesta);
        } else {
            echo 'FALSE';
        }
    }

    public function ConsultarXCi2()
    {
        $Usuario = $this->input->post('usuario');
        $Clave = $this->input->post('clave');
        $placa = $this->input->post('placa');
        $client = new SoapClient('http://192.168.248.90/ci2_cda_ws/sincrofur.asmx?wsdl');
        $param = array(
            'dato' => array(
                'Usuario' => $Usuario,
                'Clave' => $Clave,
                'Placa' => $placa
            )
        );
        $respuesta = $client->ConsultaRunt($param);
        echo json_encode($respuesta);
    }

    public function ConsultarXIndra()
    {
        $placa = $this->input->post('placa');
        $extranjero = $this->input->post('extranjero');
        $ip = $this->input->post('ip');
        $url = 'http://' . $ip . '/sicov.asmx?WSDL';
        $client = new SoapClient($url);
        $runt = array(
            'placa' => $placa,
            'extranjero' => $extranjero
        );
        $respuesta = $client->getInfoVehiculo($runt);
        $respuesta = $respuesta->getInfoVehiculoResult;
        echo json_encode($respuesta);
    }

    private function ValidarTablas()
    {
        $this->OFCConsultarRuntModel->CrearTablaMarca();
        $this->OFCConsultarRuntModel->CrearTablaLinea();
        $this->OFCConsultarRuntModel->CrearTablaColor();
        $this->OFCConsultarRuntModel->CrearRegistroRunt();
    }

    private function CrearClases()
    {
        $clase['idclase'] = 30;
        $clase['nombre'] = 'CUATRIMOTO';
        $this->OFCConsultarRuntModel->InsertarClase($clase);
        $clase['idclase'] = 163;
        $clase['nombre'] = 'CICLOMOTOR';
        $this->OFCConsultarRuntModel->InsertarClase($clase);
        $clase['idclase'] = 164;
        $clase['nombre'] = 'TRICIMOTO';
        $this->OFCConsultarRuntModel->InsertarClase($clase);
        $clase['idclase'] = 165;
        $clase['nombre'] = 'CUADRICICLO';
        $this->OFCConsultarRuntModel->InsertarClase($clase);
    }

    private function CrearAseguradora($nombre)
    {
        $aseguradora['nombre'] = $nombre;
        $aseguradora['numero_identificacion'] = '0';
        $this->OFCConsultarRuntModel->InsertarAseguradora($aseguradora);
    }

    public function IngresarDatosVehiculo()
    {

        $color['idcolorRUNT'] = $this->input->post('idcolorRUNT');
        $color['nombre'] = $this->input->post('nombreColor');
        $this->OFCConsultarRuntModel->InsertarColorRunt($color);

        $color2['idcolor'] = $this->input->post('idcolorRUNT');
        $color2['nombre'] = $this->input->post('nombreColor');
        $this->OFCConsultarRuntModel->InsertarColorLocal($color2);

        $marca['idmarcaRUNT'] = $this->input->post('idmarcaRUNT');
        $marca['nombre'] = $this->input->post('nombreMarca');
        $this->OFCConsultarRuntModel->InsertarMarcaRunt($marca);

        $marca2['idmarca'] = $this->input->post('idmarcaRUNT');
        $marca2['nombre'] = $this->input->post('nombreMarca');
        $this->OFCConsultarRuntModel->InsertarMarcaLocal($marca2);

        $linea['idmarcaRUNT'] = $this->input->post('idmarcaRUNT');
        $linea['codigo'] = $this->input->post('codigoLinea');
        $linea['nombre'] = $this->input->post('nombreLinea');
        $this->OFCConsultarRuntModel->InsertarLineaRunt($linea);

        $linea2['idmarca'] = $this->input->post('idmarcaRUNT');
        $linea2['idmintrans'] = $this->input->post('codigoLinea');
        $linea2['idrunt'] = $this->input->post('codigoLinea');
        $linea2['nombre'] = $this->input->post('nombreLinea');
        $this->OFCConsultarRuntModel->InsertarLineaLocal($linea2);

        $r = $this->OFCConsultarRuntModel->BuscarLinea($linea['idmarcaRUNT'], $linea['codigo']);
        $rLinea = $r->result();
        $vehiculo['numero_placa'] = $this->input->post('noPlaca');
        $vehiculo['numero_serie'] = $this->input->post('noChasis');
        $vehiculo['idlinea'] = $rLinea[0]->idlineaRunt;
        $vehiculo['idservicio'] = $this->PrepararServicio($this->input->post('idTipoServicio'));
        $vehiculo['idcolor'] = $color['idcolorRUNT'];
        $vehiculo['ano_modelo'] = $this->input->post('modelo');
        $vehiculo['cilindraje'] = $this->input->post('cilindraje');
        $vehiculo['idtipocombustible'] = $this->PrepararCombustible($this->input->post('idTipoCombustible'));
        $vehiculo['idclase'] = $this->PrepararClase($this->input->post('idClaseVehiculo'));
        $vehiculo['numero_motor'] = $this->input->post('noMotor');
        $vehiculo['numsillas'] = $this->input->post('capacidadPasajerosSentados');
        $vehiculo['tipo_vehiculo'] = $this->prepararTipo_Vehiculo($vehiculo['idclase']);
        $vehiculo['fecha_matricula'] = $this->formatearFecha($this->input->post('fechaMatricula'));
        $vehiculo['numejes'] = '2';
        $vehiculo['usuario'] = $this->session->userdata('IdUsuario');
        $vehiculo['numero_vin'] = $this->input->post('noVIN');
        $vehiculo['taximetro'] = '0';
        $vehiculo['cilindros'] = '1';
        $vehiculo['tiempos'] = '4';
        $vehiculo['idpais'] = '90';
        $vehiculo['polarizado'] = '0';
        if ($vehiculo['tipo_vehiculo'] == '3') {
            $vehiculo['numero_llantas'] = '2';
        } else {
            $vehiculo['numero_llantas'] = '4';
        }
        $vehiculo['numero_exostos'] = '1';
        if ($this->input->post('blindado') == 'SI') {
            $vehiculo['blindaje'] = '1';
        } else {
            $vehiculo['blindaje'] = '0';
        }
        if ($this->input->post('esEnsenanza') == 'SI') {
            $vehiculo['ensenanza'] = '1';
        } else {
            $vehiculo['ensenanza'] = '0';
        }
        $vehiculo['registrorunt'] = '1';
        $this->OFCConsultarRuntModel->InsertarVehiculo($vehiculo);
    }

    public function IngresarDatosSoat()
    {
        $this->CrearAseguradora($this->input->post('entidadExpideSoat'));
        $r = $this->OFCConsultarRuntModel->BuscarAseguradora($this->input->post('entidadExpideSoat'));
        $rAseguradora = $r->result();
        $soat['idaseguradora'] = $rAseguradora[0]->idaseguradora;
        $soat['numero_soat'] = $this->input->post('noPoliza');
        $soat['fecha_expedicion'] = $this->formatearFecha($this->input->post('fechaExpedicion'));
        $soat['fecha_vencimiento'] = $this->formatearFecha($this->input->post('fechaVencimiento'));
        $this->OFCConsultarRuntModel->InsertarSoat($soat);
        $r = $this->OFCConsultarRuntModel->BuscarSoat($soat['idaseguradora'], $soat['numero_soat']);
        $rSoat = $r->result();
        $vehiculo['idsoat'] = $rSoat[0]->idsoat;
        $vehiculo['numero_placa'] = $this->input->post('numero_placa');
        $this->OFCConsultarRuntModel->InsertarVehiculo($vehiculo);
    }

    public function PrepararServicio($servicio)
    {
        switch ($servicio) {
            case 1:
                $servicio = '3';
                break;
            case 3:
                $servicio = '4';
                break;
            case 4:
                $servicio = '1';
                break;
        }
        return $servicio;
    }

    private function PrepararCombustible($combustible)
    {
        switch ($combustible) {
            case 1:
                $combustible = '2';
                break;
            case 2:
                $combustible = '3';
                break;
            case 3:
                $combustible = '1';
                break;
        }
        return $combustible;
    }

    private function PrepararClase($clase)
    {
        switch ($clase) {
            case 42:
                $clase = '9';
                break;
            case 41:
                $clase = '13';
                break;
            case 24:
                $clase = '15';
                break;
            case 43:
                $clase = '16';
                break;
            case 19:
                $clase = '30';
                break;
        }
        return $clase;
    }

    private function prepararTipo_Vehiculo($c)
    {
        if ($c == '1' || $c == '5' || $c == '6' || $c == '16') {
            $tipo_vehiculo = '1';
        } elseif ($c == '10' || $c == '14' || $c == '17' || $c == '165' || $c == '164' || $c == '163' || $c == '30') {
            $tipo_vehiculo = '3';
        } else {
            $tipo_vehiculo = '2';
        }
        return $tipo_vehiculo;
    }

    private function formatearFecha($fecha)
    {
        $f = explode('/', $fecha);
        $dia = $f[0];
        $mes = $f[1];
        $ano = $f[2];
        return "$ano-$mes-$dia";
    }

    var $nombreSicov;
    var $ipSicov;
    var $sicovModoAlternativo;
    var $ipSicovAlternativo;
    var $usuarioSicov = "";
    var $claveSicov = "";

    private function setConf()
    {
        $conf = @file_get_contents("system/oficina.json");
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt($conf, true);
        $dat = json_decode($json, true);
        foreach ($dat as $d) {
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
        }
    }
}
