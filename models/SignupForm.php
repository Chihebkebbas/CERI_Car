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
            ['nom', 'string', 'max' => 45],
            ['prenom', 'string', 'max' => 45],

            // 3. Email valide
            ['email', 'email', 'message' => 'Veuillez saisir une adresse email valide.'],
            ['email', 'string', 'max' => 45],

            // 4. Pseudo unique
            ['pseudo', 'unique', 'targetClass' => '\app\models\Internaute', 'message' => 'Ce pseudo est déjà pris.'],
            ['pseudo','string', 'max' => 45],

            // 5. Permis : Doit être exactement 12 chiffres
            ['permis', 'match', 'pattern' => '/^[0-9]{12}$/', 'message' => 'Le numéro de permis doit comporter exactement 12 chiffres.'],
            ['permis', 'default', 'value' => null],

            // 6. Mot de passe (Sécurisé)
            ['password', 'string', 'min' => 8, 'max' => 45,  'message' => 'Le mot de passe doit faire au moins 8 caractères.'],

            // 7. Photo
            ['photo', 'string', 'max' => 200],
        ];
    }

    public function signup() {
        if (!$this->validate()) {
            return null;
        }

        $user = new Internaute();
        $user->nom = $this->nom;
        $user->prenom = $this->prenom;
        $user->mail = $this->email;
        $user->pseudo = $this->pseudo;
        $user->pass = sha1($this->password);
        $user->photo = !empty($this->photo) ?  $this->photo : "https://img.icons8.com/ios-filled/50/user.png";
        $user->permis = !empty($this->permis) ? $this->permis : null;

        return $user->save() ? $user : null;
    }
}
