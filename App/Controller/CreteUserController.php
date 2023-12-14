<?php

namespace App\Controller;

use App\Controller\Session\InfUser;
use Nextc\Controller\Action;
use Nextc\Model\Conteiner;
use App\Controller\Support\Session;
use App\Controller\Support\Help;
use App\Controller\Support\SendEmail;
use App\Model\Auth;
use App\Model\CreateUser;
use App\Model\Site;

session_start();
class CreteUserController extends Action
{
    private $intanciaSession;
    private $configuracao;
    private $newcreateCsrf;
    public $authCsrf;
    public function __construct()
    {
        $this->intanciaSession = new Session();
        $this->newcreateCsrf = new Session();
        $instacia = new Site();
        $this->configuracao = $instacia->findConfigSite(EMAIL_EMPRESA);
    }

    public function creteuser()
    {

        $token = $_POST['token'];
        $email = trim(strip_tags($_POST['email'] ?? ''));
        $name = trim(strip_tags($_POST['name'] ?? ''));
        $telefone = trim(strip_tags($_POST['telefone'] ?? ''));
        $password = trim(strip_tags($_POST['password'] ?? ''));
        $terms = trim(strip_tags($_POST['terms'] ?? ''));


        if ($this->intanciaSession->csrf_verifica($token)) {

            if (empty($name) || empty($email) || empty($password) || empty($terms) || empty($telefone)) {

                header('Content-Type: application/json; charset=utf-8');
                $error['email'] = $_POST['email'] ? '' : 'Informe corretamente o seu e-mail';
                $error['telefone'] = $_POST['telefone'] ? '' : 'Informe corretamente o seu telefone';
                $error['password'] = $_POST['password'] ? '' : 'Informe corretamente o senha';
                $error['name'] = $_POST['name'] ? '' : 'Informe corretamente o seu name';
                $error['terms'] = $_POST['terms'] ? '' : 'Aceite os termos';
                $error["erro"] = true;
                $error["mensagem"] = "dados invalidos";
                $json = json_encode($error);
                echo $json;
                return;
            }

            if (!empty($user)) {
                header('Content-Type: application/json; charset=utf-8');
                $gerador["erro"] = true;
                $gerador["mensagem"] = "Usuário existente";
                $json = json_encode($gerador);
                echo $json;
                return;
            }
            $authUser = new Auth();
            $dataCliente = array(
                "email" => $email,
                "name" => $name,
                "telefone" => $telefone,
                "password" => $password,
                "tipo_de_conta" => 'subcliente',
                'email_empresa' => EMAIL_EMPRESA
            );

            $userLogin = $authUser->register_Accouant($dataCliente);

            if (!empty($userLogin)) {
                if ($userLogin->error) {
                    $error['email'] =  $userLogin->errorInfo->email ?? '';
                    $error['name'] =  $userLogin->errorInfo->name ?? '';
                    $error['telefone'] =  $userLogin->errorInfo->telefone ?? '';
                    $error['password'] = $userLogin->errorInfo->password ?? '';
                    $error["erro"] = true;
                    $error["mensagem"] = $userLogin->status;
                    $json = json_encode($error);
                    echo $json;
                    return;
                } else {
                    $user['email'] = $userLogin->user->email ?? '';
                    $user['name'] = $userLogin->user->name ?? '';
                    $user['tipo_de_conta'] = ($userLogin->user->typeUser == 'user') ? 'cliente' : 'membercliente';
                    $user['telefone_cliente'] = $userLogin->user->phone ?? '';
                    $user['id'] = $userLogin->user->id ?? '';
                    $user['is_membro_id_membro'] = $userLogin->user->is_membro ?? '';
                    $token = $userLogin->token ?? '';
                    $user['is_active']=$userLogin->user->is_active ?? '';;
                    $user['is_send_code']=$userLogin->user->is_send_code ?? '';;

                }
            } else {
                header('Content-Type: application/json; charset=utf-8');
                $gerador["erro"] = true;
                $gerador["mensagem"] = 'Não foi possivel criar conta';
                $json = json_encode($gerador);
                echo $json;
                return;
            }


            if (!$userLogin->error) {

                $this->intanciaSession->creteSessionUser($user['name'], $user['email'], $user['tipo_de_conta'], $user['telefone_cliente'] ?? '', $user['id'], $user['is_membro_id_membro'], $token, $user['is_active'],$user['is_send_code']);
                $infoUser = new InfUser();

                $infoUser->setcookies('email_cook', $user['email'], 60800, '');
                $infoUser->setcookies('name_cook', $user['name'], 60800, '');
                $infoUser->setcookies('telefone_cook',  $user['telefone_cliente'] ?? '', 60800, '');
                $insteciaEmail = new SendEmail();
                $corpocliente = $this->corpo('Obrigado por se cadastrar na plataforma <b>' . $_SESSION['NOME_SISTEMA'] . '</b>, <br>
                A ' . $_SESSION['NOME_SISTEMA'] . ' visa oferecer diversas linhas de serviços e produtos aos utilizadores,
                tais como: Biblioteca, Programação eclesiástica, Blog com devocionais, entre outros
                do âmbito informativo e administrativo.', $user['name'], 'Novo Usúario: ' . $user['name']);

                $insteciaEmail->sendEmail($user['email'], $user['name'], EMAIL_EMPRESA, $_SESSION['NOME_SISTEMA'], 'Bem-vindo', $corpocliente);
                header('Content-Type: application/json; charset=utf-8');
                $gerador["erro"] = false;
                $gerador["mensagem"] = $userLogin->status;
                $json = json_encode($gerador);
                echo $json;
                return;
            } else {
                header('Content-Type: application/json; charset=utf-8');
                $gerador["erro"] = true;
                $gerador["mensagem"] = "Erro inesperdo 😓";
                $json = json_encode($gerador);
                echo $json;
                return;
            }
            // creteUser

        } else {
            header('Content-Type: application/json; charset=utf-8');
            $gerador["erro"] = true;
            $gerador["mensagem"] = "page expirada";
            $json = json_encode($gerador);
            echo $json;
            return;
        }
    }

    public function active_account()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        // enviar codigo

        $this->render("active_account", "layout_login");
    }
    public function confimarCode()
    {
        $token = $_POST['token'];
        $codeConfimar = trim(strip_tags($_POST['codeConfimar'] ?? ''));
        if ($this->intanciaSession->csrf_verifica($token)) {
            //active_account
            $authUser = new Auth();
            $useractive = $authUser->active_account($codeConfimar,$_SESSION['tokenjwt']);

            if (!empty($useractive)) {

                if ($useractive->error) {
                    $error['code'] =  $useractive->errorInfo->code ?? '';
                    $error["erro"] = true;
                    $error["mensagem"] = $useractive->status ?? '';
                    $json = json_encode($error);
                    echo $json;
                    return;
                } else {
                    header('Content-Type: application/json; charset=utf-8');
                    $error["erro"] = false;
                    $_SESSION['is_active'] = 1;
                    $error["mensagem"] = $useractive->status ?? '';
                    $json = json_encode($error);
                    echo $json;
                    return;
                }
            } else {
                header('Content-Type: application/json; charset=utf-8');
                $gerador["erro"] = true;
                $gerador["mensagem"] = 'Não foi possivel activar a conta';
                $json = json_encode($gerador);
                echo $json;
                return;
            }
        } else {
            header('Content-Type: application/json; charset=utf-8');
            $gerador["erro"] = true;
            $gerador["mensagem"] = "page expirada";
            $json = json_encode($gerador);
            echo $json;
            return;
        }
    }

    public function renviar_codigo()
    {

        $token = $_POST['token']??'';
        if ($this->intanciaSession->csrf_verifica($token)) {
            //active_account
            $authUser = new Auth();
            $useractive = $authUser->renviar_codigo_active($_SESSION['tokenjwt']);


            if (!empty($useractive)) {

                if ($useractive->error) {
                    $error["erro"] = true;
                    $error["mensagem"] =  $useractive->status ?? 'conexão lenta';
                    $json = json_encode($error);
                    echo $json;
                    return;
                } else {
                    $error["erro"] = false;
                    $error["mensagem"] = $useractive->status ?? '';
                    $json = json_encode($error);
                    echo $json;
                    return;
                }
            } else {
                header('Content-Type: application/json; charset=utf-8');
                $gerador["erro"] = true;
                $gerador["mensagem"] = 'Não foi possivel activar a conta';
                $json = json_encode($gerador);
                echo $json;
                return;
            }
        } else {
            header('Content-Type: application/json; charset=utf-8');
            $gerador["erro"] = true;
            $gerador["mensagem"] = "page expirada";
            $json = json_encode($gerador);
            echo $json;
            return;
        }
    }


    private function corpo($textoCorpo, $nome_pessoa, $Assunto)
    {
        return $corpo = '';
    }
}
