<?php

$autoloader = require '../../vendor/autoload.php';
$result = $autoloader->findFile('\App\Entity\Film');

var_dump($autoloader);

use DefORM\Model;

$model = new Model;


// use App\Entity\Film;

// $film = new Film();
// var_dump($film->get_class());