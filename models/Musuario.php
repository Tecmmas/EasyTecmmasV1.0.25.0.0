<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Musuario extends CI_Model {

    function __construct() {
        parent::__construct();
    }

//    function getUsuario($usuario, $contrasena) {
//
//
//
//
//        $query = $this->db->query("SELECT if(u.fecha_actualizacion < CURDATE(), 'AC','') AS 'fecha',
//                                        u.*,(SELECT c.nombre_cda FROM cda c LIMIT 1) cda
//                                    FROM 
//                                        usuarios u
//                                    WHERE
//                                        u.username='$usuario' and u.passwd='$contrasena'");
//        return $query;
//
////        $this->db->where('username', $usuario);
////        $this->db->where('passwd', $contrasena);
////        $query = $this->db->get('usuarios');
////        return $query;
//    }

    function getUsuario($usuario, $contrasena) {
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
                    (SELECT if(u.fecha_actualizacion < CURDATE(), 'AC','')) AS 'fecha',
                    JSON_CONTAINS(
                    JSON_OBJECT(
                    'IdUsuario',CAST(u.IdUsuario AS CHAR(100000)),
                    'tipo_identificacion',CAST(u.tipo_identificacion AS CHAR(100000)),
                    'idperfil',CAST(u.idperfil AS CHAR(100000)),
                    'nombres',CAST(u.nombres AS CHAR(100000)),
                    'apellidos',CAST(u.apellidos AS CHAR(100000)),
                    'identificacion',CAST(u.identificacion AS CHAR(100000)),
                    'username',CAST(u.username AS CHAR(100000)),
                    'estado',CAST(u.estado AS CHAR(100000)),
                    'fecha_actualizacion',CAST(u.fecha_actualizacion AS CHAR(100000))
                    ),
                    AES_DECRYPT(u.enc,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c')) autentico,
                    AES_DECRYPT(u.passwd,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c') passwd,
                   (SELECT c.nombre_cda FROM cda c ORDER BY 1 DESC LIMIT 1 ) cda,
                    u.equipo_asignado,
                    userUpdate
                    FROM 
                    usuarios u 
                    WHERE 
                    u.username = '$usuario' and AES_DECRYPT(u.passwd,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c') = '$contrasena';
EOF;
        $rta = $this->db->query($consulta);
        return $rta;
    }

    function getUsuarioId($id) {
       $consulta = <<<EOF
               SELECT u.nombres,u.apellidos,u.identificacion FROM usuarios u WHERE u.IdUsuario=$id
EOF;
        $rta = $this->db->query($consulta);
        return $rta;
    }

    function getOpciones($id) {
        $this->db->where('idusuario', $id);
        $query = $this->db->get('usr_opcion');
        return $query;
    }

    function actualizarOpcion($opcion) {
        if (!$this->buscarOpcion($opcion)) {
            return $this->db->insert('usr_opcion', $opcion);
        } else {
            $this->db->where('idusuario', $opcion['idusuario']);
            $this->db->where('nombre', $opcion['nombre']);
            return $this->db->update('usr_opcion', $opcion);
        }
    }

    function buscarOpcion($opcion) {
        $this->db->where('idusuario', $opcion['idusuario']);
        $this->db->where('nombre', $opcion['nombre']);
        $query = $this->db->get('usr_opcion');
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return FALSE;
        }
    }

    private function BuscarTablaOpciones() {
        $data = $this->db->query("
            show tables like '%usr_opcion%' ");
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    function CrearTablaOpciones() {
        if (!$this->BuscarTablaOpciones()) {
            try {
                $query = "CREATE TABLE `usr_opcion` (
                            `idusr_opcion` INT(11) NOT NULL AUTO_INCREMENT,
                            `idusuario` INT(11) NOT NULL,
                            `nombre` VARCHAR(45) NOT NULL,
                            `valor` VARCHAR(45) NOT NULL,
                            PRIMARY KEY (`idusr_opcion`))
                          ENGINE = MyISAM;";
                $this->db->query($query);
            } catch (Exception $ex) {
                echo($ex->getMessage());
                return false;
            }
        }
    }

}
