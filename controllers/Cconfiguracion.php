<?php

defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
ini_set('memory_limit', '-1');
set_time_limit(0);

class Cconfiguracion extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model("domain/CDAModel");
        $this->load->model("dominio/Mvehiculo");
        $this->load->model("dominio/Mconfig_prueba");
        $this->load->model("Mutilitarios");
        $this->load->library('Opensslencryptdecrypt');
        //espejoDatabase();
    }
    var $sistemaOperativo = "";

    public function index()
    {
        if ($this->session->userdata('IdUsuario') == '') {
            redirect('Cindex');
        }
    }

    public function getCda()
    {
        $cda = $this->CDAModel->get(1);
        echo $cda->nombre_cda;
    }

    public function getMac()
    {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $macAddr = false;
        $arp = `arp -a $ipAddress`;
        $lines = explode("\n", $arp);
        foreach ($lines as $line) {
            $cols = preg_split('/\s+/', trim($line));
            if ($cols[0] == $ipAddress) {
                $macAddr = $cols[1];
            }
        }

        echo utf8_encode($macAddr);
    }

    public function getMacServer()
    {
        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {

            $MAC = shell_exec('ifconfig | grep ether');

            $MAC = explode("ether", $MAC);
            $MAC = strtok($MAC[1], " ");
        } else {
            $MAC = exec('getmac | findstr "Device"');
            $MAC = strtok($MAC, ' ');
        }
        //$MAC = shell_exec('getmac | findstr "Device"');
        //        $MAC = exec('getmac | findstr "Device"');
        //        echo "00-15-5d-92-33-54";
        echo utf8_encode(strtolower($MAC));
    }

    public function getConfMaquina()
    {
        $encrptopenssl = new Opensslencryptdecrypt();
        $file = 'system/' . $this->input->post('idmaquina') . '.json';
        if (file_exists($file)) {
            echo $encrptopenssl->decrypt(file_get_contents($file, true));
        } else {
            echo "err";
        }
    }

    public function saveDominio()
    {
        $archivo = fopen("system/dominio.dat", "w+b");
        fwrite($archivo, $this->input->post('dominio'));
        fclose($archivo);
    }

    public function getDominio()
    {
        if (file_exists('system/dominio.dat')) {
            $dominio = file_get_contents('system/dominio.dat', true);
        } else {
            $dominio = "";
        }
        echo $dominio;
    }

    public function getFechaArchivo()
    {
        $archivo = str_replace("-", "/", $this->input->post('archivo'));
        if (file_exists($archivo)) {
            echo date("Y-m-d H:i:s", filemtime($archivo));
        } else {
            echo 'No registra';
        }
    }

    public function getActualizacionArchivoNew()
    {
        $tipo = $this->input->post('tipo');
        $url2 = $this->input->post('url');
        $datos = $this->input->post('datos');
        try {
            //$url = "http://" . $url2 . "/cda/index.php/Cservicio/getLineas";
            //            if (!$data = @file_get_contents($url)) {
            //                //Trapping
            //            } else {
            $archivo = fopen("system/lineas.json", "w+b");
            fwrite($archivo, $datos);
            fclose($archivo);
            $encrptopenssl = new Opensslencryptdecrypt();
            $json = $encrptopenssl->decrypt($datos, true);
            $dat = json_decode($json, true);
            foreach ($dat as $d) {
                if (strpos($d['nombre'], $tipo) !== false || str_replace('_', ' ', $tipo) == $d['nombre']) {
                    //                    if (str_replace('_', ' ', $tipo) == $d['nombre']) {
                    if ($d['nombre'] == 'oficina') {

                        $this->setConfOfc($url2, $d['idconf_maquina']);
                    } else {
                        $this->setConfMaquina($url2, $d['idconf_maquina']);
                        //                            $archivo2 = fopen("system/" + $d['nombre'] + ".dat", "w+b");
                        //                            echo $tipo;
                        $archivo2 = fopen("system/" . $tipo . ".dat", "w+b");
                        fwrite($archivo2, '1');
                        fclose($archivo2);
                    }
                }
                //                        usleep(100);
            }
            //            }
        } catch (Exception $exc) {
            //            echo '0001';
        }
    }

    //    public function getActualizacionArchivo() {
    //        $tipo = $this->input->post('tipo');
    //        $url2 = $this->input->post('url');
    //        try {
    //            $url = "http://" . $url2 . "/cda/index.php/Cservicio/getLineas";
    //            if (!$data = @file_get_contents($url)) {
    //                //Trapping
    //            } else {
    //                $archivo = fopen("system/lineas.json", "w+b");
    //                fwrite($archivo, file_get_contents($url));
    //                fclose($archivo);
    //                $encrptopenssl = New Opensslencryptdecrypt();
    //                $json = $encrptopenssl->decrypt($data, true);
    //                $dat = json_decode($json, true);
    //                foreach ($dat as $d) {
    //                    if (strpos($d['nombre'], $tipo) !== false || str_replace('_', ' ', $tipo) == $d['nombre']) {
    ////                    if (str_replace('_', ' ', $tipo) == $d['nombre']) {
    //                        if ($d['nombre'] == 'oficina') {
    //
    //                            $this->setConfOfc($url2, $d['idconf_maquina']);
    //                        } else {
    //                            $this->setConfMaquina($url2, $d['idconf_maquina']);
    ////                            $archivo2 = fopen("system/" + $d['nombre'] + ".dat", "w+b");
    ////                            echo $tipo;
    //                            $archivo2 = fopen("system/" . $tipo . ".dat", "w+b");
    //                            fwrite($archivo2, '1');
    //                            fclose($archivo2);
    //                        }
    //                    }
    ////                        usleep(100);
    //                }
    //            }
    //        } catch (Exception $exc) {
    ////            echo '0001';
    //        }
    //    }

    public function getActualizacionParametro()
    {
        switch ($this->input->post('tipo')) {
            case 'ActLineas':
                $this->Mvehiculo->CrearRegistroRunt();
                $this->Mvehiculo->addColumFVS();
                $this->Mvehiculo->addchk_3();
                $this->Mvehiculo->addColumnFFCert();
                $this->Mvehiculo->CrearTablaMarca();
                $this->Mvehiculo->CrearTablaLinea();
                $this->Mvehiculo->CrearTablaColor();
                //                $this->Mvehiculo->CrearDispatadoresRUNT();
                $this->Mvehiculo->quitarAILinea();
                $this->Mvehiculo->CrearTablaObservaciones();
                $r = $this->Mvehiculo->getVehiculoRegistroRunt1();
                $veh = $r->result();
                $lineas = json_decode(file_get_contents('application/libraries/linea.json'), true);
                foreach ($lineas as $l) {
                    foreach ($veh as $v) {
                        if ($v->nombre == $l["nombre"]) {
                            $this->Mvehiculo->actualizarIdlineaRunt($v->idlinea, $l["idlinea"]);
                        }
                    }
                }
                $this->Mvehiculo->borrarLineaRunt();
                $r = $this->Mvehiculo->getVehiculoRegistroRunt2();
                $veh = $r->result();
                foreach ($lineas as $l) {
                    foreach ($veh as $v) {
                        if ($v->idlinea == $l["idlinea"]) {
                            $linearunt['idlineaRUNT'] = $l["idlinea"];
                            $linearunt['idmarcaRUNT'] = $l["idmarca"];
                            $linearunt['codigo'] = $l["codigo"];
                            $linearunt['nombre'] = $l["nombre"];
                            $this->Mvehiculo->insertarLineaRunt_($linearunt);
                        }
                    }
                }
                break;
            default:
                break;
        }
    }

    public function configurarTablas()
    {
        $this->Mutilitarios->addColumn('vehiculos', 'num_pasajeros', 'fecha_final_certgas', 'INT(11)');
        $this->Mutilitarios->addColumn('vehiculos', 'convertidor', 'num_pasajeros', 'TINYINT(1)');
        $this->Mutilitarios->addColumn('hojatrabajo', 'llamar', 'sicov', 'TINYINT(1)');
        //        $this->Mutilitarios->addTableResulAudit();
        //        $this->Mutilitarios->addTablePruebAudit();
        //        $this->Mutilitarios->addColumn('pruebas','auditoria','idtipo_prueba','TEXT');
        //        $this->Mutilitarios->addColumn('resultados','auditoria','idconfig_prueba','TEXT');
        $this->Mutilitarios->confTriggerAuditoria();
        $this->Mutilitarios->confTriggerResultados();
        $this->Mutilitarios->confFechaGuardado();
        $this->setMaqAuditoria();
        $this->Mutilitarios->addTableCronAudit();
        $this->Mutilitarios->confAuditoriaSICOV();
    }

    public function setConfMaquina($url, $idconf_maquina)
    {
        try {
            $url = "https://" . $url . "/cda/index.php/Cservicio/getConfMaquina?idmaquina=" . $idconf_maquina;

            $archivo = fopen("system/" . $idconf_maquina . ".json", "w+b");
            $context = stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ]);
            fwrite($archivo, file_get_contents($url, false, $context));
            fclose($archivo);
            // if (!$data = @file_get_contents($url)) {
            //     echo '0001';
            // } else {
            //     fwrite($archivo, file_get_contents($url));
            //     fclose($archivo);
            // }
        } catch (Exception $exc) {
            echo '0001';
        }
    }

    public function setConfOfc($url, $idconf_maquina)
    {
        try {
            $url = "https://" . $url . "/cda/index.php/Cservicio/getConfMaquina?idmaquina=" . $idconf_maquina;
            $archivo = fopen("system/oficina.json", "w+b");

            $context = stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ]);
            fwrite($archivo, file_get_contents($url, false, $context));
            fclose($archivo);
            // echo file_get_contents($url, false, $context);
            // echo file_get_contents($url);
        } catch (Exception $exc) {
            echo '0000';
        }
    }

    public function verConfiguracion()
    {
        $tipo = $this->input->post('tipo');
        $datos = "";
        $encrptopenssl = new Opensslencryptdecrypt();
        $lineas = json_decode($encrptopenssl->decrypt(file_get_contents('system/lineas.json', true)), true);
        //                var_dump($lineas);
        foreach ($lineas as $l) {
            $maq = $l['nombre'];
            $maq = explode("_", $maq);
            if (strpos($maq[0], $tipo) !== false || str_replace('_', ' ', $tipo) == $maq[0]) {
                //            if (str_replace('_', ' ', $tipo) == $maq[0]) {
                if ($tipo == 'oficina') {
                    $datos = $datos . $this->getDatMaquina('oficina', $l['idconf_linea_inspeccion'], $l['marca'], $l['serie_maquina'], $l['serie_banco'], $maq[0]);
                } else {
                    $datos = $datos . $this->getDatMaquina($l['idconf_maquina'], $l['idconf_linea_inspeccion'], $l['marca'], $l['serie_maquina'], $l['serie_banco'], $maq[0]);
                }
            }
        }
        echo $datos;
    }

    private function getDatMaquina($idmaquina, $tipolinea, $marca, $serie, $referencia, $nombre)
    {
        $dato = "";
        $encrptopenssl = new Opensslencryptdecrypt();
        $maquina = json_decode($encrptopenssl->decrypt(file_get_contents('system/' . $idmaquina . '.json', true)), true);
        //        var_dump($maquina);
        $nombreLinea = "";
        switch ($tipolinea) {
            case '1':
                $nombreLinea = 'Livianos';
                break;
            case '2':
                $nombreLinea = 'Pesados';
                break;
            case '3':
                $nombreLinea = 'Motos';
                break;
            case '4':
                $nombreLinea = 'Mixta';
                break;
            case '5':
                $nombreLinea = 'Administrativa';
                break;
            case '6':
                $nombreLinea = 'Movil';
                break;
            case '7':
                $nombreLinea = 'Liviano1';
                break;
            case '8':
                $nombreLinea = 'Liviano2';
                break;
            case '9':
                $nombreLinea = 'Moto1';
                break;
            case '10':
                $nombreLinea = 'Moto2';
                break;
            case '11':
                $nombreLinea = 'Mixta1';
                break;
            case '12':
                $nombreLinea = 'Mixta2';
                break;
            default:
                break;
        }
        foreach ($maquina as $m) {
            $dato = $dato . "<tr>"
                . "<td>$idmaquina</td>"
                . "<td>$nombreLinea</td>"
                . "<td>$nombre</td>"
                . "<td>$marca</td>"
                . "<td>$serie</td>"
                . "<td>$referencia</td>"
                . "<td>" . $m['nombre'] . "</td>"
                . "<td>" . $m['valor'] . "</td>"
                . "<td>" . $m['descripcion'] . "</td>"
                . "</tr>";
        }
        return $dato;
    }

    public function getLineasInspeccion()
    {
        $encrptopenssl = new Opensslencryptdecrypt();
        echo $encrptopenssl->decrypt(file_get_contents('system/lineas.json', true));
    }

    public function getMaquinaId()
    {
        $encrptopenssl = new Opensslencryptdecrypt();
        
        $maquina = json_decode($encrptopenssl->decrypt(file_get_contents('system/' . $this->input->post('idmaquina') . '.json', true)), true);
        echo json_encode($maquina);
    }

    public function setMaqAuditoria()
    {
        $encrptopenssl = new Opensslencryptdecrypt();
        $maquinas = json_decode($encrptopenssl->decrypt(file_get_contents('system/lineas.json', true)));
        $idCdaRUNT = "";
        $idruntYa = false;
        foreach ($maquinas as $m) {
            $idmaquina = $m->idconf_maquina;
            if (file_exists('system/' . $idmaquina . '.json')) {
                $serial = $m->serie_maquina;
                if ($m->conf_idtipo_prueba == 5 || $m->conf_idtipo_prueba == 8) {
                    $serial = $m->serie_banco;
                }
                $maquina = json_decode($encrptopenssl->decrypt(file_get_contents('system/' . $idmaquina . '.json', true)), true);
                $ip = "xxx.xxx.xxx.xxx";
                foreach ($maquina as $mq) {
                    if ($mq["nombre"] == 'ip')
                        $ip = $mq["valor"];
                }
                $data['idconfig_prueba'] = intval($idmaquina) + 10000;
                $data['idconfiguracion'] = '34';
                $data['valor'] = $ip;
                $data['descripcion'] = 'ip maquina';
                $data['adicional'] = '';
                $this->Mconfig_prueba->insert($data);
                $data['idconfig_prueba'] = intval($idmaquina) + 20000;
                $data['valor'] = $serial;
                $data['descripcion'] = 'serial maquina';
                $this->Mconfig_prueba->insert($data);
            }
        }

        if (file_exists('system/oficina.json')) {
            $maquina = json_decode($encrptopenssl->decrypt(file_get_contents('system/oficina.json', true)), true);
            foreach ($maquina as $mq) {
                if ($mq["nombre"] == 'idCdaRUNT') {
                    $idCdaRUNT = $mq["valor"];
                    $data['idconfig_prueba'] = 8754;
                    $data['idconfiguracion'] = '34';
                    $data['valor'] = $idCdaRUNT;
                    $data['descripcion'] = 'idrunt';
                    $data['adicional'] = '';
                    $this->Mconfig_prueba->insert($data);
                }
            }
        }
    }

    public function getDia()
    {
        $dia = strval($this->Mutilitarios->getNow());
        $dia = str_replace("-", "", $dia);
        $dia = substr($dia, 0, 8);
        return $dia;
    }

    function decrypt($string)
    {
        $key = hash('sha256', $this->secret_key);
        $iv = substr(hash('sha256', $this->secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $this->encrypt_method, $key, 0, $iv);
        return $output;
    }
}
