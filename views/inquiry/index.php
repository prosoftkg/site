<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Inquiry;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InquirySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Inquiries');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inquiry-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary'=>false,
        'columns' => [
            'fullname',
            'email',
            'phone',
            'message',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Inquiry $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                 'template'=>'{view}'
            ],
        ],
    ]); ?>


</div>
