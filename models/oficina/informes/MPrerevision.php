<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MPrerevision extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function consultar($numero_placa, $rango) {
        $fechas = explode("-", $rango);
//        $fechas = str_replace(" - ", "' and '", $rango);
        $fechas = "'" . trim($fechas[0]) . "-" . trim($fechas[1]) . "-" . trim($fechas[2]) . "' and '" . trim($fechas[3]) . "-" . trim($fechas[4]) . "-" . trim($fechas[5]) . "'";
        if ($numero_placa != "") {
            $numero_placa = 'pp.numero_placa_ref like \'%' . $numero_placa . '%\' and';
        }
        $query = 'SELECT 
            IFNULL((SELECT c.correo FROM clientes c WHERE v.idcliente = c.idcliente LIMIT 1),"No registrado") AS "email",
                            CASE
                            WHEN v.idservicio = \'1\' THEN 
                            concat(\'
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 22px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 7px"><strong>\',v.numero_placa,\'</strong></label>\')
                            WHEN v.idservicio = \'2\' THEN
                            concat(\'
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: white;
                            color:black;
                            font-size: 22px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 7px"><strong>\',v.numero_placa,\'</strong></label>\')
                            WHEN v.idservicio = \'3\' THEN 
                            concat(\'
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 22px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 7px"><strong>\',v.numero_placa,\'</strong></label>\')
                            WHEN v.idservicio = \'4\' THEN 
                            concat(\'
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 22px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 7px"><strong>\',v.numero_placa,\'</strong></label>\')
                            WHEN v.idservicio = \'7\' THEN 
                            concat(\'
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 22px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 7px"><strong>\',v.numero_placa,\'</strong></label>\')
                            ELSE 
                            concat(\'
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 22px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 7px"><strong>\',v.numero_placa,\'</strong></label>\')
                            END placa,
                            pp.fecha_prerevision,
                            if(pp.reinspeccion=0,\'<strong>PRIMERA VEZ<strong>\',\'<strong>SEGUNDA VEZ<strong>\') ocacion,
                            pp.idpre_prerevision,
                            pp.tipo_inspeccion
                            FROM 
                            pre_prerevision pp,vehiculos v 
                            where
                            pp.numero_placa_ref=v.numero_placa and pp.consecutivo<>"OFC" and
                            (' . $numero_placa . ' DATE_FORMAT(pp.fecha_prerevision,\'%Y-%m-%d\') between ' . $fechas . ') order by pp.fecha_prerevision desc;';
//        echo $query;
        return $this->db->query($query);
    }

    function get($idpre_prerevision) {
        $this->db->where('idpre_prerevision', $idpre_prerevision);
        return $this->db->get("pre_prerevision");
    }

    function getInfoVehiculo($id_prerevision) {
        $query = <<< EOF
                select 
                IFNULL((SELECT c.correo FROM clientes c WHERE v.idcliente = c.idcliente LIMIT 1),'No registrado') AS 'email',
        DATE_FORMAT(pp.fecha_prerevision, '%Y/%m/%d') fecha_prerevision,
        DATE_FORMAT(pp.fecha_prerevision, '%H:%i') hora_prerevision,
        if(pp.tipo_inspeccion=1,'RTMyEC',if(pp.tipo_inspeccion=2,'Preventiva','Prueba libre')) tipo_servicio,
        if(v.tipo_vehiculo=1,'Liviano',if(v.tipo_vehiculo=2,'Pesado','Motocicleta')) tipo_vehiculo,
        if((v.tiempos=4 AND v.tipo_vehiculo = 3),'4T',if((v.tiempos=4 AND v.tipo_vehiculo = 1),'OTTO',if(v.tiempos=2,'2T','Diesel'))) tipo_motor,
        v.numero_placa placa,
        v.ano_modelo modelo,
        IFNULL((SELECT 
			if(pd.valor='0','NO FUNCIONAL',pd.valor)
			FROM 
			pre_dato pd,pre_atributo pa 
			WHERE 
			pd.idpre_atributo =pa.idpre_atributo AND 
			pd.idpre_prerevision=$id_prerevision AND 
			pa.id='histo_kilometraje' ORDER BY pd.idpre_dato DESC LIMIT 1),if(v.kilometraje='0','NO FUNCIONAL',v.kilometraje)) kilometraje,
        CASE 
        WHEN v.migrateLineaMarca <> 1 THEN
            IF(v.registrorunt = '0',
                IFNULL((SELECT upper(m.nombre) FROM marca m 
                       WHERE m.idmarca = (SELECT l.idmarca FROM linea l WHERE l.idlinea = v.idlinea LIMIT 1) 
                       LIMIT 1), 'SIN MARCA'),
                IFNULL((SELECT upper(mr.nombre) FROM marcarunt mr 
                       WHERE mr.idmarcarunt = (SELECT lr.idmarcarunt FROM linearunt lr WHERE lr.idlinearunt = v.idlinea LIMIT 1) 
                       LIMIT 1), 'SIN MARCA')
            )
        ELSE 
            IFNULL((SELECT upper(nm.nombre) FROM newmarcas nm 
                   WHERE nm.idmarcas = (SELECT nl.idmarcas FROM newlineas nl WHERE nl.idlineas = v.idlinea LIMIT 1) 
                   LIMIT 1), 'SIN MARCA')
    END AS marca,
      CASE 
                                WHEN v.migrateLineaMarca <> 1 THEN
                                    IF(v.registrorunt = '0',
                                        IFNULL((SELECT upper(l.nombre) FROM linea l WHERE l.idlinea = v.idlinea LIMIT 1), 'SIN LINEA'),
                                        IFNULL((SELECT upper(lr.nombre) FROM linearunt lr WHERE lr.idlinearunt = v.idlinea LIMIT 1), 'SIN LINEA')
                                    )
                                ELSE 
                                    IFNULL((SELECT upper(nl.nombre) FROM newlineas nl WHERE nl.idlineas = v.idlinea LIMIT 1), 'SIN LINEA')
                            END AS 'linea',

        if((select registrorunt from vehiculos where numero_placa=v.numero_placa limit 1)=1,
           (SELECT 
   		 (select c.nombre from color c where c.idcolor=pd.valor limit 1)
			FROM 
			pre_dato pd,pre_atributo pa 
			WHERE 
			pd.idpre_atributo =pa.idpre_atributo AND 
			pd.idpre_prerevision=$id_prerevision AND 
			pa.id='histo_color' ORDER BY pd.idpre_dato DESC LIMIT 1),
           (select c.nombre from color c where c.idcolor=v.idcolor limit 1)) color,
        IFNULL((SELECT 
			DATE_FORMAT(pd.valor, '%Y/%m/%d')
			FROM 
			pre_dato pd,pre_atributo pa 
			WHERE 
			pd.idpre_atributo =pa.idpre_atributo AND 
			pd.idpre_prerevision=$id_prerevision AND 
			pa.id='fecha_vencimiento_soat' ORDER BY pd.idpre_dato DESC LIMIT 1),v.fecha_vencimiento_soat) fecha_vencimiento_soat,
        v.fecha_matricula,
        if(v.blindaje=1,'SI','NO') blindaje,
        if(v.ensenanza=1,'SI','NO') ensenanza,
        if(v.polarizado=1,'SI','NO') polarizado,
        if((v.scooter=1 and v.tipo_vehiculo = 3),'SI','NO') scooter,
        ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='numero_certificado_g' or pa.id='numero_certificado_gas') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'---') numero_certificado_gas,
        ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='empresa_certificadora') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'---') empresa_certificadora,
        ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='empresa_publico') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'---') empresa_publico,
        ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='urbano') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'---') urbano,
        ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='especial') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'---') especial,
        ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='tranportes') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'---') transportes,
        ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='permisoBlindaje') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'---') permisoBlindaje,
        ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='pruebaGases') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'---') pruebaGases,
        ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='repotenciado') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'---') repotenciado,
        ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='certificador') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'---') certificador,
        ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='empleadopublico') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'---') empleadopublico,
        ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='recursospublicos') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'---') recursospublicos,
        ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='poderpublico') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'---') poderpublico,
        ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='reconocimientopublico') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'---') reconocimientopublico,
        ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='calidadpublica') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'---') calidadpublica,
        ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='codigociiu') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'---') codigociiu,
        ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='ocupacion') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'---') ocupacion,
        ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='actividadeconomica') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'---') actividadeconomica,
        ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='restriccionauditiva') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'NO') restriccionauditiva,
        IFNULL((SELECT c.nombre FROM vehiculos v, carroceria c  WHERE v.numero_placa=pp.numero_placa_ref AND v.diseno = c.idcarroceria LIMIT 1),'') AS carroceria,
        ifnull((SELECT  DATE_FORMAT(pd.valor,'%Y-%m-%d') FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and pa.id='fecha_final_certgas' and pd.idpre_prerevision=pp.idpre_prerevision limit 1),(SELECT DATE_FORMAT(h.fecha_final_certgas,'%Y-%m-%d')  FROM histo_vehiculo h WHERE h.idpre_prerevision = $id_prerevision)) fecha_final_certgas,
        if(pp.reinspeccion=0,'Primera vez','Segunda vez') ocacion,
        pp.consecutivo,
        se.nombre servicio,
        c.nombre clase,
        tc.nombre combustible,
        v.numsillas numero_sillas,
        v.num_pasajeros numero_pasajeros,
        v.cilindraje,
        v.cilindros,
        if(v.potencia_motor=0,'0',v.potencia_motor) potencia_motor
        from 
        vehiculos v,pre_prerevision pp,servicio se,clase c, tipo_combustible tc
        where   
        pp.idpre_prerevision=$id_prerevision and
        v.numero_placa=pp.numero_placa_ref and
        v.idservicio=se.idservicio and
        v.idclase=c.idclase and
        v.idtipocombustible=tc.idtipocombustible
EOF;
        $result = $this->db->query($query);
        $rta = $result->result();
        return $rta[0];
    }

//if(v.potencia_motor='0','No aplica',v.potencia_motor) potencia_motor
    function getPre_dato($id_prerevision, $id) {
        $query = <<< EOF
            select ifnull(
            (select 
            valor
            from
            pre_prerevision pp,pre_dato pd,pre_atributo pa
            where
            pp.idpre_prerevision=$id_prerevision and
            pp.idpre_prerevision=pd.idpre_prerevision and
            pa.idpre_atributo=pd.idpre_atributo and
            pa.id='$id' limit 1),'---') valor
EOF;
        $result = $this->db->query($query);
        $rta = $result->result();
        return $rta[0];
    }

    function getAceptaSINO($id_prerevision, $id) {
        $query = <<< EOF
            select
            if(pd.valor='on','<td width="5%" style="text-align:center"><strong>SI</strong></td>
                        <td width="5%" border="1" style="text-align:center">X</td>
                        <td width="5%" style="text-align:center"><strong>NO</strong></td>
                        <td width="5%" border="1"  style="text-align:center"></td>',
			'<td width="5%" style="text-align:center"><strong>SI</strong></td>
                        <td width="5%" border="1" style="text-align:center"></td>
                        <td width="5%" style="text-align:center"><strong>NO</strong></td>
                        <td width="5%" border="1"  style="text-align:center">X</td>') sino
            from
            pre_prerevision pp,pre_dato pd,pre_atributo pa
            where
            pp.idpre_prerevision=$id_prerevision and
            pp.idpre_prerevision=pd.idpre_prerevision and
            pd.idpre_atributo=pa.idpre_atributo and
            pa.id like '%$id%' 
            order by 1 LIMIT 1
EOF;
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            $rta = $result->result();
            return $rta[0]->sino;
        } else {
            return '';
        }
    }

    function getPre_datoApr($id_prerevision, $id) {
        $query = <<< EOF
            select
            pa.label,pd.valor,pa.id
            from
            pre_prerevision pp,pre_dato pd,pre_atributo pa
            where
            pp.idpre_prerevision=$id_prerevision and
            pp.idpre_prerevision=pd.idpre_prerevision and
            pd.idpre_atributo=pa.idpre_atributo and
            pa.id like '%$id%' 
            order by pa.orden
EOF;
        $result = $this->db->query($query);
        return $result;
    }

    function getCliente($placa) {
        $query = <<< EOF
            select 
            concat(ifnull(c.nombre1,''),' ',ifnull(c.nombre2,''),' ',ifnull(c.apellido1,''),' ',ifnull(c.apellido2,'')) nombre,
            ifnull(c.direccion,'---') direccion,
            ifnull(c.telefono1,'---') telefono,
            ifnull(c.correo,'---') correo,
            ifnull(c.numero_identificacion,'---') numero_identificacion,
            ifnull(c.numero_licencia,'---') numero_licencia,
            ifnull(c.categoria_licencia,'---') categoria_licencia,
            concat(ifnull(p.nombre1,''),' ',ifnull(p.nombre2,''),' ',ifnull(p.apellido1,''),' ',ifnull(p.apellido2,'')) nombre_p,
            ifnull(p.direccion,'---') direccion_p,
            ifnull(p.telefono1,'---') telefono_p,
            ifnull(p.correo,'---') correo_p,
            ifnull(p.numero_identificacion,'---') numero_identificacion_p
            from
            vehiculos v,
            clientes c,
            clientes p
            where
            v.idcliente=c.idcliente and
            v.idpropietarios=p.idcliente and
            v.numero_placa='$placa' limit 1
EOF;
        $result = $this->db->query($query);
        $rta = $result->result();
        return $rta[0];
    }

    function getOperarios($idpp) {
        $query = <<< EOF
            SELECT 
                DISTINCT CONCAT(u.nombres,' ',u.apellidos) nombre,
                ifnull((SELECT pd.valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo and (pa.id='usuario_registro' or pa.id='usuario') and pd.idpre_prerevision=pp.idpre_prerevision limit 1),'---') user,
                u.identificacion as documento
                FROM 
                pre_prerevision pp,vehiculos v,hojatrabajo ht,pruebas p,usuarios u
                WHERE 
                pp.numero_placa_ref=v.numero_placa AND 
                pp.idpre_prerevision=$idpp AND 
                v.idvehiculo=ht.idvehiculo AND
                ht.idhojapruebas=p.idhojapruebas AND
                p.estado<>5 AND
                p.idtipo_prueba<>55 AND
                u.IdUsuario=p.idusuario AND
                DATE_FORMAT(ht.fechainicial,'%Y-%m-%d') = DATE_FORMAT(pp.fecha_prerevision,'%Y-%m-%d')
EOF;
        return $this->db->query($query);
    }

    function getDocumentos($idpp) {
        $query = <<< EOF
           SELECT 
            c.numero_certificado,if(c.consecutivo_runt='',c.consecutivo_runt_rechazado,c.consecutivo_runt) consecutivo_runt,ht.pin0,pp.reinspeccion,
            IFNULL((
            SELECT valor FROM pre_dato pd,pre_atributo pa WHERE pd.idpre_atributo=pa.idpre_atributo AND pa.id='numero_solicitud' AND pd.idpre_prerevision=pp.idpre_prerevision limit 1),'') numero_solicitud
            FROM 
            pre_prerevision pp,certificados c,vehiculos v,hojatrabajo ht 
            WHERE
            pp.numero_placa_ref=v.numero_placa AND
            pp.idpre_prerevision=$idpp AND 
            v.idvehiculo=ht.idvehiculo AND
            c.idhojapruebas=ht.idhojapruebas AND
            v.idvehiculo=ht.idvehiculo AND
            DATE_FORMAT(ht.fechainicial,'%Y-%m-%d') = DATE_FORMAT(pp.fecha_prerevision,'%Y-%m-%d')
            ORDER BY 
            CASE WHEN pp.reinspeccion=1 THEN c.id_certificado END DESC, 
            CASE WHEN pp.reinspeccion=0 THEN c.id_certificado END ASC
            LIMIT 1
EOF;
        $resultados = $this->db->query($query);
        $rta = $resultados->result();
        if ($resultados->num_rows() !== 0) {
            return $rta[0];
        } else {
            return "";
        }
    }
    
    function getUser($usuario_registro){
        $query = <<< EOF
           SELECT 
                concat(u.nombres, ' ', u.apellidos) as 'nombre',
            u.*
                from usuarios u where u.idUsuario = $usuario_registro
EOF;
        $resultados = $this->db->query($query);
        $rta = $resultados->result();
        if ($resultados->num_rows() !== 0) {
            return $rta[0];
        } else {
            return "";
        }
    }

}


