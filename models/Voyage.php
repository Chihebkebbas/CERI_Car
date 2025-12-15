<?php

namespace app\models;

use yii\db\ActiveRecord;

class Voyage extends ActiveRecord
{
    public static function tableName()
    {
        return 'fredouil.voyage';
    }

    public function getInfoConducteur()
    {
        return $this->hasOne(Internaute::class , ['id' => 'conducteur']);
    }

    public function getInfoTrajet() {
        return $this->hasOne(Trajet::class , ['id' => 'trajet']);
    }

    public function getMarqueVehicule() {
        return $this->hasOne(MarqueVehicule::class , ['id' => 'idmarquev']);
    }

    public function getTypeVehicule() {
        return $this->hasOne(TypeVehicule::class , ['id' => 'idtypev']);
    }


    public function getDureeTrajet()
    {
        $minutes = (int) $this->infoTrajet->distance; // durée en minutes
        $heures = intdiv($minutes, 60);               // nombre d'heures
        $minutesRestantes = $minutes % 60;           // minutes restantes
        return sprintf("%2dh%02dmin", $heures, $minutesRestantes);
    }

    public function getHeureArrivee()
    {
        $depart = strtotime($this->heuredepart . ":00");

        $duration = $this->infoTrajet->distance;
        return date("H:i", strtotime("+$duration minutes", $depart));
    }

    public function getHeureDepartFormat()
    {
        return sprintf("%02d:00", $this->heuredepart);
    }

    public function getNomFormat()
    {
        // Récupérer la première lettre du nom et la mettre en majuscule
        $initialeNom = strtoupper(substr($this->infoConducteur->nom, 0, 1));

        return "{$this->infoConducteur->prenom} {$initialeNom}.";
    }

    public function getPhotoConducteur() {
        $url = $this->infoConducteur->photo;
        return $url == null ? "https://www.gravatar.com/avatar/?d=mp&f=y" : $url;
    }

    public function getPlacesRestantes() {
        return $this->nbplacedispo - Reservation::getNombrePlacesReservee($this->id);
    }




    public static function getVoyagesByTrajetId($trajetId) {
        return self::findAll(['trajet' => $trajetId]);
    }

    public static function getVoyagesByConducteurID($conducteurId) {
        return self::findAll(['conducteur' => $conducteurId]);
    }


}