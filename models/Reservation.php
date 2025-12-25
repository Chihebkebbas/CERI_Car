<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Modèle Reservation représentant une réservation effectuée par un internaute pour un voyage.
 * 
 * @property int $id Identifiant unique de la réservation.
 * @property int $voyage ID du voyage réservé.
 * @property int $voyageur ID de l'internaute ayant effectué la réservation.
 * @property int $nbplaceresa Nombre de places réservées.
 */
class Reservation extends ActiveRecord
{
    /**
     * @return string Nom de la table associée.
     */
    public static function tableName() {
        return 'fredouil.reservation';
    }

    /**
     * Relation vers les voyageurs (utilisateurs) associés à cette réservation.
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getVoyageurs() {
        return $this->hasMany(Internaute::class , ['id' => 'voyageur']);
    }

    /**
     * Relation vers le voyage concerné par la réservation.
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getInfoVoyage() {
        return $this->hasOne(Voyage::class , ['id' => 'voyage']);
    }



    /**
     * Recherche une réservation par son ID.
     * 
     * @param int $id
     * @return Reservation|null
     */
    public static function getReservationById($id) {
        return self::findOne(['id' => $id]);
    }

    /**
     * Récupère toutes les réservations effectuées par un internaute spécifique.
     * 
     * @param int $internauteId
     * @return Reservation[]
     */
    public static function getReservationsByInternauteId($internauteId) {
        return self::findAll(['voyageur' => $internauteId]);
    }

    /**
     * Récupère toutes les réservations associées à un voyage spécifique.
     * 
     * @param int $voyageId
     * @return Reservation[]
     */
    public static function getReservationsByVoyageId($voyageId) {
        return self::findAll(['voyage' => $voyageId]);
    }

    /**
     * Méthode placeholder (non implémentée).
     * 
     * @param int $voyageurId
     * @param int $reservationId
     */
    public static function getNombrePlacesReserveePourUnVoyageurID($voyageurId, $reservationId) {
        $reservation = self::getReservationById($reservationId);

    }

    /**
     * Calcule le nombre total de places réservées pour un voyage donné.
     * 
     * @param int $voyageId
     * @return int Nombre de places réservées.
     */
    public static function getNombrePlacesReservee($voyageId) {
        $nbPlacesReservee = 0;
        $reservations = self::getReservationsByVoyageId($voyageId);
        foreach ($reservations as $reservation) {
            $nbPlacesReservee += $reservation->nbplaceresa;
        }
        return $nbPlacesReservee;
    }


}