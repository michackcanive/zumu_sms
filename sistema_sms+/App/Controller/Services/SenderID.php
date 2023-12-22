<?php

namespace App\Controller\Services;

use Exception;


abstract class SenderID implements IRequest
{
    private $URL = API_URL;


    public function createSenderID($token,$name_sender_id)
    {
        try {
            $estruturaJson = '
        {
          "name_sender_id" : "' . $name_sender_id . '",
          "descricao_sender" : "Envio de sms",
          "token" : "' . $token . '"
        }';
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL . "requestSenderId"));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }
    public function getSenderID($token,$page)
    {
        try {
            $infor = json_decode($this->estruturaJsonGet($this->URL . "getSender?page=".$page."&token=".$token));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
        return 1;
    }
    public function getBuscarSenderID($token,$page,$pesquisar)
    {
        try {
            $infor = json_decode($this->estruturaJsonGet($this->URL . "getSender?pesquisar=".$pesquisar."&page=".$page."&token=".$token));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
        return 1;
    }
    public function getBuscarSenderIDActive($token,$page,$pesquisar)
    {
        try {
            $infor = json_decode($this->estruturaJsonGet($this->URL . "senderId_active?pesquisar=".$pesquisar."&page=".$page."&token=".$token));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
        return 1;
    }
    public function deleteSenderID($token,$id_sender)
    {
        try {
            $infor = json_decode($this->estruturaJsonGet($this->URL . "deleteSender?id_sender=".$id_sender."&token=".$token));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
        return 1;
    }
    public function pocessarSenderApi($token,$id_sender)
    {
        try {
            $infor = json_decode($this->estruturaJsonGet($this->URL . "processarSender?id_sender=".$id_sender."&token=".$token));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
        return 1;
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
