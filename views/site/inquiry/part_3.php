<?php

use kartik\slider\Slider;
?>
<div>
    <div class="custom-modal-desc count-modal-desc">
        <div>
            <div class="question_num">
                Вопрос <span>3</span> из 5
            </div>

            <div class="question_title">
                Какую сумму на разработку вы хотите инвестировать в течении первого года? (в долларах)
            </div>

            <div class="range_label_cover">
                <div class="range_label range_label_left">от $ <span class="price_digit_min">500</span></div>
                <div class="range_label range_label_right">до $ <span class="price_digit_max">20000</span></div>
            </div>

            <?= $form->field($model, 'price_range')->widget(Slider::class, [
                'value' => '500,15000',
                'sliderColor' => Slider::TYPE_GREY,
                'pluginOptions' => [
                    'min' => 500,
                    'max' => 20000,
                    'step' => 500,
                    'range' => true
                ],
            ])->label(false);
            ?>
        </div>

        <div>
        </div>
    </div>
</div>