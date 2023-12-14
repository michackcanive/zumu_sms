<?php

namespace App\Controller\Services;

use CURLFile;
use Exception;


abstract class Contacto implements IRequest
{
    private $URL = API_URL;


    public function createcontacto($token, $dataCliente)
    {
        try {
            $estruturaJson = '
        {
          "nome" : "' . $dataCliente['nome'] . '",
          "email" : "' . $dataCliente['email'] . '",
          "numero_telefone" : "' . $dataCliente['numero_telefone'] . '",
          "token" : "' . $token . '"
        }';
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL . "createcontacto"));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }



    public function updateContacto($token, $dataCliente)
    {
        try {
            $estruturaJson = '
        {
          "nome" : "' . $dataCliente['nome'] . '",
          "email" : "' . $dataCliente['email'] . '",
          "id_contacto" : "' . $dataCliente['id_contacto'] . '",
          "numero_telefone" : "' . $dataCliente['numero_telefone'] . '",
          "token" : "' . $token . '"
        }';
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL . "updatecontacto"));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }

    public function importar_contactos($token, $dataCliente)
    {
        try {
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
                    'file' => new CURLFile($caminho_temporario, $nome_arquivo),
                    'token' => $token
                ];

            $infor = json_decode($this->estruturaJsonput($dados, $this->URL . "import"));
            return $infor??'';

        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }

    public function getContacto($token, $page, $pesquisar)
    {
        try {
            $estruturaJson = '
            {
              "token" : "' . $token . '"
            }';
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL . "getContactos?pesquisar=" . $pesquisar . "&page=" . $page));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }

    public function deleteContacto($token, $id_contacto)
    {
        try {
            $infor = json_decode($this->estruturaJsonGet($this->URL . "deleteContacto?id_contacto=" . $id_contacto . "&token=" . $token));
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
}
