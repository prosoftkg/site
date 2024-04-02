<?php

namespace app\models;

use Yii;
use yii\httpclient\Client;


/**
 * This is the model class for table "yg_column".
 *
 * @property int $id
 * @property int|null $board_id
 * @property string|null $yg_id
 * @property string|null $yg_board_id
 * @property string|null $title
 * @property int|null $color
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class YgColumn extends YgModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yg_column';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['board_id', 'color', 'created_at', 'updated_at'], 'integer'],
            [['yg_id', 'yg_board_id'], 'string', 'max' => 50],
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
            'board_id' => 'Board ID',
            'yg_id' => 'Yg ID',
            'yg_board_id' => 'Yg Board ID',
            'title' => 'Title',
            'color' => 'Color',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function fetchAll()
    {
        $boards = self::getDbBoards();
        foreach ($boards as $board) {
            self::fetchBoard($board['id'], $board['yg_id']);
        }
    }

    public static function fetchBoard($board_id, $yg_board_id)
    {

        $client = new Client();
        $response = $client
            ->createRequest()
            ->setMethod('GET')->setHeaders(['Authorization' => 'Bearer ' . YgModel::$dartlabKey])
            ->setUrl(YgModel::$ygurl . '/columns')
            ->setData(['boardId' => $yg_board_id])
            ->send();
        $data = $response->data;
        if (!empty($data['content'])) {
            foreach ($data['content'] as $row) {
                $model = YgColumn::findOne(['yg_id' => $row['id']]);
                if (!$model) {
                    $model = new YgColumn();
                    $model->yg_id = $row['id'];
                }
                $model->title = $row['title'];
                if (isset($row['color'])) {
                    $model->color = $row['color'];
                }
                $model->board_id = $board_id;
                $model->yg_board_id = $yg_board_id;
                $model->save();
            }
        }
    }

    protected static function getDbBoards()
    {
        $dao = Yii::$app->db;
        return $dao->createCommand("SELECT * FROM `yg_board`")->queryAll();
    }

    /**
     * Gets query for [[YgTask]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(YgTask::class, ['column_id' => 'id']);
    }

    /**
     * Gets query for [[YgBoard]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBoard()
    {
        return $this->hasOne(YgBoard::class, ['id' => 'board_id']);
    }
}
