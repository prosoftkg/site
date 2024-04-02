<?php

namespace app\controllers;

use Yii;
use app\models\Page;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;

/**
 * YgController implements the CRUD actions for Page model.
 */
class YgController extends Controller
{
    public $layout = 'clean';

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'ruleConfig' => [
                        'class' => AccessRule::class,
                    ],
                    //'only' => ['logout'],
                    'rules' => [
                        [
                            //'actions' => ['logout'],
                            'allow' => true,
                            'roles' => [
                                User::ROLE_USER,
                                User::ROLE_MODERATOR,
                                User::ROLE_ADMIN
                            ],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Page models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $today = date('Y-m-d');
        $dao = Yii::$app->db;
        $users = $dao->createCommand("SELECT * FROM `user`")->queryAll();
        $hours = $dao->createCommand("SELECT * FROM `workhour`")->queryAll();
        //$hours = $dao->createCommand("SELECT * FROM `workhour` WHERE workday='{$today}'")->queryAll();
        //$rows = $dao->createCommand("SELECT * FROM `workhour` LEFT JOIN `user` ON workhour.user_id=user.id WHERE workday='{$today}'")->queryAll();
        return $this->render('index', ['users' => $users, 'hours' => $hours]);
    }

    public function actionView()
    {
        return $this->render('view', []);
    }
}
