<?php

class Categorie extends Modele
{
    public function getCategories()
    {
        $sql = 'SELECT CAT_ID as id, CAT_NOM as nom FROM T_CATEGORIE';
        $categories = $this->executerRequete($sql);
        return $categories;
    }

    public function getCategorie($idCategorie)
    {
        $sql = 'SELECT CAT_ID as id, CAT_NOM as nom FROM T_CATEGORIE'
            . ' WHERE CAT_ID = ?';
        $categorie = $this->executerRequete($sql, array($idCategorie));
        if ($categorie->rowCount() > 0)
            return $categorie->fetch();  // Accès à la première ligne de résultat
        else
            throw new Exception("Aucune catégorie ne correspond à l'identifiant '.$idCategorie.'");
    }

    public function getCategorieId($nomCategorie)
    {
        $sql = 'SELECT CAT_ID as id FROM T_CATEGORIE'
            . ' WHERE CAT_NOM=?';
        $resultat = $this->executerRequete($sql, array($nomCategorie))->fetch();
        return $resultat;
    }

    public function getCategorieAvecIdBillet()
    {
        $sql = 'SELECT DISTINCT T_CATEGORIE.CAT_ID as id, T_CATEGORIE.CAT_NOM as nom,'
            . ' T_BILLET.CAT_ID as idBillet'
            . ' FROM T_CATEGORIE'
            . ' LEFT JOIN T_BILLET'
            . ' ON T_CATEGORIE.CAT_ID = T_BILLET.CAT_ID';
        $categories = $this->executerRequete($sql);
        return $categories;
    }


    public function ajouterCategorie($nomCategorie)
    {
        $sql = 'INSERT INTO T_CATEGORIE(CAT_NOM)'
            . ' VALUES(?)';
        $this->executerRequete($sql, array($nomCategorie));
    }

    public function editerCategorie($idCategorie, $nomCategorie)
    {
        $sql = 'UPDATE T_CATEGORIE'
            . ' SET CAT_NOM=?'
            . ' WHERE CAT_ID=?';
        $this->executerRequete($sql, array($nomCategorie, $idCategorie));
    }

    public function supprimerCategorie($idCategorie)
    {
        $sql = 'DELETE FROM T_CATEGORIE'
            . ' WHERE CAT_ID=?';
            $this->executerRequete($sql, array($idCategorie));
    }
}