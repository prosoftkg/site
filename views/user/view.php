<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'name',
            'email:email',
            //'password_hash',
            //'auth_key',
            'yougile_id',
            'yougile_status',
            [
                'attribute' => 'yougile_last_active',
                'value' => function ($model) {
                    if (!$model->yougile_last_active) {
                        return null;
                    }
                    return Yii::$app->formatter->asDatetime($model->yougile_last_active);
                },
            ],
            'role',
            [
                'attribute' => 'confirmed_at',
                'value' => function ($model) {
                    if (!$model->confirmed_at) {
                        return null;
                    }
                    return Yii::$app->formatter->asDatetime($model->confirmed_at);
                },
            ],
            //'unconfirmed_email:email',
            [
                'attribute' => 'blocked_at',
                'value' => function ($model) {
                    if (!$model->blocked_at) {
                        return null;
                    }
                    return Yii::$app->formatter->asDatetime($model->blocked_at);
                },
            ],
            //'registration_ip',
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    if (!$model->created_at) {
                        return null;
                    }
                    return Yii::$app->formatter->asDatetime($model->created_at);
                },
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    if (!$model->updated_at) {
                        return null;
                    }
                    return Yii::$app->formatter->asDatetime($model->updated_at);
                },
            ],
            'flags',
            [
                'attribute' => 'last_login_at',
                'value' => function ($model) {
                    if (!$model->last_login_at) {
                        return null;
                    }
                    return Yii::$app->formatter->asDatetime($model->last_login_at);
                },
            ],
        ],
    ]) ?>

</div>