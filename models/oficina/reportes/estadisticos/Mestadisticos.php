<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mestadisticos extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->dbutil();
    }

    function getNombreCda() {
        $data = $this->db->query("select nombre_cda from cda");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data[0]->nombre_cda;
        } else {
            return FALSE;
        }
    }

// informe facturacion diaria
    function facturacion_diaria($fechainicial, $fechafinal) {
        $data = $this->db->query("select
                                  ifnull((select CAST(concat(ifnull(c.nombre1,''),' ',ifnull(c.nombre2,''),' ',ifnull(c.apellido1,''),' ',ifnull(c.apellido2,'')) AS CHAR(10000) CHARACTER SET utf8) from clientes c where c.idcliente=v.idcliente),'NO REGISTRA CLIENTE_________') cliente,
                                  ifnull((select c.telefono1 from clientes c where c.idcliente=v.idcliente),'NO REG') telefono,v.numero_placa placa,ht.fechainicial fecha,ht.factura factura,
                                  if(ht.reinspeccion=1 or ht.reinspeccion=0,'TM',if(ht.reinspeccion=4444 or ht.reinspeccion=44441,'PR',if(ht.reinspeccion=9999,'DP',''))) tipo,
                                  if(ht.pin1,ht.pin1,'0') valor
                                  from
                                  hojatrabajo ht, vehiculos v
                                  where
                                  v.idvehiculo=ht.idvehiculo and
                                  (ht.reinspeccion=1 or ht.reinspeccion=0 or ht.reinspeccion=4444 or ht.reinspeccion=44441 or ht.reinspeccion=9999) and ht.estadototal<>5 and
                                  DATE_FORMAT(ht.fechainicial,'%Y-%m-%d') between DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d') ORDER BY 1 ASC");
        return $data;
    }

//informe Inspecciones por defecto
    function inspecciones($fechainicial, $fechafinal) {
        $data = $this->db->query("SELECT 
                                  p.idprueba as prueba, v.numero_placa as placa,DATE_FORMAT(h.fechafinal,'%Y-%m-%d') fecha,h.reinspeccion motivo,
                                  if(p.estado=2,'A','R') as resultado, u.idusuario as inspector, c.numero_certificado as no_certificado,t.idtipo_vehiculo as cat,
                                  s.idservicio tipo,v.idtipocombustible comb,m.idmarca as marca,l.idlinea as modelo
                                  FROM 
                                  vehiculos v, hojatrabajo h, pruebas p,certificados c, linea as l, marca as m, servicio s, tipo_vehiculo t,usuarios u
                                  where 
                                  v.idvehiculo=h.idvehiculo and  h.idhojapruebas=p.idhojapruebas and h.estadototal<>5 and
                                  (select count(*) from resultados where idprueba=p.idprueba and (tiporesultado='T' or tiporesultado='defecto') and valor<>0)<>0 
                                  and p.estado<>0 and p.estado<>5 and c.idhojapruebas=h.idhojapruebas and l.idlinea=v.idlinea and l.idmarca = m.idmarca and s.idservicio=v.idservicio 
                                  and t.idtipo_vehiculo=v.tipo_vehiculo and p.idusuario=u.idusuario AND 
                                  DATE_FORMAT(h.fechainicial,'%Y-%m-%d') BETWEEN DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d')");

        return $data;
    }

    function defectos($idprueba) {
        $data = $this->db->query("select 
                                r.idprueba idprueba,r.valor codigo,concat(d.descripcion_defecto,' - ', r.observacion) descripcion,d.gravedad tipo 
                                from 
                                resultados r,defectos d where idprueba=" . $idprueba . " and r.valor=d.id_defectos");
        return $data->result();
    }

//Resumen diario de servicio
    public function resumendiarioservicio($fechainicial, $fechafinal) {
        $data = $this->db->query("select 
                                distinct v.numero_placa,v.tipo_vehiculo, DATE_FORMAT(h.fechainicial,'%Y-%m-%d') AS fechainicial, h.reinspeccion,DATE_FORMAT(p.fechainicial,'%H:%i:%s') horainicial, DATE_FORMAT(p.fechafinal,'%H:%i:%s') horafinal,
                                max(timediff(DATE_FORMAT(p.fechafinal,'%H:%i:%s'),DATE_FORMAT(p.fechainicial,'%H:%i:%s'))) tiempoespera,
                                if( 
                                (2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=1 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=2 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=3 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=4 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=5 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=6 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=7 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=8 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=9 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=10 order by idprueba desc limit 1),2))),'A','R') ar,
                                ifnull((select DATE_FORMAT(c.fecha_vigencia,'%Y-%m-%d') from certificados c where c.idhojapruebas=h.idhojapruebas limit 1),'N/A') fecha_vigencia,
                                ifnull((select format(c.usuario,0) from certificados c where c.idhojapruebas=h.idhojapruebas limit 1),'1') inspector,
                                ifnull((select c.numero_certificado from certificados c where c.idhojapruebas=h.idhojapruebas limit 1),'N/A') numero_certificado,
                                v.kilometraje,v.tipo_vehiculo,v.idservicio,(select m.idmarca from marca m,linea l where m.idmarca=l.idmarca and v.idlinea=l.idlinea) marca,v.idlinea
                                from 
                                hojatrabajo h, vehiculos v, pruebas p
                                where 
                                h.estadototal != 5 and v.idvehiculo=h.idvehiculo and p.idhojapruebas = h.idhojapruebas AND 
                                DATE_FORMAT(h.fechainicial,'%Y-%m-%d') BETWEEN DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d')  group by 1 order by 2");
        return $data->result();
    }

//Mapa de servicios entre fechas 
    function mapa_servicio_entre_fechas($fechainicial, $fechafinal) {
        $data = $this->db->query("select 
                                distinct v.numero_placa, h.reinspeccion,DATE_FORMAT(p.fechainicial,'%H:%i:%s') horainicial, DATE_FORMAT(p.fechafinal,'%H:%i:%s') horafinal,
                                concat(ti.id_mintransporte,'.',cl.numero_identificacion) documento,
                                if(h.reinspeccion=0 or h.reinspeccion=1,
                                if(v.tipo_vehiculo=1,ifnull((select valor from config_prueba where descripcion='insLiv' and idconfiguracion='555'),0),
                                if(v.tipo_vehiculo=2,ifnull((select valor from config_prueba where descripcion='insPes' and idconfiguracion='555'),0),
                                if(v.tipo_vehiculo=3,ifnull((select valor from config_prueba where descripcion='insMot' and idconfiguracion='555'),0),0))), 
                                if(h.reinspeccion=4444 or h.reinspeccion=44441 or h.reinspeccion=44440,
                                if(v.tipo_vehiculo=1,ifnull((select valor from config_prueba where descripcion='preLiv' and idconfiguracion='555'),0),
                                if(v.tipo_vehiculo=2,ifnull((select valor from config_prueba where descripcion='prePes' and idconfiguracion='555'),0),
                                if(v.tipo_vehiculo=3,ifnull((select valor from config_prueba where descripcion='preMot' and idconfiguracion='555'),0),0))), 
                                if(h.reinspeccion=7777 or h.reinspeccion=77771 or h.reinspeccion=77770,
                                if(v.tipo_vehiculo=1,ifnull((select valor from config_prueba where descripcion='perLiv' and idconfiguracion='555'),0),
                                if(v.tipo_vehiculo=2,ifnull((select valor from config_prueba where descripcion='perPes' and idconfiguracion='555'),0),
                                if(v.tipo_vehiculo=3,ifnull((select valor from config_prueba where descripcion='perMot' and idconfiguracion='555'),0),0))),
                                if(h.reinspeccion=9999,ifnull((select valor from config_prueba where descripcion='dupli' and idconfiguracion='555'),0),0)))) valor,
                                if(
                                (2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=1 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=2 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=3 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=4 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=5 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=6 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=7 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=8 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=9 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=10 order by idprueba desc limit 1),2))),'A','R') ar,
                                ifnull((select DATE_FORMAT(c.fecha_vigencia,'%Y-%m-%d') from certificados c where c.idhojapruebas=h.idhojapruebas limit 1),'N/A') fecha_vigencia,
                                ifnull((select format(c.usuario,0) from certificados c where c.idhojapruebas=h.idhojapruebas limit 1),'1') inspector,
                                ifnull((select c.numero_certificado from certificados c where c.idhojapruebas=h.idhojapruebas limit 1),'N/A') numero_certificado,
                                v.kilometraje,v.tipo_vehiculo,v.idservicio,(select m.idmarca from marca m,linea l where m.idmarca=l.idmarca and v.idlinea=l.idlinea) marca,v.idlinea
                                from 
                                hojatrabajo h, vehiculos v, pruebas p,clientes cl,tipo_identificacion ti
                                where 
                                h.estadototal!=5 and h.reinspeccion!=8888 and
                                v.idvehiculo=h.idvehiculo and p.idhojapruebas = h.idhojapruebas and cl.idcliente=v.idcliente 
                                and ti.tipo_identificacion=cl.tipo_identificacion AND 
                                DATE_FORMAT(h.fechainicial,'%Y-%m-%d') BETWEEN DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d')  group by 1");
        return $data->result();
    }

//Lista de defectos por inspector
    function lista_defectos_inspector($fechainicial, $fechafinal) {
        $data = $this->db->query("select 
                                p.idusuario
                                from 
                                hojatrabajo h,pruebas p, resultados r, defectos d
                                where 
                                h.idhojapruebas=p.idhojapruebas and r.idprueba=p.idprueba and
                                h.estadototal != 5 and (h.reinspeccion = 0 or h.reinspeccion = 1) AND
                                (r.tiporesultado='T' or r.tiporesultado='defecto')  and r.valor<>0 and
                                d.id_defectos=r.valor AND 
                                DATE_FORMAT(h.fechainicial,'%Y-%m-%d') BETWEEN DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d') group by 1 order by 1");
        return $data;
    }

    function numDefectos($fechainicial, $fechafinal, $idusurio) {
        $data = $this->db->query("select ifnull((select 
                                count(*)
                                from 
                                hojatrabajo h,pruebas p, resultados r, defectos d
                                where 
                                DATE_FORMAT(h.fechainicial,'%Y-%m-%d') BETWEEN DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d') 
                                and h.idhojapruebas=p.idhojapruebas and r.idprueba=p.idprueba and
                                h.estadototal != 5 and (h.reinspeccion = 0 or h.reinspeccion = 1) and (r.tiporesultado='T' or r.tiporesultado='defecto')  and r.valor<>0 and
                                d.id_defectos=r.valor and p.idusuario=$idusurio and d.gravedad='A'),0) as num_defA,
                                ifnull((select 
                                count(*)
                                from 
                                hojatrabajo h,pruebas p, resultados r, defectos d
                                where 
                                DATE_FORMAT(h.fechainicial,'%Y-%m-%d') BETWEEN DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d') 
                                and h.idhojapruebas=p.idhojapruebas and r.idprueba=p.idprueba and
                                h.estadototal != 5 and (h.reinspeccion = 0 or h.reinspeccion = 1) and (r.tiporesultado='T' or r.tiporesultado='defecto')  and r.valor<>0 and
                                d.id_defectos=r.valor and p.idusuario=$idusurio and d.gravedad='B'),0) as num_defB");

        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data[0];
        } else {
            return FALSE;
        }
    }

    //Inspector/categoria descriminada
    function inspectores($fechainicial, $fechafinal) {
        $data = $this->db->query("select 
                                p.idusuario,
                                IFNULL ((SELECT CONCAT(u.nombres,' ',u.apellidos) FROM usuarios u WHERE p.idusuario= u.IdUsuario), '---') AS 'user'
                                from 
                                hojatrabajo h,pruebas p 
                                where DATE_FORMAT(h.fechainicial,'%Y-%m-%d') BETWEEN DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d')  and 
                                h.estadototal != 5 and (h.reinspeccion = 0 or h.reinspeccion = 1) and h.idhojapruebas=p.idhojapruebas group by 1");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

//    function defectos($idprueba) {
//        $data = $this->db->query("select 
//r.idprueba idprueba,r.valor codigo,concat(d.descripcion_defecto,' - ', r.observacion) descripcion,d.gravedad tipo 
//from 
//resultados r,defectos d where idprueba=" . $idprueba . " and r.valor=d.id_defectos");
//        if ($data->num_rows() > 0) {
//            return $data;
//        } else {
//            return FALSE;
//        }
//    }

    function getNumDefectos($inspector, $tipoVehiculo, $servicio, $tipoDefecto, $gravedad, $rango) {
        $data = $this->db->query("select 
                                count(*) num
                                from 
                                resultados r, pruebas p, hojatrabajo h, usuarios u,vehiculos v,defectos d,tipo_defecto td
                                where 
                                DATE_FORMAT(h.fechafinal,'%Y-%m-%d') between " . $rango . " and
                                r.idprueba=p.idprueba and h.idhojapruebas=p.idhojapruebas and u.idusuario=p.idusuario and v.idclase!=15 and  v.idclase!=13 and
                                (r.tiporesultado='defecto' or r.tiporesultado='T') and d.id_defectos=r.valor and v.idvehiculo=h.idvehiculo  and h.estadototal!=5
                                and td.id_tipo_defecto=d.id_tipo_defecto and
                                p.idusuario=" . $inspector . " and v.tipo_vehiculo=" . $tipoVehiculo . " and (" . $servicio . ") and (" . $tipoDefecto . ") and d.gravedad='" . $gravedad . "'");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data[0]->num;
        } else {
            return FALSE;
        }
    }

    function getTotalNumDefectos($tipoDefecto, $gravedad, $rango) {
        $data = $this->db->query("select 
                                count(*) num
                                from 
                                resultados r, pruebas p, hojatrabajo h, usuarios u,vehiculos v,defectos d,tipo_defecto td
                                where 
                                DATE_FORMAT(h.fechafinal,'%Y-%m-%d') between " . $rango . " and
                                r.idprueba=p.idprueba and h.idhojapruebas=p.idhojapruebas and u.idusuario=p.idusuario and v.idclase!=15 and  v.idclase!=13 and h.estadototal!=5 and
                                (r.tiporesultado='defecto' or r.tiporesultado='T') and d.id_defectos=r.valor and v.idvehiculo=h.idvehiculo 
                                and td.id_tipo_defecto=d.id_tipo_defecto and (" . $tipoDefecto . ") and d.gravedad='" . $gravedad . "'");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data[0]->num;
        } else {
            return FALSE;
        }
    }

    function getNumDefectosRemolque($inspector, $idclase, $tipoDefecto, $gravedad, $rango) {
        $data = $this->db->query("select 
                                count(*) num
                                from 
                                resultados r, pruebas p, hojatrabajo h, usuarios u,vehiculos v,defectos d,tipo_defecto td
                                where 
                                DATE_FORMAT(h.fechafinal,'%Y-%m-%d') between " . $rango . " and
                                r.idprueba=p.idprueba and h.idhojapruebas=p.idhojapruebas and u.idusuario=p.idusuario and v.idclase=" . $idclase . " and
                                (r.tiporesultado='defecto' or r.tiporesultado='T') and d.id_defectos=r.valor and v.idvehiculo=h.idvehiculo  and h.estadototal!=5
                                and td.id_tipo_defecto=d.id_tipo_defecto and
                                p.idusuario=" . $inspector . " and (" . $tipoDefecto . ") and d.gravedad='" . $gravedad . "'");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data[0]->num;
        } else {
            return FALSE;
        }
    }

    function siDefectos($rango, $idUsuario) {
        $data = $this->db->query("select 
                                count(*) num
                                from 
                                resultados r2, pruebas p2, hojatrabajo h2
                                where 
                                DATE_FORMAT(h2.fechafinal,'%Y-%m-%d') between " . $rango . " and
                                r2.idprueba=p2.idprueba and h2.idhojapruebas=p2.idhojapruebas and
                                (r2.tiporesultado='defecto' or r2.tiporesultado='T') and h2.estadototal!=5 and p2.idusuario=" . $idUsuario);
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data[0]->num;
        } else {
            return FALSE;
        }
    }

//Lista de provisiones de servicios
    function lista_provisiones($fechainicial, $fechafinal) {
        $data = $this->db->query("select 
                                concat(c.nombre1,' ',c.nombre2,' ',c.apellido1,' ',c.apellido2) cliente,v.numero_placa,v.tipo_vehiculo,v.idservicio,
                                ifnull((select DATE_FORMAT(c.fecha_vigencia,'%Y-%m-%d') from certificados c where c.idhojapruebas=h.idhojapruebas limit 1),'N/A') vigencia,
                                if(h.reinspeccion=0 or h.reinspeccion=1,'Insp', 
                                if(h.reinspeccion=4444 or h.reinspeccion=44441 or h.reinspeccion=44440,'Prev', 
                                if(h.reinspeccion=7777 or h.reinspeccion=77771 or h.reinspeccion=77770,'Peri',
                                if(h.reinspeccion=9999,'Dupl','N/A')))) mot,
                                if(h.reinspeccion=0 or h.reinspeccion=1,
                                if(v.tipo_vehiculo=1,ifnull((select valor from config_prueba where descripcion='insLiv' and idconfiguracion='555'),0),
                                if(v.tipo_vehiculo=2,ifnull((select valor from config_prueba where descripcion='insPes' and idconfiguracion='555'),0),
                                if(v.tipo_vehiculo=3,ifnull((select valor from config_prueba where descripcion='insMot' and idconfiguracion='555'),0),0))), 
                                if(h.reinspeccion=4444 or h.reinspeccion=44441 or h.reinspeccion=44440,
                                if(v.tipo_vehiculo=1,ifnull((select valor from config_prueba where descripcion='preLiv' and idconfiguracion='555'),0),
                                if(v.tipo_vehiculo=2,ifnull((select valor from config_prueba where descripcion='prePes' and idconfiguracion='555'),0),
                                if(v.tipo_vehiculo=3,ifnull((select valor from config_prueba where descripcion='preMot' and idconfiguracion='555'),0),0))), 
                                if(h.reinspeccion=7777 or h.reinspeccion=77771 or h.reinspeccion=77770,
                                if(v.tipo_vehiculo=1,ifnull((select valor from config_prueba where descripcion='perLiv' and idconfiguracion='555'),0),
                                if(v.tipo_vehiculo=2,ifnull((select valor from config_prueba where descripcion='perPes' and idconfiguracion='555'),0),
                                if(v.tipo_vehiculo=3,ifnull((select valor from config_prueba where descripcion='perMot' and idconfiguracion='555'),0),0))),
                                if(h.reinspeccion=9999,ifnull((select valor from config_prueba where descripcion='dupli' and idconfiguracion='555'),0),0)))) valor
                                from 
                                hojatrabajo h,vehiculos v,clientes c
                                where 
                                DATE_FORMAT(h.fechainicial,'%Y-%m-%d') BETWEEN DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d') 
                                and h.estadototal !=5 and h.reinspeccion!=8888 and
                                h.idvehiculo=v.idvehiculo and c.idcliente=v.idcliente");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    //Aprobados rechazados por año de matricula
    function aprobadosInspeccion($sentencia, $rangoFecha) {
        $data = $this->db->query("SELECT 
                                count(*) as valor
                                FROM 
                                vehiculos v, hojatrabajo h
                                where 
                                v.idvehiculo=h.idvehiculo and 
                                DATE_FORMAT(v.fecha_matricula,'%Y') " . $sentencia . " and DATE_FORMAT(h.fechafinal,'%Y-%m-%d') between " . $rangoFecha . " and h.reinspeccion=0  and h.estadototal<>5 and
                                (
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=1 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=2 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=3 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=4 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=5 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=6 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=7 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=8 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=9 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=10 order by idprueba desc limit 1),2)))");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data[0]->valor;
        } else {
            return FALSE;
        }
    }

    function rechazadosInspeccion($sentencia, $rangoFecha) {
        $data = $this->db->query("SELECT 
                                count(*) as valor
                                FROM 
                                vehiculos v, hojatrabajo h
                                where 
                                v.idvehiculo=h.idvehiculo  and h.estadototal<>5 and 
                                DATE_FORMAT(v.fecha_matricula,'%Y') " . $sentencia . " and DATE_FORMAT(h.fechafinal,'%Y-%m-%d') between " . $rangoFecha . " and (h.reinspeccion=0 or h.reinspeccion=1) and
                                (
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=1 order by idprueba asc limit 1),2)) or 
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=2 order by idprueba asc limit 1),2)) or 
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=3 order by idprueba asc limit 1),2)) or 
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=4 order by idprueba asc limit 1),2)) or 
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=5 order by idprueba asc limit 1),2)) or 
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=6 order by idprueba asc limit 1),2)) or 
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=7 order by idprueba asc limit 1),2)) or 
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=8 order by idprueba asc limit 1),2)) or 
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=9 order by idprueba asc limit 1),2)) or 
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=10 order by idprueba asc limit 1),2)))");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data[0]->valor;
        } else {
            return FALSE;
        }
    }

    function aprobadosReinspeccion($sentencia, $rangoFecha) {
        $data = $this->db->query("SELECT 
                                count(*) as valor
                                FROM 
                                vehiculos v, hojatrabajo h
                                where 
                                v.idvehiculo=h.idvehiculo and h.estadototal<>5 and 
                                DATE_FORMAT(v.fecha_matricula,'%Y') " . $sentencia . " and DATE_FORMAT(h.fechafinal,'%Y-%m-%d') between " . $rangoFecha . " and h.reinspeccion=1 and
                                (
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=1 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=2 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=3 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=4 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=5 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=6 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=7 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=8 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=9 order by idprueba desc limit 1),2)) and 
                                2 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=10 order by idprueba desc limit 1),2)))");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data[0]->valor;
        } else {
            return FALSE;
        }
    }

    function rechazadosReinspeccion($sentencia, $rangoFecha) {
        $data = $this->db->query("SELECT 
                                count(*) as valor
                                FROM 
                                vehiculos v, hojatrabajo h
                                where 
                                v.idvehiculo=h.idvehiculo and h.estadototal<>5 and 
                                DATE_FORMAT(v.fecha_matricula,'%Y') " . $sentencia . " and DATE_FORMAT(h.fechafinal,'%Y-%m-%d') between " . $rangoFecha . " and (h.reinspeccion=1) and
                                (
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=1 order by idprueba desc limit 1),2)) or 
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=2 order by idprueba desc limit 1),2)) or 
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=3 order by idprueba desc limit 1),2)) or 
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=4 order by idprueba desc limit 1),2)) or 
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=5 order by idprueba desc limit 1),2)) or 
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=6 order by idprueba desc limit 1),2)) or 
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=7 order by idprueba desc limit 1),2)) or 
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=8 order by idprueba desc limit 1),2)) or 
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=9 order by idprueba desc limit 1),2)) or 
                                3 = (ifnull((select if(estado=1 or estado=3 or estado=0,3,2) from pruebas where idhojapruebas=h.idhojapruebas and (estado=1 or estado = 2 or estado =3 or estado =0) and idtipo_prueba=10 order by idprueba desc limit 1),2)))");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data[0]->valor;
        } else {
            return FALSE;
        }
    }

    function totalReinspeccion($sentencia, $rangoFecha) {
        $data = $this->db->query("SELECT 
                                count(*) as valor
                                FROM 
                                vehiculos v, hojatrabajo h
                                where 
                                v.idvehiculo=h.idvehiculo and h.estadototal<>5 and 
                                DATE_FORMAT(v.fecha_matricula,'%Y') " . $sentencia . " and DATE_FORMAT(h.fechafinal,'%Y-%m-%d') between " . $rangoFecha . " and (h.reinspeccion=1)");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data[0]->valor;
        } else {
            return FALSE;
        }
    }

//Clientes adquiridos,perdidos y retornados
    function clientesAdquiridos($fechainicial, $fechafinal) {
        $data = $this->db->query("SELECT 
                                distinct v.numero_placa,concat(m.nombre,' - ', l.nombre) marca, DATE_FORMAT(c.fecha_vigencia,'%Y-%m-%d') fecha,concat(cl.nombre1,' ',cl.apellido1) propietario,
                                cl.direccion direccion, cl.telefono1, cl.telefono2, ci.nombre ciudad,c.usuario ,if(c.estado=2 ,'R','A') AR
                                FROM 
                                certificados c, hojatrabajo h, vehiculos v,clientes cl, linea l, marca m, ciudades ci
                                where 
                                DATE_ADD(DATE_FORMAT(c.fechaimpresion,'%Y-%m-%d'),INTERVAL 1 YEAR) between DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d') and
                                c.idhojapruebas=h.idhojapruebas and h.idvehiculo=v.idvehiculo and cl.idcliente = v.idcliente and v.idlinea=l.idlinea and l.idmarca=m.idmarca and cl.cod_ciudad=ci.cod_ciudad and
                                (SELECT 
                                count(*)
                                FROM 
                                certificados c2, hojatrabajo h2, vehiculos v2,clientes cl2
                                where
                                c2.idhojapruebas=h2.idhojapruebas and h2.idvehiculo=v2.idvehiculo and cl2.idcliente = v2.idcliente and cl2.idcliente=cl.idcliente) = 1");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    function clientesRetornados($fechainicial, $fechafinal) {
        $data = $this->db->query("SELECT 
                                distinct v.numero_placa,concat(m.nombre,' - ', l.nombre) marca, DATE_FORMAT(c.fecha_vigencia,'%Y-%m-%d') fecha,concat(cl.nombre1,' ',cl.apellido1) propietario,
                                cl.direccion direccion, cl.telefono1, cl.telefono2, ci.nombre ciudad,c.usuario,if(c.estado=2 ,'R','A') AR
                                FROM 
                                certificados c, hojatrabajo h, vehiculos v,clientes cl, linea l, marca m, ciudades ci
                                where 
                                DATE_ADD(DATE_FORMAT(c.fechaimpresion,'%Y-%m-%d'),INTERVAL 1 YEAR) between DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d') and
                                c.idhojapruebas=h.idhojapruebas and h.idvehiculo=v.idvehiculo and cl.idcliente = v.idcliente and v.idlinea=l.idlinea and l.idmarca=m.idmarca and cl.cod_ciudad=ci.cod_ciudad and
                                (SELECT 
                                count(*)
                                FROM 
                                certificados c2, hojatrabajo h2, vehiculos v2,clientes cl2
                                where
                                c2.idhojapruebas=h2.idhojapruebas and h2.idvehiculo=v2.idvehiculo and cl2.idcliente = v2.idcliente and cl2.idcliente=cl.idcliente) != 1");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    function clientesPerdidos($fechaperdidos, $fechafinal) {
        $data = $this->db->query("SELECT 
                                distinct v.numero_placa,concat(m.nombre,' - ', l.nombre) marca, DATE_FORMAT(c.fecha_vigencia,'%Y-%m-%d') fecha,concat(cl.nombre1,' ',cl.apellido1) propietario,
                                cl.direccion direccion, cl.telefono1, cl.telefono2, ci.nombre ciudad,c.usuario,if(c.estado=2 ,'R','A') AR
                                FROM 
                                certificados c, hojatrabajo h, vehiculos v,clientes cl, linea l, marca m, ciudades ci
                                where 
                                DATE_ADD(DATE_FORMAT(c.fechaimpresion,'%Y-%m-%d'),INTERVAL 1 YEAR) between DATE_FORMAT('$fechaperdidos','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d') and
                                c.idhojapruebas=h.idhojapruebas and h.idvehiculo=v.idvehiculo and cl.idcliente = v.idcliente and v.idlinea=l.idlinea and l.idmarca=m.idmarca and cl.cod_ciudad=ci.cod_ciudad ");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    function getContrasenas($fechainicial, $fechafinal) {
        $data = $this->db->query("SELECT 
                        IFNULL((SELECT CONCAT(u.nombres, ' ', u.apellidos) FROM usuarios u WHERE u.IdUsuario = h.idusuario LIMIT 1),'---') AS 'Usuario',
                        h.fecha AS 'Fecha de cambio'
                        FROM historico_pass h 
                        WHERE DATE_FORMAT(h.fecha,'%Y-%m-%d')  BETWEEN '$fechainicial' AND '$fechafinal' ");
        return $data;
        
    }

}
