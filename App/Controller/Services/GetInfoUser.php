<?php

namespace App\Controller\Services;

use Exception;


abstract class GetInfoUser
{
    private $URL = API_URL;


    public function getInfoUsers($token, $Month)
    {
        try {
            $infor = json_decode($this->estruturaJsonGet($this->URL . "getInfoSmsUser?Month=".$Month."&token=".$token));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }
    public function getsmsdataChart($token,$Year)
    {
        try {
            $infor = json_decode($this->estruturaJsonGet($this->URL . "getInfoSmsYear?year_select=".$Year."&token=".$token));
            return $infor;
        } catch (Exception $e) {
            return array(
                'error' => true,
                'mensager' => $e
            );
        }
    }

    public function estruturaJsonGet($url): string
    {
        // $fields = urlencode($estruturaJson);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
//getSmsSendOperation
