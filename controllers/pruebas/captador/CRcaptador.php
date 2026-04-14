<?php

require APPPATH . 'libraries/REST_Controller.php';
//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
set_time_limit(0);

class CRcaptador extends REST_Controller {

    var $path;

    public function __construct() {
        parent::__construct();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        $this->load->helper(['jwt', 'authorization']);
        $this->path = $_SERVER['DOCUMENT_ROOT'] . "et/data/";
        $this->load->library('Encry');
        espejoDatabase();
    }

    public function index_get() {
//        $tokenData = '896sdbwfe87vcsdaf984ng8fgh24o1290r';
//        $token = AUTHORIZATION::generateToken($tokenData);
        // echo $token;
        $rta = $this->verify_request();
        if ($rta == parent::HTTP_OK) {
            $ip = $this->input->get("ip");
            $puerto = $this->input->get("puerto");
            $funcion = $this->input->get("funcion");
            $marca = $this->input->get("marca");
            $comando = $this->input->get("comando");
            switch ($funcion) {
                case 'getdat':
                    $rta = $this->getdat($ip, $puerto, 'captador', $marca);
                    break;
                case 'init':
                    $rta = $this->init($ip, $puerto, 'captador', $marca);
                    break;
                case 'cmd':
                    $rta = $this->cmd($ip, $comando);
                    break;
                case 'cmdBt':
                    $rta = $this->cmdBt($ip, $comando);
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

    public function init($ip, $puerto, $maquina, $marca) {
        $enc = new Encry();
        $arc = "data/" . $enc->encrypt("finit") . ".dat";
        $this->Warchivo($arc, "w+", "open|" . $maquina . "|" . $marca . "|" . $ip . "|" . $puerto);
    }

    public function cmd($ip, $comando) {
        $enc = new Encry();
        $arc = "data/" . $enc->encrypt("finit") . ".dat";
        $this->Warchivo($arc, "w+", $comando . "|virtual||" . $ip . "|10");
    }

    public function cmdBt($ip, $comando) {
        $enc = new Encry();
        $arc = "data/" . $enc->encrypt("finit") . ".dat";
        $this->Warchivo($arc, "w+", $comando . "|bt||" . $ip . "|50");
    }

    public function getdat($ip, $puerto, $maquina, $marca) {
        $enc = new Encry();
        $ip = str_replace(".", "", $ip);
        $rpm = "";
        $tmp = "";
        $archivo = "data/" . $enc->encrypt($ip . $puerto . "w") . ".dat";
        $trama = explode("|", $enc->decrypt(file_get_contents($archivo)));
        foreach ($trama as $dat) {
            if (strlen($dat) > 3 && is_numeric($dat)) {
                $rpm = $dat;
            }
            if (substr($dat, 0, 1) == "T" && strlen($dat) > 1) {
                $tmp = substr($dat, 1);
            }
        }
        $data = array(
            'tipoDispositivo' => 'cap',
            'rpmCap' => $rpm,
            'tempCap' => $tmp
        );
        return $data;
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

}
