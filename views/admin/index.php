<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Admin';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <div>user: <?= Yii::$app->user->identity->username; ?></div>
    <div>role: <?= Yii::$app->user->identity->role; ?></div>

</div>