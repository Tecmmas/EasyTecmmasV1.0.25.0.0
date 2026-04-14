<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

class Ccombi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->library('Opensslencryptdecrypt');
        espejoDatabase();
    }

    public function getData() {
        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        try {
            if (socket_connect($sock, $this->input->post('ip'), intval($this->input->post('puerto')))) {
                $leer = true;
                $trama = "";
                $count = 0;
                while ($leer) {
                    $byte = socket_read($sock, 1, 0);
                    if ($byte !== "_") {
                        $count = 0;
                        $trama = $trama . $byte;
                        if ($byte == "B") {
                            $leer = false;
                        }
                    } else {
                        $count++;
                        if ($count == 1024) {
                            $leer = false;
                        }
                    }
                }
                if (substr($trama, 1, 1) == "L") {
                    echo $trama;
                } else {
                    echo "Esperando respuesta..";
                }
                socket_shutdown($sock, 2);
                socket_close($sock);
            } else {
                echo "socket_connect() falló: razón: " . socket_strerror(socket_last_error()) . "\n";
            }
        } catch (Exception $exc) {
            echo "Esperando respuesta..";
            if ($sock) {
                socket_shutdown($sock, 2);
                socket_close($sock);
            }
        }
    }

}
