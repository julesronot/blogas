<?php

namespace blogapp\controleur;

use blogapp\vue\UtilisateurVue;
use blogapp\modele\Utilisateur;

class UtilisateurControleur {
    private $cont;

    public function __construct($conteneur) {
        $this->cont = $conteneur;
    }

    public function nouveau($rq, $rs, $args) {
        $bl = new UtilisateurVue($this->cont, null, UtilisateurVue::NOUVEAU_VUE);
        $rs->getBody()->write($bl->render());
        return $rs;
    }

    public function cree($rq, $rs, $args) {

        global $nextId ;

        $username = filter_var($rq->getParsedBodyParam('username'), FILTER_SANITIZE_STRING);
        $mail = filter_var($rq->getParsedBodyParam('mail'), FILTER_SANITIZE_STRING);
        $mdp = filter_var($rq->getParsedBodyParam('mdp'), FILTER_SANITIZE_STRING);

        $test_username = Utilisateur::where('username', '=', $username) ->first() ;
        $test_mail = Utilisateur::where('email', '=', $mail) ->first() ;

        if ($username == NULL){
          $this->cont->flash->addMessage('info', "Veuillez entrer un nom d'utilisateur.");
          return $rs->withRedirect($this->cont->router->pathFor('util_nouveau'));
        }

        if ($mdp == NULL){
          $this->cont->flash->addMessage('info', "Veuillez entrer un mot de passe.");
          return $rs->withRedirect($this->cont->router->pathFor('util_nouveau'));
        }

        if ($mail == NULL){
          $this->cont->flash->addMessage('info', "Veuillez entrer un email.");
          return $rs->withRedirect($this->cont->router->pathFor('util_nouveau'));
        }

        if ($test_username != NULL){
            $this->cont->flash->addMessage('info',
                                    "Ce nom d'utilisateur existe déjà.
                                    Choisissez-en un autre ou connectez-vous.");
            return $rs->withRedirect($this->cont->router->pathFor('util_nouveau'));
        }

        if ($test_mail != NULL){
          $this->cont->flash->addMessage('info',
                                  "Cet email existe déjà.
                                  Connectez-vous !");
          return $rs->withRedirect($this->cont->router->pathFor('util_nouveau'));
        }

        //insertion dans la base
        $newutil = new Utilisateur() ;
        $newutil->email = $mail;
        $newutil->username = $username ;
        $newutil->mdp = $mdp ;
        $newutil->statut = 'membre' ;
        $newutil->save() ;

        $this->cont->flash->addMessage('info', "Utilisateur $username ajouté !");
        return $rs->withRedirect($this->cont->router->pathFor('billet_liste'));
    }

    public function connect($rq, $rs, $args) {
      $bl = new UtilisateurVue($this->cont, null, UtilisateurVue::CONNECT_VUE);
      $rs->getBody()->write($bl->render());
      return $rs;
    }

    public function connected($rq, $rs, $args) {
        $mail = filter_var($rq->getParsedBodyParam('mail'), FILTER_SANITIZE_STRING);
        $this->cont->flash->addMessage('info', "Utilisateur $mail connecté !");
        return $rs->withRedirect($this->cont->router->pathFor('billet_liste'));
    }
}
