<?php

namespace DefORM;

use DefORM\Database;

class Model extends Database
{
    public function save()
    {
        if($this->issetTable())
        {
            if($this->issetEntity()) // entity exist in database : update
            {
                $this->update();
            }
            else // : create
            {
                $this->insert();
            }
        }

        return false;
    }

    private function issetTable()
    {
        $query = "SELECT 1 FROM " . $this->table() . " LIMIT 1";
        $check = $this->db()->query($query);

        if($check == false)
        {
            return false;
        }

        return true;        
    }

    private function issetEntity()
    {
        $req = $this->db()->prepare("SELECT id FROM " . $this->table() . " WHERE id = ?");
        $req->execute([$this->id]);
        $result = $req->rowCount();

        if($result == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function properties()
    {
        $properties = get_object_vars($this);
        unset($properties['fieldsTypes']);

        return $properties;
    }

    private function fieldsTypes()
    {
        $properties = get_object_vars($this);
        
        return $properties['fieldsTypes'];
    }

    private function update()
    {
        
    }

    private function insert()
    {
        $insert = $this->db()->prepare("INSERT INTO " . $this->table() . " VALUES()");
        $insert->execute([]);
    }

    private function issetProperty(string $name)
    {

    }

    private function entity()
    {
        return substr(strrchr(get_class($this), "\\"), 1);
    }

    private function table()
    {
        if(substr($this->entity(), -1) == 's')
        {
            return strtolower($this->entity());
        }
        else
        {
            return strtolower($this->entity()) . 's';
        }

    }
}