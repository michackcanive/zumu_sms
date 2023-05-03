<?php

namespace App\Controller;

use App\Controller\Support\Help;
use App\Controller\Support\Session;
use App\Model\PacotesSmsRepository;
use Nextc\Controller\Action;

session_start();
class PacotesController extends Action
{
    public $authCsrf;
    private $newcreateCsrf;
    public $clienteData;
    private $instaHelp;
    private $instaciamembrosRepositorio;


    public function __construct()
    {
        $this->newcreateCsrf = new Session();
        $this->newcreateCsrf->is_autheticationNot();
        $this->instaHelp = new Help();
        $this->instaciamembrosRepositorio = new PacotesSmsRepository();
    }

    public function my_pacotes_sms()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $_SESSION['pesquisar'] = '';
        $this->render("my_pacote_sms", "layoutPacotes");
    }

    public function getPacotes()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $_SESSION['page'] = trim(strip_tags($_POST['page'] ?? ''));
        //
        $data = $this->instaciamembrosRepositorio->findPacotesms($_SESSION['tokenjwt'], $_SESSION['page']);
        //$data = $this->instaciamembrosRepositorio->findPacotesms($_SESSION['tokenjwt'], $_SESSION['page']);
        $this->clienteData = $data ?? [];
        //pacoteSistema
        if (empty($this->clienteData)) {
            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] =  true;
            $json = json_encode($response);
            echo $json;
            return;
        }
        $this->render("componentPacotes", "layoutPacotes");
    }
    public function cretepacotes()
    {
        $dataCliente = array(
            "nomepacote" => trim(strip_tags($_POST['nomepacote'])),
            "qtduser" => trim(strip_tags($_POST['qtduser'])),
            "qtd_sms_user" => trim(strip_tags($_POST['qtd_sms_user'])),
            "text_ideal" => trim(strip_tags($_POST['text_ideal'] ?? '')),
            "id_pacote" => trim(strip_tags($_POST['id_pacote'] ?? ''))
        );

        $is_date_obr = $this->instaciamembrosRepositorio->cretePacotesSms($_SESSION['tokenjwt'], $dataCliente);

        if (!empty($is_date_obr)) {
            if (!empty($is_date_obr->errorInfo)) {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] = $is_date_obr->status;
                $response["nomepacote"] = $is_date_obr->errorInfo->nomepacote ?? '';
                $response["qtduser"] = $is_date_obr->errorInfo->qtduser ?? '';
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

    public function deletaPacotes()
    {
        $token = $_POST['token'];
        $id_pacote = trim(strip_tags($_POST['id_pacote']));
        if ($this->newcreateCsrf->csrf_verifica($token)) {
            $data = $this->instaciamembrosRepositorio->deletePacotesSmsCliente($_SESSION['tokenjwt'], $id_pacote);
            
            if (!empty($data)) {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = $data->error;
                $response["mensagem"] =  $data->status;
                $json = json_encode($response);
                echo $json;
                return;

            } else {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] =   $data->status??'Não foi possível eliminar';
                $json = json_encode($response);
                echo $json;
                return;
            }
        } else {
            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] = true;
            $response["mensagem"] =   'token expirado';
            $json = json_encode($response);
            echo $json;
            return;
        }
    }
}
