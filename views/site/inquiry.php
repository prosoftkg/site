<?php

use app\models\Inquiry;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\slider\Slider;

/** @var yii\web\View $this */
?>

<div class="modal fade modal-success" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <b>Заявка на звонок</b> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-align-center">
                <div class="modal-body" id="getCode">
                    <div class="custom-modal-header"></div>
                    <div class="custom-modal-desc"></div>
                    <div class="custom-modal-text js_modal_content"></div>
                    <div class="custom-modal-comment"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$order_form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
        'action' => Url::to(['inquiry/create']),
        'class' => 'order_form'
    ]
]);
$order = new Inquiry();
?>
<div class="modal fade modal-success" id="getCountModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="getCount">
                <div class="wrap-modal-slider">
                    <div class="count_slider">
                        <?= $this->render('inquiry/part_1', [
                            'form' => $order_form,
                            'model' => $order,
                        ]); ?>
                        <?= $this->render('inquiry/part_2', [
                            'form' => $order_form,
                            'model' => $order,
                        ]); ?>
                        <?= $this->render('inquiry/part_3', [
                            'form' => $order_form,
                            'model' => $order,
                        ]); ?>
                        <?= $this->render('inquiry/part_4', [
                            'form' => $order_form,
                            'model' => $order,
                        ]) ?>
                        <?= $this->render('inquiry/part_5', [
                            'form' => $order_form,
                            'model' => $order,
                        ]) ?>
                    </div>
                </div>

                <div class="count-modal-desc">
                    <div class="question_nav">
                        <div class="question_back"><span>Назад</span></div>
                        <div class="question_next blue-btn"><span>Далее</span></div>
                    </div>

                    <div class=""></div>
                </div>

                <!-- <div class="custom-modal-text"></div>
                <div class="custom-modal-comment"></div> -->
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<div class="inquiry_cover">
    <div class="container">
        <div class="inquiry-col">
            <div class="count-left">
                <div class="count-question">
                    Свяжитесь с нами
                </div>

                <div class="count-hint">
                    <p>
                        Если вы заинтересованы в нашей работе и хотите обсудить проект, свяжитесь с нами и запросите цену.
                    </p>
                </div>
            </div>

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

                <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Эл. почта'])->label(false) ?>

                <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => 'Телефон'])->label(false) ?>

                <?= $form->field($model, 'message')->textInput(['maxlength' => true, 'placeholder' => 'Сообщение'])->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'отправить'), ['class' => 'btn btn-custom js_contact_submit']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

    <div class="inquiry-phone-form">
        <?php
        $model = new Inquiry();
        $form = ActiveForm::begin([
            'id' => 'phone-inquiry',
            'action' => Url::to(['inquiry/create']),
            'enableClientValidation' => false,
            'options' => [
                'class' => 'phone-inquiry',
            ]
        ]);
        ?>
        <div class="form-shortener">
            <?= $form->field($model, 'fullname')->textInput(['maxlength' => true, 'placeholder' => 'ФИО'])->label(false); ?>
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => 'Телефон'])->label(false) ?>
            <?= $form->field($model, 'message')->textInput(['maxlength' => true, 'placeholder' => 'Сообщение'])->label(false) ?>
        </div>
        <div class='custom-modal-comment'>Нажимая кнопку, вы даете согласие на обработку персональных данных и согласны с условиями пользовательского соглашения.</div>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'отправить'), ['class' => 'btn js_inquiry_submit btn-callback']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<div class="order_personal_data modal-shortener">
    <div class="custom-modal-grid-two">
        <?php
        echo $form->field($model, 'fullname')->textInput(['maxlength' => true, 'placeholder' => 'ФИО'])->label(false);
        echo $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => '0990 140 142'])->label(false);
        ?>
    </div>
    <div class="custom-modal-hint">
        Нажимая кнопку, вы даете согласие на обработку персональных данных и согласны с условиями пользовательского соглашения.
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Получить расчет'), ['class' => 'btn blue-btn js_contact_submit']) ?>
    </div>

</div>