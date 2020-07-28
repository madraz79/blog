<?php $this->titre = "Mon Blog - Administration" ?>

<article>
    <header>
        <h1 class="titreBillet"><?= $this->nettoyer($billet['titre']) ?></h1>
        <time><?= $this->nettoyer($billet['date']) ?></time>
    </header>
    <p><?= $this->nettoyer($billet['contenu']) ?></p>
</article>
<hr />
<header>
    <h1 id="titreReponses">Réponses à <?= $this->nettoyer($billet['titre']) ?></h1>
</header>
<?php foreach ($commentaires as $commentaire): ?>
    <p><?= $this->nettoyer($commentaire['auteur']) ?> dit :</p>
    <p><?= $this->nettoyer($commentaire['contenu']) ?></p>
    <p><a href="Admin/formulaireSupprimerCommentaire/<?= $commentaire['id'] ?>">Supprimer</a></p>
<?php endforeach; ?>
