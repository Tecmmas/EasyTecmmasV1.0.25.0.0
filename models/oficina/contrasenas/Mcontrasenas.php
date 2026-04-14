<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mcontrasenas extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getuser($iduser) {
        $query = $this->db->query("SELECT u.IdUsuario, u.idperfil, u.nombres, u.apellidos, u.fecha_actualizacion FROM usuarios u WHERE u.IdUsuario = $iduser");
        return $query;
    }

    public function getpassword($iduser, $contrasenna) {
        if ($iduser == 0) {
            $query = $this->db->query("SELECT * FROM historico_pass h WHERE  h.password='$contrasenna'");
        } else {
            $query = $this->db->query("SELECT * FROM historico_pass h WHERE h.idusuario=$iduser AND h.password='$contrasenna'");
        }

        return $query;
    }

    public function updatecontraadmin($iduser, $contrasenna) {
        
        $query = $this->db->query("UPDATE usuarios  SET fecha_actualizacion = DATE_ADD(DATE_FORMAT(NOW(), '%Y/%m/%d'), INTERVAL 15 DAY), passwd='$contrasenna', userUpdate = '$iduser'   WHERE IdUsuario= $iduser");
        $this->encripta($iduser);
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    public function insertcontraadmin($iduser, $contrasenna) {
        $query = $this->db->query("INSERT INTO historico_pass VALUES (NULL,$iduser,CURRENT_TIMESTAMP(),'$contrasenna')");
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    public function updatecontra($iduser, $contrasenna, $desactivarOpe) {
        if ($desactivarOpe == '1') {
            $query = $this->db->query("UPDATE usuarios  SET fecha_actualizacion = DATE_ADD(DATE_FORMAT(NOW(), '%Y/%m/%d'), INTERVAL 8 DAY), passwd='$contrasenna',estado='0', userUpdate = '$iduser'  WHERE IdUsuario= $iduser");
        } else {
            $query = $this->db->query("UPDATE usuarios  SET fecha_actualizacion = DATE_ADD(DATE_FORMAT(NOW(), '%Y/%m/%d'), INTERVAL 30 DAY), passwd='$contrasenna', userUpdate = '$iduser'  WHERE IdUsuario= $iduser");
        }
        $this->encripta($iduser);
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    public function insertcontra($iduser, $contrasenna) {
        $query = $this->db->query("INSERT INTO historico_pass VALUES (NULL,$iduser,CURRENT_TIMESTAMP(),'$contrasenna')");
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    public function updateContraVindex($numero, $contrasena) {
        $consulta = <<<EOF
               SELECT u.IdUsuario,
                    u.tipo_identificacion,
                    u.idperfil,
                    u.nombres,
                    u.apellidos,
                    u.identificacion,
                    u.username,
                    u.estado,
                AES_DECRYPT(u.passwd,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c') as 'passwd',
                    u.fecha_actualizacion FROM usuarios u WHERE u.identificacion = $numero
EOF;
        $rta = $this->db->query($consulta);
        if ($rta->num_rows() > 0) {
            $rta = $rta->result();
            foreach ($rta as $v) {
                $iduser = $v->IdUsuario;
                $idperfil = $v->idperfil;
                $contrasenaOld = $v->passwd;
                if ($idperfil == 1 || $idperfil == 3) {
                    $this->updatecontraadmin($iduser, $contrasena);
                    $this->insertcontraadmin($iduser, $contrasenaOld);
                    //$this->encripta($iduser);
                } else {
                    $this->updatecontra($iduser, $contrasena, $desactivarOpe = '0');
                    $this->insertcontra($iduser, $contrasenaOld);
                    //$this->encripta($iduser);
                }
//                $iduser = $rta[0]->IdUsuario;
//                $idperfil = $rta[0]->idperfil;
//                $contrasenaOld = $rta[0]->passwd;
//                if ($idperfil == 1 || $idperfil == 3) {
//                    $this->updatecontraadmin($iduser, $contrasena);
//                    $this->insertcontraadmin($iduser, $contrasenaOld);
//                    //$this->encripta($iduser);
//                } else {
//                    $this->updatecontra($iduser, $contrasena);
//                    $this->insertcontra($iduser, $contrasenaOld);
//                    //$this->encripta($iduser);
//                }
            }
            return 1;
        } else {
            return 'No se encontro un usuario con ese numero de documento.';
        }
    }

    public function encripta($iduser) {
        $consulta = <<<EOF
               UPDATE usuarios u SET u.passwd =  AES_ENCRYPT(u.passwd,'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQSflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c')
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
