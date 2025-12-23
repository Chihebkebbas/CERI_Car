<section class="auth-card wide"> <div class="auth-header">
        <h1 class="auth-title">Proposer un voyage</h1>
        <p class="auth-subtitle">Partagez vos frais et rencontrez de nouvelles personnes.</p>
    </div>

    <form class="auth-form two-columns" action="#" method="POST">

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
            <input type="time" id="heure" name="heure" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="tarif" class="form-label">Prix par passager (€)</label>
            <input type="number" id="tarif" name="tarif" class="form-input" placeholder="Ex: 25" min="0" step="0.5" required>
        </div>

        <div class="form-group">
            <label for="places" class="form-label">Places disponibles</label>
            <div class="stepper-input">
                <input type="number" id="places" name="places" class="form-input" value="3" min="1" max="8" required>
            </div>
        </div>

        <div class="form-group">
            <label for="bagages" class="form-label">Bagages autorisés / pers.</label>
            <input type="number" id="bagages" name="bagages" class="form-input" value="1" min="0" max="3" required>
        </div>

        <div class="form-group full-width">
            <label for="contraintes" class="form-label">Contraintes & Infos voyageur</label>
            <textarea id="contraintes" name="contraintes" class="form-input contraintes" rows="3" placeholder="Ex: Pas de fumeurs, petits animaux acceptés en cage, musique calme..."></textarea>
            <p class="form-hint voyage">
                Soyez précis pour éviter les malentendus avec vos passagers.
            </p>
        </div>

        <div class="form-group full-width">
            <button type="submit" class="auth-submit">Publier le voyage</button>
        </div>

    </form>
</section>
