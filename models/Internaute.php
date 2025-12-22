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

    public static function getUserById($id) {
        return self::findOne(['id' => $id]);
    }

    public static function estConducteur($pseudo) {
        return !(self::getUserByIdentifiant($pseudo)->permis == NULL);
    }

    public static function isConducteur($id) {
        return !(self::getUserById($id)->permis == NULL);
    }





    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    public function validatePassword($password)
    {
        return sha1($password) === $this->pass;
    }

    public function getNomFormat() {
        $initialeNom = strtoupper(substr($this->nom, 0, 1));

        return "{$this->prenom} {$initialeNom}.";
    }

    public function getNombrePlacesReserveesByVoyageId($voyageId) {
        $nombrePlaces = 0;
        $reservations = Reservation::getReservationsByVoyageId($voyageId);
        foreach ($reservations as $reservation) {
            if ($reservation->voyageur === $this->id) {
                $nombrePlaces += $reservation->nbplaceresa;
            }
        }
    }


}