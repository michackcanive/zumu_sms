<?php

namespace App\Model;

use App\Controller\Services\Contacto;
use Exception;

class ContactoRepository extends Contacto
{

    public function get_Contacto($token, $page, $pesquisar)
    {
        return $this->getContacto($token, $page, $pesquisar);
    }

    public function create_contacto($token, $dataCliente)
    {
        if (!empty($dataCliente['id_contacto']))
            return $this->updateContacto($token, $dataCliente);
        else
            return $this->createcontacto($token, $dataCliente);
    }
    public function importarContactos($token, $dataCliente)
    {
            return $this->importar_contactos($token, $dataCliente);
    }

    public function delete_Contacto($token, $id_sender)
    {
        return $this->deleteContacto($token, $id_sender);
    }
}
