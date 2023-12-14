<?php

namespace App\Model;

use App\Controller\Services\Grupo;
use Exception;

class GrupoRepository extends Grupo
{

    public function get_grupo($token, $page, $pesquisar)
    {
        return $this->getgrupo($token, $page, $pesquisar);
    }

    public function creategrupo($token, $dataCliente)
    {
        if (!empty($dataCliente['id_grupo']))
            return $this->updategrupo($token, $dataCliente);
        else
            return $this->create_grupo($token, $dataCliente);
    }

    public function delete_grup($token, $id_grupo)
    {
        return $this->deletegrupo($token, $id_grupo);
    }
}
