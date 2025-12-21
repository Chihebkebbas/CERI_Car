<?php
use yii\helpers\Html;
use yii\helpers\Url;

use app\assets\AppAsset;


AppAsset::register($this);

?>

<?php $this->beginPage() ?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CERI Car - Plateforme de covoiturage premium - conçu par Chiheb Eddine KEBBAS">
    <title><?=Html::encode($this->title) ?></title>

    <?php $this->registerCsrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<header role="banner">
    <?php if (Yii::$app->user->isGuest): ?>
        <div class="header-container">
            <a href="<?=Url::to(['site/index']) ?>" class="logo">
                CERI<span class="logo-dot">.</span><span class="logo-red">Car</span>
            </a>
            <nav role="navigation">
                <ul class="nav-items">
                    <li><a href="<?=Url::to(['site/index']) ?>">Explorer</a></li>
                    <li><a href="<?=Url::to(['site/index']) ?>#villes">Destinations</a></li>
                    <li><a href="<?=Url::to(['site/index']) ?>#concept">Concept</a></li>
                </ul>
            </nav>
            <div class="right-nav">
                <a href="<?=Url::to(['site/login']) ?>" class="btn-text js-auth-link">Connexion</a>
                <a href="<?=Url::to(['site/signup']) ?>" class="btn-primary js-auth-link">S'inscrire</a>
            </div>
        </div>
    <?php else: ?>
        <div class="header-container">
            <a href="<?= Url::to(['site/index']) ?>" class="logo">
                CERI<span class="logo-dot">.</span><span class="logo-red">Car</span>
            </a>
            <nav role="navigation">
                <ul class="nav-items">
                    <li><a href="<?= Url::to(['site/index']) ?>">Explorer</a></li>

                    <li><a href="<?= Url::to(['site/reservation']) ?>" class="reservation-ajax-link">Réservations</a></li>

                    <li><a href="<?= Url::to(['site/voyage']) ?>">Voyages</a></li>
                </ul>
            </nav>
            <div class="right-nav">
                <a href="<?= Url::to(['internaute/view', 'id' => Yii::$app->user->id]) ?>" class="btn-text">
                    @<?= Yii::$app->user->identity->pseudo ?>
                </a>

                <a href="<?= Url::to(['voyage/create']) ?>" class="btn-primary">Nouveau voyage</a>
            </div>
        </div>
    <?php endif; ?>
    <div id="notification-banner" style="display:none;"></div>
</header>

<main>
    <?= $content ?>
</main>


<footer role="contentinfo">
    <div class="footer-content">
        <div class="footer-brand">
            <a href="<?=Url::to(['site/index']) ?>" class="logo">CERI<span class="logo-dot">.</span><span class="logo-red">Car</span></a>
            <p>Le covoiturage nouvelle génération.</p>
        </div>
        <div class="footer-links">
            <a href="<?=Url::to(['site/index']) ?>#accueil">Explorer</a>
            <a href="<?=Url::to(['site/index']) ?>#villes">Destinations</a>
            <a href="<?=Url::to(['site/index']) ?>#concept">Concept</a>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 CERI Car. Conçu par <span class="chiheb">Chiheb Eddine KEBBAS</span>.</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
