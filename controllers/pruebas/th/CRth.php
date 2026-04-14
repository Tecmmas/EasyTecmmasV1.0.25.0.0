<?php

require APPPATH . 'libraries/REST_Controller.php';
//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
set_time_limit(0);

class CRth extends REST_Controller {

    var $path;

    public function __construct() {
        parent::__construct();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        $this->load->helper(['jwt', 'authorization']);
        $this->path = $_SERVER['DOCUMENT_ROOT'] . "et/data/";
        $this->load->model("pruebas/th/Mth");
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
            $sim = $this->input->get("simulador");
            $idmaquina = $this->input->get("idmaquina");
            switch ($funcion) {
                case 'getdat':
                    $rta = $this->getdat($ip, $puerto, 'th', $marca, $sim);
                    break;
                case 'init':
                    $rta = $this->init($ip, $puerto, 'th', $marca);
                    break;
                case 'bd':
                    $rta = $this->bd($idmaquina);
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
        //var_dump($headers);
        if (isset($headers['Authorization'])) {
            $token = $headers['Authorization'];
        } else {
            $token = $headers['authorization'];
        }
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

    public function getdat($ip, $puerto, $maquina, $marca, $sim) {
        $enc = new Encry();
        $ip = str_replace(".", "", $ip);
        if ($sim <> '0') {
            $fileName = $enc->encrypt("12700120w");
        } else {
            $fileName = $enc->encrypt(str_replace(".", "", $ip) . $puerto . "w");
        }
        $archivo = "data/" . $fileName . ".dat";
        $dat = explode("|", $enc->decrypt(file_get_contents($archivo)));
        if ($dat == "") {
            $dat = "|||";
        }
        $data = array(
            'tipoDispositivo' => 'th',
            'tempAmb' => $dat[0],
            'humedad' => $dat[1],
            'fecha' => $dat[2],
            'conectado' => $dat[3]
        );

        
        return $data;
    }

    public function bd($idmaquina) {
        $rta = $this->Mth->get($idmaquina);
        $rtaDiff = $this->Mth->getDiff($idmaquina);
        foreach ($rta->result() as $r) {
            switch ($r->tipo_parametro) {
                case 'Temperatura Ambiente':
                    $tempAmb = $r->parametro;
                    break;
                case 'Humedad Relativa':
                    $humedad = $r->parametro;
                    break;
                case 'Last Update':
                    $fecha = $r->parametro;
                    break;
                case 'Conectado' :
                case 'conectado' :
                    $conectado = $r->parametro;
                    break;

                default:
                    break;
            }
        }
        $d = $rtaDiff->result();
        if (abs($d[0]->diferencia) > 10) {
            $tempAmb = "0";
            $humedad = "0";
            $conectado = "0";
        }
        $data = array(
            'funcionSet' => 'setTH',
            'tempAmb' => $tempAmb,
            'humedad' => $humedad,
            'fecha' => $fecha,
            'conectado' => $conectado
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




