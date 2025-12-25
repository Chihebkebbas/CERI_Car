<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Modèle Trajet représentant une liaison entre deux villes.
 * 
 * @property int $id Identifiant unique du trajet.
 * @property string $depart Ville de départ.
 * @property string $arrivee Ville d'arrivée.
 * @property int $distance Distance ou durée en minutes entre les deux villes.
 */
class Trajet extends ActiveRecord
{
    /**
     * @return string Nom de la table associée.
     */
    public static function tableName()
    {
        return 'fredouil.trajet';
    }

    /**
     * Recherche un trajet par ville de départ et d'arrivée.
     * 
     * @param string $depart
     * @param string $arrivee
     * @return Trajet|null
     */
    public static function getTrajet($depart, $arrivee) {
        return self::findOne(['depart' => $depart, 'arrivee' => $arrivee]);
    }

    /**
     * Récupère tous les trajets partant d'une ville donnée.
     * 
     * @param string $depart
     * @return Trajet[]
     */
    public static function getAllTrajets($depart) {
        return self::findAll(['depart' => $depart]);
    }
}