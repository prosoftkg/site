<?php

use app\models\Feedback;
use yii\helpers\Html;
?>
<div class="feedback_cover">
    <div class="container">
        <h2 class="custom-heading">Отзывы от наших клиентов</h2>
        <div class="feedback-slider-wrap">
            <div class="feedback-slider">
                <?php
                $items = Feedback::find()->all();
                foreach ($items as $item) {
                    echo Html::beginTag('div', ['class' => 'feedback-grid']);

                    echo Html::beginTag('div');
                    echo Html::img($item->getWallpaper(), ['class' => 'feedback-wallpaper']);
                    echo Html::endTag('div');

                    echo Html::beginTag('div');
                    echo Html::tag('div', $item->title, ['class' => 'feedback-title']);
                    echo Html::tag('div', $item->text, ['class' => 'feedback-text']);
                    echo Html::endTag('div');

                    echo Html::endTag('div');
                }
                ?>
            </div>
        </div>

        <div class="test-small-slick">
            <?php
            foreach ($items as $item) {
                echo Html::beginTag('div', ['class' => 'feedback-thumb']);
                echo Html::beginTag('div', ['class' => 'current-author']);
                echo Html::img($item->getLogo(), ['class' => '']);
                echo Html::tag('div', $item->author, ['class' => 'feedback-author']);
                echo Html::endTag('div');
                echo Html::endTag('div');
            }
            ?>
        </div>
    </div>
</div>