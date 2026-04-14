<?php

require APPPATH . 'libraries/REST_Controller.php';
//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class CRanalizador extends REST_Controller {

    //..................................VARIABLES GLOBALES PARA MOTORSCAN.......
    var $path;
    //datos: Archivo de datos del analizador estado|mensaje|
    var $datos;
    //puerto: Numero del puerto del analizador
    var $ip;
    //puerto: Numero del puerto del analizador
    var $puerto;
    //comandos: Comandos del analizador.........................................
    //bomba: 1 on 0 off
    var $bomba;
    //sol1: 1 on 0 off
    var $sol1;
    //sol2: 1 on 0 off
    var $sol2;

    //..................................VARIABLES GLOBALES PARA MOTORSCAN.......


    public function __construct() {
        parent::__construct();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        $this->load->helper(['jwt', 'authorization']);
        $this->load->model("pruebas/analizador/Manalizador");
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
            $vehiculo['scooter'] = $this->input->get("scooter");
            $vehiculo['numero_exostos'] = $this->input->get("numero_exostos");
            $vehiculo['convertidor'] = $this->input->get("convertidor");
            switch ($funcion) {
//                case 'AbrirCore':
//                    //  $this->AbrirCore();
//                    break;
//                case 'CerrarCore':
//                    //   $this->CerrarCore();
//                    break;
                case 'pumpOn':
                    $this->prenderBomba($marca, $ip, $puerto);
                    break;
                case 'pumpOff':
                    $this->apagarBomba($marca, $ip, $puerto);
                    break;
                case 'sol1On':
                    $this->prenderSol1($marca, $ip, $puerto);
                    break;
                case 'sol1Off':
                    $this->apagarSol1($marca, $ip, $puerto);
                    break;
                case 'sol2On':
                    $this->prenderSol2($marca, $ip, $puerto);
                    break;
                case 'sol2Off':
                    $this->apagarSol2($marca, $ip, $puerto);
                    break;
                case 'sol3On':
                    $this->prenderSol3($marca, $ip, $puerto);
                    break;
                case 'sol3Off':
                    $this->apagarSol3($marca, $ip, $puerto);
                    break;
                case 'getdat':
                    $rta = $this->getdat($ip, $puerto, $marca, $sim);
                    break;
                case 'set0':
                    $rta = $this->set0($marca);
                    break;
                case 'init':
                    $rta = $this->init($ip, $puerto, "analizador", $marca, $puertoCOM, $core);
                    break;
                case 'cmd':
                    $rta = $this->cmd($ip, $comando);
                    break;
                case 'getAnalizador':
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
                case 'getHojaPruebas':
                    $rta = $this->getHojaPruebas($this->input->get("idprueba"));
                    break;
                case 'get1024':
                    $rta = $this->get1024();
                    break;
                case 'get1025':
                    $rta = $this->get1025();
                    break;
                case 'update1024':
                    $rta = $this->update1024();
                    break;
                case 'getDatosGenerales':
                    $rta = $this->getDatosGenerales($idmaquina);
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
            //$arc = "motorscan/cmd/" . $enc->encrypt("finit") . ".dat";
            $arc = "motorscan/cmd/" . $core . ".dat";
            $this->WarchivoMtr($arc, "w+", "open|" . $maquina . "|" . $marca . "|" . $ip . "|" . $puerto . "|" . $puertoCOM);
        } else {
            $arc = "data/" . $enc->encrypt("finit") . ".dat";
            //  echo "open|" . $maquina . "|" . $marca . "|" . $ip . "|" . $puerto . "|" . $puertoCOM;
            $this->Warchivo($arc, "w+", "open|" . $maquina . "|" . $marca . "|" . $ip . "|" . $puerto . "|" . $puertoCOM);
        }
    }

    public function cmd($ip, $comando) {
        $enc = new Encry();
        $arc = "data/" . $enc->encrypt("finit") . ".dat";
        $this->Warchivo($arc, "w+", $comando . "|virtual||" . $ip . "|10");
    }

    private function prenderBomba($marca, $ip, $puerto) {
        $enc = new Encry();
        $arch = str_replace(".", "", $ip) . $puerto . "pump";
        switch ($marca) {
            case 'motorscan':
                $this->set($arch, $enc->encrypt("1"));
                break;
            default:
                break;
        }
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

    private function apagarBomba($marca, $ip, $puerto) {
        $enc = new Encry();
        $arch = str_replace(".", "", $ip) . $puerto . "pump";
        switch ($marca) {
            case 'motorscan':
                $this->set($arch, $enc->encrypt("0"));
                break;

            default:
                break;
        }
    }

    private function prenderSol1($marca, $ip, $puerto) {
        $enc = new Encry();
        $arch = str_replace(".", "", $ip) . $puerto . "sol1";
        switch ($marca) {
            case 'motorscan':
                $this->set($arch, $enc->encrypt("1"));
                break;
            default:
                break;
        }
    }

    private function apagarSol1($marca, $ip, $puerto) {
        $enc = new Encry();
        $arch = str_replace(".", "", $ip) . $puerto . "sol1";
        switch ($marca) {
            case 'motorscan':
                $this->set($arch, $enc->encrypt("0"));
                break;
            default:
                break;
        }
    }

    private function prenderSol2($marca, $ip, $puerto) {
        $enc = new Encry();
        $arch = str_replace(".", "", $ip) . $puerto . "sol2";
        switch ($marca) {
            case 'motorscan':
                $this->set($arch, $enc->encrypt("1"));
                break;
            default:
                break;
        }
    }

    private function apagarSol2($marca, $ip, $puerto) {
        $enc = new Encry();
        $arch = str_replace(".", "", $ip) . $puerto . "sol2";
        switch ($marca) {
            case 'motorscan':
                $this->set($arch, $enc->encrypt("0"));
                break;
            default:
                break;
        }
    }

    private function prenderSol3($marca, $ip, $puerto) {
        $enc = new Encry();
        $arch = str_replace(".", "", $ip) . $puerto . "sol3";
        switch ($marca) {
            case 'motorscan':
                $this->set($arch, $enc->encrypt("0"));
                break;
            default:
                break;
        }
    }

    private function apagarSol3($marca, $ip, $puerto) {
        $enc = new Encry();
        $arch = str_replace(".", "", $ip) . $puerto . "sol3";
        switch ($marca) {
            case 'motorscan':
                $this->set($arch, $enc->encrypt("0"));
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
        return $this->Manalizador->getGases($idprueba);
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
                    $datos = "||||||||||||";
                }
                $dat = explode("|", $datos);
                break;
            case 'CAPELEC':
                $enc = new Encry();
                if ($sim !== '0') {
                    $fileName = $enc->encrypt("12700110w");
                } else {
                    $fileName = $enc->encrypt(str_replace(".", "", $ip) . $puerto . "w");
                }
                $datos = $enc->decrypt(file_get_contents($this->path . $fileName . ".dat", true));
                if ($datos == "") {
                    $datos = "||||||||||||";
                }
                $dat = explode("|", $datos);
                if ($sim === '0') {
                    $this->setDesconnect($fileName);
                }

                break;
            default:
                break;
        }
        try {
            $data = array(
                'tipoDispositivo' => 'ana',
                'estado' => $dat[0],
                'mensaje' => $dat[1],
                'co' => $dat[2],
                'co2' => $dat[3],
                'o2' => $dat[4],
                'hc' => $dat[5],
                'temp' => $dat[6],
                'rpm' => $dat[7],
                'presion' => $dat[8],
                'mensajeG' => $dat[9],
                'conteo' => $dat[10],
                'wu' => $dat[11],
                'serial' => $dat[12]
            );

            return $data;
        } catch (Exception $exc) {
            return "";
        }
    }

    public function setDesconnect($archivo) {
        $arc = "data/" . $archivo . ".dat";
        $this->Warchivo($arc, "w+", "1|Desconectado|---|---|---|---|---|---|---|---|---|---|---|");
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
            usleep(500);
            //  throw new Exception;
        } catch (Exception $exc) {
            $this->Warchivo($archivo, $tipo, $content);
        }
    }

    private function updateVeh($v) {
        $this->VehiculoModel->update($v);
    }

    private function getHojaPruebas($idprueba) {
        return $this->Manalizador->getHojaPruebas($idprueba);
    }

    private function get1024() {
        return $this->Manalizador->get1024();
    }

    private function get1025() {
        return $this->Manalizador->get1025();
    }

    private function update1024() {
        return $this->Manalizador->update1024();
    }

    private function getDatosGenerales($idmaquina){
        return $this->Manalizador->getDatosGenerales($idmaquina);
    }

    //--------------------------------------------------------------------------CoreMotorScan FINAL
}
