<?php
/**
 * @author Ruslan Fadeev
 * created: 17.02.2015 23:17
 */
/** @var \app\models\User $user */
echo \yii\helpers\Url::to(['site/auth', 'auth_key' => $user->auth_key], true);