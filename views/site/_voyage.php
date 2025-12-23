<?php

?>
<div class="content-container no-summary">

    <aside class="filters-sidebar">
        <div class="filter-card">
            <h3>Trier par</h3>
            <div class="filter-options">
                <label class="radio-option">
                    <input type="radio" name="sort" checked> <span>Date (Prochain)</span>
                </label>
                <label class="radio-option">
                    <input type="radio" name="sort"> <span>Remplissage</span>
                </label>
            </div>
            <div class="divider"></div>
            <h3>Filtres</h3>
            <div class="filter-options">
                <label class="checkbox-option">
                    <input type="checkbox" checked> <span>À venir</span>
                </label>
                <label class="checkbox-option">
                    <input type="checkbox"> <span>Historique</span>
                </label>
            </div>
        </div>
    </aside>

    <section class="results-section">
        <h2 class="results-count"><span id="nombre_trajets"><?=count($voyages) ?></span> trajets disponibles</h2>

        <div class="results-scroll-container">

            <?php foreach ($voyages as $voyage): ?>

                <article class="trip-card">
                    <div class="trip-main">
                        <div class="trip-overview">
                            <div class="trip-schedule">
                                <div class="time-row"><span class="time"><?=$voyage->heureDepartFormat ?></span> <span class="place"><?=$voyage->infoTrajet->depart ?></span></div>
                                <div class="duration-visual">
                                    <div class="line"></div>
                                    <span class="duration"><?=$voyage->dureeTrajet . " (" . $voyage->infoTrajet->distance . ")"?></span>
                                    <div class="line"></div>
                                </div>
                                <div class="time-row"><span class="time"><?=$voyage->heureArrivee ?></span> <span class="place"><?=$voyage->infoTrajet->arrivee ?></span></div>
                            </div>

                            <div class="trip-meta-visible">
                                <div class="occupancy-badge <?=$voyage->estComplet() ? "full" : ""?>">
                                    <span class="material-symbols-rounded icon"><?=$voyage->estComplet() ? "check_circle" : "group"?></span>
                                    <span><?=$voyage->estComplet() ?"Complet(" . $voyage->nbplacedispo . "/" . $voyage->nbplacedispo . ")" : $voyage->placesReservees. "/" . $voyage->nbplacedispo . " Réservé"?></span>
                                </div>
                                <div class="earnings-display">
                                    <span class="label">Gain</span>
                                    <span class="amount">+ <?=$voyage->getPriceFormat($voyage->placesReservees) ?> €</span>
                                </div>
                            </div>
                        </div>
                        <div class="expand-indicator"><span class="material-symbols-rounded chevron">expand_more</span></div>
                    </div>

                    <div class="trip-details-expanded">
                        <div class="expanded-content-column">
                            <h4 class="list-title">Passagers confirmés (<?=count($voyage->voyageurs) ?>)</h4>



                                <div class="passenger-list">
                                    <?php foreach ($voyage->voyageurs as $voyageur):?>
                                        <div class="passenger-item">
                                            <div class="passenger-left">
                                                <img src="<?=$voyageur->photo ?>" class="avatar-medium">
                                                <div class="passenger-data">
                                                    <span class="name"><?=$voyageur->nomFormat ?></span>
                                                    <span class="details"><?=$voyageur->getNombrePlacesReserveesByVoyageId($voyage->id)?></span>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endforeach; ?>

                            </div>

                            <div class="trip-actions-footer">
                                <button class="btn-text-danger">Annuler ce voyage</button>
                            </div>
                        </div>
                    </div>
                </article>

            <?php endforeach; ?>

        </div>
    </section>
</div>
