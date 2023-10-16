<?php

use app\models\Order;

$types = Order::typeList();
?>
<div>
    <div class="custom-modal-desc count-modal-desc">
        <div>
            <div class="question_num">
                Вопрос <span>1</span> из 5
            </div>

            <div class="question_title">
                Что вы хотите заказать?
            </div>
            <div class="question_amount">
                Выберите один или несколько вариантов
            </div>


            <?php //= $form->field($model, 'type')->checkboxList($types)->label(false); 
            ?>
            <?= $form->field($model, 'type[]')->checkboxList(
                $types
                // [
                //     'item' => function ($index, $label, $name, $checked, $value) {
                //         return
                //             '<div class="checkbox-group"><input id=type-'.$index.' type="checkbox" /><label for=type-'.$index.'>' . $label . '</label></div>';
                //     }
                // ]
            )->label(false); ?>
        </div>

        <div class="modal-right-block">
            <div class="modal-info"></div>
            <div class="inner-modal-right">Считается, что самая платежеспособная аудитория - это пользователи iOS. Чаще всего разработку начинают именно с iOS, так как количество устройств на ней гораздо меньше, чем у Android - и приложение гораздо проще переделывать, учитывая пожелания пользователей.</div>
        </div>
    </div>
</div>