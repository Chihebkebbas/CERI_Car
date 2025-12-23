<?php

namespace app\models;

use yii\db\ActiveRecord;

class TypeVehicule extends ActiveRecord
{
    public static function tableName()
    {
        return 'fredouil.typevehicule';
    }

    public static function getAllTypes() {
        return self::find()->all();
    }

}