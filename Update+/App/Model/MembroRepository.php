<?php

namespace App\Model;

use App\Controller\Services\MemberCliente;
use Exception;

class MembroRepository extends MemberCliente
{


    public function findmember($token, $page,$pesquisar)
    {
        return $this->getMemberCliente($token, $page,$pesquisar);
    }


    public function cretemember($token, $dataCliente)
    {
        if (!empty($dataCliente['user_id']))
            return $this->updateMemberCliente($token, $dataCliente);
        else
            return $this->createMemberCliente($token, $dataCliente);
    }

    public function deleteSender($token, $id_sender)
    {
        return $this->deleteMemberCliente($token, $id_sender);
    }
}
