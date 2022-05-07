<?php

namespace blogapp\controleur;

use blogapp\modele\Billet;
use blogapp\modele\Categorie;
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
      $nomcateg = filter_var($rq->getParsedBodyParam('categorie'), FILTER_SANITIZE_STRING);
      $categ = Categorie::select('id')->where('titre', '=', $nomcateg)->first();
      $idcateg = $categ->id;

      if ($titre == NULL){
        $this->cont->flash->addMessage('error', "Donnez un titre à votre billet.");
        return $rs->withRedirect($this->cont->router->pathFor('billet_nouveau'));
      }

      if ($body == NULL){
        $this->cont->flash->addMessage('error', "Vous n'avez rien à dire ?");
        return $rs->withRedirect($this->cont->router->pathFor('billet_nouveau'));
      }

      $billet = new Billet() ;
      $billet->titre = $titre ;
      $billet->body = $body ;
      $billet->cat_id = $idcateg ;
      $billet->date = date("d-m-y");
      $billet->save();

      $this->cont->flash->addMessage('info', "Billet $titre ajouté !");
      return $rs->withRedirect($this->cont->router->pathFor('billet_liste'));
    }
}
