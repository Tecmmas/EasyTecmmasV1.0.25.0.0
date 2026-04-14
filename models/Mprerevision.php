<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mprerevision extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getConsecutivo($tipo, $consePre)
    {
        if ($consePre == "1") {
            $result = $this->db->query("select count(*) + 1 cons from pre_prerevision where tipo_inspeccion=$tipo and consecutivo<>'OFC'");
        } else {
            $result = $this->db->query("select count(*) + 1 cons from pre_prerevision where tipo_inspeccion=$tipo");
        }
        $rta = $result->result();
        return $rta[0]->cons;
    }

    //    public function getConsecutivo($tipo, $consePre)
    // {
    //     $whereCondition = $consePre == "1" ? "AND consecutivo <> 'OFC'" : "";

    //     $result = $this->db->query("
    //         SELECT COALESCE(MAX(CAST(consecutivo AS UNSIGNED)), 0) + 1 as cons 
    //         FROM pre_prerevision 
    //         WHERE tipo_inspeccion = ? 
    //         AND consecutivo REGEXP '^[0-9]+$'
    //         $whereCondition
    //     ", [$tipo]);

    //     $rta = $result->result();
    //     return $rta[0]->cons;
    // }

    public function guardarPrerevision($pre_prerevision)
    {
        $this->updatePre($pre_prerevision);
        $pre_prerevision['actualizado'] = '1';
        $this->db->insert("pre_prerevision", $pre_prerevision);
        return $this->db->insert_id();
    }

    public function guardarHistoVehiculo($histoVehiculo)
    {
        return $this->db->insert("histo_vehiculo", $histoVehiculo);
    }

    public function updatePre($pre_prerevision)
    {
        $numero_placa_ref = $pre_prerevision['numero_placa_ref'];
        $tipo_inspeccion = $pre_prerevision['tipo_inspeccion'];
        $reinspeccion = $pre_prerevision['reinspeccion'];
        //        $fecha_prerevision = $pre_prerevision['fecha_prerevision'];
        $this->db->query("
                        UPDATE
                        pre_prerevision p
                        SET
                        p.numero_placa_ref=CONCAT('$numero_placa_ref','-C'),
                        p.fecha_prerevision=p.fecha_prerevision
                        WHERE
                        p.numero_placa_ref='$numero_placa_ref' AND
                        DATE_FORMAT(p.fecha_prerevision, '%Y-%m-%d')  = CURDATE() AND
                        p.tipo_inspeccion = $tipo_inspeccion AND p.reinspeccion = $reinspeccion");
    }

    public function guardarPreDato($preDato, $preAtributo, $preZona)
    {
        $this->db->trans_start();
        $rtaAtributo = $this->buscarPreAtributo($preAtributo['id']);
        if ($rtaAtributo->num_rows() !== 0) {
            $this->actualizarPreAtributo($preAtributo);
            $rta = $rtaAtributo->result();
            $preDato['idpre_atributo'] = $rta[0]->idpre_atributo;
        } else {
            $preDato['idpre_atributo'] = $this->crearPreAtributo($preAtributo);
        }
        $rtaZona = $this->buscarPreZona($preZona['nombre']);
        if ($rtaZona->num_rows() !== 0) {
            $rta = $rtaZona->result();
            $preDato['idpre_zona'] = $rta[0]->idpre_zona;
        } else {
            $preDato['idpre_zona'] = $this->crearPreZona($preZona);
        }
        $this->db->insert("pre_dato", $preDato);
        $this->db->trans_complete();
    }

    public function buscarPreAtributo($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('pre_atributo');
        return $query;
    }

    public function crearPreAtributo($preAtributo)
    {
        echo $this->db->insert("pre_atributo", $preAtributo);
        return $this->db->insert_id();
    }

    public function actualizarPreAtributo($preAtributo)
    {
        $this->db->where('id', $preAtributo['id']);
        echo $this->db->update("pre_atributo", $preAtributo);
    }

    public function buscarPreZona($nombre)
    {
        $this->db->where('nombre', $nombre);
        $query = $this->db->get('pre_zona');
        return $query;
    }

    public function crearPreZona($preZona)
    {
        echo $this->db->insert("pre_zona", $preZona);
        return $this->db->insert_id();
    }

    public function guardarVehiculo($vehiculo)
    {
        $rtaVehiculo = $this->buscarVehiculo($vehiculo['numero_placa']);
        if ($rtaVehiculo->num_rows() !== 0) {
            $this->db->where('numero_placa', $vehiculo['numero_placa']);
            echo $this->db->update('vehiculos', $vehiculo);
        } else {
            $vehiculo["diametro_escape"] = "0";
            echo $this->db->insert("vehiculos", $vehiculo);
        }
    }

    public function buscarVehiculo($numero_placa)
    {
        $this->db->where('numero_placa', $numero_placa);
        $query = $this->db->get('vehiculos');
        return $query;
    }

    public function cargarVehiculo($numero_placa)
    {
        $result = $this->db->query("SELECT 
    v.numero_placa,
    v.aplicares2703,
    v.autoregulado,
    IFNULL(cli.numero_identificacion, '') numero_identificacion,
    IFNULL(cli.tipo_identificacion, '') tipo_identificacion,
    IFNULL(cli.nombre1, '') nombre1,
    IFNULL(cli.apellido1, '') apellido1,
    IFNULL(cli.telefono1, '') telefono1,
    IFNULL(cli.telefono2, '') telefono2,
    IFNULL(cli.direccion, '') direccion,
    IFNULL(cli.numero_licencia, '') numero_licencia,
    IFNULL(cli.categoria_licencia, '') categoria_licencia,
    IFNULL(cli.correo, '') correo,
    IFNULL(REPLACE(cli.cumpleanos, '-', ''), '') cumpleanos,
    IFNULL(ciu_cli.nombre, '') cod_ciudad,
    IFNULL(pro.numero_identificacion, '') numero_identificacion_p,
    IFNULL(pro.tipo_identificacion, '') tipo_identificacion_p,
    IFNULL(pro.nombre1, '') nombre1_p,
    IFNULL(pro.apellido1, '') apellido1_p,
    IFNULL(pro.telefono1, '') telefono1_p,
    IFNULL(pro.telefono2, '') telefono2_p,
    IFNULL(pro.direccion, '') direccion_p,
    IFNULL(pro.numero_licencia, '') numero_licencia_p,
    IFNULL(pro.categoria_licencia, '') categoria_licencia_p,
    IFNULL(pro.correo, '') correo_p,
    IFNULL(REPLACE(pro.cumpleanos, '-', ''), '') cumpleanos_p,
    IFNULL(ciu_pro.nombre, '') cod_ciudad_p,
    IFNULL(UPPER(s.nombre), '') idservicio,
    v.migrateLineaMarca,
    
    -- Optimizado: línea del vehículo
    CASE 
    WHEN v.migrateLineaMarca <> 1 THEN
        IF(v.registrorunt = '0', 
            COALESCE(linea_runt.nombre, linea_normal.nombre), 
            COALESCE(linea_runt.nombre, 'SIN LINEA')
        )
    ELSE 
        IFNULL((SELECT UPPER(nl.nombre) FROM newlineas nl WHERE nl.idlineas = v.idlinea LIMIT 1), 'SIN LINEA')
END AS idlinea,

CASE 
    WHEN v.migrateLineaMarca <> 1 THEN
        IF(v.registrorunt = '0',
            COALESCE(marca_normal.nombre, 'SIN MARCA'),
            COALESCE(marca_runt.nombre, 'SIN MARCA')
        )
    ELSE 
        IFNULL((SELECT UPPER(nm.nombre) FROM newmarcas nm 
                 WHERE nm.idmarcas = (SELECT nl.idmarcas FROM newlineas nl WHERE nl.idlineas = v.idlinea LIMIT 1) 
                 LIMIT 1), 'SIN MARCA')
END AS idmarca,
    
    IFNULL(c.nombre, '') idclase,
    COALESCE(color_runt.nombre, color_normal.nombre, '') idcolor,
    IFNULL(UPPER(tc.nombre), '') idtipocombustible,
    v.ano_modelo,
    v.numero_motor,
    v.numero_serie,
    v.numero_tarjeta_propiedad,
    v.cilindraje,
    v.cilindros,
    v.num_pasajeros,
    v.potencia_motor,
    v.tipo_vehiculo,
    v.taximetro,
    v.tiempos,
    v.ensenanza,
    IFNULL(p.nombre, '') idpais,
    IFNULL(REPLACE(v.fecha_matricula, '-', ''), '') fecha_matricula,
    v.blindaje,
    v.polarizado,
    v.numsillas,
    v.numero_vin,
    v.numero_vin numero_chasis,
    v.numero_llantas,
    v.numero_exostos,
    v.scooter,
    v.numejes,
    v.kilometraje,
    IFNULL(car.nombre, '') diseno,
    
    -- Configuración de llantas optimizada
    COALESCE(
        (SELECT p_da.valor
         FROM pre_prerevision p_pr
         JOIN pre_atributo p_at ON p_at.id = 'llanta_ejes'
         JOIN pre_dato p_da ON p_da.idpre_atributo = p_at.idpre_atributo 
                           AND p_da.idpre_prerevision = p_pr.idpre_prerevision
         WHERE p_pr.numero_placa_ref = v.numero_placa
         ORDER BY p_pr.idpre_prerevision DESC 
         LIMIT 1),
        CASE IFNULL(c.nombre, '')
            WHEN 'MOTOCICLETA' THEN '1-1'
            WHEN 'CUATRIMOTO' THEN '2-2'
            WHEN 'MOTOTRICICLO' THEN '1-2'
            WHEN 'MOTOCARRO' THEN '1-2'
            WHEN 'CUADRICICLO' THEN '2-2'
            WHEN 'TRICIMOTO' THEN '2-1'
            WHEN 'CICLOMOTOR' THEN '2-2'
            WHEN 'AUTOMOVIL' THEN '2-2'
            WHEN 'CAMIONETA' THEN '2-2'
            WHEN 'CAMPERO' THEN '2-2'
            WHEN 'MICROBUS' THEN '2-2'
            WHEN 'BUS' THEN '2-4'
            WHEN 'BUSETA' THEN '2-4'
            WHEN 'CAMION' THEN '2-4'
            WHEN 'TRACTOCAMION' THEN '2-4-4'
            WHEN 'VOLQUETA' THEN '2-4'
            ELSE '2-2'
        END
    ) conf_inf,
    
    -- Datos de certificado de gas optimizados
    COALESCE(cert_gas.numero_certificado, '') numero_certificado_gas,
    COALESCE(cert_gas.fecha_inicio, '') fecha_inicio_certgas,
    COALESCE(cert_gas.fecha_final, '') fecha_final_certgas

FROM vehiculos v

-- LEFT JOINs para todas las tablas relacionadas
LEFT JOIN servicio s ON v.idservicio = s.idservicio
LEFT JOIN clase c ON v.idclase = c.idclase
LEFT JOIN clientes cli ON v.idcliente = cli.idcliente
LEFT JOIN clientes pro ON v.idpropietarios = pro.idcliente
LEFT JOIN tipo_combustible tc ON v.idtipocombustible = tc.idtipocombustible
LEFT JOIN tipo_vehiculo tv ON v.tipo_vehiculo = tv.idtipo_vehiculo
LEFT JOIN paises p ON v.idpais = p.idpais
LEFT JOIN ciudades ciu_cli ON cli.cod_ciudad = ciu_cli.cod_ciudad
LEFT JOIN ciudades ciu_pro ON pro.cod_ciudad = ciu_pro.cod_ciudad
LEFT JOIN carroceria car ON v.diseno = car.idcarroceria

-- LEFT JOINs para datos opcionales de línea, marca y color
LEFT JOIN linea linea_normal ON v.registrorunt = '0' AND v.migrateLineaMarca <> 1 AND linea_normal.idlinea = v.idlinea
LEFT JOIN linearunt linea_runt ON v.registrorunt <> '0' AND v.migrateLineaMarca <> 1 AND linea_runt.idlinearunt = v.idlinea
LEFT JOIN marca marca_normal ON v.registrorunt = '0' AND v.migrateLineaMarca <> 1 
    AND marca_normal.idmarca = (SELECT l.idmarca FROM linea l WHERE l.idlinea = v.idlinea LIMIT 1)
LEFT JOIN marcarunt marca_runt ON v.registrorunt <> '0' AND v.migrateLineaMarca <> 1 
    AND marca_runt.idmarcarunt = (SELECT l.idmarcarunt FROM linearunt l WHERE l.idlinearunt = v.idlinea LIMIT 1)
LEFT JOIN color color_normal ON v.registrorunt = '0' AND color_normal.idcolor = v.idcolor
LEFT JOIN colorrunt color_runt ON v.registrorunt <> '0' AND color_runt.idcolorrunt = v.idcolor

-- Subconsulta para datos de certificado de gas
LEFT JOIN (
    SELECT 
        p_pr.numero_placa_ref,
        MAX(CASE WHEN p_at.id = 'numero_certificado_g' THEN p_da.valor END) as numero_certificado,
        MAX(CASE WHEN p_at.id = 'fecha_inicio_certgas' THEN p_da.valor END) as fecha_inicio,
        MAX(CASE WHEN p_at.id = 'fecha_final_certgas' THEN p_da.valor END) as fecha_final
    FROM pre_prerevision p_pr
    JOIN pre_atributo p_at ON p_at.id IN ('numero_certificado_g', 'fecha_inicio_certgas', 'fecha_final_certgas')
    JOIN pre_dato p_da ON p_da.idpre_atributo = p_at.idpre_atributo 
                      AND p_da.idpre_prerevision = p_pr.idpre_prerevision
    WHERE p_pr.numero_placa_ref = '$numero_placa'
    GROUP BY p_pr.numero_placa_ref
    ORDER BY p_pr.idpre_prerevision DESC
    LIMIT 1
) cert_gas ON cert_gas.numero_placa_ref = v.numero_placa

WHERE v.numero_placa = '$numero_placa'
LIMIT 1;");
        return $result;
    }

    public function validarCiudad($cod_ciudad)
    {
        $result = $this->db->query("SELECT cod_ciudad FROM ciudades WHERE nombre='$cod_ciudad' LIMIT 1;");
        if ($result->num_rows() !== 0) {
            $rta = $result->result();
            return $rta[0]->cod_ciudad;
        } else {
            return '';
        }
    }

    public function validarClase($nombreclase)
    {
        $result = $this->db->query("SELECT idclase FROM clase WHERE nombre='$nombreclase' LIMIT 1;");
        if ($result->num_rows() !== 0) {
            $rta = $result->result();
            return $rta[0]->idclase;
        } else {
            return '';
        }
    }   

    public function validarLinea($nombrelinea)
    {
        $result = $this->db->query("SELECT idlineas FROM newlineas WHERE nombre='$nombrelinea' LIMIT 1;");
        if ($result->num_rows() !== 0) {
            $rta = $result->result();
            return $rta[0]->idlineas;
        } else {
            return '';
        }
    }   
//     public function cargarVehiculo($numero_placa)
//     {
//         $result = $this->db->query("SELECT 
//     v.numero_placa,
//     v.aplicares2703,
//     v.autoregulado,
//     cli.numero_identificacion,
//     cli.tipo_identificacion,
//     cli.nombre1,
//     cli.apellido1,
//     cli.telefono1,
//     IFNULL(cli.telefono2, '') telefono2,
//     cli.direccion,
//     cli.numero_licencia,
//     cli.categoria_licencia,
//     cli.correo,
//     REPLACE(cli.cumpleanos, '-', '') cumpleanos,
//     ciu_cli.nombre cod_ciudad,
//     IFNULL(pro.numero_identificacion, '') numero_identificacion_p,
//     IFNULL(pro.tipo_identificacion, '') tipo_identificacion_p,
//     pro.nombre1 nombre1_p,
//     pro.apellido1 apellido1_p,
//     IFNULL(pro.telefono1, '') telefono1_p,
//     IFNULL(pro.telefono2, '') telefono2_p,
//     IFNULL(pro.direccion, '') direccion_p,
//     IFNULL(pro.numero_licencia, '') numero_licencia_p,
//     IFNULL(pro.categoria_licencia, '') categoria_licencia_p,
//     IFNULL(pro.correo, '') correo_p,
//     IFNULL(REPLACE(pro.cumpleanos, '-', ''), '') cumpleanos_p,
//     IFNULL(ciu_pro.nombre, '') cod_ciudad_p,
//     UPPER(s.nombre) idservicio,
//     v.migrateLineaMarca,
    
//     -- Optimizado: línea del vehículo
//     CASE 
//         WHEN v.migrateLineaMarca <> 1 THEN
//             IF(v.registrorunt = '0', 
//                 COALESCE(linea_runt.nombre, linea_normal.nombre), 
//                 COALESCE(linea_runt.nombre, 'SIN LINEA')
//             )
//         ELSE 
//             COALESCE((SELECT UPPER(nl.nombre) FROM newlineas nl WHERE nl.idlineas = v.idlinea LIMIT 1), 'SIN LINEA')
//     END AS idlinea,

//     -- Optimizado: marca del vehículo
//     CASE 
//         WHEN v.migrateLineaMarca <> 1 THEN
//             IF(v.registrorunt = '0',
//                 COALESCE(marca_normal.nombre, 'SIN MARCA'),
//                 COALESCE(marca_runt.nombre, 'SIN MARCA')
//             )
//         ELSE 
//             COALESCE((SELECT UPPER(nm.nombre) FROM newmarcas nm 
//                      WHERE nm.idmarcas = (SELECT nl.idmarcas FROM newlineas nl WHERE nl.idlineas = v.idlinea LIMIT 1) 
//                      LIMIT 1), 'SIN MARCA')
//     END AS idmarca,
    
//     c.nombre idclase,
//     COALESCE(color_runt.nombre, color_normal.nombre) idcolor,
//     UPPER(tc.nombre) idtipocombustible,
//     v.ano_modelo,
//     v.numero_motor,
//     v.numero_serie,
//     v.numero_tarjeta_propiedad,
//     v.cilindraje,
//     v.num_pasajeros,
//     v.potencia_motor,
//     v.tipo_vehiculo,
//     v.taximetro,
//     v.tiempos,
//     v.ensenanza,
//     p.nombre idpais,
//     REPLACE(v.fecha_matricula, '-', '') fecha_matricula,
//     v.blindaje,
//     v.polarizado,
//     v.numsillas,
//     v.numero_vin,
//     v.numero_vin numero_chasis,
//     v.numero_llantas,
//     v.numero_exostos,
//     v.scooter,
//     v.numejes,
//     v.kilometraje,
//     car.nombre diseno,
    
//     -- Configuración de llantas optimizada
//     COALESCE(
//         (SELECT p_da.valor
//          FROM pre_prerevision p_pr
//          JOIN pre_atributo p_at ON p_at.id = 'llanta_ejes'
//          JOIN pre_dato p_da ON p_da.idpre_atributo = p_at.idpre_atributo 
//                            AND p_da.idpre_prerevision = p_pr.idpre_prerevision
//          WHERE p_pr.numero_placa_ref = v.numero_placa
//          ORDER BY p_pr.idpre_prerevision DESC 
//          LIMIT 1),
//         CASE c.nombre
//             WHEN 'MOTOCICLETA' THEN '1-1'
//             WHEN 'CUATRIMOTO' THEN '2-2'
//             WHEN 'MOTOTRICICLO' THEN '1-2'
//             WHEN 'MOTOCARRO' THEN '1-2'
//             WHEN 'CUADRICICLO' THEN '2-2'
//             WHEN 'TRICIMOTO' THEN '2-1'
//             WHEN 'CICLOMOTOR' THEN '2-2'
//             WHEN 'AUTOMOVIL' THEN '2-2'
//             WHEN 'CAMIONETA' THEN '2-2'
//             WHEN 'CAMPERO' THEN '2-2'
//             WHEN 'MICROBUS' THEN '2-2'
//             WHEN 'BUS' THEN '2-4'
//             WHEN 'BUSETA' THEN '2-4'
//             WHEN 'CAMION' THEN '2-4'
//             WHEN 'TRACTOCAMION' THEN '2-4-4'
//             WHEN 'VOLQUETA' THEN '2-4'
//             ELSE '2-2'
//         END
//     ) conf_inf,
    
//     -- Datos de certificado de gas optimizados
//     COALESCE(cert_gas.numero_certificado, '') numero_certificado_gas,
//     COALESCE(cert_gas.fecha_inicio, '') fecha_inicio_certgas,
//     COALESCE(cert_gas.fecha_final, '') fecha_final_certgas


// FROM vehiculos v
// INNER JOIN servicio s ON v.idservicio = s.idservicio
// INNER JOIN clase c ON v.idclase = c.idclase
// INNER JOIN clientes cli ON v.idcliente = cli.idcliente
// INNER JOIN clientes pro ON v.idpropietarios = pro.idcliente
// INNER JOIN tipo_combustible tc ON v.idtipocombustible = tc.idtipocombustible
// INNER JOIN tipo_vehiculo tv ON v.tipo_vehiculo = tv.idtipo_vehiculo
// INNER JOIN paises p ON v.idpais = p.idpais
// INNER JOIN ciudades ciu_cli ON cli.cod_ciudad = ciu_cli.cod_ciudad
// INNER JOIN ciudades ciu_pro ON pro.cod_ciudad = ciu_pro.cod_ciudad
// INNER JOIN carroceria car ON v.diseno = car.idcarroceria

// -- LEFT JOINs para datos opcionales
// LEFT JOIN linea linea_normal ON v.registrorunt = '0' AND v.migrateLineaMarca <> 1 AND linea_normal.idlinea = v.idlinea
// LEFT JOIN linearunt linea_runt ON v.registrorunt <> '0' AND v.migrateLineaMarca <> 1 AND linea_runt.idlinearunt = v.idlinea
// LEFT JOIN marca marca_normal ON v.registrorunt = '0' AND v.migrateLineaMarca <> 1 
//     AND marca_normal.idmarca = (SELECT l.idmarca FROM linea l WHERE l.idlinea = v.idlinea LIMIT 1)
// LEFT JOIN marcarunt marca_runt ON v.registrorunt <> '0' AND v.migrateLineaMarca <> 1 
//     AND marca_runt.idmarcarunt = (SELECT l.idmarcarunt FROM linearunt l WHERE l.idlinearunt = v.idlinea LIMIT 1)
// LEFT JOIN color color_normal ON v.registrorunt = '0' AND color_normal.idcolor = v.idcolor
// LEFT JOIN colorrunt color_runt ON v.registrorunt <> '0' AND color_runt.idcolorrunt = v.idcolor

// -- Subconsulta para datos de certificado de gas (una sola vez)
// LEFT JOIN (
//     SELECT 
//         p_pr.numero_placa_ref,
//         MAX(CASE WHEN p_at.id = 'numero_certificado_g' THEN p_da.valor END) as numero_certificado,
//         MAX(CASE WHEN p_at.id = 'fecha_inicio_certgas' THEN p_da.valor END) as fecha_inicio,
//         MAX(CASE WHEN p_at.id = 'fecha_final_certgas' THEN p_da.valor END) as fecha_final
//     FROM pre_prerevision p_pr
//     JOIN pre_atributo p_at ON p_at.id IN ('numero_certificado_g', 'fecha_inicio_certgas', 'fecha_final_certgas')
//     JOIN pre_dato p_da ON p_da.idpre_atributo = p_at.idpre_atributo 
//                       AND p_da.idpre_prerevision = p_pr.idpre_prerevision
//     WHERE p_pr.numero_placa_ref = '$numero_placa'
//     GROUP BY p_pr.numero_placa_ref
//     ORDER BY p_pr.idpre_prerevision DESC
//     LIMIT 1
// ) cert_gas ON cert_gas.numero_placa_ref = v.numero_placa

// WHERE v.numero_placa = '$numero_placa'
// LIMIT 1;");
//         return $result;
//     }

    public function cargarVehiculoLite($numero_placa)
    {
        $result = $this->db->query("SELECT
v.numero_placa,
v.aplicares2703,
v.autoregulado,
upper(s.nombre) AS  idservicio,
if(v.registrorunt='0',(select l.nombre from linea l where l.idlinea=v.idlinea limit 1),(select l.nombre from linearunt l where l.idlinearunt=v.idlinea limit 1)) idlinea,
if(v.registrorunt='0',(select m.nombre from linea l,marca m where l.idlinea=v.idlinea and l.idmarca=m.idmarca limit 1),(select m.nombre from linearunt l,marcarunt m where l.idlinearunt=v.idlinea and m.idmarcarunt=l.idmarcarunt limit 1)) idmarca,
c.nombre AS  idclase,
if(v.registrorunt='0',(select co.nombre from color co where co.idcolor=v.idcolor limit 1),(select co.nombre from colorrunt co where co.idcolorrunt=v.idcolor limit 1)) idcolor,
v.ano_modelo,
v.numero_motor,
v.numero_serie,
v.numero_tarjeta_propiedad,
v.cilindraje,
v.potencia_motor,
v.tipo_vehiculo,
v.taximetro,
v.tiempos,
v.ensenanza,
IFNULL((SELECT p.nombre FROM paises p WHERE v.idpais = p.idpais LIMIT 1),'') AS   idpais,
replace(v.fecha_matricula,'-','') fecha_matricula,
v.blindaje,
v.polarizado,
v.numsillas,
v.numero_vin,
v.numero_vin numero_chasis,
v.numero_llantas,
v.numero_exostos,
v.scooter,
v.numejes,
v.kilometraje,
IFNULL(c.tipolux, '') AS tipolux,
v.convertidor,
(v.diametro_escape * 10) diametro_escape,
v.idtipocombustible,
if(v.idtipocombustible=1,'DIESEL',if(v.idtipocombustible=2,'GASOLINA',if(v.idtipocombustible=3,'GNV',if(v.idtipocombustible=4,'GAS-GASOL',if(v.idtipocombustible=5,'ELECTRICO',if(v.idtipocombustible=6,'HIDROGENO',if(v.idtipocombustible=7,'ETANOL',if(v.idtipocombustible=8,'BIODIESEL',if(v.idtipocombustible=9,'GLP',if(v.idtipocombustible=10,'GAS-ELECTRICO','GAS-DIESEL')))))))))) combustible,
v.numero_tarjeta_propiedad,
IFNULL((SELECT CONCAT(c.nombre1,' ',c.nombre2,' ',c.apellido1,' ',c.apellido2) FROM clientes c WHERE v.idcliente = c.idcliente LIMIT 1),'') AS nombre_propietario,
IFNULL((SELECT if(c.tipo_identificacion=1,'CC',if(c.tipo_identificacion=3,'CE',if(c.tipo_identificacion=4,'TI',if(c.tipo_identificacion=6,'PA','NIT')))) FROM clientes c WHERE v.idcliente = c.idcliente LIMIT 1),'') AS tipo_identificacion,
IFNULL((SELECT c.numero_identificacion FROM clientes c WHERE v.idcliente = c.idcliente LIMIT 1),'') AS numero_identificacion,
IFNULL((SELECT c.direccion FROM clientes c WHERE v.idcliente = c.idcliente LIMIT 1),'') AS direccion,
IFNULL((SELECT c.telefono1 FROM clientes c WHERE v.idcliente = c.idcliente LIMIT 1),'') AS telefono1,
IFNULL((SELECT c.telefono2 FROM clientes c WHERE v.idcliente = c.idcliente LIMIT 1),'') AS telefono2,
IFNULL((SELECT ci.nombre FROM clientes c, ciudades ci WHERE v.idcliente = c.idcliente AND c.cod_ciudad = ci.cod_ciudad LIMIT 1),'') AS nombre_ciudad,
IFNULL((SELECT ca.nombre FROM carroceria ca WHERE v.diseno = ca.idcarroceria LIMIT 1),'SIN CARROCERIA') AS carroceria
FROM vehiculos v,servicio s, clase c
WHERE
v.idservicio = s.idservicio AND v.idclase = c.idclase AND v.numero_placa = '$numero_placa' limit 1");
        return $result;
    }
}
