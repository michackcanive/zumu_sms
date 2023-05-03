<?php

namespace App\Controller;

use Nextc\Controller\Action;
use App\Controller\Support\Session;
use App\Controller\Support\Help;
use App\Controller\Support\SendEmail;
use App\Model\Auth;

session_start();
class ForgotPasswordController extends Action
{
    private $intanciaSession;
    private $instaHelp;
    public $authCsrf;
    public function __construct()
    {
        $this->intanciaSession = new Session();
        $this->instaHelp = new Help();
    }

    /**
     * Inicialização forgot
     *
     * @return void
     */
    public function forgot_password()
    {
        $this->intanciaSession->is_authetication();
        $this->authCsrf = $this->intanciaSession->createCsrf();
        $this->render("forgot_password", "layout_login");
    }

    /**
     * Para enviar código de código
     *
     * @return void
     */
    public function requestnewpassword()
    {
        $token = $_POST['token'];
        $email = trim(strip_tags($_POST['my_email']));

        if ($this->intanciaSession->csrf_verifica($token)) {

            if (empty($email)) {
                header('Content-Type: application/json; charset=utf-8');
                $error['email'] = $_POST['email'] ? '' : 'Informe corretamente o seu e-mail';
                $error["erro"] = true;
                $error["mensagem"] = "Dados incorretos";
                $json = json_encode($error);
                echo $json;
                return;
            }

            $authUser = new Auth();
            $user = $authUser->authUser('cd','');

            if (empty($user)) {
                $error['email'] =  'Este e-mail não esta regitrado';
                $error["erro"] = true;
                $error["mensagem"] = "Dados incorretos";
                $json = json_encode($error);
                echo $json;
                return;
            }
            $_SESSION['email_new_code'] = $user['email'];
            $codeGerado = $this->instaHelp->gerar4number();
            $_SESSION['code_fog'] = $codeGerado;
            $instacia = new SendEmail();
            $para_email = $user['email'];
            $para_nome = $user['name'];
            $pemeiroNome = explode(' ', $para_nome);
            $email = 'gestao@zumu.com';
            $suportezumu_sms = 'Segurança zumu_sms';
            $messagem =  $_SESSION['code_fog'];

            $corpo = $this->recuperacaoDesenha($messagem, $pemeiroNome[0]);

            if ($instacia->sendEmail($para_email, $para_nome, $email, $suportezumu_sms, 'Recuperação de Conta', $corpo)) {
                // chama rota confirmação do codigo
                $_SESSION['activetioConfirmacao'] = true;
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = false;
                $response["mensagem"] =   'Verifque a sua caixa electrónica';
                $json = json_encode($response);
                echo $json;
                return;
            } else {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] =   'Não foi possível enviar o seu código';
                $json = json_encode($response);
                echo $json;
                return;
            }
        } else {
            header('Content-Type: application/json; charset=utf-8');
            $gerador["erro"] = true;
            $gerador["mensagem"] = "Sessão expirada";
            $json = json_encode($gerador);
            echo $json;
            return;
        }
    }


    public function recuperacaoDesenha($codigo, $nome){

    }

    public function forgot_confirme()
    {
        if (!empty($_SESSION['activetioConfirmacao'])) {
            unset($_SESSION['activetioConfirmacao']);
            $_SESSION['activaRedifinir'] = true;
            $this->intanciaSession->is_authetication();
            $this->authCsrf = $this->intanciaSession->createCsrf();
            $this->render("forgot_confirme", "layout_login");
        }
    }

    /**
     * Virificar se o código esta certo
     *
     * @return void
     */
    public function confirmarCode()
    {

        $token = $_POST['token'];

        $my_code = trim(strip_tags($_POST['my_code']));/* */

        if ($this->intanciaSession->csrf_verifica($token)) {

            if ($_SESSION['code_fog'] == $my_code) {
                // chama a rota  para redifinir nova senha
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = false;
                $response["mensagem"] = 'Código verificado';
                $json = json_encode($response);
                echo $json;
                return;
            } else {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] =   'Código incorreto';
                $json = json_encode($response);
                echo $json;
                return;
            }
        } else {
            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] = true;
            $response["mensagem"] =   'Não foi possivel redifiner';
            $json = json_encode($response);
            echo $json;
            return;
        }
    }

    /**
     * Nova senha
     *
     * @return void
     */
    public function redifinirsenha()
    {
        if (!empty($_SESSION['activaRedifinir'])) {
            unset($_SESSION['activaRedifinir']);
            $_SESSION['activa_new'] = true;
            $this->intanciaSession->is_authetication();
            $this->authCsrf = $this->intanciaSession->createCsrf();
            $this->render("forgot_new_code", "layout_login");
        }
    }

    public function configuracaodeNovasenha()
    {
        if (empty($_SESSION['activa_new'])) {
            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] = true;
            $response["mensagem"] =   'Sem permissão';
            $json = json_encode($response);
            echo $json;
            return;
        }

        unset($_SESSION['activa_new']);
        $my_code_new = trim(strip_tags($_POST['new_code']));/* */
        $token = $_POST['token'];

        if ($this->intanciaSession->csrf_verifica($token)) {
            $email = $_SESSION['email_new_code'];
            $authUser = new Auth();
            $user = $authUser->authUser($email,'');
            $heshtoken = $this->instaHelp->createHash($my_code_new);

            if ($authUser->upatepassword($heshtoken, $user['id'])) {
                // chamar senha login
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = false;
                $response["mensagem"] = 'Senha redifinida';
                $json = json_encode($response);
                echo $json;
                return;
            } else {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] =   'Não foi possivel redifiner nova senha';
                $json = json_encode($response);
                echo $json;
                return;
            };
        } else {
            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] = true;
            $response["mensagem"] =   'Não foi possivel';
            $json = json_encode($response);
            echo $json;
            return;
        }
    }
}
