<?php $this->titre = "Mon Blog - Administration" ?>

<h2>Supprimer un billet</h2>

<form action="Admin/supprimerBillet" method="post">
    <p>
        Etes-vous sûr(e) de vouloir supprimer le billet intitulé "<?= $billet['titre'] ?>"
        publié le <?= $billet['date'] ?> à <?= $billet['heure'] ?>
        ainsi que les <?= $billet['nbCommentaires'] ?> commentaires associées ?
    </p>
    <input type="hidden" name="id" value="<?= isset($billet['id'])?$billet['id']:"" ?>">
    <button type="submit" name="annuler" formaction="Admin/listerBillets">Annuler</button>
    <button type="submit" name="valider">Valider</button>
</form>