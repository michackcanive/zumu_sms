<?php

namespace App\Controller;

use App\Controller\Support\Help;
use App\Controller\Support\Session;
use App\Model\ContactoRepository;
use App\Model\PacotesSmsRepository;
use Nextc\Controller\Action;

session_start();
class ContactoController extends Action
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
        $this->instaciamembrosRepositorio = new ContactoRepository();
    }

    public function my_contacto()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $_SESSION['pesquisar'] = '';
        $this->render("my_contacto", "layoutContactos");
    }

    public function getContactos()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $_SESSION['page'] = $_POST['page'] ?? '';
        $_SESSION['pesquisar'] = trim(strip_tags($_POST['pesquisar'] ?? ''));
        //
        $data = $this->instaciamembrosRepositorio->get_Contacto($_SESSION['tokenjwt'], $_SESSION['page'],$_SESSION['pesquisar']);
        //$data = $this->instaciamembrosRepositorio->findPacotesms($_SESSION['tokenjwt'], $_SESSION['page']);
        $this->clienteData = $data ?? [];
        //pacoteSistema
        $this->render("componentContactos", "layoutContactos");
    }
    public function createContacto()
    {
        $dataCliente = array(
            "nome" => trim(strip_tags($_POST['nome_contacto']??'')),
            "email" => trim(strip_tags($_POST['email_contacto']??'')),
            "numero_telefone" => trim(strip_tags($_POST['telefone']??'')),
            "id_contacto" => trim(strip_tags($_POST['id_contacto']??''))
        );

        $is_date_obr = $this->instaciamembrosRepositorio->create_contacto($_SESSION['tokenjwt'], $dataCliente);

        if (!empty($is_date_obr)) {

            if (!empty($is_date_obr->errorInfo)) {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] = $is_date_obr->status;
                $response["nome"] = $is_date_obr->errorInfo->nome ?? '';
                $response["email"] = $is_date_obr->errorInfo->email ?? '';
                $response["numero_telefone"] = $is_date_obr->errorInfo->numero_telefone ?? '';
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
    public function importarContacto()
    {
        $dataCliente = array(
            "file" => $_FILES['file']??'',
        );

        $is_date_obr = $this->instaciamembrosRepositorio->importarContactos($_SESSION['tokenjwt'], $dataCliente);
        if (!empty($is_date_obr)) {

            if (!empty($is_date_obr->errorInfo)) {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] = $is_date_obr->status;
                $response["file"] = $is_date_obr->errorInfo->file ?? '';
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

    public function deletaContacto()
    {
        $token = $_POST['token'];
        $id_contacto = trim(strip_tags($_POST['id_contacto']));
        if ($this->newcreateCsrf->csrf_verifica($token)) {
            $data = $this->instaciamembrosRepositorio->delete_Contacto($_SESSION['tokenjwt'], $id_contacto);

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
