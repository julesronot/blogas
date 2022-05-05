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
}
