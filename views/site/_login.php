<?php

use yii\helpers\Url;

?>
<section class="auth-card">
    <div class="auth-header">
        <h1 class="auth-title">Bon retour</h1>
        <p class="auth-subtitle">Connectez-vous pour poursuivre votre voyage.</p>
    </div>

    <form class="auth-form" action="<?=Url::to(['site/login']) ?>" method="POST">
        <div class="form-group">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input type="email" id="email" name="email" class="form-input" placeholder="nom@exemple.com" required>
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
        </div>

        <button type="submit" class="auth-submit">Se connecter</button>
    </form>

    <div class="auth-footer">
        <p>Pas encore de compte ? <a href="<?=Url::to(['site/signup']) ?>" class="auth-link">Créer un profil</a></p>
    </div>
</section>