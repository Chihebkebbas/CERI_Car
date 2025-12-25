<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<section class="auth-card">
    <div class="auth-header">
        <h1 class="auth-title">Bon retour</h1>
        <p class="auth-subtitle">Connectez-vous pour poursuivre votre voyage.</p>
    </div>

    <form class="auth-form login-form" action="<?= Url::to(['site/login']) ?>" method="POST">
        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>

        <div class="form-group">
            <label for="pseudo" class="form-label">Pseudo</label>
            <?= Html::input('text', 'LoginForm[pseudo]', '', [
                    'id' => 'pseudo',
                    'class' => 'form-input',
                    'placeholder' => 'ex: chiheb_kbs',
                    'required' => true
            ]) ?>
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Mot de passe</label>
            <?= Html::input('password', 'LoginForm[password]', '', [
                    'id' => 'password',
                    'class' => 'form-input',
                    'placeholder' => '••••••••',
                    'required' => true
            ]) ?>
        </div>

        <button type="submit" class="auth-submit">Se connecter</button>
    </form>

    <div class="auth-footer">
        <p>Pas encore de compte ? <a href="<?= Url::to(['site/signup']) ?>" class="auth-link js-auth-link">Créer un profil</a></p>
    </div>
</section>