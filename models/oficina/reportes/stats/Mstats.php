<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mstats extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function infoservicio()
    {
        $data = $this->db->query("SELECT s.idservicio,s.nombre FROM servicio s");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function infoclase()
    {
        $data = $this->db->query("SELECT c.idclase, c.nombre FROM clase c");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function infomarca()
    {
        $data = $this->db->query("SELECT m.idmarca AS 'idmarcaR', m.nombre FROM  marca m ORDER BY 2");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function infolinea($idlinea)
    {
        $data = $this->db->query("SELECT l.idlinea AS 'lineaR', l.nombre FROM linea l WHERE l.idmarca=$idlinea ORDER BY 2");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function infotipovehiculo()
    {
        $data = $this->db->query("SELECT * FROM tipo_vehiculo");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function infocombustible()
    {
        $data = $this->db->query("SELECT * FROM tipo_combustible");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function infousuarios()
    {
        $data = $this->db->query("SELECT u.IdUsuario, u.nombres, u.idperfil FROM usuarios u WHERE (u.idperfil=2 OR u.idperfil=6 OR u.idperfil=1 OR u.idperfil=3)");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function statsvehiculos($fechainicialv, $fechafinalv)
    {
        $data = $this->db->query("SELECT  
                                    DATE_FORMAT(h.fechainicial, '%Y/%m/%d %h:%i:%s') AS 'Fecha_inicial',
                                    v.numero_placa AS 'Placa',
                                    IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idcliente=cl.idcliente ORDER BY 1 LIMIT 1),'--.') AS 'Cliente',
                                    IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idpropietarios=cl.idcliente ORDER BY 1 LIMIT 1),'--.') AS 'Propietario',
                                    IF(v.registroRunt=1,
                                    (SELECT m.nombre FROM linearunt l,marcarunt m WHERE l.idmarcarunt=m.idmarcarunt AND l.idlinearunt=v.idlinea),
                                    (SELECT m.nombre FROM linea l,marca m WHERE l.idmarca=m.idmarca AND l.idlinea=v.idlinea)) Marca,
                                    IF(v.registroRunt=1,
                                    (SELECT l.nombre FROM  linearunt l WHERE l.idlinearunt=v.idlinea),
                                    (SELECT l.nombre FROM linea l WHERE l.idlinea=v.idlinea)) 'Linea',
                                     CASE
                                        WHEN h.estadototal= 1 THEN 'Asignado'
                                        WHEN h.estadototal = 2 THEN 'Aprobado'
                                        WHEN h.estadototal = 4 THEN 'Certificado'
                                        WHEN h.estadototal = 3 THEN 'Rechazado'
                                        WHEN h.estadototal = 9 THEN 'Reasignado'
                                        ELSE 'Abortado'
                                    END AS 'Estado',
                                     CASE
                                        WHEN h.reinspeccion = 0 THEN 'Primera vez TCM '
                                        WHEN h.reinspeccion = 1 THEN 'Reinspeecion TCM'
                                        WHEN h.reinspeccion = 4444 THEN 'Primera vez PRV'
                                        WHEN h.reinspeccion = 44441 THEN 'Reinspeecion PRV'
                                        ELSE 'Prueba libre'
                                    END AS 'Ocacion',
                                    c.nombre AS 'Clase',
                                    s.nombre AS 'Servicio',
                                    t.nombre AS 'Combustible',
                                    v.ano_modelo AS 'Modelo',
                                    tv.nombre AS 'Tipo_vehiculo',
                                    v.cilindraje AS 'Cilindraje',
                                    v.cilindros AS 'Cilindros',
                                    v.num_pasajeros AS 'Numero_pasajeros',
                                    v.kilometraje AS 'kilometraje',
                                    IF(v.taximetro = 1, 'Aplica', 'No aplica') AS 'Taximetro',
                                    IF(v.tiempos = 2,'2 Tiempos','4 Tiempos') AS 'Tiempos',
                                    IF(v.ensenanza = 1, 'Aplica', 'No aplica') AS 'Ensenanza' 
                                    FROM 
                                    vehiculos v, hojatrabajo h, servicio s, tipo_combustible t, clase c, tipo_vehiculo tv, linea l, marca m 
                                    WHERE 
                                    v.idvehiculo=h.idvehiculo AND v.idservicio = s.idservicio AND v.idtipocombustible = t.idtipocombustible AND v.idclase = c.idclase AND 
                                    v.tipo_vehiculo = tv.idtipo_vehiculo AND v.idlinea=l.idlinea AND l.idmarca=m.idmarca AND 
                                    DATE_FORMAT(h.fechafinal,'%Y-%m-%d') between DATE_FORMAT('$fechainicialv','%Y-%m-%d') AND DATE_FORMAT('$fechafinalv','%Y-%m-%d')");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function statsvehiculoswhere($where, $fechainicialv, $fechafinalv)
    {
        $data = $this->db->query("SELECT  
                                    DATE_FORMAT(h.fechainicial, '%Y/%m/%d %h:%i:%s') AS 'Fecha_inicial',
                                    v.numero_placa AS 'Placa',
                                    IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idcliente=cl.idcliente ORDER BY 1 LIMIT 1),'--.') AS 'Cliente',
                                    IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idpropietarios=cl.idcliente ORDER BY 1 LIMIT 1),'--.') AS 'Propietario',
                                    IF(v.registroRunt=1,
                                    (SELECT m.nombre FROM linearunt l,marcarunt m WHERE l.idmarcarunt=m.idmarcarunt AND l.idlinearunt=v.idlinea),
                                    (SELECT m.nombre FROM linea l,marca m WHERE l.idmarca=m.idmarca AND l.idlinea=v.idlinea)) Marca,
                                    IF(v.registroRunt=1,
                                    (SELECT l.nombre FROM  linearunt l WHERE l.idlinearunt=v.idlinea),
                                    (SELECT l.nombre FROM linea l WHERE l.idlinea=v.idlinea)) 'Linea',
                                     CASE
                                        WHEN p.estado = 0 THEN 'Asignado'
                                        WHEN h.estadototal = 2 THEN 'Aprobado'
                                        WHEN h.estadototal = 4 THEN 'Certificado'
                                        WHEN h.estadototal = 3 THEN 'Rechazado'
                                        WHEN h.estadototal = 9 THEN 'Reasignado'
                                        ELSE 'Abortado'
                                    END AS 'Estado',
                                     CASE
                                        WHEN h.reinspeccion = 0 THEN 'Primera vez TCM '
                                        WHEN h.reinspeccion = 1 THEN 'Reinspeecion TCM'
                                        WHEN h.reinspeccion = 4444 THEN 'Primera vez PRV'
                                        WHEN h.reinspeccion = 44441 THEN 'Reinspeecion PRV'
                                        ELSE 'Prueba libre'
                                    END AS 'Ocacion',
                                    c.nombre AS 'Clase',
                                    s.nombre AS 'Servicio',
                                    t.nombre AS 'Combustible',
                                    v.ano_modelo AS 'Modelo',
                                    tv.nombre AS 'Tipo_vehiculo',
                                    v.cilindraje AS 'Cilindraje',
                                    v.cilindros AS 'Cilindros',
                                    v.num_pasajeros AS 'Numero_pasajeros',
                                    v.kilometraje AS 'kilometraje',
                                    IF(v.taximetro = 1, 'Aplica', 'No aplica') AS 'Taximetro',
                                    IF(v.tiempos = 2,'2 Tiempos','4 Tiempos') AS 'Tiempos',
                                    IF(v.ensenanza = 1, 'Aplica', 'No aplica') AS 'Ensenanza' 
                                    FROM 
                                    vehiculos v, hojatrabajo h, servicio s, tipo_combustible t, clase c, tipo_vehiculo tv,linea l, marca m 
                                    WHERE 
                                    v.idvehiculo=h.idvehiculo AND v.idservicio = s.idservicio AND v.idtipocombustible = t.idtipocombustible AND v.idclase = c.idclase AND 
                                    v.tipo_vehiculo = tv.idtipo_vehiculo AND v.idlinea=l.idlinea AND l.idmarca=m.idmarca $where AND 
                                    DATE_FORMAT(h.fechafinal,'%Y-%m-%d') between DATE_FORMAT('$fechainicialv','%Y-%m-%d') AND DATE_FORMAT('$fechafinalv','%Y-%m-%d')");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function statspruebas($fechainicialp, $fechafinalp)
    {
        $data = $this->db->query("SELECT
h.idhojapruebas,
                                DATE_FORMAT(h.fechainicial, '%Y/%m/%d %h:%i:%s') AS 'Fecha_inicial',
                                v.numero_placa AS 'Placa',
                                IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idcliente=cl.idcliente ORDER BY 1 LIMIT 1),'---') AS 'Cliente',
                                IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idpropietarios=cl.idcliente ORDER BY 1 LIMIT 1),'---') AS 'Propietario',
                                IF(v.registroRunt=1,
                                (SELECT m.nombre FROM linearunt l,marcarunt m WHERE l.idmarcarunt=m.idmarcarunt AND l.idlinearunt=v.idlinea),
                                (SELECT m.nombre FROM linea l,marca m WHERE l.idmarca=m.idmarca AND l.idlinea=v.idlinea)) Marca,
                                IF(v.registroRunt=1,
                                (SELECT l.nombre FROM  linearunt l WHERE l.idlinearunt=v.idlinea),
                                (SELECT l.nombre FROM linea l WHERE l.idlinea=v.idlinea)) 'Linea',
                                IFNULL((SELECT u.identificacion FROM usuarios u, pruebas p WHERE h.idhojapruebas = p.idhojapruebas AND p.idusuario = u.IdUsuario LIMIT 1 ),'---') AS 'Documento',
                                IFNULL((SELECT CONCAT(u.nombres,u.apellidos) FROM usuarios u, pruebas p WHERE h.idhojapruebas = p.idhojapruebas AND p.idusuario = u.IdUsuario LIMIT 1 ),'---') AS 'Operario',
                                CASE
                                  WHEN h.estadototal = 1 THEN 'Asignado'
                                  WHEN h.estadototal = 2 THEN 'Aprobado'
                                  WHEN h.estadototal = 4 THEN 'Certificado'
                                  WHEN h.estadototal = 3 THEN 'Rechazado'
                                  ELSE 'Abortado'
                                END AS 'Estado_final',
                                CASE
                                  WHEN h.reinspeccion = 0 THEN 'Primera vez TCM '
                                  WHEN h.reinspeccion = 1 THEN 'Reinspeecion TCM'
                                  WHEN h.reinspeccion = 4444 THEN 'Primera vez PRV'
                                  WHEN h.reinspeccion = 44441 THEN 'Reinspeecion PRV'
                                  ELSE 'Prueba libre'
                                END AS 'Ocacion',
                                c.nombre AS 'Clase',
                                s.nombre AS 'Servicio',
                                t.nombre AS 'Combustible',
                                v.ano_modelo AS 'Modelo',
                                tv.nombre AS 'Tipo_vehiculo',
                                v.cilindraje AS 'Cilindraje',
                                v.cilindros AS 'Cilindros',
                                v.kilometraje AS 'kilometraje',
                                v.num_pasajeros AS 'Numero_pasajeros',
                                IF(v.taximetro = 1, 'Aplica', 'No aplica') AS 'Taximetro',
                                IF(v.tiempos = 2,'2 Tiempos','4 Tiempos') AS 'Tiempos',
                                IF(v.ensenanza = 1, 'Aplica', 'No aplica') AS 'Ensenanza',
                                IFNULL(IF((SELECT p.estado FROM pruebas p WHERE h.idhojapruebas = p.idhojapruebas LIMIT 1) = 5,
										  (SELECT 
                                if((r.observacion = 'razon_cancelacion' OR r.observacion = 'Aborto'),
                                r.valor,
                                r.observacion)
										  from resultados r, pruebas p 
										  WHERE 
										  h.idhojapruebas = p.idhojapruebas 
										  AND  p.idprueba = r.idprueba 
										  AND  (r.idconfig_prueba = 175 OR r.observacion = 'Fallas del equipo de medición' OR 
										  r.observacion = 'Falla súbita del fluido eléctrico' OR 
										  r.observacion = 'Bloqueo forzado del equipo' OR 
										  r.observacion = 'Ejecución incorrecta de la prueba' OR 
                                r.observacion = 'razon_cancelacion')
										  limit 1),
										  '---'),
										  '---') AS 'Razon_aborto',
                                IFNULL(IF((SELECT p.estado FROM pruebas p WHERE h.idhojapruebas = p.idhojapruebas LIMIT 1) = 5,
                                (SELECT CONCAT(u.nombres, '', u.apellidos) from resultados r, pruebas p, usuarios u 
                                WHERE h.idhojapruebas = p.idhojapruebas AND  p.idprueba= r.idprueba and  p.idusuario = u.idusuario AND (r.idconfig_prueba = 175 OR r.observacion = 'Fallas del equipo de medición' OR 
										  r.observacion = 'Falla súbita del fluido eléctrico' OR 
										  r.observacion = 'Bloqueo forzado del equipo' OR 
										  r.observacion = 'Ejecución incorrecta de la prueba' OR 
                                r.observacion = 'razon_cancelacion') limit 1),
                                '---'),'---') AS 'Usuario_aborto_prueba',
                                 if(h.estadototal = 5, IFNULL((SELECT CONCAT(u.nombres, ' ', u.apellidos) FROM usuarios u WHERE h.usuario = u.IdUsuario LIMIT 1),''),'---') AS 'prueba_cancelada'
                                 
                                 FROM 
                                 vehiculos v, hojatrabajo h,  servicio s, tipo_combustible t, clase c, tipo_vehiculo tv, linea l, marca m 
                                 WHERE 
                                 v.idvehiculo=h.idvehiculo    AND v.idservicio = s.idservicio AND v.idtipocombustible = t.idtipocombustible AND v.idclase = c.idclase AND 
                                 v.tipo_vehiculo = tv.idtipo_vehiculo AND v.idlinea=l.idlinea AND l.idmarca=m.idmarca AND 
                                 DATE_FORMAT(h.fechainicial,'%Y-%m-%d') between DATE_FORMAT('$fechainicialp','%Y-%m-%d') AND DATE_FORMAT('$fechafinalp','%Y-%m-%d') ORDER BY 1 DESC");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
        //        $data = $this->db->query("SELECT
        //                                DATE_FORMAT(h.fechainicial, '%Y/%m/%d %h:%i:%s') AS 'Fecha_inicial',
        //                                v.numero_placa AS 'Placa',
        //                                IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idcliente=cl.idcliente ORDER BY 1 LIMIT 1),'---') AS 'Cliente',
        //                                IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idpropietarios=cl.idcliente ORDER BY 1 LIMIT 1),'---') AS 'Propietario',
        //                                IF(v.registroRunt=1,
        //                                (SELECT m.nombre FROM linearunt l,marcarunt m WHERE l.idmarcarunt=m.idmarcarunt AND l.idlinearunt=v.idlinea),
        //                                (SELECT m.nombre FROM linea l,marca m WHERE l.idmarca=m.idmarca AND l.idlinea=v.idlinea)) Marca,
        //                                IF(v.registroRunt=1,
        //                                (SELECT l.nombre FROM  linearunt l WHERE l.idlinearunt=v.idlinea),
        //                                (SELECT l.nombre FROM linea l WHERE l.idlinea=v.idlinea)) 'Linea',
        //                                IFNULL((SELECT u.identificacion FROM usuarios u, pruebas p WHERE h.idhojapruebas = p.idhojapruebas AND p.idusuario = u.IdUsuario LIMIT 1 ),'---') AS 'Documento',
        //                                IFNULL((SELECT CONCAT(u.nombres,u.apellidos) FROM usuarios u, pruebas p WHERE h.idhojapruebas = p.idhojapruebas AND p.idusuario = u.IdUsuario LIMIT 1 ),'---') AS 'Operario',
        //                                CASE
        //                                  WHEN h.estadototal = 1 THEN 'Asignado'
        //                                  WHEN h.estadototal = 2 THEN 'Aprobado'
        //                                  WHEN h.estadototal = 4 THEN 'Certificado'
        //                                  WHEN h.estadototal = 3 THEN 'Rechazado'
        //                                  ELSE 'Abortado'
        //                                END AS 'Estado_final',
        //                                CASE
        //                                  WHEN h.reinspeccion = 0 THEN 'Primera vez TCM '
        //                                  WHEN h.reinspeccion = 1 THEN 'Reinspeecion TCM'
        //                                  WHEN h.reinspeccion = 4444 THEN 'Primera vez PRV'
        //                                  WHEN h.reinspeccion = 44441 THEN 'Reinspeecion PRV'
        //                                  ELSE 'Prueba libre'
        //                                END AS 'Ocacion',
        //                                c.nombre AS 'Clase',
        //                                s.nombre AS 'Servicio',
        //                                t.nombre AS 'Combustible',
        //                                v.ano_modelo AS 'Modelo',
        //                                tv.nombre AS 'Tipo_vehiculo',
        //                                v.cilindraje AS 'Cilindraje',
        //                                v.cilindros AS 'Cilindros',
        //                                v.num_pasajeros AS 'Numero_pasajeros',
        //                                v.kilometraje AS 'kilometraje',
        //                                IF(v.taximetro = 1, 'Aplica', 'No aplica') AS 'Taximetro',
        //                                IF(v.tiempos = 2,'2 Tiempos','4 Tiempos') AS 'Tiempos',
        //                                IF(v.ensenanza = 1, 'Aplica', 'No aplica') AS 'Ensenanza',
        //                                IFNULL(IF((SELECT p.estado FROM pruebas p WHERE h.idhojapruebas = p.idhojapruebas LIMIT 1) = 5,(SELECT r.valor from resultados r, pruebas p WHERE h.idhojapruebas = p.idhojapruebas AND  p.idprueba= r.idprueba and  r.idconfig_prueba= 175 limit 1),'---'),'---') AS 'Aborto',
        //                                 IFNULL(IF(h.estadototal = 5,(SELECT CONCAT(u.nombres,' ',u.apellidos)  FROM usuarios u WHERE h.usuario = u.IdUsuario limit 1),'---'),'---') AS 'Usuario_que_cancelo_la_prueba'
        //                                 FROM 
        //                                 vehiculos v, hojatrabajo h,  servicio s, tipo_combustible t, clase c, tipo_vehiculo tv, linea l, marca m 
        //                                 WHERE 
        //                                 v.idvehiculo=h.idvehiculo    AND v.idservicio = s.idservicio AND v.idtipocombustible = t.idtipocombustible AND v.idclase = c.idclase AND 
        //                                 v.tipo_vehiculo = tv.idtipo_vehiculo AND v.idlinea=l.idlinea AND l.idmarca=m.idmarca AND 
        //                                 DATE_FORMAT(h.fechainicial,'%Y-%m-%d') between DATE_FORMAT('$fechainicialp','%Y-%m-%d') AND DATE_FORMAT('$fechafinalp','%Y-%m-%d') ORDER BY 1 DESC");
        //        if ($data->num_rows() > 0) {
        //            $data = $data->result();
        //            return $data;
        //        }
    }

    function statspruebaswhere($where, $fechainicialp, $fechafinalp)
    {
        $data = $this->db->query("SELECT
h.idhojapruebas,
                                DATE_FORMAT(h.fechainicial, '%Y/%m/%d %h:%i:%s') AS 'Fecha_inicial',
                                v.numero_placa AS 'Placa',
                                IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idcliente=cl.idcliente ORDER BY 1 LIMIT 1),'---') AS 'Cliente',
                                IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idpropietarios=cl.idcliente ORDER BY 1 LIMIT 1),'---') AS 'Propietario',
                                IF(v.registroRunt=1,
                                (SELECT m.nombre FROM linearunt l,marcarunt m WHERE l.idmarcarunt=m.idmarcarunt AND l.idlinearunt=v.idlinea),
                                (SELECT m.nombre FROM linea l,marca m WHERE l.idmarca=m.idmarca AND l.idlinea=v.idlinea)) Marca,
                                IF(v.registroRunt=1,
                                (SELECT l.nombre FROM  linearunt l WHERE l.idlinearunt=v.idlinea),
                                (SELECT l.nombre FROM linea l WHERE l.idlinea=v.idlinea)) 'Linea',
                                IFNULL((SELECT u.identificacion FROM usuarios u, pruebas p WHERE h.idhojapruebas = p.idhojapruebas AND p.idusuario = u.IdUsuario LIMIT 1 ),'---') AS 'Documento',
                                IFNULL((SELECT CONCAT(u.nombres,u.apellidos) FROM usuarios u, pruebas p WHERE h.idhojapruebas = p.idhojapruebas AND p.idusuario = u.IdUsuario LIMIT 1 ),'---') AS 'Operario',
                                CASE
                                  WHEN h.estadototal = 1 THEN 'Asignado'
                                  WHEN h.estadototal = 2 THEN 'Aprobado'
                                  WHEN h.estadototal = 4 THEN 'Certificado'
                                  WHEN h.estadototal = 3 THEN 'Rechazado'
                                  ELSE 'Abortado'
                                END AS 'Estado_final',
                                CASE
                                  WHEN h.reinspeccion = 0 THEN 'Primera vez TCM '
                                  WHEN h.reinspeccion = 1 THEN 'Reinspeecion TCM'
                                  WHEN h.reinspeccion = 4444 THEN 'Primera vez PRV'
                                  WHEN h.reinspeccion = 44441 THEN 'Reinspeecion PRV'
                                  ELSE 'Prueba libre'
                                END AS 'Ocacion',
                                c.nombre AS 'Clase',
                                s.nombre AS 'Servicio',
                                t.nombre AS 'Combustible',
                                v.ano_modelo AS 'Modelo',
                                tv.nombre AS 'Tipo_vehiculo',
                                v.cilindraje AS 'Cilindraje',
                                v.cilindros AS 'Cilindros',
                                v.kilometraje AS 'kilometraje',
                                v.num_pasajeros AS 'Numero_pasajeros',
                                IF(v.taximetro = 1, 'Aplica', 'No aplica') AS 'Taximetro',
                                IF(v.tiempos = 2,'2 Tiempos','4 Tiempos') AS 'Tiempos',
                                IF(v.ensenanza = 1, 'Aplica', 'No aplica') AS 'Ensenanza',
                                IFNULL(IF((SELECT p.estado FROM pruebas p WHERE h.idhojapruebas = p.idhojapruebas LIMIT 1) = 5,
										  (SELECT 
                                if((r.observacion = 'razon_cancelacion' OR r.observacion = 'Aborto'),
                                r.valor,
                                r.observacion)
										  from resultados r, pruebas p 
										  WHERE 
										  h.idhojapruebas = p.idhojapruebas 
										  AND  p.idprueba = r.idprueba 
										  AND  (r.idconfig_prueba = 175 OR r.observacion = 'Fallas del equipo de medición' OR 
										  r.observacion = 'Falla súbita del fluido eléctrico' OR 
										  r.observacion = 'Bloqueo forzado del equipo' OR 
										  r.observacion = 'Ejecución incorrecta de la prueba' OR 
                                r.observacion = 'razon_cancelacion')
										  limit 1),
										  '---'),
										  '---') AS 'Razon_aborto',
                                IFNULL(IF((SELECT p.estado FROM pruebas p WHERE h.idhojapruebas = p.idhojapruebas LIMIT 1) = 5,
                                (SELECT CONCAT(u.nombres, '', u.apellidos) from resultados r, pruebas p, usuarios u 
                                WHERE h.idhojapruebas = p.idhojapruebas AND  p.idprueba= r.idprueba and  p.idusuario = u.idusuario AND (r.idconfig_prueba = 175 OR r.observacion = 'Fallas del equipo de medición' OR 
										  r.observacion = 'Falla súbita del fluido eléctrico' OR 
										  r.observacion = 'Bloqueo forzado del equipo' OR 
										  r.observacion = 'Ejecución incorrecta de la prueba' OR 
                                r.observacion = 'razon_cancelacion') limit 1),
                                '---'),'---') AS 'Usuario_aborto_prueba',
                                if(h.estadototal = 5, IFNULL((SELECT CONCAT(u.nombres, ' ', u.apellidos) FROM usuarios u WHERE h.usuario = u.IdUsuario LIMIT 1),''),'---') AS 'prueba_cancelada'
                                 
                                 FROM 
                                 vehiculos v, hojatrabajo h,  servicio s, tipo_combustible t, clase c, tipo_vehiculo tv, linea l, marca m 
                                 WHERE 
                                 v.idvehiculo=h.idvehiculo    AND v.idservicio = s.idservicio AND v.idtipocombustible = t.idtipocombustible AND v.idclase = c.idclase AND 
                                 v.tipo_vehiculo = tv.idtipo_vehiculo AND v.idlinea=l.idlinea AND l.idmarca=m.idmarca $where and
                                 DATE_FORMAT(h.fechainicial,'%Y-%m-%d') between DATE_FORMAT('$fechainicialp','%Y-%m-%d') AND DATE_FORMAT('$fechafinalp','%Y-%m-%d') ORDER BY 1 DESC");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function statsPruebasResultados($where, $fechainicialp, $fechafinalp)
    {
        $data = $this->db->query("SELECT p.idprueba,p.idtipo_prueba,
        IFNULL((SELECT  t.nombre FROM tipo_prueba t WHERE p.idtipo_prueba = t.idtipo_prueba LIMIT 1),'') AS 'Tipo_prueba',
        DATE_FORMAT(h.fechainicial, '%Y/%m/%d %h:%i:%s') AS 'Fecha_inicial',
        v.numero_placa AS 'Placa',
        IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idcliente=cl.idcliente ORDER BY 1 LIMIT 1),'---') AS 'Cliente',
        IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idpropietarios=cl.idcliente ORDER BY 1 LIMIT 1),'---') AS 'Propietario',
        IF(v.registroRunt=1,
        (SELECT m.nombre FROM linearunt l,marcarunt m WHERE l.idmarcarunt=m.idmarcarunt AND l.idlinearunt=v.idlinea),
        (SELECT m.nombre FROM linea l,marca m WHERE l.idmarca=m.idmarca AND l.idlinea=v.idlinea)) Marca,
        IF(v.registroRunt=1,
        (SELECT l.nombre FROM  linearunt l WHERE l.idlinearunt=v.idlinea),
        (SELECT l.nombre FROM linea l WHERE l.idlinea=v.idlinea)) 'Linea',
        IFNULL((SELECT u.identificacion FROM usuarios u, pruebas p WHERE h.idhojapruebas = p.idhojapruebas AND p.idusuario = u.IdUsuario LIMIT 1 ),'---') AS 'Documento',
        IFNULL((SELECT CONCAT(u.nombres,u.apellidos) FROM usuarios u, pruebas p WHERE h.idhojapruebas = p.idhojapruebas AND p.idusuario = u.IdUsuario LIMIT 1 ),'---') AS 'Operario',
        CASE
            WHEN p.estado = 0 THEN 'Asigando'
            WHEN p.estado = 1 THEN 'Rechazado'
            WHEN p.estado = 2 THEN 'Aprobado'
            WHEN p.estado = 3 THEN 'Reasigando'
            WHEN p.estado = 5 THEN 'Abortado'
        ELSE 'Reasignado individual'
        END AS 'Estado',
        c.nombre AS 'Clase',
        s.nombre AS 'Servicio',
        t.nombre AS 'Combustible',
        v.ano_modelo AS 'Modelo',
        tv.nombre AS 'Tipo_vehiculo',
        v.cilindraje AS 'Cilindraje',
        v.cilindros AS 'Cilindros',
        v.kilometraje AS 'kilometraje',
        ifnull(v.num_pasajeros,'0') AS 'pasajeros',
        IF(v.taximetro = 1, 'Aplica', 'No aplica') AS 'Taximetro',
        IF(v.tiempos = 2,'2 Tiempos','4 Tiempos') AS 'Tiempos',
        IF(v.ensenanza = 1, 'Aplica', 'No aplica') AS 'Ensenanza',
        p.estado,
        p.idprueba,
     IFNULL(IF(p.estado = 5,
              (SELECT 
    if((r.observacion = 'razon_cancelacion' OR r.observacion = 'Aborto'),
    r.valor,
    r.observacion)
              from resultados r, pruebas p 
              WHERE 
              h.idhojapruebas = p.idhojapruebas 
              AND  p.idprueba = r.idprueba 
              AND  (r.idconfig_prueba = 175 OR r.observacion = 'Fallas del equipo de medición' OR 
              r.observacion = 'Falla súbita del fluido eléctrico' OR 
              r.observacion = 'Bloqueo forzado del equipo' OR 
              r.observacion = 'Ejecución incorrecta de la prueba' OR 
    r.observacion = 'razon_cancelacion')
              limit 1),
              'Ejecución incorrecta de la prueba'),
              'Ejecución incorrecta de la prueba') AS 'Razon_aborto',
    IFNULL(IF(p.estado = 5,
    (SELECT CONCAT(u.nombres, '', u.apellidos) from  usuarios u WHERE   p.idusuario = u.idusuario  limit 1),'---'),'---') AS 'Usuario_aborto_prueba'
        FROM 
        vehiculos v, hojatrabajo h, pruebas p,  servicio s, tipo_combustible t, clase c, tipo_vehiculo tv 
        WHERE 
        v.idvehiculo=h.idvehiculo AND h.idhojapruebas = p.idhojapruebas AND v.idservicio = s.idservicio 
        AND v.idtipocombustible = t.idtipocombustible AND v.idclase = c.idclase AND 
        v.tipo_vehiculo = tv.idtipo_vehiculo AND 
        (p.idtipo_prueba <> 21 AND p.idtipo_prueba <> 22 AND p.idtipo_prueba <> 16 AND p.idtipo_prueba <> 15 AND p.idtipo_prueba <> 14 AND p.idtipo_prueba <> 13 AND p.idtipo_prueba <> 17 AND p.idtipo_prueba <> 12) AND
        DATE_FORMAT(h.fechainicial,'%Y-%m-%d') between DATE_FORMAT('$fechainicialp','%Y-%m-%d') AND DATE_FORMAT('$fechafinalp','%Y-%m-%d') $where ORDER BY 1 DESC");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function getresultados($idprueba)
    {
        $data = $this->db->query("SELECT c.valor AS 'Descripcion', r.valor AS 'Valor'
                                 FROM resultados r , config_prueba c
                                 WHERE r.idconfig_prueba=c.idconfig_prueba AND r.idprueba=$idprueba");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function getResultadosImagenes($idprueba, $espejo)
    {
        if ($espejo == 1) {
            $consulta = "SELECT * FROM imagenes_bd.imagenes i WHERE i.idprueba=$idprueba";
        } else {
            $consulta = "SELECT * FROM imagenes i WHERE i.idprueba=$idprueba";
        }
        $data = $this->db->query($consulta);
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    // function statscertificados($fechainicialc, $fechafinalc)
    // {
    //     $data = $this->db->query("SELECT 
    //                                 DATE_FORMAT(h.fechainicial,'%Y-%m-%d %h:%i:%s') AS Fecha,
    //                                 v.numero_placa AS 'Placa',
    //                                 IFNULL((SELECT tc.idconsecutivotc FROM consecutivotc tc WHERE h.idhojapruebas = tc.idhojapruebas LIMIT 1),'---') AS 'Numero_fur',
    //                                 IFNULL(cr.numero_certificado,'---') AS 'Numero_certificado',
    //                                 IFNULL(cr.consecutivo_runt,'---') AS 'Consecutivo_runt',
    //                                 IFNULL(cr.consecutivo_runt_rechazado,'---') AS 'Consecutivo_runt_rechazado',
    //                                 IFNULL(h.factura,'---') AS 'Factura',
    //                                 IFNULL(DATE_FORMAT(cr.fechaimpresion, '%Y/%m/%d %h:%i:%s'),'---') AS 'Fecha_impresion',
    //                                 IFNULL(DATE_FORMAT(cr.fecha_vigencia, '%Y/%m/%d %h:%i:%s'),'---') AS 'Fecha_vigencia',
    //                                 h.jefelinea AS 'Ingeniero_pista',
    //                                 IFNULL((SELECT CONCAT(u.nombres,' ',u.apellidos) FROM usuarios u WHERE cr.usuario=u.IdUsuario ORDER BY 1 LIMIT 1),'--.') AS 'Usuario_certificacion',
    //                                 IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idcliente=cl.idcliente ORDER BY 1 LIMIT 1),'--.') AS 'Cliente',
    //                                 IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idpropietarios=cl.idcliente ORDER BY 1 LIMIT 1),'--.') AS 'Propietario',
    //                                 IFNULL((SELECT cl.numero_identificacion FROM clientes cl WHERE v.idcliente=cl.idcliente ORDER BY 1 LIMIT 1),'---') AS 'Documento',
    //                                 IFNULL((SELECT cl.direccion FROM clientes cl WHERE v.idcliente=cl.idcliente ORDER BY 1 LIMIT 1),'---') AS 'Direccion',
    //                                 IFNULL((SELECT cl.correo FROM clientes cl WHERE v.idcliente=cl.idcliente ORDER BY 1 LIMIT 1),'---') AS 'Correo',
    //                                 IFNULL((SELECT cl.telefono1 FROM clientes cl WHERE v.idcliente=cl.idcliente ORDER BY 1 LIMIT 1),'---') AS 'Telefono',
    //                                 IF(v.registroRunt=1,
    //                     (SELECT m.nombre FROM linearunt l,marcarunt m WHERE l.idmarcarunt=m.idmarcarunt AND l.idlinearunt=v.idlinea),
    //                     (SELECT m.nombre FROM linea l,marca m WHERE l.idmarca=m.idmarca AND l.idlinea=v.idlinea)) Marca,
    //                     if(v.registroRunt=1,
    //                     (select l.nombre from linearunt l where l.idlinearunt=v.idlinea),
    //                     (select l.nombre from linea l where l.idlinea=v.idlinea)) AS 'Linea',
    //                     ifnull((select co.nombre from color co WHERE co.idcolor = v.idcolor LIMIT 1), '---') AS 'Color',           
    //                                  CASE
    //                                     WHEN h.estadototal = 1 THEN 'Asignado'
    //                                     WHEN h.estadototal = 2 THEN 'Aprobado'
    //                                     WHEN h.estadototal = 4 THEN 'Certificado'
    //                                     WHEN h.estadototal = 3 THEN 'Rechazado'
    //                                     ELSE 'Abortado'
    //                                 END AS 'Estado_final',
    //                                  CASE
    //                                     WHEN h.reinspeccion = 0 THEN 'Primera vez TCM '
    //                                     WHEN h.reinspeccion = 1 THEN 'Reinspeecion TCM'
    //                                     WHEN h.reinspeccion = 4444 THEN 'Primera vez PRV'
    //                                     WHEN h.reinspeccion = 44441 THEN 'Reinspeecion PRV'
    //                                     ELSE 'Prueba libre'
    //                                 END AS 'Ocacion',
    //                                 IFNULL((SELECT c.nombre FROM clase c WHERE v.idclase = c.idclase LIMIT 1),'---') AS 'Clase',
    //                                 IFNULL((SELECT s.nombre FROM servicio s WHERE s.idservicio = v.idservicio LIMIT 1),'---') AS 'Servicio',
    //                                 IFNULL((SELECT t.nombre FROM tipo_combustible t WHERE v.idtipocombustible = t.idtipocombustible LIMIT 1),'---') AS 'Combustible',
    //                                 v.ano_modelo AS 'Modelo',
    //                                 v.cilindraje,
    //                                 IFNULL((SELECT tv.nombre FROM tipo_vehiculo tv WHERE tv.idtipo_vehiculo = v.tipo_vehiculo LIMIT 1),'---') AS 'Tipo_vehiculo'
    //                                 FROM 
    //                                 vehiculos v, hojatrabajo h, certificados cr
    //                                 WHERE 
    //                                 v.idvehiculo=h.idvehiculo AND  h.idhojapruebas = cr.idhojapruebas AND  
    //                                 DATE_FORMAT(h.fechainicial,'%Y-%m-%d') between DATE_FORMAT('$fechainicialc','%Y-%m-%d') AND DATE_FORMAT('$fechafinalc','%Y-%m-%d') ORDER BY h.fechafinal ASC");
    //     if ($data->num_rows() > 0) {
    //         $data = $data->result();
    //         return $data;
    //     }
    // }

    function statscertificadoswhere($where, $fechainicialc, $fechafinalc)
    {
        $data = $this->db->query("SELECT 
                                    DATE_FORMAT(h.fechainicial,'%Y-%m-%d') AS Fecha,
                                    v.numero_placa AS 'Placa',
                                    IFNULL((SELECT tc.idconsecutivotc FROM consecutivotc tc WHERE h.idhojapruebas = tc.idhojapruebas LIMIT 1),'---') AS 'Numero_fur',
                                    IFNULL(cr.numero_certificado,'---') AS 'Numero_certificado',
                                    IFNULL(cr.consecutivo_runt,'---') AS 'Consecutivo_runt',
                                    IFNULL(cr.consecutivo_runt_rechazado,'---') AS 'Consecutivo_runt_rechazado',
                                    IFNULL(h.factura,'---') AS 'Factura',
                                    IFNULL(DATE_FORMAT(cr.fechaimpresion, '%Y/%m/%d %h:%i:%s'),'---') AS 'Fecha_impresion',
                                    IFNULL(DATE_FORMAT(cr.fecha_vigencia, '%Y/%m/%d %h:%i:%s'),'---') AS 'Fecha_vigencia',
                                    h.jefelinea AS 'Ingeniero_pista',
                                    IFNULL((SELECT CONCAT(u.nombres,' ',u.apellidos) FROM usuarios u WHERE cr.usuario=u.IdUsuario ORDER BY 1 LIMIT 1),'--.') AS 'Usuario_certificacion',
                                    IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idcliente=cl.idcliente ORDER BY 1 LIMIT 1),'--.') AS 'Cliente',
                                    IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idpropietarios=cl.idcliente ORDER BY 1 LIMIT 1),'--.') AS 'Propietario',
                                    IFNULL((SELECT cl.numero_identificacion FROM clientes cl WHERE v.idcliente=cl.idcliente ORDER BY 1 LIMIT 1),'---') AS 'Documento',
                                    IFNULL((SELECT cl.direccion FROM clientes cl WHERE v.idcliente=cl.idcliente ORDER BY 1 LIMIT 1),'---') AS 'Direccion',
                                    IFNULL((SELECT cl.correo FROM clientes cl WHERE v.idcliente=cl.idcliente ORDER BY 1 LIMIT 1),'---') AS 'Correo',
                                    IFNULL((SELECT cl.telefono1 FROM clientes cl WHERE v.idcliente=cl.idcliente ORDER BY 1 LIMIT 1),'---') AS 'Telefono',
                                    IF(v.registroRunt=1,
                        (SELECT m.nombre FROM linearunt l,marcarunt m WHERE l.idmarcarunt=m.idmarcarunt AND l.idlinearunt=v.idlinea),
                        (SELECT m.nombre FROM linea l,marca m WHERE l.idmarca=m.idmarca AND l.idlinea=v.idlinea)) Marca,
                        if(v.registroRunt=1,
                        (select l.nombre from linearunt l where l.idlinearunt=v.idlinea),
                        (select l.nombre from linea l where l.idlinea=v.idlinea)) AS 'Linea',
                        ifnull((select co.nombre from color co WHERE co.idcolor = v.idcolor LIMIT 1), '---') AS 'Color',            
                                     CASE
                                        WHEN h.estadototal = 1 THEN 'Asignado'
                                        WHEN h.estadototal = 2 THEN 'Aprobado'
                                        WHEN h.estadototal = 4 THEN 'Certificado'
                                        WHEN h.estadototal = 3 THEN 'Rechazado'
                                        ELSE 'Abortado'
                                    END AS 'Estado_final',
                                     CASE
                                        WHEN h.reinspeccion = 0 THEN 'Primera vez TCM '
                                        WHEN h.reinspeccion = 1 THEN 'Reinspeecion TCM'
                                        WHEN h.reinspeccion = 4444 THEN 'Primera vez PRV'
                                        WHEN h.reinspeccion = 44441 THEN 'Reinspeecion PRV'
                                        ELSE 'Prueba libre'
                                    END AS 'Ocacion',
                                    IFNULL((SELECT c.nombre FROM clase c WHERE v.idclase = c.idclase LIMIT 1),'---') AS 'Clase',
                                    IFNULL((SELECT s.nombre FROM servicio s WHERE s.idservicio = v.idservicio LIMIT 1),'---') AS 'Servicio',
                                    IFNULL((SELECT t.nombre FROM tipo_combustible t WHERE v.idtipocombustible = t.idtipocombustible LIMIT 1),'---') AS 'Combustible',
                                    v.ano_modelo AS 'Modelo',
                                    v.cilindraje,
                                    IFNULL((SELECT tv.nombre FROM tipo_vehiculo tv WHERE tv.idtipo_vehiculo = v.tipo_vehiculo LIMIT 1),'---') AS 'Tipo_vehiculo',
                                    v.numero_motor, v.numero_vin, v.numero_serie, v.scooter
                                    FROM 
                                    vehiculos v, hojatrabajo h, certificados cr
                                    WHERE 
                                    v.idvehiculo=h.idvehiculo AND  h.idhojapruebas = cr.idhojapruebas $where AND  
                                    DATE_FORMAT(h.fechainicial,'%Y-%m-%d') between DATE_FORMAT('$fechainicialc','%Y-%m-%d') AND DATE_FORMAT('$fechafinalc','%Y-%m-%d') ORDER BY h.fechafinal ASC");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
        
    }

    function logs()
    {
        $data = $this->db->query("SELECT 
                                IFNULL ((SELECT v.numero_placa FROM  vehiculos v, hojatrabajo h, pruebas pa WHERE v.idvehiculo=h.idvehiculo AND h.idhojapruebas = p.idhojapruebas AND pa.idprueba= c.idprueba LIMIT 1), '---') AS 'Placa',
                                IFNULL ((SELECT DATE_FORMAT(p.fechainicial,'%Y-%m-%d %h:%i:%s')  FROM  vehiculos v, hojatrabajo h, pruebas pa WHERE v.idvehiculo=h.idvehiculo AND h.idhojapruebas = p.idhojapruebas AND pa.idprueba= c.idprueba LIMIT 1), '---') AS 'Fecha_prueba',
                                c.*, p.idmaquina
                                 FROM pruebas p, control_prueba_gases c WHERE p.idprueba=c.idprueba ORDER BY 3 DESC ");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function getresultadoslog($id)
    {
        $data = $this->db->query("SELECT 
                                IFNULL((SELECT c.nombre_cda FROM cda c LIMIT 1),'') AS 'nombreCda',
                                IFNULL((SELECT c.numero_id FROM cda c LIMIT 1),'') AS 'nit',
                                IFNULL ((SELECT v.numero_placa FROM  vehiculos v, hojatrabajo h, pruebas pa WHERE v.idvehiculo=h.idvehiculo AND h.idhojapruebas = p.idhojapruebas AND pa.idprueba= c.idprueba LIMIT 1), '---') AS 'Placa',
                                IFNULL ((SELECT pa.fechafinal FROM  vehiculos v, hojatrabajo h, pruebas pa WHERE v.idvehiculo=h.idvehiculo AND h.idhojapruebas = p.idhojapruebas AND pa.idprueba= c.idprueba LIMIT 1), '---') AS 'Fecha',
                                c.datos_ciclo_ralenti, c.datos_ciclo_crucero,p.idmaquina
                                FROM pruebas p, control_prueba_gases c WHERE p.idprueba=c.idprueba AND c.idcontrol_prueba_gases=$id ORDER BY 3 DESC");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function statscalibraciones($fechainicialca, $fechafinalca, $selanalizador)
    {
        $data = $this->db->query("select 
                                cf.idmaquina as Id,
                                if(cf.descripcion<>'id_banco',DATE_FORMAT(cf.descripcion,'%Y-%m-%d/%H:%i:%s'),'---') as Fecha,
                                (select serie from maquina where idmaquina=$selanalizador limit 1) as Serie,
                                (select parametro from config_maquina  where tipo_parametro='PEF' and descripcion = cf.descripcion limit 1)  as Pef,
                                IFNULL((select concat(u.nombres,' ',u.apellidos) from config_maquina c, usuarios u  where tipo_parametro='id_user_calibra' and descripcion = cf.descripcion and c.parametro=u.IdUsuario and idmaquina=$selanalizador limit 1),'---')  as Responsable,
                                (select parametro from config_maquina  where tipo_parametro='span_alto_hc' and descripcion = cf.descripcion and idmaquina=$selanalizador limit 1)  as Span_alto_hc,
                                (select parametro from config_maquina  where tipo_parametro='span_alto_co' and descripcion = cf.descripcion  and idmaquina=$selanalizador limit 1)  as Span_alto_co,
                                (select parametro from config_maquina  where tipo_parametro='span_alto_co2' and descripcion = cf.descripcion and idmaquina=$selanalizador limit 1)  as Span_alto_co2,
                                (select 'Nitrógeno de balance')  as Span_alto_n,
                                (select parametro from config_maquina  where tipo_parametro='span_bajo_hc' and descripcion = cf.descripcion and idmaquina=$selanalizador limit 1)  as Span_bajo_hc,
                                (select parametro from config_maquina  where tipo_parametro='span_bajo_co' and descripcion = cf.descripcion and idmaquina=$selanalizador limit 1)  as Span_bajo_co,
                                (select parametro from config_maquina  where tipo_parametro='span_bajo_co2' and descripcion = cf.descripcion and idmaquina=$selanalizador limit 1)  as Span_bajo_co2,
                                (select 'Nitrógeno de balance')  as Span_bajo_n,
                                (select parametro from config_maquina where idconfiguracion=11 and substring(CAST(UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7)=substring(CAST(UNIX_TIMESTAMP(str_to_date(cf.descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7) and tipo_parametro='cal_alto_hc' and idmaquina=$selanalizador  order by UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) desc limit 1)  as Cal_alto_hc,
                                (select parametro from config_maquina where idconfiguracion=11 and substring(CAST(UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7)=substring(CAST(UNIX_TIMESTAMP(str_to_date(cf.descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7) and tipo_parametro='cal_alto_co' and idmaquina=$selanalizador  order by UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) desc limit 1)  as Cal_alto_co,
                                (select parametro from config_maquina where idconfiguracion=11 and substring(CAST(UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7)=substring(CAST(UNIX_TIMESTAMP(str_to_date(cf.descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7) and tipo_parametro='cal_alto_co2' and idmaquina=$selanalizador  order by UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) desc limit 1)  as Cal_alto_co2,
                                (select parametro from config_maquina where idconfiguracion=11 and substring(CAST(UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7)=substring(CAST(UNIX_TIMESTAMP(str_to_date(cf.descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7) and tipo_parametro='cal_alto_o2' and idmaquina=$selanalizador  order by UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) desc limit 1)  as Cal_alto_o2,
                                (select parametro from config_maquina where idconfiguracion=11 and substring(CAST(UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7)=substring(CAST(UNIX_TIMESTAMP(str_to_date(cf.descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7) and tipo_parametro='cal_bajo_hc' and idmaquina=$selanalizador  order by UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) desc limit 1)  as Cal_bajo_hc,
                                (select parametro from config_maquina where idconfiguracion=11 and substring(CAST(UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7)=substring(CAST(UNIX_TIMESTAMP(str_to_date(cf.descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7) and tipo_parametro='cal_bajo_co' and idmaquina=$selanalizador  order by UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) desc limit 1)  as Cal_bajo_co,
                                (select parametro from config_maquina where idconfiguracion=11 and substring(CAST(UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7)=substring(CAST(UNIX_TIMESTAMP(str_to_date(cf.descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7) and tipo_parametro='cal_bajo_co2' and idmaquina=$selanalizador  order by UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) desc limit 1)  as Cal_bajo_co2,
                                (select parametro from config_maquina where idconfiguracion=11 and substring(CAST(UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7)=substring(CAST(UNIX_TIMESTAMP(str_to_date(cf.descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7) and tipo_parametro='cal_bajo_o2' and idmaquina=$selanalizador  order by UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) desc limit 1)  as Cal_bajo_o2,
                                (select parametro from config_maquina  where tipo_parametro='resultado' and descripcion = cf.descripcion and idmaquina=$selanalizador limit 1)  as resultado
                                from config_maquina cf,maquina m 
                                where cf.tipo_parametro='id_banco' and cf.idmaquina=$selanalizador and idconfiguracion=11  AND 
                                DATE_FORMAT(cf.descripcion,'%Y-%m-%d') BETWEEN '$fechainicialca' AND '$fechafinalca'  group BY 2 order by 2 desc,3  desc");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function reportpdfcalibraciones($fecha, $id)
    {
        $data = $this->db->query("select 
                                if(cf.descripcion<>'id_banco',DATE_FORMAT(cf.descripcion,'%Y-%m-%d %H:%i:%s'),'---') as Fecha,
                                IFNULL((select serie from maquina where idmaquina=$id limit 1),'---') as Serie,
                                IFNULL((select parametro from config_maquina  where tipo_parametro='PEF' and descripcion = cf.descripcion limit 1),'---') as Pef,
                                IFNULL((select concat(u.nombres,' ',u.apellidos) from config_maquina c, usuarios u  where tipo_parametro='id_user_calibra' and descripcion = cf.descripcion and c.parametro=u.IdUsuario and idmaquina=$id limit 1),'---')  as Responsable,
                                IFNULL((select parametro from config_maquina  where tipo_parametro='span_alto_hc' and descripcion = cf.descripcion and idmaquina=$id limit 1),'---')  as Span_alto_hc,
                                IFNULL((select parametro from config_maquina  where tipo_parametro='span_alto_co' and descripcion = cf.descripcion  and idmaquina=$id limit 1),'---')  as Span_alto_co,
                                IFNULL((select parametro from config_maquina  where tipo_parametro='span_alto_co2' and descripcion = cf.descripcion and idmaquina=$id limit 1),'---')  as Span_alto_co2,
                                (select 'Nitrógeno de balance')  as Span_alto_n,
                                IFNULL((select parametro from config_maquina  where tipo_parametro='span_bajo_hc' and descripcion = cf.descripcion and idmaquina=$id limit 1),'---')  as Span_bajo_hc,
                                IFNULL((select parametro from config_maquina  where tipo_parametro='span_bajo_co' and descripcion = cf.descripcion and idmaquina=$id limit 1),'---')  as Span_bajo_co,
                                IFNULL((select parametro from config_maquina  where tipo_parametro='span_bajo_co2' and descripcion = cf.descripcion and idmaquina=$id limit 1),'---')  as Span_bajo_co2,
                                (select 'Nitrógeno de balance')  as Span_bajo_n,
                                IFNULL((select parametro from config_maquina where idconfiguracion=11 and substring(CAST(UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7)=substring(CAST(UNIX_TIMESTAMP(str_to_date(cf.descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7) and tipo_parametro='cal_alto_hc' and idmaquina=$id  order by UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) desc limit 1),'---')  as Cal_alto_hc,
                                IFNULL((select parametro from config_maquina where idconfiguracion=11 and substring(CAST(UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7)=substring(CAST(UNIX_TIMESTAMP(str_to_date(cf.descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7) and tipo_parametro='cal_alto_co' and idmaquina=$id  order by UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) desc limit 1),'---')  as Cal_alto_co,
                                IFNULL((select parametro from config_maquina where idconfiguracion=11 and substring(CAST(UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7)=substring(CAST(UNIX_TIMESTAMP(str_to_date(cf.descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7) and tipo_parametro='cal_alto_co2' and idmaquina=$id  order by UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) desc limit 1),'---')  as Cal_alto_co2,
                                IFNULL((select parametro from config_maquina where idconfiguracion=11 and substring(CAST(UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7)=substring(CAST(UNIX_TIMESTAMP(str_to_date(cf.descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7) and tipo_parametro='cal_alto_o2' and idmaquina=$id  order by UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) desc limit 1),'---')  as Cal_alto_o2,
                                IFNULL((select parametro from config_maquina where idconfiguracion=11 and substring(CAST(UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7)=substring(CAST(UNIX_TIMESTAMP(str_to_date(cf.descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7) and tipo_parametro='cal_bajo_hc' and idmaquina=$id  order by UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) desc limit 1),'---')  as Cal_bajo_hc,
                                IFNULL((select parametro from config_maquina where idconfiguracion=11 and substring(CAST(UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7)=substring(CAST(UNIX_TIMESTAMP(str_to_date(cf.descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7) and tipo_parametro='cal_bajo_co' and idmaquina=$id  order by UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) desc limit 1),'---')  as Cal_bajo_co,
                                IFNULL((select parametro from config_maquina where idconfiguracion=11 and substring(CAST(UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7)=substring(CAST(UNIX_TIMESTAMP(str_to_date(cf.descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7) and tipo_parametro='cal_bajo_co2' and idmaquina=$id  order by UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) desc limit 1),'---')  as Cal_bajo_co2,
                                IFNULL((select parametro from config_maquina where idconfiguracion=11 and substring(CAST(UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7)=substring(CAST(UNIX_TIMESTAMP(str_to_date(cf.descripcion,'%Y-%m-%d %H:%i:%s')) AS CHAR(10000) CHARACTER SET utf8),1,7) and tipo_parametro='cal_bajo_o2' and idmaquina=$id  order by UNIX_TIMESTAMP(str_to_date(descripcion,'%Y-%m-%d %H:%i:%s')) desc limit 1),'---')  as Cal_bajo_o2,
                                IFNULL((select parametro from config_maquina  where tipo_parametro='resultado' and descripcion = cf.descripcion and idmaquina=$id limit 1),'---')  as resultado
                                from config_maquina cf,maquina m 
                                where cf.tipo_parametro='id_banco' and cf.idmaquina=$id and idconfiguracion=11  AND 
                                DATE_FORMAT(cf.descripcion,'%Y-%m-%d %H:%i:%s') = '$fecha' group BY 1 order by 2 desc,3  DESC");
        if ($data->num_rows() > 0) {
            $rta = $data->result();
            return $rta[0];
        }
    }

    function statsfugas($fechainicialca, $fechafinalca, $selanalizador)
    {
        $data = $this->db->query("SELECT 
                                cf.idmaquina as Id,
                                if(cf.parametro,DATE_FORMAT(cf.parametro,'%Y-%m-%d %H:%i:%s'),'---') as Fecha,
                                IFNULL((select serie from maquina where idmaquina=$selanalizador limit 1),'---') as Serie,
                                IFNULL((SELECT c.parametro from config_maquina c WHERE c.tipo_parametro='PEF'  limit 1),'---') AS Pef,
                                IFNULL((SELECT CONCAT(u.nombres,' ',u.apellidos) from config_maquina c, usuarios u WHERE   (c.tipo_parametro='id_user_fugas' OR c.tipo_parametro='total_fugas_porc') AND  c.parametro=u.IdUsuario AND c.idmaquina=$selanalizador AND c.idconfig_maquina = cf.idconfig_maquina + 8 limit 1),'---') AS Responsable,
                                IFNULL((SELECT c.parametro from config_maquina c WHERE c.tipo_parametro='presion_base' AND  c.idconfig_maquina = cf.idconfig_maquina + 1 limit 1),'---') as 'presion_base',
                                IFNULL((SELECT c.parametro from config_maquina c WHERE c.tipo_parametro='presion_bomba' AND  c.idconfig_maquina = cf.idconfig_maquina + 2 limit 1),'---') as 'presion_bomba',
                                IFNULL((SELECT c.parametro from config_maquina c WHERE c.tipo_parametro='presion_filtros' AND  c.idconfig_maquina = cf.idconfig_maquina + 3 limit 1),'---') as 'presion_filtros',
                                IFNULL((SELECT c.parametro from config_maquina c WHERE c.tipo_parametro='vacio_bomba_apag' AND  c.idconfig_maquina = cf.idconfig_maquina + 4 limit 1),'---') as 'vacio_bomba_apag',
                                IFNULL((SELECT c.parametro from config_maquina c WHERE c.tipo_parametro='vacio_bomba_pren' AND  c.idconfig_maquina = cf.idconfig_maquina + 5 limit 1),'---') as 'vacio_bomba_pren',
                                IFNULL((SELECT c.parametro from config_maquina c WHERE c.tipo_parametro='total_fugas_num' AND  c.idconfig_maquina = cf.idconfig_maquina + 6 limit 1),'---') as 'total_fugas_num',
                                IFNULL((SELECT c.parametro from config_maquina c WHERE c.tipo_parametro='total_fugas_porc' AND  c.idconfig_maquina = cf.idconfig_maquina + 7 limit 1),'---') as 'total_fugas_porc',
                                IFNULL((SELECT c.parametro from config_maquina c WHERE c.tipo_parametro='total_fugas_porc' AND  c.idconfig_maquina = cf.idconfig_maquina + 8 limit 1),'---') as 'total_fugas_porc',
                                IFNULL((SELECT if(c.parametro = 1, 'Aprobado','No aprobado') from config_maquina c WHERE c.tipo_parametro='fuga' AND  c.idconfig_maquina = cf.idconfig_maquina + 9 limit 1),'---') as 'resultado'
                                from config_maquina cf
                                WHERE cf.descripcion='fecha_ultima_pruebadefugas' AND cf.idmaquina=$selanalizador and idconfiguracion=11  AND 
                                DATE_FORMAT(cf.parametro,'%Y-%m-%d') BETWEEN '$fechainicialca' AND '$fechafinalca'  ORDER BY 2 DESC ");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function reportpdffugas($fecha, $id)
    {
        $data = $this->db->query("SELECT 
                                cf.idmaquina as Id,
                                if(cf.parametro,DATE_FORMAT(cf.parametro,'%Y-%m-%d %H:%i:%s'),'---') as Fecha,
                                IFNULL((select serie from maquina where idmaquina=$id limit 1),'---') as Serie,
                                IFNULL((SELECT c.parametro from config_maquina c WHERE c.tipo_parametro='PEF'  limit 1),'---') AS Pef,
                                IFNULL((SELECT CONCAT(u.nombres,' ',u.apellidos) from config_maquina c, usuarios u WHERE   (c.tipo_parametro='id_user_fugas' OR c.tipo_parametro='total_fugas_porc') AND  c.parametro=u.IdUsuario AND c.idmaquina=$id AND c.idconfig_maquina = cf.idconfig_maquina + 8 limit 1),'---') AS Responsable,
                                IFNULL((SELECT c.parametro from config_maquina c WHERE c.tipo_parametro='presion_base' AND  c.idconfig_maquina = cf.idconfig_maquina + 1 limit 1),'---') as 'presion_base',
                                IFNULL((SELECT c.parametro from config_maquina c WHERE c.tipo_parametro='presion_bomba' AND  c.idconfig_maquina = cf.idconfig_maquina + 2 limit 1),'---') as 'presion_bomba',
                                IFNULL((SELECT c.parametro from config_maquina c WHERE c.tipo_parametro='presion_filtros' AND  c.idconfig_maquina = cf.idconfig_maquina + 3 limit 1),'---') as 'presion_filtros',
                                IFNULL((SELECT c.parametro from config_maquina c WHERE c.tipo_parametro='vacio_bomba_apag' AND  c.idconfig_maquina = cf.idconfig_maquina + 4 limit 1),'---') as 'vacio_bomba_apag',
                                IFNULL((SELECT c.parametro from config_maquina c WHERE c.tipo_parametro='vacio_bomba_pren' AND  c.idconfig_maquina = cf.idconfig_maquina + 5 limit 1),'---') as 'vacio_bomba_pren',
                                IFNULL((SELECT c.parametro from config_maquina c WHERE c.tipo_parametro='total_fugas_num' AND  c.idconfig_maquina = cf.idconfig_maquina + 6 limit 1),'---') as 'total_fugas_num',
                                IFNULL((SELECT c.parametro from config_maquina c WHERE c.tipo_parametro='total_fugas_porc' AND  c.idconfig_maquina = cf.idconfig_maquina + 7 limit 1),'---') as 'total_fugas_porc',
                                IFNULL((SELECT c.parametro from config_maquina c WHERE c.tipo_parametro='total_fugas_porc' AND  c.idconfig_maquina = cf.idconfig_maquina + 8 limit 1),'---') as 'total_fugas_porc',
                                IFNULL((SELECT if(c.parametro = 1, 'Aprobado','No aprobado') from config_maquina c WHERE c.tipo_parametro='fuga' AND  c.idconfig_maquina = cf.idconfig_maquina + 9 limit 1),'---') as 'resultado'
                                from config_maquina cf
                                WHERE cf.descripcion='fecha_ultima_pruebadefugas' AND cf.idmaquina=$id and idconfiguracion=11  AND 
                                DATE_FORMAT(cf.parametro,'%Y-%m-%d %H:%i:%s') = '$fecha' ");
        if ($data->num_rows() > 0) {
            $rta = $data->result();
            return $rta[0];
        }
    }

    function statslinealidad($fechainicialca, $fechafinalca, $selopcaidad)
    {
        $data = $this->db->query("select 
                                SUBSTRING(ra.idauditoria,4)  as Fecha,
                                (select valor from resultadosauditoria  where observacion='ID Banco' and idauditoria = ra.idauditoria limit 1)  as Id,
                                (select serie from maquina where idbanco=$selopcaidad limit 1)  as Serie,
                                IFNULL((select concat(u.nombres,' ',u.apellidos) from resultadosauditoria r, usuarios u  where r.observacion='Usuario' and r.idauditoria = ra.idauditoria and r.valor=u.IdUsuario limit 1),'---')  as Responsable,
                                (select valor from resultadosauditoria  where observacion='Lente 1 Lectura' and idauditoria = ra.idauditoria limit 1)  as Lente1_lectura,
                                (select valor from resultadosauditoria  where observacion='Lente 2 Lectura' and idauditoria = ra.idauditoria limit 1)  as Lente2_lectura,
                                (select valor from resultadosauditoria  where observacion='Lente 3 Lectura' and idauditoria = ra.idauditoria limit 1)  as Lente3_lectura,
                                (select valor from resultadosauditoria  where observacion='Lente 4 Lectura' and idauditoria = ra.idauditoria limit 1)  as Lente4_lectura,
                                (select valor from resultadosauditoria  where observacion='Lente 1 Valor' and idauditoria = ra.idauditoria limit 1)  as Lente1_valor,
                                (select valor from resultadosauditoria  where observacion='Lente 2 Valor' and idauditoria = ra.idauditoria limit 1)  as Lente2_valor,
                                (select valor from resultadosauditoria  where observacion='Lente 3 Valor' and idauditoria = ra.idauditoria limit 1)  as Lente3_valor,
                                (select valor from resultadosauditoria  where observacion='Lente 4 Valor' and idauditoria = ra.idauditoria limit 1)  as Lente4_valor,
                                (select valor from resultadosauditoria  where observacion='Lente 1 Desviación' and idauditoria = ra.idauditoria limit 1)  as Lente1_desviacion,
                                (select valor from resultadosauditoria  where observacion='Lente 2 Desviación' and idauditoria = ra.idauditoria limit 1)  as Lente2_desviacion,
                                (select valor from resultadosauditoria  where observacion='Lente 3 Desviación' and idauditoria = ra.idauditoria limit 1)  as Lente3_desviacion,
                                (select valor from resultadosauditoria  where observacion='Lente 4 Desviación' and idauditoria = ra.idauditoria limit 1)  as Lente4_desviacion,
                                (select valor from resultadosauditoria  where observacion='Error Total Lectura' and idauditoria = ra.idauditoria limit 1)  as Error_total_lectura,
                                (select valor from resultadosauditoria  where observacion='Estado' and idauditoria = ra.idauditoria limit 1)  as resultado 
                                from resultadosauditoria ra 
                                where ra.idconfig_prueba = 58 and valor= $selopcaidad AND 
                                DATE_FORMAT(ra.fechaguardado, '%Y-%m-%d')  BETWEEN  '$fechainicialca' AND '$fechafinalca'
                                group by 1 order by ra.idresultadosauditoria desc");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function reportpdflinealidad($fecha, $id)
    {
        $data = $this->db->query("SELECT
                                SUBSTRING(ra.idauditoria,4)  as Fecha, 
                                (select serie from maquina where idbanco=$id limit 1)  as Serie,
                                IFNULL((select concat(u.nombres,' ',u.apellidos) from resultadosauditoria r, usuarios u  where r.observacion='Usuario' and r.idauditoria = ra.idauditoria and r.valor=u.IdUsuario limit 1),'---')  as Responsable,
                                (SELECT cf.parametro FROM config_maquina cf WHERE cf.idmaquina=$id AND cf.descripcion='fecha_ultimacontrolcero' LIMIT 1 ) AS Fecha_control_cero,
                                (SELECT if(cf.parametro=1,'Aprobado','No aprobado') FROM config_maquina cf WHERE cf.idmaquina=$id AND cf.descripcion='verificacion_controldecero' LIMIT 1 ) AS Resultado_control_cero,
                                IFNULL((SELECT CONCAT(u.nombres,' ',u.apellidos) FROM config_maquina cf, usuarios u WHERE cf.idmaquina=$id AND cf.descripcion='id_user_verificacion_filtros' LIMIT 1 ),'---') AS Usuario_cero,
                                (select valor from resultadosauditoria  where observacion='Lente 1 Lectura' and idauditoria = ra.idauditoria limit 1)  as Lente1_lectura,
                                (select valor from resultadosauditoria  where observacion='Lente 2 Lectura' and idauditoria = ra.idauditoria limit 1)  as Lente2_lectura,
                                (select valor from resultadosauditoria  where observacion='Lente 3 Lectura' and idauditoria = ra.idauditoria limit 1)  as Lente3_lectura,
                                (select valor from resultadosauditoria  where observacion='Lente 4 Lectura' and idauditoria = ra.idauditoria limit 1)  as Lente4_lectura,
                                (select valor from resultadosauditoria  where observacion='Lente 1 Valor' and idauditoria = ra.idauditoria limit 1)  as Lente1_valor,
                                (select valor from resultadosauditoria  where observacion='Lente 2 Valor' and idauditoria = ra.idauditoria limit 1)  as Lente2_valor,
                                (select valor from resultadosauditoria  where observacion='Lente 3 Valor' and idauditoria = ra.idauditoria limit 1)  as Lente3_valor,
                                (select valor from resultadosauditoria  where observacion='Lente 4 Valor' and idauditoria = ra.idauditoria limit 1)  as Lente4_valor,
                                (select valor from resultadosauditoria  where observacion='Lente 1 Desviación' and idauditoria = ra.idauditoria limit 1)  as Lente1_desviacion,
                                (select valor from resultadosauditoria  where observacion='Lente 2 Desviación' and idauditoria = ra.idauditoria limit 1)  as Lente2_desviacion,
                                (select valor from resultadosauditoria  where observacion='Lente 3 Desviación' and idauditoria = ra.idauditoria limit 1)  as Lente3_desviacion,
                                (select valor from resultadosauditoria  where observacion='Lente 4 Desviación' and idauditoria = ra.idauditoria limit 1)  as Lente4_desviacion,
                                (select valor from resultadosauditoria  where observacion='Error Total Lectura' and idauditoria = ra.idauditoria limit 1)  as Error_total_lectura,
                                (select valor from resultadosauditoria  where observacion='Estado' and idauditoria = ra.idauditoria limit 1)  as Resultado 
                                from resultadosauditoria ra 
                                where ra.idconfig_prueba = 58 and valor= $id AND 
                                SUBSTRING(ra.idauditoria,4) = '$fecha' 
                                group by 1 order by ra.idresultadosauditoria DESC");
        if ($data->num_rows() > 0) {
            $rta = $data->result();
            return $rta[0];
        }
    }

    function infousercreacion($iduser)
    {
        $data = $this->db->query("SELECT IFNULL(CONCAT(u.nombres,' ',u.apellidos),'---') AS usuario FROM usuarios u WHERE u.IdUsuario=$iduser");
        if ($data->num_rows() > 0) {
            $rta = $data->result();
            return $rta[0];
        }
    }

    public function infocda()
    {
        $query = $this->db->get('cda');
        return $query;
    }

    public function infosede()
    {
        $query = $this->db->query('SELECT s.*, c.nombre AS ciudad, d.nombre AS departamento
                           FROM sede s, ciudades c, deptos d
                            WHERE s.cod_ciudad=c.cod_ciudad AND c.cod_depto=d.cod_depto', FALSE);
        return $query;
    }

    function get_informe_crm($fechainicial, $fechafinal, $inspeccion)
    {
        $data = $this->db->query("SELECT  
                                    v.numero_placa AS 'Placa',
                                    tv.nombre AS 'Tipo_vehiculo',
                                    v.cilindraje AS 'Cilindraje',
                                    cr.numero_certificado AS 'Certificado',
                                    DATE_FORMAT(cr.fechaimpresion, '%Y/%m/%d') AS 'Fecha_impresion',
                                    DATE_FORMAT(cr.fecha_vigencia, '%Y/%m/%d') AS 'Fecha_vigencia', 
                                    IFNULL(DATE_FORMAT(v.fecha_vencimiento_soat, '%Y/%m/%d'),'---') AS 'Fecha_vencimiento_soat',   
                                    cl.numero_identificacion AS 'Numero_identidficacion',
                                    CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) AS 'Cliente',
                                    cl.telefono1 AS 'Telefono_1',
                                    IFNULL(cl.telefono2,'---') AS 'Telefono_2',
                                    IFNULL(cl.correo,'---') AS 'Correo',
                                    cl.cumpleanos AS 'Cumpleanos',
                                    c.nombre AS 'Ciudad',
                                    cl.direccion AS 'Direccion'
                                    FROM 
                                    hojatrabajo h,vehiculos v,clientes cl,certificados cr, tipo_vehiculo tv, ciudades c
                                    WHERE 
                                    cl.cod_ciudad=c.cod_ciudad AND 
                                    cr.idhojapruebas=h.idhojapruebas AND 
                                    h.idvehiculo=v.idvehiculo AND  
                                    v.idcliente=cl.idcliente AND 
                                    v.tipo_vehiculo=tv.idtipo_vehiculo AND 
                                    cr.fechaimpresion is not null AND 
                                    cr.fecha_vigencia is not NULL AND 
                                    $inspeccion AND
                                    DATE_FORMAT(cr.fecha_vigencia,'%Y-%m-%d') between DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d')");
        return $data;
    }

    function get_informe_crm_prev($fechainicial, $fechafinal, $inspeccion, $selectmeses)
    {
        $data = $this->db->query("SELECT
                                    v.numero_placa AS 'Placa',
                                    tv.nombre AS 'Tipo_vehiculo',
                                    v.cilindraje AS 'Cilindraje',
                                    DATE_FORMAT(h.fechafinal, '%Y/%m/%d') AS 'Fecha_impresion',
                                    DATE_ADD(DATE_FORMAT(h.fechafinal, '%Y/%m/%d'), INTERVAL $selectmeses MONTH) AS 'Fecha_vigencia', 
                                    DATE_FORMAT(h.fechainicial, '%Y/%m/%d') AS 'Fecha_registro',
                                    IFNULL(DATE_FORMAT(v.fecha_vencimiento_soat, '%Y/%m/%d'),'---') AS 'Fecha_vencimiento_soat',   
                                    cl.numero_identificacion AS 'Numero_identidficacion',
                                    CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) AS 'Cliente',
                                    cl.telefono1 AS 'Telefono_1',
                                    IFNULL(cl.telefono2,'---') AS 'Telefono_2',
                                    IFNULL(cl.correo,'---') AS 'Correo',
                                    cl.cumpleanos AS 'Cumpleanos',
                                    c.nombre AS 'Ciudad',
                                    cl.direccion AS 'Direccion'
                                    FROM 
                                    hojatrabajo h,vehiculos v,clientes cl,tipo_vehiculo tv, ciudades c
                                    WHERE 
                                    cl.cod_ciudad=c.cod_ciudad AND 
                                    h.idvehiculo=v.idvehiculo AND  
                                    v.idcliente=cl.idcliente AND 
                                    v.tipo_vehiculo=tv.idtipo_vehiculo AND 
                                    $inspeccion AND
                                    DATE_ADD(DATE_FORMAT(h.fechafinal, '%Y/%m/%d'), INTERVAL $selectmeses MONTH)
                                    between DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d')");
        return $data;
    }

    function get_informe_crm_servicio($fechainicial, $fechafinal, $inspeccion, $servicio)
    {
        $data = $this->db->query("SELECT  
                                    v.numero_placa AS 'Placa',
                                    tv.nombre AS 'Tipo_vehiculo',
                                    v.cilindraje AS 'Cilindraje',
                                    cr.numero_certificado AS 'Certificado',
                                    DATE_FORMAT(cr.fechaimpresion, '%Y/%m/%d') AS 'Fecha_impresion',
                                    DATE_FORMAT(cr.fecha_vigencia, '%Y/%m/%d') AS 'Fecha_vigencia', 
                                    IFNULL(DATE_FORMAT(v.fecha_vencimiento_soat, '%Y/%m/%d'),'---') AS 'Fecha_vencimiento_soat',   
                                    cl.numero_identificacion AS 'Numero_identidficacion',
                                    CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) AS 'Cliente',
                                    cl.telefono1 AS 'Telefono_1',
                                    IFNULL(cl.telefono2,'---') AS 'Telefono_2',
                                    IFNULL(cl.correo,'---') AS 'Correo',
                                    cl.cumpleanos AS 'Cumpleanos',
                                    c.nombre AS 'Ciudad',
                                    cl.direccion AS 'Direccion'
                                    FROM 
                                    hojatrabajo h,vehiculos v,clientes cl,certificados cr, tipo_vehiculo tv, ciudades c
                                    WHERE 
                                    cl.cod_ciudad=c.cod_ciudad AND 
                                    cr.idhojapruebas=h.idhojapruebas AND 
                                    h.idvehiculo=v.idvehiculo AND  
                                    v.idcliente=cl.idcliente AND 
                                    v.tipo_vehiculo=tv.idtipo_vehiculo AND 
                                    cr.fechaimpresion is not null AND 
                                    cr.fecha_vigencia is not NULL AND 
                                    $inspeccion AND
                                    v.idservicio = $servicio AND
                                    DATE_FORMAT(cr.fecha_vigencia,'%Y-%m-%d') between DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d')");
        return $data;
    }

    // nuevos informes de fugas y calibraciones
    function statscalibracionesnuevo($fechainicialca, $fechafinalca, $selanalizador)
    {
        $data = $this->db->query("SELECT 
                                c.idmaquina AS Id,
                                IFNULL((SELECT m.serie FROM maquina m WHERE c.idmaquina = m.idmaquina LIMIT 1),'---') AS Serie,
                                DATE_FORMAT(c.fecha,'%Y-%m-%d %H:%i:%s') AS Fecha,
                                c.pef AS Pef,
                                IFNULL((SELECT CONCAT(u.nombres,' ',u.apellidos) FROM usuarios u WHERE c.usuario=u.IdUsuario LIMIT 1),'---') AS Responsable,
                                IFNULL(c.span_alto_hc,'---') AS Span_alto_hc,
                                IFNULL(c.span_alto_co,'---') AS Span_alto_co,
                                IFNULL(c.span_alto_co2,'---') AS Span_alto_co2,
                                IFNULL((select 'Nitrógeno de balance'),'---') AS Span_alto_n,
                                IFNULL(c.span_bajo_hc,'---') AS Span_bajo_hc,
                                IFNULL(c.span_bajo_co,'---') AS Span_bajo_co,
                                IFNULL(c.span_bajo_co2,'---') AS Span_bajo_co2,
                                IFNULL((select 'Nitrógeno de balance'),'---') AS Span_bajo_n,
                                IFNULL(c.cal_alto_hc,'---') AS Cal_alto_hc,
                                IFNULL(c.cal_alto_co,'---') AS Cal_alto_co,
                                IFNULL(c.cal_alto_co2,'---') AS Cal_alto_co2,
                                IFNULL(c.cal_alto_o2,'---') AS Cal_alto_o2,
                                IFNULL(c.cal_bajo_hc,'---') AS Cal_bajo_hc,
                                IFNULL(c.cal_bajo_co,'---') AS Cal_bajo_co,
                                IFNULL(c.cal_bajo_co2,'---') AS Cal_bajo_co2,
                                IFNULL(c.cal_bajo_o2,'---') AS Cal_bajo_o2,
                                IF(c.resultado = 'S','APROBADO','NO APROBADO') AS resultado
                                FROM control_calibracion c
                                WHERE c.idmaquina = $selanalizador AND 
                                DATE_FORMAT(c.Fecha,'%Y-%m-%d') between DATE_FORMAT('$fechainicialca','%Y-%m-%d') AND DATE_FORMAT('$fechafinalca','%Y-%m-%d') ORDER BY 3 DESC ");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function reportpdfcalibracionesnuevo($fecha, $id)
    {
        $data = $this->db->query("SELECT 
                                IFNULL((SELECT m.serie FROM maquina m WHERE c.idmaquina = m.idmaquina LIMIT 1),'---') AS Serie,
                                DATE_FORMAT(c.fecha,'%Y-%m-%d %H:%i:%s') AS Fecha,
                                c.pef AS Pef,
                                IFNULL((SELECT CONCAT(u.nombres,' ',u.apellidos) FROM usuarios u WHERE c.usuario=u.IdUsuario LIMIT 1),'---') AS Responsable,
                                IFNULL(c.span_alto_hc,'---') AS Span_alto_hc,
                                IFNULL(c.span_alto_co,'---') AS Span_alto_co,
                                IFNULL(c.span_alto_co2,'---') AS Span_alto_co2,
                                IFNULL((select 'Nitrógeno de balance'),'---') AS Span_alto_n,
                                IFNULL(c.span_bajo_hc,'---') AS Span_bajo_hc,
                                IFNULL(c.span_bajo_co,'---') AS Span_bajo_co,
                                IFNULL(c.span_bajo_co2,'---') AS Span_bajo_co2,
                                IFNULL((select 'Nitrógeno de balance'),'---') AS Span_bajo_n,
                                IFNULL(c.cal_alto_hc,'---') AS Cal_alto_hc,
                                IFNULL(c.cal_alto_co,'---') AS Cal_alto_co,
                                IFNULL(c.cal_alto_co2,'---') AS Cal_alto_co2,
                                IFNULL(c.cal_alto_o2,'---') AS Cal_alto_o2,
                                IFNULL(c.cal_bajo_hc,'---') AS Cal_bajo_hc,
                                IFNULL(c.cal_bajo_co,'---') AS Cal_bajo_co,
                                IFNULL(c.cal_bajo_co2,'---') AS Cal_bajo_co2,
                                IFNULL(c.cal_bajo_o2,'---') AS Cal_bajo_o2,
                                IF(c.resultado = 'S','APROBADO','NO APROBADO') AS resultado
                                FROM control_calibracion c
                                WHERE c.idmaquina = $id AND 
                                DATE_FORMAT(c.Fecha,'%Y-%m-%d %H:%i:%s') = '$fecha' ORDER BY 1 DESC LIMIT 1");
        if ($data->num_rows() > 0) {
            $rta = $data->result();
            return $rta[0];
        }
    }

    function statsfugasnuevo($fechainicialca, $fechafinalca, $selanalizador)
    {
        $data = $this->db->query("SELECT 
                                c.idmaquina AS Id,
                                DATE_FORMAT(c.fecha,'%Y-%m-%d %H:%i:%s') AS Fecha,
                                IFNULL((SELECT m.serie FROM maquina m WHERE c.idmaquina = m.idmaquina LIMIT 1),'---') AS Serie,
                                (SELECT cl.pef FROM control_calibracion cl WHERE cl.idmaquina=c.idmaquina AND c.idmaquina= $selanalizador ORDER BY 1 DESC LIMIT  1) AS Pef,  
                                IFNULL((SELECT CONCAT(u.nombres,' ',u.apellidos) FROM usuarios u WHERE c.usuario=u.IdUsuario LIMIT 1),'---') AS Responsable,
                                IFNULL(c.presion_base,'---') AS presion_base, 
                                IFNULL(c.presion_bomba,'---') AS presion_bomba,
                                IFNULL(c.presion_filtros,'---') AS presion_filtros, 
                                IFNULL(c.presion_bombaoff,'---') AS vacio_bomba_apag, 
                                IFNULL(c.presion_bombaon,'---') AS vacio_bomba_pren, 
                                IFNULL(c.num_fuga,'---') AS total_fugas_num,
                                IFNULL(c.por_num_fuga,'---') AS total_fugas_porc,
                                IF(c.aprobado = 'S','Aprobado','No aprobado') AS resultado
                                FROM control_fugas c
                                WHERE c.idmaquina=$selanalizador AND 
                                DATE_FORMAT(c.Fecha,'%Y-%m-%d') between DATE_FORMAT('$fechainicialca','%Y-%m-%d') AND DATE_FORMAT('$fechafinalca','%Y-%m-%d') ORDER BY 2 DESC ");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function statsverificacion($fechainicialca, $fechafinalca, $selanalizador)
    {
        $data = $this->db->query("SELECT c.idcontrol_verificacion,c.idmaquina, c.auditor1, c.auditor2, c.fecha AS fecha,
                                c.serie, c.noSerieBench, c.ip, c.ciclo, c.span
                                FROM control_verificacion c
                                WHERE c.idmaquina=$selanalizador AND
                                DATE_FORMAT(c.fecha,'%Y-%m-%d') between DATE_FORMAT('$fechainicialca','%Y-%m-%d') AND DATE_FORMAT('$fechafinalca','%Y-%m-%d') ORDER BY 1 DESC ");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function dataVerificacion($id)
    {
        $data = $this->db->query("SELECT c.auditor1, c.datos FROM control_verificacion c WHERE c.idcontrol_verificacion=$id");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function reportpdffugasnuevo($fecha, $id)
    {
        $data = $this->db->query("SELECT 
                                DATE_FORMAT(c.fecha,'%Y-%m-%d %H:%i:%s') AS Fecha,
                                IFNULL((SELECT m.serie FROM maquina m WHERE c.idmaquina = m.idmaquina LIMIT 1),'---') AS Serie,
                                (SELECT cl.pef FROM control_calibracion cl WHERE cl.idmaquina=c.idmaquina AND c.idmaquina= $id ORDER BY 1 DESC LIMIT  1) AS Pef,  
                                IFNULL((SELECT CONCAT(u.nombres,' ',u.apellidos) FROM usuarios u WHERE c.usuario=u.IdUsuario LIMIT 1),'---') AS Responsable,
                                IFNULL(c.presion_base,'---') AS presion_base, 
                                IFNULL(c.presion_bomba,'---') AS presion_bomba,
                                IFNULL(c.presion_filtros,'---') AS presion_filtros, 
                                IFNULL(c.presion_bombaoff,'---') AS vacio_bomba_apag, 
                                IFNULL(c.presion_bombaon,'---') AS vacio_bomba_pren, 
                                IFNULL(c.num_fuga,'---') AS total_fugas_num,
                                IFNULL(c.por_num_fuga,'---') AS total_fugas_porc,
                                IF(c.aprobado = 'S','Aprobado','No aprobado') AS resultado
                                FROM control_fugas c
                                WHERE c.idmaquina=$id AND 
                                DATE_FORMAT(c.Fecha,'%Y-%m-%d %H:%i:%s') = '$fecha' ORDER BY 1 DESC LIMIT 1");
        if ($data->num_rows() > 0) {
            $rta = $data->result();
            return $rta[0];
        }
    }

    function linealidadNuevo($fechainicialca, $fechafinalca, $selopcaidad)
    {
        $data = $this->db->query("SELECT 
                                c.idmaquina AS 'Id',
                                DATE_FORMAT(c.fecha,'%Y-%m-%d %H:%i:%s') AS Fecha,
                                IFNULL((SELECT CONCAT(u.nombres,' ',u.apellidos) FROM usuarios u WHERE c.usuario = u.IdUsuario), '---') AS 'Usuario',
                                IFNULL(c.valor1, '---') AS 'Valor1',
                                IFNULL(c.valor2, '---') AS 'Valor2',
                                IFNULL(c.valor3, '---') AS 'Valor3',
                                IFNULL(c.valor4, '---') AS 'Valor4',
                                IFNULL(c.lectura1, '---') AS 'Lectura1',
                                IFNULL(c.lectura2, '---') AS 'Lectura2',
                                IFNULL(c.lectura3, '---') AS 'Lectura3',
                                IFNULL(c.lectura4, '---') AS 'Lectura4',
                                IFNULL(c.desviacion1, '---') AS 'Desviacion1',
                                IFNULL(c.desviacion2, '---') AS 'Desviacion2',
                                IFNULL(c.desviacion3, '---') AS 'Desviacion3',
                                IFNULL(c.desviacion4, '---') AS 'Desviacion4',
                                IF(c.aprobado= 'S', 'Aprobado', 'Rechazado') AS 'Resultado'
                                FROM control_linealidad c
                                WHERE c.idmaquina=$selopcaidad AND 
                                DATE_FORMAT(c.Fecha,'%Y-%m-%d') between DATE_FORMAT('$fechainicialca','%Y-%m-%d') AND DATE_FORMAT('$fechafinalca','%Y-%m-%d') ORDER BY 2 DESC");
        if ($data->num_rows() > 0) {
            $rta = $data->result();
            return $rta;
        }
    }

    function reportpdflinealidadNuevo($fecha, $id)
    {
        $data = $this->db->query("SELECT 
                                c.id AS 'Id',
                                DATE_FORMAT(c.fecha,'%Y-%m-%d %H:%i:%s') AS Fecha,
                                (select serie from maquina where idbanco=2 limit 1)  as Serie,
                                IFNULL((SELECT CONCAT(u.nombres,' ',u.apellidos) FROM usuarios u WHERE c.usuario = u.IdUsuario), '---') AS 'Responsable',
                                IFNULL(c.valor1, '---') AS 'Lente1_valor',
                                IFNULL(c.valor2, '---') AS 'Lente2_valor',
                                IFNULL(c.valor3, '---') AS 'Lente3_valor',
                                IFNULL(c.valor4, '---') AS 'Lente4_valor',
                                IFNULL(c.lectura1, '---') AS 'Lente1_lectura',
                                IFNULL(c.lectura2, '---') AS 'Lente2_lectura',
                                IFNULL(c.lectura3, '---') AS 'Lente3_lectura',
                                IFNULL(c.lectura4, '---') AS 'Lente4_lectura',
                                IFNULL(c.desviacion1, '---') AS 'Lente1_desviacion',
                                IFNULL(c.desviacion2, '---') AS 'Lente2_desviacion',
                                IFNULL(c.desviacion3, '---') AS 'Lente3_desviacion',
                                IFNULL(c.desviacion4, '---') AS 'Lente4_desviacion',
                                IF(c.aprobado= 'S', 'Aprobada', 'Rechazado') AS 'Resultado' 
                                FROM control_linealidad c
                                WHERE c.idmaquina=$id AND 
                                DATE_FORMAT(c.Fecha,'%Y-%m-%d %H:%i:%s') = '$fecha' ORDER BY 1 DESC LIMIT 1");
        if ($data->num_rows() > 0) {
            $rta = $data->result();
            return $rta[0];
        }
    }

    function controlceroNuevo($fechainicialca, $fechafinalca, $selopcaidad)
    {
        $data = $this->db->query("SELECT 
                                c.idmaquina AS 'Id',
                                DATE_FORMAT(c.fecha,'%Y-%m-%d %H:%i:%s') AS 'Fecha',
                                IFNULL((SELECT CONCAT(u.nombres,' ',u.apellidos) FROM usuarios u WHERE c.usuario = u.IdUsuario), '---') AS 'Usuario',
                                IFNULL(c.valor_antes, '---') AS 'Valorantes',
                                IFNULL(c.valor_despues, '---') AS 'Valordespues',
                                IF(c.aprobado= 'S', 'Aprobada', 'Rechazado') AS 'Resultado'
                                FROM control_cero c
                                WHERE c.idmaquina=$selopcaidad AND 
                                DATE_FORMAT(c.Fecha,'%Y-%m-%d') between DATE_FORMAT('$fechainicialca','%Y-%m-%d') AND DATE_FORMAT('$fechafinalca','%Y-%m-%d') ORDER BY 2 DESC");
        if ($data->num_rows() > 0) {
            $rta = $data->result();
            return $rta;
        }
    }

    function controlceroNuevoPdf($fecha, $id)
    {
        $data = $this->db->query("SELECT 
                                c.idcontrol_cero AS 'Id',
                                DATE_FORMAT(c.fecha,'%Y-%m-%d %H:%i:%s') AS 'Fecha',
                                IFNULL((SELECT CONCAT(u.nombres,' ',u.apellidos) FROM usuarios u WHERE c.usuario = u.IdUsuario), '---') AS 'Usuario',
                                IFNULL(c.valor_antes, '---') AS 'Valorantes',
                                IFNULL(c.valor_despues, '---') AS 'Valordespues',
                                IF(c.aprobado= 'S', 'Aprobada', 'Rechazado') AS 'Resultado'
                                FROM control_cero c
                                WHERE c.idmaquina=$id AND 
                                DATE_FORMAT(c.Fecha,'%Y-%m-%d %H:%i:%s') = '$fecha' ORDER BY 1 DESC LIMIT 1");
        if ($data->num_rows() > 0) {
            $rta = $data->result();
            return $rta[0];
        }
    }

    function tiempoRespuesta($fechainicialca, $fechafinalca, $selopcaidad)
    {
        $data = $this->db->query("SELECT c.*
                                FROM control_respuesta c 
                                WHERE c.idmaquina = $selopcaidad AND 
                                DATE_FORMAT(c.fecha,'%Y-%m-%d') between DATE_FORMAT('$fechainicialca','%Y-%m-%d') AND DATE_FORMAT('$fechafinalca','%Y-%m-%d') ORDER BY 1 DESC");
        if ($data->num_rows() > 0) {
            $rta = $data->result();
            return $rta;
        }
    }

    function resTiempoRespuesta($id)
    {
        $data = $this->db->query("SELECT  c.datos, c.idmaquina, c.fecha, c.placa,
IFNULL((SELECT cd.nombre_cda FROM cda cd),'') AS 'cda',
IFNULL((SELECT cd.numero_id FROM cda cd),'') AS 'nit' FROM control_respuesta c WHERE c.idcontrol_respuesta=$id");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    //bitacoras

    function isertBitacora($data)
    {
        if ($query = $this->db->insert('bitacora_operador', $data)) {
            return 1;
        }
    }

    function bitacorasOpen($idusuario)
    {
        $data = $this->db->query("SELECT b.*,
                                IFNULL((SELECT u.nombres FROM usuarios u WHERE u.IdUsuario=b.idusuario LIMIT 1),'---') AS 'user' 
                                FROM bitacora_operador b WHERE b.estado=1 AND b.idusuario=$idusuario ORDER BY b.fecha_apertura ASC ");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function updateBitacoras($fechacierre, $descripcion, $idbitacora)
    {
        $data = $this->db->query("UPDATE bitacora_operador b 
                                SET b.fecha_apertura=b.fecha_apertura, b.fecha_cierre = '$fechacierre', b.estado = 2, b.comentario = CONCAT('Descripcion inicial: ', b.comentario, '----', 'Descripcion cierre: ', '$descripcion')  
                                WHERE b.id=$idbitacora");
        return 1;
    }

    function getBitacoraInicioOperaciona($idusuario, $idmaquina)
    {
        $data = $this->db->query("SELECT * 
                                FROM bitacora_operador b
                                WHERE 
                                DATE_FORMAT(b.fecha_apertura, '%Y-%m-%d')  = CURDATE() AND b.comentario LIKE '%inicio op%' AND  b.idmaquina = $idmaquina and b.idusuario = $idusuario");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        } else {
            return [];
        }
    }

    function getBitacoras()
    {
        $data = $this->db->query("SELECT b.id,b.idmaquina, 
                                IFNULL((SELECT CONCAT(m.nombre,'--',m.marca,'--',m.serie) FROM maquina m WHERE b.idmaquina = m.idmaquina LIMIT 1),'---') AS nombre,
                                b.fecha_apertura, b.fecha_cierre,
                                IFNULL((SELECT CONCAT(u.nombres, ' ', u.apellidos) FROM usuarios u WHERE b.idusuario = u.IdUsuario LIMIT 1),'---') AS usuario,
                                b.comentario, b.tipo, b.gravedad,
                                IF(b.estado = 1, 'Abierto', 'Cerrado') AS estado
                                FROM bitacora_operador b  ORDER BY 1 DESC");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    //iniciar agop

    function infoCal($idconf_maquina)
    {
        $data = $this->db->query("SELECT 
                                c.idcontrol_calibracion AS Id,
                                c.idmaquina AS Idmaquina,
                                IFNULL((SELECT m.serie FROM maquina m WHERE c.idmaquina = m.idmaquina LIMIT 1),'---') AS Serie,
                                DATE_FORMAT(c.fecha,'%Y-%m-%d %H:%i:%s') AS Fecha,
                                c.pef AS Pef,
                                IFNULL((SELECT CONCAT(u.nombres,' ',u.apellidos) FROM usuarios u WHERE c.usuario=u.IdUsuario LIMIT 1),'---') AS Responsable,
                                IFNULL(c.span_alto_hc,'---') AS Span_alto_hc,
                                IFNULL(c.span_alto_co,'---') AS Span_alto_co,
                                IFNULL(c.span_alto_co2,'---') AS Span_alto_co2,
                                IFNULL((select 'Nitrógeno de balance'),'---') AS Span_alto_n,
                                IFNULL(c.span_bajo_hc,'---') AS Span_bajo_hc,
                                IFNULL(c.span_bajo_co,'---') AS Span_bajo_co,
                                IFNULL(c.span_bajo_co2,'---') AS Span_bajo_co2,
                                IFNULL((select 'Nitrógeno de balance'),'---') AS Span_bajo_n,
                                IFNULL(c.cal_alto_hc,'---') AS Cal_alto_hc,
                                IFNULL(c.cal_alto_co,'---') AS Cal_alto_co,
                                IFNULL(c.cal_alto_co2,'---') AS Cal_alto_co2,
                                IFNULL(c.cal_alto_o2,'---') AS Cal_alto_o2,
                                IFNULL(c.cal_bajo_hc,'---') AS Cal_bajo_hc,
                                IFNULL(c.cal_bajo_co,'---') AS Cal_bajo_co,
                                IFNULL(c.cal_bajo_co2,'---') AS Cal_bajo_co2,
                                IFNULL(c.cal_bajo_o2,'---') AS Cal_bajo_o2,
                                IFNULL(c.presion_base,'---') AS Presion_base,
                                IFNULL(c.presion_bomba,'---') AS Presion_bomba,
                                IF(c.resultado = 'S','APROBADO','NO APROBADO') AS resultado
                                FROM control_calibracion c
                                WHERE c.idmaquina = $idconf_maquina  ORDER BY 1 DESC LIMIT 1");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data[0];
        } else {
            return [];
        }
    }

    function insertCal($data)
    {
        if ($query = $this->db->insert('control_calibracion', $data)) {
            return 1;
        }
    }

    function infoOpa($idconf_maquina)
    {
        $data = $this->db->query("SELECT * FROM control_linealidad c WHERE c.idmaquina = $idconf_maquina ORDER BY 1 DESC LIMIT 1
                                ");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data[0];
        } else {
            return [];
        }
    }

    function insertFug($data)
    {
        if ($query = $this->db->insert('control_fugas', $data)) {
            return 1;
        }
    }
    function infoFug($idconf_maquina)
    {
        $data = $this->db->query("SELECT 
                                c.idmaquina AS Id,
                                DATE_FORMAT(c.fecha,'%Y-%m-%d %H:%i:%s') AS Fecha,
                                IFNULL((SELECT m.serie FROM maquina m WHERE c.idmaquina = m.idmaquina LIMIT 1),'---') AS Serie,
                                (SELECT cl.pef FROM control_calibracion cl WHERE cl.idmaquina=c.idmaquina AND c.idmaquina= $idconf_maquina ORDER BY 1 DESC LIMIT  1) AS Pef,  
                                IFNULL((SELECT CONCAT(u.nombres,' ',u.apellidos) FROM usuarios u WHERE c.usuario=u.IdUsuario LIMIT 1),'---') AS Responsable,
                                IFNULL(c.presion_base,'---') AS presion_base, 
                                IFNULL(c.presion_bomba,'---') AS presion_bomba,
                                IFNULL(c.presion_filtros,'---') AS presion_filtros, 
                                IFNULL(c.presion_bombaoff,'---') AS vacio_bomba_apag, 
                                IFNULL(c.presion_bombaon,'---') AS vacio_bomba_pren, 
                                IFNULL(c.num_fuga,'---') AS total_fugas_num,
                                IFNULL(c.por_num_fuga,'---') AS total_fugas_porc,
                                IF(c.aprobado = 'S','Aprobado','No aprobado') AS resultado
                                FROM control_fugas c
                                WHERE c.idmaquina=$idconf_maquina ORDER BY 1 DESC LIMIT 1
                                ");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data[0];
        } else {
            return [];
        }
    }

    function insertOpa($data)
    {
        if ($query = $this->db->insert('control_linealidad', $data)) {
            return 1;
        }
    }

    function informePesv($fechainicial, $fechafinal)
    {
        $data = $this->db->query("
            SELECT 
                p.fechainicial, v.numero_placa as 'numeroPlaca',
                IFNULL((SELECT c.nombre FROM clase c WHERE v.idclase = c.idclase LIMIT 1),'') AS 'Clase',
                IFNULL((SELECT CONCAT(u.nombres,'', u.apellidos) FROM usuarios u WHERE u.IdUsuario =  p.idusuario),'') AS 'Inspector',
                IFNULL((SELECT u.identificacion FROM  usuarios u WHERE u.IdUsuario =  p.idusuario),'') AS 'Identificacion',
                '' AS 'AuxPrerevision',
                '' AS 'IdentificacionP',
                if((h.estadototal = 2 OR h.estadototal = 4),'Aprobado','Rechazada') AS 'AprobadoReprobado',
                IFNULL(( SELECT cr.numero_certificado FROM certificados cr WHERE h.idhojapruebas = cr.idhojapruebas LIMIT 1),'') AS 'ConsecutivoRunt'
                FROM vehiculos v, hojatrabajo h, pruebas p 
                WHERE 
                v.idvehiculo = h.idvehiculo AND h.idhojapruebas = p.idhojapruebas 
                AND (h.reinspeccion = 0 OR h.reinspeccion = 1) AND p.idtipo_prueba = 8 AND 
                DATE_FORMAT(p.fechafinal,'%Y-%m-%d') between DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d') ORDER BY 1 ASC 
                                ");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        } else {
            return [];
        }
    }

    function informePesvPrere($placa)
    {
        $data = $this->db->query("
            SELECT
            pr.*,
                IFNULL((SELECT CONCAT(u.nombres,'', u.apellidos) FROM usuarios u WHERE u.IdUsuario =  pr.valor),'')  AS 'AuxPrerevisionPre',
                IFNULL((SELECT u.identificacion FROM usuarios u WHERE u.IdUsuario =  pr.valor),'')  AS 'IdentificacionPre'
                FROM pre_prerevision p, pre_dato pr, pre_atributo pe
WHERE 
p.idpre_prerevision = pr.idpre_prerevision AND pr.idpre_atributo = pe.idpre_atributo AND 
p.numero_placa_ref = '$placa' AND pe.id LIKE '%usuario_registro%' order BY 1 DESC LIMIT 1
                                ");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        } else {
            return [];
        }
    }
}
