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
                    [
                        'actions' => ['hook', 'hooks'],
                        'allow' => true,
                        'roles' => ['?'],
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
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (in_array($action->id, ['hook', 'hooks'])) {
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

    /*
         {
            "event":"task-created",
            "payload":{
                "title":"Testing webhook",
                "timestamp":1709016804701,
                "columnId":"3a750b0a-8b05-4903-ac9e-74a34079748e",
                "archived":false,
                "completed":false,
                "createdBy":"76071d35-e01d-4e11-95db-9cfed9a186c7",
                "id":"08997e29-cd01-432d-b09e-19512d662d10",
                "parents":[]
            },
            "fromUserId":"76071d35-e01d-4e11-95db-9cfed9a186c7"
        }
        {
            "event":"task-updated",
            "payload":{
                "title":"Testing webhook",
                "timestamp":1709016804701,
                "columnId":"3a750b0a-8b05-4903-ac9e-74a34079748e",
                "archived":false,
                "completed":false,
                "createdBy":"76071d35-e01d-4e11-95db-9cfed9a186c7",
                "timeTracking":{"plan":0,"work":0},
                "id":"08997e29-cd01-432d-b09e-19512d662d10",
                "parents":[]
            },
            "fromUserId":"76071d35-e01d-4e11-95db-9cfed9a186c7"
        }
        {
            "event":"task-updated",
            "payload":{
                "title":"Testing webhook",
                "timestamp":1709016804701,
                "columnId":"3a750b0a-8b05-4903-ac9e-74a34079748e",
                "archived":false,
                "completed":false,
                "createdBy":"76071d35-e01d-4e11-95db-9cfed9a186c7",
                "timeTracking":{"plan":3,"work":0},
                "id":"08997e29-cd01-432d-b09e-19512d662d10","parents":[]
            },
            "fromUserId":"76071d35-e01d-4e11-95db-9cfed9a186c7"
        }
        {"event":"task-moved","payload":{"title":"Testing webhook","timestamp":1709016804701,"columnId":"787c50f1-f630-4f70-9a10-f5d9d72a5dd6","archived":false,"completed":false,"createdBy":"76071d35-e01d-4e11-95db-9cfed9a186c7","timeTracking":{"plan":3,"work":0},"id":"08997e29-cd01-432d-b09e-19512d662d10","parents":[]},"fromUserId":"76071d35-e01d-4e11-95db-9cfed9a186c7"}
        {"event":"task-updated","payload":{"title":"Testing webhook","timestamp":1709016804701,"columnId":"787c50f1-f630-4f70-9a10-f5d9d72a5dd6","archived":false,"completed":true,"completedTimestamp":1709017307456,"assigned":"76071d35-e01d-4e11-95db-9cfed9a186c7","createdBy":"76071d35-e01d-4e11-95db-9cfed9a186c7","timeTracking":{"plan":3,"work":2},"id":"08997e29-cd01-432d-b09e-19512d662d10","parents":[]},"fromUserId":"76071d35-e01d-4e11-95db-9cfed9a186c7"}

        {"event":"task-deleted","payload":{"title":"Testing webhook___deleted","timestamp":1709016804701,"columnId":"787c50f1-f630-4f70-9a10-f5d9d72a5dd6","archived":false,"completed":true,"completedTimestamp":1709017307456,"assigned":"76071d35-e01d-4e11-95db-9cfed9a186c7","createdBy":"76071d35-e01d-4e11-95db-9cfed9a186c7","timeTracking":{"plan":3,"work":2},"id":"08997e29-cd01-432d-b09e-19512d662d10","deleted":true,"parents":[]},"fromUserId":"76071d35-e01d-4e11-95db-9cfed9a186c7"}
        {"event":"task-renamed","payload":{"title":"Testing webhook___deleted","timestamp":1709016804701,"columnId":"787c50f1-f630-4f70-9a10-f5d9d72a5dd6","archived":false,"completed":true,"completedTimestamp":1709017307456,"assigned":"76071d35-e01d-4e11-95db-9cfed9a186c7","createdBy":"76071d35-e01d-4e11-95db-9cfed9a186c7","timeTracking":{"plan":3,"work":2},"id":"08997e29-cd01-432d-b09e-19512d662d10","deleted":true,"parents":[]},"fromUserId":"76071d35-e01d-4e11-95db-9cfed9a186c7"}
        
        {"event":"task-updated","payload":{"title":"Another test","timestamp":1709017337708,"columnId":"3a750b0a-8b05-4903-ac9e-74a34079748e","archived":false,"completed":false,"subtasks":["f690d214-1f86-43c8-9ca9-fcae42d7472f","84317954-70ea-4c55-a3f1-61deeaf62919"],"createdBy":"76071d35-e01d-4e11-95db-9cfed9a186c7","id":"0ad8e3be-8ea9-4e25-a202-50409a4d3c3a","parents":[]},"fromUserId":"76071d35-e01d-4e11-95db-9cfed9a186c7"}
        {
            "event":"task-created",
            "payload":{
                "title":"Another subtask",
                "timestamp":1709024348239,
                "archived":false,
                "completed":false,
                "createdBy":"76071d35-e01d-4e11-95db-9cfed9a186c7",
                "id":"84317954-70ea-4c55-a3f1-61deeaf62919",
                "parents":["0ad8e3be-8ea9-4e25-a202-50409a4d3c3a"]
            },
            "fromUserId":"76071d35-e01d-4e11-95db-9cfed9a186c7"
        }
         */
    public function actionHook()
    {
        $post = Yii::$app->request->post();
        if ($post) {
            $json = Json::encode($post);
            $dao = Yii::$app->db;
            $dao->createCommand()->insert('page', ['title' => 'webhook', 'content' => $json, 'code' => time()])->execute();
            if (isset($post['event'])) {
                if ($post['event'] == 'task-created') {
                    //do not create task if it has parents, it will be created by parent
                    if (empty($post['payload']['parents'])) {
                        YgTask::upsertTask($post['payload']);
                    }
                } else if ($post['event'] == 'task-updated') {
                    YgTask::upsertTask($post['payload']);
                }
            }
        }
    }

    //just for testing from postman
    public function actionHooks()
    {
        $post = Yii::$app->request->post();
        if ($post) {
            //$json = Json::encode($post);
            $dao = Yii::$app->db;
            //$dao->createCommand()->insert('page', ['title' => 'webhook', 'content' => $json, 'code' => time()])->execute();
            if (isset($post['event'])) {
                if ($post['event'] == 'task-created') {
                    //do not create task if it has parents, it will be created by parent
                    if (empty($post['event']['payload']['parents'])) {
                        YgTask::upsertTask($post['payload']);
                    }
                } else if ($post['event'] == 'task-updated') {
                    //$dao->createCommand()->insert('page', ['title' => 'webhook upd', 'content' => Json::encode($post['payload']), 'code' => time()])->execute();
                    YgTask::upsertTask($post['payload']);
                }
            }
        }
    }

    public function actionRun()
    {
        //$this->syncUsers();
        //$this->syncProjects();
        //$this->syncBoards();
        //$this->syncColumns();
        //$this->syncTasks();
        //$this->calcHours();
        exit();
    }
}
