<?php

namespace blogapp\vue;
use blogapp\vue\Vue;
use blogapp\modele\Categorie;
use blogapp\modele\Commentaire;

class BilletVue extends Vue {
    const BILLET_VUE = 1;
    const BILLET_NOUVEAU = 2 ;

    public function render() {
        switch($this->selecteur) {
        case self::BILLET_VUE:
            $content = $this->billet();
            break;
        case self::BILLET_NOUVEAU:
            $content = $this->nouveau();
            break;
        }
        return $this->userPage($content);
    }

    public function billet() {
        $res = "";
        $billet = $this->source ;
        $commentaires = Commentaire::where('id_billet', '=', $billet->id)->get() ;

        if ($this->source != null) {
            $res .= <<<YOP
            <h1>Affichage du billet : {$billet->id}</h1>
            <h2>Nom : {$billet->titre}</h2>
            <ul>
              <li>Catégorie : {$billet->categorie->titre}</li>
              <li>Contenu : {$billet->body}</li>
            </ul>

            <h3>Commentaires : </h3>
            YOP;

            foreach ($commentaires as $commentaire) {
              $res.=<<<YOP
                    <ul>
                      <li>Le <strong>$commentaire->date : </strong> $commentaire->commentaire</li>
                    </ul>
              YOP;
            }

            $res .= <<<YOP
            <form method="post" action="{$this->cont['router']->pathFor('commenter', ['id' => $billet->id])}">
              <div>
                <label for="comm">Votre commentaire :</label>
                <textarea id="comm" name="commentaire"></textarea>
              </div>
              <input type="submit" value="Commenter">
            </form>

            <form method="get" action="{$this->cont['router']->pathFor('billet_liste')}">
              <input type="submit" value="Retour à la liste des billets">
            </form>
            YOP;
        }
        else
            $res = "<h1>Erreur : le billet n'existe pas !</h1>";

        return $res;
    }

    public function nouveau() {
      $res = "" ;
      $categories = Categorie::select('titre')->get();
      $res .= <<<YOP
      <form method="post" action="{$this->cont['router']->pathFor('billet_cree')}">
        <div>
          <label for="titre">Titre du billet :</label>
          <input type="text" id="titre" name="titre">
        </div>
        <div>
          <label for='categ_select'>Choisissez une catégorie : </label>
          <select id='categ' name='categorie'>
      YOP;

              foreach($categories as $categ) {
                $res.=<<<YOP
                      <option>$categ->titre</option>
      YOP;
              }

      $res.= <<<YOP

          </select>
        </div>
        <div>
          <label for="msg">Message du billet :</label>
          <textarea id="msg" name="message"></textarea>
        </div>
        <input type="submit" value="Soumettre le billet">
      </form>
YOP;
      return $res ;
    }
/*
    public function liste() {
        $res = "";

        if ($this->source != null) {
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
        }
        else
            $res = "<h1>Erreur : la liste de billets n'existe pas !</h1>";

        return $res;
    }
*/
}
