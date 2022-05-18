<?php

namespace blogapp\vue;

use blogapp\vue\Vue;
use blogapp\modele\Utilisateur;

class UtilisateurVue extends Vue {
    const NOUVEAU_VUE = 1;
    const CONNECT_VUE = 2;
    const LISTE_VUE = 3 ;

    public function render() {
        switch($this->selecteur) {
          case self::NOUVEAU_VUE:
              $content = $this->nouveau();
              break;
          case self::CONNECT_VUE:
              $content = $this->connect();
              break;
          case self::LISTE_VUE:
              $content = $this->liste();
              break;
        }
        return $this->userPage($content);
    }

    public function nouveau() {
        return <<<YOP
        <form method="post" action="{$this->cont['router']->pathFor('util_cree')}">
        <div>
          <label for="name">Nom :</label>
          <input type="text" id="name" name="nom">
        </div>
        <div>
          <label for="name">Prénom :</label>
          <input type="text" id="name" name="prenom">
        </div>
        <div>
          <label for="name">Nom d'utilisateur :</label>
          <input type="text" id="name" name="username">
        </div>
        <div>
          <label for="mail">e-mail&nbsp;:</label>
          <input type="email" id="mail" name="mail">
        </div>
        <div>
          <label for="mdp">Mot de passe : </label>
          <input type="password" id="pass" name="mdp">
        </div>
          <input type="submit" value="Inscription ">
        </form>

        <form method="get" action="{$this->cont['router']->pathFor('util_connexion')}">
          <label for="name">Déjà inscrit(e) ? Connectez vous </label>
          <input type="submit" value="Connexion">
        </form>
        YOP;
    }

    public function connect() {
      return <<<YOP
      <form method="post" action="{$this->cont['router']->pathFor('util_connecte')}">
      <div>
        <label for="mail">e-mail&nbsp;:</label>
        <input type="email" id="mail" name="mail">
      </div>
      <div>
        <label for="mdp">Mot de passe : </label>
        <input type="password" id="pass" name="mdp">
      </div>
        <input type="submit" value="Connexion">
      </form>

      <form method="get" action="{$this->cont['router']->pathFor('util_nouveau')}">
        <label for="name">Pas de compte ?</label>
        <input type="submit" value="Créer mon compte">
      </form>
      YOP;
    }

    public function liste() {
      $res = "<h1>Liste des membres</h1>" ;
      $users = Utilisateur::select('id', 'username')->get() ;
      foreach($users as $user){
        $res .= <<<YOP
        <form method="post" action="{$this->cont->router->pathFor('radier', ['id' => $user->id])}">
          <p>$user->username
          <input type="submit" value="Radier"></p>
        </form>

        YOP;
      }
      return $res ;
    }
}
