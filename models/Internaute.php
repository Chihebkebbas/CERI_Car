<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Modèle Internaute représentant un utilisateur du système CeriCar.
 * Implémente IdentityInterface pour la gestion de l'authentification.
 * 
 * @property int $id Identifiant unique de l'internaute.
 * @property string $nom Nom de l'internaute.
 * @property string $prenom Prénom de l'internaute.
 * @property string $pseudo Pseudo utilisé pour la connexion.
 * @property string $pass Mot de passe (haché en SHA1).
 * @property string|null $mail Adresse e-mail.
 * @property string|null $photo URL ou chemin vers la photo de profil.
 * @property string|null $permis Numéro de permis (12 chiffres) si conducteur.
 */
class Internaute extends ActiveRecord implements IdentityInterface
{
    /**
     * @return string Nom de la table associée.
     */
    public static function tableName()
    {
        return 'fredouil.internaute';
    }

    /**
     * Recherche un utilisateur par son pseudo.
     * 
     * @param string $pseudo
     * @return Internaute|null
     */
    public static function getUserByIdentifiant($pseudo) {
        return self::findOne(['pseudo' => $pseudo]);
    }

    /**
     * Recherche un utilisateur par son ID.
     * 
     * @param int $id
     * @return Internaute|null
     */
    public static function getUserById($id) {
        return self::findOne(['id' => $id]);
    }

    /**
     * Vérifie si l'utilisateur identifié par son pseudo est un conducteur.
     * 
     * @param string $pseudo
     * @return bool True si conducteur, false sinon.
     */
    public static function estConducteur($pseudo) {
        return !(self::getUserByIdentifiant($pseudo)->permis == NULL);
    }

    /**
     * Vérifie si l'utilisateur identifié par son ID est un conducteur.
     * 
     * @param int $id
     * @return bool True si conducteur, false sinon.
     */
    public static function isConducteur($id) {
        return !(self::getUserById($id)->permis == NULL);
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * @return int ID de l'utilisateur.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }

    /**
     * Valide le mot de passe fourni.
     * 
     * @param string $password Mot de passe à vérifier.
     * @return bool True si le mot de passe correspond.
     */
    public function validatePassword($password)
    {
        return sha1($password) === $this->pass;
    }

    /**
     * Retourne le nom formaté : "Prénom I."
     * 
     * @return string
     */
    public function getNomFormat() {
        $initialeNom = strtoupper(substr($this->nom, 0, 1));

        return "{$this->prenom} {$initialeNom}.";
    }

    /**
     * Récupère le nombre de places réservées par cet internaute pour un voyage spécifique.
     * 
     * @param int $voyageId
     * @return int Nombre de places.
     */
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