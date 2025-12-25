<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

?>

<section class="auth-card wide">
    <div class="auth-header">
        <h1 class="auth-title">Proposer un voyage</h1>
        <p class="auth-subtitle">Partagez vos frais et rencontrez de nouvelles personnes.</p>
    </div>

    <form id="create-trip-form" class="auth-form two-columns" action="<?= Url::to(['site/create']) ?>" method="POST">
        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>

        <div class="form-group">
            <label for="depart" class="form-label">Ville de départ</label>
            <div class="input-with-icon">
                <?= Html::input('text', 'depart', '', [
                        'id' => 'depart',
                        'class' => 'form-input',
                        'placeholder' => 'Ex: Avignon',
                        'required' => true
                ]) ?>
            </div>
        </div>

        <div class="form-group">
            <label for="arrivee" class="form-label">Ville d'arrivée</label>
            <?= Html::input('text', 'arrivee', '', [
                    'id' => 'arrivee',
                    'class' => 'form-input',
                    'placeholder' => 'Ex: Paris',
                    'required' => true
            ]) ?>
        </div>

        <div class="form-group">
            <label for="heure" class="form-label">Heure de départ</label>
            <?= Html::input('time', 'heure', '', [
                    'id' => 'heure',
                    'class' => 'form-input',
                    'required' => true,
                    'step' => '3600'
            ]) ?>
        </div>

        <div class="form-group">
            <label for="tarif" class="form-label">Prix (€) (Max 5€)</label>
            <?= Html::input('number', 'tarif', '', [
                    'id' => 'tarif',
                    'class' => 'form-input',
                    'placeholder' => 'Ex: 4',
                    'min' => 0,
                    'max' => 5,
                    'step' => '0.5',
                    'required' => true
            ]) ?>
        </div>

        <div class="form-group">
            <label for="idmarquev" class="form-label">Marque Véhicule</label>
            <?= Html::dropDownList('idmarquev', null, ArrayHelper::map($marques, 'id', 'marquev'), [
                    'id' => 'idmarquev',
                    'class' => 'form-input',
                    'prompt' => 'Choisir...',
                    'required' => true
            ]) ?>
        </div>

        <div class="form-group">
            <label for="idtypev" class="form-label">Type Véhicule</label>
            <?= Html::dropDownList('idtypev', null, ArrayHelper::map($types, 'id', 'typev'), [
                    'id' => 'idtypev',
                    'class' => 'form-input',
                    'prompt' => 'Choisir...',
                    'required' => true
            ]) ?>
        </div>

        <div class="form-group">
            <label for="places" class="form-label">Places dispo</label>
            <div class="stepper-input">
                <?= Html::input('number', 'places', 1, [
                        'id' => 'places',
                        'class' => 'form-input',
                        'min' => 1,
                        'max' => 8,
                        'required' => true
                ]) ?>
            </div>
        </div>

        <div class="form-group">
            <label for="bagages" class="form-label">Bagages autorisés</label>
            <?= Html::input('number', 'bagages', 0, [
                    'id' => 'bagages',
                    'class' => 'form-input',
                    'min' => 0,
                    'max' => 3,
                    'required' => true
            ]) ?>
        </div>

        <div class="form-group full-width">
            <label for="contraintes" class="form-label">Contraintes</label>
            <?= Html::textarea('contraintes', '', [
                    'id' => 'contraintes',
                    'class' => 'form-input contraintes',
                    'rows' => 2,
                    'maxlength' => 500
            ]) ?>
        </div>

        <div class="form-group full-width">
            <button type="submit" class="auth-submit">Publier le voyage</button>
        </div>
    </form>
</section>