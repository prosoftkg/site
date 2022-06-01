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
            'message',
        ],
    ]) ?>

</div>
