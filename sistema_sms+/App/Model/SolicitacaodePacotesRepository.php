<?php

namespace App\Model;

use App\Controller\Services\PacotesSmsCliente;
use App\Controller\Services\SolicitacaodePacotes;
use Exception;

class SolicitacaodePacotesRepository extends SolicitacaodePacotes
{


    public function getsolicitacaouser($token, $page, $pesquisar)
    {
        return $this->getsolicitacaoCliente($token, $page, $pesquisar);
    }

    public function cretePacotesSms($token, $dataCliente)
    {
        return $this->createsolictacao($token, $dataCliente);
    }

    public function deleteSender($token, $id_sender)
    {
        return $this->deletePacotesSmsCliente($token, $id_sender);
    }
}
