<?php

defined("BASEPATH") or exit("No direct script access allowed");
header("Access-Control-Allow-Origin: *");
ini_set("memory_limit", "-1");
set_time_limit(300);

class Cpruebas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("form");
        $this->load->helper("url");
        $this->load->helper("security");
        $this->load->helper('download');
        $this->load->model("oficina/reportes/pruebas/Mpruebas");
        $this->load->library('Opensslencryptdecrypt');
        $this->load->dbutil();
        espejoDatabase();
    }

    public function index()
    {
        if ($this->session->userdata("IdUsuario") == "" || $this->session->userdata("IdUsuario") == "1024") {
            redirect("Cindex");
        }
        //        $rta ['informe'] = 'sonometro';
        $this->load->view('oficina/reportes/pruebas/Vstats_pruebas');
    }

    public function pruebasTipo()
    {
        $encrptopenssl = new Opensslencryptdecrypt();
        $json = $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
        $rta = json_decode($json);
        $tipoinforme = $this->input->post('tipoinformeval');
        $tipoinspeccion = $this->input->post('tipoinspeccion');
        $fechainicial = $this->input->post('fechainicial');
        $fechafinal = $this->input->post('fechafinal');
        $presionLlantas = $this->input->post('presionLlantas');
        if ($tipoinspeccion == 1) {
            $where = ('(h.reinspeccion=0 or h.reinspeccion=1)');
        } elseif ($tipoinspeccion == 4444) {
            $where = ('(h.reinspeccion=4444 or h.reinspeccion=44441)');
        } else {
            $where = ('h.reinspeccion=8888');
        }
        switch ($tipoinforme) {
            case 1:
                $rtarest = [];
                foreach ($rta as $item) {
                    if (($item->prueba == 'sonometro' && $item->activo == 1)) {
                        $idconf_maquina = $item->idconf_maquina;

                        $query = $this->Mpruebas->informe_sonometro($where, $idconf_maquina, $fechainicial, $fechafinal);

                        //                        $delimiter = ";";
                        //                        $newline = "\r\n";
                        //                        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
                        array_push($rtarest, $query);
                    }
                }
                $filename = 'Informe Sonometro';
                $this->informeAtalaya($rtarest, $filename, $idconf_maquina);
                //                $rta = '';
                //                
                //                $result = implode($rta, $rtarest);
                //                $this->download($filename, $result);
                break;
            case 3:
                $rtarest = [];
                foreach ($rta as $item) {

                    if (($item->prueba == 'luxometro' && $item->activo == 1)) {
                        $idconf_maquina = $item->idconf_maquina;


                        $query = $this->Mpruebas->informe_luces($where, $idconf_maquina, $fechainicial, $fechafinal);

                        //                        $delimiter = ";";
                        //                        $newline = "\r\n";
                        //                        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
                        array_push($rtarest, $query);
                    }
                }
                $filename = 'Informe Luxometro';
                $this->informeAtalaya($rtarest, $filename, $idconf_maquina);
                //                $rta = '';
                //                
                //                $result = implode($rta, $rtarest);
                //                $this->download($filename, $result);
                break;
            // $rtarest = [];
            // foreach ($rta as $item) {
            //     if (($item->prueba == 'luxometro' && $item->activo == 1)) {
            //         $idconf_maquina = $item->idconf_maquina;
            //         $query = $this->Mpruebas->informe_luces($where, $idconf_maquina, $fechainicial, $fechafinal);
            //         $delimiter = ";";
            //         $newline = "\r\n";
            //         $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
            //         array_push($rtarest, $data);
            //     }
            // }
            // $rta = '';
            // $filename = 'Informe Luxometro';
            // $result = implode($rta, $rtarest);
            // $this->download($filename, $result);
            // break;
            case 4:
                $rtarest = [];
                foreach ($rta as $item) {
                    if (($item->prueba == 'frenometro' && $item->activo == 1)) {
                        $idconf_maquina = $item->idconf_maquina;
                        $query = $this->Mpruebas->informe_frenos($where, $idconf_maquina, $fechainicial, $fechafinal);
                        $delimiter = ";";
                        $newline = "\r\n";
                        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
                        array_push($rtarest, $data);
                    }
                }
                $rta = '';
                $filename = 'Informe Frenos';
                $result = implode($rta, $rtarest);
                $this->download($filename, $result);
                break;
            case 5:
                $rtarest = [];
                foreach ($rta as $item) {
                    if (($item->prueba == 'suspension' && $item->activo == 1)) {
                        $idconf_maquina = $item->idconf_maquina;
                        $query = $this->Mpruebas->informe_suspension($where, $idconf_maquina, $fechainicial, $fechafinal);
                        $delimiter = ";";
                        $newline = "\r\n";
                        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
                        array_push($rtarest, $data);
                    }
                }
                $rta = '';
                $filename = 'Informe Suspension';
                $result = implode($rta, $rtarest);
                $this->download($filename, $result);
                break;
            case 6:
                $rtarest = [];
                foreach ($rta as $item) {
                    if (($item->prueba == 'alineador' && $item->activo == 1)) {
                        $idconf_maquina = $item->idconf_maquina;
                        $query = $this->Mpruebas->informe_alineador($where, $idconf_maquina, $fechainicial, $fechafinal);
                        $delimiter = ";";
                        $newline = "\r\n";
                        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
                        array_push($rtarest, $data);
                    }
                }
                $rta = '';
                $filename = 'Informe Alineador';
                $result = implode($rta, $rtarest);
                $this->download($filename, $result);
                break;
            case 7:
                $rtarest = [];
                foreach ($rta as $item) {
                    if (($item->prueba == 'taximetro' && $item->activo == 1)) {
                        $idconf_maquina = $item->idconf_maquina;
                        $query = $this->Mpruebas->informe_taximetro($where, $idconf_maquina, $fechainicial, $fechafinal);
                        $delimiter = ";";
                        $newline = "\r\n";
                        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
                        array_push($rtarest, $data);
                    }
                }
                $rta = '';
                $filename = 'Informe taximetro';
                $result = implode($rta, $rtarest);
                $this->download($filename, $result);
                break;
            case 8:
                $rta = $this->Mpruebas->getVisual($where, $fechainicial, $fechafinal, $presionLlantas);
                $this->codeDefectos($rta);
                break;
            case 9:
                $rtarest = [];
                foreach ($rta as $item) {
                    if (($item->prueba == 'analizador' && $item->activo == 1)) {
                        $idconf_maquina = $item->idconf_maquina;
                        $query = $this->Mpruebas->informe_th($where, $idconf_maquina, $fechainicial, $fechafinal);
                        $delimiter = ";";
                        $newline = "\r\n";
                        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
                        array_push($rtarest, $data);
                    }
                }
                $rta = '';
                $filename = 'Informe termohigrometro';
                $result = implode($rta, $rtarest);
                $this->download($filename, $result);
                break;
            default:
                break;
        }
    }

    private function download($filename, $result)
    {
        $nombre = $filename . '.csv';
        force_download($nombre, $result);
    }

    function tiempoPruebas()
    {
        $this->load->view('oficina/reportes/pruebas/Vtiempo_pruebas');
    }

    function gettiempoPruebas()
    {
        $fechainicial = $this->input->post('fechainicial');
        $fechafinal = $this->input->post('fechafinal');
        if ($fechainicial !== "" && $fechafinal !== "") {
            $where = "DATE_FORMAT(h.fechainicial,'%Y-%m-%d') BETWEEN '$fechainicial' AND '$fechafinal'";
            $rta = $this->Mpruebas->gettiempoPruebas($where);
            echo json_encode($rta);
        } else {
            $where = "DATE_FORMAT(h.fechainicial,'%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d')";
            $rta = $this->Mpruebas->gettiempoPruebas($where);
            echo json_encode($rta);
        }
    }

    function getCronAudit()
    {
        if ($this->session->userdata("idperfil") == 1 || $this->session->userdata("idperfil") == 3) {
            $rta = $this->Mpruebas->getCronAudit();
            echo json_encode($rta);
        }
    }

    function codeDefectos($rta)
    {
        $j = file_get_contents('./recursos/defectos.json');
        $json = json_decode(utf8_decode($j), true);
        $head = [];
        foreach ($rta as $val) {
            if ($val->tiporesultado == 'defecto') {
                foreach ($json as $v) {
                    if ($v['codigo'] == $val->valordefecto) {
                        $val->descripcion = $v['descripcion'];
                        $val->tipo = $v['tipo'];
                    } elseif ($v['codigotecmmas'] == $val->valordefecto) {
                        $val->descripcion = $v['descripcion'];
                        $val->tipo = $v['tipo'];
                    }
                }
            }
        }
        $val = (array) $rta[0];
        $head = array_keys($val);
        $name = "InformVisual";
        $this->getCsv($head, $name, $rta);
    }

    function informeAtalaya($query, $filename, $idconf_maquina)
{
    $json = [];
    $maquinaData = [];
    $head = [];
    $encrptopenssl = new Opensslencryptdecrypt();
    
    // Verificar si el archivo lineas.json existe ANTES de intentar leerlo
    $lineasFile = 'system/lineas.json';
    if (file_exists($lineasFile)) {
        $j = $encrptopenssl->decrypt(file_get_contents($lineasFile));
        $json = json_decode(utf8_decode($j), true) ?: [];
    }

    $maquinaFile = 'system/' . $idconf_maquina . '.json';
    if (file_exists($maquinaFile)) {
        $ma = $encrptopenssl->decrypt(file_get_contents($maquinaFile));
        if ($ma !== false) {
            $maquinaData = json_decode(utf8_decode($ma), true) ?: [];
        }
    }

    if (!empty($json)) {
        foreach ($query as $val) {
            foreach ($json as $v) {
                if ($v['idconf_maquina'] == $idconf_maquina) {
                    if (isset($val->Serie_analizador)) {
                        $val->Serie_analizador = strtoupper($v['serie_maquina']);
                    }
                    if (isset($val->Marca_analizador)) {
                        $val->Marca_analizador = strtoupper($v['marca']);
                    }
                    if (isset($val->Modelo)) {
                        $val->Modelo = strtoupper($v['serie_banco']);
                    }
                }
            }
        }
    }

    // CORREGIDO: Extraer encabezados del primer elemento correctamente
    if (!empty($query)) {
        // Tomar el primer elemento del query, sin importar la estructura exacta
        $firstElement = null;
        
        if (isset($query[0]) && is_object($query[0])) {
            $firstElement = $query[0];
        } else if (isset($query[0][0]) && is_object($query[0][0])) {
            $firstElement = $query[0][0];
        } else if (isset($query[1][0]) && is_object($query[1][0])) {
            $firstElement = $query[1][0];
        } else {
            // Si no encontramos la estructura esperada, usar el primer elemento disponible
            $firstElement = reset($query);
            if (is_array($firstElement) && isset($firstElement[0])) {
                $firstElement = $firstElement[0];
            }
        }
        
        if ($firstElement && is_object($firstElement)) {
            $val = (array) $firstElement;
            $head = array_keys($val);
        } else {
            // Si todo falla, usar encabezados por defecto basados en la estructura conocida
            $head = ['Serie_analizador', 'Marca_analizador', 'Modelo', /* añade más campos según necesites */];
        }
    }

    $this->getCsv2($head, $filename, $query);
}

    function getCsv($head, $name, $rta)
    {
        if (empty($fileName)) {
            $fileName = $name . date('Y-m-d H:i:s');
        }
        header('Content-type: application/csv');
        header('Content-Transfer-Encoding: binary; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $fileName . '.csv');
        $fp = fopen("php://output", 'w');
        fputcsv($fp, (array) $head, ";");
        foreach ($rta as $d) {
            //foreach ($d as $v) {
            ////                echo "<pre>";
            ////                var_dump($v);
            ////                echo "</pre>";
            fputcsv($fp, (array) $d, ";");
            //}

            //fputcsv($fp, (array) $d, ";");
        }
        exit();
    }
    function getCsv2($head, $name, $rta)
    {
        if (empty($fileName)) {
            $fileName = $name . date('Y-m-d H:i:s');
        }
        header('Content-type: application/csv');
        header('Content-Transfer-Encoding: binary; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $fileName . '.csv');
        $fp = fopen("php://output", 'w');
        fputcsv($fp, (array) $head, ";");
        foreach ($rta as $d) {
            foreach ($d as $v) {
                fputcsv($fp, (array) $v, ";");
            }

            //fputcsv($fp, (array) $d, ";");
        }
        exit();
    }

    function pruebasCliente()
    {
        $this->load->view('oficina/reportes/pruebas/VpruebasCliente');
    }

    function getPruebasCliente()
    {
        $fechainicial = $this->input->post('fechainicial');
        $fechafinal = $this->input->post('fechafinal');
        if ($fechainicial !== "" && $fechafinal !== "") {
            $where = "DATE_FORMAT(h.fechainicial,'%Y-%m-%d') BETWEEN '$fechainicial' AND '$fechafinal'";
            $rta = $this->Mpruebas->getPruebasCliente($where);
            echo json_encode($rta);
        } else {
            $where = "DATE_FORMAT(h.fechainicial,'%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d')";
            $rta = $this->Mpruebas->getPruebasCliente($where);
            echo json_encode($rta);
        }
    }
}
