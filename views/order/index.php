<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Order;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'id', 'contentOptions' => ['width' => 80]],
            'name',
            [
                'attribute' => 'type',
                'value' => function ($model) {
                    $types = [];
                    $rows = unserialize($model->type);
                    if (!$rows) {
                        return null;
                    }
                    foreach ($rows as $type) {
                        $types[] = Order::typeList()[$type];
                    };
                    return implode(', ', $types);
                }
            ],
            [
                'attribute' => 'design_need',
                'value' => function ($model) {
                    $list = Order::designNeedList();
                    if ($model->design_need) {
                        return $list[$model->design_need];
                    }
                    return $model->design_need;
                }
            ],
            'price_min',
            'price_max',
            [
                'attribute' => 'industry',
                'value' => function ($model) {
                    $list = Order::industryList();
                    if ($model->industry) {
                        return $list[$model->industry];
                    }
                    return $model->industry;
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Order $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }, 'contentOptions' => ['width' => 90]
            ],
        ],
    ]); ?>


</div>