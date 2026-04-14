<?php

require APPPATH . 'libraries/REST_Controller.php';
//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
set_time_limit(0);

class Ccore extends REST_Controller {

    var $fpCaptador;
    var $path1;
    var $path2;

    public function __construct() {
        parent::__construct();
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        $this->load->helper(['jwt', 'authorization']);
        $this->path1 = $_SERVER['DOCUMENT_ROOT'] . "et/data/";
        $this->path2 = $_SERVER['DOCUMENT_ROOT'] . "et/motorscan/cmd/";
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
            $ip = $this->input->get("ip");
            $puerto = $this->input->get("puerto");
            $core = $this->input->get("core");
            switch ($funcion) {
                case 'abrir':
                    $this->abrir("javaw.exe", $this->path1, $ip, $puerto);
                    if ($marca == "MOTORSCAN") {
                        $this->abrir($core . ".exe", $this->path2, $ip, $puerto);
                    }
                    break;
                case 'restart':
                    if ($marca == "MOTORSCAN") {
                        $this->AbrirCoreMtr($this->path2);
                    } else {
                        $this->AbrirCore($this->path1);
                    }
                    $rta = "restart";
                    break;
                case 'start':
                    if ($marca == "MOTORSCAN") {
                        $this->AbrirCoreMtr($this->path2);
                    } else {
                        $this->AbrirCore($this->path1);
                    }
                    $rta = "start";
                    break;
                case 'shutdown':
                    if ($marca == "MOTORSCAN") {
                        $this->CerrarCoreMtr($this->path2);
                    } else {
                        $this->CerrarCore($this->path1);
                    }
                    $rta = "shutdown";
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

    private function abrir($proceso, $path, $ip, $puerto) {
        $task_list = array();
        exec("tasklist 2>NUL", $task_list);
        $existe = false;
        foreach ($task_list AS $task_line) {
            $task_line = explode(" ", $task_line);
            if ($task_line[0] == $proceso || $task_line[0] == "java.exe") {
                $existe = true;
                break;
            }
        }

        if (!$existe) {
//            if ($proceso == "mtrscore.exe") {
//                $this->arduinoReset($ip, $puerto);
//                sleep(4);
//            }
            if ($proceso == "javaw.exe") {
                $this->AbrirCore($path);
            } else {
                $this->AbrirCoreMtr($path, str_replace(".exe", ".bat", $proceso));
            }
        } else {
            
        }
        //  sleep(2);
    }

    public function arduinoReset($ip, $puerto) {
        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_connect($sock, $ip, $puerto);
        $st = "Config Reset";
        $length = strlen($st);
        socket_write($sock, $st, $length);
        socket_shutdown($sock, 2);
        socket_close($sock);
    }

    public function AbrirCore($path) {
        $this->CerrarCore($path);
        sleep(1);
        $WshShell = new COM("WScript.Shell");
        $WshShell->Run($path . "open.bat", 7, false);
        return "restart";
    }

    public function AbrirCoreMtr($path, $proceso) {
        $this->CerrarCoreMtr($path, $proceso);
        sleep(1);
        $WshShell = new COM("WScript.Shell");
        $WshShell->Run($path . "open" . $proceso, 7, false);
    }

    public function CerrarCore($path) {
        $WshShell = new COM("WScript.Shell");
        $WshShell->Run($path . "close.bat", 7, false);
        return "shutdown";
    }

    public function CerrarCoreMtr($path, $proceso) {
        $WshShell = new COM("WScript.Shell");
        $WshShell->Run($path . "close" . $proceso, 7, false);
    }

}
