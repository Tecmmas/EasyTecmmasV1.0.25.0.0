<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Musuarios extends CI_Model {

    var $key = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c";

    function __construct() {
        parent::__construct();
    }

    public function infoUsuarios() {
        $data = $this->db->query("SELECT u.IdUsuario, u.nombres, u.apellidos, u.identificacion,
                                p.nombre AS perfil,
                                IF(u.estado = 1, 'Activo','Inactivo') AS estado 
                                FROM usuarios u, perfiles p
                                WHERE u.idperfil=p.idperfil");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function getUsuarios($idusuario) {
        if ($idusuario) {
            $where = "AND u.IdUsuario=$idusuario";
        } else {
            $where = "ORDER BY 1 DESC LIMIT 1";
        }
        $data = $this->db->query("SELECT u.IdUsuario,  u.nombres, u.apellidos, u.identificacion,u.username AS usuario,
                               AES_DECRYPT(u.passwd,'$this->key') as 'passwd',
                                p.nombre AS perfil,
                                p.idperfil AS idperfil,
                                IFNULL((SELECT t.nombre FROM tipo_identificacion t  WHERE u.tipo_identificacion = t.tipo_identificacion LIMIT 1),'---') AS nombreidentificacion,
                                IFNULL((SELECT t.tipo_identificacion FROM tipo_identificacion t  WHERE u.tipo_identificacion = t.tipo_identificacion LIMIT 1),'---') AS tipoidentificacion,
                                IF(u.estado = 1, 'Activo','Inactivo') AS estado,
                                IF(u.estado = 1, 1, 0) AS idestado,
                                IFNULL(u.equipo_asignado,'') AS equipo_asignado,
                                u.biometrico
                                FROM usuarios u, perfiles p
                                WHERE u.idperfil=p.idperfil $where");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        }
    }

    function insert($tipo_identificacion, $identificacion, $nombres, $apellidos, $idperfil, $username, $passwd, $estado,$equipo_asignado, $idusuarioUpdate, $base64Huella) {
        if ($idperfil == 1) {
            $data = $this->db->query("INSERT usuarios VALUES (Null,$tipo_identificacion,$idperfil,'$nombres','$apellidos',$identificacion,'$username','$passwd',$estado,DATE_ADD(DATE_FORMAT(NOW(), '%Y-%m-%d'), INTERVAL 15 DAY),'0','$equipo_asignado', $idusuarioUpdate, '$base64Huella') ");
            $this->encripta($this->db->insert_id());
        } else {
            $data = $this->db->query("INSERT usuarios VALUES (Null,$tipo_identificacion,$idperfil,'$nombres','$apellidos',$identificacion,'$username','$passwd',$estado,DATE_ADD(DATE_FORMAT(NOW(), '%Y-%m-%d'), INTERVAL 30 DAY),'0','$equipo_asignado', $idusuarioUpdate, '$base64Huella') ");
            $this->encripta($this->db->insert_id());
        }
    }

    function update($IdUsuario, $tipo_identificacion, $identificacion, $nombres, $apellidos, $idperfil, $username, $passwd, $estado, $contrasenaold,$equipo_asignado, $idusuarioUpdate, $base64Huella) {
        $data = $this->db->query("UPDATE usuarios u 
                                    SET u.tipo_identificacion=$tipo_identificacion ,u.idperfil=$idperfil ,u.nombres='$nombres',u.apellidos='$apellidos',u.identificacion=$identificacion ,
                                    u.username='$username',u.passwd='$passwd',u.estado= $estado,u.fecha_actualizacion = u.fecha_actualizacion,u.equipo_asignado='$equipo_asignado', 
                                    u.userUpdate = $idusuarioUpdate, u.biometrico = '$base64Huella'
                                    WHERE u.IdUsuario=$IdUsuario");
        $this->insertcontrasenaold($IdUsuario, $contrasenaold);
        $this->encripta($IdUsuario);
    }

    function insertcontrasenaold($IdUsuario, $contrasenaold) {
        $query = $this->db->query("INSERT INTO historico_pass VALUES (NULL,$IdUsuario,CURRENT_TIMESTAMP(),'$contrasenaold')");
    }

    function gettipoIdentificacion($tipo_identificacion) {
        $data = $this->db->query("SELECT t.nombre FROM tipo_identificacion t WHERE t.tipo_identificacion=$tipo_identificacion");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data[0]->nombre;
        }
    }

    function gettipoIdperfil($idperfil) {
        $data = $this->db->query("SELECT p.nombre FROM perfiles p WHERE p.idperfil=$idperfil");
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data[0]->nombre;
        }
    }

    public function encripta($iduser) {
        $consulta = <<<EOF
               UPDATE usuarios u SET u.passwd =  AES_ENCRYPT(u.passwd,'$this->key')
               WHERE u.IdUsuario = $iduser
EOF;
        $rta = $this->db->query($consulta);
//        $consulta = <<<EOF
//               UPDATE usuarios u SET 
//u.enc = 
//AES_ENCRYPT(CONCAT('{"IdUsuario"',': "', u.IdUsuario, '"',
//', "tipo_identificacion"',': "', u.tipo_identificacion, '"',
//', "idperfil"',': "', u.idperfil, '"',
//', "nombres"',': "', u.nombres,'"',
//', "apellidos"',': "', u.apellidos, '"',
//', "identificacion"',': "', u.identificacion, '"',
//', "username"',': "', u.username,'"',
//', "estado"',': "', u.estado, '"',
//', "fecha_actualizacion"',': "', u.fecha_actualizacion, '"}'),
//'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c')
//                WHERE u.IdUsuario = $iduser
//EOF;
//        $rta = $this->db->query($consulta);
    }

}
