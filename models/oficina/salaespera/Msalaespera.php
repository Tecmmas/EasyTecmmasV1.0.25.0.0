<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Msalaespera extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getPorcentaje($data) {
        $idhojapruebas = $data['idhojapruebas'];
        $reins = $data['reins'];
        $arrayPrueba = array();
        if ($reins == '1') {
            //LUCES
            $queryLuces = $this->db->query("SELECT 
            IF((SELECT COUNT(*) FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=1)>1,
            (SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.estado<>3 AND p.idtipo_prueba=1 ORDER BY p.idprueba DESC LIMIT 1),'') estado");
            $rLuces = $queryLuces->result();
            if ($rLuces[0]->estado !== '') {
                array_push($arrayPrueba, $rLuces[0]->estado);
            }
            //OPACIDAD
            $queryOpacidad = $this->db->query("SELECT 
            IF((SELECT COUNT(*) FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=2)>1,
            (SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.estado<>3 AND p.idtipo_prueba=2 ORDER BY p.idprueba DESC LIMIT 1),'') estado");
            $rOpacidad = $queryOpacidad->result();
            if ($rOpacidad[0]->estado !== '') {
                array_push($arrayPrueba, $rOpacidad[0]->estado);
            }
            //GASES
            $queryGases = $this->db->query("SELECT 
            IF((SELECT COUNT(*) FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=3)>1,
            (SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.estado<>3 AND p.idtipo_prueba=3 ORDER BY p.idprueba DESC LIMIT 1),'') estado");
            $rGases = $queryGases->result();
            if ($rGases[0]->estado !== '') {
                array_push($arrayPrueba, $rGases[0]->estado);
            }
            //Sonometria
            $querySonometria = $this->db->query("SELECT 
            IF((SELECT COUNT(*) FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=4)>1,
            (SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.estado<>3 AND p.idtipo_prueba=4 ORDER BY p.idprueba DESC LIMIT 1),'') estado");
            $rSonometria = $querySonometria->result();
            if ($rSonometria[0]->estado !== '') {
                array_push($arrayPrueba, $rSonometria[0]->estado);
            }
            //Camara1
            $queryCamara1 = $this->db->query("SELECT 
            IF((SELECT COUNT(*) FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=5 AND p.prueba=0)>1,
            (SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.estado<>3 AND p.idtipo_prueba=5 AND p.prueba=0 ORDER BY p.idprueba DESC LIMIT 1),'') estado");
            $rCamara1 = $queryCamara1->result();
            if ($rCamara1[0]->estado !== '') {
                array_push($arrayPrueba, $rCamara1[0]->estado);
            }
            //Camara2
            $queryCamara2 = $this->db->query("SELECT 
            IF((SELECT COUNT(*) FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=5 AND p.prueba=1)>1,
            (SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.estado<>3 AND p.idtipo_prueba=5 AND p.prueba=1 ORDER BY p.idprueba DESC LIMIT 1),'') estado");
            $rCamara2 = $queryCamara2->result();
            if ($rCamara2[0]->estado !== '') {
                array_push($arrayPrueba, $rCamara2[0]->estado);
            }
            //Taximetro
            $queryTaximetro = $this->db->query("SELECT 
            IF((SELECT COUNT(*) FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=6)>1,
            (SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.estado<>3 AND p.idtipo_prueba=6 ORDER BY p.idprueba DESC LIMIT 1),'') estado");
            $rTaximetro = $queryTaximetro->result();
            if ($rTaximetro[0]->estado !== '') {
                array_push($arrayPrueba, $rTaximetro[0]->estado);
            }
            //Frenos
            $queryFrenos = $this->db->query("SELECT 
            IF((SELECT COUNT(*) FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=7)>1,
            (SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.estado<>3 AND p.idtipo_prueba=7 ORDER BY p.idprueba DESC LIMIT 1),'') estado");
            $rFrenos = $queryFrenos->result();
            if ($rFrenos[0]->estado !== '') {
                array_push($arrayPrueba, $rFrenos[0]->estado);
            }
            //Visual
            $queryVisual = $this->db->query("SELECT 
            IF((SELECT COUNT(*) FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=8)>1,
            (SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.estado<>3 AND p.idtipo_prueba=8 ORDER BY p.idprueba DESC LIMIT 1),'') estado");
            $rVisual = $queryVisual->result();
            if ($rVisual[0]->estado !== '') {
                array_push($arrayPrueba, $rVisual[0]->estado);
            }
            //Suspension
            $querySuspension = $this->db->query("SELECT 
            IF((SELECT COUNT(*) FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=9)>1,
            (SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.estado<>3 AND p.idtipo_prueba=9 ORDER BY p.idprueba DESC LIMIT 1),'') estado");
            $rSuspension = $querySuspension->result();
            if ($rSuspension[0]->estado !== '') {
                array_push($arrayPrueba, $rSuspension[0]->estado);
            }
            //Alineacion
            $queryAlineacion = $this->db->query("SELECT 
            IF((SELECT COUNT(*) FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=10)>1,
            (SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.estado<>3 AND p.idtipo_prueba=10 ORDER BY p.idprueba DESC LIMIT 1),'') estado");
            $rAlineacion = $queryAlineacion->result();
            if ($rAlineacion[0]->estado !== '') {
                array_push($arrayPrueba, $rAlineacion[0]->estado);
            }
        } else {
            //Luces
            $queryLuces = $this->db->query("SELECT 
            IFNULL((SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=1 ORDER BY p.idprueba LIMIT 1),'') estado");
            $rLuces = $queryLuces->result();
            if ($rLuces[0]->estado !== '') {
                array_push($arrayPrueba, $rLuces[0]->estado);
            }
            //Opacidad
            $queryOpacidad = $this->db->query("SELECT 
            IFNULL((SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=2 ORDER BY p.idprueba LIMIT 1),'') estado");
            $rOpacidad = $queryOpacidad->result();
            if ($rOpacidad[0]->estado !== '') {
                array_push($arrayPrueba, $rOpacidad[0]->estado);
            }
            //Gases
            $queryGases = $this->db->query("SELECT 
            IFNULL((SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=3 ORDER BY p.idprueba LIMIT 1),'') estado");
            $rGases = $queryGases->result();
            if ($rGases[0]->estado !== '') {
                array_push($arrayPrueba, $rGases[0]->estado);
            }
            //Sonometria
            $querySonometria = $this->db->query("SELECT 
            IFNULL((SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=4 ORDER BY p.idprueba LIMIT 1),'') estado");
            $rSonometria = $querySonometria->result();
            if ($rSonometria[0]->estado !== '') {
                array_push($arrayPrueba, $rSonometria[0]->estado);
            }
            //Camara1
            $queryCamara1 = $this->db->query("SELECT 
            IFNULL((SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=5 and p.prueba=0 ORDER BY p.idprueba LIMIT 1),'') estado");
            $rCamara1 = $queryCamara1->result();
            if ($rCamara1[0]->estado !== '') {
                array_push($arrayPrueba, $rCamara1[0]->estado);
            }
            //Camara2
            $queryCamara2 = $this->db->query("SELECT 
            IFNULL((SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=5 and p.prueba=1 ORDER BY p.idprueba LIMIT 1),'') estado");
            $rCamara2 = $queryCamara2->result();
            if ($rCamara2[0]->estado !== '') {
                array_push($arrayPrueba, $rCamara2[0]->estado);
            }
            //Taximetro
            $queryTaximetro = $this->db->query("SELECT 
            IFNULL((SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=6 ORDER BY p.idprueba LIMIT 1),'') estado");
            $rTaximetro = $queryTaximetro->result();
            if ($rTaximetro[0]->estado !== '') {
                array_push($arrayPrueba, $rTaximetro[0]->estado);
            }
            //Frenos
            $queryFrenos = $this->db->query("SELECT 
            IFNULL((SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=7 ORDER BY p.idprueba LIMIT 1),'') estado");
            $rFrenos = $queryFrenos->result();
            if ($rFrenos[0]->estado !== '') {
                array_push($arrayPrueba, $rFrenos[0]->estado);
            }
            //Visual
            $queryVisual = $this->db->query("SELECT 
            IFNULL((SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=8 ORDER BY p.idprueba LIMIT 1),'') estado");
            $rVisual = $queryVisual->result();
            if ($rVisual[0]->estado !== '') {
                array_push($arrayPrueba, $rVisual[0]->estado);
            }
            //Suspension
            $querySuspension = $this->db->query("SELECT 
            IFNULL((SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=9 ORDER BY p.idprueba LIMIT 1),'') estado");
            $rSuspension = $querySuspension->result();
            if ($rSuspension[0]->estado !== '') {
                array_push($arrayPrueba, $rSuspension[0]->estado);
            }
            //Alineacion
            $queryAlineacion = $this->db->query("SELECT 
            IFNULL((SELECT p.estado FROM pruebas p WHERE p.idhojapruebas=$idhojapruebas AND p.estado<>5 AND p.idtipo_prueba=10 ORDER BY p.idprueba LIMIT 1),'') estado");
            $rAlineacion = $queryAlineacion->result();
            if ($rAlineacion[0]->estado !== '') {
                array_push($arrayPrueba, $rAlineacion[0]->estado);
            }
        }
        //Firma
        $queryFirma = $this->db->query("SELECT if(p.estadototal='1','0','2') estado FROM hojatrabajo p WHERE p.idhojapruebas=$idhojapruebas AND p.estadototal<>5 LIMIT 1");
        $rFirma = $queryFirma->result();
        if ($rFirma[0]->estado !== '') {
            array_push($arrayPrueba, $rFirma[0]->estado);
        }
        //Runt
        $queryRunt = $this->db->query("SELECT if(p.estadototal='4' or p.estadototal='7','2','0') estado FROM hojatrabajo p WHERE p.idhojapruebas=$idhojapruebas AND p.estadototal<>5 LIMIT 1");
        $rRunt = $queryRunt->result();
        if ($rRunt[0]->estado !== '') {
            array_push($arrayPrueba, $rRunt[0]->estado);
        }

        return $arrayPrueba;
    }

    function getVehiculos() {
        $query = <<<EOF
            select distinct 
                 CASE
                            WHEN v.idservicio = '1' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            height:40px;
                            font-size: 30px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 5px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '2' THEN
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: white;
                            color:black;
                            height:40px;
                            font-size: 30px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 5px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '3' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            height:40px;
                            font-size: 30px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 5px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '4' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:whitesmoke;
                            height:40px;
                            font-size: 30px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 5px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '7' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:whitesmoke;
                            height:40px;
                            font-size: 30px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 5px"><strong>',v.numero_placa,'</strong></label>')
                            ELSE 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            height:40px;
                            font-size: 30px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 5px"><strong>',v.numero_placa,'</strong></label>')
                            END placa,
                  if(h.reinspeccion=0,'1ra','2da') ocacion,
                  h.idhojapruebas,v.numero_placa,h.reinspeccion,v.tipo_vehiculo,h.llamar
            from 
                vehiculos v, 
                hojatrabajo h
            where 
                (h.reinspeccion=0 OR h.reinspeccion=1) and
                v.idvehiculo=h.idvehiculo and 
                ((DATE_FORMAT(h.fechainicial,'%Y%M%d') = DATE_FORMAT(now(),'%Y%M%d') or CURDATE() in (select date(fechainicial) from pruebas where idhojapruebas=h.idhojapruebas))) and
                h.estadototal<>5 and h.llamar<>2 order by h.fechainicial limit 20
EOF;
        $rta = $this->db->query($query);
        return $rta;
    }

    function llamar() {
        $query = <<<EOF
            select 
                 v.numero_placa,v.idservicio,h.idhojapruebas
            from 
                vehiculos v, 
                hojatrabajo h
            where 
                (h.reinspeccion=0 OR h.reinspeccion=1) and
                v.idvehiculo=h.idvehiculo and 
                ((DATE_FORMAT(h.fechainicial,'%Y%M%d') = DATE_FORMAT(now(),'%Y%M%d') or CURDATE() in (select date(fechainicial) from pruebas where idhojapruebas=h.idhojapruebas))) and
                h.estadototal<>5 and h.llamar=1 order by h.fechainicial limit 1
EOF;
        $rta = $this->db->query($query);
        return $rta;
    }

}
