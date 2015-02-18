<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $email;
    public $rememberMe;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User'],
            ['rememberMe', 'boolean']
        ];
    }
}
