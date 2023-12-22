<?php

namespace App\Controller\Services;

use Exception;


abstract class MemberCliente implements IRequest
{
    private $URL = API_URL;


    public function createMemberCliente($token, $dataCliente)
    {
        try {
            $estruturaJson = '
        {
          "nome_membro" : "' . $dataCliente['nome_membro'] . '",
          "email_membro" : "' . $dataCliente['email_membro'] . '",
          "telefone" : "' . $dataCliente['telefone'] . '",
          "password" : "' . $dataCliente['password'] . '",
          "token" : "' . $token . '"
        }';
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL . "creatememberCliente"));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }

    public function updateMemberCliente($token, $dataCliente)
    {
        try {
            $estruturaJson = '
        {
          "nome_membro" : "' . $dataCliente['nome_membro'] . '",
          "email_membro" : "' . $dataCliente['email_membro'] . '",
          "telefone" : "' . $dataCliente['telefone'] . '",
          "user_id" : "' . $dataCliente['user_id'] . '",
          "password" : "' . $dataCliente['password'] . '",
          "token" : "' . $token . '"
        }';
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL . "updatememberCliente"));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }
    public function getMemberCliente($token, $page, $pesquisar)
    {

        $estruturaJson = '
            {
              "token" : "' . $token . '"
            }';
        try {
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL . "getClienteMember?pesquisar=" . $pesquisar . "&page=" . $page));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
        return 1;
    }

    public function deleteMemberCliente($token, $id_member)
    {
        try {
            $infor = json_decode($this->estruturaJsonGet($this->URL . "deleteCliente?id_cliente=" . $id_member . "&token=" . $token));
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
