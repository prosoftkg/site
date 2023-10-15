<?php

/** @var yii\web\View $this */

use yii\helpers\Url;
use yii\helpers\Html;
?>

<div class="stage_cover" id="stages">
    <div class="container">
        <h2 class="custom-heading">Поэтапная схема работы по выполнению проекта</h2>
        <div class="stage_grid">
            <div class="stage_left">
                <div class="wrapper">
                    <div class="accordeon-container">
                        <div class="question">
                            Анализируем
                        </div>
                        <div class="answercont">
                            <div class="answer">
                                Пишем ТЗ для разработки, учитывая бизнес-процессы и технологии заказчика и потребности пользователей.
                            </div>
                        </div>
                    </div>

                    <div class="accordeon-container">
                        <div class="question">
                            Создаем прототип
                        </div>
                        <div class="answercont">
                            <div class="answer">
                                Чтобы понять, как оно будет выглядеть и работать сайт или мобильное приложение, до начала полноценной разработки. Это помогает проверить идеи, улучшить дизайн и устранить проблемы на ранних этапах проекта.
                            </div>
                        </div>
                    </div>

                    <div class="accordeon-container">
                        <div class="question">
                            Дизайн
                        </div>
                        <div class="answercont">
                            <div class="answer">
                                Создаем интерфейс, который позволит пользователям легко понимать, как пользоваться приложением или сайтом, и сделаем его приятным и привлекательным для вашей целевой аудитории.
                            </div>
                        </div>
                    </div>

                    <div class="accordeon-container">
                        <div class="question">
                            Программируем
                        </div>
                        <div class="answercont">
                            <div class="answer">
                                Используем только современные технологии, позволяющие быстро и качественно создавать продукты.
                            </div>
                        </div>
                    </div>

                    <div class="accordeon-container">
                        <div class="question">
                            Тестируем
                        </div>
                        <div class="answercont">
                            <div class="answer">
                                Проверяем и испытываем сайт или приложение с целью обнаружения ошибок, недочетов или проблем, которые могут повлиять на работу или удобство использования.
                            </div>
                        </div>
                    </div>
                    <div class="accordeon-container">
                        <div class="question">
                            Поддерживаем
                        </div>
                        <div class="answercont">
                            <div class="answer">
                                Остаемся на связи с вами для исправление ошибок, добавление новых функций и обновлений, чтобы обеспечить бесперебойную работу сайта или приложения.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="stage_right">
                <?= Html::img(Url::base() . '/images/site/stage.png'); ?>
            </div>
        </div>
    </div>
</div>