<?php

defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

//Esta clase se encargad e descargar la configuración desde la cuenta del CDA 
//en el servidor Atalaya ARI
class CbajarConfiguracion extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("Mutilitarios");
        $this->load->model("Mcliente");
        $this->load->library('Opensslencryptdecrypt');
        //espejoDatabase();
    }

    public function index()
    {
        if ($this->session->userdata('IdUsuario') == '') {
            redirect('Cindex');
        }
    }

    //Este metodo convoca el formato de prerevisión para establecerlo en los 
    //dispostivos móviles.
    public function getConfPrerevision()
    {
        $url = "http://" . $this->input->post("dominio") . "/cda/index.php/Cservicio/getInformePrerevision";
        $archivo = fopen("recursos/prerevision.json", "w+b");
        if (!$data = file_get_contents($url)) {
            echo '0001';
        } else {
            fwrite($archivo, file_get_contents($url));
            fclose($archivo);
            echo "0000";
        }
    }

    //Obtiene la lista de los datos de las tablas paramétrica del RUNT basandose
    //en el nombre de la lista
    public function getTablasParamRUNT()
    {
        $this->setFileParam("tablasparamrunt/carroceria"); //Trae la lista de carroceria
        $this->setFileParam("tablasparamrunt/ciudad"); //Trae la lista de ciudad
        $this->setFileParam("tablasparamrunt/clase"); //Trae la lista de la clase del vehículo
        $this->setFileParam("tablasparamrunt/color"); //Trae la lista del color del vehículo
        $this->setFileParam("tablasparamrunt/combustible"); //Trae la lista del tipo de combustible
        $this->setFileParam("tablasparamrunt/linea"); //Trae la lista de la linea del vehículo
        $this->setFileParam("tablasparamrunt/marca"); //Trae la lista de la marca del vehículo
        $this->setFileParam("tablasparamrunt/pais"); //Trae la lista del pais del vehículo
        $this->setFileParam("tablasparamrunt/servicio"); //Trae la lista delservicio del vehículo
    }

    public function getSensorial()
    {
        $this->setFileParam("general/sensorial"); //Trae la lista delservicio del vehículo
    }

    //Este metodo carga desde la url de la página directamente los tablas parametricas
    //del RUNT de manera centralizada.
    private function setFileParam($nombre)
    {
        $url = "http://www.tecmmas.com/$nombre.json";
        $ar = explode("/", $nombre);
        $archivo = fopen("recursos/$ar[1].json", "w+b");
        fwrite($archivo, file_get_contents($url));
        fclose($archivo);
    }

    //Obtiene una configuración específica basado en el dominio y la funcion que 
    //se convoca desde la aplicación
    // public function getConf() {
    //     try {
    //         $url = "https://" . $this->input->post("dominio") . "/cda/index.php/Cservicio/" . $this->input->post("funcion");
    //         // var_dump(file_get_contents($url));
    //         if (!$data = file_get_contents($url)) {
    //             echo '0001';
    //         } else {
    //             $archivo = fopen("system/" . $this->input->post("file") . ".json", "w+b");
    //             fwrite($archivo, file_get_contents($url));
    //             fclose($archivo);
    //             echo "0000";
    //         }
    //     } catch (Exception $exc) {
    //         echo '0001';
    //     }
    // }
    public function getConf()
    {
        try {
            $url = "https://" . $this->input->post("dominio") . "/cda/index.php/Cservicio/" . $this->input->post("funcion");
            $data = file_get_contents($url);
            $res = strpos($data, "Warning");
            if ($res == false || $res == "") {
                if (!$data) {
                    echo '0001';
                } else {
                    if ($data !== "" && $data !== null && $data !== '') {
                        $archivo = fopen("system/" . $this->input->post("file") . ".json", "w+b");
                        fwrite($archivo, $data);
                        fclose($archivo);
                    }
                    echo "0000";
                }
                
            } else {
                echo "0005";
            }
        } catch (Exception $exc) {
            echo '0001';
        }
    }


    public function getConfLicencia()
    {
        //        try {
        //            $url = "https://" . $this->input->post("dominio") . "/cda/index.php/Cservicio/" . $this->input->post("funcion");
        //            // var_dump(file_get_contents($url));
        //            if (!$data = file_get_contents($url)) {
        //                echo '0001';
        //            } else {
        $archivo = fopen("system/license.json", "w+b");
        fwrite($archivo, $this->input->post("dato"));
        fclose($archivo);
        echo "0000";
        //            }
        //        } catch (Exception $exc) {
        //            echo '0001';
        //        }
    }

    public function getDominio()
    {
        echo file_get_contents('system/dominio.dat', true);
    }

    //Obtiene la configuración de los datos de la máquina
    public function getConfMaquina()
    {
        try {
            $url = "https://" . $this->input->post("dominio") . "/cda/index.php/Cservicio/" . $this->input->post("funcion") . "?idmaquina=" . $this->input->post("file");
            $archivo = fopen("system/" . $this->input->post("file") . ".json", "w+b");
            if (!$data = file_get_contents($url)) {
                echo '0001';
            } else {
                fwrite($archivo, file_get_contents($url));
                fclose($archivo);
                echo "0000";
            }
        } catch (Exception $exc) {
            echo '0001';
        }
    }
}
