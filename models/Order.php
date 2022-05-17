<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $type
 * @property int $design_need
 * @property int $price_min
 * @property int $price_max
 * @property int $industry
 */
class Order extends \yii\db\ActiveRecord
{
    const ORDER_TYPE_ANDROID = 1;
    const ORDER_TYPE_SITE = 2;
    const ORDER_TYPE_IOS = 3;
    const ORDER_TYPE_OTHER = 4;

    const ORDER_DESIGN_NEED = 1;
    const ORDER_DESIGN_NOT_DECIDED = 2;
    const ORDER_DESIGN_NOT_NEEDED = 3;
    const ORDER_DESIGN_OTHER = 4;

    const ORDER_INDUSTRY_STORE = 1;
    const ORDER_INDUSTRY_DELIVERY = 2;
    const ORDER_INDUSTRY_HEALTHCARE = 3;
    const ORDER_INDUSTRY_MARKETPLACE = 4;
    const ORDER_INDUSTRY_CASHBACK = 5;
    const ORDER_INDUSTRY_AUTOMOTIZATION = 6;
    const ORDER_INDUSTRY_OWN = 7;

    /**
     * {@inheritdoc}
     */

    public $price_range;
    
    public static function tableName()
    {
        return 'order';
    }
    public static function typeList(){
        return  [
            self::ORDER_TYPE_ANDROID => 'Андроид приложение',
            self::ORDER_TYPE_SITE => 'Сайт',
            self::ORDER_TYPE_IOS => 'iOS приложение',
            self::ORDER_TYPE_OTHER => 'Другое',
        ];
    }

    public static function designNeedList(){
        return  [
            self::ORDER_DESIGN_NEED => 'Да, нужно разработать дизайн',
            self::ORDER_DESIGN_NOT_DECIDED => 'Пока не решил',
            self::ORDER_DESIGN_NOT_NEEDED => 'Нет, у меня есть дизайн проекта',
            self::ORDER_DESIGN_OTHER => 'Другое',
        ];
    }

    public static function industryList(){
        return  [
            self::ORDER_INDUSTRY_STORE => 'Интернет-магазин',
            self::ORDER_INDUSTRY_DELIVERY => 'Служба доставки',
            self::ORDER_INDUSTRY_HEALTHCARE => 'Здравоохранение',
            self::ORDER_INDUSTRY_MARKETPLACE => 'Маркетплейс',

            self::ORDER_INDUSTRY_CASHBACK => 'Кэшбек система',
            self::ORDER_INDUSTRY_AUTOMOTIZATION => 'Автоматизация бизнеса',
            self::ORDER_INDUSTRY_OWN => 'Ваш вариант (введите текст)',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['design_need', 'price_min', 'price_max', 'industry'], 'integer'],
            [['type','price_range'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'design_need' => Yii::t('app', 'Design Need'),
            'price_min' => Yii::t('app', 'Price Min'),
            'price_max' => Yii::t('app', 'Price Max'),
            'industry' => Yii::t('app', 'Industry'),
        ];
    }
}
