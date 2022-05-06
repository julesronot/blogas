<?php

namespace blogapp\controleur;

use blogapp\vue\UtilisateurVue;

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
        // Récupération variable POST + nettoyage
        $nom = filter_var($rq->getParsedBodyParam('nom'), FILTER_SANITIZE_STRING);
        // Insertion dans la base...
        // ...
        // Ajout d'un flash
        $this->cont->flash->addMessage('info', "Utilisateur $nom ajouté !");
        // Retour de la réponse avec redirection
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
