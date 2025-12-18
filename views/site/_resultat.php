<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Résultats de vote recherche';

?>


    <section class="search-summary">
        <div class="summary-content">
            <div class="route-info">
                <span class="city"><?=$depart ?></span>
                <span class="material-symbols-rounded arrow">arrow_forward</span>
                <span class="city"><?=$arrivee ?></span>
            </div>
            <div class="meta-info">
                <p class="passenger-count"><?=$places?> passager</p>
            </div>
            <a class="btn-modify">Modifier</a>
        </div>
    </section>

    <div class="content-container">

        <aside class="filters-sidebar">
            <div class="filter-card">
                <h3>Trier par</h3>
                <div class="filter-options">
                    <label class="radio-option"><input type="radio" name="sort" checked> <span>Prix le plus bas</span></label>
                    <label class="radio-option"><input type="radio" name="sort"> <span>Départ le plus tôt</span></label>
                </div>
                <div class="divider"></div>
                <h3>Options</h3>
                <div class="filter-options">
                    <label class="checkbox-option"><input type="checkbox"> <span>Trajets directs</span></label>
                    <label class="checkbox-option"><input type="checkbox"> <span>Bagages supplémentaires</span></label>
                </div>
            </div>
        </aside>

        <section class="results-section">
            <h2 class="results-count"><span id="nombre_trajets"><?=count($voyages) ?></span> voyages disponibles</h2>

            <div class="results-scroll-container">

                <?php foreach ($voyages as $voyage): ?>

                    <article class="trip-card <?=$voyage->placesRestantes < $places ? "full-trip" : "" ?>" >
                        <div class="trip-main">
                            <div class="trip-overview">
                                <div class="trip-schedule">
                                    <div class="time-row"><span class="time"><?=$voyage->heureDepartFormat ?></span><span class="place"><?=$depart ?></span></div>
                                    <div class="duration-visual">
                                        <div class="line"></div>
                                        <span class="duration"><?=$voyage->dureeTrajet ?><span> (<?=$voyage->infoTrajet->distance ?>km)</span></span>
                                        <div class="line"></div>
                                    </div>
                                    <div class="time-row"><span class="time"><?=$voyage->heureArrivee ?></span><span class="place"><?=$arrivee ?></span></div>
                                </div>
                                <div class="trip-meta-visible">
                                    <div class="driver-basic">
                                        <img src= <?=$voyage->photoConducteur ?> class="driver-avatar" alt="conducteur avatar">
                                        <span class="name"><?=$voyage->nomFormat ?></span>
                                    </div>
                                    <div class="price-block">
                                        <span class="price"><?= number_format($voyage->tarif * $places * $voyage->infoTrajet->distance, 2, '.', '') ?> €</span>
                                        <?= $voyage->placesRestantes < $places
                                                ? '<span class="seats-left alert-complet">COMPLET</span>'
                                                : '<span class="seats-left">' .
                                                $voyage->placesRestantes . ' ' .
                                                ($voyage->placesRestantes == 1 ? 'Place' : 'Places') .
                                                '</span>'
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="expand-indicator"><span class="material-symbols-rounded chevron">expand_more</span></div>
                        </div>
                        <div class="trip-details-expanded">
                            <div class="expanded-content">
                                <div class="detail-column">
                                    <h4>Véhicule</h4>
                                    <div class="vehicle-full">
                                        <span class="material-symbols-rounded icon">directions_car</span>
                                        <div><span class="model"><?=$voyage->marqueVehicule->marquev ?></span><span class="type-tag"><?=$voyage->typeVehicule->typev ?></span></div>
                                    </div>
                                </div>
                                <div class="detail-column">
                                    <h4>Infos</h4>
                                    <div class="badges-list">
                                        <span class="badge"><span class="material-symbols-rounded">luggage</span> <?=$voyage->nbbagage ?> </span>
                                        <span class="badge"><span class="material-symbols-rounded">notification_audio</span><?=$voyage->contraintes == '' ? 'Pas de contraintes !' : $voyage->contraintes ?></span>
                                    </div>
                                </div>
                                <div class="action-area">
                                    <button class="btn-book">Réserver</button>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>



            </div> </section>
    </div>

