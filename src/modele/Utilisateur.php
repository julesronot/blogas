<?php

namespace blogapp\modele ;

class Utilisateur extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'utilisateurs' ;
    protected $primaryKey = 'id' ;
    public $timestamps = false;

    public function commentaire() {
        return $this->hasMany('\blogapp\modele\Commentaire', 'id_user');
    }

    public function billet() {
      return $this->hasMany('\blogapp\modele\Billet', 'id_user') ;
    }
}

?>
