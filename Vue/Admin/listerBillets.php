<?php $this->titre = "Mon Blog - Administration" ?>

<h2>Liste des billets</h2>

<p><a href="Admin/formulaireAjouterBillet/">Créer un billet</a></p>

<table>
    <thead>
        <tr>
            <th>id</th>
            <th>Titre</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach( $billets as $billet ): ?>
            <tr>
                <td><?= $this->nettoyer($billet['id']) ?></td>
                <td><?= $this->nettoyer($billet['titre']) ?></td>
                <td><?= $this->nettoyer($billet['date']) ?></td>
                <td>
                    <a href="Admin/formulaireEditerBillet/<?= $this->nettoyer($billet['id']) ?>">Editer</a>
                    <a href="Admin/formulaireSupprimerBillet/<?= $this->nettoyer($billet['id']) ?>">Supprimer</a>
                    <a href="Admin/listerCommentaires/<?= $billet['id']?>">Commentaires</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a id="lienDeco" href="connexion/deconnecter">Se déconnecter</a>