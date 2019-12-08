<?php

namespace App\Repository;

use \PDO;
use DefORM\Repository;

class FilmRepository extends Repository {

    private static $instance = null;

    private function __construct() { }

    public static function getRepository()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new FilmRepository;
            return self::$instance;
        }

        return self::$instance;
    }

    public function getAll()
    {
        $req = $this->db()->query("SELECT * FROM films ORDER BY id DESC");
        $req->setFetchMode(PDO::FETCH_CLASS, 'App\\Entity\\Film');
        $result = $req->fetchAll();

        return $result;
    }

    public function getById(int $id)
    {
        $req = $this->db()->prepare("SELECT * FROM films WHERE id = ?");
        $req->execute([$id]);
        $req->setFetchMode(PDO::FETCH_CLASS, 'App\\Entity\\Film');
        $result = $req->fetch();
     
        return $result;
    }
}