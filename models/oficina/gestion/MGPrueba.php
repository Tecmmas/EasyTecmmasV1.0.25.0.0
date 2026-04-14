<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MGPrueba extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    var $key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c';

    function getVehiculoEnPista($idhojapruebas)
    {
        $query = <<<EOF
            select distinct 
                 CASE
                            WHEN v.servicio = '1' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '2' THEN
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: white;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '3' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '4' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '7' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            ELSE 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            END placa,
                  if(v.reinspeccion=0,'1ra','2da') ocacion,
                  v.idhojapruebas,v.placa  AS numero_placa,v.reinspeccion
            from 
                visor v
            where 
                
                v.idhojapruebas = $idhojapruebas
EOF;
        $rta = $this->db->query($query);
        if ($rta->num_rows() > 0) {
            $r = $rta->result();
        } else {
            $r = (object)
            array(
                'placa' => ''
            );
        }
        return $r[0];
        //        return $r;
    }

    function pruebasPendientes($idhojapruebas)
    {
        $query = <<<EOF
            select v.numero_placa,tp.nombre from vehiculos v, hojatrabajo h, pruebas p, tipo_prueba tp where tp.idtipo_prueba=p.idtipo_prueba and h.idhojapruebas=p.idhojapruebas and v.idvehiculo=h.idvehiculo and p.estado=0 and h.idhojapruebas=$idhojapruebas and p.idtipo_prueba<11
EOF;
        $rta = $this->db->query($query);
        if ($rta->num_rows() > 0) {
            $r = $rta->result();
        } else {
            $r = (object)
            array(
                '0' => (object) array(
                    'numero_placa' => '',
                    'nombre' => 'NO REGISTRA',
                )
            );
        }
        return $r;
    }

    function pruebasRechazadas($numero_placa)
    {
        $query = <<<EOF
            select v.numero_placa,tp.nombre from vehiculos v, hojatrabajo h, pruebas p, tipo_prueba tp where tp.idtipo_prueba=p.idtipo_prueba and h.idhojapruebas=p.idhojapruebas and CURDATE()=date(p.fechafinal) and v.idvehiculo=h.idvehiculo and p.estado=1 and v.numero_placa='$numero_placa'
EOF;
        $rta = $this->db->query($query);
        if ($rta->num_rows() > 0) {
            $r = $rta->result();
        } else {
            $r = (object)
            array(
                '0' => (object) array(
                    'numero_placa' => '',
                    'nombre' => 'NO REGISTRA',
                )
            );
        }
        return $r;
    }

    function getVehiculosRechazados()
    {
        $query = <<<EOF
            SELECT distinct 
                 CASE
                            WHEN v.servicio = '1' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '2' THEN
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: white;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '3' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '4' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '7' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            ELSE 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            END placa,
                  if(v.reinspeccion=0,'1ra','2da') ocacion,
                  v.idhojapruebas,v.placa as numero_placa,v.reinspeccion
                from visor v
                WHERE 
                (v.sicov=0 OR v.estadototal=1) AND (v.estadototal<>4 and v.estadototal<>5) AND
                (
                ( 
                (v.luces IS  NULL OR v.luces <> 0) AND 
                (v.gases IS  NULL OR v.gases <> 0) AND
                (v.opacidad IS  NULL OR v.opacidad <> 0) AND
                (v.sonometro IS  NULL OR v.sonometro <> 0) AND
                (v.visual IS  NULL OR v.visual <> 0) AND
                (v.camara0 IS  NULL OR v.camara0 <> 0) AND
                (v.camara1 IS  NULL OR v.camara1 <> 0) AND  
                (v.alineacion IS  NULL OR v.alineacion <> 0) AND 
                (v.frenos IS  NULL OR v.frenos <> 0) AND 
                (v.suspension IS  NULL OR v.suspension <> 0) AND 
                (v.taximetro IS  NULL OR v.taximetro <> 0)                
                
               ) 
                  AND 
                  (
                  v.luces = 1 OR v.gases = 1 OR v.opacidad = 1 OR v.sonometro = 1 OR v.visual = 1 OR v.camara0 = 1 OR v.camara1 = 1 
                  OR v.alineacion = 1 OR  v.frenos = 1 OR v.suspension = 1 OR v.taximetro = 1
                  )
                )
EOF;
        $rta = $this->db->query($query);
        return $rta;
    }

    function getVehiculosAprobados()
    {
        $query = <<<EOF
            SELECT distinct 
                 CASE
                            WHEN v.servicio = '1' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '2' THEN
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: white;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '3' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '4' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '7' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            ELSE 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            END placa,
                  if(v.reinspeccion=0,'1ra','2da') ocacion,
                  v.idhojapruebas,v.placa AS  numero_placa,v.reinspeccion
                FROM
                    visor v
                WHERE
                (v.sicov = 0 OR v.estadototal = 1) AND 
                (v.estadototal <> 4 AND v.estadototal<>5) AND
                IFNULL(v.luces,'2')=2 AND
                IFNULL(v.gases,'2')=2 AND
                IFNULL(v.opacidad,'2')=2 AND
                IFNULL(v.sonometro,'2')=2 AND
                IFNULL(v.visual,'2')=2 AND
                IFNULL(v.camara0,'2')=2 AND
                IFNULL(v.camara1,'2')=2 AND
                IFNULL(v.taximetro,'2')=2 AND
                IFNULL(v.alineacion,'2')=2 AND
                IFNULL(v.frenos,'2')=2 AND
                IFNULL(v.suspension,'2')=2
EOF;
        $rta = $this->db->query($query);

        return $rta;
    }

    function getRechazadoSinCosecutivo()
    {
        $query = <<<EOF
            select 
                distinct 
                 CASE
                            WHEN v.servicio = '1' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '2' THEN
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: white;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '3' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '4' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '7' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            ELSE 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            END placa,
                  if(v.reinspeccion=0,'1ra','2da') ocacion,
                  v.idhojapruebas,v.placa AS numero_placa,v.reinspeccion
            from 
                visor v 
            where 
            v.estadototal = 3 AND  v.sicov=1 ORDER BY v.fecha desc
EOF;
        $rta = $this->db->query($query);
        return $rta;
    }

    function getAprobadoSinCosecutivo()
    {
        $query = <<<EOF
            select 
                distinct 
                 CASE
                            WHEN v.servicio = '1' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '2' THEN
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: white;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '3' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '4' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            WHEN v.servicio = '7' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            ELSE 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.placa,'</strong></label>')
                            END placa,
                  if(v.reinspeccion=0,'1ra','2da') ocacion,
                  v.idhojapruebas,v.placa as numero_placa,v.reinspeccion
            from 
            visor v 
            where 
            v.estadototal= 2 and v.sicov=1  order BY v.fecha desc
EOF;
        $rta = $this->db->query($query);
        return $rta;
    }

    function getVehiculoTerminado()
    {
        $query = <<<EOF
            select 
                distinct 
                IFNULL((SELECT c.correo FROM clientes c WHERE v.idcliente = c.idcliente LIMIT 1),'') AS 'email',
                IFNULL((SELECT p.idpre_prerevision FROM pre_prerevision p WHERE p.numero_placa_ref = v.numero_placa LIMIT 1 ),'') AS 'idprerevision',
                 CASE
                            WHEN vr.servicio = '1' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',vr.placa,'</strong></label>')
                            WHEN vr.servicio = '2' THEN
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: white;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',vr.placa,'</strong></label>')
                            WHEN vr.servicio = '3' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',vr.placa,'</strong></label>')
                            WHEN vr.servicio = '4' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',vr.placa,'</strong></label>')
                            WHEN vr.servicio = '7' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',vr.placa,'</strong></label>')
                            ELSE 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',vr.placa,'</strong></label>')
                            END placa,
                  if(vr.reinspeccion=0,'1ra','2da') ocacion,
                  vr.idhojapruebas,vr.placa as numero_placa,vr.reinspeccion,vr.estadototal
            from 
                vehiculos v, visor vr 
            where 
               vr.placa = v.numero_placa  AND (vr.estadototal=4 or vr.estadototal=7) AND vr.certificado = 1 and vr.sicov=1 order BY vr.fecha desc
EOF;
        $rta = $this->db->query($query);
        return $rta;
    }

    //---------------------------------------INTEGRACION 20210320 BRAYAN LEON

    public function getPlaca($idhojapruebas)
    {
        $query = $this->db->query("SELECT v.numero_placa AS placa,v.idtipocombustible AS combustible, v.tipo_vehiculo AS tipovehiculo, 
                                    v.idservicio AS servicio,h.idhojapruebas, 
                                    CASE
                                        WHEN h.estadototal= 1 THEN 'Asignado'
                                        WHEN h.estadototal= 2 THEN 'Aprobado'
                                        WHEN h.estadototal= 3 THEN 'Rechazado'
                                        ELSE 'Abortada'
                                    END AS 'estado',
                                    h.fechainicial AS 'fechainicial', h.fechafinal AS 'fechafinal',
                                    CASE
                                        WHEN h.reinspeccion = 0 THEN 'Tec 1ra'
                                        WHEN h.reinspeccion = 1 THEN 'Tec Rei'
                                        WHEN h.reinspeccion = 4444 THEN 'Pre 1ra'
                                        WHEN h.reinspeccion = 44441 THEN 'Pre Rei'
                                        WHEN h.reinspeccion = 8888 THEN 'Lib'
                                        ELSE 'Error'
                                    END AS 'tipoins',
                                    (SELECT p.fechainicial FROM pruebas p WHERE h.idhojapruebas=p.idhojapruebas ORDER BY 1 DESC LIMIT 1) AS 'pfechainicial',
                                    h.reinspeccion,
                                    IF(h.pin0,h.pin0,'---') AS pin
                                    FROM vehiculos v, hojatrabajo h
                                    WHERE
                                    v.idvehiculo=h.idvehiculo AND h.idhojapruebas=$idhojapruebas ORDER BY h.fechainicial DESC LIMIT 1");
        return $query;
    }

    public function getPruebasprimera($idhojapruebas)
    {
        $query = $this->db->query("SELECT  p.idprueba, p.fechainicial,
                                    CASE
                                        WHEN p.estado = 0 THEN 'Asignado'
                                        WHEN p.estado = 1 THEN 'Rechazado'
                                        WHEN p.estado = 2 THEN 'Aprobado'
                                        ELSE 'Reasignado'
                                     END AS 'estadoPruebas',
                                     CASE
                                        WHEN p.idtipo_prueba = 1 THEN 
                                              CASE
                                                 WHEN v.luces = 0 THEN 'Asignado'
                                                 WHEN v.luces = 1 THEN 'Rechazado'
                                                 WHEN v.luces = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END
                                        WHEN p.idtipo_prueba = 2 THEN 
                                              CASE
                                                 WHEN v.opacidad = 0 THEN 'Asignado'
                                                 WHEN v.opacidad = 1 THEN 'Rechazado'
                                                 WHEN v.opacidad = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END 
                                        WHEN p.idtipo_prueba = 3 THEN 
                                              CASE
                                                 WHEN v.gases = 0 THEN 'Asignado'
                                                 WHEN v.gases = 1 THEN 'Rechazado'
                                                 WHEN v.gases = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END
                                        WHEN p.idtipo_prueba = 4 THEN 
                                              CASE
                                                 WHEN v.sonometro = 0 THEN 'Asignado'
                                                 WHEN v.sonometro = 1 THEN 'Rechazado'
                                                 WHEN v.sonometro = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END  
                                        WHEN (p.idtipo_prueba = 5 AND p.prueba = 0) THEN 
                                              CASE
                                                 WHEN v.camara0 = 0 THEN 'Asignado'
                                                 WHEN v.camara0 = 1 THEN 'Rechazado'
                                                 WHEN v.camara0 = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END
                                        WHEN (p.idtipo_prueba = 5 AND p.prueba = 1) THEN 
                                              CASE
                                                 WHEN v.camara1 = 0 THEN 'Asignado'
                                                 WHEN v.camara1 = 1 THEN 'Rechazado'
                                                 WHEN v.camara1 = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END
                                        WHEN (p.idtipo_prueba = 6) THEN 
                                              CASE
                                                 WHEN v.taximetro = 0 THEN 'Asignado'
                                                 WHEN v.taximetro = 1 THEN 'Rechazado'
                                                 WHEN v.taximetro = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END 
                                        WHEN (p.idtipo_prueba = 7) THEN 
                                              CASE
                                                 WHEN v.frenos = 0 THEN 'Asignado'
                                                 WHEN v.frenos = 1 THEN 'Rechazado'
                                                 WHEN v.frenos = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END
                                        WHEN (p.idtipo_prueba = 8) THEN 
                                              CASE
                                                 WHEN v.visual = 0 THEN 'Asignado'
                                                 WHEN v.visual = 1 THEN 'Rechazado'
                                                 WHEN v.visual = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END  
                                        WHEN (p.idtipo_prueba = 9) THEN 
                                              CASE
                                                 WHEN v.suspension = 0 THEN 'Asignado'
                                                 WHEN v.suspension = 1 THEN 'Rechazado'
                                                 WHEN v.suspension = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END 
                                        WHEN (p.idtipo_prueba = 10) THEN 
                                              CASE
                                                 WHEN v.alineacion = 0 THEN 'Asignado'
                                                 WHEN v.alineacion = 1 THEN 'Rechazado'
                                                 WHEN v.alineacion = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END   
                                           END  AS 'estado',
                                     IFNULL(p.fechafinal,'---') AS fechafinal,
                                     CASE
                                        WHEN p.idtipo_prueba = 1 THEN 'Luces'
                                        WHEN p.idtipo_prueba = 2 THEN 'Opacidad'
                                        WHEN p.idtipo_prueba = 3 THEN 'Gases'
                                        WHEN p.idtipo_prueba = 4 THEN 'Sonometro'
                                        WHEN (p.idtipo_prueba = 5 AND p.prueba = 1) THEN 'Camara-1'
                                        WHEN (p.idtipo_prueba = 5 AND p.prueba = 0) THEN 'Camara-0'
                                        WHEN p.idtipo_prueba = 6 THEN 'Taximetro'
                                        WHEN p.idtipo_prueba = 7 THEN 'Frenos'
                                        WHEN p.idtipo_prueba = 8 THEN 'Visual'
                                        WHEN p.idtipo_prueba = 9 THEN 'Suspension'
                                        ELSE 'Alineador'
                                    END AS 'pruebas',
                                    p.idtipo_prueba, p.prueba
                                    FROM hojatrabajo h, pruebas p, visor v
                                    WHERE 
                                    h.idhojapruebas = p.idhojapruebas AND v.idhojapruebas = h.idhojapruebas AND  
                                    (p.idtipo_prueba <> 12 AND p.idtipo_prueba <> 13 AND p.idtipo_prueba <> 14 AND p.idtipo_prueba <> 15 AND p.idtipo_prueba <> 16
                                    AND p.idtipo_prueba <> 17 AND p.idtipo_prueba <> 18 AND p.idtipo_prueba <> 19 AND p.idtipo_prueba <> 21 AND p.idtipo_prueba <> 22 
                                    AND p.idtipo_prueba <> 23) AND (p.estado <> 3 AND p.estado <> 5 and p.estado <> 9)
                                    AND h.idhojapruebas=$idhojapruebas");
        return $query->result();
    }

    public function getPruebassegunda($idhojapruebas, $reinspeccion)
    {
        $query = $this->db->query("SELECT  p.idprueba, p.fechainicial,
                                    CASE
                                        WHEN p.estado = 0 THEN 'Asignado'
                                        WHEN p.estado = 1 THEN 'Rechazado'
                                        WHEN p.estado = 2 THEN 'Aprobado'
                                        ELSE 'Reasignado'
                                     END AS 'estadoPruebas',
                                     CASE
                                        WHEN p.idtipo_prueba = 1 THEN 
                                              CASE
                                                 WHEN v.luces = 0 THEN 'Asignado'
                                                 WHEN v.luces = 1 THEN 'Rechazado'
                                                 WHEN v.luces = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END
                                        WHEN p.idtipo_prueba = 2 THEN 
                                              CASE
                                                 WHEN v.opacidad = 0 THEN 'Asignado'
                                                 WHEN v.opacidad = 1 THEN 'Rechazado'
                                                 WHEN v.opacidad = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END 
                                        WHEN p.idtipo_prueba = 3 THEN 
                                              CASE
                                                 WHEN v.gases = 0 THEN 'Asignado'
                                                 WHEN v.gases = 1 THEN 'Rechazado'
                                                 WHEN v.gases = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END
                                        WHEN p.idtipo_prueba = 4 THEN 
                                              CASE
                                                 WHEN v.sonometro = 0 THEN 'Asignado'
                                                 WHEN v.sonometro = 1 THEN 'Rechazado'
                                                 WHEN v.sonometro = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END  
                                        WHEN (p.idtipo_prueba = 5 AND p.prueba = 0) THEN 
                                              CASE
                                                 WHEN v.camara0 = 0 THEN 'Asignado'
                                                 WHEN v.camara0 = 1 THEN 'Rechazado'
                                                 WHEN v.camara0 = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END
                                        WHEN (p.idtipo_prueba = 5 AND p.prueba = 1) THEN 
                                              CASE
                                                 WHEN v.camara1 = 0 THEN 'Asignado'
                                                 WHEN v.camara1 = 1 THEN 'Rechazado'
                                                 WHEN v.camara1 = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END
                                        WHEN (p.idtipo_prueba = 6) THEN 
                                              CASE
                                                 WHEN v.taximetro = 0 THEN 'Asignado'
                                                 WHEN v.taximetro = 1 THEN 'Rechazado'
                                                 WHEN v.taximetro = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END 
                                        WHEN (p.idtipo_prueba = 7) THEN 
                                              CASE
                                                 WHEN v.frenos = 0 THEN 'Asignado'
                                                 WHEN v.frenos = 1 THEN 'Rechazado'
                                                 WHEN v.frenos = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END
                                        WHEN (p.idtipo_prueba = 8) THEN 
                                              CASE
                                                 WHEN v.visual = 0 THEN 'Asignado'
                                                 WHEN v.visual = 1 THEN 'Rechazado'
                                                 WHEN v.visual = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END  
                                        WHEN (p.idtipo_prueba = 9) THEN 
                                              CASE
                                                 WHEN v.suspension = 0 THEN 'Asignado'
                                                 WHEN v.suspension = 1 THEN 'Rechazado'
                                                 WHEN v.suspension = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END 
                                        WHEN (p.idtipo_prueba = 10) THEN 
                                              CASE
                                                 WHEN v.alineacion = 0 THEN 'Asignado'
                                                 WHEN v.alineacion = 1 THEN 'Rechazado'
                                                 WHEN v.alineacion = 2 THEN 'Aprobado'
                                                 ELSE 'Reasignado'
                                              END   
                                           END  AS 'estado',
                                     IFNULL(p.fechafinal,'---') AS fechafinal,
                                     CASE
                                        WHEN p.idtipo_prueba = 1 THEN 'Luces'
                                        WHEN p.idtipo_prueba = 2 THEN 'Opacidad'
                                        WHEN p.idtipo_prueba = 3 THEN 'Gases'
                                        WHEN p.idtipo_prueba = 4 THEN 'Sonometro'
                                        WHEN (p.idtipo_prueba = 5 AND p.prueba = 1) THEN 'Camara-1'
                                        WHEN (p.idtipo_prueba = 5 AND p.prueba = 0) THEN 'Camara-0'
                                        WHEN p.idtipo_prueba = 6 THEN 'Taximetro'
                                        WHEN p.idtipo_prueba = 7 THEN 'Frenos'
                                        WHEN p.idtipo_prueba = 8 THEN 'Visual'
                                        WHEN p.idtipo_prueba = 9 THEN 'Suspension'
                                        ELSE 'Alineador'
                                    END AS 'pruebas',
                                    p.idtipo_prueba, p.prueba
                                    FROM hojatrabajo h, pruebas p, visor v
                                    WHERE 
                                    h.idhojapruebas = p.idhojapruebas AND v.idhojapruebas = h.idhojapruebas AND v.reinspeccion = $reinspeccion AND 
                                    (p.idtipo_prueba <> 12 AND p.idtipo_prueba <> 13 AND p.idtipo_prueba <> 14 AND p.idtipo_prueba <> 15 AND p.idtipo_prueba <> 16
                                    AND p.idtipo_prueba <> 17 AND p.idtipo_prueba <> 18 AND p.idtipo_prueba <> 19 AND p.idtipo_prueba <> 21 AND p.idtipo_prueba <> 22 
                                    AND p.idtipo_prueba <> 23) 
                                    AND h.idhojapruebas=$idhojapruebas AND (p.estado <> 3 AND p.estado <> 5 AND p.estado <> 9)
                                    AND p.fechainicial BETWEEN 
				    DATE_SUB((SELECT p.fechainicial  FROM pruebas p WHERE h.idhojapruebas=p.idhojapruebas AND 
                                    (p.idtipo_prueba <> 12 AND p.idtipo_prueba <> 13 AND p.idtipo_prueba <> 14 AND p.idtipo_prueba <> 15 AND p.idtipo_prueba <> 16
                                    AND p.idtipo_prueba <> 17 AND p.idtipo_prueba <> 18 AND p.idtipo_prueba <> 19 AND p.idtipo_prueba <> 21 AND p.idtipo_prueba <> 22 
                                    AND p.idtipo_prueba <> 23)  ORDER BY 1 DESC LIMIT 1),INTERVAL 10 MINUTE)								
                                    AND 
				    (SELECT p.fechainicial  FROM pruebas p WHERE h.idhojapruebas=p.idhojapruebas AND 
                                    (p.idtipo_prueba <> 12 AND p.idtipo_prueba <> 13 AND p.idtipo_prueba <> 14 AND p.idtipo_prueba <> 15 AND p.idtipo_prueba <> 16
                                    AND p.idtipo_prueba <> 17 AND p.idtipo_prueba <> 18 AND p.idtipo_prueba <> 19 AND p.idtipo_prueba <> 21 AND p.idtipo_prueba <> 22 
                                    AND p.idtipo_prueba <> 23) and p.estado <> 9  ORDER BY 1 DESC LIMIT 1) ");
        return $query->result();
    }

    public function getPruebasVisualprimera($idhojapruebas)
    {
        $query = $this->db->query("SELECT  p.idprueba,
                                    CASE
                                       WHEN p.idtipo_prueba = 12 THEN 'Th'
                                       WHEN p.idtipo_prueba = 13 THEN 'Profundimetro'
                                       WHEN p.idtipo_prueba = 14 THEN 'Captador'
                                       WHEN p.idtipo_prueba = 15 THEN 'Pie de rey'
                                       WHEN p.idtipo_prueba = 16 THEN 'Detector H'
                                       WHEN p.idtipo_prueba = 17 THEN 'Elevador'
                                       WHEN p.idtipo_prueba = 18 THEN 'Calibrador'
                                       WHEN p.idtipo_prueba = 19 THEN 'Cronometro'
                                       WHEN p.idtipo_prueba = 21 THEN 'Perifecrico Rmp'
                                       WHEN p.idtipo_prueba = 22 THEN 'Periferico Tem'
                                       ELSE 'Bascula'
                                   END AS 'pruebas',
                                   p.idtipo_prueba
                                   FROM hojatrabajo h, pruebas p
                                   WHERE 
                                   h.idhojapruebas = p.idhojapruebas AND 
                                   (p.idtipo_prueba <> 1 AND p.idtipo_prueba <> 2 AND p.idtipo_prueba <> 3 AND p.idtipo_prueba <> 4 AND p.idtipo_prueba <> 5
                                   AND p.idtipo_prueba <> 6 AND p.idtipo_prueba <> 7 AND p.idtipo_prueba <> 8 AND p.idtipo_prueba <> 9 AND p.idtipo_prueba <> 10 ) 
                                   AND h.idhojapruebas=$idhojapruebas and p.estado <> 9");
        return $query->result();
    }

    public function getPruebasVisualsegunda($idhojapruebas)
    {
        $query = $this->db->query("SELECT  p.idprueba,
                                    CASE
                                       WHEN p.idtipo_prueba = 12 THEN 'Th'
                                       WHEN p.idtipo_prueba = 13 THEN 'Profundimetro'
                                       WHEN p.idtipo_prueba = 14 THEN 'Captador'
                                       WHEN p.idtipo_prueba = 15 THEN 'Pie de rey'
                                       WHEN p.idtipo_prueba = 16 THEN 'Detector H'
                                       WHEN p.idtipo_prueba = 17 THEN 'Elevador'
                                       WHEN p.idtipo_prueba = 18 THEN 'Calibrador'
                                       WHEN p.idtipo_prueba = 19 THEN 'Cronometro'
                                       WHEN p.idtipo_prueba = 21 THEN 'Perifecrico Rmp'
                                       WHEN p.idtipo_prueba = 22 THEN 'Periferico Tem'
                                       ELSE 'Bascula'
                                   END AS 'pruebas',
                                   p.idtipo_prueba
                                   FROM hojatrabajo h, pruebas p
                                   WHERE 
                                   h.idhojapruebas = p.idhojapruebas AND 
                                   (p.idtipo_prueba <> 1 AND p.idtipo_prueba <> 2 AND p.idtipo_prueba <> 3 AND p.idtipo_prueba <> 4 AND p.idtipo_prueba <> 5
                                   AND p.idtipo_prueba <> 6 AND p.idtipo_prueba <> 7 AND p.idtipo_prueba <> 8 AND p.idtipo_prueba <> 9 AND p.idtipo_prueba <> 10 ) 
                                   AND h.idhojapruebas=$idhojapruebas AND p.estado <> 3 
                                   AND p.fechainicial BETWEEN 
                                   DATE_SUB((SELECT p.fechainicial  FROM pruebas p WHERE h.idhojapruebas=p.idhojapruebas AND 
                                   (p.idtipo_prueba <> 1 AND p.idtipo_prueba <> 2 AND p.idtipo_prueba <> 3 AND p.idtipo_prueba <> 4 AND p.idtipo_prueba <> 5
                                   AND p.idtipo_prueba <> 6 AND p.idtipo_prueba <> 7 AND p.idtipo_prueba <> 8 AND p.idtipo_prueba <> 9 AND p.idtipo_prueba <> 10 ) and p.estado <> 9   ORDER BY 1 DESC LIMIT 1)  ,INTERVAL 45 MINUTE)
				   AND 
				   (SELECT p.fechainicial  FROM pruebas p WHERE h.idhojapruebas=p.idhojapruebas AND 
                                   (p.idtipo_prueba <> 1 AND p.idtipo_prueba <> 2 AND p.idtipo_prueba <> 3 AND p.idtipo_prueba <> 4 AND p.idtipo_prueba <> 5
                                   AND p.idtipo_prueba <> 6 AND p.idtipo_prueba <> 7 AND p.idtipo_prueba <> 8 AND p.idtipo_prueba <> 9 AND p.idtipo_prueba <> 10 ) and p.estado <> 9   ORDER BY 1 DESC LIMIT 1)");
        return $query->result();
    }

    function getCreateCaptador($idhojapruebas, $fechainicial)
    {
        $query = $this->db->query("INSERT INTO pruebas VALUES (NULL,$idhojapruebas,'$fechainicial',0,0,NULL,NULL,1,14, AES_ENCRYPT('" . $this->encriptInsert($idhojapruebas, $fechainicial, 0, 0, 1, 14) . "','" . $this->key . "') )");
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    function updateHojatrabajo($idhojapruebas)
    {
        $query = $this->db->query("UPDATE hojatrabajo  SET fechainicial=fechainicial, fechafinal=fechafinal, estadototal = 1 WHERE idhojapruebas=$idhojapruebas ");
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    function updateVisual($idhojapruebas, $idvisual)
    {
        //         $query = $this->db->query("DELETE FROM resultados  WHERE idprueba=$idvisual;");
        $this->db->trans_start();
        $query = $this->db->query("UPDATE pruebas SET fechainicial=fechainicial, estado=9 WHERE idprueba=$idvisual AND idhojapruebas=$idhojapruebas");
        $this->updateEnc($idvisual);
        $query = $this->db->query("INSERT INTO pruebas  VALUES (NULL,$idhojapruebas,(SELECT p.fechainicial FROM pruebas p WHERE p.idprueba=$idvisual LIMIT 1),
                                (SELECT p.prueba FROM pruebas p WHERE p.idprueba=$idvisual LIMIT 1),0,NULL,NULL,1, (SELECT p.idtipo_prueba FROM pruebas p WHERE p.idprueba=$idvisual LIMIT 1),
                                AES_ENCRYPT(JSON_OBJECT(
                                 'idhojapruebas',CAST($idhojapruebas AS CHAR(100000)),
                                 'fechainicial',CAST((SELECT p.fechainicial FROM pruebas p WHERE p.idprueba=$idvisual LIMIT 1) AS CHAR(100000)),
                                 'prueba',CAST((SELECT p.prueba FROM pruebas p WHERE p.idprueba=$idvisual LIMIT 1) AS CHAR(100000)),
                                 'estado',CAST(0 AS CHAR(100000)),
                                 'fechafinal',CAST(NULL AS CHAR(100000)),
                                 'idmaquina',CAST(NULL AS CHAR(100000)),
                                 'idusuario',CAST(1 AS CHAR(100000)),
                                 'idtipo_prueba',CAST((SELECT p.idtipo_prueba FROM pruebas p WHERE p.idprueba=$idvisual LIMIT 1) AS CHAR(100000))),
                                 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c'))");
        $query = $this->db->query("UPDATE visor v SET v.visual = 0, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas");
        $this->db->trans_complete();
        if ($query) {
            return 1;
        } else {
            return 0;
        }
        //        $query = $this->db->query("DELETE FROM resultados WHERE idprueba=$idvisual;");
        //        $query = $this->db->query("UPDATE pruebas SET fechainicial=fechainicial, fechafinal= null, idmaquina = null, estado=0 WHERE idprueba=$idvisual AND idhojapruebas=$idhojapruebas");
        //        if ($query) {
        //            return 1;
        //        } else {
        //            return 0;
        //        }
    }

    function updatePruebasVisual($idhojapruebas, $idtipoprueba)
    {
        $this->db->trans_start();
        $query = $this->db->query("UPDATE pruebas SET fechainicial=fechainicial,fechafinal= null, estado=0, idmaquina = null WHERE idprueba=$idtipoprueba AND idhojapruebas=$idhojapruebas");
        $this->updateEnc($idtipoprueba);
        $query = $this->db->query("UPDATE visor v SET v.visual = 0, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas");
        $this->db->trans_complete();
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    function updatePruebas($idhojapruebas, $idtipoprueba, $idtipo_prueba, $prueba)
    {
        switch ($idtipo_prueba) {
            case '1':
                $query = $this->db->query("UPDATE visor v SET v.luces = 0, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas AND (SELECT v.idvisor FROM visor v WHERE v.idhojapruebas =  $idhojapruebas ORDER BY 1 DESC LIMIT 1) LIMIT 1");
                break;
            case '2':
                $query = $this->db->query("UPDATE visor v SET v.opacidad = 0, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas AND (SELECT v.idvisor FROM visor v WHERE v.idhojapruebas =  $idhojapruebas ORDER BY 1 DESC LIMIT 1) LIMIT 1");
                break;
            case '3':
                $query = $this->db->query("UPDATE visor v SET v.gases = 0, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas AND (SELECT v.idvisor FROM visor v WHERE v.idhojapruebas =  $idhojapruebas ORDER BY 1 DESC LIMIT 1) LIMIT 1");
                break;
            case '4':
                $query = $this->db->query("UPDATE visor v SET v.sonometro = 0, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas AND (SELECT v.idvisor FROM visor v WHERE v.idhojapruebas =  $idhojapruebas ORDER BY 1 DESC LIMIT 1) LIMIT 1");
                break;
            case '5':
                if ($prueba == '0') {
                    $query = $this->db->query("UPDATE visor v SET v.camara0 = 0, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas AND (SELECT v.idvisor FROM visor v WHERE v.idhojapruebas =  $idhojapruebas ORDER BY 1 DESC LIMIT 1) LIMIT 1");
                } else {
                    $query = $this->db->query("UPDATE visor v SET v.camara1 = 0, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas AND (SELECT v.idvisor FROM visor v WHERE v.idhojapruebas =  $idhojapruebas ORDER BY 1 DESC LIMIT 1) LIMIT 1");
                }

                break;
            case '6':
                $query = $this->db->query("UPDATE visor v SET v.taximetro = 0, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas AND (SELECT v.idvisor FROM visor v WHERE v.idhojapruebas =  $idhojapruebas ORDER BY 1 DESC LIMIT 1) LIMIT 1");
                break;
            case '7':
                $query = $this->db->query("UPDATE visor v SET v.frenos = 0, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas AND (SELECT v.idvisor FROM visor v WHERE v.idhojapruebas =  $idhojapruebas ORDER BY 1 DESC LIMIT 1) LIMIT 1");
                break;
            case '9':
                $query = $this->db->query("UPDATE visor v SET v.suspension = 0, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas AND (SELECT v.idvisor FROM visor v WHERE v.idhojapruebas =  $idhojapruebas ORDER BY 1 DESC LIMIT 1) LIMIT 1");
                break;
            case '10':
                $query = $this->db->query("UPDATE visor v SET v.alineacion = 0, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas AND (SELECT v.idvisor FROM visor v WHERE v.idhojapruebas =  $idhojapruebas ORDER BY 1 DESC LIMIT 1) LIMIT 1");
                break;

            default:
                break;
        }
        $query = $this->db->query("UPDATE pruebas SET fechainicial=fechainicial, estado=9 WHERE idprueba=$idtipoprueba AND idhojapruebas=$idhojapruebas");
        $this->updateEnc($idtipoprueba);
        $query = $this->db->query("INSERT INTO pruebas  VALUES (NULL,$idhojapruebas,(SELECT p.fechainicial FROM pruebas p WHERE p.idprueba=$idtipoprueba LIMIT 1),
                                (SELECT p.prueba FROM pruebas p WHERE p.idprueba=$idtipoprueba LIMIT 1),0,NULL,NULL,1, (SELECT p.idtipo_prueba FROM pruebas p WHERE p.idprueba=$idtipoprueba LIMIT 1),
                                AES_ENCRYPT(JSON_OBJECT(
                                 'idhojapruebas',CAST($idhojapruebas AS CHAR(100000)),
                                 'fechainicial',CAST((SELECT p.fechainicial FROM pruebas p WHERE p.idprueba=$idtipoprueba LIMIT 1) AS CHAR(100000)),
                                 'prueba',CAST((SELECT p.prueba FROM pruebas p WHERE p.idprueba=$idtipoprueba LIMIT 1) AS CHAR(100000)),
                                 'estado',CAST(0 AS CHAR(100000)),
                                 'fechafinal',CAST(NULL AS CHAR(100000)),
                                 'idmaquina',CAST(NULL AS CHAR(100000)),
                                 'idusuario',CAST(1 AS CHAR(100000)),
                                 'idtipo_prueba',CAST((SELECT p.idtipo_prueba FROM pruebas p WHERE p.idprueba=$idtipoprueba LIMIT 1) AS CHAR(100000))),
                                 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c'))");
        if ($query) {
            return 1;
        } else {
            return 0;
        }
        //        $query = $this->db->query("DELETE FROM resultados WHERE idprueba=$idtipoprueba;");
        //        $query = $this->db->query("DELETE FROM imagenes WHERE idprueba=$idtipoprueba;");
        //        $query = $this->db->query("UPDATE pruebas SET fechainicial=fechainicial,estado=0,fechafinal= null, idmaquina = null WHERE idprueba=$idtipoprueba AND idhojapruebas=$idhojapruebas");
        //        if ($query) {
        //            return 1;
        //        } else {
        //            return 0;
        //        }
    }

    function deletePerifericos($idhojapruebas, $idtipoprueba)
    {
        $query = $this->db->query("DELETE FROM pruebas  WHERE idprueba=$idtipoprueba AND idhojapruebas=$idhojapruebas");
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    //-------------------------------------------------------- fin de reasignacion individual------------------------------------------//
    function getHojatrabajoPin($estado, $pin, $idhojapruebas)
    {
        $query = $this->db->query("UPDATE hojatrabajo  SET fechainicial=fechainicial, fechafinal=fechafinal, estadototal = $estado, pin0= $pin WHERE idhojapruebas=$idhojapruebas ");
        $query = $this->db->query("UPDATE visor v SET v.estadofinal = $estado, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas");
        return $query;
    }

    function getHojatrabajoPinEstado($pin, $idhojapruebas)
    {
        $query = $this->db->query("UPDATE hojatrabajo  SET fechainicial=fechainicial, fechafinal=fechafinal, pin0= $pin WHERE idhojapruebas=$idhojapruebas ");
        return $query;
    }

    //-------------------------------------------------------- fin de actualizacion estado y pin ------------------------------------------//
    function Createtaximetro($idhojapruebas, $pfechainicial)
    {
        $query = $this->db->query("INSERT INTO pruebas VALUES (NULL,$idhojapruebas,'$pfechainicial',0,0,NULL,NULL,1,6, AES_ENCRYPT('" . $this->encriptInsert($idhojapruebas, $pfechainicial, 0, 0, 1, 6) . "','" . $this->key . "') )");
        $query = $this->db->query("UPDATE visor v SET v.taximetro = 0, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas");
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    function Actualizarvehiculo($placa, $servicio, $combustible, $tipovehiculo)
    {
        $query = $this->db->query("UPDATE vehiculos v SET v.idservicio=$servicio, v.idtipocombustible=$combustible , v.tipo_vehiculo=$tipovehiculo  WHERE v.numero_placa='$placa'");
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    function AsignarDisel($idhojapruebas)
    {
        $query = $this->db->query("UPDATE pruebas p SET p.fechainicial=p.fechainicial, p.idtipo_prueba=2 WHERE p.idtipo_prueba=3 AND p.idhojapruebas=$idhojapruebas");
        $this->updateEnc2($idhojapruebas, "2");
        $query = $this->db->query("UPDATE visor v SET v.opacidad = 0, v.fecha = v.fecha, v.gases = null WHERE v.idhojapruebas = $idhojapruebas");
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    function AsignarGasolina($idhojapruebas)
    {
        $query = $this->db->query("UPDATE pruebas p SET p.fechainicial=p.fechainicial, p.idtipo_prueba=3 WHERE p.idtipo_prueba=2 AND p.idhojapruebas=$idhojapruebas");
        $this->updateEnc2($idhojapruebas, "2");
        $query = $this->db->query("UPDATE visor v SET v.opacidad = null, v.fecha = v.fecha, v.gases = 0 WHERE v.idhojapruebas = $idhojapruebas");
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    function deleteTaximetro($idhojapruebas)
    {
        $query = $this->db->query("DELETE FROM pruebas  WHERE  idhojapruebas=$idhojapruebas AND idtipo_prueba=6;");
        $query = $this->db->query("UPDATE visor v SET v.taximetro = null, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas");
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    function livianoapesado($idhojapruebas, $pfechainicial)
    {
        $this->db->trans_start();
        $query = $this->db->query("UPDATE pruebas SET idtipo_prueba=2, fechainicial=fechainicial WHERE idtipo_prueba=3 AND idhojapruebas=$idhojapruebas ");
        $this->updateEnc2($idhojapruebas, "2");
        $query = $this->db->query("UPDATE visor v SET v.opacidad = 0, v.fecha = v.fecha, v.gases = null, v.suspension = null WHERE v.idhojapruebas = $idhojapruebas");
        $query = $this->db->query("DELETE FROM pruebas  WHERE  idhojapruebas=$idhojapruebas AND idtipo_prueba=9 ");
        $query = $this->db->query("INSERT INTO pruebas VALUES (NULL,$idhojapruebas,'$pfechainicial',0,0,NULL,NULL,1,15,AES_ENCRYPT('" . $this->encriptInsert($idhojapruebas, $pfechainicial, 0, 0, 1, 15) . "','" . $this->key . "'))");
        $this->db->trans_complete();
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    function pesadoliviano($idhojapruebas, $pfechainicial)
    {
        $this->db->trans_start();
        $query = $this->db->query("UPDATE pruebas SET idtipo_prueba=3, fechainicial=fechainicial WHERE idtipo_prueba=2 AND idhojapruebas=$idhojapruebas ");
        $this->updateEnc2($idhojapruebas, "2");
        $query = $this->db->query("UPDATE visor v SET v.opacidad = null, v.fecha = v.fecha, v.gases = 0, v.suspension = 0 WHERE v.idhojapruebas = $idhojapruebas");
        $query = $this->db->query("DELETE FROM pruebas  WHERE  idhojapruebas=$idhojapruebas AND idtipo_prueba=15 AND fechainicial='$pfechainicial'");
        $query = $this->db->query("INSERT INTO pruebas VALUES (NULL,$idhojapruebas,'$pfechainicial',0,0,NULL,NULL,1,9,AES_ENCRYPT('" . $this->encriptInsert($idhojapruebas, $pfechainicial, 0, 0, 1, 9) . "','" . $this->key . "'))");
        $this->db->trans_complete();
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    function motoLiviano($idhojapruebas, $pfechainicial)
    {
        $this->db->trans_start();
        $query = $this->db->query("DELETE FROM pruebas  WHERE  idhojapruebas=$idhojapruebas AND idtipo_prueba=17 AND fechainicial='$pfechainicial'");
        $query = $this->db->query("INSERT INTO pruebas VALUES (NULL,$idhojapruebas,'$pfechainicial',0,0,NULL,NULL,1,9, AES_ENCRYPT('" . $this->encriptInsert($idhojapruebas, $pfechainicial, 0, 0, 1, 9) . "','" . $this->key . "'))");
        $query = $this->db->query("INSERT INTO pruebas VALUES (NULL,$idhojapruebas,'$pfechainicial',0,0,NULL,NULL,1,10, AES_ENCRYPT('" . $this->encriptInsert($idhojapruebas, $pfechainicial, 0, 0, 1, 10) . "','" . $this->key . "'))");
        $query = $this->db->query("INSERT INTO pruebas VALUES (NULL,$idhojapruebas,'$pfechainicial',0,0,NULL,NULL,1,16, AES_ENCRYPT('" . $this->encriptInsert($idhojapruebas, $pfechainicial, 0, 0, 1, 16) . "','" . $this->key . "'))");
        $query = $this->db->query("UPDATE visor v SET v.suspension = 0,v.alineacion = 0, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas");
        $this->db->trans_complete();
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    function livianoMoto($idhojapruebas, $pfechainicial)
    {
        $this->db->trans_start();
        $query = $this->db->query("UPDATE pruebas SET idtipo_prueba=17, fechainicial=fechainicial WHERE idtipo_prueba=16 AND idhojapruebas=$idhojapruebas ");
        $this->updateEnc2($idhojapruebas, "17");
        $query = $this->db->query("DELETE FROM pruebas  WHERE  idhojapruebas=$idhojapruebas AND idtipo_prueba=9 AND fechainicial='$pfechainicial'");
        $query = $this->db->query("DELETE FROM pruebas  WHERE  idhojapruebas=$idhojapruebas AND idtipo_prueba=10 AND fechainicial='$pfechainicial'");
        $query = $this->db->query("UPDATE visor v SET v.suspension = null, v.alineacion = null,  v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas");
        $this->db->trans_complete();
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    function pesadoMoto($idhojapruebas, $pfechainicial)
    {
        $this->db->trans_start();
        $query = $this->db->query("UPDATE pruebas SET idtipo_prueba=17, fechainicial=fechainicial WHERE idtipo_prueba=16 AND idhojapruebas=$idhojapruebas ");
        $this->updateEnc2($idhojapruebas, "17");
        $query = $this->db->query("UPDATE pruebas SET idtipo_prueba=3, fechainicial=fechainicial WHERE idtipo_prueba=2 AND idhojapruebas=$idhojapruebas ");
        $this->updateEnc2($idhojapruebas, "3");
        $query = $this->db->query("UPDATE visor v SET v.gases = 0, v.opacidad = null, v.alineacion = null, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas");
        $query = $this->db->query("DELETE FROM pruebas  WHERE  idhojapruebas=$idhojapruebas AND idtipo_prueba=10 AND fechainicial='$pfechainicial'");
        $query = $this->db->query("DELETE FROM pruebas  WHERE  idhojapruebas=$idhojapruebas AND idtipo_prueba=15 AND fechainicial='$pfechainicial'");
        $this->db->trans_complete();
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    function motoPesado($idhojapruebas, $pfechainicial)
    {
        $this->db->trans_start();
        $query = $this->db->query("UPDATE pruebas SET idtipo_prueba=2, fechainicial=fechainicial WHERE idtipo_prueba=3 AND idhojapruebas=$idhojapruebas ");
        $this->updateEnc2($idhojapruebas, "2");
        $query = $this->db->query("UPDATE visor v SET v.gases = null, v.opacidad = 0, v.alineacion = 0, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas");
        $query = $this->db->query("DELETE FROM pruebas  WHERE  idhojapruebas=$idhojapruebas AND idtipo_prueba=17 AND fechainicial='$pfechainicial'");
        $query = $this->db->query("INSERT INTO pruebas VALUES (NULL,$idhojapruebas,'$pfechainicial',0,0,NULL,NULL,1,10, AES_ENCRYPT('" . $this->encriptInsert($idhojapruebas, $pfechainicial, 0, 0, 1, 10) . "','" . $this->key . "'))");
        $query = $this->db->query("INSERT INTO pruebas VALUES (NULL,$idhojapruebas,'$pfechainicial',0,0,NULL,NULL,1,15, AES_ENCRYPT('" . $this->encriptInsert($idhojapruebas, $pfechainicial, 0, 0, 1, 15) . "','" . $this->key . "'))");
        $query = $this->db->query("INSERT INTO pruebas VALUES (NULL,$idhojapruebas,'$pfechainicial',0,0,NULL,NULL,1,16, AES_ENCRYPT('" . $this->encriptInsert($idhojapruebas, $pfechainicial, 0, 0, 1, 16) . "','" . $this->key . "'))");
        $this->db->trans_complete();
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    function asignarSonometro($idhojapruebas, $pfechainicial)
    {
        $this->db->trans_start();
        $query = $this->db->query("INSERT INTO pruebas VALUES (NULL,$idhojapruebas,'$pfechainicial',0,0,NULL,NULL,1,4, AES_ENCRYPT('" . $this->encriptInsert($idhojapruebas, $pfechainicial, 0, 0, 1, 4) . "','" . $this->key . "'))");
        $query = $this->db->query("UPDATE visor v SET v.sonometro = 0, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas");
        $this->db->trans_complete();
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    //-------------------------------------------------------- fin de reconfiguracion de pruebas ------------------------------------------//
    function cancelarPruebas($idhojapruebas, $reinspeccion)
    {
        $data = $this->db->query("SELECT 
                                    DATE_FORMAT(h.fechainicial,'%Y-%m-%d %H:%i:%s') AS fechai, 
                                    p.*
                                    FROM hojatrabajo h, pruebas p 
                                    WHERE 
                                    h.idhojapruebas= p.idhojapruebas AND 
                                    p.idhojapruebas= $idhojapruebas ORDER BY 1 DESC ");
        $rta = $data->result();
        if ($reinspeccion == 1) {
            $query = $this->db->query("UPDATE hojatrabajo h SET h.estadototal=7, h.reinspeccion=0, h.sicov=1, h.fechainicial=h.fechainicial, h.fechafinal=h.fechafinal WHERE h.idhojapruebas=$idhojapruebas");
            foreach ($rta as $value) {
                if ($value->estado == 3) {
                    $this->db->query("UPDATE pruebas p SET p.estado=1, p.fechainicial=p.fechainicial, p.fechafinal=p.fechafinal WHERE p.idhojapruebas=$idhojapruebas and p.estado=3");
                    $this->updateEnc3($idhojapruebas, "3");
                } elseif (($value->fechainicial !== $value->fechai) || $value->estado == 0) {
                    $this->db->trans_start();
                    $this->db->query("UPDATE pruebas p SET  p.estado=5, p.fechainicial=p.fechainicial, p.fechafinal=NOW(), p.idmaquina=$idhojapruebas,p.idusuario=1 WHERE p.idhojapruebas=$idhojapruebas and p.idprueba = $value->idprueba");
                    $this->updateEnc($value->idprueba);
                    $this->db->trans_complete();
                }
            }
            $query = $this->db->query("UPDATE visor v SET v.estadototal = 5, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas");
            return 1;
        } else {
            $query = $this->db->query("UPDATE hojatrabajo h SET h.estadototal=5, h.fechainicial=h.fechainicial, h.fechafinal=h.fechafinal WHERE h.idhojapruebas=$idhojapruebas");
            $query = $this->db->query("UPDATE visor v SET v.estadototal = 5, v.fecha = v.fecha WHERE v.idhojapruebas = $idhojapruebas");
            $query = $this->db->query("UPDATE pruebas p SET p.estado=5, p.fechainicial=p.fechainicial, p.fechafinal=p.fechafinal WHERE p.idhojapruebas=$idhojapruebas");
            $this->updateEnc4($idhojapruebas);
            return 1;
        }
    }

    //-------------------------------------------------------- fin cancelacion de pruebas ------------------------------------------//
    function registroentrada($where)
    {
        $query = $this->db->query("SELECT 
                                pp.fecha_prerevision 'Fecharegistro',
                                p.numero_identificacion 'Documentopropietario',
                                CONCAT(IFNULL(CONCAT(p.apellido1,' '),''),IFNULL(CONCAT(p.apellido2,' '),''),IFNULL(p.nombre1,''),IFNULL(CONCAT(' ',p.nombre2),'')) 'Nombrepropietario',
                                IFNULL(p.direccion,'NO REGISTRA') 'Direccionpropietario',
                                IFNULL(p.telefono1,'NO REGISTRA') 'Telefonopropietario',
                                IFNULL(p.correo,'NO REGISTRA') 'Correopropietario',
                                c.numero_identificacion 'Documentocliente',
                                CONCAT(IFNULL(CONCAT(c.apellido1,' '),''),IFNULL(CONCAT(c.apellido2,' '),''),IFNULL(c.nombre1,''),IFNULL(CONCAT(' ',c.nombre2),'')) 'Nombrecliente',
                                IFNULL(c.direccion,'NO REGISTRA') 'Direccioncliente',
                                IFNULL(c.telefono1,'NO REGISTRA') 'Telefonocliente',
                                IFNULL(c.correo,'NO REGISTRA') 'Correocliente',
                                v.numero_placa 'Placa',
                                CASE
                                    WHEN v.tipo_vehiculo = 1 THEN 'Liviano'
                                    WHEN v.tipo_vehiculo = 2 THEN 'Pesado'
                                    ELSE 'Moto'
                                END 'Tipovehiculo',
                                CASE
                                    WHEN v.idservicio = 1 THEN 'Oficial'
                                    WHEN v.idservicio = 2 THEN 'Público'
                                    WHEN v.idservicio = 3 THEN 'Particular'
                                    WHEN v.idservicio = 4 THEN 'Diplomático'	 	     
                                    ELSE 'EspecialRNMA'
                                END 'Servicio',
                                CASE
                                    WHEN v.taximetro = 1 THEN 'Si'
                                    ELSE 'No'
                                END 'Taxi',
                                CASE
                                    WHEN pp.tipo_inspeccion = 1 THEN 'Tecnico-mecánica'
                                    WHEN pp.tipo_inspeccion = 2 THEN 'Preventiva'
                                    ELSE 'Prueba libre'
                                END 'Tipoinspeccion',
                                CASE
                                    WHEN pp.reinspeccion = 0 THEN 'Primera vez'
                                    ELSE 'Segunda vez'
                                END 'Ocacion',
                                CASE
                                    WHEN v.ensenanza = 1 THEN 'SI'
                                    ELSE 'NO'
                                END 'Ensenanza'
                                FROM 
                                pre_prerevision pp,vehiculos v,clientes c, clientes p
                                WHERE
                                pp.numero_placa_ref=v.numero_placa AND
                                c.idcliente=v.idcliente AND
                                p.idcliente=v.idpropietarios AND
                                $where
                                GROUP BY v.numero_placa, pp.reinspeccion
                                ORDER BY pp.fecha_prerevision desc
                                ");
        return $query->result();
    }


    function encriptInsert($idhojapruebas, $fechainicial, $prueba, $estado, $idusuario, $idtipo_prueba)
    {
        $dat['idhojapruebas'] = $idhojapruebas;
        $dat['fechainicial'] = $fechainicial;
        $dat['prueba'] = "$prueba";
        $dat['estado'] = "$estado";
        $dat['fechafinal'] = NULL;
        $dat['idmaquina'] = NULL;
        $dat['idusuario'] = "$idusuario";
        $dat['idtipo_prueba'] = "$idtipo_prueba";
        $enc = json_encode($dat);
        return $enc;
    }

    function updateEnc($id)
    {
        $pruebas['idprueba'] = $id;
        $idprueba = $pruebas['idprueba'];
        $query2 = $this->db->query("SELECT * FROM pruebas p WHERE p.idprueba = $idprueba LIMIT 1");
        $pru = $query2->result();
        $dat['idhojapruebas'] = $pru[0]->idhojapruebas;
        $dat['fechainicial'] = $pru[0]->fechainicial;
        $dat['prueba'] = $pru[0]->prueba;
        $dat['estado'] = $pru[0]->estado;
        $dat['fechafinal'] = $pru[0]->fechafinal;
        $dat['idmaquina'] = $pru[0]->idmaquina;
        $dat['idusuario'] = $pru[0]->idusuario;
        $dat['idtipo_prueba'] = $pru[0]->idtipo_prueba;
        $enc = json_encode($dat);
        $key = $this->key;
        $Q = <<<EOF
                UPDATE
                pruebas
                SET
                fechainicial=fechainicial, enc=(SELECT AES_ENCRYPT('$enc','$key'))
                WHERE
                idprueba=$idprueba;
EOF;
        $this->db->query($Q);
    }

    function updateEnc2($idhojapruebas, $idtipo_prueba)
    {
        $query2 = $this->db->query("SELECT * FROM pruebas p WHERE p.idhojapruebas = $idhojapruebas and p.idtipo_prueba=$idtipo_prueba LIMIT 1");
        $pru = $query2->result();
        $idprueba = $pru[0]->idprueba;
        $dat['idhojapruebas'] = $pru[0]->idhojapruebas;
        $dat['fechainicial'] = $pru[0]->fechainicial;
        $dat['prueba'] = $pru[0]->prueba;
        $dat['estado'] = $pru[0]->estado;
        $dat['fechafinal'] = $pru[0]->fechafinal;
        $dat['idmaquina'] = $pru[0]->idmaquina;
        $dat['idusuario'] = $pru[0]->idusuario;
        $dat['idtipo_prueba'] = $pru[0]->idtipo_prueba;
        $enc = json_encode($dat);
        $key = $this->key;
        $Q = <<<EOF
                UPDATE
                pruebas
                SET
                fechainicial=fechainicial, enc=(SELECT AES_ENCRYPT('$enc','$key'))
                WHERE
                idprueba=$idprueba;
EOF;
        $this->db->query($Q);
    }

    function validEventosFinalizados($placa)
    {
        $consulta = <<<EOF
       SELECT * FROM eventosindra e WHERE e.idelemento  LIKE '%$placa%' 
            AND e.tipo = 'e' AND e.enviado = 0 AND 
            DATE_FORMAT(e.fecha, '%Y-%m-%d')  =  DATE_FORMAT(CURDATE(), '%Y-%m-%d')  
EOF;
        $rta = $this->db->query($consulta);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
            return $rta;
        } else {
            return [];
        }
    }

    function updateEnc3($idhojapruebas, $estado)
    {
        $query2 = $this->db->query("SELECT * FROM pruebas p WHERE p.idhojapruebas = $idhojapruebas and p.estado=$estado");
        $pruebas = $query2->result();
        foreach ($pruebas as $pru) {
            $idprueba = $pru->idprueba;
            $dat['idhojapruebas'] = $pru->idhojapruebas;
            $dat['fechainicial'] = $pru->fechainicial;
            $dat['prueba'] = $pru->prueba;
            $dat['estado'] = $pru->estado;
            $dat['fechafinal'] = $pru->fechafinal;
            $dat['idmaquina'] = $pru->idmaquina;
            $dat['idusuario'] = $pru->idusuario;
            $dat['idtipo_prueba'] = $pru->idtipo_prueba;
            $enc = json_encode($dat);
            $key = $this->key;
            $Q = <<<EOF
                UPDATE
                pruebas
                SET
                fechainicial=fechainicial, enc=(SELECT AES_ENCRYPT('$enc','$key'))
                WHERE
                idprueba=$idprueba;
EOF;
            $this->db->query($Q);
        }
    }

    function updateEnc4($idhojapruebas)
    {
        $query2 = $this->db->query("SELECT * FROM pruebas p WHERE p.idhojapruebas = $idhojapruebas");
        $pruebas = $query2->result();
        foreach ($pruebas as $pru) {
            $idprueba = $pru->idprueba;
            $dat['idhojapruebas'] = $pru->idhojapruebas;
            $dat['fechainicial'] = $pru->fechainicial;
            $dat['prueba'] = $pru->prueba;
            $dat['estado'] = $pru->estado;
            $dat['fechafinal'] = $pru->fechafinal;
            $dat['idmaquina'] = $pru->idmaquina;
            $dat['idusuario'] = $pru->idusuario;
            $dat['idtipo_prueba'] = $pru->idtipo_prueba;
            $enc = json_encode($dat);
            $key = $this->key;
            $Q = <<<EOF
                UPDATE
                pruebas
                SET
                fechainicial=fechainicial, enc=(SELECT AES_ENCRYPT('$enc','$key'))
                WHERE
                idprueba=$idprueba;
EOF;
            $this->db->query($Q);
        }
    }

    public function consultarConsecutivo($idhojapruebas)
    {
        $consulta = <<<EOF
                       SELECT * FROM  certificados c WHERE c.idhojapruebas = $idhojapruebas order by 1 desc 
EOF;
        $rta = $this->db->query($consulta);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
            return $rta[0];
        } else {
            return "";
        }
    }

    public function getDilucion($idhojapruebas, $reinspeccion)
    {
        $consulta = <<<EOF
                       SELECT r.valor
                            FROM resultados r
                            INNER JOIN pruebas p ON r.idprueba = p.idprueba
                            INNER JOIN hojatrabajo h ON p.idhojapruebas = h.idhojapruebas
                            WHERE p.idtipo_prueba = 3
                            AND (p.estado = 2)
                            AND h.idhojapruebas = $idhojapruebas
                            AND r.valor = 'DILUSION EXCESIVA'
EOF;
        $rta = $this->db->query($consulta);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
            return $rta;
        } else {
            return [];
        }
    }
}
