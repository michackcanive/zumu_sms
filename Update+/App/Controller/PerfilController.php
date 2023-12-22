<?php

namespace App\Controller;

use App\Controller\Support\Help;
use App\Controller\Support\Session;
use App\Model\CreateUser;
use App\Model\GestaoModel;
use App\Model\IgrejasRepository;
use App\Model\MembroRepository;
use App\Model\UserProfileModel;
use Nextc\Controller\Action;

session_start();
class PerfilController extends Action
{
    public $authCsrf;
    private $newcreateCsrf;
    private $instaHelp;
    private $instaciaIgrejasRepositorio;
    private $instaciaUserRepositorio;

    public function __construct()
    {
        $this->newcreateCsrf = new Session();
        $this->newcreateCsrf->is_autheticationNot();
        $this->instaHelp = new Help();
        $this->instaciaUserRepositorio = new UserProfileModel();

        if ($_SESSION['tipo_de_conta'] == 'admin') {
        } else if ($_SESSION['tipo_de_conta'] == 'cliente') {
        } else {
            return;
        }
    }

    public function user_profile()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $this->user = $this->instaciaUserRepositorio->finduser($_SESSION['idUser']);
        $this->render("my_user_profile", "layoutProfile");
    }
    public function update_user()
    {
        $token = $_POST['token'];
        $name_user = trim(strip_tags($_POST['user_name'] ?? ''));
        $senha = trim(strip_tags($_POST['senha_user'] ?? ''));

        if ($this->newcreateCsrf->csrf_verifica($token)) {

            $this->user = $this->instaciaUserRepositorio->finduser($_SESSION['idUser']);
            $help = new Help();
            if (!$help->verifyHash($senha, $this->user['password'])) {
                $error['password'] =  'senha incorreta';
                $error["erro"] = true;
                $error["mensagem"] = "Dados incorretos";
                $json = json_encode($error);
                echo $json;
                return;
            }

            if (empty($name_user)) {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] = 'Nome invalido';
                $json = json_encode($response);
                echo $json;
                return;
            }
            $isupdate = $this->instaciaUserRepositorio->updateUser($name_user, $_SESSION['idUser']);
            if (!empty($isupdate)) {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = false;
                $response["mensagem"] = 'Sucesso';
                $json = json_encode($response);
                echo $json;
                return;
            } else {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] = 'Não foi possível';
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
    public function update_user_senha()
    {
        $token = $_POST['token'];
        $senha_actual = trim(strip_tags($_POST['senha_actual'] ?? ''));
        $senha_nova = trim(strip_tags($_POST['senha_nova'] ?? ''));
        $senha_confirmacao = trim(strip_tags($_POST['senha_confirmacao'] ?? ''));

        if ($this->newcreateCsrf->csrf_verifica($token)) {

            if (!($senha_nova === $senha_confirmacao)) {
            }

            $this->user = $this->instaciaUserRepositorio->finduser($_SESSION['idUser']);
            $help = new Help();
            if (!$help->verifyHash($senha_actual, $this->user['password'])) {
                header('Content-Type: application/json; charset=utf-8');
                $error["erro"] = true;
                $error["mensagem"] = "Senha Actual incorretos";
                $json = json_encode($error);
                echo $json;
                return;
            }

            if (empty($senha_actual)) {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] = 'senha nova invalida';
                $json = json_encode($response);
                echo $json;
                return;
            }
            $senha_actual_hash = $this->instaHelp->createHash($senha_actual);
            $isupdate = $this->instaciaUserRepositorio->updateUserSenha($senha_actual_hash, $_SESSION['idUser']);
            if ($isupdate) {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = false;
                $response["mensagem"] = 'Sucesso';
                $json = json_encode($response);
                echo $json;
                return;
            } else {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] = 'Não foi possível';
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
