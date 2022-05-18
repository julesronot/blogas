<?php

namespace blogapp\vue ;

use blogapp\authentification\Authentification ;

class IndexVue extends Vue {

  const INDEX_VUE = 1 ;

  public function render() {
      switch($this->selecteur) {
      case self::INDEX_VUE:
          $content = $this->display();
          break;
      }
      return $this->userPage($content);
  }

  public function display() {
    $res = "";

    if ($this->source != null){
        $res = <<<YOP
        <h1>Affichage de la liste des billets</h1>
        <ul>
        YOP;

        foreach ($this->source as $billet) {
            $url = $this->cont->router->pathFor('billet_aff', ['id' => $billet->id]);
            $res .= <<<YOP
            <li><a href="$url">{$billet->titre}</a></li>
            YOP;
        }
        $url_newutil = $this->cont->router->pathFor('util_nouveau');
        $url_connexion = $this->cont->router->pathFor('util_connexion');
        $url_newbillet = $this->cont->router->pathFor('billet_nouveau');
        $url_newcateg = $this->cont->router->pathFor('categ_nouveau');
        $url_membresListe = $this->cont->router->pathFor('membres_liste');

        $res .= "</ul>";
        $res .= <<<YOP
        <a href = "$url_newutil">
          <input type='button' value="Créer un compte"/>
        </a>
        <a href = "$url_connexion">
          <input type="button" value="Connexion">
        </a>
        YOP;

        if (Authentification::authlevel() >= 1){
          $res .= <<<YOP
          <a href = "$url_newbillet">
            <input type="button" value="Ajouter un nouveau billet">
          </a>
          YOP;
        }

        if (Authentification::authlevel() == 2){
          $res .=<<<YOP
          <a href = "$url_newcateg">
            <input type="button" value="Ajouter une catégorie">
          </a>
          <a href = "$url_membresListe">
            <input type="button" value="Liste des membres">
          </a>
          YOP;
        }
      }
      else
        $res = "<h1>Erreur : la liste de billets n'existe pas !</h1>";
        return $res;
      }

}

?>
