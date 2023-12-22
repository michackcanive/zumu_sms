<?php

namespace App\Controller;

use App\Controller\Support\Help;
use App\Controller\Support\Session;
use App\Model\HomeRepository;
use App\Model\Site;
use Nextc\Controller\Action;

session_start();
class HomeController extends Action
{
    private $connect_tw;
    public $authCsrf;
    private $newcreateCsrf;
    private $instaciaHomeRepository;
    private $instaciaSiteRepositorio;
    public $configuracoes;
    public $total_do_ano;
    public $instaHelp;
    public $smsCount;
    public $sms_send;
    public $amunto_value;



    public function __construct()
    {
        //$this->is_auth();

        $this->newcreateCsrf = new Session();
        $this->newcreateCsrf->is_autheticationNot();
        $this->instaHelp = new Help();
        $this->instaciaSiteRepositorio = new Site();
        $this->configuracoes = $this->instaciaSiteRepositorio->findConfigSite(EMAIL_EMPRESA);
        $this->instaciaHomeRepository = new HomeRepository();

        if ($_SESSION['tipo_de_conta'] == 'admin') {
        } else if ($_SESSION['tipo_de_conta'] == 'cliente') {
        }
    }

    public function dashboard()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();

        //getInfoUsers
        $_SESSION['Month'] = trim(strip_tags($_POST['Month'] ?? ''));
        $dateUsers = $this->instaciaHomeRepository->getInfoUsers($_SESSION['tokenjwt'], $_SESSION['Month']);
        $this->smsCount = $dateUsers->my_sms ?? 0;
        $this->sms_send = $dateUsers->sms_send ?? 0;
        $this->amunto_value = $dateUsers->amunto_value ?? 0;

        $i = 1;
        foreach ($dateUsers->dataRegistered ?? [] as $value) {
            $this->total_do_ano[$i] = $value;
            $i++;
        }

        $_SESSION['pesquisar'] = '';
        $this->render("dashboard", "layoutmembrouser");
    }
    public function getsms_chart()
    {
        $Year = trim(strip_tags($_POST['Year'] ?? ''));
        $dateUsers = $this->instaciaHomeRepository->getsmsdataChart($_SESSION['tokenjwt'], $Year);
        $i = 1;
        foreach ($dateUsers->dataRegistered ?? [] as $value) {
            $this->total_do_ano[$i] = $value;
            $i++;
        }
        $this->render("charComponet", "layoutmembrouser");
    }

    public function logout()
    {
        $this->sair();
    }
}
