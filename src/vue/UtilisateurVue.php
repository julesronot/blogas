<?php

namespace blogapp\vue;

use blogapp\vue\Vue;

class UtilisateurVue extends Vue {
    const NOUVEAU_VUE = 1;
    const CONNECT_VUE = 2;

    public function render() {
        switch($this->selecteur) {
        case self::NOUVEAU_VUE:
            $content = $this->nouveau();
            break;
        case self::CONNECT_VUE:
            $content = $this->connect();
        }
        return $this->userPage($content);
    }

    public function nouveau() {
        return <<<YOP
        <form method="post" action="{$this->cont['router']->pathFor('util_cree')}">
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
      YOP;
    }
}
