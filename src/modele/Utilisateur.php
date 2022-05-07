<?php

namespace blogapp\modele ;

class Utilisateur extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'utilisateurs' ;
    protected $primaryKey = 'id' ;
    public $timestamps = false;
}

?>
