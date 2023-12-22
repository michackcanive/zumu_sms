<?php

namespace App\Model;

use App\Controller\Services\GetConfiguracaSistema;
use Nextc\Model\Conteiner;

class Site extends GetConfiguracaSistema
{

    public function findConfigSite($emailEmpresa)
    {
        return $this->getconfiguracaoSistema($emailEmpresa);
    }
}
