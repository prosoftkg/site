<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $title
 * @property string $link
 * @property int $priority
 * @property string $logo
 */
class Client extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'link', 'priority', 'logo'], 'safe'],
            [['priority'], 'integer'],
            [['title', 'link', 'logo'], 'string', 'max' => 255],
        ];
    }

    public function getLogo()
    {
        $filename = Yii::getAlias("@webroot/images/client/{$this->id}/") . $this->logo;
        if (file_exists($filename)) {
            return Url::base() . "/images/client/{$this->id}/{$this->logo}";
        } else {
            return Url::base() . "/images/client/template.png";
        }
    }    

    function beforeValidate()
    {
        $this->file = UploadedFile::getInstance($this, 'file');
        if ($this->file) {
            $this->logo = preg_replace('/\s+/', '', $this->file);
        }
        return parent::beforeValidate();
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($this->file) {
            $dir = Yii::getAlias("@webroot/images/client/{$this->id}");
            FileHelper::createDirectory($dir);
            $filename = preg_replace('/\s+/', '', $this->file);
            $this->file->saveAs("{$dir}" . DIRECTORY_SEPARATOR . "{$filename}");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'link' => Yii::t('app', 'Link'),
            'priority' => Yii::t('app', 'Priority'),
            'logo' => Yii::t('app', 'Logo'),
        ];
    }
}
