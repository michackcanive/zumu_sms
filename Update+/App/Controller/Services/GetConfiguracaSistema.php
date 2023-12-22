<?php

namespace App\Controller\Services;

use CURLFile;
use Exception;

abstract class GetConfiguracaSistema
{
    private $URL = API_URL;

    public function getconfiguracaoSistema($emilUser)
    {
        try {
            $infor = json_decode($this->estruturaJsonGet($this->URL . "getconfigSistema?emailUser=" . $emilUser));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e,
            );
        }
    }

    public function updateEmpresa($token, $dataCliente)
    {
        try {

            if ($dataCliente['logo_zumu']['error'] == UPLOAD_ERR_OK) {
                $nome_arquivo = $dataCliente['logo_zumu']['name'];
                $caminho_temporario = $dataCliente['logo_zumu']['tmp_name'];
                // Fazer algo com o arquivo enviado
            } else {
                if (empty($_SESSION['LOGO_SISTEMA'])) {
                    return array(
                        'error' => true,
                        'mensager' => 'Logo invalido',
                    );
                }

            }

            if (empty($caminho_temporario)) {
                $dados = array(
                    "nome_sistema" => trim(strip_tags($dataCliente['nome_sistema'])),
                    "email_empresa" => trim(strip_tags($dataCliente['email'] ?? '')),
                    "contacto" => trim(strip_tags($dataCliente['contacto'] ?? '')),
                    "nif" => trim(strip_tags($dataCliente['nif_sistema'] ?? '')),
                    "endereco" => trim(strip_tags($dataCliente['endereco'] ?? '')),
                    "hora_atendimento_inicio" => trim(strip_tags($dataCliente['hora_atendimento_inicio'] ?? '')),
                    "hora_atendimento_termino" => trim(strip_tags($dataCliente['hora_atendimento_termino'] ?? '')),
                    "dica_sistema" => trim(strip_tags($dataCliente['dica_sistema'] ?? '')),
                    "objectivo" => trim(strip_tags($dataCliente['objectivo_sistema'] ?? '')),
                    "termsSolicitacao" => trim(strip_tags($dataCliente['termsSolicitacao'] ?? '')),
                    "qtd_kz_sender" => trim(strip_tags($dataCliente['qtd_kz_sender'] ?? '')),
                    "qtd_sender_grats" => trim(strip_tags($dataCliente['qtd_sender_grats'] ?? '')),
                    "beneficiario" => trim(strip_tags($dataCliente['beneficiario'] ?? '')),
                    "iban" => trim(strip_tags($dataCliente['iban'] ?? '')),
                    'token' => $token,
                );
            } else {

                // Diretório atual do script em execução
                $diretorioAtual = __DIR__;

// Caminho para a pasta public a partir do diretório atual
                $novoNome = 'send.png';
                $caminhoPublic = $diretorioAtual . '/../public'.$novoNome;

                if (rename($caminho_temporario, $novoNome)) {

                    if (copy($novoNome, $caminhoPublic)) {
                        //
                    } else {
                       //
                    }
                }

                $dados = array(
                    'file' => new CURLFile($novoNome ?? '', $nome_arquivo ?? ''),
                    "nome_sistema" => trim(strip_tags($dataCliente['nome_sistema'])),
                    "email_empresa" => trim(strip_tags($dataCliente['email'] ?? '')),
                    "contacto" => trim(strip_tags($dataCliente['contacto'] ?? '')),
                    "nif" => trim(strip_tags($dataCliente['nif_sistema'] ?? '')),
                    "endereco" => trim(strip_tags($dataCliente['endereco'] ?? '')),
                    "hora_atendimento_inicio" => trim(strip_tags($dataCliente['hora_atendimento_inicio'] ?? '')),
                    "hora_atendimento_termino" => trim(strip_tags($dataCliente['hora_atendimento_termino'] ?? '')),
                    "dica_sistema" => trim(strip_tags($dataCliente['dica_sistema'] ?? '')),
                    "objectivo" => trim(strip_tags($dataCliente['objectivo_sistema'] ?? '')),
                    "termsSolicitacao" => trim(strip_tags($dataCliente['termsSolicitacao'] ?? '')),
                    "qtd_kz_sender" => trim(strip_tags($dataCliente['qtd_kz_sender'] ?? '')),
                    "qtd_kz_sender" => trim(strip_tags($dataCliente['qtd_kz_sender'] ?? '')),
                    "qtd_sender_grats" => trim(strip_tags($dataCliente['qtd_sender_grats'] ?? '')),
                    "beneficiario" => trim(strip_tags($dataCliente['beneficiario'] ?? '')),
                    "iban" => trim(strip_tags($dataCliente['iban'] ?? '')),
                    'token' => $token,
                );
            }

            $infor = json_decode($this->estruturaJsonput($dados, $this->URL . "updateEmpresa"));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e,
            );
        }
    }
    //updateEmpresa

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
}
//getSmsSendOperation
