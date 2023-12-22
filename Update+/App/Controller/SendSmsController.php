<?php

namespace App\Controller;

use App\Controller\Support\Session;
use App\Model\SenderIdRepository;
use App\Model\SmsSendRepository;
use Nextc\Controller\Action;

session_start();
class SendSmsController extends Action
{
    public $authCsrf;
    private $newcreateCsrf;
    public $clienteData;
    private $instaciaSendRepositorio;
    private $instaciasenderRepositorio;
    public $data_senderActive;

    public function __construct()
    {
        $this->newcreateCsrf = new Session();
        $this->newcreateCsrf->is_autheticationNot();
        $this->instaciaSendRepositorio = new SmsSendRepository();
        $this->instaciasenderRepositorio = new SenderIdRepository();
    }

    public function my_send_sms()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $this->data_senderActive = $this->instaciasenderRepositorio->findSenderActive($_SESSION['tokenjwt'], $_SESSION['page'] ?? '', $_SESSION['pesquisar']);
        $this->render("my_send_sms", "layoutSendSms");
    }
    public function my_agendar()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $this->data_senderActive = $this->instaciasenderRepositorio->findSenderActive($_SESSION['tokenjwt'], $_SESSION['page'] ?? '', $_SESSION['pesquisar']);
        $this->render("my_agendar", "layoutAgandas");
    }
    public function get_agendas()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $_SESSION['page'] = $_POST['page'] ?? '';
        $_SESSION['pesquisar'] = trim(strip_tags($_POST['pesquisar'] ?? ''));
        $data = $this->instaciaSendRepositorio->getAgendas($_SESSION['tokenjwt'], $_SESSION['page'], $_SESSION['pesquisar']);

        $this->clienteData = $data ?? [];
        if (empty($this->clienteData)) {
            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] = true;
            $json = json_encode($response);
            echo $json;
            return;
        }
        $this->render("component_agendas", "layoutAgandas");
    }

    public function getSmsSend()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $_SESSION['page'] = $_POST['page'] ?? '';
        $_SESSION['pesquisar'] = trim(strip_tags($_POST['pesquisar'] ?? ''));
        $data = $this->instaciaSendRepositorio->findOperationSendSms($_SESSION['tokenjwt'], $_SESSION['page'], $_SESSION['pesquisar']);

        $this->clienteData = $data ?? [];
        if (empty($this->clienteData)) {
            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] = true;
            $json = json_encode($response);
            echo $json;
            return;
        }
        //$_SESSION['sender_id_active'] = $this->clienteData->sender_id ?? [];
        $this->render("componentSmsSend", "layoutSendSms");
    }

    public function getsenderSend()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        header('Content-Type: application/json; charset=utf-8');
        $response["sender_id_active"] = $_SESSION['sender_id_active'] ?? [];
        $json = json_encode($response);
        echo $json;
        return;

        //
    }

    public function sendOperationSms()
    {
        $is_agenda = $_POST['is_agenda'] ?? 0;
        $dataCliente = array(
            "type_send" => trim(strip_tags($_POST['type_send'] ?? '')),
            "id_sender" => trim(strip_tags($_POST['id_sender'] ?? '')),
            "message_body" => trim(strip_tags($_POST['message_body'] ?? '')),
            "is_agenda" => ($is_agenda == 'on') ? 1 : 0,
            "start" => trim(strip_tags($_POST['start'] ?? '')),
            "file" => $_FILES['file'] ?? null,
            "number_phone" => trim(strip_tags($_POST['number_phone'] ?? '')),
            "id_grupo" => trim(strip_tags($_POST['id_grupo'] ?? '')),
        );

        $is_date_obr = $this->instaciaSendRepositorio->SendsmsSms($_SESSION['tokenjwt'], $dataCliente);
        if (!empty($is_date_obr)) {

            if (!empty($is_date_obr->errorInfo)) {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["campos"] = $is_date_obr->errorInfo ?? '';
                $response["mensagem"] = $is_date_obr->status;
                $response["message_body"] = $is_date_obr->errorInfo->message_body ?? '';
                $response["id_sender"] = $is_date_obr->errorInfo->id_sender ?? '';
                $response["type_send"] = $is_date_obr->errorInfo->type_send ?? '';
                $response["id_grupo"] = $is_date_obr->errorInfo->id_grupo ?? '';
                $response["number_phone"] = $is_date_obr->errorInfo->number_phone ?? '';
                $json = json_encode($response);
                echo $json;
                return;
            }

            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] = $is_date_obr->error ?? true;
            $response["mensagem"] = $is_date_obr->status ?? $is_date_obr->errorInfo ?? 'Não foi possivel enviar';
            $response["campos"] = $is_date_obr->errorInfo ?? '';
            $json = json_encode($response);
            echo $json;
            return;
        }
    }
}
