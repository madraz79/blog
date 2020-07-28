<?php $this->titre = "Mon Blog - Administration" ?>

<h2>Administration</h2>

Bienvenue, <?= $this->nettoyer($login) ?> !
Ce blog comporte <?= $this->nettoyer($nbBillets) ?> billet(s) et <?= $this->nettoyer($nbCommentaires) ?> commentaire(s).
<br>
<nav>
    <ul>
        <li><a href="admin/listerBillets">Gestion des billets</a></li>
        <li><a href="admin/listerCategories">Gestion des catégories</a></li>
    </ul>
</nav>
<a id="lienDeco" href="connexion/deconnecter">Se déconnecter</a>