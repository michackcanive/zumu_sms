<?php

namespace App\Controller;

use App\Controller\Support\Help;
use App\Controller\Support\Session;
use App\Model\GrupoRepository;
use Nextc\Controller\Action;

session_start();
class GruposController extends Action
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
        $this->instaciamembrosRepositorio = new GrupoRepository();
    }

    public function my_grupos()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $_SESSION['pesquisar'] = '';
        $this->render("my_grupos", "layoutGrupos");
    }
    public function add_contact()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $_SESSION['pesquisar'] = '';
        $id_grupo = $_GET['id_grupo'] ?? '';
        $this->render("add_contact", "layoutGrupos");
    }

    public function getGrupos()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $_SESSION['page'] = $_POST['page'] ?? '';
        $_SESSION['pesquisar'] = trim(strip_tags($_POST['pesquisar'] ?? ''));
        //
        $data = $this->instaciamembrosRepositorio->get_grupo($_SESSION['tokenjwt'], $_SESSION['page'], $_SESSION['pesquisar']);
        //$data = $this->instaciamembrosRepositorio->findPacotesms($_SESSION['tokenjwt'], $_SESSION['page']);
        $this->clienteData = $data ?? [];
        //pacoteSistema
        $this->render("componentGrupos", "layoutGrupos");
    }
    public function createGrupo()
    {
        $dataCliente = array(
            "nome_grupo" => trim(strip_tags($_POST['nome_grupo'] ?? '')),
            "descricao" => trim(strip_tags($_POST['descricao'] ?? '')),
        );

        $is_date_obr = $this->instaciamembrosRepositorio->creategrupo($_SESSION['tokenjwt'], $dataCliente);

        if (!empty($is_date_obr)) {

            if (!empty($is_date_obr->errorInfo)) {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] = $is_date_obr->status ?? '';
                $response["nome_grupo"] = $is_date_obr->errorInfo->nome_grupo ?? '';
                $response["descricao"] = $is_date_obr->errorInfo->descricao ?? '';
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
        header('Content-Type: application/json; charset=utf-8');
        $response["erro"] = true;
        $response["mensagem"] =  'server interval';
        $json = json_encode($response);
        echo $json;
        return;
    }

    public function deletagrupos()
    {
        $token = $_POST['token'];
        $id_contacto = trim(strip_tags($_POST['id_grupo']));
        if ($this->newcreateCsrf->csrf_verifica($token)) {
            $data = $this->instaciamembrosRepositorio->delete_grup($_SESSION['tokenjwt'], $id_contacto);

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
                $response["mensagem"] =   $data->status ?? 'Não foi possível eliminar';
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
    public function actionGrupo()
    {
        $dataCliente = array(
            "grupe_id" => trim(strip_tags($_GET['id_grupo'] ?? '')),
            "grupo_contact_id" => '',
            "typeAction" => trim(strip_tags($_POST['typeAction'] ?? '')),
        );
        $is_date_obr = $this->instaciamembrosRepositorio->creategrupo($_SESSION['tokenjwt'], $dataCliente);

        if (!empty($is_date_obr)) {

            if (!empty($is_date_obr->errorInfo)) {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] = $is_date_obr->status ?? '';
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
        header('Content-Type: application/json; charset=utf-8');
        $response["erro"] = true;
        $response["mensagem"] =  'server interval';
        $json = json_encode($response);
        echo $json;
        return;
    }
}
