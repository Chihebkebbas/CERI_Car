<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Internaute extends ActiveRecord implements IdentityInterface
{

    public static function tableName()
    {
        return 'fredouil.internaute';
    }

    public static function getUserByIdentifiant($pseudo) {
        return self::findOne(['pseudo' => $pseudo]);
    }

    public static function estConducteur($pseudo) {
        return !(self::getUserByIdentifiant($pseudo)->permis == NULL);
    }


    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        // TODO: Implement getId() method.
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}