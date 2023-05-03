<?php

namespace App\Controller;

use App\Controller\Support\Session;
use App\Model\GestaoSmsRepository;
use Nextc\Controller\Action;

session_start();
class GestaoSmsController extends Action
{
    public $authCsrf;
    private $newcreateCsrf;
    public $clienteData;
    private $instaciamembrosRepositorio;

    public function __construct()
    {
        $this->newcreateCsrf = new Session();
        $this->newcreateCsrf->is_autheticationNot();
        $this->instaciamembrosRepositorio = new GestaoSmsRepository();
    }

    public function my_gestao_sms()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $this->render("my_gestao_sms", "layoutGestaoSms");
    }

    public function getOperation()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $_SESSION['page'] = $_POST['page'] ?? '';
        $_SESSION['pesquisar'] = trim(strip_tags($_POST['pesquisar'] ?? ''));
        $data = $this->instaciamembrosRepositorio->findOperationSms($_SESSION['tokenjwt'], $_SESSION['page'], $_SESSION['pesquisar']);
        $this->clienteData = $data ?? [];
        
        if (empty($this->clienteData)) {
            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] =  true;
            $json = json_encode($response);
            echo $json;
            return;
        }
        //pacoteSistema
        $this->render("componentGestaoSms", "layoutGestaoSms");
    }


    //getsmsComprado

    public function my_vendas_sms()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $this->render("my_vendas_sms", "layoutGestaoSms");
    }

    public function getOperationvenda()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $_SESSION['page'] = $_POST['page'] ?? '';
        $_SESSION['pesquisar'] = trim(strip_tags($_POST['pesquisar'] ?? ''));
        $data = $this->instaciamembrosRepositorio->findOperationSmsvenda($_SESSION['tokenjwt'], $_SESSION['page'], $_SESSION['pesquisar']);
        $this->clienteData = $data ?? [];
        if (empty($this->clienteData)) {
            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] =  true;
            $json = json_encode($response);
            echo $json;
            return;
        }
        $this->render("componentVendaSms", "layoutGestaoSms");
    }

    public function creteOperationSms()
    {
        $dataCliente = array(
            "email_user" => trim(strip_tags($_POST['email_user'] ?? '')),
            "typeopercao" => trim(strip_tags($_POST['typeopercao'] ?? '')),
            "quantia_de_sms" => trim(strip_tags($_POST['quantia_de_sms'] ?? '')),
        );

        $is_date_obr = $this->instaciamembrosRepositorio->creteOperationSms($_SESSION['tokenjwt'], $dataCliente);
        /* header('Content-Type: application/json; charset=utf-8');
        $response["erro"] = $is_date_obr->error;
        $response["mensagem"] =  $is_date_obr;
        $json = json_encode($response);
        echo $json;
        return; */
        if (!empty($is_date_obr)) {
            if (!empty($is_date_obr->errorInfo)) {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] = $is_date_obr->status;
                $response["email_user"] = $is_date_obr->errorInfo->email_user ?? '';
                $response["typeopercao"] = $is_date_obr->errorInfo->typeopercao ?? '';
                $response["quantia_de_sms"] = $is_date_obr->errorInfo->quantia_de_sms ?? '';
                $json = json_encode($response);
                echo $json;
                return;
            }
            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] = $is_date_obr->error;
            $response["mensagem"] =  $is_date_obr->status;
            $json = json_encode($response);
            echo $json;
            return;
        }
    }
}
