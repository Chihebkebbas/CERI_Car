<?php

namespace app\models;

use yii\db\ActiveRecord;

class Trajet extends ActiveRecord
{
    public static function tableName()
    {
        return 'fredouil.trajet';
    }

    public function getTrajet($depart, $arrivee) {
        return $this->findOne(['depart' => $depart, 'arrivee' => $arrivee]);
    }
}