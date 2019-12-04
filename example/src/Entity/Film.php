<?php

namespace App\Entity;

use DefORM\Model;

class Film extends Model
{
    protected $fieldsTypes;

    public function __construct()
    {
        $this->fieldsTypes = [
            'id' => 'int',
            'title' => 'string',
        ];
    }

    protected $id;

    protected $title;

    public function getId() : int 
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }
}