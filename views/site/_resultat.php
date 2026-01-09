<?php

use yii\helpers\Url;

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
            <a class="btn-modify js-modify-link" href="<?=Url::to(['site/index']) ?>">Modifier</a>
        </div>
    </section>

    <div class="content-container">

        <aside class="filters-sidebar">
            <div class="filter-card">
                <h3>Afficher</h3>
                <div class="filter-options">
                    <label class="radio-option"><input type="radio" name="filter" checked> <span>Tous</span></label>
                </div>
            </div>
        </aside>

        <section class="results-section">
            <h2 class="results-count"><span id="nombre_trajets"><?=count($voyages) + count($correspondance) ?></span> voyages disponibles</h2>

            <div class="results-scroll-container">

                <?php foreach ($voyages as $voyage): ?>

                    <article class="trip-card <?=$voyage->placesRestantes < $places ? "full-trip" : "" ?>" >
                        <div class="trip-main" >
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
                                        <img src="<?=$voyage->photoConducteur ?>" class="driver-avatar" alt="conducteur avatar">
                                        <span class="name"><?=$voyage->nomFormat ?></span>
                                    </div>
                                    <div class="price-block">
                                        <span class="price"><?= $voyage->getPriceFormat($places) ?> €</span>
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
                                    <button class="btn-book btn-book-ajax" data-id="<?= $voyage->id ?>" data-places="<?=$places ?>" >Réserver</button>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>

                <?php foreach ($correspondance as $c): ?>
                    <?php
                        $voyage1 = $c['voyage1'];
                        $voyage2 = $c['voyage2'];
                    ?>
                    <article class="trip-card <?=$c['placesRestantes'] < $places ? "full-trip" : "" ?>">
                        <div class="trip-main">
                            <div class="trip-overview">
                                <div class="trip-schedule">
                                    <div class="time-row"><span class="time"><?=$voyage1->heureDepartFormat ?></span> <span class="place"><?=$depart ?></span></div>
                                    <div class="duration-visual">
                                        <div class="line"></div>
                                        <span class="duration"><?=$c['distance']?><span> (<?=$voyage1->infoTrajet->distance + $voyage2->infoTrajet->distance?>km)</span></span>
                                        <div class="line"></div>
                                    </div>
                                    <div class="time-row"><span class="time"><?=$voyage2->heureArrivee ?></span> <span class="place"><?=$arrivee ?></span></div>
                                </div>
                                <div class="trip-meta-visible">
                                    <div class="escale">
                                        <div class="driver-basic">
                                            <div class="driver-stack">
                                                <img src="<?=$voyage1->photoConducteur ?>" class="driver-avatar" alt="conducteur avatar">
                                                <img src="<?=$voyage2->photoConducteur ?>" class="driver-avatar" alt="conducteur avatar">
                                            </div>
                                            <span class="name"><?=$voyage1->nomFormat . " & " . $voyage2->nomFormat ?></span>
                                        </div>
                                        <div class="escale-badge">
                                            <span class="material-symbols-rounded">transfer_within_a_station</span>
                                            <span>Escale à <?=$c['ville'] ?></span>
                                        </div>
                                    </div>
                                    <div class="price-block">
                                        <span class="price"><?= $c['price'] ?> €</span>
                                        <span class="seats-left">
                                            <?= $c['placesRestantes'] < $places
                                                    ? '<span class="seats-left alert-complet">COMPLET</span>'
                                                    : '<span class="seats-left">' .
                                                    $c['placesRestantes'] . ' ' .
                                                    ($c['placesRestantes'] === 1 ? 'Place' : 'Places') .
                                                    '</span>'
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="expand-indicator"><span class="material-symbols-rounded chevron">expand_more</span></div>
                        </div>
                        <div class="trip-details-expanded">
                            <div class="expanded-content">
                                <div class="escale-voiture">
                                    <div class="detail-column">
                                        <h4>Véhicules</h4>
                                        <div class="vehicle-full">
                                            <span class="material-symbols-rounded icon">directions_car</span>
                                            <div><span class="model"><?=$voyage1->marqueVehicule->marquev ?></span><span class="type-tag"><?=$voyage1->typeVehicule->typev ?></span></div>
                                        </div>
                                        <div class="vehicle-full second-vehicule">
                                            <span class="material-symbols-rounded icon">directions_car</span>
                                            <div><span class="model"><?=$voyage2->marqueVehicule->marquev ?></span><span class="type-tag"><?=$voyage2->typeVehicule->typev ?></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="correspondence-timeline detail-column">
                                    <h4>Trajets</h4>
                                    <div class="segment">
                                        <div class="segment-time"><?=$voyage1->heureDepartFormat . " - " . $voyage1->heureArrivee ?></div>
                                        <div class="segment-route"><?=$voyage1->infoTrajet->depart . " → " . $voyage1->infoTrajet->arrivee ?></div>
                                    </div>
                                    <div class="layover"><span class="material-symbols-rounded">hourglass_empty</span> Escale <?=$c['marge'] ?></div>
                                    <div class="segment">
                                        <div class="segment-time"><?=$voyage2->heureDepartFormat . " - " . $voyage2->heureArrivee ?></div>
                                        <div class="segment-route"><?=$voyage2->infoTrajet->depart . " → " . $voyage2->infoTrajet->arrivee ?></div>
                                    </div>
                                </div>
                                <div class="detail-column">
                                    <h4>Infos</h4>
                                    <div class="badges-list">
                                        <span class="badge"><span class="material-symbols-rounded">luggage</span>  <?=$c['bagages'] ?> Bagages</span>
                                        <span class="badge"><span class="material-symbols-rounded">notification_audio</span> <?=$voyage1->contraintes . ", " . $voyage2->contraintes ?></span>
                                    </div>
                                </div>
                                <div class="action-area">
                                    <button class="btn-book full-width btn-book-ajax" data-id1="<?= $voyage1->id ?>" data-id2="<?= $voyage2->id ?>" data-places="<?=$places ?>">Réserver</button>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>



            </div> </section>
    </div>

