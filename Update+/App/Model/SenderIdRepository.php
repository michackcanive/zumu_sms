<?php

namespace App\Model;

use App\Controller\Services\SenderID;
use Exception;
use Nextc\Model\Conteiner;

class SenderIdRepository extends SenderID
{

    public function findObreirosByUserAll($token,$page)
    {
        return $this->getSenderID($token,$page);
    }
    public function findSender($token,$page,$pesquisar)
    {
        return $this->getBuscarSenderID($token,$page,$pesquisar);
    }
    public function findSenderActive($token,$page,$pesquisar)
    {
        return $this->getBuscarSenderIDActive($token,$page,$pesquisar);
    }

    public function creteObreiros($token, $nome_sender)
    {
        return $this->createSenderID($token,$nome_sender);
    }

    public function deleteSender($token, $id_sender)
    {
        return $this->deleteSenderID($token,$id_sender);
    }
    public function pocessarSenderid($token, $id_sender)
    {
        return $this->pocessarSenderApi($token,$id_sender);
    }
}
