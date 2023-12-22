<?php

namespace App\Controller;

use App\Controller\Support\Help;
use App\Controller\Support\Session;
use App\Model\UsersRepository;
use Nextc\Controller\Action;

session_start();
class UserSystmController extends Action
{
    public $authCsrf;
    private $newcreateCsrf;
    private $instaHelp;

    private $instaciaUserRepositorio;


    public function __construct()
    {
        $this->newcreateCsrf = new Session();
        $this->newcreateCsrf->is_autheticationNot();
        $this->instaHelp = new Help();
        $this->instaciaUserRepositorio = new UsersRepository();

        if ($_SESSION['tipo_de_conta'] == 'admin') {
        } else if ($_SESSION['tipo_de_conta'] == 'cliente') {
            die('Sem permissão');
            return;
        }else{
            return;
        }
    }

    public function my_user_all()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();

        $this->render("my_user_all", "layoutUsers");
    }
}
