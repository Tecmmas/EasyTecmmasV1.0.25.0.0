<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mvehiculo extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get($data)
    {
        $this->db->where("idvehiculo", $data['idvehiculo']);
        $query = $this->db->get('vehiculos');
        return $query;
    }

    public function getXplacaLite($placa)
    {
        $this->db->where("numero_placa", $placa);
        $query = $this->db->get('vehiculos');
        return $query;
    }

    public function update($data)
    {
        $this->db->set("diseno", $data['diseno']);
        $this->db->set("imagen", $data['imagen']);
        $this->db->where("idvehiculo", $data['idvehiculo']);
        echo $this->db->update('vehiculos');
    }

    public function quitarAILinea()
    {
        $this->db->query("ALTER TABLE `linearunt`
	CHANGE COLUMN `idlineaRUNT` `idlineaRUNT` INT(11) NOT NULL AUTO_INCREMENT FIRST;");
    }

    //    function get($data) {
    //        $this->db->where("idvehiculo", $data['idvehiculo']);
    //        $this->db->where("numero_placa", $placa);
    //        $query = $this->db->get('vehiculos');
    //        return $query;
    //    }
    //
    //    function getXplacaLite($placa) {
    //        $this->db->where("numero_placa", $placa);
    //        $query = $this->db->get('vehiculos');
    //        return $query;
    //    }
    //
    //    function update($data) {
    //        $this->db->set("diseno", $data['diseno']);
    //        $this->db->set("imagen", $data['imagen']);
    //        $this->db->where("idvehiculo", $data['idvehiculo']);
    //        echo $this->db->update('vehiculos');
    //    }
    //
    //    function quitarAILinea() {
    //        $this->db->query("ALTER TABLE `linearunt`
    //    CHANGE COLUMN `idlineaRUNT` `idlineaRUNT` INT(11) NOT NULL AUTO_INCREMENT FIRST;");
    //    }

    public function guardarVehiculo($vehiculo)
    {
        $this->db->trans_start();
        $r = $this->getXplacaLite($vehiculo['numero_placa']);
        // if ($this->BuscarLinea($vehiculo['idlinea'])) {
            // $json = file_get_contents('application/libraries/linea.json', true);
            // $lin = json_decode($json, true);
            // foreach ($lin as $l) {
            //     if ($l['idlinea'] == $vehiculo['idlinea']) {
            //         $linearunt['idlineaRUNT'] = $l["idlinea"];
            //         $linearunt['idmarcaRUNT'] = $l["idmarca"];
            //         $linearunt['codigo'] = $l["codigo"];
            //         $linearunt['nombre'] = $l["nombre"];
            //         $this->insertarLineaRunt_($linearunt);

            //         if (!$rtaMar = $this->BuscarMarca($linearunt['idmarcaRUNT'])) {
            //             $json = file_get_contents('application/libraries/marca.json', true);
            //             $mar = json_decode($json, true);
            //             foreach ($mar as $m) {
            //                 if ($m['codigo'] == $linearunt['idmarcaRUNT']) {
            //                     $marcarunt['idmarcaRUNT'] = $m["codigo"];
            //                     $marcarunt['nombre'] = $m["nombre"];
            //                     $this->InsertarMarcaRunt($marcarunt);
            //                 }
            //             }
            //         }
            //         break;
            //     }
            // }
        // }
        if (!$rtaCol = $this->BuscarColor($vehiculo['idcolor'])) {
            $json = file_get_contents('recursos/color.json', true);
            $col = json_decode($json, true);
            foreach ($col as $c) {
                if ($c['codigo'] == $vehiculo['idcolor']) {
                    $colorrunt['idcolorrunt'] = $c['codigo'];
                    $colorrunt['nombre'] = $c['nombre'];
                    $this->InsertarColorRunt($colorrunt);
                }
            }
        }
        //
        if ($r->num_rows() !== 0) {
            unset($vehiculo['diametro_escape']);
            $this->db->where('numero_placa', $vehiculo['numero_placa']);
            echo $this->db->update('vehiculos', $vehiculo);
        } else {
            echo $this->db->insert('vehiculos', $vehiculo);
        }
        //
        $rtaPre = $this->BuscarPrerevision($vehiculo['numero_placa'], '1');
        $idpre_prerevision = "";
        if ($rtaPre->num_rows() > 0) {
            $r = $rtaPre->result();
            $pr = $r[0];
            $idpre_prerevision = $pr->idpre_prerevision;
        } else {
            $rtaPre = $this->BuscarPrerevision($vehiculo['numero_placa'], '0');
            if ($rtaPre->num_rows() > 0) {
                $r = $rtaPre->result();
                $pr = $r[0];
                $idpre_prerevision = $pr->idpre_prerevision;
            }
        }
        $servicio = $vehiculo['idservicio'];
        $placa = $vehiculo['numero_placa'];
        $this->db->query("UPDATE visor v SET v.servicio = $servicio , v.fecha = v.fecha WHERE v.placa = '$placa'");
        if ($idpre_prerevision !== "") {
            if ("1" == $pr->actualizado) {
                $histoVehiculo['histo_propietario'] = $vehiculo['idpropietarios'];
                $histoVehiculo['histo_servicio'] = $vehiculo['idservicio'];
                $histoVehiculo['histo_licencia'] = $vehiculo['numero_tarjeta_propiedad'];
                $histoVehiculo['histo_color'] = $vehiculo['idcolor'];
                $histoVehiculo['histo_combustible'] = $vehiculo['idtipocombustible'];
                $histoVehiculo['histo_kilometraje'] = $vehiculo['kilometraje'];
                $histoVehiculo['histo_blindaje'] = $vehiculo['blindaje'];
                $histoVehiculo['histo_polarizado'] = $vehiculo['polarizado'];
                $histoVehiculo['usuario_registro'] = $vehiculo['usuario'];
                $histoVehiculo['histo_cliente'] = $vehiculo['idcliente'];
                $histoVehiculo['numero_certificado_gas'] = $vehiculo['chk_3'];
                $histoVehiculo['fecha_final_certgas'] = $vehiculo['fecha_final_certgas'];
                $histoVehiculo['fecha_vencimiento_soat'] = $vehiculo['fecha_vencimiento_soat'];
                $histoVehiculo['nombre_empresa'] = $vehiculo['nombre_empresa'];
                $histoVehiculo['idpre_prerevision'] = $pr->idpre_prerevision;
                $histoVehiculo['tipo_inspeccion'] = $pr->tipo_inspeccion;
                $histoVehiculo['reinspeccion'] = $pr->reinspeccion;
                $this->actualizarHistoVehiculo($histoVehiculo);
            } else {
                $this->updatePreDato($idpre_prerevision, $this->BuscarPreAtributo('histo_propietario'), $vehiculo['idpropietarios']);
                $this->updatePreDato($idpre_prerevision, $this->BuscarPreAtributo('histo_servicio'), $vehiculo['idservicio']);
                $this->updatePreDato($idpre_prerevision, $this->BuscarPreAtributo('histo_licencia'), $vehiculo['numero_tarjeta_propiedad']);
                $this->updatePreDato($idpre_prerevision, $this->BuscarPreAtributo('histo_color'), $vehiculo['idcolor']);
                $this->updatePreDato($idpre_prerevision, $this->BuscarPreAtributo('histo_combustible'), $vehiculo['idtipocombustible']);
                $this->updatePreDato($idpre_prerevision, $this->BuscarPreAtributo('histo_kilometraje'), $vehiculo['kilometraje']);
                $this->updatePreDato($idpre_prerevision, $this->BuscarPreAtributo('histo_blindaje'), $vehiculo['blindaje']);
                $this->updatePreDato($idpre_prerevision, $this->BuscarPreAtributo('histo_polarizado'), $vehiculo['polarizado']);
                $this->updatePreDato($idpre_prerevision, $this->BuscarPreAtributo('usuario_registro'), $vehiculo['usuario']);
                $this->updatePreDato($idpre_prerevision, $this->BuscarPreAtributo('histo_cliente'), $vehiculo['idcliente']);
                $this->updatePreDato($idpre_prerevision, $this->BuscarPreAtributo('chk-3'), $vehiculo['chk_3']);
                $this->updatePreDato($idpre_prerevision, $this->BuscarPreAtributo('fecha_final_certgas'), $vehiculo['fecha_final_certgas']);
                $this->updatePreDato($idpre_prerevision, $this->BuscarPreAtributo('fecha_vencimiento_soat'), $vehiculo['fecha_vencimiento_soat']);
                $this->updatePreDato($idpre_prerevision, $this->BuscarPreAtributo('nombre_empresa'), $vehiculo['nombre_empresa']);
            }
        }
        $this->db->trans_complete();
    }

    public function actualizarHistoVehiculo($histoVehiculo)
    {
        $pre_prerevision['actualizado'] = '1';
        $this->db->where('idpre_prerevision', $histoVehiculo['idpre_prerevision']);
        $this->db->update("pre_prerevision", $pre_prerevision);

        $this->db->where('idpre_prerevision', $histoVehiculo['idpre_prerevision']);
        echo $this->db->update("histo_vehiculo", $histoVehiculo);
    }

    public function BuscarPrerevision($numero_placa, $reinspeccion)
    {
        if ($reinspeccion == '1' || $reinspeccion == '0') {
            $tipo_inspeccion = '1';
        } else if ($reinspeccion == '4444' || $reinspeccion == '44441') {
            $tipo_inspeccion = '2';
            if ($reinspeccion == '4444') {
                $reinspeccion = '0';
            } else {
                $reinspeccion = '1';
            }
        } else {
            $reinspeccion = '0';
            $tipo_inspeccion = '3';
        }
        $data = $this->db->query("
            SELECT
                *
                FROM
                pre_prerevision pp
                WHERE
                pp.numero_placa_ref='$numero_placa' AND
                pp.reinspeccion='$reinspeccion' AND
                pp.tipo_inspeccion='$tipo_inspeccion' and
                DATE_FORMAT(pp.fecha_prerevision,'%Y%M%d') = DATE_FORMAT(now(),'%Y%M%d') limit 1");
        return $data;
    }

    public function BuscarPreAtributo($id)
    {
        $data = $this->db->query("
            SELECT
                pa.idpre_atributo
                FROM
                pre_atributo pa
                WHERE
                pa.id='$id' limit 1");
        if ($data->num_rows() > 0) {
            $rta = $data->result();
            return $rta[0]->idpre_atributo;
        } else {
            return false;
        }
    }

    public function insertarPrerevision($numero_placa, $reinspeccion)
    {
        if ($reinspeccion == '1' || $reinspeccion == '0') {
            $tipo_inspeccion = '1';
        } else if ($reinspeccion == '4444' || $reinspeccion == '44441') {
            $tipo_inspeccion = '2';
            if ($reinspeccion == '4444') {
                $reinspeccion = '0';
            } else {
                $reinspeccion = '1';
            }
        } else {
            $reinspeccion = '0';
            $tipo_inspeccion = '3';
        }
        $pre_prerevision['consecutivo'] = 'OFC';
        $pre_prerevision['numero_placa_ref'] = $numero_placa;
        $pre_prerevision['tipo_inspeccion'] = $tipo_inspeccion;
        $pre_prerevision['reinspeccion'] = $reinspeccion;
        $pre_prerevision['actualizado'] = '1';
        $this->db->insert('pre_prerevision', $pre_prerevision);
        $pre_prerevision['idpre_prerevision'] = $this->db->insert_id();
        return $pre_prerevision;
    }

    public function insertPreDato($idpre_prerevision, $idpre_atributo, $valor)
    {
        $pre_dato['idpre_prerevision'] = $idpre_prerevision;
        $pre_dato['idpre_atributo'] = $idpre_atributo;
        $pre_dato['idpre_zona'] = '0';
        if ($valor == null) {
            $valor = "1";
        }

        $pre_dato['valor'] = $valor;
        $this->db->insert('pre_dato', $pre_dato);
    }

    public function updatePreDato($idpre_prerevision, $idpre_atributo, $valor)
    {
        $this->db->set('valor', $valor, true);
        $this->db->where('idpre_prerevision', $idpre_prerevision);
        $this->db->where('idpre_atributo', $idpre_atributo);
        $this->db->update('pre_dato');
    }

    public function getXplaca($placa)
    {
        $query = <<<EOF
                                select
                                    v.idvehiculo,
                                    v.numero_placa,
                                    IFNULL((SELECT cli.idcliente FROM clientes cli WHERE cli.idcliente=v.idcliente LIMIT 1),'') idcliente,
                                    IFNULL((SELECT cli.numero_identificacion FROM clientes cli WHERE cli.idcliente=v.idcliente LIMIT 1),'') documento_cliente,
                                    IFNULL((SELECT CONCAT(ifnull(cli.nombre1,''),' ',ifnull(cli.nombre2,'')) FROM clientes cli WHERE cli.idcliente=v.idcliente LIMIT 1),'') nombre_cliente,
                                    IFNULL((SELECT CONCAT(ifnull(cli.apellido1,''),' ',ifnull(cli.apellido2,'')) FROM clientes cli WHERE cli.idcliente=v.idcliente LIMIT 1),'') apellido_cliente,
                                    IFNULL((SELECT cli.telefono1 FROM clientes cli WHERE cli.idcliente=v.idcliente LIMIT 1),'') telefono_cliente,
                                    IFNULL((SELECT pro.idcliente FROM clientes pro WHERE pro.idcliente=v.idpropietarios LIMIT 1),'') idpropietario,
                                    IFNULL((SELECT pro.numero_identificacion FROM clientes pro WHERE pro.idcliente=v.idpropietarios LIMIT 1),'') documento_propietario,
                                    IFNULL((SELECT CONCAT(ifnull(pro.nombre1,''),' ',ifnull(pro.nombre2,'')) FROM clientes pro WHERE pro.idcliente=v.idpropietarios LIMIT 1),'') nombre_propietario,
                                    IFNULL((SELECT CONCAT(ifnull(pro.apellido1,''),' ',ifnull(pro.apellido2,'')) FROM clientes pro WHERE pro.idcliente=v.idpropietarios LIMIT 1),'') apellido_propietario,
                                    IFNULL((SELECT pro.telefono1 FROM clientes pro WHERE pro.idcliente=v.idpropietarios LIMIT 1),'') telefono_propietario,
        			                     IFNULL((SELECT CONCAT('<option value="',s.idservicio,'">',upper(s.nombre),'</option>') FROM servicio s WHERE s.idservicio=v.idservicio),'<option value="0">SIN LINEA</option>') idservicio,
                                   
                                    CASE 
        WHEN v.migrateLineaMarca <> 1 THEN
            IF(v.registrorunt = '0',
                IFNULL((SELECT upper(l.nombre) FROM linea l WHERE l.idlinea = v.idlinea LIMIT 1), 'SIN LINEA'),
                IFNULL((SELECT upper(lr.nombre) FROM linearunt lr WHERE lr.idlinearunt = v.idlinea LIMIT 1), 'SIN LINEA')
            )
        ELSE 
            IFNULL((SELECT upper(nl.nombre) FROM newlineas nl WHERE nl.idlineas = v.idlinea LIMIT 1), 'SIN LINEA')
    END as idlinea,
    
    -- ID de línea RUNT corregido:
    CASE 
        WHEN v.migrateLineaMarca <> 1 THEN
            IF(v.registrorunt = '0',
                IFNULL((SELECT l.idlinea FROM linea l WHERE l.idlinea = v.idlinea LIMIT 1), 0),
                IFNULL((SELECT lr.idlinearunt FROM linearunt lr WHERE lr.idlinearunt = v.idlinea LIMIT 1), 0)
            )
        ELSE 
            IFNULL((SELECT nl.idlineas FROM newlineas nl WHERE nl.idlineas = v.idlinea LIMIT 1), 0)
    END AS idlineaRUNT,
    
    -- Marca corregida:
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
    END AS idmarca,
    
    -- ID de marca RUNT corregido:
    CASE 
        WHEN v.migrateLineaMarca <> 1 THEN
            IF(v.registrorunt = '0',
                IFNULL((SELECT m.idmarca FROM marca m 
                       WHERE m.idmarca = (SELECT l.idmarca FROM linea l WHERE l.idlinea = v.idlinea LIMIT 1) 
                       LIMIT 1), 0),
                IFNULL((SELECT mr.idmarcarunt FROM marcarunt mr 
                       WHERE mr.idmarcarunt = (SELECT lr.idmarcarunt FROM linearunt lr WHERE lr.idlinearunt = v.idlinea LIMIT 1) 
                       LIMIT 1), 0)
            )
        ELSE 
            IFNULL((SELECT nm.idmarcas FROM newmarcas nm 
                   WHERE nm.idmarcas = (SELECT nl.idmarcas FROM newlineas nl WHERE nl.idlineas = v.idlinea LIMIT 1) 
                   LIMIT 1), 0)
    END AS idmarcaRUNT,
                                   
                        	        
                                   
                                   
                                    IFNULL((SELECT CONCAT('<option value="',c.idclase,'">',upper(c.nombre),'</option>') FROM clase c WHERE c.idclase=v.idclase),'<option value="1">AUTOMOVIL</option>') idclase,
                                    IFNULL((SELECT col.nombre FROM colorrunt col WHERE col.idcolorRUNT=v.idcolor),"SIN COLOR") idcolor,
                                    IFNULL((SELECT col.idcolorRUNT FROM colorrunt col WHERE col.idcolorRUNT=v.idcolor),0) idcolorrunt,
                                    IFNULL((SELECT CONCAT('<option value="',tc.idtipocombustible,'">',upper(tc.nombre),'</option>') FROM tipo_combustible tc WHERE tc.idtipocombustible=v.idtipocombustible),'<option value="2">GASOLINA</option>') idcombustible,
                                    v.ano_modelo,
                                    v.numero_motor, 
                                    v.numero_serie,
                                    v.numero_tarjeta_propiedad,
                                    v.cilindraje,
                                    CONCAT('<option value="',v.cilindros,'">',upper(v.cilindros),'</option>') cilindros,
                                    v.potencia_motor,
                                    IFNULL((SELECT CONCAT('<option value="',tv.idtipo_vehiculo,'">',upper(tv.nombre),'</option>') FROM tipo_vehiculo tv WHERE tv.idtipo_vehiculo=v.tipo_vehiculo),'<option value="1">LIVIANO</option>') tipo_vehiculo,
                                    if(v.taximetro=0,CONCAT("<option value='0'>NO</option>"),CONCAT("<option value='1'>SI</option>")) taximetro,
                                    CONCAT('<option value="',v.tiempos,'">',v.tiempos,'</option>') tiempos,
                                    if(v.ensenanza=0,CONCAT("<option value='0'>NO</option>"),CONCAT("<option value='1'>SI</option>")) ensenanza,
                                    IFNULL((SELECT CONCAT('<option value="',p.idpais,'">',p.nombre,'</option>') FROM paises p WHERE p.idpais=v.idpais),'<option value="90">COLOMBIA</option>') idpais,
                                    v.fecha_matricula,
                                    if(v.blindaje=0,CONCAT("<option value='0'>NO</option>"),CONCAT("<option value='1'>SI</option>")) blindaje,
                                    if(v.polarizado=0,CONCAT("<option value='0'>NO</option>"),CONCAT("<option value='1'>SI</option>")) polarizado,
                                    v.numsillas,
                                    v.num_pasajeros,
                                    v.numero_vin,
                                    v.numero_vin numero_chasis,
                                    CONCAT('<option value="',v.numero_llantas,'">',v.numero_llantas,'</option>') numero_llantas,
                                    CONCAT('<option value="',v.numero_exostos,'">',upper(v.numero_exostos),'</option>') numero_exostos,
                                    if(v.scooter=0,CONCAT("<option value='0'>NO</option>"),CONCAT("<option value='1'>SI</option>")) scooter,
                                    CONCAT('<option value="',v.numejes,'">',v.numejes,'</option>') numejes,
                                    v.kilometraje,
                                    IFNULL((SELECT car.idcarroceria FROM carroceria car WHERE car.idcarroceria=v.diseno),'0') idcarroceriarunt,
                                    IFNULL((SELECT upper(car.nombre) FROM carroceria car WHERE car.idcarroceria=v.diseno),'SIN CARROCERIA') diseno,
                                    ifnull(v.fecha_final_certgas,'') fecha_final_certgas,
                                    ifnull(v.fecha_vencimiento_soat,'') fecha_vencimiento_soat,
                                    if(v.chk_3='SI',CONCAT("<option value='SI'>SI</option>"),if(v.chk_3='NO',CONCAT("<option value='NO'>NO</option>"),CONCAT("<option value='NA'>NO APLICA</option>"))) chk_3,
                                    ifnull(v.nombre_empresa,'') nombre_empresa,
                                    v.migrateLineaMarca
                                    from
                                    vehiculos   v
                                    where
                                    v.numero_placa = '$placa' limit 1
EOF;
        return $this->db->query($query);
    }
    //     public function getXplaca($placa)
    //     {
    //         $query = <<<EOF
    //                                 select
    //                                     v.idvehiculo,
    //                                     v.numero_placa,
    //                                     IFNULL((SELECT cli.idcliente FROM clientes cli WHERE cli.idcliente=v.idcliente LIMIT 1),'') idcliente,
    //                                     IFNULL((SELECT cli.numero_identificacion FROM clientes cli WHERE cli.idcliente=v.idcliente LIMIT 1),'') documento_cliente,
    //                                     IFNULL((SELECT CONCAT(ifnull(cli.nombre1,''),' ',ifnull(cli.nombre2,'')) FROM clientes cli WHERE cli.idcliente=v.idcliente LIMIT 1),'') nombre_cliente,
    //                                     IFNULL((SELECT CONCAT(ifnull(cli.apellido1,''),' ',ifnull(cli.apellido2,'')) FROM clientes cli WHERE cli.idcliente=v.idcliente LIMIT 1),'') apellido_cliente,
    //                                     IFNULL((SELECT cli.telefono1 FROM clientes cli WHERE cli.idcliente=v.idcliente LIMIT 1),'') telefono_cliente,
    //                                     IFNULL((SELECT pro.idcliente FROM clientes pro WHERE pro.idcliente=v.idpropietarios LIMIT 1),'') idpropietario,
    //                                     IFNULL((SELECT pro.numero_identificacion FROM clientes pro WHERE pro.idcliente=v.idpropietarios LIMIT 1),'') documento_propietario,
    //                                     IFNULL((SELECT CONCAT(ifnull(pro.nombre1,''),' ',ifnull(pro.nombre2,'')) FROM clientes pro WHERE pro.idcliente=v.idpropietarios LIMIT 1),'') nombre_propietario,
    //                                     IFNULL((SELECT CONCAT(ifnull(pro.apellido1,''),' ',ifnull(pro.apellido2,'')) FROM clientes pro WHERE pro.idcliente=v.idpropietarios LIMIT 1),'') apellido_propietario,
    //                                     IFNULL((SELECT pro.telefono1 FROM clientes pro WHERE pro.idcliente=v.idpropietarios LIMIT 1),'') telefono_propietario,
    //         			                IFNULL((SELECT CONCAT('<option value="',s.idservicio,'">',upper(s.nombre),'</option>') FROM servicio s WHERE s.idservicio=v.idservicio),'<option value="0">SIN LINEA</option>') idservicio,
    // 				                    IFNULL((SELECT upper(lr.nombre) FROM linearunt lr WHERE lr.idlineaRUNT=v.idlinea),'SIN LINEA') idlinea,
    // 				                    IFNULL((SELECT lr.idlineaRUNT FROM linearunt lr WHERE lr.idlineaRUNT=v.idlinea),0) idlineaRUNT,
    //                 		            IFNULL((SELECT upper(mr.nombre) FROM marcarunt mr WHERE mr.idmarcaRUNT=(SELECT lr.idmarcarunt FROM linearunt lr WHERE lr.idlineaRUNT=v.idlinea)),'SIN MARCA') idmarca,
    //                         	        IFNULL((SELECT mr.idmarcaRUNT FROM marcarunt mr WHERE mr.idmarcaRUNT=(SELECT lr.idmarcarunt FROM linearunt lr WHERE lr.idlineaRUNT=v.idlinea)),0) idmarcaRUNT,
    //                                     IFNULL((SELECT CONCAT('<option value="',c.idclase,'">',upper(c.nombre),'</option>') FROM clase c WHERE c.idclase=v.idclase),'<option value="1">AUTOMOVIL</option>') idclase,
    //                                     IFNULL((SELECT col.nombre FROM colorrunt col WHERE col.idcolorRUNT=v.idcolor),"SIN COLOR") idcolor,
    //                                     IFNULL((SELECT col.idcolorRUNT FROM colorrunt col WHERE col.idcolorRUNT=v.idcolor),0) idcolorrunt,
    //                                     IFNULL((SELECT CONCAT('<option value="',tc.idtipocombustible,'">',upper(tc.nombre),'</option>') FROM tipo_combustible tc WHERE tc.idtipocombustible=v.idtipocombustible),'<option value="2">GASOLINA</option>') idcombustible,
    //                                     v.ano_modelo,
    //                                     v.numero_motor,
    //                                     v.numero_serie,
    //                                     v.numero_tarjeta_propiedad,
    //                                     v.cilindraje,
    //                                     CONCAT('<option value="',v.cilindros,'">',upper(v.cilindros),'</option>') cilindros,
    //                                     v.potencia_motor,
    //                                     IFNULL((SELECT CONCAT('<option value="',tv.idtipo_vehiculo,'">',upper(tv.nombre),'</option>') FROM tipo_vehiculo tv WHERE tv.idtipo_vehiculo=v.tipo_vehiculo),'<option value="1">LIVIANO</option>') tipo_vehiculo,
    //                                     if(v.taximetro=0,CONCAT("<option value='0'>NO</option>"),CONCAT("<option value='1'>SI</option>")) taximetro,
    //                                     CONCAT('<option value="',v.tiempos,'">',v.tiempos,'</option>') tiempos,
    //                                     if(v.ensenanza=0,CONCAT("<option value='0'>NO</option>"),CONCAT("<option value='1'>SI</option>")) ensenanza,
    //                                     IFNULL((SELECT CONCAT('<option value="',p.idpais,'">',p.nombre,'</option>') FROM paises p WHERE p.idpais=v.idpais),'<option value="90">COLOMBIA</option>') idpais,
    //                                     v.fecha_matricula,
    //                                     if(v.blindaje=0,CONCAT("<option value='0'>NO</option>"),CONCAT("<option value='1'>SI</option>")) blindaje,
    //                                     if(v.polarizado=0,CONCAT("<option value='0'>NO</option>"),CONCAT("<option value='1'>SI</option>")) polarizado,
    //                                     v.numsillas,
    //                                     v.num_pasajeros,
    //                                     v.numero_vin,
    //                                     v.numero_vin numero_chasis,
    //                                     CONCAT('<option value="',v.numero_llantas,'">',v.numero_llantas,'</option>') numero_llantas,
    //                                     CONCAT('<option value="',v.numero_exostos,'">',upper(v.numero_exostos),'</option>') numero_exostos,
    //                                     if(v.scooter=0,CONCAT("<option value='0'>NO</option>"),CONCAT("<option value='1'>SI</option>")) scooter,
    //                                     CONCAT('<option value="',v.numejes,'">',v.numejes,'</option>') numejes,
    //                                     v.kilometraje,
    //                                     IFNULL((SELECT car.idcarroceria FROM carroceria car WHERE car.idcarroceria=v.diseno),'0') idcarroceriarunt,
    //                                     IFNULL((SELECT upper(car.nombre) FROM carroceria car WHERE car.idcarroceria=v.diseno),'SIN CARROCERIA') diseno,
    //                                     ifnull(v.fecha_final_certgas,'') fecha_final_certgas,
    //                                     ifnull(v.fecha_vencimiento_soat,'') fecha_vencimiento_soat,
    //                                     if(v.chk_3='SI',CONCAT("<option value='SI'>SI</option>"),if(v.chk_3='NO',CONCAT("<option value='NO'>NO</option>"),CONCAT("<option value='NA'>NO APLICA</option>"))) chk_3,
    //                                     ifnull(v.nombre_empresa,'') nombre_empresa,
    //                                     v.migrateLineaMarca
    //                                     from
    //                                     vehiculos   v
    //                                     where
    //                                     v.numero_placa = '$placa' limit 1
    // EOF;
    //         return $this->db->query($query);
    //     }

    public function addColumFVS()
    {
        if ($this->evaluarColumna('fecha_vencimiento_soat') == 0) {
            $query = $this->db->query("ALTER TABLE `vehiculos`
            ADD COLUMN `fecha_vencimiento_soat` DATE NULL AFTER `registrorunt`;");
            echo $query;
        }
    }

    public function addchk_3()
    {
        if ($this->evaluarColumna('chk_3') == 0) {
            $query = $this->db->query("ALTER TABLE `vehiculos`
            ADD COLUMN `chk_3` VARCHAR(5) NULL DEFAULT 'NA' AFTER `fecha_vencimiento_soat`;");
            echo $query;
        }
    }

    public function addColumnFFCert()
    {
        if ($this->evaluarColumna('fecha_final_certgas') == 0) {
            $query = $this->db->query("ALTER TABLE `vehiculos`
            ADD COLUMN `fecha_final_certgas` DATE NULL AFTER `chk_3`;");
            echo $query;
        }
    }

    public function evaluarColumna($campo)
    {
        $query = $this->db->query("SELECT count(*) dat FROM information_schema.COLUMNS
                                    WHERE COLUMN_NAME = '$campo'
                                    and TABLE_NAME = 'vehiculos'");
        $rta = $query->result();
        return $rta[0]->dat;
    }

    public function BuscarTablaMarca()
    {
        $data = $this->db->query("
            show tables like '%marcarunt%' ");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function BuscarTablaLinea()
    {
        $data = $this->db->query("
            show tables like '%linearunt%' ");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function BuscarTablaColor()
    {
        $data = $this->db->query("
            show tables like '%colorrunt%' ");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function BuscarTablaObservaciones()
    {
        $data = $this->db->query("
            show tables like '%observaciones%' ");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function BuscarRegistroRunt()
    {
        $data = $this->db->query("
            show columns from vehiculos where Field='registrorunt'");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function CrearTablaMarca()
    {
        if (!$this->BuscarTablaMarca()) {
            try {
                $query = "CREATE TABLE `marcarunt` (
                            `idmarcaRUNT` INT(11) NOT NULL,
                            `nombre` VARCHAR(100) NOT NULL,
                            PRIMARY KEY (`idmarcaRUNT`))
                            ENGINE = MyISAM;";
                $this->db->query($query);
            } catch (Exception $ex) {
                echo ($ex->getMessage());
                return false;
            }
        }
    }

    public function CrearTablaLinea()
    {
        if (!$this->BuscarTablaLinea()) {
            try {
                $query = "CREATE TABLE `linearunt` (
                            `idlineaRUNT` INT(11) NOT NULL AUTO_INCREMENT,
                            `idmarcaRUNT` INT(11) NOT NULL,
                            `codigo` INT(11) NOT NULL,
                            `nombre` VARCHAR(100) NOT NULL,
                            PRIMARY KEY (`idlineaRUNT`))
                            ENGINE = MyISAM;";
                $this->db->query($query);
            } catch (Exception $ex) {
                echo ($ex->getMessage());
                return false;
            }
        }
    }

    public function CrearTablaColor()
    {
        if (!$this->BuscarTablaColor()) {
            try {
                $query = "CREATE TABLE `colorrunt` (
                            `idcolorRUNT` INT NOT NULL,
                            `nombre` VARCHAR(100) NOT NULL,
                            PRIMARY KEY (`idcolorRUNT`))ENGINE = MyISAM";
                $this->db->query($query);
            } catch (Exception $ex) {
                echo ($ex->getMessage());
                return false;
            }
        }
    }

    public function CrearTablaObservaciones()
    {
        if (!$this->BuscarTablaObservaciones()) {
            try {
                $query = "CREATE TABLE `observaciones` (
                                `id` INT(11) NOT NULL AUTO_INCREMENT,
                                `codigo` VARCHAR(50) NOT NULL,
                                `observacion` TEXT NOT NULL,
                                PRIMARY KEY (`id`)
                        )
                        COLLATE='utf8_general_ci'
                        ENGINE=MyISAM";
                $this->db->query($query);
            } catch (Exception $ex) {
                echo ($ex->getMessage());
                return false;
            }
        }
    }

    public function CrearRegistroRunt()
    {
        if (!$this->BuscarRegistroRunt()) {
            try {
                $query = "ALTER TABLE `vehiculos`
                        ADD COLUMN `registrorunt` VARCHAR(1) NULL DEFAULT '0' AFTER `numejes`;";
                $this->db->query($query);
            } catch (Exception $ex) {
                echo ($ex->getMessage());
                return false;
            }
        }
    }

    //    function CrearDispatadoresRUNT() {
    //            try {
    //                $query = <<<EOF
    //DROP TRIGGER IF EXISTS insert_linea;
    //DELIMITER $$
    //CREATE TRIGGER insert_linea
    //AFTER INSERT
    //ON linearunt FOR EACH ROW
    //BEGIN
    //IF NOT EXISTS (SELECT idlinea FROM linea WHERE idlinea=NEW.idlineaRUNT) THEN
    //INSERT INTO linea (idlinea,idmarca,nombre,idmintrans)
    //VALUES(NEW.idlinearunt,NEW.idmarcaRUNT,NEW.nombre,NEW.codigo);
    //END IF;
    //END$$
    //DELIMITER ;
    //EOF;
    //                $this->db->query($query);
    //            } catch (Exception $ex) {
    //                echo($ex->getMessage());
    //                return false;
    //            }
    //    }

    public function InsertarColorRunt($colorrunt)
    {
        $this->db->insert('colorrunt', $colorrunt);
    }

    public function BuscarColor($idcolor)
    {
        $data = $this->db->query("
            SELECT
                idcolorRUNT
            FROM
                colorrunt c
            WHERE
                c.idcolorRUNT=$idcolor");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function InsertarMarcaRunt($marcarunt)
    {
        $this->db->insert('marcarunt', $marcarunt);
    }

    public function BuscarMarca($idmarca)
    {
        $data = $this->db->query("
            SELECT
                idmarcaRUNT
            FROM
                marcarunt m
            WHERE
                m.idmarcaRUNT=$idmarca");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function InsertarLineaRunt($linearunt)
    {
        if (!$this->BuscarLinea($linearunt['idmarcaRUNT'], $linearunt['codigo'])) {

            $this->db->insert('linearunt', $linearunt);
        }
    }

    public function InsertarLineaRunt2($linearunt)
    {
        $rta = $this->BuscarLinea($linearunt['idmarcaRUNT'], $linearunt['codigo']);
        if (!$rta) {
            $this->db->insert('linearunt', $linearunt);
            //            return $this->db->insert_id();
        } else {
            $rta = $rta->result();
            return $rta[0]->idlineaRunt;
        }
    }

    public function BuscarLinea($idlinearunt)
    {
        $data = $this->db->query("
           SELECT
                l.idlineas
            FROM
                newlineas l
            WHERE
                l.idlineas=$idlinearunt
                ");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return false;
        }
    }
    // public function BuscarLinea($idlinearunt)
    // {
    //     $data = $this->db->query("
    //         SELECT
    //             idlineaRunt
    //         FROM
    //             linearunt l
    //         WHERE
    //             l.idlineaRUNT=$idlinearunt");
    //     if ($data->num_rows() > 0) {
    //         return $data;
    //     } else {
    //         return false;
    //     }
    // }

    public function BuscarLineaNombre($nombre)
    {
        $data = $this->db->query("
            SELECT
                idlineaRunt
            FROM
                linearunt l
            WHERE
                l.nombre='$nombre'");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function getVehiculoRegistroRunt1()
    {
        $data = $this->db->query("SELECT v.idlinea,lr.idlineaRUNT,lr.nombre FROM vehiculos v,linearunt lr WHERE v.registrorunt=1 AND lr.idlineaRUNT=v.idlinea group by 1");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function getVehiculoRegistroRunt2()
    {
        $data = $this->db->query("SELECT v.idlinea FROM vehiculos v WHERE v.registrorunt=1 group by 1");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function actualizarIdlineaRunt($idlineaOld, $idlineaNew)
    {
        $this->db->set('idlinea', $idlineaNew, true);
        $this->db->where('idlinea', $idlineaOld);
        $this->db->where('registrorunt', '1');
        $this->db->update('vehiculos');
    }

    public function actualizarPropietario($idpropietario, $numero_placa)
    {
        $this->db->set('idpropietarios', $idpropietario, true);
        $this->db->where('numero_placa', $numero_placa);
        $this->db->update('vehiculos');
    }

    public function actualizarCliente($idcliente, $numero_placa)
    {
        $this->db->set('idcliente', $idcliente, true);
        $this->db->where('numero_placa', $numero_placa);
        $this->db->update('vehiculos');
    }

    public function actualizarAplicaRes2703($autoregulado, $numero_placa)
    {
        if ($autoregulado == 'true') {
            $this->db->set('aplicares2703', '1', true);
        } else {
            $this->db->set('aplicares2703', '0', true);
        }
        $this->db->where('numero_placa', $numero_placa);
        $this->db->update('vehiculos');
    }

    public function actualizarAutoregulado($autoregulado, $numero_placa)
    {
        if ($autoregulado == 'true') {
            $this->db->set('autoregulado', '1', true);
        } else {
            $this->db->set('autoregulado', '0', true);
        }
        $this->db->where('numero_placa', $numero_placa);
        $this->db->update('vehiculos');
    }

    public function borrarLineaRunt()
    {
        $this->db->empty_table('linearunt');
    }

    public function insertarLineaRunt_($linearunt)
    {
        $this->db->insert('linearunt', $linearunt);
    }

    public function getXCRT()
    {
        $query = <<<EOF
              SELECT
                *
                FROM hojatrabajo h, vehiculos v
                WHERE
                v.idvehiculo=h.idvehiculo AND
                DATE_FORMAT(h.fechainicial,'%Y-%m-%d') BETWEEN '2019-01-01' AND  '2024-11-31' AND
                (h.reinspeccion=0 OR h.reinspeccion=1) AND
                v.imagen<>'OK'
                ORDER BY h.fechainicial
                LIMIT 1
EOF;
        return $this->db->query($query);
    }

    public function guardarCRT($data)
    {
        $this->db->set('idlinea', $data['idlinearunt'], true);
        $this->db->set('idcolor', $data['idcolorrunt'], true);
        $this->db->set('imagen', 'OK', true);
        $this->db->where('numero_placa', $data['numero_placa']);
        return $this->db->update('vehiculos');
    }

    public function BuscarxIdprueba($idprueba)
    {
        $placa = "";
        $query = <<<EOF
             SELECT v.numero_placa placa FROM hojatrabajo h,pruebas p,vehiculos v WHERE v.idvehiculo=h.idvehiculo AND p.idhojapruebas=h.idhojapruebas AND p.idprueba=$idprueba
EOF;
        $query2 = $this->db->query($query);
        if ($query2->num_rows() > 0) {
            $rta = $query2->result();
            $placa = $rta[0]->placa;
        }
        return $placa;
    }

    public function getNewLineas($idlinea, $idmarca)
    {
        $lineas = false;
        $marcas = false;
        
        $query = $this->db->query("SELECT * FROM newlineas WHERE idlineas = $idlinea");
        if ($query->num_rows() > 0) {
            //$res =  $query->result();
            $lineas = true;
        } else {
            $lineas = false;
        }


        // $idmarcas = $res[0]->idmarcas;
        $query = $this->db->query("SELECT * FROM newmarcas WHERE idmarcas = $idmarca");
        if ($query->num_rows() > 0) {
            $marcas = true;
        } else {
            $marcas = false;
        }
        return array('lineas' => $lineas, 'marcas' => $marcas);
        // return array('lineas' => $lineas, 'marcas' => $marcas);
    }

    public function insertNewLineasMarcas(
        $lineas,
        $marcas,
        $idlineas,
        $nombre,
        $codigo_ws,
        $idmarcas,
        $nombreMarca
    ) {

        if (!$lineas) {
            // echo "No existen lineas";
            $this->db->insert('newlineas', array(
                'idlineas' => $idlineas,
                'nombre' => $nombre,
                'idmarcas' => $idmarcas,
                'codigo_ws' =>  $codigo_ws
            ));
        }

        if (!$marcas) {
            $this->db->insert('newmarcas', array(
                'idmarcas' => $idmarcas,
                'nombre' => $nombreMarca
            ));
        }

        return true;
    }
}



