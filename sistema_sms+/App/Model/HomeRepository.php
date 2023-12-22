<?php

namespace App\Model;

use App\Controller\Services\GetInfoUser;
use Exception;

class HomeRepository extends GetInfoUser
{


    public function getInfoSmsUser($token, $Month)
    {
        return $this->getInfoUsers($token, $Month);
    }
}
