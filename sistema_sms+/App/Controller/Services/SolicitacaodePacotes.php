<?php

namespace App\Controller\Services;

use CURLFile;
use Exception;


abstract class SolicitacaodePacotes implements IRequest
{
    private $URL = API_URL;


    public function createsolictacao($token, $dataCliente)
    {

        try {
            if ($dataCliente['comprovativo']['error'] == UPLOAD_ERR_OK) {
                $nome_arquivo = $dataCliente['comprovativo']['name'];
                $caminho_temporario = $dataCliente['comprovativo']['tmp_name'];
                // Fazer algo com o arquivo enviado
            } else {
                return array(
                    'error' => true,
                    'mensager' => 'comprovativo invalido'
                );
            }
            $dados = [
                'token' => $token,
                'aumount_cart' => $dataCliente['aumount_cart'],
                'nota' => $dataCliente['nota'],
                'comprovativo' => new CURLFile($caminho_temporario, $nome_arquivo)
            ];
            $infor = json_decode($this->estruturaJsonput($dados, $this->URL . "createsolictacao"));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e ?? 'Não possivel'
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
    public function getsolicitacaoCliente($token, $page, $pesquisar)
    {
        try {
            $estruturaJson = '
            {
              "token" : "' . $token . '"
            }';
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL . "getsolicitacaoCarregamento?pesquisar=" . $pesquisar . "&page=" . $page));
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


    public function Activarcarregamento($token, $dataCliente)
    {
        try {
            $estruturaJson = '
            {
              "codigo_activacao" : "' .  $dataCliente['password'] . '",
              "id_request" : "' . $dataCliente['id_request'] . '",
              "token":"' . $token . '"
            }';
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL . "createliberacaosaldo"));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }
    public function comprarsmsuser($token, $dataCliente)
    {
        try {
            $estruturaJson = '
            {
              "id_pedido" : "' . $dataCliente['id_pacote'] . '",
              "token":"' . $token . '"
            }';
            $infor = json_decode($this->estruturaJson($estruturaJson, $this->URL . "createcomprasms"));
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
