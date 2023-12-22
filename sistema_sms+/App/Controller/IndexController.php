<?php

namespace App\Controller;

use App\Controller\Session\InfUser;
use App\Controller\Support\Help;
use App\Controller\Support\SendEmail;
use App\Controller\Support\Session;
use App\Model\PacotesSmsRepository;
use App\Model\Site;
use Nextc\Controller\Action;
use Exception;

session_start();
class IndexController extends Action
{
    private $newcreateCsrf;
    private $instaHelp;
    public $view;
    public $configuracao;
    public $publicacoesadmin;
    private $instaciaCategoryRepositorio;
    public $infoUser;
    public $clienteData;
    private $instaciamembrosRepositorio;
    public $authCsrf;

    public function __construct()
    {
        $this->instaHelp = new Help();
        $this->newcreateCsrf = new Session();
        $instacia = new Site();
        $this->configuracao = $instacia->findConfigSite(EMAIL_EMPRESA);
        $_SESSION['NOME_SISTEMA'] = $this->configuracao->dataEmpresa->nome_sistema ?? '';
        $_SESSION['NIF_SISTEMA'] = $this->configuracao->dataEmpresa->nif ?? '';
        $_SESSION['hora_atendimento_inicio'] = $this->configuracao->dataEmpresa->hora_atendimento_inicio ?? '';
        $_SESSION['hora_atendimento_termino'] = $this->configuracao->dataEmpresa->hora_atendimento_termino ?? '';
        $_SESSION['LOGO_SISTEMA'] = $this->configuracao->dataEmpresa->logo_sistema ?? '';
        $_SESSION['NOME_EMAIL'] = $this->configuracao->dataEmpresa->email ?? '';
        $_SESSION['NOME_TELEFONE'] = $this->configuracao->dataEmpresa->contacto ?? '';
        $_SESSION['BENEFICIARIO_SISTEMA'] = $this->configuracao->dataEmpresa->beneficiario ?? '';
        $_SESSION['IBAN_SISTEMA'] = $this->configuracao->dataEmpresa->iban ?? '';

        $_SESSION['BENEFICIARIO_SISTEMA_ZUMU'] =  $this->configuracao->beneficiario_zumu  ?? '';
        $_SESSION['IBAN_SISTEMA_ZUMU'] =  $this->configuracao->iban_zumu  ?? '';

        $this->instaciamembrosRepositorio = new PacotesSmsRepository();
        //<?=$this->configuracao->dataEmpresa->nome_sistema??''
        $this->infoUser = new InfUser();
    }
    //Index
    public function index()
    {

        $this->newcreateCsrf->is_authetication();
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $this->render("index", "layout_site");
    }

    public function login()
    {
        $this->newcreateCsrf->is_authetication();
        $this->authCsrf = $this->newcreateCsrf->createCsrf();

        if (!empty($this->infoUser->getcookies('email_cook')) && empty($_GET['type']))
            $this->render("scree", "layout_login");
        $this->render("login", "layout_login");
    }

    //registrar
    public function register()
    {
        $this->newcreateCsrf->is_authetication();
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $this->render("register", "layout_login");
    }
    //registrar



    public function termos_condicoes()
    {
        $instacia = new Site();
        $this->configuracao = $instacia->findConfigSite(EMAIL_EMPRESA);
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $this->render("termos_condicoes", "layout_site");
    }
    public function getPacotesSite()
    {
        $data = $this->instaciamembrosRepositorio->findPacotesmssite(EMAIL_EMPRESA);
       // $data = $this->instaciamembrosRepositorio->findPacotesms($_SESSION['tokenjwt'], $_SESSION['page']);

        $this->clienteData = $data ?? [];
        //pacoteSistema
        $this->render("componetesmsSite", "layout_site");
    }
}
