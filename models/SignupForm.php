<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model {
    public $nom;
    public $prenom;
    public $pseudo;
    public $email;
    public $password;
    public $permis;
    public $photo;

    public function rules() {
        return [
            // 1. Nettoyage des espaces (Trim) par défaut
            [['nom', 'prenom', 'pseudo', 'email', 'permis'], 'trim'],

            // 2. Champs requis
            [['nom', 'prenom', 'pseudo', 'email', 'password'], 'required', 'message' => 'Ce champ est requis.'],

            // 3. Email valide
            ['email', 'email', 'message' => 'Veuillez saisir une adresse email valide.'],

            // 4. Pseudo unique
            ['pseudo', 'unique', 'targetClass' => '\app\models\Internaute', 'message' => 'Ce pseudo est déjà pris.'],

            // 5. Permis : Doit être exactement 12 chiffres
            ['permis', 'match', 'pattern' => '/^[0-9]{12}$/', 'message' => 'Le numéro de permis doit comporter exactement 12 chiffres.'],

            // 6. Mot de passe (Sécurisé)
            ['password', 'string', 'min' => 8, 'message' => 'Le mot de passe doit faire au moins 8 caractères.'],

            // 7. Photo
            ['photo', 'string', 'max' => 255],
        ];
    }

    public function signup() {
        if (!this.validate()) {
            return null;
        }

        $user = new Internaute();
        $user->nom = $this->nom;
        $user->prenom = $this->prenom;
        $user->mail = $this->mail;
        $user->pseudo = $this->pseudo;
        $user->pass = Yii::$app->security->generatePasswordHash($this->password);
        $user->photo = $this->photo;
        $user->permis = $this->permis;

        return $user->save() ? $user : null;
    }
}
