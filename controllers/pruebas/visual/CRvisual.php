<?php

require APPPATH . 'libraries/REST_Controller.php';
//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
set_time_limit(0);

class CRvisual extends REST_Controller {

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
        $this->load->model("pruebas/visual/Mvisual");
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
                case 'getDefectos':
                    $idprueba = $this->input->get('idprueba');
                    $r = $this->getDefectos($idprueba);
                    $rta = $r->result();
                    break;
                case 'getObses':
                    $idprueba = $this->input->get('idprueba');
                    $r = $this->getObses($idprueba);
                    $rta = $r->result();
                    break;
                case 'getObseAdd':
                    $idprueba = $this->input->get('idprueba');
                    $r = $this->getObseAdd($idprueba);
                    $rta = $r->result();
                    break;
                case 'getObservaciones':
                    $codigo = $this->input->get('codigo');
                    $r = $this->getObservaciones($codigo);
                    $rta = $r->result();
                    break;
                case 'insertarDefecto':
                    $idprueba = $this->input->get('idprueba');
                    $valor = $this->input->get('valor');
                    $this->insertarDefecto($idprueba, $valor);
                    break;
                case 'insertarOperarioSensorial':
                    $data['idprueba'] = $this->input->get('idprueba');
                    $data['idusuario'] = $this->input->get('idusuario');
                    $data['idsensorial'] = $this->input->get('idsensorial');
                    $this->insertarOperarioSensorial($data);
                    break;
                case 'insertarObse':
                    $datos['idprueba'] = $this->input->get('idprueba');
                    $datos['valor'] = $this->input->get('valor');
                    $datos['tiporesultado'] = $this->input->get('tiporesultado');
                    $datos['idconfig_prueba'] = "77";
                    $datos['observacion'] = $this->input->get('tiporesultado');
                    $this->borrarObse($datos);
                    $this->insertarObse($datos);
                    break;
                case 'borrarObse':
                    $datos['idprueba'] = $this->input->get('idprueba');
                    $datos['valor'] = $this->input->get('valor');
                    $datos['tiporesultado'] = $this->input->get('tiporesultado');
                    $this->borrarObse($datos);
                    break;
                case 'insertarObservacionesAdd':
                    $idprueba = $this->input->get('idprueba');
                    $valor = $this->input->get('valor');
                    $this->insertarObservacionesAdd($idprueba, $valor);
                    break;
                case 'borrarDefecto':
                    $idprueba = $this->input->get('idprueba');
                    $valor = $this->input->get('valor');
                    $this->borrarDefecto($idprueba, $valor);
                    break;
                case 'insertarObservacion':
                    $codigo = $this->input->get('codigo');
                    $observacion = $this->input->get('observacion');
                    $this->insertarObservacion($codigo, $observacion);
                    break;
                case 'borrarObservacion':
                    $codigo = $this->input->get('codigo');
                    $observacion = $this->input->get('observacion');
                    $this->borrarObservacion($codigo, $observacion);
                    break;
                case 'actualizarObservacion':
                    $idprueba = $this->input->get('idprueba');
                    $codigo = $this->input->get('codigo');
                    $observacion = $this->input->get('observacion');
                    $this->actualizarObservacion($idprueba, $codigo, $observacion);
                    break;
                case 'actualizarPruebaXMaq':
                    $idprueba = $this->input->get('idprueba');
                    $idmaquina = $this->input->get('idmaquina');
                    $idusuario = $this->input->get('idusuario');
                    $this->actualizarPruebaXMaq($idprueba, $idmaquina,$idusuario);
                    break;
                case 'insertarLabrado':
                    $idprueba = $this->input->get('idprueba');
                    $valor = $this->input->get('valor');
                    $tiporesultado = $this->input->get('tiporesultado');
                    $this->insertarLabrado($idprueba, $tiporesultado, $valor);
                    break;
                case 'borrarLabrado':
                    $idprueba = $this->input->get('idprueba');
                    $tiporesultado = $this->input->get('tiporesultado');
                    $this->borrarLabrado($idprueba, $tiporesultado);
                    break;
                case 'getLabrados':
                    $idprueba = $this->input->get('idprueba');
                    $r = $this->getLabrados($idprueba);
                    $rta = $r->result();
                    break;
                case 'getHojaPruebas':
                    $rta = $this->getHojaPruebas($this->input->get("idprueba"));
                    break;
                case 'getFirmaUsuario':
                    $rta = $this->getFirmaUsuario($this->input->get("documento"));
                    break;
                case 'getPruebasAsignadas':
                    $idhojapruebas = $this->input->get("idhojapruebas");
                    $reinspeccion = $this->input->get("reinspeccion");
                    $r = $this->getPruebasAsignadas($idhojapruebas, $reinspeccion);
                    $rta = $r->result();
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

    private function getNow() {
        return $this->Mutilitarios->getNow();
    }

    private function getDefectos($idprueba) {
        return $this->Mvisual->getDefectos($idprueba);
    }

    private function getObservaciones($idprueba) {
        return $this->Mvisual->getObservaciones($idprueba);
    }
    private function getObses($idprueba) {
        return $this->Mvisual->getObses($idprueba);
    }
    private function getObseAdd($idprueba) {
        return $this->Mvisual->getObseAdd($idprueba);
    }

    private function insertarOperarioSensorial($data) {
        $this->Mvisual->insertarOperarioSensorial($data);
    }
    private function insertarDefecto($idprueba, $valor) {
        $this->Mvisual->insertarDefecto($idprueba, $valor);
    }
    private function insertarObse($datos) {
        $this->Mvisual->insertarObse($datos);
    }
    private function borrarObse($datos) {
        $this->Mvisual->borrarObse($datos);
    }
    
    private function insertarObservacionesAdd($idprueba, $valor) {
        $this->Mvisual->insertarObservacionesAdd($idprueba, $valor);
    }

    private function borrarDefecto($idprueba, $valor) {
        $this->Mvisual->borrarDefecto($idprueba, $valor);
    }

    private function insertarObservacion($codigo, $observacion) {
        $this->Mvisual->insertarObservacion($codigo, $observacion);
    }

    private function borrarObservacion($codigo, $observacion) {
        $this->Mvisual->borrarObservacion($codigo, $observacion);
    }

    private function actualizarObservacion($idprueba, $codigo, $observacion) {
        $this->Mvisual->actualizarObservacion($idprueba, $codigo, $observacion);
    }

    private function insertarLabrado($idprueba, $tiporesultado, $valor) {
        $this->Mvisual->insertarLabrado($idprueba, $tiporesultado, $valor);
    }

    private function borrarLabrado($idprueba, $tiporesultado) {
        $this->Mvisual->borrarLabrado($idprueba, $tiporesultado);
    }

    private function getLabrados($idprueba) {
        return $this->Mvisual->getLabrados($idprueba);
    }

    private function getHojaPruebas($idprueba) {
        return $this->Mvisual->getHojaPruebas($idprueba);
    }

    private function getPruebasAsignadas($idhojapruebas, $reinspeccion) {
        return $this->Mvisual->getPruebasAsignadas($idhojapruebas, $reinspeccion);
    }

    private function actualizarPruebaXMaq($idprueba, $idmaquina,$idusuario) {
        $this->Mvisual->actualizarPruebaXMaq($idprueba, $idmaquina,$idusuario);
    }

}
