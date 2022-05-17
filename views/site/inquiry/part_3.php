<?php

use kartik\slider\Slider;
?>
<div>
    <div class="custom-modal-desc count-modal-desc">
        <div>
            <div class="question_num">
                Вопрос <span>3</span> из 4
            </div>

            <div class="question_title">
                Какую сумму на разработку вы хотите инвестировать в течении первого года? (в долларах)
            </div>

            <div class="range_label_cover">
                <div class="range_label range_label_left">от $ 1000</div>
                <div class="range_label range_label_right">до $ 5000</div>
            </div>

            <?=$form->field($model, 'price_range')->widget(Slider::classname(), [
                'value' => '500,10000',
                'sliderColor' => Slider::TYPE_GREY,
                'pluginOptions' => [
                    'min' => 0,
                    'max' => 100000,
                    'step' => 100,
                    'range' => true
                ]
            ]);
            ?>
        </div>

        <div>
            <div class="modal-right-block">
                <div class="modal-info"></div>
                <div class="inner-modal-right">Считается, что самая платежеспособная аудитория - это пользователи iOS. Чаще всего разработку начинают именно с iOS, так как количество устройств на ней гораздо меньше, чем у Android - и приложение гораздо проще переделывать, учитывая пожелания пользователей.</div>
            </div>
        </div>
    </div>
</div>