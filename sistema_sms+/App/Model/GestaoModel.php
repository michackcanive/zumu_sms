<?php

namespace App\Model;

use Nextc\Model\Conteiner;
use Exception;
use DateTime;
use PDOException;

class GestaoModel extends Conteiner
{

    public function __get($atributos)
    {
        return $this->$atributos;
    }
    public function __set($atributos, $value)
    {
        $this->$atributos = $value;
    }
}
