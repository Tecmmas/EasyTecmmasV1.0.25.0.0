<?php

require APPPATH . 'libraries/REST_Controller.php';
//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
set_time_limit(0);

class CRcamara extends REST_Controller {

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
        $this->load->model("Mutilitarios");
        $this->load->model("pruebas/camara/Mcamara");
        espejoDatabase();
    }

    public function index_get() {
//        $tokenData = '896sdbwfe87vcsdaf984ng8fgh24o1290r';
//        $token = AUTHORIZATION::generateToken($tokenData);
        // echo $token;
        $rta = $this->verify_request();
        if ($rta == parent::HTTP_OK) {
            $funcion = $this->input->get("funcion");
            switch ($funcion) {
                case 'getNow':
                    $rta = $this->getNow();
                    break;
                case 'getFoto':
                    $idhojapruebas = $this->input->get("idhojapruebas");
                    $reinspeccion = $this->input->get("reinspeccion");
                    $prueba = $this->input->get("prueba");
                    $rta = $this->getFoto($idhojapruebas, $reinspeccion, $prueba);
                    break;
                case 'getHojaPruebas':
                    $rta = $this->getHojaPruebas($this->input->get("idprueba"));
                    break;
                case 'guardarImagen':
                    $idprueba = $this->input->get("idprueba");
                    $imagen = $this->input->get("imagen");
                    $idusuario = $this->input->get("idusuario");
                    $idmaquina = $this->input->get("idmaquina");
                    $this->guardarImagen($idprueba, $imagen, $idusuario, $idmaquina);
                    $rta = "guardar";
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

    private function getNow() {
        return $this->Mutilitarios->getNow();
    }

    private function getHojaPruebas($idprueba) {
        return $this->Mcamara->getHojaPruebas($idprueba);
    }

    private function getFoto($idhojapruebas, $reinspeccion, $prueba) {
//        $order = "";
//        if ($reinspeccion == '1') {
        $order = "desc";
//        }
        return $this->Mcamara->getFoto($idhojapruebas, $order, $prueba);
    }

    private function guardarImagen($idprueba, $imagen, $idusuario, $idmaquina) {
        return $this->Mcamara->guardarImagen($idprueba, $imagen, $idusuario, $idmaquina);
    }

    public function guardarImagenPOST() {
        $idprueba = $this->input->post("idprueba");
        $imagen = $this->input->post("imagen");
        $idusuario = $this->input->post("idusuario");
        $idmaquina = $this->input->post("idmaquina");
        $this->Mcamara->guardarImagen($idprueba, $imagen, $idusuario, $idmaquina);
    }

}
