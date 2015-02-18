<?php

namespace app\controllers;

use app\models;
use app\models\LoginForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout', 'settings'],
                'rules' => [
                    [
                        'actions' => ['logout', 'settings'],
                        'allow'   => true,
                        'roles'   => ['@']
                    ]
                ]
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post']
                ]
            ]
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            /*'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],*/
        ];
    }

    public function actionSettings()
    {
        $user = User::findIdentity(Yii::$app->user->identity->getId());
        if ($user->load(Yii::$app->request->post())) {
            Yii::$app->session->setFlash('success', 'Saved');
            $user->update();
        }
        return $this->render('settings', ['model' => $user]);
    }

    public function actionAuth($auth_key)
    {
        if ($user = User::findIdentityByAccessToken($auth_key)) {
            if (Yii::$app->user->login($user)) {
                $this->redirect(['settings']);
            }
        }
        $this->goHome();
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $loginForm = new LoginForm();
        if ($loginForm->load(Yii::$app->request->post())) {
            if ($loginForm->validate()) {
                $user = new User();
                $user->email = $loginForm->email;
                if ($user->save()) {
                    return $this->render('successful', ['user' => $user]);
                }
            } else {
                if ($user = User::findOne(['email' => $loginForm->email])) {
                    return $this->render('successful', ['user' => $user]);
                }
            }
        }
        return $this->render('login', ['model' => $loginForm]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
