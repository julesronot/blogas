<?php

namespace blogapp\controleur;

use blogapp\modele\Categorie;
use blogapp\vue\CategorieVue;
use blogapp\vue\IndexVue;

class CategorieControleur {
    private $cont;

    public function __construct($conteneur) {
        $this->cont = $conteneur;
    }

    public function nouveau($rq, $rs, $args) {
      $bl = new CategorieVue($this->cont, null, CategorieVue::CATEG_NOUVEAU);
      $rs->getBody()->write($bl->render());
      return $rs;
    }

    public function ajoute($rq, $rs, $args) {
      $titre = filter_var($rq->getParsedBodyParam('titre'), FILTER_SANITIZE_STRING);
      $descr = filter_var($rq->getParsedBodyParam('description'), FILTER_SANITIZE_STRING);
      $this->cont->flash->addMessage('info', "Catégorie $titre ajoutée !");
      return $rs->withRedirect($this->cont->router->pathFor('billet_liste'));
    }
}
