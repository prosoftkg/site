<?php

use app\components\Hlp;

/** @var yii\web\View $this */

?>
<div class="count-wrap">
    <div class="container">
        <div class="count-cover">
            <div class="count-left">
                <div class="count-question">
                    Сколько стоит ваше приложение?
                </div>
                <div class="count-hint">
                    <p>Есть вопросы? Позвоните нам</p>
                    <p><a href='tel:<?= Hlp::phones()[1] ?>'><?= Hlp::phones()[0] ?></a></p>
                </div>
            </div>
            <div class="count-right">
                <div class="count-quote">
                    Рассчитаем стоимость вашего приложения.
                    Получите расчет ответив на 5 простых вопроса!
                </div>
                <div class="count-btn blue-btn">
                    Получить расчет
                </div>
            </div>
        </div>
    </div>
</div>