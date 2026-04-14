<?php

defined("BASEPATH") or exit("No direct script access allowed");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}
ini_set("memory_limit", "-1");
set_time_limit(300);

class Cci2 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("dominio/MEventosindra");
    }

    private $configuracion = [];

    public function index()
    {
    }

    private function setConf()
    {
        $conf = @file_get_contents("system/oficina.json");
        if (isset($conf)) {
            $encrptopenssl = new Opensslencryptdecrypt();
            $json          = $encrptopenssl->decrypt($conf, true);
            $dat           = json_decode($json, true);
            if ($dat) {
                foreach ($dat as $d) {
                    if ($d['nombre'] == "idCdaRUNT") {
                        $this->configuracion['idCdaRUNT'] = $d['valor'];
                    }
                    if ($d['nombre'] == "ipSicov") {
                        $this->configuracion['ipSicov'] = $d['valor'];
                    }
                    if ($d['nombre'] == "sicovModoAlternativo") {
                        $this->configuracion['sicovModoAlternativo'] = $d['valor'];
                    }
                    if ($d['nombre'] == "ipSicovAlternativo") {
                        $this->configuracion['ipSicovAlternativo'] = $d['valor'];
                    }
                    if ($d['nombre'] == "usuarioSicov") {
                        $this->configuracion['usuarioSicov'] = $d['valor'];
                    }
                    if ($d['nombre'] == "claveSicov") {
                        $this->configuracion['claveSicov'] = $d['valor'];
                    }
                }
            }
        }
    }

    //Recupera una Placa asociada a un PIN que se encuentre en estado Disponible.
    public function consulta_pin()
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->setConf();
        $url = 'http://' . $this->configuracion['ipSicov'] . '/fur/api/v1/rest/consulta_pin';
        $eco = json_decode($this->eco(), true);
        if (! $eco['success'] || $eco['ws_ecoResult'] !== 'OK') {
            echo json_encode([
                'success' => false,
                'mensaje' => ($eco['mensaje'] ?? 'Respuesta inesperada'),
            ], JSON_UNESCAPED_UNICODE);
            return;
        }
        $dataPIN = json_decode($this->input->raw_input_stream, true) ?? [];
        $data    = array_merge($dataPIN, [
            'usuario' => $this->configuracion['usuarioSicov'],
            'clave'   => $this->configuracion['claveSicov'],
        ]);
        $options = [
            'http' => [
                'header'        => "Content-Type: application/json\r\n",
                'method'        => 'POST',
                'content'       => json_encode($data),
                'ignore_errors' => true, // Para capturar respuestas de error HTTP
            ],
        ];
        $context  = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);

        $result = json_decode($response, true);
        if (isset($result['data'])) {
            $fecha           = $result['data']['fechaTransaccion'];
            $hora            = $result['data']['horaTransaccion'];
            $codigo          = $result['data']['codigoRespuesta'];
            $mensaje         = $result['data']['mensajeRespuesta'];
            $mensajeArray    = explode('|', $mensaje) ?? $mensaje;
            $placaConsultada = "";
            if ($codigo == '2007') {
                $datosPlaca = explode("@", $mensajeArray[0]);
                if (is_array($datosPlaca)) {
                    $placaConsultada = $datosPlaca[1];
                }
            }
            $success = true;
            if ($codigo == '2007' && $placaConsultada != $data['pPlaca']) {
                $mensajeEvento = 'Los datos no coinciden con la placa consultada. ' . $this->mensajes($codigo, $mensaje);
                $success       = false;
            } elseif ($codigo == '2006') {
                $mensajeEvento = 'El PIN no ha sido quemado desde audiweb, por favor verifique la información: ' . $data['pPlaca'] . '|' . $data['pPin'];
                $success       = false;
            } else {
                $mensajeEvento = $this->mensajes($codigo, $mensaje);
            }
            $respuesta = [
                'success' => $success,
                'fecha'   => $fecha,
                'hora'    => $hora,
                'codigo'  => $codigo,
                'mensaje' => $mensajeEvento,
            ];
            $idelemento = $data['pPlaca'];
            $cadena     = "IdUsuario: " . $this->session->userdata('IdUsuario');
            $tipo       = "p";
            $enviado    = "1";
            $this->insertarEvento($idelemento, $cadena, $tipo, $enviado, $respuesta['mensaje']);
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'success' => false,
                'mensaje' => 'Respuesta inesperada de la API',
                'raw'     => $result,
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    private function consulta_pin_tiny($ipSicov, $usuarioSicov, $claveSicov, $pin, $placa)
    {
        $url  = 'http://' . $ipSicov . '/fur/api/v1/rest/consulta_pin';
        $data = [
            'usuario' => $usuarioSicov,
            'clave'   => $claveSicov,
            'pPin'    => $pin,
            'pPlaca'  => $placa,
        ];
        $options = [
            'http' => [
                'header'        => "Content-Type: application/json\r\n",
                'method'        => 'POST',
                'content'       => json_encode($data),
                'ignore_errors' => true, // Para capturar respuestas de error HTTP
            ],
        ];
        $context  = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);
        $result   = json_decode($response, true);
        if (isset($result['data'])) {
            $codigo = $result['data']['codigoRespuesta'];
            if ($codigo == '1006') {
                return false;
            }
            return true;
        }
        return false;
    }

    //Recupera un PIN que se encuentre en estado Disponible asociado a la placa
    public function consulta_pin_placa()
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->setConf();
        $url = 'http://' . $this->configuracion['ipSicov'] . '/fur/api/v1/rest/consulta-pin-placa';
        $eco = json_decode($this->eco(), true);
        if (! $eco['success'] || $eco['ws_ecoResult'] !== 'OK') {
            echo json_encode([
                'success' => false,
                'mensaje' => ($eco['mensaje'] ?? 'Respuesta inesperada'),
            ], JSON_UNESCAPED_UNICODE);
            return;
        }
        $dataPIN = json_decode($this->input->raw_input_stream, true) ?? [];
        $data    = array_merge($dataPIN, [
            'usuario' => $this->configuracion['usuarioSicov'],
            'clave'   => $this->configuracion['claveSicov'],
        ]);

        $options = [
            'http' => [
                'header'        => "Content-Type: application/json\r\n",
                'method'        => 'POST',
                'content'       => json_encode($data),
                'ignore_errors' => true, // Para capturar respuestas de error HTTP
            ],
        ];
        $context  = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);
        $result   = json_decode($response, true);

        if (isset($result['data'])) {
            $fecha   = $result['data']['fechaTransaccion'];
            $hora    = $result['data']['horaTransaccion'];
            $codigo  = $result['data']['codigoRespuesta'];
            $mensaje = $result['data']['mensajeRespuesta'];
            echo json_encode([
                'success' => true,
                'fecha'   => $fecha,
                'hora'    => $hora,
                'codigo'  => $codigo,
                'mensaje' => $this->mensajes($codigo, $mensaje),
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'mensaje' => 'Respuesta inesperada de la API',
                'raw'     => $result,
            ]);
        }
    }

    //Consulta los datos asociados a una placa desde el runt
    public function consulta_runt()
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->setConf();
        $url = 'http://' . $this->configuracion['ipSicov'] . '/fur/api/v1/rest/consulta_runt';
        $eco = json_decode($this->eco(), true);
        if (! $eco['success'] || $eco['ws_ecoResult'] !== 'OK') {
            echo json_encode([
                'success' => false,
                'mensaje' => ($eco['mensaje'] ?? 'Respuesta inesperada'),
            ], JSON_UNESCAPED_UNICODE);
            return;
        }
        $dataPIN = json_decode($this->input->raw_input_stream, true) ?? [];
        $data    = array_merge($dataPIN, [
            'usuario' => $this->configuracion['usuarioSicov'],
            'clave'   => $this->configuracion['claveSicov'],
        ]);

        $options = [
            'http' => [
                'header'        => "Content-Type: application/json\r\n",
                'method'        => 'POST',
                'content'       => json_encode($data),
                'ignore_errors' => true,
            ],
        ];
        $context  = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);

        $result = json_decode($response, true);
        if (isset($result['data'])) {
            $success                    = true;
            $codigo                     = $result['data']['ConsultaRUNTResult']['CodigoRespuesta'] ?? '';
            $mensaje                    = $result['data']['ConsultaRUNTResult']['MensajeRespuesta'] ?? '';
            $noPlaca                    = $result['data']['ConsultaRUNTResult']['noPlaca'] ?? '';
            $noChasis                   = $result['data']['ConsultaRUNTResult']['noChasis'] ?? '';
            $idMarca                    = $result['data']['ConsultaRUNTResult']['idMarca'] ?? '';
            $marca                      = $result['data']['ConsultaRUNTResult']['marca'] ?? '';
            $idLinea                    = $result['data']['ConsultaRUNTResult']['idLinea'] ?? '';
            $linea                      = $result['data']['ConsultaRUNTResult']['linea'] ?? '';
            $idTipoServicio             = $result['data']['ConsultaRUNTResult']['idTipoServicio'] ?? '';
            $tipoServicio               = $result['data']['ConsultaRUNTResult']['tipoServicio'] ?? '';
            $idColor                    = $result['data']['ConsultaRUNTResult']['idColor'] ?? '';
            $color                      = $result['data']['ConsultaRUNTResult']['color'] ?? '';
            $modelo                     = $result['data']['ConsultaRUNTResult']['modelo'] ?? '';
            $cilindraje                 = $result['data']['ConsultaRUNTResult']['cilindraje'] ?? '';
            $idTipoCombustible          = $result['data']['ConsultaRUNTResult']['idTipoCombustible'] ?? '';
            $tipoCombustible            = $result['data']['ConsultaRUNTResult']['tipoCombustible'] ?? '';
            $idClaseVehiculo            = $result['data']['ConsultaRUNTResult']['idClaseVehiculo'] ?? '';
            $claseVehiculo              = $result['data']['ConsultaRUNTResult']['claseVehiculo'] ?? '';
            $noMotor                    = $result['data']['ConsultaRUNTResult']['noMotor'] ?? '';
            $noVIN                      = $result['data']['ConsultaRUNTResult']['noVIN'] ?? '';
            $capacidadPasajerosSentados = $result['data']['ConsultaRUNTResult']['capacidadPasajerosSentados'] ?? '';
            $blindado                   = $result['data']['ConsultaRUNTResult']['blindado'] ?? '';
            $esEnsenanza                = $result['data']['ConsultaRUNTResult']['esEnsenanza'] ?? '';
            $fechaMatricula             = $result['data']['ConsultaRUNTResult']['fechaMatricula'] ?? '';
            $datosCdasRtm               = $result['data']['ConsultaRUNTResult']['datosCdasRtm'] ?? '';
            $soatNacionales             = $result['data']['ConsultaRUNTResult']['soatNacionales'] ?? '';
            $noPoliza                   = $result['data']['ConsultaRUNTResult']['datosSoat']['noPoliza'] ?? '';
            $fechaExpedicion            = $result['data']['ConsultaRUNTResult']['datosSoat']['fechaExpedicion'] ?? '';
            $fechaVigencia              = $result['data']['ConsultaRUNTResult']['datosSoat']['fechaVigencia'] ?? '';
            $fechaVencimiento           = $result['data']['ConsultaRUNTResult']['datosSoat']['fechaVencimiento'] ?? '';
            $entidadExpideSoat          = $result['data']['ConsultaRUNTResult']['datosSoat']['entidadExpideSoat'] ?? '';
            $estadoSoat                 = $result['data']['ConsultaRUNTResult']['datosSoat']['estado'] ?? '';
            if ($codigo != '0000') {
                $success = false;
            }
            echo json_encode([
                'success'                    => $success,
                'codigo'                     => $codigo,
                'mensaje'                    => $mensaje,
                'noPlaca'                    => $noPlaca,
                'noChasis'                   => $noChasis,
                'idMarca'                    => $idMarca,
                'marca'                      => $marca,
                'idLinea'                    => $idLinea,
                'linea'                      => $linea,
                'idTipoServicio'             => $idTipoServicio,
                'tipoServicio'               => $tipoServicio,
                'idColor'                    => $idColor,
                'color'                      => $color,
                'modelo'                     => $modelo,
                'cilindraje'                 => $cilindraje,
                'idTipoCombustible'          => $idTipoCombustible,
                'tipoCombustible'            => $tipoCombustible,
                'idClaseVehiculo'            => $idClaseVehiculo,
                'claseVehiculo'              => $claseVehiculo,
                'noMotor'                    => $noMotor,
                'noVIN'                      => $noVIN,
                'capacidadPasajerosSentados' => $capacidadPasajerosSentados,
                'blindado'                   => $blindado,
                'esEnsenanza'                => $esEnsenanza,
                'fechaMatricula'             => $fechaMatricula,
                'datosCdasRtm'               => $datosCdasRtm,
                'soatNacionales'             => $soatNacionales,
                'noPoliza'                   => $noPoliza,
                'fechaExpedicion'            => $fechaExpedicion,
                'fechaVigencia'              => $fechaVigencia,
                'fechaVencimiento'           => $fechaVencimiento,
                'entidadExpideSoat'          => $entidadExpideSoat,
                'estadoSoat'                 => $estadoSoat,
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'mensaje' => 'Respuesta inesperada de la API',
                'raw'     => $result,
            ]);
        }
    }

    //Quema el pin.
    public function utilizar_pin()
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->setConf();
        $url = 'http://' . $this->configuracion['ipSicov'] . '/fur/api/v1/rest/utilizar_pin';
        $eco = json_decode($this->eco(), true);
        if (! $eco['success'] || $eco['ws_ecoResult'] !== 'OK') {
            echo json_encode([
                'success' => false,
                'mensaje' => ($eco['mensaje'] ?? 'Respuesta inesperada'),
            ], JSON_UNESCAPED_UNICODE);
            return;
        }
        $dataPIN = json_decode($this->input->raw_input_stream, true);

        if (! $this->consulta_pin_tiny($this->configuracion['ipSicov'], $this->configuracion['usuarioSicov'], $this->configuracion['claveSicov'], $dataPIN['pPin'], $dataPIN['pPlaca'])) {
            $respuesta = [
                'success' => false,
                'codigo'  => '1006',
                'mensaje' => 'PIN no válido: El PIN no se encuentra en estado Disponible o no existe',
            ];
            $idelemento = $dataPIN['pPlaca'];
            $cadena     = "IdUsuario: " . $this->session->userdata('IdUsuario');
            $tipo       = "p";
            $enviado    = "1";
            $this->insertarEvento($idelemento, $cadena, $tipo, $enviado, $respuesta['mensaje']);
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            return;
        }
        // if (! is_array($dataPIN) || empty($dataPIN)) {
        //     $dataPIN = $this->input->post(null, true) ?: [];
        // }
        $data = array_merge($dataPIN, [
            'usuario' => $this->configuracion['usuarioSicov'],
            'clave'   => $this->configuracion['claveSicov'],
        ]);

        $options = [
            'http' => [
                'header'        => "Content-Type: application/json\r\n",
                'method'        => 'POST',
                'content'       => json_encode($data),
                'ignore_errors' => true, // Para capturar respuestas de error HTTP
            ],
        ];
        $context  = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);

        $result = json_decode($response, true);

        if (isset($result['data'])) {
            $fecha     = $result['data']['fechaTransaccion'];
            $hora      = $result['data']['horaTransaccion'];
            $codigo    = $result['data']['codigoRespuesta'];
            $mensaje   = $result['data']['mensajeRespuesta'];
            $respuesta = [
                'success' => true,
                'fecha'   => $fecha,
                'hora'    => $hora,
                'codigo'  => $codigo,
                'mensaje' => $mensaje,
            ];
            $idelemento = $data['pPlaca'];
            $cadena     = "IdUsuario: " . $this->session->userdata('IdUsuario');
            $tipo       = "p";
            $enviado    = "1";
            $this->insertarEvento($idelemento, $cadena, $tipo, $enviado, $respuesta['mensaje']);
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'success' => false,
                'mensaje' => 'Respuesta inesperada de la API',
                'raw'     => $result,
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    //Ciclo de prueba
    public function ciclo_prueba()
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->setConf();
        $url = 'http://' . $this->configuracion['ipSicov'] . '/fur/api/v1/rest/reporte-ciclos-pruebas';
        $eco = json_decode($this->eco(), true);
        if (! $eco['success'] || $eco['ws_ecoResult'] !== 'OK') {
            echo json_encode([
                'success' => false,
                'mensaje' => ($eco['mensaje'] ?? 'Respuesta inesperada'),
            ], JSON_UNESCAPED_UNICODE);
            return;
        }
        $dataCiclo = json_decode($this->input->raw_input_stream, true) ?? [];
        $data      = array_merge($dataCiclo, [
            'usuario' => $this->configuracion['usuarioSicov'],
            'clave'   => $this->configuracion['claveSicov'],
            'idRunt'  => $this->configuracion['idCdaRUNT'],
            'fecha'   => (new DateTime('now', new DateTimeZone('America/Bogota')))->format('Ymd H:i:s'),
        ]);

        $options = [
            'http' => [
                'header'        => "Content-Type: application/json\r\n",
                'method'        => 'POST',
                'content'       => json_encode($data),
                'ignore_errors' => true, // Para capturar respuestas de error HTTP
            ],
        ];
        $context  = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);
        if ($response === false) {
            echo json_encode([
                'success' => false,
                'mensaje' => 'Error al conectar con la API',
            ], JSON_UNESCAPED_UNICODE);
            return;
        }
        $result = json_decode($response, true);

        if (isset($result['data'])) {
            $fechaTransaccion = $result['data']['fechaTransaccion'] ?? null;
            $codigoRespuesta  = $result['data']['codigoRespuesta'] ?? null;
            $mensajeRespuesta = $result['data']['mensajeRespuesta'] ?? null;
            $respuesta        = [
                'success'          => true,
                'fechaTransaccion' => $fechaTransaccion,
                'codigoRespuesta'  => $codigoRespuesta,
                'mensajeRespuesta' => $mensajeRespuesta,
            ];
            $idelemento = $dataCiclo['placa'];
            $tiposPrueba = [
                '1'  => 'GASES',
                '5'  => 'OPACIDAD',
                '6'  => 'SUSPENSION',
                '7'  => 'FRENOS',
                '8'  => 'ALINEACION',
                '9'  => 'LUCES',
                '12' => 'SONOMETRO',
                '16' => 'TAXIMETRO',
                '17' => 'SENSORIAL INFERIOR',
                '18' => 'SENSORIAL EXTERIOR',
                '19' => 'SENSORIAL INTERIOR',
                '20' => 'FOTO FRONTAL',
                '21' => 'FOTO TRASERA',
            ];
            $cadena = ($tiposPrueba[$data['tipoPrueba']] ?? 'NO EXISTE')
                . '|' . $data['idEvento'] . '|' . $data['mensajeEvento'];
            $tipo    = "e";
            $enviado = "1";
            $this->insertarEvento($idelemento, $cadena, $tipo, $enviado, $respuesta['mensajeRespuesta']);
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'success' => false,
                'mensaje' => 'Respuesta inesperada de la API',
                'raw'     => $result,
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    public function furv4()
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->setConf();

        $url = 'http://' . $this->configuracion['ipSicov'] . '/fur/api/v1/rest/furv4';
        $eco = json_decode($this->eco(), true);
        if (! $eco['success'] || $eco['ws_ecoResult'] !== 'OK') {
            echo json_encode([
                'success' => false,
                'mensaje' => ($eco['mensaje'] ?? 'Respuesta inesperada'),
            ], JSON_UNESCAPED_UNICODE);
            return;
        }
        $dataFUR = json_decode($this->input->raw_input_stream, true) ?? [];
        $data    = array_merge($dataFUR, [
            'usuario' => $this->configuracion['usuarioSicov'],
            'clave'   => $this->configuracion['claveSicov'],
        ]);
        $options = [
            'http' => [
                'header'        => "Content-Type: application/json\r\n",
                'method'        => 'POST',
                'content'       => json_encode($data),
                'ignore_errors' => true, // Para capturar respuestas de error HTTP
            ],
        ];
        $context  = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            echo json_encode([
                'success' => false,
                'mensaje' => 'Error al conectar con la API',
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        $result = json_decode($response, true);

        if (isset($result['data'])) {
            $fechaTransaccion = $result['data']['fechaTransaccion'] ?? null;
            $horaTransaccion  = $result['data']['horaTransaccion'] ?? null;
            $codigoRespuesta  = $result['data']['codigoRespuesta'] ?? null;
            $mensajeRespuesta = $result['data']['mensajeRespuesta'] ?? null;
            $confirmacion     = $result['data']['confirmacion'] ?? null;

            echo json_encode([
                'success'          => true,
                'fechaTransaccion' => $fechaTransaccion,
                'horaTransaccion'  => $horaTransaccion,
                'codigoRespuesta'  => $codigoRespuesta,
                'mensajeRespuesta' => $mensajeRespuesta,
                'confirmacion'     => $confirmacion,
            ], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'success' => false,
                'mensaje' => 'Respuesta inesperada de la API',
                'raw'     => $result,
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    //Eco de la API.
    public function eco()
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->setConf();
        $url = 'http://' . $this->configuracion['ipSicov'] . '/fur/api/v1/rest/eco';

        $options = [
            'http' => [
                'header'        => "Content-Type: application/json\r\n",
                'method'        => 'GET',
                'ignore_errors' => true, // Para capturar respuestas de error HTTP
            ],
        ];
        $context  = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);
        // var_dump($response);
        if ($response === false) {
            return json_encode([
                'success' => false,
                'mensaje' => 'Error al conectar con la API',
            ], JSON_UNESCAPED_UNICODE);

        }

        $result = json_decode($response, true);

        if (isset($result['data'])) {
            $ws_ecoResult = $result['data']['ws_ecoResult'];
            return json_encode([
                'success'      => true,
                'ws_ecoResult' => $ws_ecoResult,
            ], JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode([
                'success' => false,
                'mensaje' => 'Respuesta inesperada de la API',
                'raw'     => $result,
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    private function mensajes($codigo, $detalle)
    {
        $msg = 'Código de respuesta no válido: Revise la conexión con CI2';
        switch ($codigo) {
            case '0000':
                $msg = 'Transacción exitosa|' . $detalle;
                break;
            case '1000':
                $msg = 'Transacción Fallida|' . $detalle;
                break;
            case '1001':
                $msg = 'Dato no puede ser nulo|' . $detalle;
                break;
            case '1002':
                $msg = 'Valor no válido|' . $detalle;
                break;
            case '1003':
                $msg = 'Formato no válido|' . $detalle;
                break;
            case '1004':
                $msg = 'Campo obligatorio|' . $detalle;
                break;
            case '1005':
                $msg = 'Longitud no permitida|' . $detalle;
                break;
            case '1006':
                $msg = 'Dato no existe|' . $detalle;
                break;
            case '2001':
                $msg = 'Usuario y clave no válidos|' . $detalle;
                break;
            case '2002':
                $msg = 'Usuario no permitido|' . $detalle;
                break;
            case '2003':
                $msg = 'CDA no permitido|' . $detalle;
                break;
            case '2004':
                $msg = 'Vehículo no permitido|' . $detalle;
                break;
            case '2005':
                $msg = 'PIN ANULADO|' . $detalle;
                break;
            case '2006':
                $msg = 'PIN DISPONIBLE|' . $detalle;
                break;
            case '2007':
                $msg = 'PIN UTILIZADO|' . $detalle;
                break;
            case '2008':
                $msg = 'PIN REPORTADO CON FUR|' . $detalle;
                break;
            case '2009':
                $msg = 'PIN NO VALIDO|' . $detalle;
                break;
            case '2010':
                $msg = 'Pendiente por procesar|' . $detalle;
                break;
            case '2011':
                $msg = 'La solicitud está pendiente por reportar resultado|' . $detalle;
                break;
            case '2012':
                $msg = 'Código RUNT ya está registrado|' . $detalle;
                break;
        }
        return $msg;
    }

    private function insertarEvento($idelemento, $cadena, $tipo, $enviado, $respuesta)
    {
        $data['idelemento'] = $idelemento;
        $data['cadena']     = $cadena;
        $data['tipo']       = $tipo;
        $data['enviado']    = $enviado;
        $data['respuesta']  = $respuesta;
        $this->MEventosindra->insert($data);
    }
}
