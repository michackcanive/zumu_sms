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
}
