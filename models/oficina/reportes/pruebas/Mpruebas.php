<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mpruebas extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->dbutil();
    }

//inicio consulta infome pruebas sonometro
    public function informe_sonometro($where, $idconf_maquina, $fechainicial, $fechafinal) {
         $consulta = <<<EOF
                  SELECT  DISTINCT
                        IFNULL((SELECT c.nombre_cda FROM cda c LIMIT 1),'---') AS 'Nombre cda',
                        IFNULL((SELECT c.numero_id FROM cda c LIMIT 1),'---') AS 'Numero cda',
                        IFNULL((SELECT c.tipo_identificacion FROM cda c LIMIT 1),'---') AS 'Nit',
                        IFNULL((SELECT s.direccion FROM cda c, sede s WHERE c.idcda = s.idcda LIMIT 1),'---') AS 'Direccion',
			ma.marca AS 'Marca_analizador',
			ma.serie AS 'Serie_analizador',
			DATE_FORMAT(p.fechafinal, '%Y/%m/%d') AS 'Fecha',
			v.numero_placa AS 'Placa',
			IFNULL(( SELECT t.nombre FROM tipo_vehiculo t WHERE t.idtipo_vehiculo = v.tipo_vehiculo LIMIT 1),'---') AS 'Tipo vehiculo',
			v.ano_modelo AS 'Modelo',
			v.tiempos,
			IF(v.idtipocombustible = 1,'Diesel',IF(v.idtipocombustible <> 1 && v.tipo_vehiculo<> 3,'Otto',IF(v.tiempos = 4 && v.tipo_vehiculo=3,'4T','2T'))) AS 'Ciclo',
			(SELECT ma.serie from maquina ma, pruebas p WHERE p.idmaquina=ma.idmaquina AND p.idtipo_prueba=4  limit 1) AS 'Modelo sonometro',
                 v.ano_modelo as 'Modelo',
                 v.cilindraje as 'Cilindraje',
			(SELECT valor FROM pruebas pr,resultados re WHERE pr.idtipo_prueba=4 AND pr.idhojapruebas=h.idhojapruebas AND re.idprueba=pr.idprueba AND re.tiporesultado='valor_ruido_motor1' ORDER BY 1 DESC LIMIT 1) 'Resultado ruido'
                        FROM 
			hojatrabajo h,pruebas p,vehiculos v,maquina ma
                        WHERE 
                        v.idvehiculo=h.idvehiculo AND
			h.idhojapruebas=p.idhojapruebas AND
			p.idmaquina=ma.idmaquina AND 
			ma.idmaquina=$idconf_maquina  AND 
         p.idtipo_prueba=4 AND
         $where AND
         (p.estado<>0 and p.estado <> 9 and p.estado <> 5) AND
         DATE_FORMAT(p.fechafinal,'%Y-%m-%d') between DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d')   order by p.fechafinal asc  
EOF;
        $rta = $this->db->query($consulta);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
            return $rta;
        } else {
            return [];
        }
        
    }

    function informe_luces($where, $idconf_maquina, $fechainicial, $fechafinal) {
        $consulta = <<<EOF
                  SELECT DISTINCT
                                DATE_FORMAT(p.fechafinal, '%Y/%m/%d %h:%i:%s') AS 'Fecha',
                                v.numero_placa as Placa,
                                IFNULL((SELECT t.nombre FROM tipo_vehiculo t WHERE v.tipo_vehiculo = t.idtipo_vehiculo LIMIT 1), '---') AS 'Tipo vehiculo',
                                IFNULL((SELECT s.nombre FROM servicio s WHERE v.idservicio = s.idservicio LIMIT 1),'---') AS 'Servicio',
                                CASE
                                    WHEN p.estado= 0 THEN 'Asignado'
                                    WHEN p.estado= 1 THEN 'Rechazado'
                                    WHEN p.estado= 3 THEN 'Reasignado'
                                    WHEN p.estado= 2 THEN 'Aprobado'
                                 ELSE 'Abortada'
                                 END AS 'Estado Prueba',
                                 CASE
                                    WHEN h.reinspeccion = 0 THEN 'Tec 1ra'
                                    WHEN h.reinspeccion = 1 THEN 'Tec Rei'
                                    WHEN h.reinspeccion = 4444 THEN 'Pre 1ra'
                                    WHEN h.reinspeccion = 44441 THEN 'Pre Rei'
                                    WHEN h.reinspeccion = 8888 THEN 'Lib'
                                 ELSE 'Error'
                                 END AS 'Tipo inspeccion',
                                IFNULL((SELECT CONCAT(u.nombres, ' ', u.apellidos) FROM usuarios u WHERE p.idusuario = u.IdUsuario  LIMIT 1),'') AS 'Usuario prueba',
                                IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idcliente=cl.idcliente LIMIT 1 ),'---') AS Cliente,
                                IFNULL((SELECT cl.telefono1 FROM clientes cl WHERE v.idcliente=cl.idcliente LIMIT 1 ),'---') AS 'Telefono cliente',
                                IFNULL((SELECT CONCAT(UPPER(ma.nombre),' - ',UPPER(ma.marca),' - ',UPPER(ma.serie)) FROM maquina ma WHERE p.idmaquina = ma.idmaquina LIMIT 1 ),'---') AS 'Maquina',
                                IFNULL((SELECT cla.nombre FROM clase cla WHERE v.idclase = cla.idclase LIMIT 1),'') AS 'clase',
                                 
                                v.ano_modelo Modelo,
                                IFNULL((SELECT t.nombre FROM tipo_vehiculo t WHERE v.tipo_vehiculo = t.idtipo_vehiculo LIMIT 1),'') AS 'Tipo vehiculo',
                               IF(v.registroRunt=1,
                                      (SELECT l.nombre FROM  linearunt l WHERE l.idlinearunt=v.idlinea),
                                      (SELECT l.nombre FROM linea l WHERE l.idlinea=v.idlinea)) 'Linea',
        if(v.registroRunt=1,
                                      (select m.nombre from linearunt l,marcarunt m where l.idmarcarunt=m.idmarcarunt and l.idlinearunt=v.idlinea),
                                      (select m.nombre from linea l,marca m where l.idmarca=m.idmarca and l.idlinea=v.idlinea)) AS 'Marca',
        v.ano_modelo AS 'Año modelo',
    
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=14 and r.tiporesultado = 1 limit 1),'---') 'Valor derecha baja',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=14 and r.tiporesultado = 2 limit 1),'---') 'Valor derecha baja 2',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=14 and r.tiporesultado = 3 limit 1),'---') 'Valor derecha baja 3',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=15 and r.tiporesultado = 1 limit 1),'---') 'Valor derecha alta',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=15 and r.tiporesultado = 2 limit 1),'---') 'Valor derecha alta 2',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=15 and r.tiporesultado = 3 limit 1),'---') 'Valor derecha alta 3',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=16 and r.tiporesultado = 1 limit 1),'---') 'Valor izquierda baja',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=16 and r.tiporesultado = 2 limit 1),'---') 'Valor izquierda baja 2',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=16 and r.tiporesultado = 3 limit 1),'---') 'Valor izquierda baja 3',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=17 and r.tiporesultado = 1 limit 1),'---') 'Valor izquierda alta',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=17 and r.tiporesultado = 2 limit 1),'---') 'Valor izquierda alta 2',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=17 and r.tiporesultado = 3 limit 1),'---') 'Valor izquierda alta 3',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=19 limit 1),'---') 'Valor inclinacion baja izquierda',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=20 limit 1),'---') 'Valor inclinacion derecha',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=190 limit 1),'---') 'Valor derecha antiniebla',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=190 and r.tiporesultado = 2 limit 1),'---') 'Valor derecha antiniebla 2',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=190 and r.tiporesultado = 3 limit 1),'---') 'Valor derecha antiniebla 3',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=191 limit 1),'---') 'valor izquierda antiniebla',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=191 and r.tiporesultado = 2 limit 1),'---') 'valor izquierda antiniebla 2',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=191 and r.tiporesultado = 3 limit 1),'---') 'valor izquierda antiniebla 3',
                                IFNULL((select abs(round(r.valor,1)) from resultados r where r.idprueba=p.idprueba and r.idconfig_prueba=18 limit 1),'---') 'Valor intensidad total'
                                FROM 
                                hojatrabajo h,pruebas p,vehiculos v
                                WHERE 
                                v.idvehiculo=h.idvehiculo AND
                                h.idhojapruebas=p.idhojapruebas AND
                                 
                                p.idmaquina=$idconf_maquina  AND 
                                p.idtipo_prueba=1 AND
                               $where AND
                                (p.estado<>0 and p.estado <> 9 and p.estado <> 5) AND
                                DATE_FORMAT(p.fechafinal,'%Y-%m-%d') between DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d');    
EOF;
                 
        // return $query;
        $rta = $this->db->query($consulta);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
            return $rta;
        } else {
            return [];
        }
    }

    function informe_frenos($where, $idconf_maquina, $fechainicial, $fechafinal) {
        $query = $this->db->query("SELECT DISTINCT
                            DATE_FORMAT(p.fechafinal, '%Y/%m/%d %h:%i:%s') AS 'Fecha', v.numero_placa as Placa, 
                            IFNULL((SELECT t.nombre FROM tipo_vehiculo t WHERE v.tipo_vehiculo = t.idtipo_vehiculo LIMIT 1), '---') AS 'Tipo vehiculo',
                                IFNULL((SELECT s.nombre FROM servicio s WHERE v.idservicio = s.idservicio LIMIT 1),'---') AS 'Servicio',
                                CASE
                                   WHEN p.estado= 0 THEN 'Asignado'
                                   WHEN p.estado= 1 THEN 'Rechazado'
                                   WHEN p.estado= 3 THEN 'Reasignado'
                                   WHEN p.estado= 2 THEN 'Aprobado'
                                ELSE 'Abortada'
                                END AS 'Estado Prueba',
                                CASE
                                   WHEN h.reinspeccion = 0 THEN 'Tec 1ra'
                                   WHEN h.reinspeccion = 1 THEN 'Tec Rei'
                                   WHEN h.reinspeccion = 4444 THEN 'Pre 1ra'
                                   WHEN h.reinspeccion = 44441 THEN 'Pre Rei'
                                   WHEN h.reinspeccion = 8888 THEN 'Lib'
                                ELSE 'Error'
                                END AS 'Tipo inspeccion',
                                IFNULL((SELECT CONCAT(u.nombres, ' ', u.apellidos) FROM usuarios u WHERE p.idusuario = u.IdUsuario  LIMIT 1),'') AS 'Usuario prueba',
                                IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idcliente=cl.idcliente LIMIT 1 ),'---') AS Cliente, 
                                IFNULL((SELECT cl.telefono1 FROM clientes cl WHERE v.idcliente=cl.idcliente LIMIT 1 ),'---') AS 'Telefono cliente', 
                                IFNULL((SELECT CONCAT(UPPER(ma.nombre),' - ',UPPER(ma.marca),' - ',UPPER(ma.serie)) FROM maquina ma WHERE p.idmaquina = ma.idmaquina LIMIT 1 ),'---') AS 'Maquina', 
                                c.nombre Clase, v.ano_modelo Modelo,
                                IFNULL((SELECT t.nombre FROM tipo_vehiculo t WHERE v.tipo_vehiculo = t.idtipo_vehiculo LIMIT 1),'') AS 'Tipo vehiculo',
                                if(v.registrorunt=1,(select nombre from marcarunt where idmarcaRUNT=(select idmarcaRunt from linearunt where idlineaRUNT=v.idlinea limit 1) limit 1),m.nombre) as Marca, 
                                if(v.registrorunt=1,(select nombre from linearunt where idlineaRUNT=v.idlinea limit 1),l.nombre) AS Linea,
                                ifnull((select t.nombre from tipo_vehiculo t where v.tipo_vehiculo = t.idtipo_vehiculo limit 1),'---') AS 'Tipo vehiculo',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Frenos eje 1 derecho' ORDER BY 1 DESC LIMIT 1),'---') 'Fuerza eje 1 derecho',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Frenos eje 1 Izquierdo' ORDER BY 1 DESC LIMIT 1),'---') 'Fuerza eje 1 izquierdo', 
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Frenos eje 2 derecho' ORDER BY 1 DESC LIMIT 1),'---') 'Fuerza eje 2 derecho',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Frenos eje 2 Izquierdo' ORDER BY 1 DESC LIMIT 1),'---') 'Fuerza eje 2 izquierdo',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Frenos eje 3 derecho' ORDER BY 1 DESC LIMIT 1),'---') 'Fuerza eje 3 derecho',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Frenos eje 3 Izquierdo' ORDER BY 1 DESC LIMIT 1),'---') 'Fuerza eje 3 izquierdo',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Frenos eje 4 derecho' ORDER BY 1 DESC LIMIT 1),'---') 'Fuerza eje 4 derecho',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Frenos eje 4 Izquierdo' ORDER BY 1 DESC LIMIT 1),'---') 'Fuerza eje 4 izquierdo',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Frenos eje 5 derecho' ORDER BY 1 DESC LIMIT 1),'---') 'Fuerza eje 5 derecho',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Frenos eje 5 Izquierdo' ORDER BY 1 DESC LIMIT 1),'---') 'Fuerza eje 5 izquierdo',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Pesaje eje 1 derecho' ORDER BY 1 DESC LIMIT 1),'---') 'Pesaje eje 1 derecho',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Pesaje eje 1 Izquierdo' ORDER BY 1 DESC LIMIT 1),'---') 'Pesaje eje 1 izquierdo',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Pesaje eje 2 derecho' ORDER BY 1 DESC LIMIT 1),'---') 'Pesaje eje 2 derecho',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Pesaje eje 2 Izquierdo' ORDER BY 1 DESC LIMIT 1),'---') 'Pesaje eje 2 izquierdo',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Pesaje eje 3 derecho' ORDER BY 1 DESC LIMIT 1),'---') 'Pesaje eje 3 derecho',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Pesaje eje 3 Izquierdo' ORDER BY 1 DESC LIMIT 1),'---') 'Pesaje eje 3 izquierdo',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Pesaje eje 4 derecho' ORDER BY 1 DESC LIMIT 1),'---') 'Pesaje eje 4 derecho',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Pesaje eje 4 Izquierdo' ORDER BY 1 DESC LIMIT 1),'---') 'Pesaje eje 4 izquierdo',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Pesaje eje 5 derecho' ORDER BY 1 DESC LIMIT 1),'---') 'Pesaje eje 5 derecho',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Pesaje eje 5 Izquierdo' ORDER BY 1 DESC LIMIT 1),'---') 'Pesaje eje 5 izquierdo',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Desequilibrio eje 1' ORDER BY 1 DESC LIMIT 1),'---') 'Desequilibrio eje 1',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Desequilibrio eje 2' ORDER BY 1 DESC LIMIT 1),'---') 'Desequilibrio eje 2',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Desequilibrio eje 3' ORDER BY 1 DESC LIMIT 1),'---') 'Desequilibrio eje 3',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Desequilibrio eje 4' ORDER BY 1 DESC LIMIT 1),'---') 'Desequilibrio eje 4',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Desequilibrio eje 5' ORDER BY 1 DESC LIMIT 1),'---') 'Desequilibrio eje 5',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='FrenoAuxs eje 2 derecho' ORDER BY 1 DESC LIMIT 1),'---') 'Freno Auxs eje 2 derecho',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='FrenoAuxs eje 2 Izquierdo' ORDER BY 1 DESC LIMIT 1),'---') 'Freno Auxs eje 2 Izquierdo',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='eficacia_auxiliar' ORDER BY 1 DESC LIMIT 1),'---') 'Eficacia auxiliar',
                                IFNULL((SELECT valor FROM resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='eficacia_maxima' ORDER BY 1 DESC LIMIT 1),'---') 'Eficacia maxima'
                                FROM hojatrabajo h,pruebas p,vehiculos v,maquina ma, marca m , linea l , clase c 
                                WHERE v.idvehiculo=h.idvehiculo AND h.idhojapruebas=p.idhojapruebas 
                                AND v.idlinea = l.idlinea AND l.idmarca = m.idmarca AND v.idclase = c.idclase 
                                AND p.idmaquina=ma.idmaquina  AND ma.idmaquina=$idconf_maquina AND p.idtipo_prueba=7 
                                AND $where AND (p.estado<>0 and p.estado <> 9 and p.estado <> 5) AND DATE_FORMAT(p.fechafinal,'%Y-%m-%d') 
                                between DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d')");
        return $query;
    }

    function informe_suspension($where, $idconf_maquina, $fechainicial, $fechafinal) {
        $query = $this->db->query("SELECT DISTINCT
            DATE_FORMAT(p.fechafinal, '%Y/%m/%d %h:%i:%s') AS 'Fecha', v.numero_placa as Placa, 
            IFNULL((SELECT t.nombre FROM tipo_vehiculo t WHERE v.tipo_vehiculo = t.idtipo_vehiculo LIMIT 1), '---') AS 'Tipo vehiculo',
                IFNULL((SELECT s.nombre FROM servicio s WHERE v.idservicio = s.idservicio LIMIT 1),'---') AS 'Servicio',
                                CASE
                                   WHEN p.estado= 0 THEN 'Asignado'
                                   WHEN p.estado= 1 THEN 'Rechazado'
                                   WHEN p.estado= 3 THEN 'Reasignado'
                                   WHEN p.estado= 2 THEN 'Aprobado'
                                ELSE 'Abortada'
                                END AS 'Estado Prueba',
                                CASE
                                   WHEN h.reinspeccion = 0 THEN 'Tec 1ra'
                                   WHEN h.reinspeccion = 1 THEN 'Tec Rei'
                                   WHEN h.reinspeccion = 4444 THEN 'Pre 1ra'
                                   WHEN h.reinspeccion = 44441 THEN 'Pre Rei'
                                   WHEN h.reinspeccion = 8888 THEN 'Lib'
                                ELSE 'Error'
                                END AS 'Tipo inspeccion',
                                IFNULL((SELECT CONCAT(u.nombres, ' ', u.apellidos) FROM usuarios u WHERE p.idusuario = u.IdUsuario  LIMIT 1),'') AS 'Usuario prueba',
                                IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idcliente=cl.idcliente LIMIT 1 ),'---') AS Cliente, 
                                IFNULL((SELECT cl.telefono1 FROM clientes cl WHERE v.idcliente=cl.idcliente LIMIT 1 ),'---') AS 'Telefono cliente', 
                                IFNULL((SELECT CONCAT(UPPER(ma.nombre),' - ',UPPER(ma.marca),' - ',UPPER(ma.serie)) FROM maquina ma WHERE p.idmaquina = ma.idmaquina LIMIT 1 ),'---') AS 'Maquina', 
                                c.nombre Clase, v.ano_modelo Modelo,
                                IFNULL((SELECT t.nombre FROM tipo_vehiculo t WHERE v.tipo_vehiculo = t.idtipo_vehiculo LIMIT 1),'') AS 'Tipo vehiculo',
                                if(v.registrorunt=1,(select nombre from marcarunt where idmarcaRUNT=(select idmarcaRunt from linearunt where idlineaRUNT=v.idlinea limit 1) limit 1),m.nombre) as marca, 
                                if(v.registrorunt=1,(select nombre from linearunt where idlineaRUNT=v.idlinea limit 1),l.nombre) AS linea, 
                                IFNULL((SELECT re.valor FROM   resultados re  WHERE   re.idprueba=p.idprueba AND  re.idconfig_prueba=142 ORDER BY 1 DESC LIMIT 1),'---') 'Delantera derecha',
                                IFNULL((SELECT re.valor FROM   resultados re  WHERE   re.idprueba=p.idprueba AND  re.idconfig_prueba=143 ORDER BY 1 DESC LIMIT 1),'---') 'Delantera izquierda',
                                IFNULL((SELECT re.valor FROM   resultados re  WHERE   re.idprueba=p.idprueba AND  re.idconfig_prueba=144 ORDER BY 1 DESC LIMIT 1),'---') 'Trasera derecha',
                                IFNULL((SELECT re.valor FROM   resultados re  WHERE   re.idprueba=p.idprueba AND  re.idconfig_prueba=145 ORDER BY 1 DESC LIMIT 1),'---') 'Trasera izquierda'
                                FROM hojatrabajo h,pruebas p,vehiculos v,maquina ma, marca m , linea l , clase c 
                                WHERE v.idvehiculo=h.idvehiculo AND h.idhojapruebas=p.idhojapruebas 
                                AND v.idlinea = l.idlinea AND l.idmarca = m.idmarca AND v.idclase = c.idclase 
                                AND p.idmaquina=ma.idmaquina  AND ma.idmaquina=$idconf_maquina AND p.idtipo_prueba=9 
                                AND $where AND (p.estado<>0 and p.estado <> 9 and p.estado <> 5) AND DATE_FORMAT(p.fechafinal,'%Y-%m-%d') 
                                between DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d')");
        return $query;
    }

    function informe_alineador($where, $idconf_maquina, $fechainicial, $fechafinal) {
        $query = $this->db->query("SELECT DISTINCT
            DATE_FORMAT(p.fechafinal, '%Y/%m/%d %h:%i:%s') AS 'Fecha', v.numero_placa as Placa, 
            IFNULL((SELECT t.nombre FROM tipo_vehiculo t WHERE v.tipo_vehiculo = t.idtipo_vehiculo LIMIT 1), '---') AS 'Tipo vehiculo',
                IFNULL((SELECT s.nombre FROM servicio s WHERE v.idservicio = s.idservicio LIMIT 1),'---') AS 'Servicio',
                                CASE
                                   WHEN p.estado= 0 THEN 'Asignado'
                                   WHEN p.estado= 1 THEN 'Rechazado'
                                   WHEN p.estado= 3 THEN 'Reasignado'
                                   WHEN p.estado= 2 THEN 'Aprobado'
                                ELSE 'Abortada'
                                END AS 'Estado Prueba',
                                CASE
                                   WHEN h.reinspeccion = 0 THEN 'Tec 1ra'
                                   WHEN h.reinspeccion = 1 THEN 'Tec Rei'
                                   WHEN h.reinspeccion = 4444 THEN 'Pre 1ra'
                                   WHEN h.reinspeccion = 44441 THEN 'Pre Rei'
                                   WHEN h.reinspeccion = 8888 THEN 'Lib'
                                ELSE 'Error'
                                END AS 'Tipo inspeccion',
                                    IFNULL((SELECT CONCAT(u.nombres, ' ', u.apellidos) FROM usuarios u WHERE p.idusuario = u.IdUsuario  LIMIT 1),'') AS 'Usuario prueba',
                                IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idcliente=cl.idcliente LIMIT 1 ),'---') AS Cliente, 
                                IFNULL((SELECT cl.telefono1 FROM clientes cl WHERE v.idcliente=cl.idcliente LIMIT 1 ),'---') AS 'Telefono cliente', 
                                IFNULL((SELECT CONCAT(UPPER(ma.nombre),' - ',UPPER(ma.marca),' - ',UPPER(ma.serie)) FROM maquina ma WHERE p.idmaquina = ma.idmaquina LIMIT 1 ),'---') AS 'Maquina', 
                                c.nombre Clase, v.ano_modelo Modelo,
                                IFNULL((SELECT t.nombre FROM tipo_vehiculo t WHERE v.tipo_vehiculo = t.idtipo_vehiculo LIMIT 1),'') AS 'Tipo vehiculo',
                                if(v.registrorunt=1,(select nombre from marcarunt where idmarcaRUNT=(select idmarcaRunt from linearunt where idlineaRUNT=v.idlinea limit 1) limit 1),m.nombre) as marca, 
                                if(v.registrorunt=1,(select nombre from linearunt where idlineaRUNT=v.idlinea limit 1),l.nombre) AS linea, 
                                IFNULL((SELECT re.valor FROM   resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Alineación eje 1' ORDER BY 1 DESC LIMIT 1),'---') 'Alineacion eje 1',
                                IFNULL((SELECT re.valor FROM   resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Alineación eje 2' ORDER BY 1 DESC LIMIT 1),'---') 'Alineacion eje 2',
                                IFNULL((SELECT re.valor FROM   resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Alineación eje 3' ORDER BY 1 DESC LIMIT 1),'---') 'Alineacion eje 3',
                                IFNULL((SELECT re.valor FROM   resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Alineación eje 4' ORDER BY 1 DESC LIMIT 1),'---') 'Alineacion eje 4',
                                IFNULL((SELECT re.valor FROM   resultados re  WHERE   re.idprueba=p.idprueba AND  re.observacion='Alineación eje 5' ORDER BY 1 DESC LIMIT 1),'---') 'Alineacion eje 5'
                                FROM hojatrabajo h,pruebas p,vehiculos v,maquina ma, marca m , linea l , clase c 
                                WHERE v.idvehiculo=h.idvehiculo AND h.idhojapruebas=p.idhojapruebas 
                                AND v.idlinea = l.idlinea AND l.idmarca = m.idmarca AND v.idclase = c.idclase 
                                AND p.idmaquina=ma.idmaquina  AND ma.idmaquina=$idconf_maquina AND p.idtipo_prueba=10 
                                AND $where AND (p.estado<>0 and p.estado <> 9 and p.estado <> 5) AND DATE_FORMAT(p.fechafinal,'%Y-%m-%d') 
                                between DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d')");
        return $query;
    }

    function informe_taximetro($where, $idconf_maquina, $fechainicial, $fechafinal) {
        $query = $this->db->query("SELECT DISTINCT
                                DATE_FORMAT(p.fechafinal, '%Y/%m/%d %h:%i:%s') AS 'Fecha', v.numero_placa as Placa, 
                                IFNULL((SELECT t.nombre FROM tipo_vehiculo t WHERE v.tipo_vehiculo = t.idtipo_vehiculo LIMIT 1), '---') AS 'Tipo vehiculo',
                IFNULL((SELECT s.nombre FROM servicio s WHERE v.idservicio = s.idservicio LIMIT 1),'---') AS 'Servicio',
                                CASE
                                   WHEN p.estado= 0 THEN 'Asignado'
                                   WHEN p.estado= 1 THEN 'Rechazado'
                                   WHEN p.estado= 3 THEN 'Reasignado'
                                   WHEN p.estado= 2 THEN 'Aprobado'
                                ELSE 'Abortada'
                                END AS 'Estado Prueba',
                                CASE
                                   WHEN h.reinspeccion = 0 THEN 'Tec 1ra'
                                   WHEN h.reinspeccion = 1 THEN 'Tec Rei'
                                   WHEN h.reinspeccion = 4444 THEN 'Pre 1ra'
                                   WHEN h.reinspeccion = 44441 THEN 'Pre Rei'
                                   WHEN h.reinspeccion = 8888 THEN 'Lib'
                                ELSE 'Error'
                                END AS 'Tipo inspeccion',
                                IFNULL((SELECT CONCAT(u.nombres, ' ', u.apellidos) FROM usuarios u WHERE p.idusuario = u.IdUsuario  LIMIT 1),'') AS 'Usuario prueba',
                                IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idcliente=cl.idcliente LIMIT 1 ),'---') AS Cliente, 
                                IFNULL((SELECT cl.telefono1 FROM clientes cl WHERE v.idcliente=cl.idcliente LIMIT 1 ),'---') AS 'Telefono cliente', 
                                IFNULL((SELECT CONCAT(UPPER(ma.nombre),' - ',UPPER(ma.marca),' - ',UPPER(ma.serie)) FROM maquina ma WHERE p.idmaquina = ma.idmaquina LIMIT 1 ),'---') AS 'Maquina', 
                                c.nombre Clase, v.ano_modelo Modelo,
                                IFNULL((SELECT t.nombre FROM tipo_vehiculo t WHERE v.tipo_vehiculo = t.idtipo_vehiculo LIMIT 1),'') AS 'Tipo vehiculo',
                                if(v.registrorunt=1,(select nombre from marcarunt where idmarcaRUNT=(select idmarcaRunt from linearunt where idlineaRUNT=v.idlinea limit 1) limit 1),m.nombre) as marca, 
                                if(v.registrorunt=1,(select nombre from linearunt where idlineaRUNT=v.idlinea limit 1),l.nombre) AS linea, 
                                IFNULL((SELECT re.valor FROM   resultados re  WHERE   re.idprueba=p.idprueba AND  re.tiporesultado='Rllanta' ORDER BY 1 DESC LIMIT 1),'---') 'Referencia Comercial de la llanta',
IFNULL((SELECT re.valor FROM   resultados re  WHERE   re.idprueba=p.idprueba AND  re.tiporesultado='error_tiempo_nuevo' ORDER BY 1 DESC LIMIT 1),'---') 'Error en distancia',
IFNULL((SELECT re.valor FROM   resultados re  WHERE   re.idprueba=p.idprueba AND  re.tiporesultado='error_distancia_nuevo' ORDER BY 1 DESC LIMIT 1),'---') 'Error en tiempo',
IFNULL((SELECT re.valor FROM   resultados re  WHERE   re.idprueba=p.idprueba AND  re.tiporesultado='vector_tiempo' ORDER BY 1 DESC LIMIT 1),'---') 'Vector tiempo',
IFNULL((SELECT re.valor FROM   resultados re  WHERE   re.idprueba=p.idprueba AND  re.tiporesultado='vector_distancia' ORDER BY 1 DESC LIMIT 1),'---') 'Vector distancia'
                                FROM hojatrabajo h,pruebas p,vehiculos v,maquina ma, marca m , linea l , clase c 
                                WHERE v.idvehiculo=h.idvehiculo AND h.idhojapruebas=p.idhojapruebas 
                                AND v.idlinea = l.idlinea AND l.idmarca = m.idmarca AND v.idclase = c.idclase 
                                AND p.idmaquina=ma.idmaquina  AND ma.idmaquina=$idconf_maquina AND p.idtipo_prueba=6 
                                AND $where AND (p.estado<>0 and p.estado <> 9 and p.estado <> 5) AND DATE_FORMAT(p.fechafinal,'%Y-%m-%d') 
                                between DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d')");
        return $query;
    }

    function gettiempoPruebas($where) {
        $query = $this->db->query("(SELECT 
                    distinct v.numero_placa PLACA,
                    date_format((select p2.fechainicial from pruebas p2 where p2.idhojapruebas=h.idhojapruebas and p2.fechainicial=h.fechainicial order by p2.fechainicial limit 1), '%Y-%m-%d') FECHA,
                    date_format((select p2.fechainicial from pruebas p2 where p2.idhojapruebas=h.idhojapruebas and p2.fechainicial=h.fechainicial order by p2.fechainicial limit 1),'%H:%i:%s') HORA_INICIAL_Y_REGISTRO,
                    ifnull(date_format((select p2.fechafinal from pruebas p2 where p2.idhojapruebas=h.idhojapruebas and p2.fechainicial=h.fechainicial order by p2.fechafinal desc limit 1),'%H:%i:%s'),'---') HORA_FINAL,
                    if(h.estadototal=4 and h.reinspeccion=0,date_format(h.fechafinal,'%H:%i:%s'),'No certificado') HORA_IMPRESION,
                    if(v.tipo_vehiculo=1,'Liviano',if(v.tipo_vehiculo=3,'Moto','Pesado')) TIPO_VEHICULO,
                    'Primera vez' INSPECCION,
                    IFNULL(TIMESTAMPDIFF(MINUTE, 
                    (select p2.fechainicial from pruebas p2 where p2.idhojapruebas=h.idhojapruebas and p2.fechainicial=h.fechainicial order by p2.fechainicial limit 1),
                    (select p2.fechafinal from pruebas p2 where p2.idhojapruebas=h.idhojapruebas and p2.fechainicial=h.fechainicial order by p2.fechafinal desc limit 1)),'---') TIEMPO_INSPECCION,
                    if(h.estadototal=4 AND (h.reinspeccion=0 OR h.reinspeccion = 1),TIMESTAMPDIFF(MINUTE,(select p2.fechainicial from pruebas p2 where p2.idhojapruebas=h.idhojapruebas and p2.fechainicial=h.fechainicial order by p2.fechainicial limit 1),h.fechafinal),'No aplica') TIEMPO_TOTAL
                    from 
                    pruebas p, hojatrabajo h, vehiculos v 
                    WHERE 
                    p.idhojapruebas=h.idhojapruebas and
                    (h.reinspeccion=0 or h.reinspeccion=1) and 
                    h.idvehiculo=v.idvehiculo and
                    h.fechainicial=p.fechainicial and
                    (p.idtipo_prueba<>55 OR p.idtipo_prueba <> 21 OR p.idtipo_prueba <> 22) and
                    h.estadototal<>5 and
                    $where
                    order BY p.fechainicial ASC 
                    )
                    UNION 
                    (
                    select 
                    distinct v.numero_placa PLACA,
                    IFNULL(date_format((select p2.fechainicial from pruebas p2 where p2.idhojapruebas=h.idhojapruebas   order by p2.fechainicial desc limit 1),'%Y-%m-%d'),'---') FECHA,
                    IFNULL(date_format((select p2.fechainicial from pruebas p2 where p2.idhojapruebas=h.idhojapruebas   order by p2.fechainicial desc limit 1),'%H:%i:%s'),'---') HORA_INICIAL_Y_REGISTRO,
                    ifnull(date_format((select p2.fechafinal from pruebas p2 where p2.idhojapruebas=h.idhojapruebas   order by p2.fechafinal desc limit 1),'%H:%i:%s'),'---') HORA_FINAL,
                    if(h.estadototal=4,date_format(h.fechafinal,'%H:%i:%s'),'No certificado') HORA_IMPRESION,
                    if(v.tipo_vehiculo=1,'Liviano',if(v.tipo_vehiculo=3,'Moto','Pesado')) TIPO_VEHICULO,
                    'Segunda vez' INSPECCION,
                    IFNULL( TIMESTAMPDIFF(MINUTE, 
                    (select p2.fechainicial from pruebas p2 where p2.idhojapruebas=h.idhojapruebas  order by p2.fechainicial desc limit 1),
                    (select p2.fechafinal from pruebas p2 where p2.idhojapruebas=h.idhojapruebas  order by p2.fechafinal desc limit 1)),'---') TIEMPO_INSPECCION,
                    if(h.estadototal=4,TIMESTAMPDIFF(MINUTE,(select p2.fechainicial from pruebas p2 where p2.idhojapruebas=h.idhojapruebas  order by p2.fechainicial desc limit 1),h.fechafinal),'No aplica') TIEMPO_TOTAL
                    from 
                    pruebas p, hojatrabajo h, vehiculos v 
                    where
                    p.idhojapruebas=h.idhojapruebas and
                    (h.reinspeccion=0 OR h.reinspeccion = 1) and
                    h.idvehiculo=v.idvehiculo and
                    (p.idtipo_prueba<>55 OR p.idtipo_prueba <> 21 OR p.idtipo_prueba <> 22) and
                    h.estadototal<>5 and
                    $where
                    order BY p.fechainicial ASC 
                    );");
        if ($query->num_rows() > 0) {
            $query = $query->result();
            return $query;
        }
    }
    function getPruebasCliente($where) {
        $query = $this->db->query("SELECT 
                v.numero_placa AS 'Placa',
                h.fechainicial,
                h.idhojapruebas,
                h.reinspeccion,
                v.nombre_empresa
                FROM vehiculos v, hojatrabajo h
                WHERE v.idvehiculo = h.idvehiculo  AND h.reinspeccion = 4444 AND  v.nombre_empresa IS NOT NULL and $where ORDER BY 1 DESC ");
        if ($query->num_rows() > 0) {
            $query = $query->result();
            return $query;
        }
    }

//    function gettiempoPruebas($where) {
//        $query = $this->db->query("(SELECT 
//                    distinct v.numero_placa PLACA,
//                    date_format((select p2.fechainicial from pruebas p2 where p2.idhojapruebas=h.idhojapruebas and p2.fechainicial=h.fechainicial order by p2.fechainicial limit 1), '%Y-%m-%d') FECHA,
//                    date_format((select p2.fechainicial from pruebas p2 where p2.idhojapruebas=h.idhojapruebas and p2.fechainicial=h.fechainicial order by p2.fechainicial limit 1),'%H:%i:%s') HORA_INICIAL_Y_REGISTRO,
//                    ifnull(date_format((select p2.fechafinal from pruebas p2 where p2.idhojapruebas=h.idhojapruebas and p2.fechainicial=h.fechainicial order by p2.fechafinal desc limit 1),'%H:%i:%s'),'---') HORA_FINAL,
//                    if(h.estadototal=4 and h.reinspeccion=0,date_format(h.fechafinal,'%H:%i:%s'),'No certificado') HORA_IMPRESION,
//                    if(v.tipo_vehiculo=1,'Liviano',if(v.tipo_vehiculo=3,'Moto','Pesado')) TIPO_VEHICULO,
//                    'Primera vez' INSPECCION,
//                    IFNULL(TIMESTAMPDIFF(MINUTE, 
//                    (select p2.fechainicial from pruebas p2 where p2.idhojapruebas=h.idhojapruebas and p2.fechainicial=h.fechainicial order by p2.fechainicial limit 1),
//                    (select p2.fechafinal from pruebas p2 where p2.idhojapruebas=h.idhojapruebas and p2.fechainicial=h.fechainicial order by p2.fechafinal desc limit 1)),'---') TIEMPO_INSPECCION,
//                    if(h.estadototal=4 and h.reinspeccion=0,TIMESTAMPDIFF(MINUTE,(select p2.fechainicial from pruebas p2 where p2.idhojapruebas=h.idhojapruebas and p2.fechainicial=h.fechainicial order by p2.fechainicial limit 1),h.fechafinal),'No aplica') TIEMPO_TOTAL
//                    from 
//                    pruebas p, hojatrabajo h, vehiculos v 
//                    WHERE 
//                    p.idhojapruebas=h.idhojapruebas and
//                    (h.reinspeccion=0 or h.reinspeccion=1) and 
//                    h.idvehiculo=v.idvehiculo and
//                    h.fechainicial=p.fechainicial and
//                    p.idtipo_prueba<>55 and
//                    h.estadototal<>5 and
//                    h.fechainicial >= DATE_FORMAT(NOW(),'%Y-%m-%d') 
//                    order by p.idprueba
//                    )
//                    UNION 
//                    (
//                    select 
//                    distinct v.numero_placa PLACA,
//                    date_format((select p2.fechainicial from pruebas p2 where p2.idhojapruebas=h.idhojapruebas and p2.fechainicial<>h.fechainicial order by p2.fechainicial desc limit 1), '%Y-%m-%d') FECHA,
//                    date_format((select p2.fechainicial from pruebas p2 where p2.idhojapruebas=h.idhojapruebas and p2.fechainicial<>h.fechainicial  order by p2.fechainicial desc limit 1),'%H:%i:%s') HORA_INICIAL_Y_REGISTRO,
//                    ifnull(date_format((select p2.fechafinal from pruebas p2 where p2.idhojapruebas=h.idhojapruebas and p2.fechainicial<>h.fechainicial  order by p2.fechafinal desc limit 1),'%H:%i:%s'),'---') HORA_FINAL,
//                    if(h.estadototal=4,date_format(h.fechafinal,'%H:%i:%s'),'No certificado') HORA_IMPRESION,
//                    if(v.tipo_vehiculo=1,'Liviano',if(v.tipo_vehiculo=3,'Moto','Pesado')) TIPO_VEHICULO,
//                    'Segunda vez' INSPECCION,
//                    IFNULL( TIMESTAMPDIFF(MINUTE, 
//                    (select p2.fechainicial from pruebas p2 where p2.idhojapruebas=h.idhojapruebas and p2.fechainicial<>h.fechainicial order by p2.fechainicial desc limit 1),
//                    (select p2.fechafinal from pruebas p2 where p2.idhojapruebas=h.idhojapruebas and p2.fechainicial<>h.fechainicial order by p2.fechafinal desc limit 1)),'---') TIEMPO_INSPECCION,
//                    if(h.estadototal=4,TIMESTAMPDIFF(MINUTE,(select p2.fechainicial from pruebas p2 where p2.idhojapruebas=h.idhojapruebas and p2.fechainicial<>h.fechainicial  order by p2.fechainicial desc limit 1),h.fechafinal),'No aplica') TIEMPO_TOTAL
//                    from 
//                    pruebas p, hojatrabajo h, vehiculos v 
//                    where
//                    p.idhojapruebas=h.idhojapruebas and
//                    h.reinspeccion=1 and
//                    h.idvehiculo=v.idvehiculo and
//                    p.idtipo_prueba<>55 and
//                    h.estadototal<>5 and
//                    $where
//                    order by p.idprueba
//                    );");
//        if ($query->num_rows() > 0) {
//            $query = $query->result();
//            return $query;
//        }
//    }

    function getCronAudit() {
        $query = $this->db->query("SELECT * FROM cron_audit c  ORDER BY 1 DESC LIMIT 1");
        if ($query->num_rows() > 0) {
            $query = $query->result();
            return $query;
        }
    }

    function getVisual($where, $fechainicial, $fechafinal, $presionLlantas) {
        if ($presionLlantas == 1) {
            $presion = "r.valor, r.observacion, '' AS 'descripcion','' AS 'tipo',
            IFNULL((SELECT pr.valor FROM pre_prerevision p, pre_dato pr, pre_atributo pe WHERE p.numero_placa_ref = v.numero_placa AND p.idpre_prerevision = pr.idpre_prerevision AND pr.idpre_atributo = pe.idpre_atributo AND pe.id = 'llanta-1-D-a' LIMIT 1),'---') AS 'Llantan 1 derecha',
            IFNULL((SELECT pr.valor FROM pre_prerevision p, pre_dato pr, pre_atributo pe WHERE p.numero_placa_ref = v.numero_placa AND p.idpre_prerevision = pr.idpre_prerevision AND pr.idpre_atributo = pe.idpre_atributo AND pe.id = 'llanta-1-I-a' LIMIT 1),'---') AS 'Llantan 1 izquierda',
            IFNULL((SELECT pr.valor FROM pre_prerevision p, pre_dato pr, pre_atributo pe WHERE p.numero_placa_ref = v.numero_placa AND p.idpre_prerevision = pr.idpre_prerevision AND pr.idpre_atributo = pe.idpre_atributo AND pe.id = 'llanta-2-D-a' LIMIT 1),'---') AS 'Llantan 2 derecha',
            IFNULL((SELECT pr.valor FROM pre_prerevision p, pre_dato pr, pre_atributo pe WHERE p.numero_placa_ref = v.numero_placa AND p.idpre_prerevision = pr.idpre_prerevision AND pr.idpre_atributo = pe.idpre_atributo AND pe.id = 'llanta-2-I-a' LIMIT 1),'---') AS 'Llantan 2 izquierda'";
        } else {
            $presion = "r.valor, r.observacion, '' AS 'descripcion','' AS 'tipo'";
        }
        $consulta = <<<EOF
                SELECT DISTINCT 
                DATE_FORMAT(p.fechafinal, '%Y/%m/%d %h:%i:%s') AS 'Fecha', 
                v.numero_placa as Placa, 
                IFNULL((SELECT t.nombre FROM tipo_vehiculo t WHERE v.tipo_vehiculo = t.idtipo_vehiculo LIMIT 1), '---') AS 'Tipo vehiculo',
                IFNULL((SELECT s.nombre FROM servicio s WHERE v.idservicio = s.idservicio LIMIT 1),'---') AS 'Servicio',
                CASE
                   WHEN p.estado= 0 THEN 'Asignado'
                   WHEN p.estado= 1 THEN 'Rechazado'
                   WHEN p.estado= 3 THEN 'Reasignado'
                   WHEN p.estado= 2 THEN 'Aprobado'
                ELSE 'Abortada'
                END AS 'Estado Prueba',
                CASE
                   WHEN h.reinspeccion = 0 THEN 'Tec 1ra'
                   WHEN h.reinspeccion = 1 THEN 'Tec Rei'
                   WHEN h.reinspeccion = 4444 THEN 'Pre 1ra'
                   WHEN h.reinspeccion = 44441 THEN 'Pre Rei'
                   WHEN h.reinspeccion = 8888 THEN 'Lib'
                ELSE 'Error'
                END AS 'Tipo inspeccion',
                IFNULL((SELECT CONCAT(u.nombres, ' ', u.apellidos) FROM usuarios u WHERE p.idusuario = u.IdUsuario  LIMIT 1),'') AS 'Usuario prueba',
                IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idcliente=cl.idcliente LIMIT 1 ),'---') AS Cliente, 
                IFNULL((SELECT cl.telefono1 FROM clientes cl WHERE v.idcliente=cl.idcliente LIMIT 1 ),'---') AS 'Telefono cliente', 
                IFNULL((SELECT c.nombre FROM clase c WHERE v.idclase = c.idclase LIMIT 1),'---') Clase,
                v.ano_modelo Modelo, 
                IF(v.registroRunt=1,
                                        (SELECT m.nombre FROM  linearunt l,marcarunt m WHERE l.idmarcarunt=m.idmarcarunt AND l.idlinearunt=v.idlinea),
                                        (SELECT m.nombre FROM linea l,marca m WHERE l.idmarca=m.idmarca AND l.idlinea=v.idlinea)) 'Marca',
                IF(v.registroRunt=1,
                                        (SELECT l.nombre FROM  linearunt l WHERE l.idlinearunt=v.idlinea),
                                        (SELECT l.nombre FROM linea l WHERE l.idlinea=v.idlinea)) 'linea',
                IFNULL((SELECT re.valor FROM resultados re WHERE p.idprueba=re.idprueba  AND  re.tiporesultado='defecto' AND re.idconfig_prueba=153 AND re.idresultados = r.idresultados LIMIT 1),'') AS 'valordefecto',
                r.tiporesultado,
                                $presion
                FROM vehiculos v , hojatrabajo h, pruebas p, resultados r
                WHERE 
                 v.idvehiculo = h.idvehiculo AND h.idhojapruebas = p.idhojapruebas AND p.idtipo_prueba = 8 AND p.idprueba = r.idprueba AND 
                 (p.estado<>0 and p.estado <> 9 and p.estado <> 5) AND $where AND
                 DATE_FORMAT(p.fechainicial,'%Y-%m-%d') BETWEEN '$fechainicial'  AND '$fechafinal'  
	
EOF;
        $rta = $this->db->query($consulta);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
            return $rta;
        } else {
            return [];
        }
    }

    function getPlacasDefectos() {
        $consulta = <<<EOF
                SELECT DISTINCT 
                DATE_FORMAT(p.fechafinal, '%Y/%m/%d %h:%i:%s') AS 'Fecha', 
                v.numero_placa as Placa,
                r.idprueba
                
                FROM vehiculos v , hojatrabajo h, pruebas p, resultados r
                WHERE 
                 v.idvehiculo = h.idvehiculo AND h.idhojapruebas = p.idhojapruebas AND p.idtipo_prueba = 8 AND p.idprueba = r.idprueba AND 
                 (p.estado<>0 and p.estado <> 9 and p.estado <> 5) AND (h.reinspeccion = 0 OR h.reinspeccion = 1) AND
                 DATE_FORMAT(p.fechainicial,'%Y-%m-%d') BETWEEN '2022-09-20'  AND '2023-04-10' AND 
                 (r.idconfig_prueba = 153 AND r.tiporesultado  <> 'COMENTARIOSADICIONALES') ORDER BY p.fechafinal ASC 
EOF;
        $rta = $this->db->query($consulta);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
            return $rta;
        } else {
            return [];
        }
    }

    function getcontadordefectos($idprueba) {
        $consulta = <<<EOF
                SELECT DISTINCT 
                DATE_FORMAT(p.fechafinal, '%Y/%m/%d %h:%i:%s') AS 'Fecha', 
                v.numero_placa as Placa, 
                IFNULL((SELECT t.nombre FROM tipo_vehiculo t WHERE v.tipo_vehiculo = t.idtipo_vehiculo LIMIT 1), '---') AS 'Tipo vehiculo',
                IFNULL((SELECT s.nombre FROM servicio s WHERE v.idservicio = s.idservicio LIMIT 1),'---') AS 'Servicio',
                v.ensenanza,
                CASE
                   WHEN p.estado= 0 THEN 'Asignado'
                   WHEN p.estado= 1 THEN 'Rechazado'
                   WHEN p.estado= 3 THEN 'Reasignado'
                   WHEN p.estado= 2 THEN 'Aprobado'
                ELSE 'Abortada'
                END AS 'Estado Prueba',
                CASE
                   WHEN h.reinspeccion = 0 THEN 'Tec 1ra'
                   WHEN h.reinspeccion = 1 THEN 'Tec Rei'
                   WHEN h.reinspeccion = 4444 THEN 'Pre 1ra'
                   WHEN h.reinspeccion = 44441 THEN 'Pre Rei'
                   WHEN h.reinspeccion = 8888 THEN 'Lib'
                ELSE 'Error'
                END AS 'Tipo inspeccion',
                IFNULL((SELECT CONCAT(u.nombres, ' ', u.apellidos) FROM usuarios u WHERE p.idusuario = u.IdUsuario  LIMIT 1),'') AS 'Usuario prueba',
                IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idcliente=cl.idcliente LIMIT 1 ),'---') AS Cliente, 
                IFNULL((SELECT cl.telefono1 FROM clientes cl WHERE v.idcliente=cl.idcliente LIMIT 1 ),'---') AS 'Telefono cliente', 
                IFNULL((SELECT c.nombre FROM clase c WHERE v.idclase = c.idclase LIMIT 1),'---') Clase,
                v.ano_modelo Modelo, 
                IF(v.registroRunt=1,
                                        (SELECT m.nombre FROM  linearunt l,marcarunt m WHERE l.idmarcarunt=m.idmarcarunt AND l.idlinearunt=v.idlinea),
                                        (SELECT m.nombre FROM linea l,marca m WHERE l.idmarca=m.idmarca AND l.idlinea=v.idlinea)) 'Marca',
                IF(v.registroRunt=1,
                                        (SELECT l.nombre FROM  linearunt l WHERE l.idlinearunt=v.idlinea),
                                        (SELECT l.nombre FROM linea l WHERE l.idlinea=v.idlinea)) 'linea',
                IFNULL((SELECT re.valor FROM resultados re WHERE p.idprueba=re.idprueba  AND  re.tiporesultado='defecto' AND re.idconfig_prueba=153 AND re.idresultados = r.idresultados LIMIT 1),'') AS 'valordefecto',
                r.tiporesultado
                FROM vehiculos v , hojatrabajo h, pruebas p, resultados r
                WHERE 
                 v.idvehiculo = h.idvehiculo AND h.idhojapruebas = p.idhojapruebas AND p.idtipo_prueba = 8 AND p.idprueba = r.idprueba AND 
                 (p.estado<>0 and p.estado <> 9 and p.estado <> 5) AND (h.reinspeccion = 0 OR h.reinspeccion = 1) AND
                 (r.idconfig_prueba = 153 AND r.tiporesultado  <> 'COMENTARIOSADICIONALES') and r.idprueba = $idprueba
	
EOF;
        $rta = $this->db->query($consulta);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
            return $rta;
        } else {
            return [];
        }
    }

    function informe_th($where, $idconf_maquina, $fechainicial, $fechafinal) {
        $query = $this->db->query("SELECT DISTINCT
            DATE_FORMAT(p.fechafinal, '%Y/%m/%d %h:%i:%s') AS 'Fecha', v.numero_placa as Placa, 
                                IFNULL((SELECT CONCAT(u.nombres, ' ', u.apellidos) FROM usuarios u WHERE p.idusuario = u.IdUsuario  LIMIT 1),'') AS 'Usuario prueba',
                                IFNULL((SELECT CONCAT(cl.nombre1,' ',cl.nombre2,' ',cl.apellido1,' ',cl.apellido2) FROM clientes cl WHERE v.idcliente=cl.idcliente LIMIT 1 ),'---') AS Cliente, 
                                IFNULL((SELECT cl.telefono1 FROM clientes cl WHERE v.idcliente=cl.idcliente LIMIT 1 ),'---') AS 'Telefono cliente', 
                                IFNULL((SELECT CONCAT(UPPER(ma.nombre),' - ',UPPER(ma.marca),' - ',UPPER(ma.serie)) FROM maquina ma WHERE p.idmaquina = ma.idmaquina LIMIT 1 ),'---') AS 'Maquina', 
                                c.nombre Clase, v.ano_modelo Modelo, 
                                if(v.registrorunt=1,(select nombre from marcarunt where idmarcaRUNT=(select idmarcaRunt from linearunt where idlineaRUNT=v.idlinea limit 1) limit 1),m.nombre) as marca, 
                                if(v.registrorunt=1,(select nombre from linearunt where idlineaRUNT=v.idlinea limit 1),l.nombre) AS linea, 
                                IFNULL((select valor from resultados where idprueba=p.idprueba and tiporesultado='temperatura_ambiente' order by 1 desc limit 1),'---') AS 'Temperatura ambiente',
                                IFNULL((select valor from resultados where idprueba=p.idprueba and tiporesultado='humedad'  order by 1 desc limit 1),'---') AS 'Humedad relativa'
                                FROM hojatrabajo h,pruebas p,vehiculos v,maquina ma, marca m , linea l , clase c 
                                WHERE v.idvehiculo=h.idvehiculo AND h.idhojapruebas=p.idhojapruebas 
                                AND v.idlinea = l.idlinea AND l.idmarca = m.idmarca AND v.idclase = c.idclase 
                                AND p.idmaquina=ma.idmaquina  AND ma.idmaquina=$idconf_maquina AND p.idtipo_prueba=3
                                AND $where AND p.estado<>0 AND DATE_FORMAT(p.fechafinal,'%Y-%m-%d') 
                                between DATE_FORMAT('$fechainicial','%Y-%m-%d') AND DATE_FORMAT('$fechafinal','%Y-%m-%d')");
        return $query;
    }

}
