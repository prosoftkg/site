<?php

use yii\helpers\Html;
use app\components\Hlp;

/* @var $this yii\web\View */
/* @var $model app\models\Page */

$this->title = 'test';
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="page-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    echo Hlp::pb(30, '');
    $minutes = 150;

    $hours = intdiv($minutes, 60) . ':' . ($minutes % 60);
    echo $hours;
    ?>


</div>