<?php
use yii\helpers\Url;

?>

<section class="auth-card wide">
    <div class="auth-header">
        <h1 class="auth-title">Proposer un voyage</h1>
        <p class="auth-subtitle">Partagez vos frais et rencontrez de nouvelles personnes.</p>
    </div>

    <form id="create-trip-form" class="auth-form two-columns" action="<?= Url::to(['site/create']) ?>" method="POST">
        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />

        <div class="form-group">
            <label for="depart" class="form-label">Ville de départ</label>
            <div class="input-with-icon">
                <input type="text" id="depart" name="depart" class="form-input" placeholder="Ex: Avignon" required>
            </div>
        </div>

        <div class="form-group">
            <label for="arrivee" class="form-label">Ville d'arrivée</label>
            <input type="text" id="arrivee" name="arrivee" class="form-input" placeholder="Ex: Paris" required>
        </div>

        <div class="form-group">
            <label for="heure" class="form-label">Heure de départ</label>
            <input type="time" id="heure" name="heure" class="form-input" required step="3600">
        </div>

        <div class="form-group">
            <label for="tarif" class="form-label">Prix (€) (Max 5€)</label>
            <input type="number" id="tarif" name="tarif" class="form-input" placeholder="Ex: 4" min="0" max="5" step="0.5" required>
        </div>

        <div class="form-group">
            <label for="idmarquev" class="form-label">Marque Véhicule</label>
            <select id="idmarquev" name="idmarquev" class="form-input" required>
                <option value="" disabled selected>Choisir...</option>
                <?php foreach ($marques as $marque): ?>
                    <option value="<?= $marque->id ?>"><?= $marque->marquev ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="idtypev" class="form-label">Type Véhicule</label>
            <select id="idtypev" name="idtypev" class="form-input" required>
                <option value="" disabled selected>Choisir...</option>
                <?php foreach ($types as $type): ?>
                    <option value="<?= $type->id ?>"><?= $type->typev ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="places" class="form-label">Places dispo</label>
            <div class="stepper-input">
                <input type="number" id="places" name="places" class="form-input" value="1" min="1" max="8" required>
            </div>
        </div>

        <div class="form-group">
            <label for="bagages" class="form-label">Bagages autorisés</label>
            <input type="number" id="bagages" name="bagages" class="form-input" value="0" min="0" max="3" required>
        </div>

        <div class="form-group full-width">
            <label for="contraintes" class="form-label">Contraintes</label>
            <textarea id="contraintes" name="contraintes" class="form-input contraintes" rows="2" maxlength="500"></textarea>
        </div>

        <div class="form-group full-width">
            <button type="submit" class="auth-submit">Publier le voyage</button>
        </div>
    </form>
</section>