<?php

namespace common\models;
use yii\db\ActiveRecord;

class User1 extends ActiveRecord implements \yii\web\IdentityInterface
{



    public static function tableName()
    {
        return 'user'; // TODO: Change the autogenerated stub
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        //return static::findOne(['access_token' => $token]);
    }


    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
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
        return null;
    }


    public function validatePassword($password)
    {
        if ($password == $this->password){
            return true;
        } else {
            return false;
        }
    }


    public function getRole()
    {
        return $this->hasOne(Roles::className(), ['id' => 'role_id']);
    }


}