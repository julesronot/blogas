<?php

namespace blogapp\vue ;

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
        $res .= "</ul>";
        $res .= <<<YOP
        <a href = "$url_newutil">
          <input type='button' value="Créer un compte"/>
        </a>
        <a href = "$url_connexion">
          <input type="button" value="Connexion">
        </a>
        <input type="button" value="Ajouter un nouveau billet">
        <input type="button" value="Ajouter une catégorie">
        YOP;
      }
      else
        $res = "<h1>Erreur : la liste de billets n'existe pas !</h1>";
        return $res;
      }

}

?>
