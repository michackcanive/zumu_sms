<?php

namespace App\Model;

use App\Controller\Services\GetRegisterSendSms;
use Exception;

class SmsSendRepository extends GetRegisterSendSms
{


    public function findOperationSendSms($token, $page, $pesquisar)
    {
        return $this->getSmsSend($token, $page, $pesquisar);
    }

    public function SendsmsSms($token, $dataCliente)
    {
     return $this->sendOperationSms($token, $dataCliente);
    }
}
