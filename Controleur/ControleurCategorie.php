<?php

require_once 'Framework/Controleur.php';
require_once 'Modele/Billet.php';
require_once 'Modele/Categorie.php';

class ControleurCategorie extends Controleur {

    private $billet;
    private $categorie;

    public function __construct() {
        $this->billet = new Billet();
        $this->categorie = new Categorie();
    }

    // Redirige à l'accueil
    public function index() {
        $this->rediriger('Accueil');
    }

    // Affiche les billets de la catégorie
    public function billets()
    {
        $idCategorie = $this->requete->getParametre('id');
        $billets = $this->billet->getBilletsCategorie($idCategorie);
        $categorie = $this->categorie->getCategorie($idCategorie);
        $this->genererVue( array(
            'billets' => $billets,
            'categorie' => $categorie
        ));
    }

}

