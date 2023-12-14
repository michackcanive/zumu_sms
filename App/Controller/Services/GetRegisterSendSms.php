<?php

namespace App\Controller\Services;

use CURLFile;
use Exception;


abstract class GetRegisterSendSms
{
    private $URL = API_URL;


    public function getSmsSend($token, $page, $pesquisar)
    {
        try {
            $infor = json_decode($this->estruturaJsonGet($this->URL . "getSmsSendOperation?pesquisar=" . $pesquisar . "&page=" . $page . "&token=" . $token));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }

    public function sendOperationSms($token, $dataCliente)
    {
        try {

            if (!empty($dataCliente['file']['name'])) {

                if ($dataCliente['file']['error'] == UPLOAD_ERR_OK) {
                    $nome_arquivo = $dataCliente['file']['name'];
                    $caminho_temporario = $dataCliente['file']['tmp_name'];
                    // Fazer algo com o arquivo enviado
                } else {
                    return array(
                        'error' => true,
                        'mensager' => 'Arquivo invalido'
                    );
                }

                $dados = [
                    'id_sender' => $dataCliente['id_sender'],
                    'type_send' => $dataCliente['type_send'],
                    'number_phone' => $dataCliente['number_phone'] ?? '',
                    'message_body' => $dataCliente['message_body'] ?? '',
                    'exelContact' => new CURLFile($caminho_temporario, $nome_arquivo),
                    'token' => $token
                ];

            } else {
                $dados = [
                    'id_sender' => $dataCliente['id_sender'],
                    'type_send' => $dataCliente['type_send'],
                    'number_phone' => $dataCliente['number_phone'] ?? '',
                    'message_body' => $dataCliente['message_body'] ?? '',
                    'token' => $token
                ];
            }



            $infor = json_decode($this->estruturaJsonput($dados, $this->URL . "send_sms"));
            return $infor??'';
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }

    public function estruturaJsonput($estruturaJson, $url): string
    {
        // $fields = urlencode($estruturaJson);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $estruturaJson);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
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

    public function estruturaJson($estruturaJson, $url): string
    {
        // $fields = urlencode($estruturaJson);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $estruturaJson);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
//getSmsSendOperation
