<?php

require APPPATH . 'libraries/REST_Controller.php';
//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
ini_set('memory_limit', '-1');
set_time_limit(1);

class CRopacidad extends REST_Controller {

    //..................................VARIABLES GLOBALES PARA MOTORSCAN.......
    var $path;
    //datos: Archivo de datos del analizador estado|mensaje|
    var $datos;
    //ip: ip del puerto del opacimetro
    var $ip;
    //puerto: Numero del puerto del analizador
    var $puerto;
    //
    var $ipCaptador = "";
    //
    var $puertoCaptador = "";
    //
    var $rpmCaptador = "";
    //
    var $tempCaptador = "";
    //
    var $simuladorCaptador = "";
    //
    var $ipSonometro = "";
    //
    var $puertoSonometro = "";
    //
    var $ruidoSonometro = "";
    //
    var $ipAnalizador = "";
    //
    var $puertoAnalizador = "";
    //
    var $marcaAnalizador = "";
    //
    var $rpmAnalizador = "";
    //
    var $tempAnalizador = "";
    //
    var $simuladorAnalizador = "";
    //
    var $ipTH = "";
    //
    var $puertoTH = "";
    //
    var $simuladorTH = "";
    //
    var $humedadTH = "";
    //
    var $tempAmbTH = "";
    //
    var $conectadoTH = "";

    //comandos: Comandos del analizador.........................................
    //..................................VARIABLES GLOBALES PARA MOTORSCAN.......


    public function __construct() {
        parent::__construct();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        $this->load->helper(['jwt', 'authorization']);
        $this->load->model("pruebas/opacidad/Mopacidad");
        $this->load->model("domain/VehiculoModel");

        $this->load->library('Encry');
        espejoDatabase();
    }

    public function index_get() {
//        $tokenData = '896sdbwfe87vcsdaf984ng8fgh24o1290r';
//        $token = AUTHORIZATION::generateToken($tokenData);
        // echo $token;
        $rta = $this->verify_request();
        if ($rta == parent::HTTP_OK) {
            $funcion = $this->input->get("funcion");
            $marca = $this->input->get("marca");
            if ($marca == "MOTORSCAN") {
                $this->path = $_SERVER['DOCUMENT_ROOT'] . "et/motorscan/cmd/";
            } else {
                $this->path = $_SERVER['DOCUMENT_ROOT'] . "et/data/";
            }
            $puertoCOM = $this->input->get("puertoCOM");
            $puerto = $this->input->get("puerto");
            $ip = $this->input->get("ip");
            $comando = $this->input->get("comando");
            $cmd = $this->input->get("cmd");
            $core = $this->input->get("core");
            $sim = $this->input->get("simulacion");
            $idmaquina = $this->input->get("idmaquina");
            $vehiculo['numero_placa'] = $this->input->get("numero_placa");
            $vehiculo['diametro_escape'] = $this->input->get("diametro_escape");
            $this->ipCaptador = $this->input->get("ipCaptador");
            $this->puertoCaptador = $this->input->get("puertoCaptador");
            $this->simuladorCaptador = $this->input->get("simuladorCaptador");
            $this->ipAnalizador = $this->input->get("ipAnalizador");
            $this->puertoAnalizador = $this->input->get("puertoAnalizador");
            $this->simuladorAnalizador = $this->input->get("simuladorAnalizador");
            $this->ipTH = $this->input->get("ipTH");
            $this->puertoTH = $this->input->get("puertoTH");
            $this->simuladorTH = $this->input->get("simuladorTH");
            $this->ipSonometro = $this->input->get("ipSonometro");
            $this->puertoSonometro = $this->input->get("ipSonometro");
            switch ($funcion) {
                case 'getdat':
                    $rta = $this->getdat($ip, $puerto, $marca, $sim);
                    break;
                case 'set0':
                    $rta = $this->set0($marca);
                    break;
                case 'init':
                    $rta = $this->init($ip, $puerto, "opacimetro", $marca, $puertoCOM, $core);
                    break;
                case 'cmd':
                    $rta = $this->cmd($ip, $comando);
                    break;
                case 'getOpacimetro':
                    $rta = $this->getGases($this->input->get("idprueba"));
                    break;
                case 'ejecutarCMD':
                    $rta = $this->ejecutarCMD($marca, $ip, $puerto, $cmd);
                    break;
                case 'getMensaje':
                    $rta = $this->getMensaje($ip, $puerto);
                    break;
                case 'getConteo':
                    $rta = $this->getConteo($ip, $puerto);
                    break;
                case 'updateVeh':
                    $rta = $this->updateVeh($vehiculo);
                    break;
                case 'getDatosGenerales':
                    $rta = $this->getDatosGenerales($idmaquina);
                    break;
                case 'getHojaPruebas':
                    $rta = $this->getHojaPruebas($this->input->get("idprueba"));
                    break;
                default:
                    break;
            }
            $status = parent::HTTP_OK;
            $response = ['status' => $status, 'data' => $rta];
            $this->response($response, $status);
        } else {
            $status = parent::HTTP_UNAUTHORIZED;
            $response = ['status' => $status, 'data' => 'Acceso no autorizado'];
            $this->response($response, $status);
        }
    }

    public function index_post() {
        echo 'post';
    }

    public function index_put() {
        echo 'put';
    }

    public function index_delete() {
        echo 'delete';
    }

    protected function verify_request() {
        $headers = $this->input->request_headers();
        $token = $headers['Authorization'];
        try {
            $data = AUTHORIZATION::validateToken($token);
            if ($data === false) {
                $status = parent::HTTP_UNAUTHORIZED;
                $response = ['status' => $status, 'msg' => 'Acceso no autorizado'];
                $this->response($response, $status);
                exit();
            } else {
                return parent::HTTP_OK;
            }
        } catch (Exception $e) {
            $status = parent::HTTP_UNAUTHORIZED;
            $response = ['status' => $status, 'msg' => 'Acceso no autorizado'];
            $this->response($response, $status);
        }
    }

    public function init($ip, $puerto, $maquina, $marca, $puertoCOM, $core) {
        $enc = new Encry();
        if ($marca == "MOTORSCAN") {
            $arc = "motorscan/cmd/" . $core . ".dat";
            $this->WarchivoMtr($arc, "w+", "open|" . $maquina . "|" . $marca . "|" . $ip . "|" . $puerto . "|" . $puertoCOM);
        } else {
            $arc = "data/" . $enc->encrypt("finit") . ".dat";
//            echo "open|" . $maquina . "|" . $marca . "|" . $ip . "|" . $puerto . "|" . $puertoCOM;
            $this->Warchivo($arc, "w+", "open|" . $maquina . "|" . $marca . "|" . $ip . "|" . $puerto . "|" . $puertoCOM);
        }
    }

    public function cmd($ip, $comando) {
        $enc = new Encry();
        $arc = "data/" . $enc->encrypt("finit") . ".dat";
        $this->Warchivo($arc, "w+", $comando . "|virtual||" . $ip . "|10");
    }

    private function ejecutarCMD($marca, $ip, $puerto, $cmd) {
        switch ($marca) {
            case 'motorscan':
                $arch = str_replace(".", "", $ip) . $puerto . "comando";
                file_put_contents("motorscan/cmd/" . $arch . ".dat", $cmd);
                break;
            case 'capelec':
                $enc = new Encry();
                $fileName = $enc->encrypt(str_replace(".", "", $ip) . $puerto . "r");
                $this->Warchivo($this->path . $fileName . ".dat", "w+", $cmd);
                break;
            default:
                break;
        }
    }

    private function set0($marca, $ip, $puerto) {
        $enc = new Encry();
        $arch = str_replace(".", "", $ip) . $puerto . "estado";
        switch ($marca) {
            case 'motorscan':
                $this->set($arch, $enc->encrypt("0"));
                break;
            default:
                break;
        }
    }

    private function getGases($idprueba) {
        return $this->Mopacidad->getGases($idprueba);
    }

    //--------------------------------------------------------------------------CoreMotorScan INICIO

    public function AbrirCore() {
        try {
            $this->CerrarCore();
            sleep(2);
            $WshShell = new COM("WScript.Shell");
            $WshShell->Run($this->path . "open.bat", 7, false);
        } catch (Exception $ex) {
            $this->AbrirCore();
        }
    }

    public function CerrarCore() {
        $WshShell = new COM("WScript.Shell");
        $WshShell->Run($this->path . "close.bat", 7, false);
    }

    public function getdat($ip, $puerto, $marca, $sim) {
        switch ($marca) {
            case 'motorscan':
                $datos = file_get_contents($this->path . str_replace(".", "", $ip) . $puerto . "datos.dat", true);
                if ($datos == "") {
                    $datos = "|||||||||||";
                }
                $dat = explode("|", $datos);
                break;
            case 'CAPELEC':
                $enc = new Encry();
                if ($sim !== '0') {
                    $fileName = $enc->encrypt("12700130w");
                } else {
                    $fileName = $enc->encrypt(str_replace(".", "", $ip) . $puerto . "w");
                }
                $datos = $enc->decrypt(file_get_contents($this->path . $fileName . ".dat", true));
                if ($datos == "") {
                    $datos = "|||||||||||";
                }
                $dat = explode("|", $datos);

                break;
            default:
                break;
        }
        $this->getCaptador();
        $this->getAnalizador();
        $this->getSonometro();
        $this->getTH();
        try {
            $data = array(
                'tipoDispositivo' => 'opa',
                'estado' => $dat[0],
                'opaCru' => $dat[1],
                'opaBes' => $dat[2],
                'opaBrl' => $dat[3],
                'opaFil' => $dat[4],
                'tempGas' => $dat[5],
                'tempTubo' => $dat[6],
                'version' => $dat[7],
                'mensajeG' => $dat[8],
                'conteo' => $dat[9],
                'wu' => $dat[10],
                'serial' => $dat[11],
                'rpmCaptador' => $this->rpmCaptador,
                'tempCaptador' => $this->tempCaptador,
                'rpmAnalizador' => $this->rpmAnalizador,
                'tempAnalizador' => $this->tempAnalizador,
                'ruidoSonometro' => $this->ruidoSonometro,
                'tempAmbTH' => $this->tempAmbTH,
                'humedadTH' => $this->humedadTH,
                'conectadoTH' => $this->conectadoTH
            );
            if ($sim === '0') {
                $this->setDesconnect($fileName, "1|---|---|---|---|---|---|---|---|---|---|---|");
            }
            return $data;
        } catch (Exception $exc) {
            return "";
        }
    }

    private function getCaptador() {
        if ($this->ipCaptador !== "") {
            $enc = new Encry();
            $rpm = "";
            $tmp = "";
            $path = $_SERVER['DOCUMENT_ROOT'] . "et/data/";
            if ($this->simuladorCaptador === '1') {
                $fileName = $enc->encrypt("12700180w");
            } else {
                $fileName = $enc->encrypt(str_replace(".", "", $this->ipCaptador) . $this->puertoCaptador . "w");
            }
            $trama = explode("|", $enc->decrypt(file_get_contents($path . $fileName . ".dat", true)));
            if ($this->simuladorCaptador === '0' || $this->simuladorCaptador === '') {
                $this->setDesconnect($fileName, "---|---");
            }
            if ($trama[0] !== "---") {
                foreach ($trama as $dat) {
                    if (strlen($dat) > 3 && is_numeric($dat)) {
                        $rpm = $dat;
                    }
                    if (substr($dat, 0, 1) == "T" && strlen($dat) > 1) {
                        $tmp = substr($dat, 1);
                    }
//                    var_dump($this->simuladorCaptador);
                }
                $this->rpmCaptador = $rpm;
                $this->tempCaptador = $tmp;

//                if ($this->simuladorCaptador === '0' || $this->simuladorCaptador === '') {
//                    $this->setDesconnect($fileName, "---|---");
//                }
            } else {
                $this->rpmCaptador = "---";
                $this->tempCaptador = "---";
            }
        }
    }

    private function getAnalizador() {
        if ($this->ipAnalizador !== "") {
            if ($this->marcaAnalizador == "MOTORSCAN") {
                $path = $_SERVER['DOCUMENT_ROOT'] . "et/motorscan/cmd/";
            } else {
                $path = $_SERVER['DOCUMENT_ROOT'] . "et/data/";
            }
            $enc = new Encry();
            if ($this->simuladorAnalizador === '1') {
                $fileName = $enc->encrypt("12700110w");
            } else {
                $fileName = $enc->encrypt(str_replace(".", "", $this->ipAnalizador) . $this->puertoAnalizador . "w");
            }

//            $fileName = $enc->encrypt(str_replace(".", "", $this->ipAnalizador) . $this->puertoAnalizador . "w");
            $datos = $enc->decrypt(file_get_contents($path . $fileName . ".dat", true));
            if ($datos == "") {
                $datos = "|||||||||||||";
            }
            $dat = explode("|", $datos);

            if ($dat[0] === "4") {
                $dat[7] = "C";
                $dat[8] = $dat[11];
            }
            $this->tempAnalizador = $dat[8];
//            $this->tempAnalizador = $dat[6];
            $this->rpmAnalizador = $dat[7];
            if ($this->simuladorAnalizador === '0' || $this->simuladorAnalizador === '') {
                $this->setDesconnect($fileName, "1|---|---|---|---|---|---|---|---|---|---|---|---|---");
            }
        }
    }

    private function getSonometro() {
        if ($this->ipSonometro !== "") {
            $enc = new Encry();
            $ip = str_replace(".", "", $this->ipSonometro);
            $archivo = "data/" . $enc->encrypt($ip . $this->puertoSonometro . "w") . ".dat";
            $trama = explode("|", $enc->decrypt(file_get_contents($archivo)));
            $ruido = "";
            foreach ($trama as $dat) {
                if ($dat !== "") {
                    $ruido = $dat;
                }
            }
//            $this->ruidoSonometro = floatval($ruido) / 10;
        }
        $this->ruidoSonometro = "45.2";
    }

    private function getTH() {
        if ($this->ipTH !== "") {
            $enc = new Encry();
            $ip = str_replace(".", "", $this->ipTH);
            if ($this->simuladorTH <> '0') {
                $fileName = $enc->encrypt("12700120w");
            } else {
                $fileName = $enc->encrypt(str_replace(".", "", $this->ipTH) . $this->puertoTH . "w");
            }
            $archivo = "data/" . $fileName . ".dat";
            $dat = explode("|", $enc->decrypt(file_get_contents($archivo)));
            if ($dat == "") {
                $dat = "|||";
            }
//            $data = array(
//                'tipoDispositivo' => 'th',
//                'tempAmb' => $dat[0],
//                'humedad' => $dat[1],
//                'fecha' => $dat[2],
//                'conectado' => $dat[3]
//            );
//            return $data;

            $this->tempAmbTH = $dat[0];
            $this->humedadTH = $dat[1];
            $this->conectadoTH = $dat[3];
        }
    }

    public function setDesconnect($archivo, $trama) {
        $arc = "data/" . $archivo . ".dat";
        $this->Warchivo($arc, "w+", $trama);
    }

    public function getMensaje($ip, $puerto) {
        return file_get_contents("motorscan/cmd/" . str_replace(".", "", $ip) . $puerto . "mensaje.dat", true);
    }

    public function getConteo($ip, $puerto) {
        return file_get_contents("motorscan/cmd/" . str_replace(".", "", $ip) . $puerto . "conteo.dat", true);
    }

    private function Warchivo($archivo, $tipo, $conten) {
        $enc = new Encry();
        $content = $enc->encrypt($conten);
        try {
            $file = fopen($archivo, $tipo);
            fwrite($file, $content);
            fclose($file);
            usleep(500);
            //  throw new Exception;
        } catch (Exception $exc) {
            $this->Warchivo($archivo, $tipo, $content);
        }
    }

    private function WarchivoMtr($archivo, $tipo, $conten) {
        try {
            $file = fopen($archivo, $tipo);
            fwrite($file, $conten);
            fclose($file);
            // usleep(500);
            //  throw new Exception;
        } catch (Exception $exc) {
            $this->Warchivo($archivo, $tipo, $content);
        }
    }

    private function updateVeh($v) {
        $this->VehiculoModel->update($v);
    }

    private function getDatosGenerales($idmaquina) {
        return $this->Mopacidad->getDatosGenerales($idmaquina);
    }

    private function getHojaPruebas($idprueba) {
        return $this->Mopacidad->getHojaPruebas($idprueba);
    }

    //--------------------------------------------------------------------------CoreMotorScan FINAL
}
