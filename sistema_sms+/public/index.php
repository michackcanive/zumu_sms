<?php

ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

////////////////////PRIVILEGIANDOS///////////////////////////

require_once "../vendor/autoload.php";
require_once "./config.php";

use App\Router\Route;
use Nextc\Init\Close;

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
    Route::setRoute("/inicio", "AppController-inicio");
} else {
    ///////////////////////Router////////////////////////////
    switch (Close::control()) {
        /////////////////////////////////IndexController
        case '/':
            Route::setRoute("/index", "IndexController-index");
            break;

        case '/contact':
            Route::setRoute("/contact", "IndexController-contact");
            break;

        case '/termos_condicoes':
            Route::setRoute("/termos_condicoes", "IndexController-termos_condicoes");
            break;

        ////////////////////////////////////////////////////////
        case '/envioemail':
            Route::setRoute("/envioemail", "IndexController-envioemail");
            break;
        case '/envioemail_temos':
            Route::setRoute("/envioemail_temos", "MembroIgrejasAcessoController-envioemail_temos");
            break;
        case '/envioemail_temos_email':
            Route::setRoute("/envioemail_temos_email", "MembroIgrejasAcessoController-envioemail_temos_email");
            break;
        case '/login':
            Route::setRoute("/login", "IndexController-login");
            break;
        case '/register':
            Route::setRoute("/register", "IndexController-register");
            break;
        case '/confimarCode':
            Route::setRoute("/confimarCode", "CreteUserController-confimarCode");
            break;
        case '/renviar_codigo':
            Route::setRoute("/renviar_codigo", "CreteUserController-renviar_codigo");
            break;

        case '/requestnewpassword':
            Route::setRoute("/requestnewpassword", "ForgotPasswordController-requestnewpassword");
            break;

        case '/forgot_password':
            Route::setRoute("/forgot_password", "ForgotPasswordController-forgot_password");
            break;

        case '/forgot_confirme':
            Route::setRoute("/forgot_confirme", "ForgotPasswordController-forgot_confirme");
            break;

        case '/redifinirsenha':
            Route::setRoute("/redifinirsenha", "ForgotPasswordController-redifinirsenha");
            break;

        case '/confirmarCode':
            Route::setRoute("/confirmarCode", "ForgotPasswordController-confirmarCode");
            break;
        case '/user_profile':
            Route::setRoute("/user_profile", "PerfilController-user_profile");
            break;
        case '/update_user':
            Route::setRoute("/update_user", "PerfilController-update_user");
            break;
        case '/update_user_senha':
            Route::setRoute("/update_user_senha", "PerfilController-update_user_senha");
            break;

        //
        case '/configuracaodeNovasenha':
            Route::setRoute("/configuracaodeNovasenha", "ForgotPasswordController-configuracaodeNovasenha");
            break;

        case '/creteuser':
            Route::setRoute("/creteuser", "CreteUserController-creteuser");
            break;
        case '/active_account':
            Route::setRoute("/active_account", "CreteUserController-active_account");
            break;

        ////////////////////////////////////////
        case '/authuser':
            Route::setRoute("/authuser", "AuthController-authuser");
            break;

        case '/dashboard':
            Route::setRoute("/dashboard", "HomeController-dashboard");
            break;
        case '/getsms_chart':
            Route::setRoute("/getsms_chart", "HomeController-getsms_chart");
            break;

        ///////////////////////CONTACTO//////////////////////////////

        case '/my_contacto':
            Route::setRoute("/my_contacto", "ContactoController-my_contacto");
            break;
        case '/createContacto':
            Route::setRoute("/createContacto", "ContactoController-createContacto");
            break;
        case '/importarContacto':
            Route::setRoute("/importarContacto", "ContactoController-importarContacto");
            break;
        case '/getContactos':
            Route::setRoute("/getContactos", "ContactoController-getContactos");
            break;

        ///////GRUPOS//////////////////////////////////
        case '/my_grupos':
            Route::setRoute("/my_grupos", "GruposController-my_grupos");
            break;
        case '/add_contact':
            Route::setRoute("/add_contact", "GruposController-add_contact");
            break;
        case '/createGrupo':
            Route::setRoute("/createGrupo", "GruposController-createGrupo");
            break;
        case '/getGrupos':
            Route::setRoute("/getGrupos", "GruposController-getGrupos");
            break;

        //////////////////////////////////////////////////////

        /////////////////SENDER ID////////////////
        case '/my_sender':
            Route::setRoute("/my_sender", "SenderController-my_sender");
            break;
        case '/getSender':
            Route::setRoute("/getSender", "SenderController-getSender");
            break;
        case '/getBuscarSender':
            Route::setRoute("/getBuscarSender", "SenderController-getBuscarSender");
            break;
        case '/creteObreiros':
            Route::setRoute("/creteObreiros", "SenderController-creteObreiros");
            break;
        case '/deletaobreiro':
            Route::setRoute("/deletaobreiro", "SenderController-deletaobreiro");
            break;
        case '/processarsenderID':
            Route::setRoute("/processarsenderID", "SenderController-processarsenderID");
            break;
        /////////////////////////////////////////////////////
        case '/my_membro':
            Route::setRoute("/my_membro", "MembroController-my_membro");
            break;
        case '/getMember':
            Route::setRoute("/getMember", "MembroController-getMember");
            break;
        case '/cretemember':
            Route::setRoute("/cretemember", "MembroController-cretemember");
            break;
        case '/getBuscarCliente':
            Route::setRoute("/getBuscarCliente", "MembroController-getBuscarCliente");
            break;
        case '/deletamember':
            Route::setRoute("/deletamember", "MembroController-deletamember");
            break;

        ///////////////////////////////////////////////
        case '/my_pacotes_sms':
            Route::setRoute("/my_pacotes_sms", "PacotesController-my_pacotes_sms");
            break;
        case '/getPacotes':
            Route::setRoute("/getPacotes", "PacotesController-getPacotes");
            break;
        case '/getPacotesSite':
            Route::setRoute("/getPacotesSite", "IndexController-getPacotesSite");
            break;
        case '/cretepacotes':
            Route::setRoute("/cretepacotes", "PacotesController-cretepacotes");
            break;
        case '/deletapacotes':
            Route::setRoute("/deletapacotes", "PacotesController-deletapacotes");
            break;
        //////////////////////////////////////////////

        case '/my_gestao_sms':
            Route::setRoute("/my_gestao_sms", "GestaoSmsController-my_gestao_sms");
            break;
        case '/my_vendas_sms':
            Route::setRoute("/my_vendas_sms", "GestaoSmsController-my_vendas_sms");
            break;

        case '/creteOperationSms':
            Route::setRoute("/creteOperationSms", "GestaoSmsController-creteOperationSms");
            break;
        case '/getOperation':
            Route::setRoute("/getOperation", "GestaoSmsController-getOperation");
            break;
        case '/getOperationvenda':
            Route::setRoute("/getOperationvenda", "GestaoSmsController-getOperationvenda");
            break;

        //////////////////////////////////////////////////////////

        case '/my_send_sms':
            Route::setRoute("/my_send_sms", "SendSmsController-my_send_sms");
            break;
        case '/my_agendar':
            Route::setRoute("/my_agendar", "SendSmsController-my_agendar");
            break;
        case '/getSmsSend':
            Route::setRoute("/getSmsSend", "SendSmsController-getSmsSend");
            break;
            case '/get_agendas':
                Route::setRoute("/get_agendas", "SendSmsController-get_agendas");
                break;
        case '/creteOperationSms':
            Route::setRoute("/creteOperationSms", "SendSmsController-creteOperationSms");
            break;
        case '/getsenderSend':
            Route::setRoute("/getsenderSend", "SendSmsController-getsenderSend");
            break;

        case '/sendOperationSms':
            Route::setRoute("/sendOperationSms", "SendSmsController-sendOperationSms");
            break;

        //////////////////////////////////////////////////////////

        /* SOLICITAÇÕES DE PACOTES */
        case '/my_solitation_card':
            Route::setRoute("/my_solitation_card", "SolicitacaoPacotesController-my_solicitacao");
            break;
        case '/my_comprar_sms':
            Route::setRoute("/my_comprar_sms", "SolicitacaoPacotesController-my_comprar_sms");
            break;
        case '/getsolicitacao_carregamentos':
            Route::setRoute("/getsolicitacao_carregamentos", "SolicitacaoPacotesController-getsolicitacao_carregamentos");
            break;
        case '/createsolictacao':
            Route::setRoute("/createsolictacao", "SolicitacaoPacotesController-createsolictacao");
            break;
        case '/activarcarregamento':
            Route::setRoute("/activarcarregamento", "SolicitacaoPacotesController-activarcarregamento");
            break;
        case '/comprarsms':
            Route::setRoute("/comprarsms", "SolicitacaoPacotesController-comprarsms");
            break;

        /* FIM/////////////////////////////////////////////////////// */

        case '/my_config':
            Route::setRoute("/my_config", "ConfigOmniController-my_config");
            break;

        case '/creteConfg':
            Route::setRoute("/creteConfg", "ConfigOmniController-creteConfg");
            break;

        case '/logout':
            Route::setRoute("/logout", "HomeController-logout");
            break;

        //FIM
        default:
            Route::setRoute("/", "IndexController-index");
    }
}
