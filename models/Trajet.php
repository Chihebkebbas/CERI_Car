<?php

namespace app\models;

use yii\db\ActiveRecord;

class Trajet extends ActiveRecord
{
    public static function tableName()
    {
        return 'fredouil.trajet';
    }

    public static function getTrajet($depart, $arrivee) {
        return self::findOne(['depart' => $depart, 'arrivee' => $arrivee]);
    }
}