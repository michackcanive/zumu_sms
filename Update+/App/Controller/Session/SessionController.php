<?php

namespace App\Controller\Session;

use Nextc\Controller\Action;

session_start();
class SessionController extends Action
{
    public function session_is(){

        if($this->is_post()){
            session_destroy();
            header('Location:/');
        }

        $tempo=time();
        if($tempo>$_SESSION['exipere']??''){
            session_destroy();
            header('Content-Type: application/json; charset=utf-8');
            $gerador["erro"] = true;
            $gerador["mensagem"] = "NO";
            $json = json_encode($gerador);
            echo $json;
            return;
        }else{
            header('Content-Type: application/json; charset=utf-8');
            $gerador["erro"] = false;
            $gerador["mensagem"] = "OK";
            $json = json_encode($gerador);
            echo $json;
            return;
        }
    }
}
