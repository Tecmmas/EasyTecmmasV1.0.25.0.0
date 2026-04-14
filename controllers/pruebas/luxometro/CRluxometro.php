<?php

require APPPATH . 'libraries/REST_Controller.php';
//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
set_time_limit(0);

class CRluxometro extends REST_Controller {

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
        $this->load->model("pruebas/luxometro/Mluxometro");
        espejoDatabase();
    }

    public function index_get() {
//        $tokenData = '896sdbwfe87vcsdaf984ng8fgh24o1290r';
//        $token = AUTHORIZATION::generateToken($tokenData);
//         echo $token;
        $rta = $this->verify_request();
        if ($rta == parent::HTTP_OK) {
            $ip = $this->input->get("ip");
            $puerto = $this->input->get("puerto");
            $funcion = $this->input->get("funcion");
            $marca = $this->input->get("marca");
            $comando = $this->input->get("comando");
            $url = $this->input->get("url");
            $placa = $this->input->get("placa");
            $contenido = $this->input->get("contenido");
            switch ($funcion) {
                case 'getdat':
                    $rta = $this->getdat($ip, $puerto, 'luxometro', $marca);
                    break;
                case 'init':
                    $rta = $this->init($ip, $puerto, 'luxometro', $marca);
                    break;
                case 'cmd':
                    $rta = $this->cmd($ip, $comando);
                    break;
                case 'getHojaPruebas':
                    $rta = $this->getHojaPruebas($this->input->get("idprueba"));
                    break;
                case 'getLuxometro':
                    $rta = $this->getLuxometro($this->input->get("idprueba"));
                    break;
                case 'setCG':
                    $rta = $this->setCG($url, $placa, $contenido);
                    break;
                case 'getRES':
                    $rta = $this->getRES($url, $placa);
                    break;
                case 'delCG':
                    $rta = $this->delCG($url, $placa);
                    break;
                case 'delRES':
                    $rta = $this->delRES($url, $placa);
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

    public function getdat($ip, $puerto, $maquina, $marca) {
        $enc = new Encry();
        $ip = str_replace(".", "", $ip);
        $archivo = "data/" . $enc->encrypt($ip . $puerto . "w") . ".dat";
        $trama = $enc->decrypt(file_get_contents($archivo));
        if ($trama !== "") {
            $this->Warchivo($archivo, "w+", "");
        } else {
            $trama = "Esperando respuesta..";
        }
        $data = array(
            'tipoDispositivo' => 'lux',
            'trama' => $trama
        );
        return $data;
    }

    public function cmd($ip, $comando) {
        $enc = new Encry();
        $arc = "data/" . $enc->encrypt("finit") . ".dat";
        $this->Warchivo($arc, "w+", $comando . "|virtual||" . $ip . "|10");
    }

    private function Warchivo($archivo, $tipo, $conten) {
        $enc = new Encry();
        $content = $enc->encrypt($conten);
        try {
            $file = fopen($archivo, $tipo);
            fwrite($file, $content);
            fclose($file);
            usleep(500);
        } catch (Exception $exc) {
            $this->Warchivo($archivo, $tipo, $content);
        }
    }

    private function getHojaPruebas($idprueba) {
        return $this->Mluxometro->getHojaPruebas($idprueba);
    }

    private function getLuxometro($idprueba) {
        return $this->Mluxometro->getLuxometro($idprueba);
    }

    private function setCG($url, $placa, $contenido) {
        file_put_contents($url . "CG/" . $placa . ".CG", $contenido);
        return "";
    }

    private function getRES($url, $placa) {
        return file_get_contents($url . "RES/" . $placa . ".P");
    }

    private function delCG($url) {
        $files = glob($url . 'CG/*.CG');
        foreach ($files as $file) {
            if (is_file($file))
                unlink($file);
        }
        return "";
    }

    private function delRES($url) {
        $files = glob($url . 'RES/*.P');
        foreach ($files as $file) {
            if (is_file($file))
                unlink($file);
        }
        return "";
    }

}
