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

        $nom = filter_var($rq->getParsedBodyParam('nom'), FILTER_SANITIZE_STRING);
        $prenom = filter_var($rq->getParsedBodyParam('prenom'), FILTER_SANITIZE_STRING);
        $username = filter_var($rq->getParsedBodyParam('username'), FILTER_SANITIZE_STRING);
        $mail = filter_var($rq->getParsedBodyParam('mail'), FILTER_SANITIZE_STRING);
        $mdp = password_hash(filter_var($rq->getParsedBodyParam('mdp'), FILTER_SANITIZE_STRING), PASSWORD_DEFAULT);

        $test_username = Utilisateur::where('username', '=', $username) ->first() ;
        $test_mail = Utilisateur::where('email', '=', $mail) ->first() ;

        if ($nom == NULL){
          $this->cont->flash->addMessage('error', "Veuillez préciser votre nom.");
          return $rs->withRedirect($this->cont->router->pathFor('util_nouveau'));
        }

        if ($prenom == NULL){
          $this->cont->flash->addMessage('error', "Veuillez préciser votre prénom.");
          return $rs->withRedirect($this->cont->router->pathFor('util_nouveau'));
        }

        if ($username == NULL){
          $this->cont->flash->addMessage('error', "Veuillez entrer un nom d'utilisateur.");
          return $rs->withRedirect($this->cont->router->pathFor('util_nouveau'));
        }

        if ($mdp == NULL){
          $this->cont->flash->addMessage('error', "Veuillez entrer un mot de passe.");
          return $rs->withRedirect($this->cont->router->pathFor('util_nouveau'));
        }

        if ($mail == NULL){
          $this->cont->flash->addMessage('error', "Veuillez entrer un email.");
          return $rs->withRedirect($this->cont->router->pathFor('util_nouveau'));
        }

        if ($test_username != NULL){
            $this->cont->flash->addMessage('error',
                                    "Ce nom d'utilisateur existe déjà.
                                    Choisissez-en un autre ou connectez-vous.");
            return $rs->withRedirect($this->cont->router->pathFor('util_nouveau'));
        }

        if ($test_mail != NULL){
          $this->cont->flash->addMessage('error',
                                  "Cet email existe déjà.
                                  Connectez-vous !");
          return $rs->withRedirect($this->cont->router->pathFor('util_nouveau'));
        }

        //insertion dans la base
        $newutil = new Utilisateur() ;
        $newutil->nom = $nom ;
        $newutil->prenom = $prenom ;
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
        $mdp = filter_var($rq->getParsedBodyParam('mdp'), FILTER_SANITIZE_STRING);

        $user = Utilisateur::where('email', '=', $mail)->first() ;
        if ($user == NULL){
          $this->cont->flash->addMessage('error', "Utilisateur inexistant.");
          return $rs->withRedirect($this->cont->router->pathFor('util_connexion'));
        }
        else{
          $user_mdp = $user->mdp ;
          if (!password_verify($mdp, $user_mdp)){
            $this->cont->flash->addMessage('error', "Le mot de passe n'est pas correct.");
            return $rs->withRedirect($this->cont->router->pathFor('util_connexion'));
          }
          else{
            $this->cont->flash->addMessage('info', "Utilisateur $mail connecté !");
            return $rs->withRedirect($this->cont->router->pathFor('billet_liste'));
          }
        }
    }
}
