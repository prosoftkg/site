<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\User;
use yii\helpers\Json;

class AdminController extends Controller
{
    public $layout;

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if ($action->id == 'tabs-data') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect('/site/login');
        }
        return $this->render('index');
    }

    public function actionUsers()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect('/site/login');
        }
        return $this->render('users');
    }

    public function actionRun()
    {
        return 'test';
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@prosoft.kg';
        $user->password_hash = Yii::$app->getSecurity()->generatePasswordHash('admin');
        $user->save();


        exit();
        /*  $params = [
            'title' => 'My title 11:44',
            'body' => 'Hey there show me',
            'params' => [
                'test_id' => 123,
            ],
        ];
        $token = 'cXBC0x7FR8S1E8SPNC0XM0:APA91bFtTt8Z31sQpWpU7aXi5uhcMoHqAOlgWJpzB-ZD1KpK-MbrihojXXzsLsdDma4-ngOCBe1yFMf9fWPZ16AFdUAY9WtA_rWzTyP7GBg4KGmwZJU7JMRtmgvOwSXqwLk8Aept0Agi';
        self::pushNotification($token, $params);
        exit(); */
    }
}
