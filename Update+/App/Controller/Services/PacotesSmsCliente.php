<?php

namespace App\Controller\Services;

use Exception;


abstract class PacotesSmsCliente implements IRequest
{
    private $URL = API_URL;


    public function createPacotesSmsCliente($token, $dataCliente)
    {
        try {
            $estruturaJson = '
        {
          "nomepacote" : "' . $dataCliente['nomepacote'] . '",
          "qtduser" : "' . $dataCliente['qtduser'] . '",
          "qtd_sms_user" : "' . $dataCliente['qtd_sms_user'] . '",
          "text_ideal" : "' . $dataCliente['text_ideal'] . '",
          "token" : "' . $token . '"
        }';
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL . "createpacotessms"));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }

    public function updatePacoteSmsCliente($token, $dataCliente)
    {
        try {
            $estruturaJson = '
        {
          "nomepacote" : "' . $dataCliente['nomepacote'] . '",
          "qtduser" : "' . $dataCliente['qtduser'] . '",
          "id_pacote" : "' . $dataCliente['id_pacote'] . '",
          "qtd_sms_user" : "' . $dataCliente['qtd_sms_user'] . '",
          "text_ideal" : "' . $dataCliente['text_ideal'] . '",
          "token" : "' . $token . '"
        }';
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL . "updatePacoteSms"));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }
    public function getPacotesSmsCliente($token, $page)
    {
        try {
            $infor = json_decode($this->estruturaJsonGet($this->URL . "getClientePacote?page=" . $page . "&token=" . $token));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }
    public function getPacotesSmsClientesite($email_empresa)
    {
        try {
            $infor = json_decode($this->estruturaJsonGet($this->URL . "getClientePacotesite?email_empresa=".$email_empresa));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }

    public function deletePacotesSmsCliente($token, $id_pacote)
    {
        try {
            $infor = json_decode($this->estruturaJsonGet($this->URL . "deletePacoteSms?id_pacote=" . $id_pacote . "&token=" . $token));
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
