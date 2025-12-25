<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<section class="auth-card wide" id="signup">
    <div class="auth-header">
        <h1 class="auth-title">Créer un compte</h1>
        <p class="auth-subtitle">Rejoignez la communauté et commencez à économiser.</p>
    </div>

    <form class="auth-form two-columns signup-form" action="<?= Url::to(['site/signup']) ?>" method="POST">
        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>

        <div class="form-group">
            <label for="nom" class="form-label">Nom</label>
            <?= Html::input('text', 'SignupForm[nom]', '', [
                    'id' => 'nom',
                    'class' => 'form-input',
                    'placeholder' => 'Votre nom',
                    'required' => true
            ]) ?>
        </div>

        <div class="form-group">
            <label for="prenom" class="form-label">Prénom</label>
            <?= Html::input('text', 'SignupForm[prenom]', '', [
                    'id' => 'prenom',
                    'class' => 'form-input',
                    'placeholder' => 'Votre prénom',
                    'required' => true
            ]) ?>
        </div>

        <div class="form-group">
            <label for="pseudo" class="form-label">Pseudo</label>
            <?= Html::input('text', 'SignupForm[pseudo]', '', [
                    'id' => 'pseudo',
                    'class' => 'form-input',
                    'placeholder' => 'Choisissez un pseudo',
                    'required' => true
            ]) ?>
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Adresse e-mail</label>
            <?= Html::input('email', 'SignupForm[email]', '', [
                    'id' => 'email',
                    'class' => 'form-input',
                    'placeholder' => 'nom@exemple.com',
                    'required' => true
            ]) ?>
        </div>

        <div class="form-group full-width">
            <label for="password" class="form-label">Mot de passe</label>
            <?= Html::input('password', 'SignupForm[password]', '', [
                    'id' => 'password',
                    'class' => 'form-input',
                    'placeholder' => '8 caractères minimum',
                    'required' => true,
                    'minlength' => 8
            ]) ?>
        </div>

        <div class="form-group">
            <label for="permis" class="form-label">N° Permis <span>(Optionnel)</span></label>
            <?= Html::input('text', 'SignupForm[permis]', '', [
                    'id' => 'permis',
                    'class' => 'form-input',
                    'placeholder' => 'Pour les conducteurs'
            ]) ?>
        </div>

        <div class="form-group">
            <label for="photo" class="form-label">Photo URL <span>(Optionnel)</span></label>
            <?= Html::input('url', 'SignupForm[photo]', '', [
                    'id' => 'photo',
                    'class' => 'form-input',
                    'placeholder' => 'https://...'
            ]) ?>
        </div>

        <div class="form-group full-width">
            <button type="submit" class="auth-submit">Commencer l'aventure</button>
        </div>
    </form>

    <div class="auth-footer">
        <p>Déjà membre ? <a href="<?= Url::to(['site/login']) ?>" class="auth-link js-auth-link">Se connecter</a></p>
    </div>
</section>