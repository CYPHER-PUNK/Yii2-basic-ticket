<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $email
 * @property string $auth_key
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    #public $rememberMe;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $this->sendLinkToLogin();
        }
        return parent::afterSave($insert, $changedAttributes);
    }

    public function afterFind()
    {
        $this->sendLinkToLogin();
        return parent::afterFind();
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'auth_key'], 'string', 'max' => 255],
            [['email'], 'unique'],
            #[['rememberMe'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'email'    => 'Email',
            'auth_key' => 'Auth Key'
        ];
    }

    public function sendLinkToLogin()
    {
        $mailer = \Yii::$app->mail;
        $mailer->compose('@app/mail/loginLink', ['user' => $this])
            ->setFrom(['mail@' . Yii::$app->request->serverName => ' Tickets'])
            ->setTo($this->email)
            ->setSubject('Link to login')
            ->send();
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|User the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]); // наше приложение гораздо легче чем требования интерфейса
        #return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
