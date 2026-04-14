<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mutilitarios extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getNow() {
        $result = $this->db->query("select now() ahora");
        $result = $result->result();
        return $result[0]->ahora;
    }

    function getTodayLite() {
        $result = $this->db->query("select replace(curdate(),'-','') hoy");
        $result = $result->result();
        return $result[0]->hoy;
    }

    function getCurtDate() {
        $result = $this->db->query("select curdate() hoy");
        $result = $result->result();
        return $result[0]->hoy;
    }

    function getDayDiff($fechafinal) {
        $result = $this->db->query("select TIMESTAMPDIFF(DAY,DATE_FORMAT(NOW(),'%Y-%m-%d'), DATE_FORMAT('$fechafinal','%Y-%m-%d')) fechafinal");
        $result = $result->result();
        return $result[0]->fechafinal;
    }

    function getFechaSumY($anio) {
        $result = $this->db->query("select DATE_ADD(NOW(),INTERVAL $anio YEAR) fecha");
        $result = $result->result();
        return $result[0]->fecha;
    }

    function addTableResulAudit() {
        if (!$this->evaluarTabla("resultados_audit")) {
            $query = $this->db->query("CREATE TABLE `resultados_audit` (
                        `id` INT(11) NOT NULL AUTO_INCREMENT,
                        `idprueba` INT(11) NOT NULL DEFAULT '0',
                        `idresultado` INT(11) NOT NULL DEFAULT '0',
                        `auditoria` TEXT NOT NULL,
                        PRIMARY KEY (`id`))
                        COLLATE='utf8_general_ci'
                        ENGINE=MyISAM;");
            echo $query;
        }
    }

    function addTablePruebAudit() {
        if (!$this->evaluarTabla("pruebas_audit")) {
            $query = $this->db->query("CREATE TABLE `pruebas_audit` (
                        `id` INT(11) NOT NULL AUTO_INCREMENT,
                        `idprueba` INT(11) NOT NULL DEFAULT '0',
                        `auditoria` TEXT NOT NULL,
                        PRIMARY KEY (`id`))
                        COLLATE='utf8_general_ci'
                        ENGINE=MyISAM;");
            echo $query;
        }
    }

    function addTableCronAudit() {
        if (!$this->evaluarTabla("cron_audit")) {
            $query = $this->db->query("CREATE TABLE `cron_audit` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`placa` VARCHAR(10) NOT NULL DEFAULT '0',
	`idprueba` INT(11) NOT NULL DEFAULT '0',
	`idresultado` INT(11) NOT NULL DEFAULT '0',
	`intento` VARCHAR(1000) NOT NULL DEFAULT '0',
	`fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
        `notificado` TINYINT(1) NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`))
        COLLATE='utf8_general_ci'
        ENGINE=MyISAM;");
            echo $query;
        }
    }

    function addTableAudEnc() {
        if (!$this->evaluarTabla("audenc")) {
            $query = $this->db->query("CREATE TABLE `pruebas_audit` (
                        `id` INT(11) NOT NULL AUTO_INCREMENT,
                        `idprueba` INT(11) NOT NULL DEFAULT '0',
                        `auditoria` TEXT NOT NULL,
                        PRIMARY KEY (`id`))
                        COLLATE='utf8_general_ci'
                        ENGINE=MyISAM;");
            echo $query;
        }
    }

    function addColumn($tabla, $columna, $canterior, $tipodato) {
        if ($this->evaluarColumna($tabla, $columna) == 0) {
            $query = $this->db->query("ALTER TABLE `$tabla`
            ADD COLUMN `$columna` $tipodato NULL AFTER `$canterior`;");
            echo $query;
        }
    }

    function evaluarColumna($tabla, $campo) {
        $query = $this->db->query("SELECT count(*) dat FROM information_schema.COLUMNS
                                    WHERE COLUMN_NAME = '$campo'
                                    and TABLE_NAME = '$tabla'");
        $rta = $query->result();
        return $rta[0]->dat;
    }

    function evaluarTabla($tabla) {
        $data = $this->db->query("
            show tables like '%$tabla%' ");
        if ($data->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function confTriggerAuditoria() {
        $Q = <<<EOF
CREATE TRIGGER auditpru_jz
    BEFORE UPDATE 
    ON pruebas FOR EACH ROW
BEGIN
    SET @serial_=(SELECT valor from config_prueba where idconfig_prueba=20000+NEW.idmaquina LIMIT 1); 
    SET @ip=(SELECT valor from config_prueba where idconfig_prueba=10000+NEW.idmaquina LIMIT 1);
    SET @idrunt=(select valor from config_prueba where idconfig_prueba=8754 LIMIT 1);
    SET @usuario=(SELECT CONCAT(u.nombres,' ',u.apellidos) FROM usuarios u WHERE u.idusuario=NEW.idusuario LIMIT 1);
    SET @identificacion=(SELECT u.identificacion FROM usuarios u WHERE u.idusuario=NEW.idusuario LIMIT 1);
    SET @placa=(SELECT v.numero_placa FROM hojatrabajo h,pruebas p,vehiculos v WHERE v.idvehiculo=h.idvehiculo AND p.idhojapruebas=h.idhojapruebas AND p.idprueba=OLD.idprueba);
    SET @num_ejes=(SELECT v.numejes FROM hojatrabajo h,pruebas p,vehiculos v WHERE v.idvehiculo=h.idvehiculo AND p.idhojapruebas=h.idhojapruebas AND p.idprueba=OLD.idprueba);
    SET @reinspeccion= (SELECT h.reinspeccion FROM hojatrabajo h,pruebas p,vehiculos v WHERE v.idvehiculo=h.idvehiculo AND p.idhojapruebas=h.idhojapruebas AND p.idprueba=OLD.idprueba);
	 if((NEW.estado = 1 OR NEW.estado = 2 OR NEW.estado = 5) AND OLD.estado=0 AND DATE_FORMAT(OLD.fechainicial, '%Y%m%d')=DATE_FORMAT(NOW(), '%Y%m%d')) then
	 	  if NEW.estado = 5 then
		  		   SET @obs='Prueba cancelada';		  
		  else
		  		   SET @obs='';
		  END if;
		 if OLD.idtipo_prueba=1 then
		 	INSERT INTO auditoria_sicov VALUES(NULL,OLD.idhojapruebas,@serial_,@ip,DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),1,2,862,@idrunt,
			CONCAT('{"derBajaIntensidadValor1":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=1 AND r.observacion='baja_derecha' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","derBajaIntensidadValor2":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=2 AND r.observacion='baja_derecha' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","derBajaIntensidadValor3":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=3 AND r.observacion='baja_derecha' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","derBajaSimultaneas":"',(SELECT IFNULL((SELECT if(SUBSTRING(r.valor, 1, 1)='1','SI','NO') FROM resultados r WHERE  r.observacion='conmuLux' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","izqBajaIntensidadValor1":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=1 AND r.observacion='baja_izquierda' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","izqBajaIntensidadValor2":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=2 AND r.observacion='baja_izquierda' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","izqBajaIntensidadValor3":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=3 AND r.observacion='baja_izquierda' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","izqBajaSimultaneas":"',(SELECT IFNULL((SELECT if(SUBSTRING(r.valor, 1, 1)='1','SI','NO') FROM resultados r WHERE  r.observacion='conmuLux' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","derBajaInclinacionValor1":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=1 AND r.observacion='inclinacion_derecha' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","derBajaInclinacionValor2":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=2 AND r.observacion='inclinacion_derecha' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","derBajaInclinacionValor3":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=3 AND r.observacion='inclinacion_derecha' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","izqBajaInclinacionValor1":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=1 AND r.observacion='inclinacion_izquierda' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","izqBajaInclinacionValor2":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=2 AND r.observacion='inclinacion_izquierda' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","izqBajaInclinacionValor3":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=3 AND r.observacion='inclinacion_izquierda' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","Intensidad":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado='intensidad_total' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","derAltaIntensidadValor1":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=1 AND r.observacion='alta_derecha' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","derAltaIntensidadValor2":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=2 AND r.observacion='alta_derecha' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","derAltaIntensidadValor3":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=3 AND r.observacion='alta_derecha' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","derAltasSimultaneas":"',(SELECT IFNULL((SELECT if(SUBSTRING(r.valor, 2, 1)='1','SI','NO') FROM resultados r WHERE  r.observacion='conmuLux' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","izqAltaIntesidadValor1":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=1 AND r.observacion='alta_izquierda' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","izqAltaIntesidadValor2":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=2 AND r.observacion='alta_izquierda' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","izqAltaIntesidadValor3":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=3 AND r.observacion='alta_izquierda' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","izqAltasSimultaneas":"',(SELECT IFNULL((SELECT if(SUBSTRING(r.valor, 2, 1)='1','SI','NO') FROM resultados r WHERE  r.observacion='conmuLux' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","derExplorardorasValor1":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=1 AND r.observacion='antis_derecha' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","derExplorardorasValor2":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=2 AND r.observacion='antis_derecha' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","derExplorardorasValor3":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=3 AND r.observacion='antis_derecha' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","derExploradorasSimultaneas":"',(SELECT IFNULL((SELECT if(SUBSTRING(r.valor, 3, 1)='1','SI','NO') FROM resultados r WHERE  r.observacion='conmuLux' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","izqExplorardorasValor1":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=1 AND r.observacion='antis_izquierda' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","izqExplorardorasValor2":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=2 AND r.observacion='antis_izquierda' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","izqExplorardorasValor3":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=3 AND r.observacion='antis_izquierda' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","izqExploradorasSimultaneas":"',(SELECT IFNULL((SELECT if(SUBSTRING(r.valor, 3, 1)='1','SI','NO') FROM resultados r WHERE  r.observacion='conmuLux' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","tablaAfectada":"resultados","idRegistro":"',NEW.idprueba,'"}'),@usuario,@identificacion,@obs,@placa);
		 end if;		 
		 if OLD.idtipo_prueba=2 OR OLD.idtipo_prueba=3 then
		   if OLD.idtipo_prueba=3 then
		 		   SET @temperaturaAmbiente = (SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.observacion='temperatura_ambiente' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
		 		   SET @humedadRelativa = (SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.observacion='humedad' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
 		 	      SET @catalizador = (SELECT  if(v.scooter=1 AND v.tipo_vehiculo<>3,'SI','NO') FROM hojatrabajo h,pruebas p,vehiculos v WHERE v.idvehiculo=h.idvehiculo AND p.idhojapruebas=h.idhojapruebas AND p.idprueba=OLD.idprueba);
 		 	      if @catalizador='SI' then
     		 	      SET @temperatura = '0';
 		 	      ELSE
     		 	      SET @temperatura = (SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.observacion='temperatura_aceite' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
 		 	      END IF;
		 	      SET @temperaturaInicial = '';
				   SET @temperaturaFinal = '';
	   		   SET @diametro_escape = '';
		 		   IF (SELECT COUNT(*) FROM resultados r WHERE r.idprueba=NEW.idprueba and r.valor = 'DILUSION EXCESIVA' and r.tiporesultado = 'observaciones' LIMIT 1)>0 then
			 		   SET @dilucion = 'true';
	   		 	ELSE
			 		   SET @dilucion = 'false';
		 	      END IF;
		 	ELSE
		 			SET @temperaturaAmbiente = (SELECT IFNULL((SELECT valor FROM resultados r WHERE r.idconfig_prueba=200 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
		 		   SET @humedadRelativa = (SELECT IFNULL((SELECT valor FROM resultados r WHERE r.idconfig_prueba=201 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
		 		   SET @temperaturaInicialTMP = (SELECT IFNULL((SELECT valor FROM resultados r WHERE r.idconfig_prueba=224 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
		 		   SET @temperaturaFinalTMP = (SELECT IFNULL((SELECT valor FROM resultados r WHERE r.idconfig_prueba=39 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
  		 	      SET @diametro_escape = (SELECT v.diametro_escape FROM hojatrabajo h,pruebas p,vehiculos v WHERE v.idvehiculo=h.idvehiculo AND p.idhojapruebas=h.idhojapruebas AND p.idprueba=OLD.idprueba);
  		 	      SET @temperatura = '';
       		   SET @catalizador = '';
      		   SET @dilucion = '';
		 		   if @temperaturaFinalTMP < @temperaturaInicialTMP then
		 		   	SET @temperaturaInicial = @temperaturaFinalTMP;
		 		   	SET @temperaturaFinal = @temperaturaInicialTMP;
		 		   ELSE
		 		   	SET @temperaturaInicial = @temperaturaInicialTMP;
		 		   	SET @temperaturaFinal = @temperaturaFinalTMP;
		 	      END if;
		 	END if;
		 	INSERT INTO auditoria_sicov VALUES(NULL,OLD.idhojapruebas,@serial_,@ip,DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),1,1,862,@idrunt,
			CONCAT('{"temperaturaAmbiente":"',@temperaturaAmbiente,'","rpmRalenti":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.observacion='rpm_ralenti' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","tempRalenti":"',@temperatura,'","humedadRelativa":"',@humedadRelativa,'","velocidadGobernada0":"',(SELECT IFNULL((SELECT valor - (valor % 10) FROM resultados r WHERE r.idconfig_prueba=41 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'", "velocidadGobernada1":"',(SELECT IFNULL((SELECT valor - (valor % 10) FROM resultados r WHERE r.idconfig_prueba=63 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","velocidadGobernada2":"',(SELECT IFNULL((SELECT valor - (valor % 10) FROM resultados r WHERE r.idconfig_prueba=64 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","velocidadGobernada3":"',(SELECT IFNULL((SELECT valor - (valor % 10) FROM resultados r WHERE r.idconfig_prueba=65 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","opacidad0":"',(SELECT IFNULL((SELECT valor FROM resultados r WHERE r.idconfig_prueba=34 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","opacidad1":"',(SELECT IFNULL((SELECT valor FROM resultados r WHERE r.idconfig_prueba=35 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","opacidad2":"',(SELECT IFNULL((SELECT valor FROM resultados r WHERE r.idconfig_prueba=36 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","opacidad3":"',(SELECT IFNULL((SELECT valor FROM resultados r WHERE r.idconfig_prueba=37 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","valorFinal":"',(SELECT IFNULL((SELECT valor FROM resultados r WHERE r.idconfig_prueba=61 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","temperaturaInicial":"',@temperaturaInicial,'","temperaturaFinal":"',@temperaturaFinal,'","LTOEStandar":"',@diametro_escape,'","HCRalenti":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.observacion='hc_ralenti' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","CORalenti":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.observacion='co_ralenti' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","CO2Ralenti":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.observacion='co2_ralenti' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","O2Ralenti":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.observacion='o2_ralenti' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","rpmCrucero":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.observacion='rpm_crucero' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","HCCrucero":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.observacion='hc_crucero' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","COCrucero":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.observacion='co_crucero' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","CO2Crucero":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.observacion='co2_crucero' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","O2Crucero":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.observacion='o2_crucero' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","dilucion":"',@dilucion,'","catalizador":"',@catalizador,'","temperaturaPrueba":"',@temperatura,'","tablaAfectada":"resultados","idRegistro":"',NEW.idprueba,'"}'),@usuario,@identificacion,@obs,@placa);	    
		 end if;	    
		 if OLD.idtipo_prueba=4 then
		 	INSERT INTO auditoria_sicov VALUES(NULL,OLD.idhojapruebas,@serial_,@ip,DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),1,3,862,@idrunt,
			CONCAT('{"ruidoEscape":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado='valor_ruido_motor1' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","tablaAfectada":"resultados","idRegistro":"',NEW.idprueba,'"}'),@usuario,@identificacion,@obs,@placa);
	    end if;	 					
		 if OLD.idtipo_prueba=6 then
		 	INSERT INTO auditoria_sicov VALUES(NULL,OLD.idhojapruebas,@serial_,@ip,DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),1,8,862,@idrunt,
			CONCAT('{"refComericalLLanta":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado='Rllanta' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","errorDistancia":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado='error_distancia_nuevo' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","errorTiempo":"',(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado='error_tiempo_nuevo' AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),'')),'","tablaAfectada":"resultados","idRegistro":"',NEW.idprueba,'"}'),@usuario,@identificacion,@obs,@placa);
	    end if;	 				 	
		 if OLD.idtipo_prueba=7 then
		   SET @numEjes=(SELECT v.numejes FROM hojatrabajo h,pruebas p,vehiculos v WHERE v.idvehiculo=h.idvehiculo AND p.idhojapruebas=h.idhojapruebas AND p.idprueba=OLD.idprueba); 
		   SET @eficaciaTotal=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.idconfig_prueba=151 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
		   SET @eficaciaAuxiliar=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.idconfig_prueba=152 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
		   SET @fuerzaEje1Izquierdo=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=1 AND r.idconfig_prueba=149 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
			SET @pesoEje1Izquierdo=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=1 AND r.idconfig_prueba=147 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),IFNULL((SELECT r.valor FROM resultados r,pruebas p WHERE p.idprueba=r.idprueba AND p.idhojapruebas=NEW.idhojapruebas AND p.idtipo_prueba=9 AND r.tiporesultado=1 AND r.idconfig_prueba=147 ORDER BY r.idprueba DESC LIMIT 1),'')));
			SET @fuerzaEje1Derecho=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=1 AND r.idconfig_prueba=148 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
			SET @pesoEje1Derecho=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=1 AND r.idconfig_prueba=146 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),IFNULL((SELECT r.valor FROM resultados r,pruebas p WHERE p.idprueba=r.idprueba AND p.idhojapruebas=NEW.idhojapruebas AND p.idtipo_prueba=9 AND r.tiporesultado=1 AND r.idconfig_prueba=146 ORDER BY r.idprueba DESC LIMIT 1),'')));
			SET @eje1Desequilibrio=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=1 AND r.idconfig_prueba=150 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
			SET @fuerzaEje2Izquierdo=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=2 AND r.idconfig_prueba=149 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
			SET @pesoEje2Izquierdo=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=2 AND r.idconfig_prueba=147 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),IFNULL((SELECT r.valor FROM resultados r,pruebas p WHERE p.idprueba=r.idprueba AND p.idhojapruebas=NEW.idhojapruebas AND p.idtipo_prueba=9 AND r.tiporesultado=2 AND r.idconfig_prueba=147 ORDER BY r.idprueba DESC LIMIT 1),'')));
			SET @fuerzaEje2Derecho=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=2 AND r.idconfig_prueba=148 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
			SET @pesoEje2Derecho=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=2 AND r.idconfig_prueba=146 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),IFNULL((SELECT r.valor FROM resultados r,pruebas p WHERE p.idprueba=r.idprueba AND p.idhojapruebas=NEW.idhojapruebas AND p.idtipo_prueba=9 AND r.tiporesultado=2 AND r.idconfig_prueba=146 ORDER BY r.idprueba DESC LIMIT 1),'')));
			SET @eje2Desequilibrio=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=2 AND r.idconfig_prueba=150 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
			SET @fuerzaEje3Izquierdo=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=3 AND r.idconfig_prueba=149 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
			SET @pesoEje3Izquierdo=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=3 AND r.idconfig_prueba=147 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),IFNULL((SELECT r.valor FROM resultados r,pruebas p WHERE p.idprueba=r.idprueba AND p.idhojapruebas=NEW.idhojapruebas AND p.idtipo_prueba=9 AND r.tiporesultado=3 AND r.idconfig_prueba=147 ORDER BY r.idprueba DESC LIMIT 1),'')));
			SET @fuerzaEje3Derecho=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=3 AND r.idconfig_prueba=148 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
			SET @pesoEje3Derecho=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=3 AND r.idconfig_prueba=146 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),IFNULL((SELECT r.valor FROM resultados r,pruebas p WHERE p.idprueba=r.idprueba AND p.idhojapruebas=NEW.idhojapruebas AND p.idtipo_prueba=9 AND r.tiporesultado=3 AND r.idconfig_prueba=146 ORDER BY r.idprueba DESC LIMIT 1),'')));
			SET @eje3Desequilibrio=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=3 AND r.idconfig_prueba=150 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
			SET @fuerzaEje4Izquierdo=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=4 AND r.idconfig_prueba=149 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
			SET @pesoEje4Izquierdo=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=4 AND r.idconfig_prueba=147 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),IFNULL((SELECT r.valor FROM resultados r,pruebas p WHERE p.idprueba=r.idprueba AND p.idhojapruebas=NEW.idhojapruebas AND p.idtipo_prueba=9 AND r.tiporesultado=4 AND r.idconfig_prueba=147 ORDER BY r.idprueba DESC LIMIT 1),'')));
			SET @fuerzaEje4Derecho=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=4 AND r.idconfig_prueba=148 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
			SET @pesoEje4Derecho=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=4 AND r.idconfig_prueba=146 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),IFNULL((SELECT r.valor FROM resultados r,pruebas p WHERE p.idprueba=r.idprueba AND p.idhojapruebas=NEW.idhojapruebas AND p.idtipo_prueba=9 AND r.tiporesultado=4 AND r.idconfig_prueba=146 ORDER BY r.idprueba DESC LIMIT 1),'')));
			SET @eje4Desequilibrio=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=4 AND r.idconfig_prueba=150 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
			SET @fuerzaEje5Izquierdo=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=5 AND r.idconfig_prueba=149 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
			SET @pesoEje5Izquierdo=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=5 AND r.idconfig_prueba=147 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),IFNULL((SELECT r.valor FROM resultados r,pruebas p WHERE p.idprueba=r.idprueba AND p.idhojapruebas=NEW.idhojapruebas AND p.idtipo_prueba=9 AND r.tiporesultado=5 AND r.idconfig_prueba=147 ORDER BY r.idprueba DESC LIMIT 1),'')));
			SET @fuerzaEje5Derecho=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=5 AND r.idconfig_prueba=148 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
			SET @pesoEje5Derecho=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=5 AND r.idconfig_prueba=146 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),IFNULL((SELECT r.valor FROM resultados r,pruebas p WHERE p.idprueba=r.idprueba AND p.idhojapruebas=NEW.idhojapruebas AND p.idtipo_prueba=9 AND r.tiporesultado=5 AND r.idconfig_prueba=146 ORDER BY r.idprueba DESC LIMIT 1),'')));
			SET @eje5Desequilibrio=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=5 AND r.idconfig_prueba=150 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
			SET @fuerzaEje6Izquierdo=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=6 AND r.idconfig_prueba=149 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
			SET @pesoEje6Izquierdo=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=6 AND r.idconfig_prueba=147 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),IFNULL((SELECT r.valor FROM resultados r,pruebas p WHERE p.idprueba=r.idprueba AND p.idhojapruebas=NEW.idhojapruebas AND p.idtipo_prueba=9 AND r.tiporesultado=6 AND r.idconfig_prueba=147 ORDER BY r.idprueba DESC LIMIT 1),'')));
			SET @fuerzaEje6Derecho=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=6 AND r.idconfig_prueba=148 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
			SET @pesoEje6Derecho=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=6 AND r.idconfig_prueba=146 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),IFNULL((SELECT r.valor FROM resultados r,pruebas p WHERE p.idprueba=r.idprueba AND p.idhojapruebas=NEW.idhojapruebas AND p.idtipo_prueba=9 AND r.tiporesultado=6 AND r.idconfig_prueba=146 ORDER BY r.idprueba DESC LIMIT 1),'')));
			SET @eje6Desequilibrio=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=6 AND r.idconfig_prueba=150 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
			SET @derFuerzaAuxiliar=(SELECT IFNULL((SELECT sum(r.valor) FROM resultados r WHERE r.tiporesultado>@numEjes AND r.idprueba=NEW.idprueba AND r.idconfig_prueba=148 GROUP BY r.idconfig_prueba ORDER BY 1 DESC),''));
			SET @derFuerzaPeso=@pesoEje1Derecho + @pesoEje2Derecho + @pesoEje3Derecho + @pesoEje4Derecho + @pesoEje5Derecho + @pesoEje6Derecho;
			SET @izqFuerzaAuxiliar=(SELECT IFNULL((SELECT sum(r.valor) FROM resultados r WHERE r.tiporesultado>@numEjes AND r.idprueba=NEW.idprueba AND r.idconfig_prueba=149 GROUP BY r.idconfig_prueba ORDER BY 1 DESC),''));
			SET @izqFuerzaPeso=@pesoEje1Izquierdo + @pesoEje2Izquierdo + @pesoEje3Izquierdo + @pesoEje4Izquierdo + @pesoEje5Izquierdo + @pesoEje6Izquierdo;
		 	INSERT INTO auditoria_sicov VALUES(NULL,OLD.idhojapruebas,@serial_,@ip,DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),1,4,862,@idrunt,
			CONCAT('{"eficaciaTotal":"',@eficaciaTotal,'","eficaciaAuxiliar":"',@eficaciaAuxiliar,'","fuerzaEje1Izquierdo":"',@fuerzaEje1Izquierdo,'","pesoEje1Izquierdo":"',@pesoEje1Izquierdo,'","fuerzaEje1Derecho":"',@fuerzaEje1Derecho,'","pesoEje1Derecho":"',@pesoEje1Derecho,'","eje1Desequilibrio":"',@eje1Desequilibrio,'","fuerzaEje2Izquierdo":"',@fuerzaEje2Izquierdo,'","pesoEje2Izquierdo":"',@pesoEje2Izquierdo,'","fuerzaEje2Derecho":"',@fuerzaEje2Derecho,'","pesoEje2Derecho":"',@pesoEje2Derecho,'","eje2Desequilibrio":"',@eje2Desequilibrio,'","fuerzaEje3Izquierdo":"',@fuerzaEje3Izquierdo,'","pesoEje3Izquierdo":"',@pesoEje3Izquierdo,'","fuerzaEje3Derecho":"',@fuerzaEje3Derecho,'","pesoEje3Derecho":"',@pesoEje3Derecho,'","eje3Desequilibrio":"',@eje3Desequilibrio,'","fuerzaEje4Izquierdo":"',@fuerzaEje4Izquierdo,'","pesoEje4Izquierdo":"',@pesoEje4Izquierdo,'","fuerzaEje4Derecho":"',@fuerzaEje4Derecho,'","pesoEje4Derecho":"',@pesoEje4Derecho,'","eje4Desequilibrio":"',@eje4Desequilibrio,'","fuerzaEje5Izquierdo":"',@fuerzaEje5Izquierdo,'","pesoEje5Izquierdo":"',@pesoEje5Izquierdo,'","fuerzaEje5Derecho":"',@fuerzaEje5Derecho,'","pesoEje5Derecho":"',@pesoEje5Derecho,'","eje5Desequilibrio":"',@eje5Desequilibrio,'","fuerzaEje6Izquierdo":"',@fuerzaEje6Izquierdo,'","pesoEje6Izquierdo":"',@pesoEje6Izquierdo,'","fuerzaEje6Derecho":"',@fuerzaEje6Derecho,'","pesoEje6Derecho":"',@pesoEje6Derecho,'","eje6Desequilibrio":"',@eje6Desequilibrio,'","derFuerzaAuxiliar":"',@derFuerzaAuxiliar,'","derFuerzaPeso":"',@derFuerzaPeso,'","izqFuerzaAuxiliar":"',@izqFuerzaAuxiliar,'","izqFuerzaPeso":"',@izqFuerzaPeso,'","tablaAfectada":"resultados","idRegistro":"',NEW.idprueba,'"}'),@usuario,@identificacion,@obs,@placa);
		end if;	 				 			 
		if OLD.idtipo_prueba=8 then
			SET @Observaciones=(SELECT CONCAT(IFNULL((SELECT GROUP_CONCAT(r.observacion SEPARATOR '_') FROM resultados r WHERE r.idprueba=NEW.idprueba AND r.tiporesultado='defecto' AND r.observacion<>''),''),'_',IFNULL((SELECT r.valor FROM resultados r  WHERE r.idprueba=NEW.idprueba AND r.tiporesultado='COMENTARIOSADICIONALES'),'')));
			SET @CodigoRechazo=(SELECT IFNULL((SELECT GROUP_CONCAT(r.valor SEPARATOR '_') FROM resultados r WHERE r.idprueba=NEW.idprueba AND r.tiporesultado='defecto'),''));
		   INSERT INTO auditoria_sicov VALUES(NULL,OLD.idhojapruebas,@serial_,@ip,DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),1,7,862,@idrunt,
			CONCAT('{"Observaciones":"',@Observaciones,'","CodigoRechazo":"',@CodigoRechazo,'","tablaAfectada":"resultados","idRegistro":"',NEW.idprueba,'"}'),@usuario,@identificacion,'',@placa);			
	    end if;	 				 	
		 if OLD.idtipo_prueba=9 then
		   SET @suspIzqEje1=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.idconfig_prueba=143 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
		   SET @suspIzqEje2=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.idconfig_prueba=145 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
		   SET @susPDerEje1=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.idconfig_prueba=142 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
         SET @susPDerEje2=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.idconfig_prueba=144 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
		   INSERT INTO auditoria_sicov VALUES(NULL,OLD.idhojapruebas,@serial_,@ip,DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),1,6,862,@idrunt,
			CONCAT('{"suspIzqEje1":"',@suspIzqEje1,'","suspIzqEje2":"',@suspIzqEje2,'","susPDerEje1":"',@susPDerEje1,'","susPDerEje2":"',@susPDerEje2,'","tablaAfectada":"resultados","idRegistro":"',NEW.idprueba,'"}'),@usuario,@identificacion,@obs,@placa);
	    end if;	 				 	
		 if OLD.idtipo_prueba=10 then
		   SET @desviacionLateraleje1=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=1 AND r.idconfig_prueba=141 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
		   SET @desviacionLateraleje2=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=2 AND r.idconfig_prueba=141 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
		   SET @desviacionLateraleje3=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=3 AND r.idconfig_prueba=141 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
         SET @desviacionLateraleje4=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=4 AND r.idconfig_prueba=141 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
         SET @desviacionLateraleje5=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=5 AND r.idconfig_prueba=141 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
         SET @desviacionLateraleje6=(SELECT IFNULL((SELECT r.valor FROM resultados r WHERE r.tiporesultado=6 AND r.idconfig_prueba=141 AND r.idprueba=NEW.idprueba ORDER BY r.idprueba DESC LIMIT 1),''));
		   INSERT INTO auditoria_sicov VALUES(NULL,OLD.idhojapruebas,@serial_,@ip,DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),1,5,862,@idrunt,
			CONCAT('{"desviacionLateraleje1":"',@desviacionLateraleje1,'","desviacionLateraleje2":"',@desviacionLateraleje2,'","desviacionLateraleje3":"',@desviacionLateraleje3,'","desviacionLateraleje4":"',@desviacionLateraleje4,'","desviacionLateraleje5":"',@desviacionLateraleje5,'","desviacionLateraleje6":"',@desviacionLateraleje6,'","tablaAfectada":"resultados","idRegistro":"',NEW.idprueba,'"}'),@usuario,@identificacion,@obs,@placa);
	    end if;
    end if;
    
	 if(((OLD.estado = 1 OR OLD.estado = 2 OR OLD.estado = 5) AND NEW.estado=0 AND DATE_FORMAT(OLD.fechainicial, '%Y%m%d')=DATE_FORMAT(NOW(), '%Y%m%d') AND
	   (SELECT COUNT(*) FROM resultados WHERE idprueba=OLD.idprueba)>0) OR OLD.fechainicial<>NEW.fechainicial)  then
		   SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Operacion no permitida';
	 else
	 	if NEW.estado = 0 then
	 	 SET @obs='Prueba reasignada para repetir.';
	    SET @serial_=(SELECT valor from config_prueba where idconfig_prueba=20000+OLD.idmaquina LIMIT 1);
	    SET @ip=(SELECT valor from config_prueba where idconfig_prueba=10000+OLD.idmaquina LIMIT 1);
   	 SET @usuario=(SELECT CONCAT(u.nombres,' ',u.apellidos) FROM usuarios u WHERE u.idusuario=OLD.idusuario LIMIT 1);
	    SET @identificacion=(SELECT u.identificacion FROM usuarios u WHERE u.idusuario=OLD.idusuario LIMIT 1);
	 	 if OLD.idtipo_prueba=1 then
		 	INSERT INTO auditoria_sicov VALUES(NULL,OLD.idhojapruebas,@serial_,@ip,DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),3,2,862,@idrunt,
			CONCAT('{"derBajaIntensidadValor1":"","derBajaIntensidadValor2":"","derBajaIntensidadValor3":"","derBajaSimultaneas":"","izqBajaIntensidadValor1":"","izqBajaIntensidadValor2":"","izqBajaIntensidaValor3":"","IzqBajaSimultaneas":"","derBajaInclinacionValor1":"","derBajaInclinacionValor2":"","derBajaInclinacionValor3":"","izqBajaInclinacionValor1":"","izqBajaInclinacionValor2":"","izqBajaInclinacionValor3":"","sumatoriaIntensidad":"","derAltaIntensidadValor1":"","derAltaIntensidadValor2":"","derAltaIntensidadValor3":"","derAltasSimultaneas":"","izqAltaIntesidadValor1":"","izqAltaIntesidadValor2":"","izqAltaIntesidadValor3":"","izqAltasSimultaneas":"","derExplorardorasValor1":"","derExplorardorasValor2":"","derExplorardorasValor3":"","derExploradorasSimultaneas":"","izqExplorardorasValor1":"","izqExplorardorasValor2":"","izqExplorardorasValor3":"","izqExploradorasSimultaneas":"","tablaAfectada":"resultados","idRegistro":"',NEW.idprueba,'"}'),@usuario,@identificacion,@obs,@placa);
		 end if;
	 	 if OLD.idtipo_prueba=2 OR OLD.idtipo_prueba=3 then
		 	INSERT INTO auditoria_sicov VALUES(NULL,OLD.idhojapruebas,@serial_,@ip,DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),3,1,862,@idrunt,
			CONCAT('{"temperaturaAmbiente":"","rpmRalenti":"","tempRalenti":"","humedadRelativa":"","velocidadGobernada0":"","velocidadGobernada1":"","velocidadGobernada2":"","velocidadGobernada3":"","opacidad0":"","opacidad1":"","opacidad2":"","opacidad3":"","valorFinal":"","temperaturaInicial":"","temperaturaFinal":"","LTOEStandar":"","HCRalenti":"","CORalenti":"","CO2Ralenti":"","O2Ralenti":"","rpmCrucero":"","HCCrucero":"","COCrucero":"","CO2Crucero":"","O2Crucero":"","dilucion":"","catalizador":"","temperaturaPrueba":"","tablaAfectada":"resultados","idRegistro":"',NEW.idprueba,'"}'),@usuario,@identificacion,@obs,@placa);
		 end if;
	 	 if OLD.idtipo_prueba=4 then
		 	INSERT INTO auditoria_sicov VALUES(NULL,OLD.idhojapruebas,@serial_,@ip,DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),3,3,862,@idrunt,
			CONCAT('{"ruidoEscape":"","tablaAfectada":"resultados","idRegistro":"',NEW.idprueba,'"}'),@usuario,@identificacion,@obs,@placa);
		 end if;
	 	 if OLD.idtipo_prueba=6 then
		 	INSERT INTO auditoria_sicov VALUES(NULL,OLD.idhojapruebas,@serial_,@ip,DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),3,8,862,@idrunt,
			CONCAT('{"refComericalLLanta":"","errorDistancia":"","errorTiempo":"","tablaAfectada":"resultados","idRegistro":"',NEW.idprueba,'"}'),@usuario,@identificacion,@obs,@placa);
		 end if;
	 	 if OLD.idtipo_prueba=7 then
		 	INSERT INTO auditoria_sicov VALUES(NULL,OLD.idhojapruebas,@serial_,@ip,DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),3,4,862,@idrunt,
			CONCAT('{"refComericalLLanta":"","errorDistancia":"","errorTiempo":"","tablaAfectada":"resultados","idRegistro":"',NEW.idprueba,'"}'),@usuario,@identificacion,@obs,@placa);
		 end if;
	 	 if OLD.idtipo_prueba=8 then
		 	INSERT INTO auditoria_sicov VALUES(NULL,OLD.idhojapruebas,@serial_,@ip,DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),3,7,862,@idrunt,
			CONCAT('{"Observaciones":"","CodigoRechazo":"","tablaAfectada":"resultados","idRegistro":"',NEW.idprueba,'"}'),@usuario,@identificacion,@obs,@placa);
		 end if;
	 	 if OLD.idtipo_prueba=9 then
		 	INSERT INTO auditoria_sicov VALUES(NULL,OLD.idhojapruebas,@serial_,@ip,DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),3,6,862,@idrunt,
			CONCAT('{"suspIzqEje1":"","suspIzqEje2":"","susPDerEje1":"","susPDerEje2":"","tablaAfectada":"resultados","idRegistro":"',NEW.idprueba,'"}'),@usuario,@identificacion,@obs,@placa);
		 end if;
	 	 if OLD.idtipo_prueba=10 then
		 	INSERT INTO auditoria_sicov VALUES(NULL,OLD.idhojapruebas,@serial_,@ip,DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i:%s'),3,5,862,@idrunt,
			CONCAT('{"desviacionLateraleje1":"","desviacionLateraleje2":"","desviacionLateraleje3":"","desviacionLateraleje4":"","desviacionLateraleje5":"","desviacionLateraleje6":"","tablaAfectada":"resultados","idRegistro":"',NEW.idprueba,'"}'),@usuario,@identificacion,@obs,@placa);
		 end if;
	 	END if;
    end if;
END
EOF;
        $query = $this->db->query($Q);
        echo $query;
    }

    function confTriggerResultados() {
        $Q = <<<EOF
CREATE TRIGGER auditres_jz
    BEFORE UPDATE 
    ON resultados FOR EACH ROW
BEGIN
    if (OLD.valor<>NEW.valor AND DATE_FORMAT(OLD.fechaguardado, '%Y%m%d')=DATE_FORMAT(NOW(), '%Y%m%d')) OR NEW.fechaguardado<>OLD.fechaguardado then          
      INSERT INTO cron_audit VALUES(NULL,(SELECT v.numero_placa FROM pruebas p,hojatrabajo h,vehiculos v where p.idhojapruebas=h.idhojapruebas and v.idvehiculo=h.idvehiculo and p.idprueba=OLD.idprueba limit 1),OLD.idprueba,OLD.idresultados,concat((SELECT p.idtipo_prueba FROM pruebas p where p.idprueba=OLD.idprueba limit 1),'|',OLD.valor,'|',NEW.valor),NOW(),0);
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Operacion no permitida';
    end if;
END
EOF;
        $query = $this->db->query($Q);
        echo $query;
    }

    function confAuditoriaSICOV() {
        $query = $this->db->query("ALTER TABLE `auditoria_sicov`
	CHANGE COLUMN `trama` `trama` TEXT NOT NULL DEFAULT '' AFTER `id_runt_cda`,
	ADD COLUMN `usuario` VARCHAR(50) NOT NULL AFTER `trama`,
	ADD COLUMN `placa` VARCHAR(50) NULL DEFAULT NULL AFTER `observacion`;");
        echo $query;
    }

    function confFechaGuardado() {
        $query = $this->db->query("ALTER TABLE `resultados`
	CHANGE COLUMN `fechaguardado` `fechaguardado` TIMESTAMP NOT NULL DEFAULT current_timestamp() AFTER `valor`;");
        echo $query;
    }

}
