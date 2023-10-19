<?php

use app\models\Feedback;
use yii\helpers\Html;

$items = Feedback::find()->all();
?>
<section id='feedback'>
    <div class="feedback_cover">
        <div class="container">
            <h2 class="custom-heading">Отзывы от наших клиентов</h2>

            <div class='feedback_dots js_feedback_dots'>
                <?php
                $i = 0;
                foreach ($items as $item) {
                    if ($i == 0) {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                    echo Html::beginTag('span', ['class' => 'feedback-dot ' . $active, 'data-count' => $i]);
                    echo Html::img($item->getLogo(), ['class' => '']);
                    echo Html::endTag('span');
                    $i++;
                }
                ?>
            </div>

            <div class="feedback-slider-wrap">
                <div class="feedback-slider">
                    <?php
                    foreach ($items as $item) {
                        echo Html::beginTag('div', ['class' => 'feedback-grid']);

                        echo Html::beginTag('div');
                        echo Html::img($item->getWallpaper(), ['class' => 'feedback-wallpaper']);
                        echo Html::endTag('div');

                        echo Html::beginTag('div', ['class' => 'feedback-wrap']);
                        echo Html::beginTag('div', ['class' => 'current-author']);
                        echo Html::img($item->getLogo(), ['class' => '']);
                        echo Html::tag('div', $item->author, ['class' => 'feedback-author']);
                        echo Html::tag('div', $item->title, ['class' => 'feedback-title']);
                        echo Html::endTag('div');
                        echo Html::tag('div', $item->text, ['class' => 'feedback-text']);
                        echo Html::endTag('div');

                        echo Html::endTag('div');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>