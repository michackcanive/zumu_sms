<?php

namespace App\Controller;

use App\Controller\Session\InfUser;
use Nextc\Controller\Action;
use App\Controller\Support\Session;
use App\Controller\Support\Help;
use App\Model\Auth;
use Exception;

session_start();
class AuthController extends Action
{
    private $intanciaSession;
    public function __construct()
    {
        $this->intanciaSession = new Session();
    }

    public function authuser()
    {
        try {
            $token = $_POST['token'];
            $email = trim(strip_tags($_POST['email']));
            $password = trim(strip_tags($_POST['password']));

            if ($this->intanciaSession->csrf_verifica($token)) {
                if (empty($email) || empty($password)) {
                    header('Content-Type: application/json; charset=utf-8');
                    $error['email'] = $_POST['email'] ? '' : 'Informe corretamente o seu e-mail';
                    $error['password'] = $_POST['password'] ? '' : 'Informe corretamente o senha';
                    $error["erro"] = true;
                    $error["mensagem"] = "Dados incorretos";
                    $json = json_encode($error);
                    echo $json;
                    return;
                }

                $authUser = new Auth();
                $userLogin = $authUser->authUser($email, $password);

                if (!empty($userLogin->error)) {
                    $error['email'] =  $userLogin->erroInfo->email ?? '';
                    $error['password'] = $userLogin->erroInfo->password ?? '';
                    $error["erro"] = true;
                    $error["mensagem"] = $userLogin->status;
                    $json = json_encode($error);
                    echo $json;
                    return;
                }
                if (empty($userLogin->data)) {
                    header('Content-Type: application/json; charset=utf-8');
                    $gerador["erro"] = true;
                    $gerador["mensagem"] = $userLogin->status ?? 'Não foi possivel logar';
                    $json = json_encode($gerador);
                    echo $json;
                    return;
                }


                $user['email'] = $userLogin->data->email ?? '';
                $user['name'] = $userLogin->data->name ?? '';
                $user['tipo_de_conta'] = ($userLogin->data->typeUser == 'user') ? 'cliente' : 'membercliente';
                $user['telefone_cliente'] = $userLogin->data->phone ?? '';
                $user['id'] = $userLogin->data->id ?? '';
                $user['is_membro_id_membro'] = $userLogin->data->is_membro ?? '';
                $token = $userLogin->token ?? '';

                $this->intanciaSession->creteSessionUser($user['name'], $user['email'], $user['tipo_de_conta'] ?? '', $user['telefone_cliente'] ?? '', $user['id'], $user['is_membro_id_membro'] ?? '', $token);
                $infoUser = new InfUser();

                $infoUser->setcookies('email_cook', $user['email'], 60800, '');
                $infoUser->setcookies('name_cook', $user['name'], 60800, '');

                header('Content-Type: application/json; charset=utf-8');
                $gerador["erro"] = false;
                $premero = explode(' ', $user['name']);
                $gerador["mensagem"] = "Ben-vindo(a)" . $premero[0] ?? '';
                $json = json_encode($gerador);
                echo $json;
                return;
            } else {
                header('Content-Type: application/json; charset=utf-8');
                $gerador["erro"] = true;
                $gerador["mensagem"] = "Pagena expirada";
                $json = json_encode($gerador);
                echo $json;
                return;
            }
        } catch (Exception $e) {
            header('Content-Type: application/json; charset=utf-8');
            $gerador["erro"] = true;
            $gerador["mensagem"] = "Não foi possível entrar";
            $json = json_encode($gerador);
            echo $json;
            return;
        }
    }
}
