<?php

session_start();

require 'vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \blogapp\authentification\Authentification ;
use \blogapp\modele\Utilisateur ;
use \blogapp\conf\ConnectionFactory;

// Création de la connexion à la base
ConnectionFactory::makeConnection('src/conf/conf.ini');

// Configuration de Slim

$configuration = [
    'settings' => [
        'displayErrorDetails' => true
    ],
    'flash' => function() {
        return new \Slim\Flash\Messages();
    }
];

// Création du dispatcher

$app = new \Slim\App($configuration);

// Création d'un utilisateur public

if (!isset($_SESSION['user'])){

  $public = new Utilisateur() ;
  $public->username = 'anonyme' ;
  $public->statut = 'public' ;

  Authentification::loadProfile($public) ;
}

// Définition des routes

$app->get('/',
          '\blogapp\controleur\BilletControleur:liste')
    ->setName('billet_liste');

$app->get('/billet/{id}',
          '\blogapp\controleur\BilletControleur:affiche')
    ->setName('billet_aff');

$app->get('/newutil',
          '\blogapp\controleur\UtilisateurControleur:nouveau')
    ->setName('util_nouveau');

$app->post('/createutil',
          '\blogapp\controleur\UtilisateurControleur:cree')
    ->setName('util_cree');

$app->get('/connexion',
          '\blogapp\controleur\UtilisateurControleur:connect')
  ->setName('util_connexion');

$app->post('/connecte',
           '\blogapp\controleur\UtilisateurControleur:connected')
    ->setName('util_connecte');

$app->get('/membres',
          '\blogapp\controleur\UtilisateurControleur:liste')
    ->setName('membres_liste');

$app->post('/radier/{id}',
           '\blogapp\controleur\UtilisateurControleur:radier')
    ->setName('radier');

$app->get('/newbillet',
          '\blogapp\controleur\BilletControleur:nouveau')
    ->setName('billet_nouveau');

$app->post('/createbillet',
           '\blogapp\controleur\BilletControleur:ajoute')
    ->setName('billet_cree');

$app->get('/newcateg',
          '\blogapp\controleur\CategorieControleur:nouveau')
    ->setName('categ_nouveau');

$app->post('/createcateg',
           '\blogapp\controleur\CategorieControleur:ajoute')
    ->setName('categ_cree');

$app->post('/commenter/{id}',
           '\blogapp\controleur\CommentaireControleur:nouveau')
    ->setName('commenter');

$app->run();
