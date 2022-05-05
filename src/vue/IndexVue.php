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
      $res .= "</ul>";
      $res .= <<<YOP
      <input type="button" value="Créer un compte">
      YOP;
    }
    else
        $res = "<h1>Erreur : la liste de billets n'existe pas !</h1>";
        return $res;
  }

}

?>
