<?php

require_once 'Framework/Modele.php';

/**
 * Fournit les services d'accès aux genres musicaux 
 * 
 * @author Baptiste Pesquet
 */
class Billet extends Modele {

    /** Renvoie la liste des billets du blog
     * 
     * @return PDOStatement La liste des billets
     */
    public function getBillets() {
        $sql = 'select BIL_ID as id, BIL_DATE as date,'
                . ' BIL_TITRE as titre, BIL_CONTENU as contenu from T_BILLET'
                . ' order by BIL_ID desc';
        $billets = $this->executerRequete($sql);
        return $billets;
    }

    /** Renvoie les informations sur un billet
     * 
     * @param int $id L'identifiant du billet
     * @return array Le billet
     * @throws Exception Si l'identifiant du billet est inconnu
     */
    public function getBillet($idBillet) {
        $sql = 'SELECT BIL_ID as id, BIL_DATE as date,'
                . ' BIL_TITRE as titre, BIL_CONTENU as contenu, CAT_ID as idCategorie'
                . ' from T_BILLET'
                . ' where BIL_ID=?';
        $billet = $this->executerRequete($sql, array($idBillet));
        if ($billet->rowCount() > 0)
            return $billet->fetch();  // Accès à la première ligne de résultat
        else
            throw new Exception("Aucun billet ne correspond à l'identifiant '$idBillet'");
    }

    public function getBilletsCategorie($idCategorie)
    {
        $sql = 'SELECT BIL_ID as id, BIL_DATE as date, BIL_TITRE as titre, BIL_CONTENU as contenu'
            . ' FROM T_BILLET'
            . ' WHERE CAT_ID=? '
            . ' ORDER BY BIL_ID DESC';
            $billets = $this->executerRequete($sql, array($idCategorie));
            return $billets;
    }

    public function getMetadonnees($idBillet)
    {
        $sql = 'select BIL_ID as id, BIL_DATE as date,'
                . ' BIL_TITRE as titre from T_BILLET'
                . ' where BIL_ID=?';
        $billet = $this->executerRequete($sql, array($idBillet));
        if ($billet->rowCount() > 0)
            return $billet->fetch();  // Accès à la première ligne de résultat
        else
            throw new Exception("Aucun billet ne correspond à l'identifiant '$idBillet'");
    }

    /**
     * Renvoie le nombre total de billets
     * 
     * @return int Le nombre de billets
     */
    public function getNombreBillets()
    {
        $sql = 'select count(*) as nbBillets from T_BILLET';
        $resultat = $this->executerRequete($sql);
        $ligne = $resultat->fetch();  // Le résultat comporte toujours 1 ligne
        return $ligne['nbBillets'];
    }

    public function ajouterBillet($titre, $contenu, $categorie)
    {
        $sql = 'INSERT INTO T_BILLET(BIL_DATE, BIL_TITRE, BIL_CONTENU, CAT_ID)'
            .' VALUES(?, ?, ?, ?)';
        $date = date('Y-m-d H:i:s');
        $this->executerRequete($sql, array($date, $titre, $contenu, $categorie));
    }

    public function editerBillet($idBillet, $titreBillet, $contenuBillet, $idCategorie)
    {
        $sql = 'UPDATE T_BILLET'
            . ' SET BIL_TITRE=?, BIL_CONTENU=?, CAT_ID=?'
            . ' WHERE BIL_ID=?';
        $this->executerRequete($sql, array($titreBillet, $contenuBillet, $idCategorie, $idBillet));
    }

    public function supprimerBillet($idBillet)
    {
        $sql = 'DELETE FROM T_BILLET'
            . ' WHERE BIL_ID=?';
        $this->executerRequete($sql, array($idBillet));
    }
}