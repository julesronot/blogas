<?php


namespace blogapp\controleur;

use blogapp\modele\Commentaire;


class CommentaireControleur
{

  private $cont ;

  public function __construct($conteneur) {
      $this->cont = $conteneur;
  }

  public function nouveau($rq, $rs, $args){
    $id_billet = $args['id'] ;
    $commentaire = filter_var($rq->getParsedBodyParam('commentaire'), FILTER_SANITIZE_STRING);

    if ($commentaire == NULL){
      $this->cont->flash->addMessage('error', "Ajoutez du texte à votre commentaire.");
      return $rs->withRedirect($this->cont->router->pathFor('billet_aff', ['id' => $id_billet]));
    }

    $comm = new Commentaire() ;
    $comm->commentaire = $commentaire ;
    $comm->date = date("y-m-d");
    $comm->id_billet = $id_billet ;
    $comm->id_user = $_SESSION['user']['id'] ;
    $comm->save() ;

    $this->cont->flash->addMessage('info', "Commentaire ajouté !");
    return $rs->withRedirect($this->cont->router->pathFor('billet_aff', ['id' => $id_billet]));
  }
}
