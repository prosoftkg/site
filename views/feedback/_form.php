<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use karpoff\icrop\CropImageUpload;
use vova07\imperavi\Widget;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Feedback */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="feedback-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'formatting' => ['p', 'blockquote', 'h2'],
            'plugins' => [
                'clips',
                'fullscreen',
                'table',
                'fontsize',
                'fontcolor',
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'photo')->widget(CropImageUpload::className()) ?>

    <?= $form->field($model, 'file')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>