<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\components\AccessRule;
use yii\web\Controller;
use yii\web\Response;
use app\models\User;
use app\models\Workhour;
use app\models\YgBoard;
use app\models\YgColumn;
use app\models\YgProject;
use app\models\YgTask;
use yii\helpers\Json;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\httpclient\Client;

class AdminController extends Controller
{
    public $layout = 'clean';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
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
                            //User::ROLE_USER,
                            //User::ROLE_MODERATOR,
                            User::ROLE_ADMIN
                        ],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Finds the Address model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Address the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function syncUsers()
    {
        $client = new Client();
        $response = $client
            ->createRequest()
            ->setMethod('GET')->setHeaders(['Authorization' => 'Bearer ' . YgProject::$dartlabKey])
            ->setUrl(YgProject::$ygurl . '/users')
            //->setData($request)
            ->send();
        $data = $response->data;
        if (!empty($data['content'])) {
            foreach ($data['content'] as $user) {
                $model = User::findOne(['yougile_id' => $user['id']]);
                if (!$model) {
                    $model = User::findOne(['email' => $user['email']]);
                    if ($model) {
                        $model->yougile_id = $user['id'];
                    }
                }
                if (!$model) {
                    $model = new User();
                    $model->yougile_id = $user['id'];
                    $em = explode('@', $user['email']);
                    $model->username = $em[0];
                    $model->password = $em[0];
                }
                $model->name = $user['realName'];
                $model->email = $user['email'];
                $model->yougile_last_active = substr($user['lastActivity'], 0, 10);
                $model->yougile_status = $user['status'];
                $model->save();
            }
        }
    }

    protected function syncProjects()
    {
        YgProject::fetchAll();
    }
    protected function syncBoards()
    {
        YgBoard::fetchAll();
    }
    protected function syncColumns()
    {
        YgColumn::fetchAll();
    }
    protected function syncTasks()
    {
        YgTask::fetchAll();
    }
    protected function calcHours()
    {
        Workhour::calcHours();
    }

    public function actionRun()
    {
        //$this->syncUsers();
        //$this->syncProjects();
        //$this->syncBoards();
        //$this->syncColumns();
        //$this->syncTasks();
        $this->calcHours();
        exit();
    }
}
