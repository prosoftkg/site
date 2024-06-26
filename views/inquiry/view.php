<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Inquiry */

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Inquiries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="inquiry-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fullname',
            'email',
            'phone',
            /* [
                'attribute' => 'info',
                'format' => 'raw',
                'value' => function ($model) {
                    $types = [];
                    $rows = json_decode($model->info);
                    if (!$rows) {
                        return null;
                    }
                    foreach ($rows as $k => $v) {
                        $types[] = $k . ': ' . $v;
                    };
                    return implode('<br />', $types);
                }
            ], */
            [
                'attribute' => 'info',
                'format' => 'raw',
            ],
            'message',
            'yougile_id',
            'yougile_status',
            'admin_comment',
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at);
                },
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->updated_at);
                },
            ],
        ],
    ]) ?>

</div>