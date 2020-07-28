<?php $this->titre = "Mon Blog - Administration" ?>

<h2>Supprimer une catégorie</h2>

<form action="Admin/supprimerCategorie" method="post">
    <p>
        Etes-vous sûr(e) de vouloir supprimer la catégorie intitulée "<?= $categorie['nom']?>" ?
    </p>
    <input type="hidden" name="id" value="<?= $categorie['id']?>">
    <button type="submit" name="annuler" formaction="Admin/listerCategories">Annuler</button>
    <button type="submit" name="valider">Valider</button>
</form>