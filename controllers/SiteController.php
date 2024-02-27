<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Portfolio;
use app\models\User;
use yii\helpers\Json;

class SiteController extends Controller
{
    public $layout;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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
        $this->layout = "index";
        return $this->render('index');
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionAdmin()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect('/site/login');
        }
        return $this->render('admin');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionTabsData($id)
    {
        if ($id == 1) {
            $portfolio = Portfolio::find()->where(['web' => 1])->orderBy(['prioritet' => SORT_ASC])->all();
        } elseif ($id == 2) {
            $portfolio = Portfolio::find()->where(['mobile' => 1])->orderBy(['prioritet' => SORT_ASC])->all();
        } else {
            $portfolio = Portfolio::find()->all();
        }
        $html = $this->renderPartial('tabContent', ['items' => $portfolio]);
        return Json::encode($html);
    }

    public static function pushNotification($token, $params)
    {
        //$fcm_server_key = Yii::$app->params['firebaseServerKey'];
        $fcm_server_key = 'AAAAgt2-ZUI:APA91bEIdTfeUOA4Ga9NOZ2DGxiFNf1uZfLBWqAZbgLY90UJZUjPLneX96HJBRX2DykR12wcIfp6ZJ7e3rkvCiiO6hArtL6IVFJGIRgHpa0VYGmsy-A8wCETH5qM2PDfs7S8fgzzZfrC';

        $data = ["click_action" => "FLUTTER_NOTIFICATION_CLICK"];
        if (!empty($params['params'])) {
            $data = array_merge($data, $params['params']);
        }
        $fields = [
            'notification'     => ['body' => $params['body'], 'title' => $params['title'], 'sound' => 'default', 'android_channel_id' => 'horsechannel'],
            'priority' => 'high',
            'data' => $data,
            'to' => $token
        ];

        $headers = ['Authorization: key=' . $fcm_server_key, 'Content-Type: application/json'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        var_dump($result);
        //{"multicast_id":6871200661950690246,"success":1,"failure":0,"canonical_ids":0,"results":[{"message_id":"0:1704789063156133%3150c44c3150c44c"}]}
        //{"multicast_id":2844040801835453767,"success":0,"failure":1,"canonical_ids":0,"results":[{"error":"NotRegistered"}]}
    }

    public function actionRun()
    {

        echo 'yoba';
        exit();
        $params = [
            'title' => 'My title 16:17',
            'body' => 'Hey there show me',
            'params' => [
                'test_id' => 123,
            ],
        ];
        //$token = 'cXBC0x7FR8S1E8SPNC0XM0:APA91bFtTt8Z31sQpWpU7aXi5uhcMoHqAOlgWJpzB-ZD1KpK-MbrihojXXzsLsdDma4-ngOCBe1yFMf9fWPZ16AFdUAY9WtA_rWzTyP7GBg4KGmwZJU7JMRtmgvOwSXqwLk8Aept0Agi';
        $token = 'cjjql9FT4kY3uOVp1DQUM0:APA91bG7DE9DTo3Qpmhx8ei2ggzQ1BcrjkaqC7Gdj9M2YppxR0qb1R-Ba1w2yUnLzfLnbJu_sV2y-uU1gTLfnva-6pRxDjwjyXRSC7kzTFXdtZBOXFbx3UQcD9M49kQGHPlwTvoud7Ma';
        self::pushNotification($token, $params);
        exit();
    }
}
