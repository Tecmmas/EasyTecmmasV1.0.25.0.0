<?php

require APPPATH . 'libraries/REST_Controller.php';
//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
ini_set('memory_limit', '-1');
set_time_limit(1);

class CRfrenometro extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        $this->load->helper(['jwt', 'authorization']);
        $this->load->model("pruebas/frenometro/Mfrenometro");
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
            $vehiculo['numero_placa'] = $this->input->get("numero_placa");
            $vehiculo['numejes'] = $this->input->get("numejes");
            $vehiculo['numero_llantas'] = $this->input->get("numero_llantas");
            if ($marca == "MOTORSCAN") {
                $this->path = $_SERVER['DOCUMENT_ROOT'] . "et/motorscan/cmd/";
            } else {
                $this->path = $_SERVER['DOCUMENT_ROOT'] . "et/data/";
            }
            switch ($funcion) {
                case 'getTaximetro':
                    $rta = $this->getFrenometro($this->input->get("idprueba"));
                    break;
                case 'getHojaPruebas':
                    $rta = $this->getHojaPruebas($this->input->get("idprueba"));
                    break;
                case 'getIdPruebaTP':
                    $rta = $this->getIdPruebaTP($this->input->get("idhojapruebas"), $this->input->get("idtipo_prueba"));
                    break;
                case 'getIdPruebaDefLab':
                    $rta = $this->getIdPruebaDefLab($this->input->get("idhojapruebas"));
                    break;
                case 'actualizarEjesLlantas':
                    $rta = $this->updateVeh($vehiculo);
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

//    private function getTaximetro($idprueba) {
//        return $this->Mfrenometro->getTaximetro($idprueba);
//    }

    private function getHojaPruebas($idprueba) {
        return $this->Mfrenometro->getHojaPruebas($idprueba);
    }

    private function getIdPruebaTP($idhojapruebas, $idtipo_prueba) {
        return $this->Mfrenometro->getIdPruebaTP($idhojapruebas, $idtipo_prueba);
    }

    private function getIdPruebaDefLab($idhojapruebas) {
        return $this->Mfrenometro->getIdPruebaDefLab($idhojapruebas);
    }

//    private function actualizarEjesLlantas($numero_placa, $numejes, $numero_llantas) {
//        return $this->Mfrenometro->actualizarEjesLlantas($numero_placa, $numejes, $numero_llantas);
//    }

    private function updateVeh($v) {
        $this->VehiculoModel->update($v);
    }

}
