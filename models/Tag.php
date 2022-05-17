<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property int $frequency
 * @property string $name
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['frequency', 'name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'frequency' => Yii::t('app', 'Frequency'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
