<?php $this->titre = "Mon Blog - Administration" ?>

<h2>Editer une catégorie</h2>

<?php if( isset($message) ): ?>
    <p><?= $message ?></p>
<?php endif; ?>

<form action="Admin/editerCategorie" method="post">
    <label for="nom_categorie">Titre :</label>
    <input type="text" name="nom_categorie" id="nom_categorie" value="<?= isset($categorie['nom'])?$categorie['nom']:""?>">
    <br>
    <input type="hidden" name="id" value="<?= isset($categorie['id'])?$categorie['id']:"" ?>">
    <button type="submit" name="annuler" formaction="Admin/listerCategories">Annuler</button>
    <button type="submit" name="valider">Valider</button>
</form>