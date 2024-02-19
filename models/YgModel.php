<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

class YgModel extends \yii\db\ActiveRecord
{
    public static $dartlabKey = 'AftoMTJhmiYXDzSrYkzdoOkUfu46fQJd9IOY5ghZ-K5RRZFMpIlVxwc8IPgIluf3';
    public static $ygurl = 'https://yougile.com/api-v2';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }
}
