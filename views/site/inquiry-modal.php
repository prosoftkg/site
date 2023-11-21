<?php

use app\models\Inquiry;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
?>
<div class="inquiry_modal">
    <div class="inquiry-form">
        <?php
        $model = new Inquiry();
        $form = ActiveForm::begin([
            'id' => 'callback-form',
            'action' => Url::to(['inquiry/create']),
            'options' => [
                'class' => 'callback-form-gq',
            ]
        ]);
        ?>
        <?= $form->field($model, 'fullname')->textInput(['maxlength' => true, 'placeholder' => 'ФИО'])->label(false); ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'ваш@gmail.com'])->label(false) ?>
        <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => '0555 51 50 55'])->label(false) ?>
        <?= $form->field($model, 'message')->textInput(['maxlength' => true, 'placeholder' => 'Сообщение'])->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'отправить'), ['class' => 'btn btn-custom js_contact_submit modalnahoi']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>