<?php

namespace app\models;

use Yii;
use yii\httpclient\Client;

/**
 * This is the model class for table "yg_project".
 *
 * @property int $id
 * @property int|null $yg_id
 * @property string|null $title
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class YgProject extends YgModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yg_project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['yg_id'], 'string', 'max' => 50],
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
            'yg_id' => 'Yg ID',
            'title' => 'Title',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function fetchAll()
    {
        $client = new Client();
        $response = $client
            ->createRequest()
            ->setMethod('GET')->setHeaders(['Authorization' => 'Bearer ' . YgModel::$dartlabKey])
            ->setUrl(YgModel::$ygurl . '/projects')
            //->setData($request)
            ->send();
        $data = $response->data;
        if (!empty($data['content'])) {
            foreach ($data['content'] as $row) {
                $model = YgProject::findOne(['yg_id' => $row['id']]);
                if (!$model) {
                    $model = new YgProject();
                    $model->yg_id = $row['id'];
                }
                $model->title = $row['title'];
                $model->save();
            }
        }
    }

    /**
     * Gets query for [[YgBoard]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBoards()
    {
        return $this->hasMany(YgBoard::class, ['project_id' => 'id']);
    }
}
