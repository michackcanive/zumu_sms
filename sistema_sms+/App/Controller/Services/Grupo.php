<?php

namespace App\Controller\Services;

use CURLFile;
use Exception;


abstract class Grupo implements IRequest
{
    private $URL = API_URL;


    public function create_grupo($token, $dataCliente)
    {
        try {
            $estruturaJson = '
        {
          "name_grupo" : "' . $dataCliente['nome_grupo'] . '",
          "descricao" : "' . $dataCliente['descricao'] . '",
          "token" : "' . $token . '"
        }';
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL . "creategrupo"));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }



    public function updategrupo($token, $dataCliente)
    {
        try {
            $estruturaJson = '
        {
          "name_grupo" : "' . $dataCliente['name_grupo'] . '",
          "id_grupo" : "' . $dataCliente['id_grupo'] . '",
          "token" : "' . $token . '"
        }';
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL . "updategrupo"));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }

    public function actionTypeGrupo($token, $dataCliente)
    {
        try {
            $estruturaJson = '
        {
          "grupo_id" : "' . $dataCliente['grupo_id'] . '",
          "grupo_contact_id" : "' . $dataCliente['dados'] . '",
          "typeAction" : "' . $dataCliente['typeAction'] . '",
          "token" : "' . $token . '"
        }';
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL . "actionGrup"));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }


    public function getgrupo($token, $page, $pesquisar)
    {
        try {
            $estruturaJson = '
            {
              "token" : "' . $token . '"
            }';
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL . "getgrupos?pesquisar=" . $pesquisar . "&page=" . $page));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }

    public function deletegrupo($token, $id_grupo)
    {
        try {
            $infor = json_decode($this->estruturaJsonGet($this->URL . "deletegrupo?id_grupo=" . $id_grupo . "&token=" . $token));
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
