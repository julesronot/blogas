<?php

namespace blogapp\modele;

class Commentaire extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'commentaires';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function billet() {
        return $this->belongsTo('\blogapp\modele\Billet', 'id_billet');
    }

    public function user() {
        return $this->belongsTo('\blogapp\modele\Utilisateur', 'id_user');
    }
}

?>
