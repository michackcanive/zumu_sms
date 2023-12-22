<?php

namespace App\Controller;

use App\Controller\Support\Help;
use App\Controller\Support\Session;
use App\Model\CreateUser;
use App\Model\IgrejasRepository;
use App\Model\MembroRepository;
use Nextc\Controller\Action;

session_start();
class MembroController extends Action
{
    public $authCsrf;
    private $newcreateCsrf;
    private $instaHelp;
    public $clienteData;
    private $instaciamembrosRepositorio;


    public function __construct()
    {
        $this->newcreateCsrf = new Session();
        $this->newcreateCsrf->is_autheticationNot();
        $this->instaHelp = new Help();
        $this->instaciamembrosRepositorio = new MembroRepository();

        if ($_SESSION['tipo_de_conta'] == 'admin') {
        } else if ($_SESSION['tipo_de_conta'] == 'cliente') {
        } else {
            return;
        }
    }

    public function my_membro()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $_SESSION['pesquisar']='';
        $this->render("my_membro", "layoutMembro");
    }

    public function getMember()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $_SESSION['page'] = $_POST['page'] ?? '';
        $_SESSION['pesquisar'] = trim(strip_tags($_POST['pesquisar'] ?? ''));
        $data = $this->instaciamembrosRepositorio->findmember($_SESSION['tokenjwt'], $_SESSION['page'] ?? '', $_SESSION['pesquisar']);
        $this->clienteData = $data ?? [];
        if (empty($this->clienteData)) {
            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] =  true;
            $json = json_encode($response);
            echo $json;
            return;
        }
        $this->render("componentCliente", "layoutSender");
    }
    public function cretemember()
    {
        $dataCliente = array(
            "nome_membro" => trim(strip_tags($_POST['nome_membro'])),
            "email_membro" => trim(strip_tags($_POST['email_membro'])),
            "telefone" => trim(strip_tags($_POST['telefone'])),
            "user_id" => trim(strip_tags($_POST['user_id'] ?? '')),
            "password" => trim(strip_tags($_POST['password']))
        );

        $is_date_obr = $this->instaciamembrosRepositorio->cretemember($_SESSION['tokenjwt'], $dataCliente);

        if (!empty($is_date_obr)) {
            if (!empty($is_date_obr->errorInfo)) {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] = $is_date_obr->status;
                $response["email_membro"] = $is_date_obr->errorInfo->email_membro ?? '';
                $response["telefone"] = $is_date_obr->errorInfo->telefone ?? '';
                $response["password"] = $is_date_obr->errorInfo->password ?? '';
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

    public function deletamember()
    {

        $token = $_POST['token'];
        $id_sender = trim(strip_tags($_POST['id_membro']));
        if ($this->newcreateCsrf->csrf_verifica($token)) {
            $data = $this->instaciamembrosRepositorio->deleteMemberCliente($_SESSION['tokenjwt'], $id_sender);
            if (!empty($data->error == false)) {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = $data->error;
                $response["mensagem"] =   'Eliminado';
                $json = json_encode($response);
                echo $json;
                return;
            } else {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] =   $data->status;
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
