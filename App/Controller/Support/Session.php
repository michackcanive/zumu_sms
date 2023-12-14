<?php

namespace App\Controller\Support;

use Exception;
use Nextc\Model\Conteiner;

class Session
{

    private $operacao_sms;

    public function __get($atributos)
    {
        return $this->$atributos;
    }
    public function __set($atributos, $value)
    {
        $this->$atributos = $value;
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function createCsrf(): string
    {
        return $_SESSION['csrf_token'] = base64_encode(random_bytes(20));
    }

    /**
     * csrf_verifica
     * @param [type] $token
     * @return boolean
     */
    public function csrf_verifica($token): bool
    {
        if (!empty($_SESSION['csrf_token'])) {
            if ($token == $_SESSION['csrf_token']) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function creteSessionUser($nameUser, $emailUser, $tipoDeConta, $telefone, $idUser, $is_membro_id_membro, $token, $is_active,$is_send_code)
    {
        $_SESSION['nameUser'] = $nameUser;
        $_SESSION['emailUser'] = $emailUser ?? '';
        $_SESSION['tipo_de_conta'] = $tipoDeConta;
        $_SESSION['idUser'] = $idUser;
        $_SESSION['telefone'] = $telefone ?? '';
        $_SESSION['tokenjwt'] = $token ?? '';
        $_SESSION['is_membro_id_membro'] = $is_membro_id_membro ?? '';
        $_SESSION['is_active'] = $is_active ?? 0;
        $_SESSION['is_send_code']=$is_send_code?? 0;

    }

    public function is_authetication()
    {

        if (!empty($_SESSION['idUser'])) {
            header('Location:/dashboard');
        }
    }

    public function is_autheticationNot()
    {
        if (empty($_SESSION['idUser'])) {
            header('Location:/login');
        }
        if (!$_SESSION['is_active']) {
            header('Location:/active_account');
        }
    }
}
