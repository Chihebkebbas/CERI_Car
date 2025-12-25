<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<section class="auth-card wide">
    <div class="auth-header">
        <h1 class="auth-title">Mon compte</h1>
        <p class="auth-subtitle">Vous pouvez modifier vous informations.</p>
    </div>

    <div class="avatar">
        <img src="<?= $user->photo ?>" alt="user avatar">
    </div>

    <form id="profile-form" class="auth-form two-columns" action="<?= Url::to(['site/profile']) ?>" method="POST">
        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>

        <div class="form-group">
            <label for="nom" class="form-label">Nom</label>
            <?= Html::input('text', 'nom', $user->nom, [
                    'id' => 'nom',
                    'class' => 'form-input',
                    'placeholder' => 'Votre nom',
                    'required' => true
            ]) ?>
        </div>

        <div class="form-group">
            <label for="prenom" class="form-label">Prénom</label>
            <?= Html::input('text', 'prenom', $user->prenom, [
                    'id' => 'prenom',
                    'class' => 'form-input',
                    'placeholder' => 'Votre prénom',
                    'required' => true
            ]) ?>
        </div>

        <div class="form-group">
            <label for="pseudo" class="form-label">Pseudo</label>
            <?= Html::input('text', 'pseudo', $user->pseudo, [
                    'id' => 'pseudo',
                    'class' => 'form-input',
                    'placeholder' => 'Choisissez un pseudo',
                    'required' => true
            ]) ?>
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Adresse e-mail</label>
            <?= Html::input('email', 'email', $user->mail, [
                    'id' => 'email',
                    'class' => 'form-input',
                    'placeholder' => 'nom@exemple.com',
                    'required' => true
            ]) ?>
        </div>

        <div class="form-group full-width">
            <label for="password" class="form-label">Mot de passe</label>
            <?= Html::input('password', 'password', '', [
                    'id' => 'password',
                    'class' => 'form-input',
                    'placeholder' => 'Vous pouvez entrez un nouveau mot de pass',
                    'minlength' => 8
            ]) ?>
        </div>

        <div class="form-group">
            <label for="permis" class="form-label">N° Permis <span>(Optionnel)</span></label>
            <?= Html::input('text', 'permis', $user->permis ?: '', [
                    'id' => 'permis',
                    'class' => 'form-input',
                    'placeholder' => 'Pour les conducteurs'
            ]) ?>
        </div>

        <div class="form-group">
            <label for="photo" class="form-label">Photo URL <span>(Optionnel)</span></label>
            <?= Html::input('url', 'photo', $user->photo ?: '', [
                    'id' => 'photo',
                    'class' => 'form-input',
                    'placeholder' => 'https://...'
            ]) ?>
        </div>

        <div class="form-group full-width">
            <button type="submit" class="auth-submit">Sauvgarder</button>
        </div>
    </form>

    <div class="auth-footer">
        <?= !$user->permis ? '<p>Rejoindre nos conducteurs ? <a href="#permis" class="auth-link">Ajouter un permis</a></p>' : '' ?>

        <a class="logout" href="<?= Url::to(['site/logout']) ?>" data-method="post">Déconnexion</a>
    </div>
</section>