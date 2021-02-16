<?php
namespace frontend\models;
use yii\base\Model;
 
class SignupForm extends Model{

    public $username;
    public $password;

       

    public function rules() {
        return [
            [['username', 'password'], 'required', 'message' => 'Обязательное поле'],
            ['username', 'unique', 'targetClass' => User::className(),  'message' => 'Этот логин уже занят'],
        ];
    }
}