<?php

namespace App\Controller\Support;

use Exception;

class Help
{

    public function __get($atributos)
    {
        return $this->$atributos;
    }
    public function __set($atributos, $value)
    {
        $this->$atributos = $value;
    }

    /**
     * password_verifica
     *
     * @param [type] $value
     * @param [type] $hash
     * @return bool
     */
    public function verifyHash($palavra, $passhash): bool
    {
        return $verifica = password_verify($palavra, $passhash);
    }

    /**
     * createHash
     *
     * @param [type] $palavra
     * @return void
     */
    public function createHash($palavra)
    {
        return $passhash = password_hash($palavra, PASSWORD_BCRYPT);
    }

    public  function generateRandomString($size)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuwxyz0123456789";
        $randomString = '';
        for ($i = 0; $i < $size; $i = $i + 1) {
            $randomString .= $chars[mt_rand(0, 60)];
        }
        return $randomString;
    }

    public  function redirect($url)
    {
        header("Location: " . $url);
        exit();
    }

    public function creatCookes($name, $value, $expire, $path = '/', $domain="", $secure = '', $httponly = '')
    {
        return setcookie($name, $value, $expire, $path, $domain);
    }
    public function getCookes($name)
    {
        return $_COOKIE[$name]??'';
    }

    public function is_auth()
    {
        if (!empty($_SESSION['idUser'])) {
            header('Location:/dashboard');
        }
    }




    function gerar4number()
    {
        return rand(1000, 9999);
    }

}
