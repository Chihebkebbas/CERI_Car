<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Modèle Voyage représentant une annonce de covoiturage.
 * 
 * @property int $id Identifiant unique du voyage.
 * @property int $conducteur ID de l'internaute conducteur.
 * @property int $trajet ID du trajet associé.
 * @property int $heuredepart Heure de départ (0-23).
 * @property float $tarif Tarif par kilomètre.
 * @property int $nbplacedispo Nombre total de places proposées.
 * @property int $nbbagage Nombre de bagages autorisés.
 * @property string|null $contraintes Contraintes particulières du voyage.
 * @property int $idtypev ID du type de véhicule.
 * @property int $idmarquev ID de la marque du véhicule.
 */
class Voyage extends ActiveRecord
{
    /**
     * @return string Nom de la table associée.
     */
    public static function tableName()
    {
        return 'fredouil.voyage';
    }

    /**
     * Relation vers le conducteur du voyage.
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getInfoConducteur()
    {
        return $this->hasOne(Internaute::class , ['id' => 'conducteur']);
    }

    /**
     * Relation vers le trajet associé au voyage.
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getInfoTrajet() {
        return $this->hasOne(Trajet::class , ['id' => 'trajet']);
    }

    /**
     * Relation vers la marque du véhicule utilisé.
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getMarqueVehicule() {
        return $this->hasOne(MarqueVehicule::class , ['id' => 'idmarquev']);
    }

    /**
     * Relation vers le type de véhicule utilisé.
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getTypeVehicule() {
        return $this->hasOne(TypeVehicule::class , ['id' => 'idtypev']);
    }


    /**
     * Calcule la durée du trajet au format "XhYYmin".
     * 
     * @return string
     */
    public function getDureeTrajet()
    {
        $minutes = (int) $this->infoTrajet->distance; // durée en minutes
        $heures = intdiv($minutes, 60);               // nombre d'heures
        $minutesRestantes = $minutes % 60;           // minutes restantes
        return sprintf("%2dh%02dmin", $heures, $minutesRestantes);
    }

    /**
     * Formate une distance (en minutes) au format "XhYYmin".
     * 
     * @param int $distance Distance en minutes.
     * @return string
     */
    public static function getDureeTrajetFormat($distance) {
        $minutes = $distance;
        $heures = intdiv($minutes, 60);
        $minutesRestantes = $minutes % 60;
        return sprintf("%2dh%02dmin", $heures, $minutesRestantes);
    }



    /**
     * Calcule l'heure d'arrivée prévue.
     * 
     * @return string Heure au format "H:i".
     */
    public function getHeureArrivee()
    {
        $depart = strtotime($this->heuredepart . ":00");

        $duration = $this->infoTrajet->distance;
        return date("H:i", strtotime("+$duration minutes", $depart));
    }

    /**
     * Retourne l'heure de départ formatée "HH:00".
     * 
     * @return string
     */
    public function getHeureDepartFormat()
    {
        return sprintf("%02d:00", $this->heuredepart);
    }

    /**
     * Retourne le nom du conducteur formaté : "Prénom I."
     * 
     * @return string
     */
    public function getNomFormat()
    {
        // Récupérer la première lettre du nom et la mettre en majuscule
        $initialeNom = strtoupper(substr($this->infoConducteur->nom, 0, 1));

        return "{$this->infoConducteur->prenom} {$initialeNom}.";
    }

    /**
     * Retourne l'URL de la photo du conducteur ou un avatar par défaut.
     * 
     * @return string
     */
    public function getPhotoConducteur() {
        $url = $this->infoConducteur->photo;
        return $url == null ? "https://www.gravatar.com/avatar/?d=mp&f=y" : $url;
    }

    /**
     * Calcule le nombre de places restantes dans le voyage.
     * 
     * @return int
     */
    public function getPlacesRestantes() {
        return $this->nbplacedispo - $this->placesReservees;
    }

    /**
     * Calcule le prix total pour un nombre de places donné.
     * 
     * @param int $places Nombre de places.
     * @return string Prix formaté.
     */
    public function getPriceFormat($places) {
        return number_format($this->tarif * $places * $this->infoTrajet->distance, 2, '.', '');
    }

    /**
     * Récupère le nombre de places déjà réservées pour ce voyage.
     * 
     * @return int
     */
    public function getPlacesReservees() {
        return Reservation::getNombrePlacesReservee($this->id);
    }

    /**
     * Recherche un voyage par son ID.
     * 
     * @param int $id
     * @return Voyage|null
     */
    public static function getVoyageById($id) {
        return self::findOne(['id' => $id]);
    }

    /**
     * Récupère tous les voyages associés à un trajet spécifique.
     * 
     * @param int $trajetId
     * @return Voyage[]
     */
    public static function getVoyagesByTrajetId($trajetId) {
        return self::findAll(['trajet' => $trajetId]);
    }

    /**
     * Récupère tous les voyages proposés par un conducteur spécifique.
     * 
     * @param int $conducteurId
     * @return Voyage[]
     */
    public static function getVoyagesByConducteurID($conducteurId) {
        return self::findAll(['conducteur' => $conducteurId]);
    }


    /**
     * Récupère la liste des voyageurs ayant réservé ce voyage.
     * 
     * @return Internaute[]
     */
    public function getVoyageurs() {
        $voyageurs = [];
        $reservations = Reservation::getReservationsByVoyageId($this->id);

        foreach ($reservations as $reservation) {
            $voyageurs[] = Internaute::getUserById($reservation->voyageur);
        }
        return $voyageurs;
    }

    /**
     * Vérifie si le voyage est complet.
     * 
     * @return bool
     */
    public function estComplet() {
        return $this->placesRestantes === 0;
    }


}