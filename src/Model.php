<?php

namespace DefORM;

class Model 
{
    private $class;

    private function __construct()
    {
        $this->class = __CLASS__;
    }

    protected static function getAll()
    {

    }

    protected static function get(int $id)
    {

    }

    protected static function get_class()
    {
        return $this->class;
    }
}