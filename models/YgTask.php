<?php

namespace app\models;

use Yii;
use yii\httpclient\Client;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "yg_task".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int|null $column_id
 * @property string|null $yg_id
 * @property string|null $yg_column_id
 * @property string|null $title
 * @property string|null $description
 * @property int|null $archived
 * @property int|null $completed
 * @property int|null $completed_at
 * @property float|null $time_plan
 * @property float|null $time_work
 * @property int|null $deadline
 * @property int|null $created_by
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class YgTask extends YgModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yg_task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'column_id', 'archived', 'completed', 'completed_at', 'deadline', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['time_plan', 'time_work'], 'number'],
            [['yg_id', 'yg_column_id'], 'string', 'max' => 50],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'column_id' => 'Column ID',
            'yg_id' => 'Yg ID',
            'yg_column_id' => 'Yg Column ID',
            'title' => 'Title',
            'description' => 'Description',
            'archived' => 'Archived',
            'completed' => 'Completed',
            'completed_at' => 'Completed At',
            'time_plan' => 'Time Plan',
            'time_work' => 'Time Work',
            'deadline' => 'Deadline',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    public static function fetchAll()
    {
        $rows = self::getDbColumns();
        foreach ($rows as $row) {
            self::fetchTask($row['id'], $row['yg_id']);
        }
        //self::fetchTask(187, '787c50f1-f630-4f70-9a10-f5d9d72a5dd6');
    }

    public static function fetchTask($column_id, $yg_column_id)
    {
        $client = new Client();
        $response = $client
            ->createRequest()
            ->setMethod('GET')->setHeaders(['Authorization' => 'Bearer ' . YgModel::$dartlabKey])
            ->setUrl(YgModel::$ygurl . '/tasks')
            ->setData(['columnId' => $yg_column_id])
            ->send();
        $data = $response->data;
        if (!empty($data['content'])) {
            foreach ($data['content'] as $row) {
                $model = YgTask::findOne(['yg_id' => $row['id']]);
                if (!$model) {
                    $model = new YgTask();
                    $model->yg_id = $row['id'];
                    $model->created_at = substr($row['timestamp'], 0, 10);
                }
                $model->title = StringHelper::truncate($row['title'], 250);
                $model->archived = $row['archived'] ? 1 : 0;
                $model->completed = $row['completed'] ? 1 : 0;
                if (isset($row['completedTimestamp'])) {
                    $model->completed_at = substr($row['completedTimestamp'], 0, 10);
                }
                if (isset($row['description'])) {
                    $model->description = $row['description'];
                }
                if (isset($row['timeTracking'])) {
                    $model->time_plan = $row['timeTracking']['plan'];
                    $model->time_work = $row['timeTracking']['work'];
                }
                if (isset($row['deadline'])) {
                    $model->deadline = substr($row['deadline']['deadline'], 0, 10);
                }
                $model->created_by = self::getUserId($row['createdBy']);
                $model->column_id = $column_id;
                $model->yg_column_id = $yg_column_id;
                if ($model->save()) {
                    if (isset($row['subtasks'])) {
                        foreach ($row['subtasks'] as $yg_task_id) {
                            self::addSubtask($model, $yg_task_id);
                        }
                    }

                    if (isset($row['assigned'])) {
                        if (is_array($row['assigned'])) {
                            foreach ($row['assigned'] as $assigned) {
                                self::assignUserToTask($model->id, $assigned);
                            }
                        } else {
                            self::assignUserToTask($model->id, $row['assigned']);
                        }
                    }
                } else {
                    var_dump($model->getErrors());
                }
            }
        }
    }

    protected static function getDbColumns()
    {
        $dao = Yii::$app->db;
        return $dao->createCommand("SELECT * FROM `yg_column`")->queryAll();
    }

    protected static function getUserId($yougile_id)
    {
        $model = User::findOne(['yougile_id' => $yougile_id]);
        if ($model) {
            return $model->id;
        }
        return 0;
    }

    protected static function addSubtask($task, $yg_task_id)
    {
        $client = new Client();
        $response = $client
            ->createRequest()
            ->setMethod('GET')->setHeaders(['Authorization' => 'Bearer ' . YgModel::$dartlabKey])
            ->setUrl(YgModel::$ygurl . '/tasks/' . $yg_task_id)
            ->send();
        $row = $response->data;
        if (!empty($row) && !empty($row['id'])) {
            $model = YgTask::findOne(['yg_id' => $row['id']]);
            if (!$model) {
                $model = new YgTask();
                $model->yg_id = $row['id'];
                $model->created_at = substr($row['timestamp'], 0, 10);
                $model->parent_id = $task->id;
            }
            $model->title = StringHelper::truncate($row['title'], 250);
            $model->archived = $row['archived'] ? 1 : 0;
            $model->completed = $row['completed'] ? 1 : 0;
            if (isset($row['completedTimestamp'])) {
                $model->completed_at = substr($row['completedTimestamp'], 0, 10);
            }
            if (isset($row['description'])) {
                $model->description = $row['description'];
            }
            if (isset($row['timeTracking'])) {
                $model->time_plan = $row['timeTracking']['plan'];
                $model->time_work = $row['timeTracking']['work'];
            }
            if (isset($row['deadline'])) {
                $model->deadline = substr($row['deadline']['deadline'], 0, 10);
            }
            //$model->created_by=getUserId($row['createdBy']);
            if ($model->save()) {
                if (isset($row['subtasks'])) {
                    foreach ($row['subtasks'] as $yg_task_id) {
                        self::addSubtask($model, $yg_task_id);
                    }
                }
                if (isset($row['assigned'])) {
                    if (is_array($row['assigned'])) {
                        foreach ($row['assigned'] as $assigned) {
                            self::assignUserToTask($model->id, $assigned);
                        }
                    } else {
                        self::assignUserToTask($model->id, $row['assigned']);
                    }
                }
            }
        }
    }

    protected static function assignUserToTask($task_id, $yg_user_id)
    {
        $dao = Yii::$app->db;
        $user_id = self::getUserId($yg_user_id);
        if ($user_id) {
            $row = $dao->createCommand("SELECT id FROM `yg_task_user` WHERE user_id={$user_id} AND task_id={$task_id}")->queryOne();
            if (!$row) {
                $dao->createCommand()->insert('yg_task_user', ['user_id' => $user_id, 'task_id' => $task_id])->execute();
            }
        }
    }

    /**
     * Gets query for [[YgColumn]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getColumn()
    {
        return $this->hasOne(YgColumn::class, ['id' => 'column_id']);
    }
}
