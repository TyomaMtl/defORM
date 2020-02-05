<?php

namespace DefORM;

use \PDO;
use DefORM\Database;

class Repository extends Database 
{
    public function getAll()
    {
        $req = $this->db()->query("SELECT * FROM " . $this->tableName() . " ORDER BY id DESC");
        $req->setFetchMode(PDO::FETCH_CLASS, 'App\\Entity\\' . $this->entityName());
        $result = $req->fetchAll();

        return $result;
    }

    public function getById(int $id)
    {
        $req = $this->db()->prepare("SELECT * FROM " . $this->tableName() . " WHERE id = ?");
        $req->execute([$id]);
        $req->setFetchMode(PDO::FETCH_CLASS, 'App\\Entity\\' . $this->entityName());
        $result = $req->fetch();
     
        return $result;
    }

    private function entityName()
    {
        $entityName = substr(strrchr(get_class($this), "\\"), 1);
        $entityName = substr_replace($entityName, "", -10);

        return $entityName;
    }

    private function tableName()
    {
        return strtolower($this->entityName() . 's');
    }
}