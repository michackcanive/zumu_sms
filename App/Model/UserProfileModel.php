<?php

namespace App\Model;

use Nextc\Model\Conteiner;
use Exception;
use DateTime;
use PDOException;

class UserProfileModel extends Conteiner
{

    public function __get($atributos)
    {
        return $this->$atributos;
    }
    public function __set($atributos, $value)
    {
        $this->$atributos = $value;
    }

    public function finduser($id_usuario)
    {
        try {
            $query = "SELECT * FROM tb_user WHERE id=:id_usuario";
            $stm = $this->db->prepare($query);
            $stm->bindValue(':id_usuario', $id_usuario);
            $stm->execute();
            return $stm->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function updateUser($name, $id)
    {
        try {
            $query = "UPDATE tb_user SET name=:name WHERE  id=:id";
            $stm = $this->db->prepare($query);
            $stm->bindValue(':name', $name);
            $stm->bindValue(':id', $id);
            return $stm->execute();
        } catch (PDOException $e) {
            return [];
        }
    }

    public function updateUserSenha($password, $id)
    {
        try {
            $query = "UPDATE tb_user SET password=:password WHERE  id=:id";
            $stm = $this->db->prepare($query);
            $stm->bindValue(':password', $password);
            $stm->bindValue(':id', $id);
            return $stm->execute();
        } catch (PDOException $e) {
            return [];
        }
    }

    public function deleteuser($id)
    {
        $query = "DELETE from tb_user where id=:id";
        $stm = $this->db->prepare($query);
        $stm->bindValue(':id', $id);
        return $stm->execute();
    }
}
