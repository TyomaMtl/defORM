<?php

namespace DefORM;

use \PDO;

class Database 
{
    private $host;
    private $name;
    private $user;
    private $pass;

    protected function __construct()
    {
        $config = file_get_contents('../example/config/config.json');
        $host = json_decode($config);

        $this->host = $host->host;
        $this->name = $host->name;
        $this->user = $host->user;
        $this->pass = $host->pass;

        try 
        {
            $db = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->name . ';charset=utf8;', $this->user, $this->pass);
            return $db;
        }
        catch(PDOExeption $e)
        {
            die('Bingo, database out of the game !');
            exit();
        }
    }
}