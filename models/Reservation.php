<?php

namespace app\models;

use yii\db\ActiveRecord;

class Reservation extends ActiveRecord
{
    public static function tableName() {
        return 'fredouil.reservation';
    }

    public function getVoyageurs() {
        return $this->hasMany(Internaute::class , ['id' => 'voyageur']);
    }

    public function getInfoVoyage() {
        return $this->hasOne(Voyage::class , ['id' => 'voyage']);
    }

    public static function getReservationsByVoyageId($voyageId) {
        return self::findAll(['voyage' => $voyageId]);
    }

    public static function getReservationsByInternauteId($internauteId) {
        return self::findAll(['voyageur' => $internauteId]);
    }

}