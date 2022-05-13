<?php

namespace blogapp\authentification;

class Authentification {

    public static function loadProfile($newuser) {

      if (isset($_SESSION['user'])) {
        unset($_SESSION['user']);
      }

      switch ($newuser->statut){

        case 'admin' :
          $_SESSION['user'] = [
            'id' => $newuser->id ,
            'username' => $newuser->username ,
            'email' => $newuser->email ,
            'auth-level' => 2
          ];
          break ;

        case 'membre' :
          $_SESSION['user'] = [
            'id' => $newuser->id ,
            'username' => $newuser->username ,
            'email' => $newuser->email ,
            'auth-level' => 1
          ];
          break ;

        default :
          $_SESSION['user'] = [
            'username' => 'anonyme' ,
            'auth-level' => 0
          ];
          break ;
      }
    }

    public static function authlevel() {
      return $_SESSION['user']['auth-level'] ;
    }
}

?>
