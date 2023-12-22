<?php

namespace App\Controller;

use App\Controller\Support\Help;
use App\Controller\Support\Session;
use App\Model\MembroRepository;
use App\Model\SenderIdRepository;
use App\Model\Site;
use Nextc\Controller\Action;

session_start();
class SenderController extends Action
{
    public $authCsrf;
    private $newcreateCsrf;
    private $instaHelp;

    private $instaciaObreirosRepositorio;
    private $instaciamembrosRepositorio;
    public $actvSendAcount;
    public $senderData;
    public $pendetSendAcount;
    public $configuracao;


    public function __construct()
    {
        $this->newcreateCsrf = new Session();
        $this->newcreateCsrf->is_autheticationNot();
        $this->instaHelp = new Help();
        $this->instaciaObreirosRepositorio = new SenderIdRepository();
        $instacia = new Site();

        $this->configuracao = $instacia->findConfigSite(EMAIL_EMPRESA);

        if ($_SESSION['tipo_de_conta'] == 'admin') {
        } else if ($_SESSION['tipo_de_conta'] == 'cliente') {
        } else {
            return;
        }
    }

    public function my_sender()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $_SESSION['pesquisar'] = '';
        $this->render("my_sender", "layoutSender");
    }
    public function getSender()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $_SESSION['pesquisar'] = trim(strip_tags($_POST['pesquisar'] ?? ''));
        $_SESSION['page'] = $_POST['page'] ?? '';
        $data = $this->instaciaObreirosRepositorio->findSender($_SESSION['tokenjwt'], $_SESSION['page'] ?? '', $_SESSION['pesquisar']);
        $this->senderData = $data ?? [];
        if (empty($this->senderData)) {
            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] =  true;
            $json = json_encode($response);
            echo $json;
            return;
        }
        $this->render("componentSender", "layoutSender");
    }


    public function creteObreiros()
    {
        $token = $_POST['token'];

        $nome_sender = $_POST['nome_sender'];
        $is_date_obr = $this->instaciaObreirosRepositorio->creteObreiros($_SESSION['tokenjwt'], $nome_sender);

        if (!empty($is_date_obr)) {

            if (!empty($is_date_obr->errorInfo)) {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] = $is_date_obr->errorInfo->name_sender_id;
                $json = json_encode($response);
                echo $json;
                return;
            }

            if ($is_date_obr->error) {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] =   $is_date_obr->status;
                $json = json_encode($response);
                echo $json;
                return;
            }

            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] = false;
            $response["mensagem"] =   $is_date_obr->status;
            $json = json_encode($response);
            echo $json;
            return;
        }
    }

    public function deletaobreiro()
    {

        $token = $_POST['token'];
        $id_sender = trim(strip_tags($_POST['id_sender']));
        if ($this->newcreateCsrf->csrf_verifica($token)) {
            $data = $this->instaciaObreirosRepositorio->deleteSender($_SESSION['tokenjwt'], $id_sender);
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
                $response["mensagem"] =   'Não foi possível eliminar';
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

    public function processarsenderID()
    {
        $token = $_POST['token'];
        $id_sender = trim(strip_tags($_POST['id_sender']));
        if ($this->newcreateCsrf->csrf_verifica($token)) {
            $data = $this->instaciaObreirosRepositorio->pocessarSenderid($_SESSION['tokenjwt'], $id_sender);

            if (!empty($data)) {
                if (!empty($data->errorInfo)) {
                    header('Content-Type: application/json; charset=utf-8');
                    $response["erro"] =$data->error;
                    $response["mensagem"] =  $data->status;
                    $json = json_encode($response);
                    echo $json;
                    return;
                }
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = $data->error;
                $response["mensagem"] =  $data->status;
                $json = json_encode($response);
                echo $json;
                return;
            } else {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] =   'Não foi possível eliminar';
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
