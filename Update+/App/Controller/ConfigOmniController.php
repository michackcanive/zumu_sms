<?php

namespace App\Controller;

use App\Controller\Support\Help;
use App\Controller\Support\Session;
use App\Model\ConfigsistemaRepository;
use App\Model\IgrejasRepository;
use App\Model\ObreirosRepository;
use App\Model\Site;
use Nextc\Controller\Action;

session_start();
class ConfigOmniController extends Action
{
    public $authCsrf;
    private $newcreateCsrf;
    private $instaHelp;
    private $instaciaConfigRepositorio;
    public $configuracao;


    public function __construct()
    {
        $this->newcreateCsrf = new Session();
        $this->newcreateCsrf->is_autheticationNot();
        $this->instaHelp = new Help();
        $this->instaciaConfigRepositorio = new ConfigsistemaRepository();

        if ($_SESSION['tipo_de_conta'] == 'admin') {
        } else if ($_SESSION['tipo_de_conta'] == 'cliente') {
            return;
        } else {
            return;
        }
    }

    public function my_config()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        //$this->configuracao = $this->instaciaConfigRepositorio->findconfig();
        $instacia = new Site();
        $this->configuracao = $instacia->findConfigSite(EMAIL_EMPRESA);

        $this->render("my_config", "layoutConfigsistema");
    }

    public function creteConfg()
    {

        $token = $_POST['token'];
        if ($this->newcreateCsrf->csrf_verifica($token)) {

            $dataCliente = array(
                "logo_zumu" => $_FILES['logo_sistema'],
                "nome_sistema" => trim(strip_tags($_POST['nome_sistema'])),
                "email" => trim(strip_tags($_POST['email'] ?? '')),
                "contacto" => trim(strip_tags($_POST['contacto'] ?? '')),
                "nif_sistema" => trim(strip_tags($_POST['nif'] ?? '')),
                "endereco" => trim(strip_tags($_POST['endereco'] ?? '')),
                "hora_atendimento_inicio" => trim(strip_tags($_POST['hora_atendimento_inicio'] ?? '')),
                "hora_atendimento_termino" => trim(strip_tags($_POST['hora_atendimento_termino'] ?? '')),
                "dica_sistema" => trim(strip_tags($_POST['dica_sistema'] ?? '')),
                "objectivo_sistema" => trim(strip_tags($_POST['objectivo_sistema'] ?? '')),
                "termsSolicitacao" => trim(strip_tags($_POST['termsSolicitacao'] ?? 0)),
                "qtd_kz_sender" => trim(strip_tags($_POST['qtd_kz_sender'] ?? '')),
                "qtd_sender_grats" => trim(strip_tags($_POST['qtd_sender_grats'] ?? '')),
                "iban" => trim(strip_tags($_POST['iban'] ?? '')),
                "beneficiario" => trim(strip_tags($_POST['beneficiario'] ?? ''))
            );

            $data = $this->instaciaConfigRepositorio->creteConfigsistema($_SESSION['tokenjwt'], $dataCliente);
         
            if (!empty($data)) {
                if ($data->error) {
                    header('Content-Type: application/json; charset=utf-8');
                    $response["erro"] = $data->error;
                    $response["mensagem"] = $data->status;
                    $json = json_encode($response);
                    echo $json;
                    return;
                } else {

                    $instacia = new Site();
                    $this->configuracao = $instacia->findConfigSite(EMAIL_EMPRESA);
                    $_SESSION['NOME_SISTEMA'] = $this->configuracao->dataEmpresa->nome_sistema ?? '';
                    $_SESSION['LOGO_SISTEMA'] = $this->configuracao->dataEmpresa->logo_sistema ?? '';
                    $_SESSION['NOME_EMAIL'] = $this->configuracao->dataEmpresa->email ?? '';
                    $_SESSION['NOME_TELEFONE'] = $this->configuracao->dataEmpresa->contacto ?? '';

                    header('Content-Type: application/json; charset=utf-8');
                    $response["erro"] = $data->error;
                    $response["mensagem"] = $data->status;
                    $json = json_encode($response);
                    echo $json;
                    return;
                }
            } else {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] =   'Não foi possível gravar';
                $response["camino"] =   '';
                $json = json_encode($response);
                echo $json;
                return;
            };
        } else {
            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] = true;
            $response["mensagem"] =   'Não foi possível configurar o sistema';
            $response["camino"] =   '';
            $json = json_encode($response);
            echo $json;
            return;
        }
    }
}
