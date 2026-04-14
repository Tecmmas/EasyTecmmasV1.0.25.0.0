<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mindex extends CI_Model
{

    var $validVariableEspejo = 0;

    function __construct()
    {
        parent::__construct();
        $this->load->dbutil();
        $this->myforge = $this->load->dbforge($this->db, TRUE);
        $this->validVariableEspejo = validEspejo();
        if ($this->validVariableEspejo == 1) {
            $this->bdslave = $this->load->database('bdslave', true);
            $this->borrarBd();
        }
    }

    public function staTus()
    {
        $consulta = <<<EOF
            SHOW SLAVE STATUS
EOF;
        $rta = $this->bdslave->query($consulta);
        return $rta;
    }

    function borrarBd()
    {
        //$this->db->query("STOP SLAVE");
        // $this->db->query("SET sql_log_bin = 0");

        // $this->db->query("DELETE h,p,r
        //                     FROM vehiculos v, hojatrabajo h, pruebas p, resultados r
        //                     WHERE v.idvehiculo = h.idvehiculo AND h.idhojapruebas = p.idhojapruebas AND p.idprueba = r.idprueba AND 
        //                     DATE_FORMAT(CURDATE(), '%Y-%m-%d')  <> DATE_FORMAT(p.fechafinal, '%Y-%m-%d') AND 
        //                     (h.estadototal = 4 OR h.reinspeccion = 8888 OR h.reinspeccion = 4444 OR h.reinspeccion = 4441)");
        // $this->db->query("DELETE p,pr 
        //                 FROM pre_prerevision p, pre_dato pr WHERE p.idpre_prerevision = pr.idpre_prerevision AND    
        //                 DATE_FORMAT(CURDATE(), '%Y-%m-%d')  <> DATE_FORMAT(p.fecha_prerevision, '%Y-%m-%d')");

        // $this->db->query("SET sql_log_bin = 1");
        // $this->db->query("START SLAVE");
    }

    // public function getresul_local()
    // {
    //     $query = true;
    //     $mesaje = "";
    //     $this->db2 = $this->load->database('bdrespaldo', true);
    //     $tecmmas = $this->db->query("SHOW TABLES ");
    //     $res = $tecmmas->result();
    //     foreach ($res as $bd) {
    //         if ($bd->Tables_in_tecmmas_bd !== 'backup') {
    //             $rta = $this->db->query("SELECT COUNT(*) AS 'res' FROM $bd->Tables_in_tecmmas_bd");
    //             $rta2 = $this->db2->query("SELECT COUNT(*) AS 'res' FROM $bd->Tables_in_tecmmas_bd");
    //             $data = $rta->result();
    //             $data2 = $rta2->result();
    //             if ($data[0]->res !== $data2[0]->res) {
    //                 $query = false;
    //                 $mesaje = $mesaje . "Tabla $bd->Tables_in_tecmmas_bd registros no coinciden bd_local= " . $data[0]->res . ' bd_resplado= ' . $data2[0]->res . '<br/>';
    //             }
    //         }
    //     }
    //     $imagenesbd = $this->db->query("SHOW DATABASES  like 'imagenes_bd'");
    //     if ($imagenesbd->num_rows() > 0) {
    //         $image = $this->db->query("SHOW TABLES FROM imagenes_bd");
    //         $r = $image->result();
    //         foreach ($r as $bd) {
    //             $rta = $this->db->query("SELECT COUNT(*) AS 'res' FROM imagenes_bd.$bd->Tables_in_imagenes_bd");
    //             $rta2 = $this->db2->query("SELECT COUNT(*) AS 'res' FROM imagenes_bd.$bd->Tables_in_imagenes_bd");
    //             $data = $rta->result();
    //             $data2 = $rta2->result();
    //             if ($data[0]->res !== $data2[0]->res) {
    //                 $query = false;
    //                 $mesaje = $mesaje . "En la base de datos imagenes_bd Tabla $bd->Tables_in_imagenes_bd registros no coinciden bd_local= " . $data[0]->res . ' bd_resplado= ' . $data2[0]->res . '<br/>';
    //             }
    //         }
    //     }
    //     if (!$query) {
    //         return $mesaje;
    //     } else {
    //         return $query;
    //     }
    // }
    //    function puede_entrar($usuario, $contrasena) {
    //        $this->db->where('username', $usuario);
    //        $this->db->where('passwd', $contrasena);
    //        $query = $this->db->get('usuarios');
    //        return $query;
    //    }

    function puede_entrar($usuario, $contrasena)
    {
        $consulta = <<<EOF
               SELECT 
                    u.IdUsuario,
                    u.tipo_identificacion,
                    u.idperfil,
                    u.nombres,
                    u.apellidos,
                    u.identificacion,
                    u.username,
                    u.estado,
                    u.fecha_actualizacion,
                    u.userUpdate,
                    u.biometrico,
                    AES_DECRYPT(u.passwd,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c') autentico,
                    AES_DECRYPT(u.passwd,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c') passwd
                    FROM 
                    usuarios u 
                    WHERE 
                    u.username = '$usuario' and AES_DECRYPT(u.passwd,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c') = '$contrasena';
EOF;
        $rta = $this->db->query($consulta);
        return $rta;
    }

    function validar_vigencia($idUsuario)
    {
        $result = $this->db->query("select 1 from usuarios u WHERE u.fecha_actualizacion<CURDATE() AND u.IdUsuario=" . $idUsuario);
        if ($result->num_rows() > 0) {
            return "1";
        } else {
            return "0";
        }
    }

    function enc()
    {
        //$this->dbforge->drop_column('usuarios', 'enc');
        if (!$this->db->field_exists('fechavigencia', 'cda')) {
            $fields = array(
                'fechavigencia' => array(
                    'type' => 'DATE',  // En mayúsculas es más estándar
                    'null' => TRUE,
                    'default' => NULL   // Explícito para claridad
                )
            );
            $this->dbforge->add_column('cda', $fields);
        }
        if (!$this->db->field_exists('nombre_empresa', 'vehiculos')) {
            $fields = array(
                'nombre_empresa' => array('type' => 'VARCHAR(500)')
            );
            $this->dbforge->add_column('vehiculos', $fields);
        }
        if (!$this->db->field_exists('userUpdate', 'usuarios')) {
            $fields = array(
                'userUpdate' => array('type' => 'INT(11)', 'default' => 0)
            );
            $this->dbforge->add_column('usuarios', $fields);
        }
        if (!$this->db->field_exists('idmodoTransporte', 'vehiculos')) {
            $fields = array(
                'idmodoTransporte' => array('type' => 'INT(11)', 'null' => true)
            );
            $this->dbforge->add_column('vehiculos', $fields);
            $this->createModoTransporte();
        }
        if (!$this->db->field_exists('equipo_asignado', 'usuarios')) {
            $fields = array(
                'equipo_asignado' => array('type' => 'VARCHAR(500)')
            );
            $this->dbforge->add_column('usuarios', $fields);
        }
        if (!$this->db->field_exists('biometrico', 'usuarios')) {
            $fields = array(
                'biometrico' => array('type' => 'LONGBLOB', 'null' => TRUE)
            );
            $this->dbforge->add_column('usuarios', $fields);
        }
        if (!$this->db->field_exists('nombre_empresa', 'vehiculos')) {
            $fields = array(
                'nombre_empresa' => array('type' => 'VARCHAR(500)')
            );
            $this->dbforge->add_column('vehiculos', $fields);
        }
        if (!$this->db->field_exists('aplicares2703', 'vehiculos')) {
            $fields = array(
                'aplicares2703' => array('type' => 'TINYINT', 'default' => '0')
            );
            $this->dbforge->add_column('vehiculos', $fields);
        }
        if (!$this->db->field_exists('autoregulado', 'vehiculos')) {
            $fields = array(
                'autoregulado' => array('type' => 'TINYINT', 'default' => '0')
            );
            $this->dbforge->add_column('vehiculos', $fields);
        }

        if (!$this->db->field_exists('actualizado', 'pre_prerevision')) {
            $fields = array(
                'actualizado' => array('type' => 'TINYINT', 'default' => '0')
            );
            $this->dbforge->add_column('pre_prerevision', $fields);
        }
        if (!$this->db->field_exists('enc', 'usuarios')) {
            $fields = array(
                'enc' => array('type' => 'VARBINARY(5000)')
            );
            $this->dbforge->add_column('usuarios', $fields);

            $consulta = <<<EOF
               UPDATE usuarios u SET u.passwd =  AES_ENCRYPT(u.passwd,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c')
EOF;
            $rta = $this->db->query($consulta);
            $consulta = <<<EOF
               UPDATE usuarios u SET 
u.enc = 
AES_ENCRYPT(CONCAT('{"IdUsuario"',': "', u.IdUsuario, '"',
', "tipo_identificacion"',': "', u.tipo_identificacion, '"',
', "idperfil"',': "', u.idperfil, '"',
', "nombres"',': "', u.nombres,'"',
', "apellidos"',': "', u.apellidos, '"',
', "identificacion"',': "', u.identificacion, '"',
', "username"',': "', u.username,'"',
', "estado"',': "', u.estado, '"',
', "fecha_actualizacion"',': "', u.fecha_actualizacion, '"}'),
'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c')
EOF;
            $rta = $this->db->query($consulta);
        }
        if (!$this->db->field_exists('enc', 'pruebas')) {
            $fields = array(
                'enc' => array('type' => 'VARBINARY(5000)')
            );
            //            $consulta = <<<EOF
            //               UPDATE usuarios u SET u.passwd =  AES_ENCRYPT(u.passwd,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c')
            //EOF;
            //            $rta = $this->db->query($consulta);
            $this->dbforge->add_column('pruebas', $fields);
            $this->db->query("ALTER TABLE visor  MODIFY luces VARCHAR(50) NULL;");
            $this->db->query("ALTER TABLE visor  MODIFY gases VARCHAR(50) NULL;");
            $this->db->query("ALTER TABLE visor  MODIFY opacidad VARCHAR(50) NULL;");
            $this->db->query("ALTER TABLE visor  MODIFY sonometro VARCHAR(50) NULL;");
            $this->db->query("ALTER TABLE visor  MODIFY visual VARCHAR(50) NULL;");
            $this->db->query("ALTER TABLE visor  MODIFY camara0 VARCHAR(50) NULL;");
            $this->db->query("ALTER TABLE visor  MODIFY camara1 VARCHAR(50) NULL;");
            $this->db->query("ALTER TABLE visor  MODIFY alineacion VARCHAR(50) NULL;");
            $this->db->query("ALTER TABLE visor  MODIFY frenos VARCHAR(50) NULL;");
            $this->db->query("ALTER TABLE visor  MODIFY suspension VARCHAR(50) NULL;");
            $this->db->query("ALTER TABLE visor  MODIFY taximetro VARCHAR(50) NULL;");
        }
        if (!$this->db->field_exists('enc', 'resultados')) {
            $fields = array(
                'enc' => array('type' => 'VARBINARY(5000)')
            );
            $this->dbforge->add_column('resultados', $fields);
        }

        //control para nuevas marcas lineas y ciudades
        if (!$this->db->field_exists('migrateLineaMarca', 'vehiculos')) {
            $fields = array(
                'migrateLineaMarca' => array('type' => 'TINYINT', 'default' => '0')
            );
            $this->dbforge->add_column('vehiculos', $fields);
            $this->db->query("ALTER TABLE sede  MODIFY cod_ciudad VARCHAR(30) NULL;");
            $this->db->query("ALTER TABLE ciudades  MODIFY cod_ciudad VARCHAR(30) NULL;");
            $this->db->query("ALTER TABLE clientes  MODIFY cod_ciudad VARCHAR(30) NULL;");
            $this->db->query("DELETE FROM ciudades");

            //gestion de tabla clase
            $this->db->query("DELETE FROM clase");
            $this->db->query("INSERT INTO clase (idclase, nombre, tipolux) VALUES
                                (1, 'AUTOMOVIL', 'M1'),
                                (2, 'BUS', 'M3'),
                                (3, 'BUSETA', 'M3'),
                                (4, 'CAMION', 'N2'),
                                (5, 'CAMIONETA', 'N1G'),
                                (6, 'CAMPERO', 'M1G'),
                                (7, 'MICROBUS', 'M2'),
                                (8, 'TRACTOCAMION', 'N3'),
                                (42, 'VOLQUETA', 'N2'),
                                (10, 'MOTOCICLETA', 'L3e'),
                                (11, 'MAQ.AGRICOLA', 'N3'),
                                (12, 'MAQ.INDUSTRIAL', 'N3'),
                                (41, 'SEMIREMOLQUE', 'N3'),
                                (14, 'MOTOCARRO', 'L6e'),
                                (24, 'REMOLQUE', 'N3'),
                                (43, 'SIN CLASE', 'M1'),
                                (17, 'MOTOTRICICLO', 'L4e'),
                                (19, 'CUATRIMOTO', ''),
                                (163, 'CICLOMOTOR', ''),
                                (164, 'TRICIMOTO', ''),
                                (165, 'CUADRICICLO', ''),
                                (160, 'MAQ. CONSTRUCCION O MINERA', 'N3'),
                                (181, 'TRICIMÓVIL', 'L6e');");

            $this->db->query("UPDATE vehiculos SET idclase = 42 WHERE idclase = 9;");
            $this->db->query("UPDATE vehiculos SET idclase = 41 WHERE idclase = 13;");
            $this->db->query("UPDATE vehiculos SET idclase = 24 WHERE idclase = 15;");
            $this->db->query("UPDATE vehiculos SET idclase = 43 WHERE idclase = 16;");
            $this->db->query("UPDATE vehiculos SET idclase = 19 WHERE idclase = 30;");
            $this->db->query("UPDATE vehiculos SET idclase = 5 WHERE idclase = 166;");
            //solo para pruebas
            $this->db->query("DROP TABLE IF EXISTS newmarcas;");
            $this->db->query("DROP TABLE IF EXISTS newlineas;");


            $this->createTablaNewMarcas();
            $this->createTablaNewLineas();
        }

        // Verificar si ya existe algún registro
        $check = $this->db->query("SELECT COUNT(*) as total FROM tipo_combustible WHERE idtipocombustible IN (12,13,14,15)")->row();
        if ($check->total == 0) {
            $this->db->query("INSERT INTO tipo_combustible (idtipocombustible, nombre) VALUES
                        (12, 'Diesel-gas'),
                        (13, 'Glp-electrico'),
                        (14, 'Glp-gasolina'),
                        (15, 'Biodiesel-electrico')");
        }


        $this->createTablaHistoVehiculo();
        $this->createTablaControlEnvioBogota();
    }

    function createTablaHistoVehiculo()
    {
        //$this->ajustarFechaPrerevision();
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'idpre_prerevision' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'unique' => TRUE,
                'null' => FALSE,
            ),
            'tipo_inspeccion' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
            ),
            'reinspeccion' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
            ),
            'histo_propietario' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => TRUE,
            ),
            'histo_servicio' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => TRUE,
            ),
            'histo_licencia' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => TRUE,
            ),
            'histo_color' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => TRUE,
            ),
            'histo_combustible' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => TRUE,
            ),
            'histo_kilometraje' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => TRUE,
            ),
            'histo_blindaje' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => TRUE,
            ),
            'histo_polarizado' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => TRUE,
            ),
            'usuario_registro' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => TRUE,
            ),
            'histo_cliente' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => TRUE,
            ),
            'numero_certificado_gas' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => TRUE,
            ),
            'fecha_final_certgas' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => TRUE,
            ),
            'fecha_vencimiento_soat' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => TRUE,
            ),
            'nombre_empresa' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => TRUE,
            ),
            'fecha' => array(
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ),
        );
        $this->myforge->add_key('id', TRUE);
        $this->myforge->add_field($fields);
        $attributes = array('ENGINE' => 'MyISAM');
        $this->myforge->create_table('histo_vehiculo', TRUE, $attributes);
    }

    function createTablaControlEnvioBogota()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `control_envio_api` (
                `idcontrolenvioapi` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `idprueba` INT(11) NOT NULL,
                `idmaquina` INT(11) NOT NULL,
                `placa` VARCHAR(200) NULL,
                `mensaje` LONGTEXT NULL,
                `estado` INT(11) NOT NULL,
                `fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT `pk_control_envio_api` PRIMARY KEY(`idcontrolenvioapi`)
            ) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci";

        $this->db->query($sql);
    }

    function createTablaNewMarcas()
    {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
                // 'unsigned' => TRUE,
            ),
            'idmarcas' => array(
                'type' => 'INT',
                'constraint' => 11,
                // 'unsigned' => TRUE,
            ),
            'nombre' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => TRUE,
            )
        );

        // CORRECCIÓN: Debe ser 'idmarcas' no 'idmarca'
        $this->myforge->add_key('id', TRUE);
        $this->myforge->add_field($fields);
        $attributes = array('ENGINE' => 'MyISAM');
        $this->myforge->create_table('newmarcas', TRUE, $attributes);

        // Ejecutar el archivo SQL de marcas

    }

    function createTablaNewLineas()
    {
        $this->db->trans_start();
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
                //'unsigned' => TRUE,
            ),
            'idlineas' => array(
                'type' => 'INT',
                'constraint' => 11,
                //'unsigned' => TRUE,
            ),
            'nombre' => array(
                'type' => 'VARCHAR',
                'constraint' => 2000,
                'null' => TRUE,
            ),
            'idmarcas' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'codigo_ws' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                //'unique' => TRUE,
                'null' => FALSE,
            ),
        );

        $this->myforge->add_key('id', TRUE);
        $this->myforge->add_field($fields);
        $attributes = array('ENGINE' => 'MyISAM');
        $this->myforge->create_table('newlineas', TRUE, $attributes);


        $this->executeSQLFile('application/libraries/marcas.sql');
        $this->executeSQLFile('application/libraries/lineas.sql');
        $this->executeSQLFile('application/libraries/ciudades.sql');
        $this->db->query("UPDATE clientes c
                        SET c.cod_ciudad = (
                            SELECT ci.cod_ciudad
                            FROM ciudades ci 
                            WHERE ci.cod_ciudad LIKE CONCAT(c.cod_ciudad, '%')
                            LIMIT 1
                        )
                        WHERE EXISTS (
                            SELECT 1
                            FROM ciudades ci 
                            WHERE ci.cod_ciudad LIKE CONCAT(c.cod_ciudad, '%')
                        );");

        $this->db->query("UPDATE sede s
                        JOIN ciudades ci ON ci.cod_ciudad LIKE CONCAT(s.cod_ciudad, '%')
                        SET s.cod_ciudad = ci.cod_ciudad;");
        $this->db->trans_complete();
    }


    private function executeSQLFile($file_path)
    {
        if (!file_exists($file_path)) {
            log_message('error', 'Archivo SQL no encontrado: ' . $file_path);
            return false;
        }
        $sqlfile = file_get_contents($file_path);
        $queries = explode(';', $sqlfile);
        $this->db->trans_start();
        $success_count = 0;
        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query)) {
                try {
                    $this->db->query($query);
                    $success_count++;
                } catch (Exception $e) {
                    log_message('error', 'Error ejecutando consulta: ' . $e->getMessage());
                    log_message('debug', 'Consulta: ' . substr($query, 0, 200));
                }
            }
        }

        $this->db->trans_complete();
        log_message('info', "Ejecutadas $success_count consultas de " . basename($file_path));

        return $success_count;
    }

    // function createTablaNewMarcas()
    // {
    //     $fields = array(
    //         'idmarcas' => array(
    //             'type' => 'INT',
    //             'constraint' => 11,
    //             'unsigned' => TRUE,
    //         ),
    //         'nombre' => array(
    //             'type' => 'VARCHAR',
    //             'constraint' => 200,
    //             'null' => TRUE,
    //         )
    //     );
    //     $this->myforge->add_key('idmarca', TRUE);
    //     $this->myforge->add_field($fields);
    //     $attributes = array('ENGINE' => 'MyISAM');
    //     $this->myforge->create_table('NewMarcas', TRUE, $attributes);
    //     $sqlfile = file_get_contents('application/libraries/marcas.sql');
    // }

    // function createTablaNewLineas()
    // {
    //     $fields = array(
    //         'idlineas' => array(
    //             'type' => 'INT',
    //             'constraint' => 11,
    //             'unsigned' => TRUE,
    //         ),
    //         'nombre' => array(
    //             'type' => 'VARCHAR',
    //             'constraint' => 2000,
    //             'null' => TRUE,
    //         ),
    //         'idmarcas' => array(
    //             'type' => 'INT',
    //             'constraint' => 11,
    //         ),
    //         'codigo_ws' => array(
    //             'type' => 'INT',
    //             'unsigned' => TRUE,
    //             'unique' => TRUE,
    //             'null' => FALSE,
    //         ),

    //     );
    //     $this->myforge->add_key('idlineas', TRUE);
    //     $this->myforge->add_field($fields);
    //     $attributes = array('ENGINE' => 'MyISAM');
    //     $this->myforge->create_table('NewLineas', TRUE, $attributes);

    //     $sqlfile = file_get_contents('application/libraries/lineas.sql');
    // }



    //     function ajustarFechaPrerevision() {
    //         $consulta = <<<EOF
    //         SELECT DISTINCT h.idhojapruebas,h.idvehiculo, h.fechainicial, h.fechafinal, h.reinspeccion, p.*
    //         FROM vehiculos v,hojatrabajo h, pre_prerevision p 
    //         WHERE 
    //         v.idvehiculo = h.idvehiculo AND (h.estadototal <> 5 AND h.estadototal <> 1) AND 
    //         v.numero_placa = p.numero_placa_ref AND  p.actualizado = 1 AND 
    //         DATE_FORMAT(h.fechainicial,'%Y-%m-%d') != DATE_FORMAT(p.fecha_prerevision,'%Y-%m-%d') AND 
    //         DATE_FORMAT(p.fecha_prerevision,'%Y-%m-%d') BETWEEN '2024-06-01' AND '2024-06-25' limit 200
    // EOF;
    //         $rta = $this->db->query($consulta);
    //     }

    function dataTh($marca, $temperatura, $humedad, $conectado, $idTh)
    {
        // echo "Marca: $marca - Temp: $temperatura - Humedad: $humedad - Conectado: $conectado - IdTh: $idTh\n";
        $keyTh = "353E9D61B66D77CAE6BF97DE8F7CAWYJFLLD2D765SD4894165SD81SD";
        $this->db->query("UPDATE config_maquina c SET  c.parametro  = AES_ENCRYPT($temperatura,'$keyTh') WHERE c.idmaquina = $idTh AND c.tipo_parametro = 'Temperatura Ambiente'");
        $this->db->query("UPDATE config_maquina c SET  c.parametro  = AES_ENCRYPT($humedad,'$keyTh') WHERE c.idmaquina = $idTh AND c.tipo_parametro = 'Humedad Relativa'");
        $this->db->query("UPDATE config_maquina c SET  c.parametro  = AES_ENCRYPT(DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s'),'$keyTh') WHERE c.idmaquina = $idTh AND c.tipo_parametro = 'Last Update'");
        $this->db->query("UPDATE config_maquina c SET  c.parametro  = $conectado WHERE c.idmaquina = $idTh AND c.tipo_parametro = 'Conectado'");
    }

    function consultarImagen()
    {
        $consulta = <<<EOF
        SELECT * from imagenes_bd_.imagenes i where i.idprueba = 397020 
EOF;
        $rta = $this->db->query($consulta);
        return $rta;
    }


    function createModoTransporte()
    {
        //$this->ajustarFechaPrerevision();
        $fields = array(
            'idmodoTransporte' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'modo_transporte' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => TRUE,
            ),
            'observaciones' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),

        );
        $this->myforge->add_key('idmodoTransporte', TRUE);
        $this->myforge->add_field($fields);
        $attributes = array('ENGINE' => 'MyISAM');
        $this->myforge->create_table('modotransporte', TRUE, $attributes);

        $data = array(
            array(
                'idmodoTransporte' => 1,
                'modo_transporte' => 'TRANSPORTE PÚBLICO COLECTIVO',
                'observaciones' => 'Tranporte publico colectivo'
            ),
            array(
                'idmodoTransporte' => 2,
                'modo_transporte' => 'TRANSPORTE PÚBLICO INDIVIDUAL',
                'observaciones' => 'Taxis'
            ),
            array(
                'idmodoTransporte' => 3,
                'modo_transporte' => 'TRANSPORTE ESCOLAR',
                'observaciones' => NULL
            ),
            array(
                'idmodoTransporte' => 4,
                'modo_transporte' => 'TRANSPORTE DE CARGA',
                'observaciones' => NULL
            ),
            array(
                'idmodoTransporte' => 5,
                'modo_transporte' => 'TRANSPORTE TRONCAL',
                'observaciones' => 'Vehículos de transporte publico perteneciente a las rutas troncales (articulado y biarticulados)'
            ),
            array(
                'idmodoTransporte' => 6,
                'modo_transporte' => 'TRANSPORTE DE ALIMENTADORES',
                'observaciones' => 'Vehículos de transporte publico perteneciente a las rutas alimentadoras'
            ),
            array(
                'idmodoTransporte' => 7,
                'modo_transporte' => 'TRANSPORTE ZONAL',
                'observaciones' => 'Vehículos de transporte publico perteneciente al SITP'
            ),
            array(
                'idmodoTransporte' => 8,
                'modo_transporte' => 'PÚBLICO COLECTIVO INTERMUNICIPAL',
                'observaciones' => NULL
            ),
            array(
                'idmodoTransporte' => 9,
                'modo_transporte' => 'Vehiculos de emergencia, seguridad, servicios',
                'observaciones' => NULL
            ),
            array(
                'idmodoTransporte' => 10,
                'modo_transporte' => 'TRANSPORTE PARTICULAR',
                'observaciones' => NULL
            ),
            array(
                'idmodoTransporte' => 11,
                'modo_transporte' => 'MIXTO',
                'observaciones' => 'Uso particular y carga, camionetas de carga con placa amarilla'
            )
        );

        // Insert batch
        $this->db->insert_batch('modotransporte', $data);
    }
}
