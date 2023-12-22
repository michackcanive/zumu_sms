<?php

namespace App\Model;

use App\Controller\Services\GestaoSmsCliente;

use Exception;

class GestaoSmsRepository extends GestaoSmsCliente
{


    public function findOperationSms($token, $page, $pesquisar)
    {
        return $this->getOperationSmsCliente($token, $page, $pesquisar);
    }
    public function findOperationSmsvenda($token, $page, $pesquisar)
    {
        //getCompras_admin
        if ($_SESSION['tipo_de_conta'] == 'membercliente')
            return $this->getOperationSmsClientevenda($token, $page, $pesquisar);
        return $this->getOperationSmsClientevenda_admin($token, $page, $pesquisar);
    }

    public function creteOperationSms($token, $dataCliente)
    {
        return $this->createOperationSmsCliente($token, $dataCliente);
    }
}
