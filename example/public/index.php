<?php

require '../../vendor/autoload.php';

// use App\Entity\Film;
use App\Repository\FilmRepository;

// $film = new Film();
// $film->setTitle('New film');
// $film->save();

$films = FilmRepository::getRepository();

// $myFilm = $films->getById('12');
// echo $myFilm->getTitle();
// $myFilm->setTitle("Jean jean");
// $myFilm->save();

$mySecondFilm = $films->getById('8');
$mySecondFilm->delete();