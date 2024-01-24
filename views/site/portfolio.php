<?php

/** @var yii\web\View $this */

use app\models\Portfolio;
use kartik\tabs\TabsX;

$items = [
    [
        'label' => '',
        'content' => $this->render('tabContent', ['items' => Portfolio::find()->orderBy(['prioritet' => SORT_ASC])->all()]),
        'active' => true,
        'linkOptions' => ['class' => 'empty-tab-link']
    ],
    [
        'label' => 'Web',
        'content' => '',
        'linkOptions' => ['data-url' => \yii\helpers\Url::to(['/site/tabs-data', 'id' => 1])]
    ],
    [
        'label' => 'Mobile',
        'content' => '',
        'linkOptions' => ['data-url' => \yii\helpers\Url::to(['/site/tabs-data', 'id' => 2]), 'class' => 'tab-link-margin']
    ],
]; ?>
<div class="portfolio" id="portfolio">
    <div class="container">
        <h2 class="custom-heading">Наши проекты</h2>
        <!-- <div class="portfolio_slogan">
            Работали с первыми лицами государств, топ-менеджерами и собственниками крупнейших кыргызских и зарубежных компаний.
        </div> -->
        <br />
        <?= TabsX::widget([
            'items' => $items,
            'position' => TabsX::POS_ABOVE,
            'align' => TabsX::ALIGN_RIGHT,
            'bordered' => true,
            'encodeLabels' => false
        ]); ?>
    </div>
</div>