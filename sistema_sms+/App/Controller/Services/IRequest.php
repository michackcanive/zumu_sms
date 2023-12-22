<?php
namespace App\Controller\Services;
interface IRequest
{
    public function estruturaJson($estruturaJson, $url): string;
}
