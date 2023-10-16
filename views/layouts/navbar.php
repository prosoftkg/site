<?php

/** @var yii\web\View $this */
/** @var string $content */

use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

NavBar::begin([
    'brandLabel' => '<div class="brand-logo"></div>',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-expand-md navbar-custom',
        'id' => 'header',
        'encodeLabels' => false,
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
    'items' => [
        ['label' => 'портфолио', 'url' => '#portfolio', 'options' => ['class' => 'left-side-menu menu-right-margin']],
        ['label' => 'услуги', 'url' => '#service', 'options' => ['class' => 'left-side-menu menu-right-margin']],
        ['label' => 'о нас', 'url' => '#digits', 'options' => ['class' => 'left-side-menu']],
        ['label' => '', 'url' => ['/'], 'options' => ['class' => 'logo']],
        ['label' => 'условия работы', 'url' => '#stages', 'options' => ['class' => 'right-side-menu menu-left-margin']],
        ['label' => 'отзывы', 'url' => '#feedback', 'options' => ['class' => 'right-side-menu menu-left-margin']],
        ['label' => 'контакты', 'url' => '#contacts', 'options' => ['class' => 'right-side-menu menu-left-margin']],
    ],
]);
NavBar::end();
