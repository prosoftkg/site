<div>
    <div class="custom-modal-desc count-modal-desc">
        <div>
            <div class="question_num">
                Вопрос <span>5</span> из 5
            </div>


            <div class="question_title">
                Ваши контактные данные
            </div>
            <br />

            <div class="question_options">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'contact')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="question_title">
                Дополнительная информация
            </div>
            <div class='font12 lhn mb5'>Есть ли у вас комментарии или другая информация (может быть примеры других проектов-аналогов)?</div>

            <div class="">
                <?= $form->field($model, 'comment')->textArea(['maxlength' => true,])->label(false) ?>
                <div class='font11'>макс. 500 символов</div>
            </div>

        </div>

        <div>
        </div>
    </div>
</div>