<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CLuxometro extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        espejoDatabase();
//        $this->load->model("MPrueba");
    }

    public function index() {
//        $data['idalineacion'] = $this->input->post('idprueba');
        $this->load->view('VLuxometro');
    }

    public function guardarAlineacion() {
        $pruebas['idprueba'] = $this->input->post('idprueba');
        $resultados['idconfig_prueba'] = '141';
        $resultados['idprueba'] = $pruebas['idprueba'];

        $resultados['tiporesultado'] = '1';
        $resultados['valor'] = $this->input->post('alineacion1');
        $valEje1 = $resultados['valor'];
        $resultados['observacion'] = 'Alineacion Eje 1';
        $this->MPrueba->guardarResultado($resultados);
        $resultados['tiporesultado'] = '2';
        $resultados['valor'] = $this->input->post('alineacion2');
        $resultados['observacion'] = 'Alineacion Eje 2';
        $this->MPrueba->guardarResultado($resultados);
        $resultados['tiporesultado'] = 'Versión de software';
        $resultados['valor'] = '1.0';
        $resultados['observacion'] = 'EasyTecmmas';
        $resultados['idconfig_prueba'] = '100';
        $this->MPrueba->guardarResultado($resultados);

        if ($valEje1 > 10 || $valEje1 < -10) {
            $pruebas['estado'] = '1';
        } else {
            $pruebas['estado'] = '2';
        }
        $pruebas['idmaquina'] = '6';
        $pruebas['idusuario'] = '92';
        $pruebas['fechafinal'] = date('Y-m-d H:i:s');
        $this->MPrueba->actualizarPrueba($pruebas);
        $rPrueba = $this->MPrueba->getPruebas($pruebas['idprueba']);
        $idhojapruebas = $rPrueba[0]->idhojapruebas;
        $rHojatrabajo = $this->MPrueba->getHojaPruebas($idhojapruebas);
        if ($rHojatrabajo[0]->reinspeccion == '0' || $rHojatrabajo[0]->reinspeccion == '1') {
            $auditoria_sicov['id_revision'] = $idhojapruebas;
            $auditoria_sicov['serial_equipo_medicion'] = 'FRLIV 2002';
            $auditoria_sicov['ip_equipo_medicion'] = '192.168.1.100';
            $auditoria_sicov['fecha_registro_bd'] = date('Y-m-d H:i:s');
            $auditoria_sicov['fecha_evento'] = date('Y-m-d H:i:s');
            $auditoria_sicov['tipo_operacion'] = '1';
            $auditoria_sicov['tipo_evento'] = '5';
            $auditoria_sicov['codigo_proveedor'] = '862';
            $auditoria_sicov['id_runt_cda'] = '15761094';
            $auditoria_sicov['trama'] = '{"eje1":"' . $this->input->post('alineacion1') . '","eje2":"' . $this->input->post('alineacion2') . '","eje3":"","eje4":"","eje5":"","tablaAfectada":"resultados","idRegistro":"' . $pruebas['idprueba'] . '"}';
            $auditoria_sicov['identificacion_usuario'] = '';
            $auditoria_sicov['observacion'] = '';
            $this->MPrueba->guardarAuditoria($auditoria_sicov);
        }
    }

}
