<?php

namespace app\controllers;

use Yii;
use app\models\Inquiry;
use app\models\InquirySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\httpclient\Client;

/**
 * InquiryController implements the CRUD actions for Inquiry model.
 */
class InquiryController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
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
     * Lists all Inquiry models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new InquirySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Inquiry model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Inquiry model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Inquiry();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $info = [];

                if ($model->price_range) {
                    $post = explode(',', $model->price_range);
                    //$info['price_min'] = $post[0];
                    //$info['price_max'] = $post[1];
                    $info[] = 'price_min: ' . $post[0];
                    $info[] = 'price_max: ' . $post[1];
                }

                if ($model->type) {
                    foreach ($model->type as $type) {
                        $types[] = Inquiry::typeList()[$type];
                    };
                    //$info['type'] = implode(', ', $types);
                    $info[] = 'type: ' . implode(', ', $types);
                }

                if ($model->design_need) {
                    $list = Inquiry::designNeedList();
                    //$info['design_need'] = $list[$model->design_need];
                    $info[] = 'design_need: ' . $list[$model->design_need];
                }

                if ($model->industry) {
                    $list = Inquiry::industryList();
                    //$info['industry'] = $list[$model->industry];
                    $info[] = 'industry: ' . $list[$model->industry];
                }
                if ($model->industry_custom) {
                    //$info['industry_custom'] = $model->industry_custom;
                    $info[] = 'industry_custom: ' . $model->industry_custom;
                }
                if ($info) {
                    //$model->info = json_encode($info, JSON_UNESCAPED_UNICODE);
                    $model->info = implode('<br />', $info);
                }

                Yii::$app->response->format = Response::FORMAT_JSON;
                if ($model->save()) {
                    //$model->email(Yii::$app->params['adminEmail'], $model->name, $model->phone);
                    self::saveYougile($model->id, $model->fullname . ' ' . $model->phone, $model->info . '<br />comment: ' . $model->message);
                    return "Заказ звонка принят! Мы свяжемся с вами в ближайшее время!";
                } else {
                    //$model->validate();
                    return $model->errors;
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    static function saveYougile($id, $title, $desc)
    {
        $request = [
            'title' => $title,
            'description' => $desc,
            'columnId' => '9df7847f-5d46-4764-9d61-00c712cf501b',
            'assigned' => ['76071d35-e01d-4e11-95db-9cfed9a186c7']
        ];

        $client = new Client();
        $response = $client
            ->createRequest()
            ->setMethod('POST')
            ->setUrl('https://yougile.com/api-v2/tasks')
            ->setHeaders(['content-type' => 'application/json'])
            ->addHeaders(['authorization' => 'Bearer AftoMTJhmiYXDzSrYkzdoOkUfu46fQJd9IOY5ghZ-K5RRZFMpIlVxwc8IPgIluf3'])
            ->setData($request)
            ->send();

        $dao = Yii::$app->db;
        $dao->createCommand()->update('inquiry', ['yougile_id' => $response->data['id']], ['id' => $id])->execute();
    }

    /**
     * Updates an existing Inquiry model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Inquiry model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Inquiry model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Inquiry the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inquiry::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    static function yougiles()
    {

        /* {"event":"task-moved",
            "payload":
            {
                "id":"00043c65-02f5-4c63-9ebb-150d47bc6e01",
                "title":"task added by Postman",
                "columnId":"190dea20-9b1e-4516-b1da-0b0073cf02ec",
                "completed":false,
                "archived":false,
                "createdBy":"76071d35-e01d-4e11-95db-9cfed9a186c7",
                "assigned":["76071d35-e01d-4e11-95db-9cfed9a186c7"],
                "timestamp":1698652295065,"parents":[]
            },
            "fromUserId":"76071d35-e01d-4e11-95db-9cfed9a186c7"} */

        /*"{\"event\":\"task-moved\",\"payload\":{\"id\":\"a2f3aed6-fbc4-430b-9079-dd850665d071\",\"title\":\"test\",\"columnId\":\"9df7847f-5d46-4764-9d61-00c712cf501b\",\"completed\":false,\"archived\":false,\"createdBy\":\"76071d35-e01d-4e11-95db-9cfed9a186c7\",\"timestamp\":1698746220096,\"parents\":[]},\"fromUserId\":\"76071d35-e01d-4e11-95db-9cfed9a186c7\"}"*/
        /*"{\
            "event\":\"task-updated\",
            \"payload\":{
                \"id\":\"9deeacde-c520-4eb0-9bf0-8a4ec1fa0a80\",
                \"title\":\"task added by Postman\",
                \"columnId\":\"55972025-7573-46a9-8b2e-08046b5d99c4\",
                \"completed\":true,
                \"completedTimestamp\":1698753622699,
                \"archived\":false,
                \"createdBy\":\"76071d35-e01d-4e11-95db-9cfed9a186c7\",
                \"subtasks\":[],
                \"assigned\":[\"76071d35-e01d-4e11-95db-9cfed9a186c7\"],
                \"timestamp\":1698652295065,
                \"parents\":[]
            },
            \"fromUserId\":\"76071d35-e01d-4e11-95db-9cfed9a186c7\
            "}"*/
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if ($action->id == 'yougile') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionYougile()
    {
        $dao = Yii::$app->db;
        $post = Yii::$app->request->post();
        if ($post) {
            //$post = json_encode($post);

            $dao->createCommand()->insert('inquiry', ['fullname' => 'post id', 'phone' => '0553000665', 'info' => $post['payload']['id']])->execute();
        }
        exit;
    }
}
