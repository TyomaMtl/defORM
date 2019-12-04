<?php

namespace DefORM;

use \PDO;
use PDOException;

class Database 
{    
    protected function db()
    {
        $config = file_get_contents(dirname(__DIR__) . '/example/config/config.json');
        $host = json_decode($config);

        try 
        {
            $db = new PDO('mysql:host=' . $host->host . ';dbname=' . $host->name . ';charset=utf8;', $host->user, $host->pass);
            return $db;
        }
        catch(PDOException $e)
        {
            die('Bingo, database out of the game !');
            exit($e);
        }
    }
}