<?php

namespace App\Controller\Services;

use Exception;


abstract class GestaoSmsCliente implements IRequest
{
    private $URL = API_URL;


    public function createOperationSmsCliente($token, $dataCliente)
    {
        try {
            $estruturaJson = '
        {
          "email_user" : "' . $dataCliente['email_user'] . '",
          "typeopercao" : "' . $dataCliente['typeopercao'] . '",
          "quantia_de_sms" : "' . $dataCliente['quantia_de_sms'] . '",
          "token" : "' . $token . '"
        }';
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL . "createOperationSmsCliente"));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }

    public function getOperationSmsCliente($token, $page, $pesquisar)
    {
        try {
            $estruturaJson = '
            {
              "token" : "' . $token . '"
            }';
            $infor = json_decode($this->estruturaJson($estruturaJson,$this->URL . "getPesquisarSmsOperation?pesquisar=".$pesquisar."&page=" . $page));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }
    public function getOperationSmsClientevenda($token, $page, $pesquisar)
    {
        try {
            $estruturaJson = '
            {
              "token" : "' . $token . '"
            }';
            $infor = json_decode($this->estruturaJson($estruturaJson,$this->URL . "getCompras_sms?pesquisar=".$pesquisar."&page=" . $page));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }

    public function getOperationSmsClientevenda_admin($token, $page, $pesquisar)
    {
        try {
            $estruturaJson = '
            {
              "token" : "' . $token . '"
            }';
            $infor = json_decode($this->estruturaJson($estruturaJson,$this->URL . "getCompras_admin?pesquisar=".$pesquisar."&page=" . $page));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }

    public function estruturaJson($estruturaJson, $url): string
    {
        // $fields = urlencode($estruturaJson);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $estruturaJson);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    public function estruturaJsonput($estruturaJson, $url): string
    {
        // $fields = urlencode($estruturaJson);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $estruturaJson);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function estruturaJsonGet($url): string
    {
        // $fields = urlencode($estruturaJson);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
