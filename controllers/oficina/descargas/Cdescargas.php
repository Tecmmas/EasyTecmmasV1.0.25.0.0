<?php

defined("BASEPATH") or exit("No direct script access allowed");
header("Access-Control-Allow-Origin: *");
ini_set("memory_limit", "-1");
set_time_limit(300);

class Cdescargas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("form");
        $this->load->helper("url");
        $this->load->helper("security");
        $this->load->helper('download');
        espejoDatabase();
    }

    var $sistemaOperativo = "";

    public function index()
    {
        if ($this->session->userdata("IdUsuario") == "" || $this->session->userdata("IdUsuario") == "1024") {
            redirect("Cindex");
        }
        //        $url = 'http://updateapp.tecmmas.com/actualizaciones.json';
        //        $archivo = fopen('system/actualizaciones.json', "w+b");
        //        fwrite($archivo, file_get_contents($url, 0, stream_context_create(["http"=>["timeout"=>1]])));
        //        fclose($archivo);
        //        
        //        $json = file_get_contents('system/actualizaciones.json', true);
        //        $rta ['actu'] = json_decode($json);
        //        $from = "C:/Apache24/htdocs/et/application/EasyTecmmasV1.0.12";
        $this->load->view('oficina/descargas/Vdescargas');
    }

    public function getJson()
    {
        $archivo = fopen('system/actualizaciones.json', "w+b");
        fwrite($archivo, $this->input->post('json'));
        fclose($archivo);
        echo json_encode(1);
    }



    //    function getDescripcion() {
    //        $idactualizacion = $this->input->post('idactualizacion');
    //        $json = file_get_contents('system/actualizaciones.json', true);
    //        $rta = json_decode($json);
    //        foreach ($rta as $value) {
    //            if ($idactualizacion == $value->id) {
    //                $descripcion = $value->descripcion;
    //            }
    //        }
    //        echo json_encode($descripcion);
    //    }

    public function Getactualizacion()
    {
        $url = $this->input->post('url');
        $file = $this->input->post('file');
        $version = $this->input->post('version');
        //        $json = file_get_contents('system/actualizaciones.json', true);
        //        $rta = json_decode($json);
        //        foreach ($rta as $value) {
        //            if ($idactualizacion == $value->id) {
        //                $url = $value->url;
        //                $file = $value->file;
        //                $version = $value->version;
        //            }
        //        }
        $this->createbatgit($url, $file, $version);
        echo json_encode(1);
    }

    private function createbatgit($url, $file, $version)
    {
        $this->sistemaOperativo = sistemaoperativo();

        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            $data = '/var/www/html/et/application';
            $scriptPath = '/var/www/html/et/system/dwngit.sh';

            // Sanitizar y limpiar la URL
            $url = trim($url);
            $url = rtrim($url, '?/'); // Eliminar cualquier ?/ al final

            // Crear contenido del script con formato adecuado
            $cadena = "#!/bin/bash\n";
            $cadena .= "set -e\n"; // Detener ante errores
            $cadena .= "mkdir -p " . escapeshellarg($data) . "\n";
            $cadena .= "cd " . escapeshellarg($data) . " || exit 1\n";
            $cadena .= "git clone " . escapeshellarg($url) . " " . escapeshellarg($file) . "\n";
            $cadena .= "exit $?\n";

            // Guardar archivo asegurando formato UNIX
            file_put_contents($scriptPath, $cadena);

            // Forzar permisos y formato correcto
            chmod($scriptPath, 0755);
            exec("dos2unix " . escapeshellarg($scriptPath) . " 2>/dev/null");

            // Ejecutar y capturar salida
            $out = shell_exec('/bin/bash ' . escapeshellarg($scriptPath) . ' 2>&1');
            // $data = '/var/www/html/et/application';
            // $cadena = "cd $data
            //     git init
            //     git clone $url
            //     exit";
            // $archivo = fopen('system/dwngit.sh', "w+b");
            // fwrite($archivo, $cadena);
            // fclose($archivo);
            // $out = shell_exec('bash /var/www/html/et/system/dwngit.sh');
             $to = "/var/www/html/et/application/";
            // $from = "/var/www/html/et/application/$file";
        } else {
            $data = 'C:\Apache24\htdocs\et\application';
            $cadena = "cd $data
                git init
                git clone $url
                exit";
            $archivo = fopen('system/dwngit.bat', "w+b");
            fwrite($archivo, $cadena);
            fclose($archivo);
            $out = shell_exec('start C:/Apache24/htdocs/et/system/dwngit.bat');
            $to = '"C:/Apache24/htdocs/et/application"';
            $from = "C:/Apache24/htdocs/et/application/$file";
        }

        $this->getfoldercop($to, $file, $version);
        /*  if (file_exists($from)) {
           
        } else {
            $this->error("Lo sentimos el archivo no se pudo descargar, por favor comunicate con el area de soporte para validar." . $out);
        }  */
    }

    public function getfoldercop($to, $file, $version)
    {
        $this->sistemaOperativo = sistemaoperativo();

        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {

            
            $from = "/var/www/html/et/application/$file/";
            $cadena = "rsync -av $from $to";
            $permiso = "chmod -R 777 /var/www/html/et/application/$file";

            
            // echo $permiso . "<br>";
            $o = [];
            $var = 0;
            exec($permiso, $o, $var);

            $output = [];
            $return_var = 0;
            exec($cadena, $output, $return_var);
           

            $borrar = "rm -rf /var/www/html/et/application/$file";
            $output2 = [];
            $return_var2 = 0;
            exec($borrar, $output2, $return_var2);
        } else {
            $from = '"' . "C:/Apache24/htdocs/et/application/$file" . '"';
            $cadena = "Xcopy  /e /y $from $to";
            shell_exec($cadena);
            $d = "cd C:/Apache24/htdocs/et/application
                     RD /S /Q $file
                    exit";
            $archivo = fopen('system/deletFolder.bat', "w+b");
            fwrite($archivo, $d);
            fclose($archivo);
            shell_exec('start C:/Apache24/htdocs/et/system/deletFolder.bat');
        }
        $dominio = file_get_contents('system/dominio.dat', true);
        $url = 'http://updateapp.tecmmas.com/Actualizaciones/index.php/Cactualizaciones/updateVersion' . '?dominio=' . $dominio . '&version=' . $version;
        file_get_contents($url);
        //        redirect("Cindex");
    }

    private function error($mensaje)
    {
        $this->session->set_flashdata('error', $mensaje);
        redirect("oficina/descargas/Cdescargas");
    }
}
