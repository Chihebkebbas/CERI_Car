<?php

namespace app\models;

use yii\db\ActiveRecord;

class Reservation extends ActiveRecord
{
    public static function tableName() {
        return 'fredouil.reservation';
    }

    public function getVoyageurs() {
        return $this->hasMany(Internaute::class , ['voyageur' => 'id']);
    }

    public function getVoyage() {
        return $this->hasOne(Internaute::class , ['voyage' => 'id']);
    }

    public function getReservationsByVoyageId($voyageId) {
        return $this->findAll(['voyage' => $voyageId]);
    }

}