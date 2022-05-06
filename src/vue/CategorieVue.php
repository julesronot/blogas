<?php

namespace blogapp\vue;
use blogapp\vue\Vue;

class CategorieVue extends Vue {
    const CATEG_NOUVEAU = 1 ;

    public function render() {
        switch($this->selecteur) {
        case self::CATEG_NOUVEAU:
            $content = $this->nouveau();
            break;
        }
        return $this->userPage($content);
    }

    public function nouveau() {
      $res = "" ;
      $res .= <<<YOP
      <form method="post" action="{$this->cont['router']->pathFor('categ_cree')}">
        <div>
          <label for="titre">Titre de la catégorie :</label>
          <input type="text" id="titre" name="titre">
        </div>
        <div>
          <label for="msg">Description :</label>
          <textarea id="msg" name="description"></textarea>
        </div>
        <input type="submit" value="Soumettre">
      </form>
      YOP;
      return $res ;
    }
}
