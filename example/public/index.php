<?php

require '../../vendor/autoload.php';

use App\Entity\Film;

$film = new Film();
$film->setTitle('Star Wars');
$film->save();