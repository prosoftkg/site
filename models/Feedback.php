<?php

namespace app\models;

use Yii;
use karpoff\icrop\CropImageUploadBehavior;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
/**
 * This is the model class for table "feedback".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $photo
 * @property string $photo_crop
 * @property string $photo_cropped
 */
class Feedback extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['text',], 'string'],
            [['title','logo','author'], 'string', 'max' => 255],
            ['photo', 'file', 'extensions' => 'png, jpeg, jpg, gif', 'on' => ['insert', 'update']],
            [['photo_crop', 'photo_cropped'], 'string', 'max' => 100]
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            [
                'class' => CropImageUploadBehavior::className(),
                'attribute' => 'photo',
                'scenarios' => ['insert', 'update'],
                'path' => "@webroot/images/feedback",
                'url' => "@web/images/feedback",
                'ratio' => 551 / 313,
                'crop_field' => 'photo_crop',
                'cropped_field' => 'photo_cropped',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function getWallpaper()
    {
        $filename = Yii::getAlias("@webroot/images/feedback/") . $this->photo;
        if (file_exists($filename)) {
            return Url::base() . "/images/feedback/{$this->photo_cropped}";
        } else {
            return Url::base() . "/images/site/template.png";
        }
    }

    /**
     * {@inheritdoc}
     */

    public function getLogo()
    {
        $filename = Yii::getAlias("@webroot/images/feedback/{$this->id}/") . $this->logo;
        if (file_exists($filename)) {
            return Url::base() . "/images/feedback/{$this->id}/{$this->logo}";
        } else {
            return Url::base() . "/images/portfolio/template.png";
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
            $dir = Yii::getAlias("@webroot/images/feedback/{$this->id}");
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
            'text' => Yii::t('app', 'Text'),
            'photo' => Yii::t('app', 'Photo'),
            'photo_crop' => Yii::t('app', 'Photo Crop'),
            'author' => Yii::t('app', 'Author'),
            'photo_cropped' => Yii::t('app', 'Photo Cropped'),
        ];
    }
}
