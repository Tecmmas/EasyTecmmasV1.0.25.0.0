<?php

defined("BASEPATH") OR exit("No direct script access allowed");
header("Access-Control-Allow-Origin: *");
ini_set("memory_limit", "-1");
set_time_limit(300);

class Cestadisticos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper("form");
        $this->load->helper("url");
        $this->load->helper("security");
        $this->load->helper('download');
        $this->load->library('TCPDF');
        $this->load->model("oficina/reportes/estadisticos/Mestadisticos");
        $this->load->library('zip');
        $this->load->helper('download');
        $this->load->dbutil();
        espejoDatabase();
    }

    public function index() {
        $this->load->view('oficina/reportes/estadisticos/Vestadisticos');
    }

    public function getReporte() {
        date_default_timezone_set('America/bogota');
        $date = date("Y-m-d H-i-s");
        $idreporte = $this->input->post('idreporte');
        $fechainicial = $this->input->post('fechainicial');
        $fechafinal = $this->input->post('fechafinal');
        $fechaperdidos = $this->input->post('fechaperdidos');
        switch ($idreporte) {
            case 1:
                $json = file_get_contents('recursos/defectos.json', true);
                $data ['defectos'] = json_decode($json);
                $data ['titulo'] = strtoupper('Informe lista de defectos');
                $data ['fechageneracion'] = date("Y-m-d H:i:s");
                $data['nombreCda'] = $this->Mestadisticos->getNombreCda();
                $this->load->view('oficina/reportes/estadisticos/Vpdf_lista_defectos', $data);
                break;
            case 2:
                $data ['titulo'] = strtoupper('Informe facturacion diaria');
                $data ['fechageneracion'] = date("Y-m-d H:i:s");
                $data ['fechainicial'] = $fechainicial;
                $data ['fechafinal'] = $fechafinal;
                $data['nombreCda'] = $this->Mestadisticos->getNombreCda();
                $rta = $this->Mestadisticos->facturacion_diaria($fechainicial, $fechafinal);
                $data ['datos'] = $rta->result();
                $this->load->view('oficina/reportes/estadisticos/Vpdf_facturacion_diaria', $data);
                break;
            case 3:
                $data ['titulo'] = strtoupper('Inspecciones por defecto');
                $data ['fechageneracion'] = date("Y-m-d H:i:s");
                $data ['fechainicial'] = $fechainicial;
                $data ['fechafinal'] = $fechafinal;
                $data['nombreCda'] = $this->Mestadisticos->getNombreCda();
                $rta = $this->Mestadisticos->inspecciones($fechainicial, $fechafinal);
                $data ['inspecciones'] = $rta->result();
                $this->load->view('oficina/reportes/estadisticos/Vpdf_mapa_inspecciones_defecto', $data);
                break;
            case 4:
                $data ['titulo'] = strtoupper('Resumen diario de servicio');
                $data ['fechageneracion'] = date("Y-m-d H:i:s");
                $data ['fechainicial'] = $fechainicial;
                $data ['fechafinal'] = $fechafinal;
                $data ['fechai'] = strtotime($fechainicial);
                $data ['fechaf'] = strtotime($fechafinal);
                $data['nombreCda'] = $this->Mestadisticos->getNombreCda();
                $this->load->view('oficina/reportes/estadisticos/Vpdf_resumen_diario_servicio', $data);
                break;
            case 5:
                $data ['titulo'] = strtoupper('Mapa de servicios entre fechas');
                $data ['fechageneracion'] = date("Y-m-d H:i:s");
                $data ['fechainicial'] = $fechainicial;
                $data ['fechafinal'] = $fechafinal;
                $data ['fechai'] = strtotime($fechainicial);
                $data ['fechaf'] = strtotime($fechafinal);
                $data['nombreCda'] = $this->Mestadisticos->getNombreCda();
                $this->load->view('oficina/reportes/estadisticos/Vpdf_mapa_servicios_entre_fechas', $data);
                break;
            case 6:
                $data ['titulo'] = strtoupper('Lista de defectos por inspector');
                $data ['fechageneracion'] = date("Y-m-d H:i:s");
                $data ['fechainicial'] = $fechainicial;
                $data ['fechafinal'] = $fechafinal;
                $data ['fechai'] = strtotime($fechainicial);
                $data ['fechaf'] = strtotime($fechafinal);
                $data['nombreCda'] = $this->Mestadisticos->getNombreCda();
                $rta = $this->Mestadisticos->lista_defectos_inspector($fechainicial, $fechafinal);
                $data ['inspectores'] = $rta->result();
                $this->load->view('oficina/reportes/estadisticos/Vpdf_lista_defectos_inspector', $data);
                break;
            case 7:
                $data ['titulo'] = strtoupper('Inspector/categoria descriminada');
                $data ['fechageneracion'] = date("Y-m-d H:i:s");
                $data ['fechainicial'] = $fechainicial;
                $data ['fechafinal'] = $fechafinal;
                $data ['fechai'] = strtotime($fechainicial);
                $data ['fechaf'] = strtotime($fechafinal);
                $data['nombreCda'] = $this->Mestadisticos->getNombreCda();
                $rta = $this->Mestadisticos->inspectores($fechainicial, $fechafinal);
                $data ['inspectores'] = $rta->result();
                $this->load->view('oficina/reportes/estadisticos/Vpdf_inspector_categoria_descriminada', $data);
                break;
            case 8:
                $data ['titulo'] = strtoupper('Lista de provisiones de servicios');
                $data ['fechageneracion'] = date("Y-m-d H:i:s");
                $data ['fechainicial'] = $fechainicial;
                $data ['fechafinal'] = $fechafinal;
                $data['nombreCda'] = $this->Mestadisticos->getNombreCda();
                $rta = $this->Mestadisticos->lista_provisiones($fechainicial, $fechafinal);
                $data ['listagem'] = $rta->result();
                $this->load->view('oficina/reportes/estadisticos/Vpdf_lista_provisiones_servicio', $data);
                break;
            case 9:
                $data ['titulo'] = strtoupper('Aprobados rechazados por año de matricula');
                $data ['fechageneracion'] = date("Y-m-d H:i:s");
                $data ['fechainicial'] = $fechainicial;
                $data ['fechafinal'] = $fechafinal;
                $data['nombreCda'] = $this->Mestadisticos->getNombreCda();
                $data['ai1993'] = $this->Mestadisticos->aprobadosInspeccion("<= '1993'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['ri1993'] = $this->Mestadisticos->rechazadosInspeccion("<= '1993'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['ar1993'] = $this->Mestadisticos->aprobadosReinspeccion("<= '1993'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['rr1993'] = $this->Mestadisticos->rechazadosReinspeccion("<= '1993'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['total1993'] = $data['ai1993'] + $data['ri1993'] + $data['ar1993'] + $data['rr1993'];

                $data['ai19941998'] = $this->Mestadisticos->aprobadosInspeccion("between '1994' and '1998'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['ri19941998'] = $this->Mestadisticos->rechazadosInspeccion("between '1994' and '1998'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['ar19941998'] = $this->Mestadisticos->aprobadosReinspeccion("between '1994' and '1998'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['rr19941998'] = $this->Mestadisticos->rechazadosReinspeccion("between '1994' and '1998'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['total19941998'] = $data['ai19941998'] + $data['ri19941998'] + $data['ar19941998'] + $data['rr19941998'];

                $data['ai19992003'] = $this->Mestadisticos->aprobadosInspeccion("between '1999' and '2003'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['ri19992003'] = $this->Mestadisticos->rechazadosInspeccion("between '1999' and '2003'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['ar19992003'] = $this->Mestadisticos->aprobadosReinspeccion("between '1999' and '2003'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['rr19992003'] = $this->Mestadisticos->rechazadosReinspeccion("between '1999' and '2003'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['total19992003'] = $data['ai19992003'] + $data['ri19992003'] + $data['ar19992003'] + $data['rr19992003'];

                $data['ai20042008'] = $this->Mestadisticos->aprobadosInspeccion("between '2004' and '2008'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['ri20042008'] = $this->Mestadisticos->rechazadosInspeccion("between '2004' and '2008'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['ar20042008'] = $this->Mestadisticos->aprobadosReinspeccion("between '2004' and '2008'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['rr20042008'] = $this->Mestadisticos->rechazadosReinspeccion("between '2004' and '2008'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['total20042008'] = $data['ai20042008'] + $data['ri20042008'] + $data['ar20042008'] + $data['rr20042008'];

                $data['ai2009'] = $this->Mestadisticos->aprobadosInspeccion(">= '2009'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['ri2009'] = $this->Mestadisticos->rechazadosInspeccion(">= '2009'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['ar2009'] = $this->Mestadisticos->aprobadosReinspeccion(">= '2009'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['rr2009'] = $this->Mestadisticos->rechazadosReinspeccion(">= '2009'", "'" . $fechainicial . "' and '" . $fechafinal . "'");
                $data['total2009'] = $data['ai2009'] + $data['ri2009'] + $data['ar2009'] + $data['rr2009'];

                $data['totalAprobadosInpeccion'] = $data['ai1993'] + $data['ai19941998'] + $data['ai19992003'] + $data['ai20042008'] + $data['ai2009'];
                $data['totalRechazadosInpeccion'] = $data['ri1993'] + $data['ri19941998'] + $data['ri19992003'] + $data['ri20042008'] + $data['ri2009'];
                $data['totalAprobadosReinpeccion'] = $data['ar1993'] + $data['ar19941998'] + $data['ar19992003'] + $data['ar20042008'] + $data['ar2009'];
                $data['totalRechazadosReinpeccion'] = $data['rr1993'] + $data['rr19941998'] + $data['rr19992003'] + $data['rr20042008'] + $data['rr2009'];

                $data['total'] = $data['totalAprobadosInpeccion'] + $data['totalRechazadosInpeccion'] + $data['totalAprobadosReinpeccion'] + $data['totalRechazadosReinpeccion'];

                $maximo = max($data['ai1993'], $data['ri1993'], $data['ar1993'], $data['ai19941998'], $data['ri19941998'], $data['ar19941998'], $data['rr19941998'], $data['ai19992003'], $data['ri19992003'], $data['ar19992003'], $data['rr19992003'], $data['ai20042008'], $data['ri20042008'], $data['ar20042008'], $data['rr20042008'], $data['ai2009'], $data['ri2009'], $data['ar2009'], $data['rr2009']);

                $data['ai1993Por'] = round(($data['ai1993'] / $maximo) * 100);
                $data['ri1993Por'] = round(($data['ri1993'] / $maximo) * 100);
                $data['ar1993Por'] = round(($data['ar1993'] / $maximo) * 100);
                $data['rr1993Por'] = round(($data['rr1993'] / $maximo) * 100);

                $data['ai19941998Por'] = round(($data['ai19941998'] / $maximo) * 100);
                $data['ri19941998Por'] = round(($data['ri19941998'] / $maximo) * 100);
                $data['ar19941998Por'] = round(($data['ar19941998'] / $maximo) * 100);
                $data['rr19941998Por'] = round(($data['rr19941998'] / $maximo) * 100);

                $data['ai19992003Por'] = round(($data['ai19992003'] / $maximo) * 100);
                $data['ri19992003Por'] = round(($data['ri19992003'] / $maximo) * 100);
                $data['ar19992003Por'] = round(($data['ar19992003'] / $maximo) * 100);
                $data['rr19992003Por'] = round(($data['rr19992003'] / $maximo) * 100);

                $data['ai20042008Por'] = round(($data['ai20042008'] / $maximo) * 100);
                $data['ri20042008Por'] = round(($data['ri20042008'] / $maximo) * 100);
                $data['ar20042008Por'] = round(($data['ar20042008'] / $maximo) * 100);
                $data['rr20042008Por'] = round(($data['rr20042008'] / $maximo) * 100);

                $data['ai2009Por'] = round(($data['ai2009'] / $maximo) * 100);
                $data['ri2009Por'] = round(($data['ri2009'] / $maximo) * 100);
                $data['ar2009Por'] = round(($data['ar2009'] / $maximo) * 100);
                $data['rr2009Por'] = round(($data['rr2009'] / $maximo) * 100);

                $maximo2 = max($data['total1993'], $data['total19941998'], $data['total19992003'], $data['total20042008'], $data['total2009']);

                $data['total1993Por'] = round((($data['total1993'] / $maximo2) * 100) / 2);
                $data['total19941998Por'] = round((($data['total19941998'] / $maximo2) * 100) / 2);
                $data['total19992003Por'] = round((($data['total19992003'] / $maximo2) * 100) / 2);
                $data['total20042008Por'] = round((($data['total20042008'] / $maximo2) * 100) / 2);
                $data['total2009Por'] = round((($data['total2009'] / $maximo2) * 100) / 2);

                $this->load->view('oficina/reportes/estadisticos/Vpdf_aprobados_rechazados_matricula', $data);
                break;
            case 10:
                $data ['titulo'] = strtoupper('Clientes adquiridos,perdidos y retornados');
                $data ['fechageneracion'] = date("Y-m-d H:i:s");
                $data ['fechainicial'] = $fechainicial;
                $data ['fechafinal'] = $fechafinal;
                $data ['fechaperdidos'] = $fechaperdidos;
                $data['nombreCda'] = $this->Mestadisticos->getNombreCda();
                $rta = $this->Mestadisticos->clientesAdquiridos($fechainicial, $fechafinal);
                $data['clientesAdquiridos'] = $rta->result();
                $rta = $this->Mestadisticos->clientesPerdidos($fechaperdidos, $fechafinal);
                $data['clientesPerdidos'] = $rta->result();
                $rta = $this->Mestadisticos->clientesRetornados($fechainicial, $fechafinal);
                $data['clientesRetornados'] = $rta->result();
                $this->load->view('oficina/reportes/estadisticos/Vpdf_clientes_adquiridos_perdidos_retornados', $data);
                break;
            case 11:
                $rta = $this->Mestadisticos->getContrasenas($fechainicial, $fechafinal);
                $filename = 'Informe Contraseñas';
                $this->downloadinforme($rta, $filename);
                break;
            default:
                redirect("oficina/reportes/estadisticos/Cestadisticos");
                break;
        }
    }

    public function downloadinforme($query, $filename) {
        date_default_timezone_set('America/bogota');
        $date = date("Y-m-d-H-i-s");
        $delimiter = ";";
        $newline = "\r\n";
        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        $this->download($filename, $data);
//        force_download($nombre, $data);
    }

    private function download($filename, $result) {
        $nombre = $filename . '.csv';
        force_download($nombre, $result);
    }

}
