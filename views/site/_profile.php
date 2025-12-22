<?php

use yii\helpers\Url;


?>

<section class="auth-card wide">
    <div class="auth-header">
        <h1 class="auth-title">Mon compte</h1>
        <p class="auth-subtitle">Vous pouvez modifier vous informations.</p>
    </div>

    <div class="avatar">
        <img src="https://i.pravatar.cc/150?img=5" alt="user avatar">
    </div>

    <form id="profile-form" class="auth-form two-columns" action="<?=Url::to(['site/profile']) ?>" method="POST">
        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
        <div class="form-group">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" id="nom" name="nom" class="form-input" placeholder="Votre nom" required value="<?=$user->nom ?>">
        </div>

        <div class="form-group">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" id="prenom" name="prenom" class="form-input" placeholder="Votre prénom" required value="<?=$user->prenom ?>">
        </div>

        <div class="form-group">
            <label for="pseudo" class="form-label">Pseudo</label>
            <input type="text" id="pseudo" name="pseudo" class="form-input" placeholder="Choisissez un pseudo" required value="<?=$user->pseudo ?>">
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input type="email" id="email" name="email" class="form-input" placeholder="nom@exemple.com" required value="<?=$user->mail?>">
        </div>

        <div class="form-group full-width">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" id="password" name="password" class="form-input" placeholder="Vous pouvez entrez un nouveau mot de pass" minlength="8">
        </div>

        <div class="form-group">
            <label for="permis" class="form-label">N° Permis <span>(Optionnel)</span></label>
            <input type="text" id="permis" name="permis" class="form-input" placeholder="Pour les conducteurs" value="<?=$user->permis ?: '' ?>">
        </div>

        <div class="form-group">
            <label for="photo" class="form-label">Photo URL <span>(Optionnel)</span></label>
            <input type="url" id="photo" name="photo" class="form-input" placeholder="https://..." value="<?= $user->photo ?: '' ?>">
        </div>

        <div class="form-group full-width">
            <button type="submit" class="auth-submit">Sauvgarder</button>
        </div>
    </form>

    <div class="auth-footer">
        <?= !$user->permis ? '<p>Rejoindre nos conducteurs ? <a href="#permis" class="auth-link">Ajouter un permis</a></p>' : '' ?>

        <a class="logout" href="<?=Url::to(['site/logout']) ?>">Déconnexion</a>
    </div>
</section>
