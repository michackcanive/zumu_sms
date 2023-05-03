<?php

namespace App\Model;

use App\Controller\Services\GetConfiguracaSistema;
use Exception;
use Nextc\Model\Conteiner;

class ConfigsistemaRepository  extends GetConfiguracaSistema
{


    public function findconfig()
    {
        //
    }

    public function creteConfigsistema($token, $data)
    {
        return $this->updateEmpresa($token, $data);
    }
}
