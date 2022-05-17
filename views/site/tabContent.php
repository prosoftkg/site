<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
?>
<div class="portfolio-slider">
    <?php
    foreach ($items as $item) {
        echo Html::beginTag('div', ['class' => 'portfolio-grid']);

        echo Html::beginTag('div',['class'=>'portfolio-item-cover']);
        echo Html::beginTag('div',['class'=>'portfolio-intro']);
        echo Html::img($item->getLogo(), ['class' => 'portfolio-logo']);

        // --------- Tags Begin-------------------
        echo Html::beginTag('span',['class'=>'portfolio-tags']);
        foreach ($item->tags as $tag) {
            echo Html::tag('span', $tag->name);
        }
        echo Html::endTag('span');
        // --------- Tags End-------------------
        echo Html::endTag('div');
        
        echo Html::tag('div', $item->title, ['class'=>'portfolio-title']);
        echo Html::tag('div', $item->text, ['class'=>'portfolio-text']);
        echo Html::endTag('div');

        echo Html::beginTag('div',['class'=>'portfolio-wallpaper-cover']);
        echo Html::img($item->getWallpaper(), ['class' => 'portfolio-wallpaper']);
        echo Html::endTag('div');

        echo Html::endTag('div');
    } ?>
</div>