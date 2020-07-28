<?php $this->titre = "Mon Blog - Administration" ?>

<h2>Liste des catégories</h2>

<p><a href="Admin/formulaireAjouterCategorie/">Créer une catégorie</a></p>

<table>
    <thead>
        <tr>
            <th>id</th>
            <th>Nom</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach( $categories as $categorie ): ?>
            <tr>
                <td><?= $this->nettoyer($categorie['id']) ?></td>
                <td><?= $this->nettoyer($categorie['nom']) ?></td>
                <td>
                    <a href="Admin/formulaireEditerCategorie/<?= $categorie['id'] ?>">Editer</a>
                    <?php if( is_null($categorie['idBillet']) ): ?>
                        <a href="Admin/formulaireSupprimerCategorie/<?= $categorie['id']  ?>">Supprimer</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a id="lienDeco" href="connexion/deconnecter">Se déconnecter</a>