<?php

namespace blogapp\modele;

class Billet extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'billets';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function categorie() {
        return $this->belongsTo('\blogapp\modele\Categorie', 'cat_id');
    }

    public function commentaire() {
        return $this->hasMany('\blogapp\modele\Commentaire', 'id_billet');
    }

}

?>
