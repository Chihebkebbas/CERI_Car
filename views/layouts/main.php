<?php
use yii\helpers\Html;
use yii\helpers\Url;

use app\assets\AppAsset;

/*Pour appliquer le css et js déclarer dans assets/AppAsset.php sur la vue courante */
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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&family=DM+Sans:opsz,wght@9..40,400;500;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet" />
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<header role="banner">
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
            <a href="<?=Url::to(['site/login']) ?>" class="btn-text">Connexion</a>
            <a href="<?=Url::to(['site/signup']) ?>" class="btn-primary">S'inscrire</a>
        </div>
    </div>
    <div id="notification-banner"></div>
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
