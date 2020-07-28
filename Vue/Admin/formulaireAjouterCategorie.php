<?php $this->titre = "Mon Blog - Administration" ?>

<h2>Ajouter un catégorie</h2>

<?php if( isset($message) ): ?>
    <p><?= $message ?></p>
<?php endif; ?>

<form action="Admin/ajouterCategorie" method="post">
    <label for="nom_categorie">Nom :</label>
    <input type="text" name="nom_categorie" id="nom_categorie" value="<?= isset($categorie['nom'])?$categorie['nom']:""?>">
    <br>
    <label for="categorie_billet">Catégorie :</label>
    <select name="categorie_billet" id="categorie_billet">
        <?php foreach($categories as $categorie): ?>
            <option value="<?= $categorie['id']; ?>" <?= (isset($billet['idCategorie']) && $billet['idCategorie'] == $categorie['id'])?"selected":""?>>
                <?= $categorie['nom']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>
    <button type="submit" name="valider">Valider</button>
</form>