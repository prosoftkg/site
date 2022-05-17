<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use karpoff\icrop\CropImageUpload;
use kartik\file\FileInput;
use dosamigos\selectize\SelectizeTextInput;

/* @var $this yii\web\View */
/* @var $model app\models\Portfolio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="portfolio-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'tagNames')->widget(SelectizeTextInput::className(), [
        // calls an action that returns a JSON object with matched
        // tags
        'loadUrl' => ['product/list'],
        'options' => ['class' => 'form-control'],
        'clientOptions' => [
            'plugins' => ['remove_button'],
            'valueField' => 'name',
            'labelField' => 'name',
            'searchField' => ['name'],
            'create' => true,
        ],
    ])->hint('Введите тэги через запятую') ?>

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

    <?= $form->field($model, 'web')->checkbox() ?>
    <?= $form->field($model, 'mobile')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>