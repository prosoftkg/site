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
use app\models\YgTask;

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
        $d = Yii::$app->request->get('d');
        //$today = date('Y-m-d');
        $thisweekstr = strtotime('monday this week');
        $thisweek = date('Y-m-d', $thisweekstr);
        //$twoweeks = date('Y-m-d', strtotime('-14 days', $thisweekstr));
        //$prevmonth = date('Y-m-d', strtotime('first day of last month'));
        $thismonth = date('Y-m-01');

        $from = $thisweek;
        $to = date('Y-m-d');

        if ($d == 'pw') {
            $from = date('Y-m-d', strtotime('monday previous week'));
            $to = date('Y-m-d', strtotime('friday previous week'));
        }
        if ($d == 'tm') {
            $from = $thismonth;
        }

        $dao = Yii::$app->db;
        $users = $dao->createCommand("SELECT * FROM `user`")->queryAll();
        $hours = $dao->createCommand("SELECT * FROM `workhour` WHERE workday >= '{$from}' AND workday<='{$to}' ORDER BY workday ASC")->queryAll();
        //$hours = $dao->createCommand("SELECT * FROM `workhour` WHERE workday='{$today}'")->queryAll();
        //$rows = $dao->createCommand("SELECT * FROM `workhour` LEFT JOIN `user` ON workhour.user_id=user.id WHERE workday='{$today}'")->queryAll();
        $tasks = YgTask::find()->where(['completed' => 0])->andWhere(['not', ['column_id' => null]])->all();
        return $this->render('index', ['users' => $users, 'hours' => $hours, 'tasks' => $tasks]);
    }

    public function actionView()
    {
        return $this->render('view', []);
    }
    public function actionYoba()
    {
        $tasks = YgTask::find()->where(['completed' => 0])->andWhere(['not', ['column_id' => null]])->all();
        return $this->render('index1', ['tasks' => $tasks]);
    }
}
