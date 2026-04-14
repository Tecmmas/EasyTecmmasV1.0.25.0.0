<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use ModbusTcpClient\Network\BinaryStreamConnection;
use ModbusTcpClient\Packet\ModbusFunction\ReadHoldingRegistersRequest;
use ModbusTcpClient\Packet\ModbusFunction\WriteSingleRegisterRequest;
use ModbusTcpClient\Packet\ResponseFactory;

require __DIR__ . '/../vendor/autoload.php';
header("Access-Control-Allow-Origin: *");
class Cmodbus extends CI_Controller {

    public function leer() {
       // $ip = $this->input->post('ip');
       $ip = '192.168.10.80';
        
        $port = 502;
        $unitId = 1;
        $address = 0;
        $quantity = 50;
        $connection = BinaryStreamConnection::getBuilder()
                ->setPort($port)
                ->setHost($ip)
                ->build();
        $packet = new ReadHoldingRegistersRequest($address, $quantity, $unitId);
        $result = [];
        try {
            $binaryData = $connection->connect()->sendAndReceive($packet);
            $response = ResponseFactory::parseResponseOrThrow($binaryData)->withStartAddress($address);
            foreach ($response as $address => $word) {
                $result[$address] = [
                    'dato' => $word->getInt16()
                ];
            }
        } catch (Exception $exception) {
            
        } finally {
            $connection->close();
        }
        $data['result'] = $result;
        $data['address'] = $address;
        echo json_encode($data);
    }

    public function escribir() {
        $connection = BinaryStreamConnection::getBuilder()
                ->setPort(502)
                ->setHost('192.168.10.80')
                ->build();
        $startAddress = $this->input->post('response');
        $value = $this->input->post('valor');
        try {
            $packet = new WriteSingleRegisterRequest($startAddress, $value);
            $connection->connect()->sendAndReceive($packet);
        } catch (Exception $exception) {
            
        } finally {
            $connection->close();
        }
    }

}
