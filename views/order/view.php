<?php

use app\models\Order;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'contact',
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
            'industry_custom',
            'comment'
        ],
    ]) ?>

</div>