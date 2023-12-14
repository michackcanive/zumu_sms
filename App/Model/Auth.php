<?php

namespace App\Model;

use App\Controller\Services\Auth as ServicesAuth;
use Nextc\Model\Conteiner;
use Exception;
use DateTime;
use PDOException;

class Auth extends ServicesAuth
{
    public function authUser($emailUser, $senha)
    {
        return $this->login($emailUser, $senha);
    }
    public function register_Accouant($dataCliente)
    {
        return $this->register($dataCliente);
    }
    public function upatepassword($password, $id_usuario): bool
    {
        return boolval(1);
    }
    public function active_account($code,$token_jwt)
    {
        //activeAccount
        return $this->activeAccount($code,$token_jwt);

    }
    public function renviar_codigo_active($token_jwt)
    {
        //activeAccount
        return $this->renviar_codigo($token_jwt);

    }
}
