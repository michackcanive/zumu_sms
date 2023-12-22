<?php

namespace App\Model;

use App\Controller\Services\PacotesSmsCliente;
use Exception;

class PacotesSmsRepository extends PacotesSmsCliente
{


    public function findPacotesmssite($email_empresa)
    {
        return $this->getPacotesSmsClientesite($email_empresa);
    }
    public function findPacotesms($token, $page)
    {
        return $this->getPacotesSmsCliente($token, $page);
    }

    public function cretePacotesSms($token, $dataCliente)
    {
        if (!empty($dataCliente['id_pacote']))
            return $this->updatePacoteSmsCliente($token, $dataCliente);
        else
            return $this->createPacotesSmsCliente($token, $dataCliente);
    }

    public function deleteSender($token, $id_sender)
    {
        return $this->deletePacotesSmsCliente($token, $id_sender);
    }
}
