<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
ini_set('memory_limit', '-1');

class Cvehiculo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("dominio/Mvehiculo");
        $this->load->model("dominio/Mpropietario");
        $this->load->model("dominio/Mdepartamento");
        $this->load->model("dominio/Mciudad");
        $this->load->model("dominio/Mclase");
        $this->load->model("dominio/Mpais");
        $this->load->model("dominio/Mpre_atributo");
        $this->load->library('Opensslencryptdecrypt');
    }

    public function index() {
        if ($this->session->userdata('IdUsuario') == '' || $this->session->userdata('IdUsuario') == '1024') {
            redirect('Cindex');
        }
        $this->setDatos();
        $encrptopenssl = New Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/oficina.json', true), true);
        $ofc = json_decode($json, true);
        foreach ($ofc as $d) {
            $data[$d['nombre']] = $d['valor'];
        }
        $this->load->view('oficina/vehiculo/Vvehiculo', $data);
    }

    public function buscarVehiculo() {
        $rta = $this->Mvehiculo->getXplaca($this->input->post('numero_placa'));
        $this->session->unset_userdata('numero_placa');
        if ($rta->num_rows() > 0) {
            $v = $rta->result();
            echo json_encode($v[0]);
        } else {
            echo '';
        }
    }

    public function getClases() {
        $rta = $this->Mclase->getAll();
        $clases = "";
        foreach ($rta->result() as $c) {
            $clases = $clases . "<option value='$c->idclase'>$c->nombre</option>";
        }
        echo $clases;
    }

    public function getIdClase() {
        $rta = $this->Mclase->getAll();
        $nombre = $this->input->post("nombre");
        $idclase = "1";
        foreach ($rta->result() as $c) {
            if ($nombre == $c->nombre) {
                $idclase = $c->idclase;
                break;
            }
        }
        echo $idclase;
    }

    public function getIdMarca() {
        $json1 = file_get_contents('application/libraries/marca.json', true);
        $mar = json_decode($json1, true);
        $idmarca = "1";
        foreach ($mar as $m) {
            if ($m->nombre == $this->input->post("nombre")) {
                $idmarca = $m->codigo;
                break;
            }
        }
        echo $idmarca;
    }

    public function getIdColor() {
        $json1 = file_get_contents('recursos/color.json', true);
        $col = json_decode($json1, true);
        $idcolor = "1";
        foreach ($col as $c) {
            if ($c->nombre == $this->input->post("nombre")) {
                $idcolor = $c->codigo;
                break;
            }
        }
        echo $idcolor;
    }

    public function getIdLinea() {
        $json1 = file_get_contents('application/libraries/linea.json', true);
        $lin = json_decode($json1, true);
//        var_dump($lin);
        $idlinea = "1";
        foreach ($lin as $l) {
            if ($l["codigo"] == $this->input->post("nombre") &&
                    $l["idmarca"] == $this->input->post("idmarca")) {
                $idlinea = $l["idlinea"];
                break;
            }
        }
        echo $idlinea;
    }

    public function getPaises() {
        $rta = $this->Mpais->getAll();
        $paises = "";
        foreach ($rta->result() as $c) {
            $paises = $paises . "<option value='$c->idpais'>$c->nombre</option>";
        }
        echo $paises;
    }

    public function getMarca() {
        $json1 = file_get_contents('application/libraries/marca.json', true);
        $mar = json_decode($json1, true);
        $marca = "";
        foreach ($mar as $m) {
            $codigo = $m["codigo"];
            $nombre = $m["nombre"];
            if ($codigo == $this->input->post("idmarca")) {
                $marca = "<option value='$codigo'>$nombre</option>";
                break;
            }
        }
        echo $marca;
    }

    public function getMarca_() {
        $json1 = file_get_contents('application/libraries/marca.json', true);
        $mar = json_decode($json1, true);
        echo $mar;
    }

    private function getLinea($idlinea) {
        $json = file_get_contents('application/libraries/linea.json', true);
        $lin = json_decode($json, true);
        $linea = "";
        foreach ($lin as $l) {
            if ($idlinea == $l['idlinea']) {
                $value = $l['idlinea'];
                $nombre = $l['nombre'];
                $linea = "<option value='$value'>$nombre</option>";
                break;
            }
        }
        return $linea;
    }

    private function getLineaIdmarca($idlinea) {
        $json = file_get_contents('application/libraries/linea.json', true);
        $lin = json_decode($json, true);
        $idmarca = "";

        foreach ($lin as $l) {
            if ($idlinea == $l['idlinea']) {
                $idmarca = $l['idmarca'];
                break;
            }
        }
        return $idmarca;
    }

    public function getCombustibles() {
        $json = file_get_contents('recursos/combustible.json', true);
        $lin = json_decode($json, true);
        $combustibles = "";
        foreach ($lin as $l) {
            $value = $l['codigo'];
            $nombre = $l['nombre'];
            $combustibles = $combustibles . "<option value='$value'>$nombre</option>";
        }
        echo $combustibles;
    }

    public function getServicios() {
        $json = file_get_contents('recursos/servicio.json', true);
        $lin = json_decode($json, true);
        $servicios = "";
        foreach ($lin as $l) {
            $value = $l['codigo'];
            $nombre = $l['nombre'];
            $servicios = $servicios . "<option value='$value'>$nombre</option>";
        }
        echo $servicios;
    }

    public function getMarcas() {
        $json1 = file_get_contents('application/libraries/marca.json', true);
        $mar = json_decode($json1, true);
        $marcas = "";
        foreach ($mar as $m) {
            if (strpos($m['nombre'], strtoupper($this->input->post('textomarca'))) !== FALSE) {
                $value = $m['codigo'];
                $nombre = $m['nombre'];
                $marcas = $marcas . "<tr><td><input id='$value' class='btn btn-block bot_azul' onclick='asignarMarca(this)' type='button'  style='height: 40px;padding: 5px;width:420px'   value='$nombre'  data-dismiss='modal'/><td></tr>";
            }
        }
        echo $marcas;
    }

    public function getMarcasE() {
        $json1 = file_get_contents('application/libraries/marca.json', true);
        $mar = json_decode($json1, true);
        $marcas = "";
        foreach ($mar as $m) {
            if ($m['nombre'] == strtoupper($this->input->post('textomarca'))) {
                $value = $m['codigo'];
                $nombre = $m['nombre'];
                $marcas = $marcas . "<tr><td><input id='$value' class='btn btn-block bot_azul' onclick='asignarMarca(this)' type='button'  style='height: 40px;padding: 5px;width:420px'   value='$nombre'  data-dismiss='modal'/><td></tr>";
            }
        }
        echo $marcas;
    }

    public function getLineas() {
        $json = file_get_contents('application/libraries/linea.json', true);
        $lin = json_decode($json, true);
        $lineas = "";
        foreach ($lin as $l) {
            if ($this->input->post('codigo') == $l['idmarca'] && strpos($l['nombre'], strtoupper($this->input->post('textolinea'))) !== FALSE) {
                $value = $l['idlinea'];
                $nombre = $l['nombre'];
                $lineas = $lineas . "<tr><td><input id='$value' class='btn btn-block bot_azul' onclick='asignarLinea(this)' type='button'  style='height: 40px;padding: 5px;width:420px'   value='$nombre'  data-dismiss='modal'/><td></tr>";
            }
        }
        echo $lineas;
    }

    public function getLineasE() {
        $json = file_get_contents('application/libraries/linea.json', true);
        $lin = json_decode($json, true);
        $lineas = "";
        foreach ($lin as $l) {
            if ($this->input->post('codigo') == $l['idmarca'] && $l['nombre'] == strtoupper($this->input->post('textolinea'))) {
                $value = $l['idlinea'];
                $nombre = $l['nombre'];
                $lineas = $lineas . "<tr><td><input id='$value' class='btn btn-block bot_azul' onclick='asignarLinea(this)' type='button'  style='height: 40px;padding: 5px;width:420px'   value='$nombre'  data-dismiss='modal'/><td></tr>";
            }
        }
        echo $lineas;
    }

    public function getColores() {
        $json = file_get_contents('recursos/color.json', true);
        $lin = json_decode($json, true);
        $colores = "";
        foreach ($lin as $l) {
            if (strpos($l['nombre'], strtoupper($this->input->post('textocolor'))) !== FALSE) {
                $value = $l['codigo'];
                $nombre = $l['nombre'];
                $colores = $colores . "<tr><td><input id='$value' class='btn btn-block bot_azul' onclick='asignarColor(this)' type='button'  style='height: 40px;padding: 5px;width:420px'   value='$nombre'  data-dismiss='modal'/><td></tr>";
            }
        }
        echo $colores;
    }

    public function getColoresE() {
        $json = file_get_contents('recursos/color.json', true);
        $lin = json_decode($json, true);
        $colores = "";
        foreach ($lin as $l) {
            if ($l['nombre'] == strtoupper($this->input->post('textocolor'))) {
                $value = $l['codigo'];
                $nombre = $l['nombre'];
                $colores = $colores . "<tr><td><input id='$value' class='btn btn-block bot_azul' onclick='asignarColor(this)' type='button'  style='height: 40px;padding: 5px;width:420px'   value='$nombre'  data-dismiss='modal'/><td></tr>";
            }
        }
        echo $colores;
    }

    private function getColor($idcolor) {
        $json = file_get_contents('recursos/color.json', true);
        $lin = json_decode($json, true);
        $color = "";
        foreach ($lin as $l) {
            $value = $l['codigo'];
            $nombre = $l['nombre'];
            if ($value == $idcolor) {
                $color = "<option value='$value'>$nombre</option>";
                break;
            }
        }
        return $color;
    }

    public function getCarrocerias() {
        $json = file_get_contents('recursos/carroceria.json', true);
        $lin = json_decode($json, true);
        $carrocerias = "";
        foreach ($lin as $l) {
            if (strpos($l['nombre'], strtoupper($this->input->post('textocarroceria'))) !== FALSE) {
                $value = $l['codigo'];
                $nombre = $l['nombre'];
                $carrocerias = $carrocerias . "<tr><td><input id='$value' class='btn btn-block bot_azul' onclick='asignarCarroceria(this)' type='button'  style='height: 40px;padding: 5px;width:420px'   value='$nombre'  data-dismiss='modal'/><td></tr>";
            }
        }
        echo $carrocerias;
    }

    public function getCarroceriasE() {
        $json = file_get_contents('recursos/carroceria.json', true);
        $lin = json_decode($json, true);
        $carrocerias = "";
        foreach ($lin as $l) {
            if ($l['nombre'] == strtoupper($this->input->post('textocarroceria'))) {
                $value = $l['codigo'];
                $nombre = $l['nombre'];
                $carrocerias = $carrocerias . "<tr><td><input id='$value' class='btn btn-block bot_azul' onclick='asignarCarroceria(this)' type='button'  style='height: 40px;padding: 5px;width:420px'   value='$nombre'  data-dismiss='modal'/><td></tr>";
            }
        }
        echo $carrocerias;
    }

    private function getAseguradoras() {
        $json = file_get_contents('recursos/aseguradora.json', true);
        $lin = json_decode($json, true);
        $aseguradoras = "";
        foreach ($lin as $l) {
            $value = $l['codigo'];
            $nombre = $l['nombre'];
            $aseguradoras = $aseguradoras . "<option value='$value'>$nombre</option>";
        }
        return $aseguradoras;
    }

    private function getAseguradora($idaseguradora) {
        $json = file_get_contents('recursos/aseguradora.json', true);
        $lin = json_decode($json, true);
        $aseguradora = "";
        foreach ($lin as $l) {
            $value = $l['codigo'];
            $nombre = $l['nombre'];
            if ($value == $idaseguradora) {
                $aseguradora = "<option value='$value'>$nombre</option>";
                break;
            }
        }
        return $aseguradora;
    }

    public function getTipo_Vehiculos() {
        $tipo_vehiculo = "";
        $tipo_vehiculo = $tipo_vehiculo . "<option value='1'>LIVIANO</option>";
        $tipo_vehiculo = $tipo_vehiculo . "<option value='2'>PESADO</option>";
        $tipo_vehiculo = $tipo_vehiculo . "<option value='3'>MOTO</option>";
        echo $tipo_vehiculo;
    }

    public function getNumejes() {
        $numEjes = "";
        $numEjes = $numEjes . "<option value='2'>2</option>";
        $numEjes = $numEjes . "<option value='3'>3</option>";
        $numEjes = $numEjes . "<option value='4'>4</option>";
        $numEjes = $numEjes . "<option value='5'>5</option>";
        echo $numEjes;
    }

    public function getNumllantas() {
        $numEjes = "";
        $numEjes = $numEjes . "<option value='2'>2</option>";
        $numEjes = $numEjes . "<option value='3'>3</option>";
        $numEjes = $numEjes . "<option value='4'>4</option>";
        $numEjes = $numEjes . "<option value='5'>5</option>";
        $numEjes = $numEjes . "<option value='6'>6</option>";
        $numEjes = $numEjes . "<option value='7'>7</option>";
        $numEjes = $numEjes . "<option value='8'>8</option>";
        $numEjes = $numEjes . "<option value='9'>9</option>";
        $numEjes = $numEjes . "<option value='10'>10</option>";
        $numEjes = $numEjes . "<option value='11'>11</option>";
        $numEjes = $numEjes . "<option value='12'>12</option>";
        $numEjes = $numEjes . "<option value='13'>13</option>";
        $numEjes = $numEjes . "<option value='14'>14</option>";
        $numEjes = $numEjes . "<option value='15'>15</option>";
        $numEjes = $numEjes . "<option value='16'>16</option>";
        $numEjes = $numEjes . "<option value='17'>17</option>";
        $numEjes = $numEjes . "<option value='18'>18</option>";
        echo $numEjes;
    }

    public function getTiempos() {
        $tiempos = "";
        $tiempos = $tiempos . "<option value='4'>4</option>";
        $tiempos = $tiempos . "<option value='2'>2</option>";
        echo $tiempos;
    }

    public function getNumExostos() {
        $numExostos = "";
        $numExostos = $numExostos . "<option value='1'>1</option>";
        $numExostos = $numExostos . "<option value='2'>2</option>";
        $numExostos = $numExostos . "<option value='3'>3</option>";
        $numExostos = $numExostos . "<option value='4'>4</option>";
        echo $numExostos;
    }

    public function getSiNo() {
        $sino = "";
        $sino = $sino . "<option value='0'>NO</option>";
        $sino = $sino . "<option value='1'>SI</option>";
        echo $sino;
    }

    public function getSiNoNa() {
        $sino = "";
        $sino = $sino . "<option value='NA'>NO APLICA</option>";
        $sino = $sino . "<option value='SI'>SI</option>";
        $sino = $sino . "<option value='NO'>NO</option>";
        echo $sino;
    }

    public function getCilindros() {
        $cilindros = "";
        $cilindros = $cilindros . "<option value='1'>1</option>";
        $cilindros = $cilindros . "<option value='2'>2</option>";
        $cilindros = $cilindros . "<option value='3'>3</option>";
        $cilindros = $cilindros . "<option value='4'>4</option>";
        $cilindros = $cilindros . "<option value='6'>6</option>";
        $cilindros = $cilindros . "<option value='8'>8</option>";
        $cilindros = $cilindros . "<option value='10'>10</option>";
        $cilindros = $cilindros . "<option value='12'>12</option>";
        echo $cilindros;
    }

    private function getCarroceria($idcarroceria) {
        $json = file_get_contents('recursos/carroceria.json', true);
        $lin = json_decode($json, true);
        $carroceria = "";
        foreach ($lin as $l) {
            $value = $l['codigo'];
            $nombre = $l['nombre'];
            if ($value == $idcarroceria) {
                $carroceria = "<option value='$value'>$nombre</option>";
                break;
            }
        }
        return $carroceria;
    }

    private function setDatos() {
        $this->setAtr("histo_propietario", "histo_propietario", "0");
        $this->setAtr("histo_servicio", "histo_servicio", "0");
        $this->setAtr("histo_licencia", "histo_licencia", "0");
        $this->setAtr("histo_color", "histo_color", "0");
        $this->setAtr("histo_combustible", "histo_combustible", "0");
        $this->setAtr("histo_kilometraje", "histo_kilometraje", "0");
        $this->setAtr("histo_blindaje", "histo_blindaje", "0");
        $this->setAtr("histo_polarizado", "histo_polarizado", "0");
        $this->setAtr("usuario_registro", "usuario_registro", "0");
        $this->setAtr("histo_cliente", "histo_cliente", "0");
        $this->setAtr("histo_aseguradora", "histo_aseguradora", "0");
        $this->setAtr("fecha_inicio_soat", "fecha_inicio_soat", "0");
        $this->setAtr("numero_soat", "numero_soat", "0");
        $this->setAtr("chk-3", "Certificado de conversión a gas VIGENTE (si aplica)", "3");
    }

    private function setAtr($id, $label, $orden) {
        $data['id'] = $id;
        $data['label'] = $label;
        $data['orden'] = $orden;
        $r = $this->Mpre_atributo->getXid($data);
        if ($r->num_rows() == 0) {
            $this->Mpre_atributo->insert($data);
        }
    }

    public function BuscarPropietario() {
        $this->load->view('oficina/vehiculo/Vclientevehiculo');
    }

    public function getCliente() {
        if ($this->input->post('match') !== '') {
            $clientes = $this->Mpropietario->getMatch($this->input->post('match'));
            $datos = '';
            if ($clientes->num_rows() > 0) {
                foreach ($clientes->result() as $c) {
                    $datos = $datos . <<<EOF
            <tr>
                <td>$c->numero_identificacion</td>
                <td>$c->nombre1 $c->nombre2</td>
                <td>$c->apellido1 $c->apellido2</td>
                <td>$c->direccion</td>
                <td>$c->telefono1</td>
                <td>$c->correo</td>
                <td><form action='../Cvehiculo' method='post'>
                        <input name='idcliente' type='hidden' value='$c->idcliente'>
                        <input name='button' id='$c->idcliente' class='btn btn-block'  style='width: content-box;
                                                                            border-radius: 10px 10px 10px 10px;
                                                                            background: whitesmoke;
                                                                            border: solid green;
                                                                            color: black' value='Asignar'
                                                                            onclick='asignarPropietario(this)'/>   
                    </form>
                </td>     
            </tr>
EOF;
                }
            }
            $data['clientes'] = $datos;
        }
        $data['item'] = $this->input->post('match');
        $this->load->view('oficina/vehiculo/Vclientevehiculo', $data);
    }

    public function asignarPropietario() {
        echo $this->session->userdata('siPropietario');
        $numero_placa = $this->session->userdata('numero_placa');
        if ($this->session->userdata('siPropietario') === '1') {
            $idpropietarios = $this->input->post('idpropietarios');
            $this->Mvehiculo->actualizarPropietario($idpropietarios, $numero_placa);
        } else {
            $idcliente = $this->input->post('idpropietarios');
            $this->Mvehiculo->actualizarCliente($idcliente, $numero_placa);
        }
        $this->load->view('oficina/vehiculo/Vvehiculo');
    }

    public function guardarVehiculo() {
        $this->session->set_userdata('siPropietario', $this->input->post('sipropietario'));
        $vehiculo = $this->input->post('vehiculo');
        $this->session->set_userdata('numero_placa', $vehiculo['numero_placa']);
        $vehiculo['usuario'] = $this->session->userdata('IdUsuario');
        $this->Mvehiculo->guardarVehiculo($vehiculo);
    }

    private function setPrerevision() {
        
    }

    public function nuevo() {
        $this->session->unset_userdata('numero_placa');
    }

    public function consultaRuntTask() {
        $encrptopenssl = New Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/oficina.json', true), true);
        $ofc = json_decode($json, true);
        foreach ($ofc as $d) {
            $data[$d['nombre']] = $d['valor'];
        }
        $this->load->view('oficina/vehiculo/consultaRuntTask', $data);
    }

    public function buscarVehCRT() {
        $rta = $this->Mvehiculo->getXCRT();
        if ($rta->num_rows() > 0) {
            $v = $rta->result();
            echo json_encode($v[0]);
        } else {
            echo '';
        }
    }

    public function guardarCRT() {
        $fechainicial = $this->input->post('fechainicial');
        $data['idlinearunt'] = $this->input->post('idlinearunt');
        $data['idcolorrunt'] = $this->input->post('idcolorrunt');
        $data['numero_placa'] = $this->input->post('numero_placa');
        $rta = $this->Mvehiculo->guardarCRT($data);
//        var_dump($data);
        if ($rta) {
            echo $fechainicial . ' -> ' . $data['numero_placa'] . ": OK";
        } else {
            echo $fechainicial . ' -> ' . $data['numero_placa'] . ": ERROR";
        }
    }

}
