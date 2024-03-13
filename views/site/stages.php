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
                            Прототипируем
                        </div>
                        <div class="answercont">
                            <div class="answer">
                                It's likely an infinite loop in JavaScript that we could not catch. To fix, add ?turn_off_js=true to the end of the URL (on any page, like the Pen or Project editor, your Profile page, or the Dashboard) to temporarily turn off JavaScript. When you're ready to run the JavaScript again, remove ?turn_off_js=true and refresh the page.<br><br>

                                <a href="https://blog.codepen.io/documentation/features/turn-off-javascript-in-previews/">How to Disable JavaScript Docs</a>
                            </div>
                        </div>
                    </div>

                    <div class="accordeon-container">
                        <div class="question">
                            Дизайним
                        </div>
                        <div class="answercont">
                            <div class="answer">
                                You can leave a comment on any public Pen. Click the "Comments" link in the Pen editor view, or visit the Details page.<br><br>

                                <a href="https://blog.codepen.io/documentation/faq/how-do-i-contact-the-creator-of-a-pen/">How to Contact Creator of a Pen Docs</a>
                            </div>
                        </div>
                    </div>

                    <div class="accordeon-container">
                        <div class="question">
                            Программируем
                        </div>
                        <div class="answercont">
                            <div class="answer">
                                We have our current list of library versions <a href="https://codepen.io/versions">here</a>

                            </div>
                        </div>
                    </div>

                    <div class="accordeon-container">
                        <div class="question">
                            Тестируем
                        </div>
                        <div class="answercont">
                            <div class="answer">
                                A fork is a complete copy of a Pen or Project that you can save to your own account and modify. Your forked copy comes with everything the original author wrote, including all of the code and any dependencies.<br><br>

                                <a href="https://blog.codepen.io/documentation/features/forks/">Learn More About Forks</a>
                            </div>
                        </div>
                    </div>
                    <div class="accordeon-container">
                        <div class="question">
                            Поддерживаем
                        </div>
                        <div class="answercont">
                            <div class="answer">
                                A fork is a complete copy of a Pen or Project that you can save to your own account and modify. Your forked copy comes with everything the original author wrote, including all of the code and any dependencies.<br><br>

                                <a href="https://blog.codepen.io/documentation/features/forks/">Learn More About Forks</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="stage_right">
                <?= Html::img(Url::base() . '/images/site/stage1.png'); ?>
            </div>
        </div>
    </div>
</div>