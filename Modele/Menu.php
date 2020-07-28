<?php

require_once 'Framework/Modele.php';

class Menu extends Modele
{

    public function getElementsMenu()
    {
        $menu = array();
        $menu[] = array(
            'nom' => 'Accueil',
            'lien' => 'accueil'
        );

        $sql = 'SELECT T_CATEGORIE.CAT_ID as id, T_CATEGORIE.CAT_NOM as nom, T_BILLET.BIL_ID as idBillet'
            . ' FROM T_CATEGORIE'
            . ' LEFT JOIN T_BILLET'
            . ' ON T_CATEGORIE.CAT_ID = T_BILLET.CAT_ID'
            . ' GROUP BY T_CATEGORIE.CAT_ID';
        $categories = $this->executerRequete($sql);

        foreach($categories as $categorie) {
            $menu[] = array(
                'nom' => $categorie['nom'],
                'lien' => 'categorie/billets/' . $categorie['id']
            );
        }

        $menu[] = array(
            'nom' => 'Administration',
            'lien' => 'admin'
        );

        return $menu;
    }

}