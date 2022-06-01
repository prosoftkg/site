<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inquiry".
 *
 * @property int $id
 * @property string|null $fullname
 * @property string|null $e-mail
 * @property string $phone
 * @property string $message
 */
class Inquiry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inquiry';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'message'], 'required'],
            [['fullname', 'email', 'phone'], 'string', 'max' => 255],
            [['count_id'], 'integer', 'max' => 11],
            [['message'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fullname' => Yii::t('app', 'ФИО'),
            'email' => Yii::t('app', 'E-Mail'),
            'phone' => Yii::t('app', 'Телефон'),
            'message' => Yii::t('app', 'Сообщение'),
            'count_id' => Yii::t('app', 'Заявка на расчет'),
        ];
    }
}
