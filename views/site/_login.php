<?php

use yii\helpers\Url;

?>
<section class="auth-card">
    <div class="auth-header">
        <h1 class="auth-title">Bon retour</h1>
        <p class="auth-subtitle">Connectez-vous pour poursuivre votre voyage.</p>
    </div>

    <form class="auth-form login-form" action="<?=Url::to(['site/login']) ?>" method="POST">
        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
        <div class="form-group">
            <label for="pseudo" class="form-label">Pseudo</label>
            <input type="text" id="pseudo" name="LoginForm[pseudo]" class="form-input" placeholder="ex: chiheb_kbs" required>
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" id="password" name="LoginForm[password]" class="form-input" placeholder="••••••••" required>
        </div>

        <button type="submit" class="auth-submit">Se connecter</button>
    </form>

    <div class="auth-footer">
        <p>Pas encore de compte ? <a href="<?=Url::to(['site/signup']) ?>" class="auth-link js-auth-link">Créer un profil</a></p>
    </div>
</section>