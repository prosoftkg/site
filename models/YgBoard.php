<?php

namespace app\models;

use Yii;
use yii\httpclient\Client;


/**
 * This is the model class for table "yg_board".
 *
 * @property int $id
 * @property int|null $project_id
 * @property string|null $yg_id
 * @property string|null $yg_project_id
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class YgBoard extends YgModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yg_board';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'created_at', 'updated_at'], 'integer'],
            [['yg_id', 'yg_project_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'yg_id' => 'Yg ID',
            'yg_project_id' => 'Yg Project ID',
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
            ->setUrl(YgModel::$ygurl . '/boards')
            //->setData(['projectId' => 1])
            ->send();
        $data = $response->data;
        if (!empty($data['content'])) {
            foreach ($data['content'] as $row) {
                $project = self::getDbProject($row['projectId']);
                if ($project) {
                    $model = YgBoard::findOne(['yg_id' => $row['id']]);
                    if (!$model) {
                        $model = new YgBoard();
                        $model->yg_id = $row['id'];
                    }
                    $model->project_id = $project['id'];
                    $model->yg_project_id = $project['yg_id'];
                    $model->save();
                }
            }
        }
    }

    protected static function getDbProject($yg_project_id)
    {
        $dao = Yii::$app->db;
        return $dao->createCommand("SELECT * FROM `yg_project` WHERE yg_id='{$yg_project_id}'")->queryOne();
    }

    /**
     * Gets query for [[YgColumn]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getColumns()
    {
        return $this->hasMany(YgColumn::class, ['board_id' => 'id']);
    }

    /**
     * Gets query for [[YgProject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(YgProject::class, ['id' => 'project_id']);
    }
}
