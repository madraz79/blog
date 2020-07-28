<?php

require_once 'Framework/Modele.php';

/**
 * Fournit les services d'accès aux genres musicaux 
 * 
 * @author Baptiste Pesquet
 */
class Commentaire extends Modele {

    public function getCommentaire($idCommentaire)
    {
        $sql = 'SELECT COM_ID as id, COM_DATE as date, COM_AUTEUR as auteur,'
            . ' COM_CONTENU as contenu, BIL_ID as idBillet'
            . ' FROM T_COMMENTAIRE'
            . ' WHERE COM_ID = ?';
        $commentaire = $this->executerRequete($sql, array($idCommentaire));
        return $commentaire->fetch();
    }

    // Renvoie la liste des commentaires associés à un billet
    public function getCommentaires($idBillet) {
        $sql = 'select COM_ID as id, COM_DATE as date,'
                . ' COM_AUTEUR as auteur, COM_CONTENU as contenu from T_COMMENTAIRE'
                . ' where BIL_ID=?';
        $commentaires = $this->executerRequete($sql, array($idBillet));
        return $commentaires;
    }

    public function ajouterCommentaire($auteur, $contenu, $idBillet) {
        $sql = 'insert into T_COMMENTAIRE(COM_DATE, COM_AUTEUR, COM_CONTENU, BIL_ID)'
            . ' values(?, ?, ?, ?)';
        $date = date('Y-m-d H:i:s');
        $this->executerRequete($sql, array($date, $auteur, $contenu, $idBillet));
    }
    
    public function supprimerCommentaire($idCommentaire)
    {
        $sql = 'DELETE FROM T_COMMENTAIRE'
            . ' WHERE COM_ID = ?';
        $this->executerRequete($sql, array($idCommentaire));
    }

    /**
     * Renvoie le nombre total de commentaires
     * 
     * @return int Le nombre de commentaires
     */
    public function getNombreCommentaires()
    {
        $sql = 'select count(*) as nbCommentaires from T_COMMENTAIRE';
        $resultat = $this->executerRequete($sql);
        $ligne = $resultat->fetch();  // Le résultat comporte toujours 1 ligne
        return $ligne['nbCommentaires'];
    }

    public function getNombreCommenairesBillet($idBillet)
    {
        $sql = 'select count(*) as nbCommentaires from T_COMMENTAIRE where BIL_ID=?';
        $resultat = $this->executerRequete($sql, array($idBillet));
        $ligne = $resultat->fetch();  // Le résultat comporte toujours 1 ligne
        return $ligne['nbCommentaires'];
    }

    public function supprimerCommentairesBillet($idBillet)
    {
        $sql = 'DELETE FROM T_COMMENTAIRE'
            . ' WHERE BIL_ID=?';
        $this->executerRequete($sql, array($idBillet));
    }
}