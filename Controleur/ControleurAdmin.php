<?php

require_once 'ControleurSecurise.php';
require_once 'Modele/Billet.php';
require_once 'Modele/Commentaire.php';
require_once 'Modele/Categorie.php';

/**
 * Contrôleur des actions d'administration
 *
 * @author Baptiste Pesquet
 */
class ControleurAdmin extends ControleurSecurise
{
    private $billet;
    private $commentaire;
    private $categorie;

    /**
     * Constructeur 
     */
    public function __construct()
    {
        $this->billet = new Billet();
        $this->commentaire = new Commentaire();
        $this->categorie = new Categorie();
    }

    public function index()
    {
        $nbBillets = $this->billet->getNombreBillets();
        $nbCommentaires = $this->commentaire->getNombreCommentaires();
        $login = $this->requete->getSession()->getAttribut("login");
        $this->genererVue(array('nbBillets' => $nbBillets, 'nbCommentaires' => $nbCommentaires, 'login' => $login));
    }

    public function listerBillets()
    {
        $billets = $this->billet->getBillets();
        $this->genererVue(array('billets' => $billets));
    }

    // Formulaire d'ajout d'un billet
    public function formulaireAjouterBillet()
    {
        $champs = array();
        if( $this->requete->getSession()->existeAttribut('formulaireAjouterBillet') ) {
            $champs = $this->requete->getSession()->getAttribut('formulaireAjouterBillet');
            $this->requete->getSession()->supprimerAttribut('formulaireAjouterBillet');
        }

        $champs['categories'] = $this->categorie->getCategories();

        $this->genererVue($champs);
    }

    // 
    public function ajouterBillet()
    {

        $champManquant = false;
        if( $this->requete->existeParametre("titre_billet") ) {
            $billet['titre'] = $this->requete->getParametre("titre_billet"); 
        }
        else {
            $champManquant = true;
        }

        if( $this->requete->existeParametre("contenu_billet") ) {
            $billet['contenu'] = $this->requete->getParametre("contenu_billet"); 
        }
        else {
            $champManquant = true;
        }

        if( $this->requete->existeParametre("categorie_billet") ) {
            $billet['idCategorie'] = $this->requete->getParametre("categorie_billet"); 
        }
        else {
            $champManquant = true;
        }

        if( $champManquant ) {
            $message = "Veuillez saisir tous les champs.";
            $session = $this->requete->getSession();
            $session->setAttribut('formulaireAjouterBillet', array(
                'billet' => $billet,
                'message' => $message
            ));
            $this->rediriger("Admin","formulaireAjouterBillet");
        }
        else {
            $this->billet->ajouterBillet($billet['titre'], $billet['contenu'], $billet['idCategorie']);
            $this->rediriger("Admin", "listerBillets");
        }
        
    }
    
    // Formulaire d'édition d'un billet
    public function formulaireEditerBillet()
    {
        if( $this->requete->getSession()->existeAttribut('formulaireEditerBillet')) {
            $champs = $this->requete->getSession()->getAttribut('formulaireEditerBillet');
            $this->requete->getSession()->supprimerAttribut('formulaireEditerBillet');
            $champs['categories'] = $this->categorie->getCategories();
            $this->genererVue($champs);
        }
        elseif( $this->requete->existeParametre('id') ){
            $idBillet = $this->requete->getParametre('id');
            $billet = $this->billet->getBillet($idBillet);
            $categories = $this->categorie->getCategories();
            $this->genererVue(array(
                'billet' => $billet,
                'categories' => $categories
            ));
        }
        else {
            throw new Exception("Edition du billet impossible : l'id n'est pas spécifié");
        }
    }

    // Modifier le billet en base
    public function editerBillet()
    {
        $billet['id'] = (int)$this->requete->getParametre('id');

        $champManquant = false;
        if( $this->requete->existeParametre("titre_billet") ) {
            $billet['titre'] = $this->requete->getParametre("titre_billet"); 
        }
        else {
            $champManquant = true;
        }

        if( $this->requete->existeParametre("contenu_billet") ) {
            $billet['contenu'] = $this->requete->getParametre("contenu_billet"); 
        }
        else {
            $champManquant = true;
        }

        if( $this->requete->existeParametre("categorie_billet") ) {
            $billet['idCategorie'] = $this->requete->getParametre("categorie_billet"); 
        }
        else {
            $champManquant = true;
        }

        if( $champManquant ) {
            $message = "Veuillez saisir tous les champs.";
            $session = $this->requete->getSession();
            $session->setAttribut('formulaireEditerBillet', array(
                'billet' => $billet,
                'message' => $message
            ));
            $this->rediriger("Admin","formulaireEditerBillet");
        }
        else {
            $this->billet->editerBillet($billet['id'], $billet['titre'], $billet['contenu'], $billet['idCategorie']);
            $this->rediriger("Admin", "listerBillets");
        }
    }

    // Formulaire de confirmation de suppression d'un billet
    public function formulaireSupprimerBillet()
    {
        $idBillet = $this->requete->getParametre('id');
        $billet = $this->billet->getMetadonnees($idBillet);
        $date = new DateTime($billet['date']);
        $billet['date'] = $date->format('d-m-Y');
        $billet['heure'] = $date->format('H\hi');
        $billet['nbCommentaires'] = $this->commentaire->getNombreCommenairesBillet($idBillet);
        $this->genererVue(array(
            'billet' => $billet
        ));
    }

    // Supprimer un billet et les commentaires associés
    public function supprimerBillet()
    {
        $idBillet = $this->requete->getParametre('id');
        $this->commentaire->supprimerCommentairesBillet($idBillet);
        $this->billet->supprimerBillet($idBillet);
        $this->rediriger('Admin', 'listerBillets');
    }

    // Lister tous les commentaires d'un billet
    public function listerCommentaires()
    {
        $idBillet = $this->requete->getParametre('id');
        $billet = $this->billet->getBillet($idBillet);
        $commentaires = $this->commentaire->getCommentaires($idBillet);

        $this->genererVue(array(
            'billet' => $billet,
            'commentaires' => $commentaires
        ));

    }

    // Formulaire de confirmation de suppression d'un commentaire
    public function formulaireSupprimerCommentaire()
    {
        $idCommentaire = $this->requete->getParametre('id');
        $commentaire = $this->commentaire->getCommentaire($idCommentaire);
        $date = new DateTime($commentaire['date']);
        $commentaire['date'] = $date->format('d-m-Y');
        $commentaire['heure'] = $date->format('H\hi');

        $this->genererVue(array(
            'commentaire' => $commentaire,
        ));
    }

    public function supprimerCommentaire()
    {
        $idCommentaire = $this->requete->getParametre('id_commentaire');
        $this->commentaire->supprimerCommentaire($idCommentaire);

        $idBillet = $this->requete->getParametre('id');
        $this->rediriger('Admin', 'listerCommentaires', $idBillet);
    }

    public function listerCategories()
    {
        $categories = $this->categorie->getCategorieAvecIdBillet();
        $this->genererVue(array(
            'categories' => $categories
        ));
    }

    public function formulaireAjouterCategorie()
    {
        $champs = array();
        if( $this->requete->getSession()->existeAttribut('formulaireAjouterCategorie') ) {
            $champs = $this->requete->getSession()->getAttribut('formulaireAjouterCategorie');
            $this->requete->getSession()->supprimerAttribut('formulaireAjouterCategorie');
        }
        $this->genererVue($champs);
    }

    public function ajouterCategorie()
    {
        if( $this->requete->existeParametre("nom_categorie") == false ) {
            $message = "Veuillez saisir tous les champs.";
            $session = $this->requete->getSession();
            $session->setAttribut('formulaireAjouterCategorie', array(
                'message' => $message
            ));
            $this->rediriger("Admin","formulaireAjouterCategorie");
        }
        else {
            $nomCategorie = $this->requete->getParametre('nom_categorie');
            if( (bool)$this->categorie->getCategorieId($nomCategorie) == false ) {
                $this->categorie->ajouterCategorie($nomCategorie);
            }

            $this->rediriger('Admin', 'listerCategories');
        }
    }

    public function formulaireEditerCategorie()
    {
        if( $this->requete->getSession()->existeAttribut('formulaireEditerCategorie')) {
            $champs = $this->requete->getSession()->getAttribut('formulaireEditerCategorie');
            $this->requete->getSession()->supprimerAttribut('formulaireEditerCategorie');
            $this->genererVue($champs);
        }
        elseif( $this->requete->existeParametre('id') ){
            $idCategorie = $this->requete->getParametre('id');
            $categorie = $this->categorie->getCategorie($idCategorie);
            $this->genererVue(array(
                'categorie' => $categorie
            ));
        }
        else {
            throw new Exception("Edition de la catégorie impossible : l'id n'est pas spécifié");
        }
    }

    public function editerCategorie()
    {
        $categorie['id'] = (int)$this->requete->getParametre('id');

        if( $this->requete->existeParametre('nom_categorie') == false ){
            $message = "Veuillez saisir tous les champs.";
            $session = $this->requete->getSession();
            $session->setAttribut('formulaireEditerCategorie', array(
                'message' => $message,
                'categorie' => $categorie
            ));
            $this->rediriger("Admin","formulaireEditerCategorie", $categorie['id']);
        }
        else {
            $categorie['nom'] = $this->requete->getParametre('nom_categorie');
            if( (bool)$this->categorie->getCategorieId($categorie['nom']) == false ) {
                $this->categorie->editerCategorie($categorie['id'], $categorie['nom']);
                $this->rediriger('Admin', 'listerCategories');
            }
            else {
                $message = 'Le nom spécifié est déjà utilisé';
                $session = $this->requete->getSession();
                $session->setAttribut('formulaireEditerCategorie', array(
                    'message' => $message,
                    'categorie' => $categorie
                ));
                $this->rediriger("Admin","formulaireEditerCategorie", $categorie['id']);
            }
        }
    }

    public function formulaireSupprimerCategorie()
    {
        $idCategorie = $this->requete->getParametre('id');
        $categorie = $this->categorie->getCategorie($idCategorie);
        $this->genererVue(array(
            'categorie' => $categorie
        ));
    }

    public function supprimerCategorie()
    {
        $idCategorie = $this->requete->getParametre('id');
        $this->categorie->supprimerCategorie($idCategorie);
        $this->rediriger('Admin', 'listerCategories');
    }

}

