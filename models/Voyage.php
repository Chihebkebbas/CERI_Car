<?php

namespace app\models;

use yii\db\ActiveRecord;

class Voyage extends ActiveRecord
{
    public static function tableName()
    {
        return 'fredouil.voyage';
    }

    public function getConducteur()
    {
        return $this->hasOne(Internaute::class , ['id' => 'conducteur']);
    }

    public function getTrajet() {
        return $this->hasOne(Trajet::class , ['id' => 'trajet']);
    }

    public function getMarqueVehicule() {
        return $this->hasOne(MarqueVehicule::class , ['id' => 'idmarquev']);
    }

    public function getTypeVehicule() {
        return $this->hasOne(TypeVehicule::class , ['id' => 'idtypev']);
    }

    public static function getVoyagesByTrajetId($trajetId) {
        return self::findAll(['trajet' => $trajetId]);
    }

    public static function getVoyagesByConducteurID($conducteurId) {
        return self::findAll(['conducteur' => $conducteurId]);
    }


}