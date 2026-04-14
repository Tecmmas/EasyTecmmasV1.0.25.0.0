<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MGestion extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
        $this->myforge = $this->load->dbforge($this->db, TRUE);
    }

    function getVehiculosEnPista() {
        $this->tableSala2();
        $this->createTriguerSalae();
        $query = <<<EOF
            select distinct 
                 CASE
                            WHEN v.idservicio = '1' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '2' THEN
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: white;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '3' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '4' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '7' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            ELSE 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            END placa,
                  if(h.reinspeccion=0,'1ra','2da') ocacion,
                  h.idhojapruebas,v.numero_placa,h.reinspeccion
            from 
                vehiculos v, 
                hojatrabajo h, 
                pruebas p 
            where 
                h.idhojapruebas=p.idhojapruebas and 
                v.idvehiculo=h.idvehiculo and 
                (h.estadototal=1 or h.estadototal=3) and 
                ((DATE_FORMAT(h.fechainicial,'%Y%M%d') = DATE_FORMAT(now(),'%Y%M%d') or CURDATE() in (select date(fechainicial) from pruebas where idhojapruebas=h.idhojapruebas and estado=0 ))) and
                h.estadototal<>5 and p.estado=0 order by h.fechainicial desc
EOF;
        $rta = $this->db->query($query);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
        } else {
            $rta = '';
        }
        return $rta;
    }

    function tableSala2() {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'idhojaprueba' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
            ),
            'idprueba' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
            ),
            'idtipo_prueba' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
            ),
            'estado' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
            ),
            'actualizado' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
            ),
            'fecha' => array(
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ),
        );
        $this->myforge->add_key('id', TRUE);
        $this->myforge->add_field($fields);
        $attributes = array('ENGINE' => 'InnoDB');
        $this->myforge->create_table('control_salae', TRUE, $attributes);
    }

    public function createTriguerSalae() {
        $data = $this->db->query("SHOW TRIGGERS");
        $rta = $data->result();
        $val = false;
        foreach ($rta as $value) {
            if ($value->Trigger == 'salae') {
                $val = true;
            }
        }
        if ($val == false) {
            $query = $this->db->query("
            CREATE DEFINER=`root`@`localhost` TRIGGER `salae` AFTER UPDATE ON `pruebas` FOR EACH ROW BEGIN
 	  if NEW.idtipo_prueba=5 then
 		 SET @numcamara=(SELECT count(*) from pruebas where idtipo_prueba=5 AND idhojapruebas=NEW.idhojapruebas AND estado=0 group by idtipo_prueba LIMIT 1); 
	 	  if @numcamara > 0 then
		  		   SET @estado=0;		  
		  else
		  		   SET @estado=2;
		  END if;
		    INSERT INTO control_salae VALUES (NULL,NEW.idhojapruebas,NEW.idprueba,NEW.idtipo_prueba,@estado,'0',NOW());		  
	  else
		    INSERT INTO control_salae VALUES (NULL,NEW.idhojapruebas,NEW.idprueba,NEW.idtipo_prueba,NEW.estado,'0',NOW());	  
	  END if;
END
            "
            );
        }
    }

    function pruebasPendientes() {
        $query = <<<EOF
            select v.numero_placa,tp.nombre from vehiculos v, hojatrabajo h, pruebas p, tipo_prueba tp where tp.idtipo_prueba=p.idtipo_prueba and h.idhojapruebas=p.idhojapruebas and v.idvehiculo=h.idvehiculo and p.estado=0
EOF;
        $rta = $this->db->query($query);
        return $rta;
    }

    function getVehiculosRechazados() {
        $query = <<<EOF
            SELECT distinct 
                 CASE
                            WHEN v.idservicio = '1' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '2' THEN
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: white;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '3' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '4' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '7' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            ELSE 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            END placa,
                  if(h.reinspeccion=0,'1ra','2da') ocacion,
                  h.idhojapruebas,v.numero_placa,h.reinspeccion
from hojatrabajo h, vehiculos v 
WHERE 
(h.sicov=0 or h.estadototal=1)AND
(CURDATE()=date(h.fechainicial) or CURDATE()=date(h.fechafinal)) and v.idvehiculo=h.idvehiculo and (h.estadototal<>4 and h.estadototal<>5) AND
(if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=1 and estado<>5 order by idprueba desc limit 1 ),6))=1 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=1 and estado<>5 order by idprueba desc limit 1 ),6))=3,'R','A')='R' OR
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=2 and estado<>5 order by idprueba desc limit 1 ),6))=1 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=2 and estado<>5 order by idprueba desc limit 1 ),6))=3,'R','A')='R' OR
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=3 and estado<>5 order by idprueba desc limit 1 ),6))=1 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=3 and estado<>5 order by idprueba desc limit 1 ),6))=3,'R','A')='R' OR
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=4 and estado<>5  order by idprueba desc limit 1 ),6))=1 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=4 and estado<>5  order by idprueba desc limit 1 ),6))=3,'R','A')='R' OR
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=5 and prueba=0 and estado<>5 order by idprueba desc limit 1 ),6))=1 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=5 and prueba=0 and estado<>5 order by idprueba desc limit 1 ),6))=3,'R','A')='R' OR
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=5 and prueba=1 and estado<>5 order by idprueba desc limit 1 ),6))=1 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=5 and prueba=1 and estado<>5 order by idprueba desc limit 1 ),6))=3,'R','A')='R' OR
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=6 and estado<>5 order by idprueba desc limit 1 ),6))=1 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=6 and estado<>5 order by idprueba desc limit 1 ),6))=3,'R','A')='R' OR
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=7 and estado<>5 order by idprueba desc limit 1 ),6))=1 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=7 and estado<>5 order by idprueba desc limit 1 ),6))=3,'R','A')='R' OR
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=8 and estado<>5 order by idprueba desc limit 1 ),6))=1 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=8 and estado<>5 order by idprueba desc limit 1 ),6))=3,'R','A')='R' OR
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=9 and estado<>5 order by idprueba desc limit 1 ),6))=1 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=9 and estado<>5 order by idprueba desc limit 1 ),6))=3,'R','A')='R' OR
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=10 and estado<>5 order by idprueba desc limit 1 ),6))=1 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=10 and estado<>5 order by idprueba desc limit 1 ),6))=3,'R','A')='R') AND
if(0 IN (select estado FROM pruebas where idhojapruebas=h.idhojapruebas AND estado=0),'SI','NO') = 'NO'

EOF;
        $rta = $this->db->query($query);

        $rta = $this->db->query($query);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
        } else {
            $rta = '';
        }
        return $rta;
    }

    function getVehiculosAprobados() {
        $query = <<<EOF
            SELECT distinct 
                 CASE
                            WHEN v.idservicio = '1' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '2' THEN
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: white;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '3' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '4' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '7' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            ELSE 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            END placa,
                  if(h.reinspeccion=0,'1ra','2da') ocacion,
                  h.idhojapruebas,v.numero_placa,h.reinspeccion
FROM
    hojatrabajo h, vehiculos v
WHERE
(h.sicov=0 or h.estadototal=1)AND
(CURDATE()=date(h.fechainicial) or CURDATE()=date(h.fechafinal) or CURDATE() in (select date(fechafinal) from pruebas where idhojapruebas=h.idhojapruebas and (estado<>5 and estado<>0) and CURDATE()=date(NOW()))) and v.idvehiculo=h.idvehiculo and (h.estadototal<>4 and h.estadototal<>5) and 
(if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=1 and estado<>5 order by idprueba desc limit 1 ),6))=2 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=1 and estado<>5 order by idprueba desc limit 1 ),6))=6,'A','R')='A' AND
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=2 and estado<>5 order by idprueba desc limit 1 ),6))=2 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=2 and estado<>5 order by idprueba desc limit 1 ),6))=6,'A','R')='A' AND
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=3 and estado<>5 order by idprueba desc limit 1 ),6))=2 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=3 and estado<>5 order by idprueba desc limit 1 ),6))=6,'A','R')='A' AND
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=4 and estado<>5  order by idprueba desc limit 1 ),6))=2 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=4 and estado<>5  order by idprueba desc limit 1 ),6))=6,'A','R')='A' AND
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=5 and prueba=0 and estado<>5 order by idprueba desc limit 1),6))=2 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=5 and prueba=0 and estado<>5 order by idprueba desc limit 1),6))=6,'A','R')='A' AND
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=5 and prueba=1 and estado<>5 order by idprueba desc limit 1 ),6))=2 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=5 and prueba=1 and estado<>5 order by idprueba desc limit 1 ),6))=6,'A','R')='A' AND
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=6 and estado<>5 order by idprueba desc limit 1 ),6))=2 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=6 and estado<>5 order by idprueba desc limit 1 ),6))=6,'A','R')='A' AND
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=7 and estado<>5 order by idprueba desc limit 1 ),6))=2 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=7 and estado<>5 order by idprueba desc limit 1 ),6))=6,'A','R')='A' AND
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=8 and estado<>5 order by idprueba desc limit 1 ),6))=2 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=8 and estado<>5 order by idprueba desc limit 1 ),6))=6,'A','R')='A' AND
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=9 and estado<>5 order by idprueba desc limit 1 ),6))=2 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=9 and estado<>5 order by idprueba desc limit 1 ),6))=6,'A','R')='A' AND
if(
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=10 and estado<>5 order by idprueba desc limit 1 ),6))=2 OR
(select ifnull((select estado FROM pruebas where idhojapruebas = h.idhojapruebas and idtipo_prueba=10 and estado<>5 order by idprueba desc limit 1 ),6))=6,'A','R')='A')
EOF;
        $rta = $this->db->query($query);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
        } else {
            $rta = '';
        }
        return $rta;
    }

    function getRechazadoSinCosecutivo() {
        $query = <<<EOF
            select 
                distinct 
                 CASE
                            WHEN v.idservicio = '1' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '2' THEN
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: white;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '3' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '4' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '7' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            ELSE 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            END placa,
                  if(h.reinspeccion=0,'1ra','2da') ocacion,
                  h.idhojapruebas,v.numero_placa,h.reinspeccion
            from 
                vehiculos v, hojatrabajo h 
            where 
            v.idvehiculo=h.idvehiculo AND CURDATE()=date(h.fechafinal) and h.estadototal=3 and h.sicov=1 order by h.fechafinal desc
EOF;
        $rta = $this->db->query($query);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
        } else {
            $rta = '';
        }
        return $rta;
    }

    function getAprobadoSinCosecutivo() {
        $query = <<<EOF
            select 
                distinct 
                 CASE
                            WHEN v.idservicio = '1' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '2' THEN
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: white;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '3' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '4' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '7' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            ELSE 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            END placa,
                  if(h.reinspeccion=0,'1ra','2da') ocacion,
                  h.idhojapruebas,v.numero_placa,h.reinspeccion
            from 
            vehiculos v, hojatrabajo h 
            where v.idvehiculo=h.idvehiculo AND CURDATE()=date(h.fechafinal) and h.estadototal=2 and h.sicov=1 order by h.fechafinal desc
EOF;
        $rta = $this->db->query($query);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
        } else {
            $rta = '';
        }
        return $rta;
    }

    function getVehiculoTerminado() {
        $query = <<<EOF
            select 
                distinct 
                IFNULL((SELECT c.correo FROM clientes c WHERE v.idcliente = c.idcliente LIMIT 1),'') AS 'email',
                IFNULL((SELECT p.idpre_prerevision FROM pre_prerevision p WHERE p.numero_placa_ref = v.numero_placa LIMIT 1 ),'') AS 'idprerevision',
                 CASE
                            WHEN v.idservicio = '1' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '2' THEN
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: white;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '3' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '4' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            WHEN v.idservicio = '7' THEN 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: blue;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: whitesmoke;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            ELSE 
                            concat('
                            <label style="
                            border-radius: 6px 6px 6px 6px;background: gold;
                            color:black;
                            font-size: 14px;
                            font-weight: bold;
                            border: solid;
                            border-color: black;
                            padding: 2px"><strong>',v.numero_placa,'</strong></label>')
                            END placa,
                  if(h.reinspeccion=0,'1ra','2da') ocacion,
                  h.idhojapruebas,v.numero_placa,h.reinspeccion,h.estadototal
            from 
                vehiculos v, hojatrabajo h 
            where 
                v.idvehiculo=h.idvehiculo AND CURDATE()=date(h.fechafinal) and (h.estadototal=4 or h.estadototal=7) and h.sicov=1 order by h.fechafinal desc
EOF;
        //and 0<>(select count(*) from certificados c where c.idhojapruebas=h.idhojapruebas) 
        $rta = $this->db->query($query);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
        } else {
            $rta = '';
        }
        return $rta;
    }

    function getAuditoria() {
        $this->borrarRegAudit();
        $query = <<<EOF
            select * from cron_audit where notificado=0;
EOF;
        $rta = $this->db->query($query);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
            foreach ($rta as $r) {
                $this->db->where('id', $r->id);
                $this->db->set('notificado', 1, false);
                $this->db->update("cron_audit");
            }
            return $rta;
        } else {
            return '';
        }
    }

    function borrarRegAudit() {
        $query = <<<EOF
            delete from cron_audit where CURDATE()<>date(fecha)
EOF;
        $this->db->query($query);
    }

    function getPlacaSalaE() {
        $this->borrarPlacaSalaE();
        $query = <<<EOF
                    SELECT * FROM control_salae c WHERE c.actualizado=0 and c.estado<>5
EOF;
        $rta = $this->db->query($query);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
            foreach ($rta as $r) {
                $this->db->where('id', $r->id);
                $this->db->set('actualizado', 1, false);
                $this->db->update("control_salae");
            }
            return $rta;
        } else {
            return '';
        }
    }

    function borrarPlacaSalaE() {
        $query = <<<EOF
            delete from control_salae where CURDATE()<> DATE_FORMAT(fecha,'%Y-%m-%d')
EOF;
        $this->db->query($query);
    }

}
