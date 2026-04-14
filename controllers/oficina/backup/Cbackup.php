<?php

defined("BASEPATH") or exit("No direct script access allowed");
header("Access-Control-Allow-Origin: *");
ini_set("memory_limit", "-1");
set_time_limit(9000);

class Cbackup extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("form");
        $this->load->helper("url");
        $this->load->helper("security");
        $this->load->helper('download');
        $this->load->helper('download');
        $this->load->model("oficina/reportes/informefugascal/Minformes");
        $this->load->model("oficina/backup/Mbackup");
        $this->load->library('Opensslencryptdecrypt');
        $this->load->dbforge();
        $this->load->dbutil();
        espejoDatabase();
    }

    var $versionMaria;
    var $ipRestBackup;
    var $sistemaOperativo = "";

    public function index()
    {
        if ($this->session->userdata("IdUsuario") == "" || $this->session->userdata("IdUsuario") == "1024") {
            redirect("Cindex");
        }
        date_default_timezone_set('America/bogota');
        $date = date("Y");
        $this->createtable();
        $this->setConf();
        $version = $this->versionMaria;
        if (!empty($version)) {
            $rtamaria = $version;
            $rta['dateactu'] = date("Y-m-d");
            $rta['rtamaria'] = $rtamaria;
            $rta['date'] = $date;
            $this->load->view('oficina/backup/Vbackup', $rta);
        } else {
            $rta['message'] = 'La configuración no es correcta, por favor comunícate con el área de soporte.';
            $rta['heading'] = 'Error de configuración';
            $this->load->view('errors/html/error_general.php', $rta);
        }
        $this->sistemaOperativo = sistemaoperativo();
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            if (!is_dir('/var/www/html/BACKUPS' . $date)) {
                mkdir('/var/www/html/BACKUPS' . $date, 0777, true);
            }
        } else {
            if (!is_dir('C:\BACKUPS' . $date)) {
                mkdir('C:\BACKUPS' . $date, 0777, true);
            }
        }
    }

    private function setConf()
    {
        $conf = @file_get_contents("system/oficina.json");
        if (isset($conf)) {
            $encrptopenssl = new Opensslencryptdecrypt();
            $json = $encrptopenssl->decrypt($conf, true);
            $dat = json_decode($json, true);
            if ($dat) {
                foreach ($dat as $d) {
                    if ($d['nombre'] == "versionMaria") {
                        $this->versionMaria = $d['valor'];
                    }
                    if ($d['nombre'] == "ipRestBackup") {
                        $this->ipRestBackup = $d['valor'];
                    }
                }
            }
        }
    }

//     function createcronbak()
// {
//     $this->sistemaOperativo = sistemaoperativo();
//     date_default_timezone_set('America/bogota');
//     $date2 = date("Y-m-d");
//     $rtamaria = $this->input->post('rtamaria');
//     $date = $this->input->post('date');
//     $rta['cda'] = $this->infocda();
//     $cadena = $rta['cda']->nombre_cda;
//     $nombrecda = $this->formato_texto($cadena);
    
//     $namebackup = $nombrecda . '-' . $date2;
    
//     if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
//         // PARTE LINUX - SIN CAMBIOS
//         $folder = "/var/www/html/BACKUPS$date/$nombrecda";
//         $data = "var/www/html/et/system/";
//         $cadena = "mysqldump -v --opt --events --routines --triggers  -u backupres -p --password=tecmmas --databases tecmmas_bd imagenes_bd > $folder" . '-' . $date2 . ".sql";
//         $archivo = fopen('system/CRONBKNEW.sh', "w+b");
//         fwrite($archivo, $cadena);
//         fclose($archivo);
//         shell_exec('bash /var/www/html/et/system/CRONBKNEW.sh');
//         $permisos = "chmod 777 -R /var/www/html/BACKUPS$date";
//         shell_exec($permisos);
        
//         $this->inserdatabackup($namebackup, $folder);
        
//     } else {
//         // PARTE WINDOWS - MODIFICADA PARA CAPTURAR ERRORES
//         $folder = "C:/BACKUPS$date";
//         $data = "C:/Program Files/" . $rtamaria . "/bin";

//         // Crear directorio si no existe
//         if (!is_dir($folder)) {
//             mkdir($folder, 0777, true);
//         }

//         // Nombre de archivo seguro
//         $safeNombrecda = preg_replace('/[^a-zA-Z0-9_-]/', '_', $nombrecda);
//         $backupFile = $folder . "\\" . $safeNombrecda . "-" . $date2 . ".sql";

//         // Crear BAT
//         $cadena = "@echo off
// chcp 65001 > nul
// cd /d \"$data\"
// \"mysqldump.exe\" -v --opt --events --routines --triggers -u root -pmSWibf7KTGfesnhp --databases tecmmas_bd imagenes_bd --result-file=\"$backupFile\"
// exit /b %errorlevel%";

//         file_put_contents('system/CRONBKNEW.bat', $cadena);

//         // Ejecutar y capturar output y código de error
//         $output = shell_exec('system\CRONBKNEW.bat 2>&1');
//         $returnCode = 0;
//         exec('system\CRONBKNEW.bat 2>&1', $outputArray, $returnCode);

//         // Verificar si hubo error
//         if ($returnCode !== 0 || !file_exists($backupFile)) {
//             // HUBO ERROR - Retornar el mensaje de error
//             $errorMessage = "Error en backup: Código $returnCode";
//             if (!empty($output)) {
//                 $errorMessage .= " - " . $output;
//             }
//             if (!file_exists($backupFile)) {
//                 $errorMessage .= " - Archivo no creado: $backupFile";
//             }
//             echo json_encode(["error" => $errorMessage]);
//             return; // Salir de la función sin llamar a inserdatabackup
//         } else {
//             // TODO BIEN - Continuar con el proceso normal
//             $this->inserdatabackup($namebackup, $folder);
//         }
//     }
    
// }

    function createcronbak()
    {
        $this->sistemaOperativo = sistemaoperativo();
        date_default_timezone_set('America/bogota');
        $date2 = date("Y-m-d");
        $rtamaria = $this->input->post('rtamaria');
        $date = $this->input->post('date');
        $rta['cda'] = $this->infocda();
        $cadena = $rta['cda']->nombre_cda;
        $nombrecda = $this->formato_texto($cadena);
        /* $folder = "C:/BACKUPS$date/$nombrecda";
        $data = "C:/Program Files/" . $rtamaria . "/bin";
        $cadena = "cd $data
                    mysqldump -v --opt --events --routines --triggers  -u backupres -p --password=tecmmas --databases tecmmas_bd imagenes_bd > $folder" . '-' . $date2 . ".sql
                    exit";
        $archivo = fopen('system/CRONBKNEW.bat', "w+b");
        fwrite($archivo, $cadena);
        fclose($archivo);
        shell_exec('start C:\Apache24\htdocs\et\system\CRONBKNEW.bat'); */
        //        shell_exec('start C:\Apache24\htdocs\informes\system\CRONBKNEW.bat');
        $namebackup = $nombrecda . '-' . $date2;
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            $folder = "/var/www/html/BACKUPS$date/$nombrecda";
            $data = "var/www/html/et/system/";
            $cadena = "mysqldump -v --opt --events --routines --triggers  -u backupres -p --password=tecmmas --databases tecmmas_bd imagenes_bd > $folder" . '-' . $date2 . ".sql";
            $archivo = fopen('system/CRONBKNEW.sh', "w+b");
            fwrite($archivo, $cadena);
            fclose($archivo);
            //shell_exec('start  wine cmd');
            //shell_exec('/var/www/html/et/system/CRONBKNEW.sh');
            shell_exec('bash /var/www/html/et/system/CRONBKNEW.sh');
            $permisos = "chmod 777 -R /var/www/html/BACKUPS$date";
            shell_exec($permisos);
        } else {
            $folder = "C:/BACKUPS$date/$nombrecda";
            $data = "C:/Program Files/" . $rtamaria . "/bin";
            $cadena = "cd $data
                    mysqldump -v --opt --events --routines --triggers  -u backupres -p --password=tecmmas --databases tecmmas_bd imagenes_bd > $folder" . '-' . $date2 . ".sql
                    exit";
            $archivo = fopen('system/CRONBKNEW.bat', "w+b");
            fwrite($archivo, $cadena);
            fclose($archivo);
            shell_exec('start C:\Apache24\htdocs\et\system\CRONBKNEW.bat');
        }
        $this->inserdatabackup($namebackup, $folder);
    }

    public function createtable()
    {
        $fields = array(
            'idbackup' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'nombre' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE,
            ),
            'usuario' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE,
            ),
            'html' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'usuariores' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
            ),
            'res' => array(
                'type' => 'INT',
                'null' => TRUE,
            ),
            'fechageneracion' => array(
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ),
            'fecharestauracion' => array(
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ),
        );
        $this->dbforge->add_key('idbackup', TRUE);
        $this->dbforge->add_field($fields);
        $attributes = array('ENGINE' => 'MyISAM');
        $this->dbforge->create_table('backup', TRUE, $attributes);
    }

    //inserta los datos del backup en la tabla local y servidor cliente
    public function inserdatabackup($namebackup, $folder)
    {
        $dominio = file_get_contents('system/dominio.dat', true);
        $usuario = $this->session->userdata("IdUsuario");
        //        $usuario = 1;
        $data = substr($folder, 0, 14);
        $nombre['rta'] = $this->usuario_prueba($usuario);
        $user = $nombre['rta']->nombre_user;
        $cadena = $nombre['rta']->nombre_user;
        $usercad = $this->formato_texto($cadena);
        $rta = $this->Mbackup->inserbackup($namebackup, $user);
        if ($rta == 1) {
            $url = 'http://' . $dominio . '/cda/index.php/Cbackupserver' . '?namebackup=' . $namebackup . '&user=' . $usercad;
            file_get_contents($url);
            echo json_encode($data);
        }
    }

    function infoBackup()
    {
        $rta = $this->Mbackup->gettable();
        echo json_encode($rta);
    }

    //crea el .bat de restauracion
    public function regresbackup()
    {
        $this->sistemaOperativo = sistemaoperativo();
        date_default_timezone_set('America/bogota');
        $date2 = date("d-m-Y");
        $this->setConf();
        $idbackup = $this->input->post('idbackup');
        $namebackup = $this->input->post('namebackup');
        $rtamaria = $this->input->post('rtamaria');
        $date = $this->input->post('date');
        if ($this->sistemaOperativo == null || $this->sistemaOperativo == "") {
            $ipRestBackup = $this->ipRestBackup;
            //$folder = "C:/BACKUPS$date/$namebackup";
            $folder = "/var/www/html/BACKUPS$date/$namebackup";
            //$folder = "/home/servertecmmas/Documents/BACKUPS$date/$namebackup";
            //$data = "C:/Program Files/$rtamaria/bin";
            if (!empty($ipRestBackup)) {
                $cadena = "mysql -u root --password=tecmmas --host=$ipRestBackup  < $folder.sql";
                $archivo = fopen('system/RESTBACKUP.sh', "w+b");
                fwrite($archivo, $cadena);
                fclose($archivo);
                //            shell_exec('start C:\Apache24\htdocs\informes\system\RESTBACKUP.bat');
                shell_exec('bash /var/www/html/et/system/RESTBACKUP.sh');
                $this->validaterestore($idbackup, $namebackup);
            } else {
                $this->error('La ip del servidor de respaldo no ha sido asignada, por favor comunicarse con el área de soporte');
            }
        } else {
            $ipRestBackup = $this->ipRestBackup;
            $folder = "C:/BACKUPS$date/$namebackup";
            $data = "C:/Program Files/$rtamaria/bin";
            if (!empty($ipRestBackup)) {
                $cadena = "cd $data
                        mysql -u root --password=tecmmas --host=$ipRestBackup  < $folder.sql
                        exit";
                $archivo = fopen('system/RESTBACKUP.bat', "w+b");
                fwrite($archivo, $cadena);
                fclose($archivo);
                //            shell_exec('start C:\Apache24\htdocs\informes\system\RESTBACKUP.bat');
                shell_exec('start C:\Apache24\htdocs\et\system\RESTBACKUP.bat');
                $this->validaterestore($idbackup, $namebackup);
            } else {
                $this->error('La ip del servidor de respaldo no ha sido asignada, por favor comunicarse con el área de soporte');
            }
        }
    }

    // valida la restauracion
    public function validaterestore($idbackup, $namebackup)
    {
        $usuario = $this->session->userdata("IdUsuario");
        $dominio = file_get_contents('system/dominio.dat', true);
        //        $usuario = 1;
        $nombre['rta'] = $this->usuario_prueba($usuario);
        $user = $nombre['rta']->nombre_user;
        $cadena = $nombre['rta']->nombre_user;
        $usercad = $this->formato_texto($cadena);
        $data = substr($namebackup, -10);
        $rtalocal = $this->Mbackup->getresul_local();
        $rtarespaldo = $this->Mbackup->getresul_respaldo();
        if (!is_string($rtalocal)) {
            $rta = $this->Mbackup->getplacas($data);
            $delimiter = ";";
            $newline = "\r\n";
            $html = $this->dbutil->csv_from_result($rta, $delimiter, $newline);
            $datares = $this->Mbackup->Updatebackup($html, $user, $idbackup);
            if ($datares == 1) {
                $html2 = $this->formato_texto($html);
                $url = 'http://' . $dominio . '/cda/index.php/Cbackupserver/updatebackup' . '?html2=' . $html2 . '&usercad=' . $usercad . '&idbackup=' . $idbackup;
                file_get_contents($url);
                $r = [
                    "data" => $data,
                    "respuesta" => 1,
                ];
                echo json_encode($r);
            } else {
                $r = [
                    "data" => "",
                    "respuesta" => 2,
                ];
                echo json_encode($r);
            }
        } else {
            //            echo $rtalocal;
            //            $mensaje = 'Error al comparar la información la cantidad de registros de las dos bases de datos no concuerda.
            //                        Baselocal=' . $rtalocal . ' ' . 'Baseres=' . $rtarespaldo;
            $mensaje = $rtalocal;
            $datares = $this->Mbackup->Updatebackup($mensaje, $user, $idbackup);
            if ($datares == 1) {
                $html2 = $this->formato_texto($mensaje);
                $url = 'http://' . $dominio . '/cda/index.php/Cbackupserver/updatebackup' . '?html2=' . $html2 . '&usercad=' . $usercad . '&idbackup=' . $idbackup;
                file_get_contents($url);
            } else {
                $r = [
                    "data" => "",
                    "respuesta" => 3,
                ];
                echo json_encode($r);
            }
            $r = [
                "data" => "",
                "respuesta" => 4,
            ];
            echo json_encode($r);
        }
    }

    // carga las placas que fueron restauradas
    public function infoplacas()
    {
        $rta = $this->Mbackup->getplacas($data = $this->input->post('data'));
        $res = $rta->result();
        echo json_encode($res);
    }

    //carga los backups generados
    public function gettable()
    {
        $rta = $this->Mbackup->gettable();
        echo json_encode($rta);
    }

    //carga la vista del reporte
    public function viewreportbackup()
    {
        $this->load->view('oficina/backup/Vreporbackup');
    }

    //genera el reporte del backup
    public function reporbackup()
    {
        date_default_timezone_set('America/bogota');
        $date = date("d-m-Y");
        $fechainicial = $this->input->post('fechainicial');
        $fechafinal = $this->input->post('fechafinal');
        $query = $this->Mbackup->informe_backup($fechainicial, $fechafinal);
        $delimiter = ";";
        $newline = "\r\n";
        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        $nombre = 'REPORTE BACKUP ' . $date . ' ' . '.csv';
        force_download($nombre, $data);
    }

    //consulta la informacion del cda
    function infocda()
    {
        $data = $this->Minformes->infocda();
        $rta = $data->result();
        return $rta[0];
    }

    //usuarioprueba
    public function usuario_prueba($usuario)
    {
        $data = $this->Minformes->usuario_prueba($usuario);
        $rta = $data->result();
        return $rta[0];
    }

    private function formato_texto($cadena)
    {
        $no_permitidas = array("Ñ", "ñ", "á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹", "'", "", " ", ".");
        $permitidas = array("N", "n", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E", "_", "_");
        $texto = str_replace($no_permitidas, $permitidas, $cadena);
        return $texto;
    }

    private function error($mensaje)
    {
        $this->session->set_flashdata('error', $mensaje);
        redirect("oficina/backup/Cbackup");
    }

    function pruebaresult()
    {
        echo $rtalocal = $this->Mbackup->getresul_local();
    }
}
