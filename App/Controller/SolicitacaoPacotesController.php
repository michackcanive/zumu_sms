<?php

namespace App\Controller;

use App\Controller\Support\Help;
use App\Controller\Support\Session;
use App\Model\PacotesSmsRepository;
use App\Model\SolicitacaodePacotesRepository;
use Exception;
use Nextc\Controller\Action;

session_start();
class SolicitacaoPacotesController extends Action
{
    public $authCsrf;
    private $newcreateCsrf;
    public $clienteData;
    private $instaciamembrosRepositorio;
    public $saldo_account;


    public function __construct()
    {
        $this->newcreateCsrf = new Session();
        $this->newcreateCsrf->is_autheticationNot();
        $this->instaciamembrosRepositorio = new SolicitacaodePacotesRepository();
        
    }

    public function my_solicitacao()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $_SESSION['pesquisar'] = '';
        $this->render("my_solicitacao", "layoutSolicitacao");
    }

  /*  public function my_comprar_sms()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $_SESSION['page'] = trim(strip_tags($_POST['page'] ?? ''));
        $data = $this->instaciamembrosRepositorio->findPacotesms($_SESSION['tokenjwt'], $_SESSION['page']);
        $this->clienteData = $data ?? [];
        //pacoteSistema
        $this->render("componentPacotesCompra", "layoutPacotes");
    }*/

    public function getsolicitacao_carregamentos()
    {
        $this->authCsrf = $this->newcreateCsrf->createCsrf();
        $_SESSION['page'] = $_POST['page'] ?? '';
        $_SESSION['pesquisar'] = trim(strip_tags($_POST['pesquisar'] ?? ''));
        $data = $this->instaciamembrosRepositorio->getsolicitacaouser($_SESSION['tokenjwt'], $_SESSION['page'], $_SESSION['pesquisar']);
        $this->clienteData = $data ?? [];
        
        if (empty($this->clienteData)) {
            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] =  true;
            $json = json_encode($response);
            echo $json;
            return;
        }

        $this->render("componentSolicitacaoCarregamento", "layoutSolicitacao");
    }

    public function createsolictacao()
    {
        $dataCliente = array(
            "comprovativo" => $_FILES['comprovativo'],
            "aumount_cart" => trim(strip_tags($_POST['amount_kz'])),
            "nota" => trim(strip_tags($_POST['nota'] ?? '')),
        );

        $is_date_obr = $this->instaciamembrosRepositorio->cretePacotesSms($_SESSION['tokenjwt'], $dataCliente);
        if (!empty($is_date_obr)) {
            if (!empty($is_date_obr->errorInfo)) {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] = $is_date_obr->status;
                $response["comprovativo"] = $is_date_obr->errorInfo->comprovativo ?? '';
                $response["aumount_cart"] = $is_date_obr->errorInfo->aumount_cart ?? '';
                $response["nota"] = $is_date_obr->errorInfo->nota ?? '';
                $json = json_encode($response);
                echo $json;
                return;
            }
            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] = $is_date_obr->error;
            $response["mensagem"] =  $is_date_obr->status;
            $json = json_encode($response);
            echo $json;
            return;
        }
    }

    public function cretepacotes()
    {
        $dataCliente = array(
            "nomepacote" => trim(strip_tags($_POST['nomepacote'])),
            "qtduser" => trim(strip_tags($_POST['qtduser'])),
            "id_pacote" => trim(strip_tags($_POST['id_pacote'] ?? '')),
        );

        $is_date_obr = $this->instaciamembrosRepositorio->cretePacotesSms($_SESSION['tokenjwt'], $dataCliente);

        if (!empty($is_date_obr)) {
            if (!empty($is_date_obr->errorInfo)) {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] = $is_date_obr->status;
                $response["nomepacote"] = $is_date_obr->errorInfo->nomepacote ?? '';
                $response["qtduser"] = $is_date_obr->errorInfo->qtduser ?? '';
                $json = json_encode($response);
                echo $json;
                return;
            }
            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] = $is_date_obr->error;
            $response["mensagem"] =  $is_date_obr->status;
            $json = json_encode($response);
            echo $json;
            return;
        }
    }

    public function deletaPacotes()
    {
        $token = $_POST['token'];
        $id_pacote = trim(strip_tags($_POST['id_pacote']));
        if ($this->newcreateCsrf->csrf_verifica($token)) {
            $data = $this->instaciamembrosRepositorio->deletePacotesSmsCliente($_SESSION['tokenjwt'], $id_pacote);
            if (!empty($data->error == false)) {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = $data->error;
                $response["mensagem"] =   'Eliminado';
                $json = json_encode($response);
                echo $json;
                return;
            } else {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] =   $data->status;
                $json = json_encode($response);
                echo $json;
                return;
            }
        } else {
            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] = true;
            $response["mensagem"] =   'token expirado';
            $json = json_encode($response);
            echo $json;
            return;
        }
    }
    public function activarcarregamento()
    {
        $token = $_POST['token'];


        if ($this->newcreateCsrf->csrf_verifica($token)) {

            $dataCliente = array(
                "id_request" => trim(strip_tags($_POST['id_request'])),
                "password" => trim(strip_tags($_POST['password']))
            );
            $data = $this->instaciamembrosRepositorio->Activarcarregamento($_SESSION['tokenjwt'], $dataCliente);

            if (!empty($data)) {
                if ($data->error) {
                    header('Content-Type: application/json; charset=utf-8');
                    $response["erro"] = true;
                    $response["mensagem"] =   $data->status;
                    $json = json_encode($response);
                    echo $json;
                    return;
                } else {
                    header('Content-Type: application/json; charset=utf-8');
                    $response["erro"] = $data->error;
                    $response["mensagem"] = $data->status;
                    $json = json_encode($response);
                    echo $json;
                    return;
                }
            }
        } else {
            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] = true;
            $response["mensagem"] =   'token expirado';
            $json = json_encode($response);
            echo $json;
            return;
        }
    }

    public function comprarsms()
    {
        $token = $_POST['token'];
        try {
            if ($this->newcreateCsrf->csrf_verifica($token)) {

                $dataCliente = array(
                    "id_pacote" => trim(strip_tags($_POST['id_pacote']))
                );
                $data = $this->instaciamembrosRepositorio->comprarsmsuser($_SESSION['tokenjwt'], $dataCliente);

                if (!empty($data)) {
                    if ($data->error) {
                        header('Content-Type: application/json; charset=utf-8');
                        $response["erro"] = true;
                        $response["mensagem"] =   $data->status;
                        $json = json_encode($response);
                        echo $json;
                        return;
                    } else {
                        header('Content-Type: application/json; charset=utf-8');
                        $response["erro"] = $data->error;
                        $response["mensagem"] = $data->status;
                        $json = json_encode($response);
                        echo $json;
                        return;
                    }
                }
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] =   'Ups erro de conexão';
                $json = json_encode($response);
                echo $json;
                return;
            } else {
                header('Content-Type: application/json; charset=utf-8');
                $response["erro"] = true;
                $response["mensagem"] =   'token expirado';
                $json = json_encode($response);
                echo $json;
                return;
            }
        } catch (Exception $e) {
            header('Content-Type: application/json; charset=utf-8');
            $response["erro"] = true;
            $response["mensagem"] =   'error interval';
            $json = json_encode($response);
            echo $json;
            return;
        }
    }
    //
}
