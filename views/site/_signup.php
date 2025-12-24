<?php

use yii\helpers\Url;


?>
<section class="auth-card wide" id="signup">
    <div class="auth-header">
        <h1 class="auth-title">Créer un compte</h1>
        <p class="auth-subtitle">Rejoignez la communauté et commencez à économiser.</p>
    </div>

    <form class="auth-form two-columns signup-form" action="<?=Url::to(['site/signup']) ?>" method="POST">
        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
        <div class="form-group">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" id="nom" name="SignupForm[nom]" class="form-input" placeholder="Votre nom" required>
        </div>

        <div class="form-group">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" id="prenom" name="SignupForm[prenom]" class="form-input" placeholder="Votre prénom" required>
        </div>

        <div class="form-group">
            <label for="pseudo" class="form-label">Pseudo</label>
            <input type="text" id="pseudo" name="SignupForm[pseudo]" class="form-input" placeholder="Choisissez un pseudo" required>
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input type="email" id="email" name="SignupForm[email]" class="form-input" placeholder="nom@exemple.com" required>
        </div>

        <div class="form-group full-width">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" id="password" name="SignupForm[password]" class="form-input" placeholder="8 caractères minimum" required minlength="8">
        </div>

        <div class="form-group">
            <label for="permis" class="form-label">N° Permis <span>(Optionnel)</span></label>
            <input type="text" id="permis" name="SignupForm[permis]" class="form-input" placeholder="Pour les conducteurs">
        </div>

        <div class="form-group">
            <label for="photo" class="form-label">Photo URL <span>(Optionnel)</span></label>
            <input type="url" id="photo" name="SignupForm[photo]" class="form-input" placeholder="https://...">
        </div>

        <div class="form-group full-width">
            <button type="submit" class="auth-submit">Commencer l'aventure</button>
        </div>
    </form>

    <div class="auth-footer">
        <p>Déjà membre ? <a href="<?=Url::to(['site/login'])?>" class="auth-link js-auth-link">Se connecter</a></p>
    </div>
</section>