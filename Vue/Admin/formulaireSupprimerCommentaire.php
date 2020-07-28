<?php $this->titre = "Mon Blog - Administration" ?>

<h2>Supprimer un commentaire</h2>

<form action="Admin/supprimerCommentaire" method="post">
    <p>
        Etes-vous sûr(e) de vouloir supprimer le comentaire de "<?= $commentaire['auteur']?>"
        publié le <?= $commentaire['date'] ?> à <?= $commentaire['heure'] ?> ?
    </p>
    <input type="hidden" name="id_commentaire" value="<?= $commentaire['id']?>">
    <input type="hidden" name="id" value="<?= $commentaire['idBillet']?>">
    <button type="submit" name="annuler" formaction="Admin/listerCommentaires">Annuler</button>
    <button type="submit" name="valider">Valider</button>
</form>