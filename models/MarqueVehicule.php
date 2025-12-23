<?php

namespace app\models;

use yii\db\ActiveRecord;

class MarqueVehicule extends ActiveRecord
{
    public static function tableName()
    {
        return 'fredouil.marquevehicule';
    }
    
    public static function getAllMarques() {
        return self::find()->all();
    }

}