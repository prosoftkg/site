<?php

namespace app\models;

use Yii;
use karpoff\icrop\CropImageUploadBehavior;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use app\models\Tag;
use dosamigos\taggable\Taggable;

/**
 * This is the model class for table "portfolio".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $photo
 * @property string $photo_crop
 * @property string $photo_cropped
 * @property string $logo
 */
class Portfolio extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'portfolio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['tagNames','web','mobile'], 'safe'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
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
                'path' => "@webroot/images/portfolio",
                'url' => "@web/images/portfolio",
                'ratio' => 357 / 219,
                'crop_field' => 'photo_crop',
                'cropped_field' => 'photo_cropped',
            ],
            [
                'class' => Taggable::className(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function getWallpaper()
    {
        $filename = Yii::getAlias("@webroot/images/portfolio/") . $this->photo;
        if (file_exists($filename)) {
            return Url::base() . "/images/portfolio/{$this->photo_cropped}";
        } else {
            return Url::base() . "/images/portfolio/template.png";
        }
    }
    
    /**
     * {@inheritdoc}
     */

    public function getLogo()
    {
        $filename = Yii::getAlias("@webroot/images/portfolio/{$this->id}/") . $this->logo;
        if (file_exists($filename)) {
            return Url::base() . "/images/portfolio/{$this->id}/{$this->logo}";
        } else {
            return Url::base() . "/images/portfolio/template.png";
        }
    }    

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('portfolio_tag_assn', ['product_id' => 'id']);
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
            $dir = Yii::getAlias("@webroot/images/portfolio/{$this->id}");
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
            'photo_cropped' => Yii::t('app', 'Photo Cropped'),
            'logo' => Yii::t('app', 'Logo'),
            'file' => Yii::t('app', 'Файл'),
            'tagNames' => Yii::t('app', 'Тэг'),
        ];
    }
}
