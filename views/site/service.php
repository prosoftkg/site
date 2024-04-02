<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
?>

<div class="service_cover" id="service">
    <div class="container">
        <h2 class="custom-heading">Наши услуги и стэк</h2>
        <div class="service-grid">
            <div class="service-block mob-dev">
                <div class="service-gradient">

                </div>
                <div class="service-title">
                    Мобильная разработка
                </div>
            </div>
            <div class="service-block web-dev">
                <div class="service-gradient">

                </div>
                <div class="service-title">
                    Веб разработка
                </div>
            </div>
            <div class="service-block automate-dev">
                <div class="service-gradient">

                </div>
                <div class="service-title">
                    Автоматизация бизнеса
                </div>
            </div>
            <div class="service-block design-dev">
                <div class="service-gradient">

                </div>
                <div class="service-title">
                    UX/UI дизайн
                </div>
            </div>
            <div class="service-block seo-dev">
                <div class="service-gradient">

                </div>
                <div class="service-title">
                    Бизнес аналитика
                </div>

                <!-- <div class="service-desc">
                    PPC, электронный маркетинг, написание контента, SEO, продвижение в Apple Store и Google Market.
                </div> -->

                <!-- <div class="service-bottom">
                    <?php //Html::img(Url::base() . '/images/site/service-items.svg'); 
                    ?>
                </div> -->
            </div>

            <div class="service-block free-consult">

                <div class="service-title">
                    Не знаете какая услуга вам нужна?
                </div>

                <div class="service-desc-consult js_offer_btn pointer">
                    Бесплатная консультация
                    <div><?= Html::img(Url::base() . '/images/site/arrow-right-circle.svg'); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>