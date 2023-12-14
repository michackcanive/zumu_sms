<?php

namespace App\Controller\Services;

use Exception;

abstract class Auth implements IRequest
{
    private $URL = API_URL;

    public function login($email, $password)
    {
        $estruturaJson = '
        {
          "email" : "' . $email . '",
          "password" : "' . $password . '"
        }';
        try {
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL . "login"));

            if (!empty($infor)) {
                return $infor;
            } else {
                return [];
            }
            return [];
        } catch (Exception $error) {
            return [];
        }
    }

    public function register($dataCliente)
    {

        $estruturaJson = '
        {
          "name" : "' . $dataCliente['name'] . '",
          "telefone" : "' . $dataCliente['telefone'] . '",
          "email" : "' . $dataCliente['email'] . '",
          "password" : "' . $dataCliente['password'] . '",
          "tipo_de_conta" : "' . $dataCliente['tipo_de_conta'] . '",
          "email_empresa" : "' .$dataCliente['email_empresa'] . '"
        }';
        try {
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL."register"));

            if (!empty($infor)) {
                return $infor;
            } else {
                return [];
            }
            return [];
        } catch (Exception $error) {
            return [];
        }
    }
    public function activeAccount($code,$token_jwt)
    {
        $estruturaJson = '
        {
          "code" : "' . $code . '",
          "token" : "' . $token_jwt . '"
        }';
        try {
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL . "activeAccount"));

            if (!empty($infor)) {
                return $infor;
            } else {
                return [];
            }
            return [];
        } catch (Exception $error) {
            return [];
        }
    }

    public function renviar_codigo($token_jwt)
    {
        try {
            $infor = json_decode($this->estruturaJsonGet($this->URL . "renviar_codigo_activa?token=".$token_jwt));
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
