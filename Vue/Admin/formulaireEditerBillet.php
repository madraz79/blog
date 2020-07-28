<?php $this->titre = "Mon Blog - Administration" ?>

<h2>Editer un billet</h2>

<?php if( isset($message) ): ?>
    <p><?= $message ?></p>
<?php endif; ?>

<form action="Admin/editerBillet" method="post">
    <label for="titre_billet">Titre :</label>
    <input type="text" name="titre_billet" id="titre_billet" value="<?= isset($billet['titre'])?$billet['titre']:""?>">
    <br>
    <label for="contenu_billet">Contenu :</label>
    <textarea name="contenu_billet" id="contenu_billet" rows="5"><?= isset($billet['contenu'])?$billet['contenu']:""?></textarea>
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
    <input type="hidden" name="id" value="<?= isset($billet['id'])?$billet['id']:"" ?>">
    <button type="submit" name="valider">Valider</button>
</form>