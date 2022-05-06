<?php

namespace blogapp\controleur;

use blogapp\modele\Billet;
use blogapp\vue\BilletVue;
use blogapp\vue\IndexVue;

class BilletControleur {
    private $cont;

    public function __construct($conteneur) {
        $this->cont = $conteneur;
    }

    public function affiche($rq, $rs, $args) {
        $id = $args['id'];
        $billet = Billet::where('id', '=', $id)->first();

        $bl = new BilletVue($this->cont, $billet, BilletVue::BILLET_VUE);
        $rs->getBody()->write($bl->render());
        return $rs;
    }

    public function liste($rq, $rs, $args) {
        $billets = Billet::get();
        $bl = new IndexVue($this->cont, $billets, IndexVue::INDEX_VUE);
        $rs->getBody()->write($bl->render());
        return $rs;
    }

    public function nouveau($rq, $rs, $args) {
      $bl = new BilletVue($this->cont, null, BilletVue::BILLET_NOUVEAU);
      $rs->getBody()->write($bl->render());
      return $rs;
    }

    public function ajoute($rq, $rs, $args) {
      $titre = filter_var($rq->getParsedBodyParam('titre'), FILTER_SANITIZE_STRING);
      $body = filter_var($rq->getParsedBodyParam('message'), FILTER_SANITIZE_STRING);
      $this->cont->flash->addMessage('info', "Billet $titre ajouté !");
      return $rs->withRedirect($this->cont->router->pathFor('billet_liste'));
    }
}
