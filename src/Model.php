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
        else
        {
            die("Table doesn't exist");
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
        // unset($properties['id']);
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
        $values = [];
        for($i = count($this->generateValues()) - 1; $i >= 0; $i--)
        {
            $values[] = $this->generateValues()[$i];
        }

        $fieldsName = explode(',', $this->generateFieldsName());
        
        $fields = null;
        for($i = 1; $i < count($fieldsName); $i++)
        {
            $fields .= $fieldsName[$i] . ' = ?'; 
        }

        if(!is_null($fields))
        {
            $query = "UPDATE " . $this->table() . " SET " . $fields . " WHERE id = ?";

            $update = $this->db()->prepare($query);
            if($update->execute($values) == false)
            {
                die($update->errorInfo()[2]);
            }

            return true;
        }

        return false;
    }

    private function generateFieldsName()
    {
        $fieldsName = null;

        foreach($this->properties() as $k => $p)
        {
            if(array_key_last($this->properties()) == $k)
            {
                $fieldsName .= $k;
            }
            else
            {
                $fieldsName .= $k . ',';
            }
        }

        return $fieldsName;
    }
    
    private function generateValues()
    {
        $values = [];

        foreach($this->properties() as $p)
        { 
            $values[] = $p;
        }

        return $values;
    }

    private function generateQuestionMark()
    {
        $questionMark = null;

        for ($i=0; $i < count($this->properties()); $i++)
        {
            if($i == count($this->properties())-1)
            {
                $questionMark.= '?';
            }
            else
            {
                $questionMark.= '?,';
            }
        }
        
        return $questionMark;
    }

    private function insert()
    {
        $query = "INSERT INTO " .$this->table() . " (" . $this->generateFieldsName() . ") VALUES(" . $this->generateQuestionMark() . ")";

        $insert = $this->db()->prepare($query);

        $values = $this->generateValues();
        unset($values[0]);
        
        if($insert->execute($this->generateValues()) == false)
        {
            die($insert->errorInfo()[2]);
        }
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