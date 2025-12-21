<?php
?>

<div class="content-container no-summary">
        <aside class="filters-sidebar">
            <div class="filter-card">
                <h3>Afficher</h3>
                <div class="filter-options">
                    <label class="radio-option"><input type="radio" name="filter" checked> <span>Tous</span></label>
                </div>
            </div>
        </aside>

        <section class="results-section">
            <h2 class="results-count"><?=count($reservations) ?> réservations à venir</h2>

            <div class="results-scroll-container">

                <?php foreach ($reservations as $reservation): ?>

                    <article class="trip-card">
                        <div class="trip-main">
                            <div class="trip-overview reservation" >
                                <div class="trip-schedule">
                                    <div class="reservation-date">Demain, 12 Oct</div>

                                    <div class="time-row"><span class="time"><?=$reservation->infoVoyage->heureDepartFormat ?></span> <span class="place"><?=$reservation->infoVoyage->infoTrajet->depart ?></span></div>
                                    <div class="duration-visual">
                                        <div class="line"></div>
                                        <span class="duration"><?=$reservation->infoVoyage->dureeTrajet . " (" . $reservation->infoVoyage->infoTrajet->distance . "Km)" ?></span>
                                        <div class="line"></div>
                                    </div>
                                    <div class="time-row"><span class="time"><?=$reservation->infoVoyage->heureArrivee ?></span> <span class="place"><?=$reservation->infoVoyage->infoTrajet->arrivee ?></span></div>
                                </div>
                                <div class="trip-meta-visible">
                                    <div class="driver-basic">
                                        <img src="<?=$reservation->infoVoyage->photoConducteur ?>" class="driver-avatar" alt="conducteur avatar">
                                        <span class="name"><?=$reservation->infoVoyage->nomFormat ?></span>
                                    </div>


                                    <div class="reservation-info">
                                        <span class="status-badge status-confirmed">Confirmé</span>
                                        <div class="price-block">
                                            <span class="price"><?=$reservation->infoVoyage->getPriceFormat($reservation->nbplaceresa) ?></span>
                                            <span class="seats-left"><?=$reservation->nbplaceresa === 1 ? $reservation->nbplaceresa . " place réservée" : $reservation->nbplaceresa . " places réservées" ?></span>
                                        </div>
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
                                        <div><span class="model"><?=$reservation->infoVoyage->marqueVehicule->marquev ?></span><span class="type-tag"><?=$reservation->infoVoyage->typeVehicule->typev ?></span></div>
                                    </div>
                                </div>
                                <div class="detail-column">
                                    <h4>Infos</h4>
                                    <div class="badges-list">
                                        <span class="badge"><span class="material-symbols-rounded">luggage</span> <?=$reservation->infoVoyage->nbbagage === 1 ? $reservation->infoVoyage->nbbagage . " Bagage" : $reservation->infoVoyage->nbbagage . " Bagages" ?></span>
                                        <span class="badge"><span class="material-symbols-rounded">notification_audio</span><?=$reservation->infoVoyage->contraintes == '' ? 'Pas de contraintes !' : $reservation->infoVoyage->contraintes ?></span>
                                    </div>
                                </div>
                                <div class="action-area">
                                    <button class="btn-cancel">Annuler la réservation</button>
                                </div>
                            </div>
                        </div>
                    </article>

                <?php endforeach ?>


            </div>
        </section>
    </div>