<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model {
    public $pseudo;
    public $password;

    private $_user = false;

    public function rules() {
        return [
            [ ['pseudo', 'password'], 'trim'],
            [['pseudo', 'password'], 'required', 'message' => 'Ce champ est requis.'],
            ['pseudo','string', 'max' => 45],
            ['password','string', 'max' => 45],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Pseudo ou mot de passe incorrect.');
            }
        }
    }

    public function login() {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), 3600*24*7);
        }
    }

    public function getUser() {
        if ($this->_user === false) {
            $this->_user = Internaute::getUserByIdentifiant($this->pseudo);
        }
        return $this->_user;
    }

}