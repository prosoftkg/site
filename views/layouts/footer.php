<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<footer class="footer">
    <div class="container">
        <div class="footer-top">
            <?= Html::img(Url::base() . "/images/site/logo.svg"); ?>
            <div class="footer-nav">
                <?= Html::a('портфолио', '#portfolio'); ?>
                <?= Html::a('услуги', '#service'); ?>
                <?= Html::a('о нас', '#digits'); ?>
                <?= Html::a('условия работы', '#stages'); ?>
                <?= Html::a('отзывы', '#feedback'); ?>
            </div>
            <div class="social-links">
                <?php //echo Html::a(Html::img(Url::base() . '/images/site/facebook.svg'), 'https://www.facebook.com/Prosoftkg'); 
                ?>
                <?php //echo Html::a(Html::img(Url::base() . '/images/site/instagram.svg'), 'https://instagram.com/Prosoftkg') 
                ?>
                <?php //echo Html::a(Html::img(Url::base() . '/images/site/twitter.svg'), 'https://www.twitter.com/prosoftkg') 
                ?>
            </div>
        </div>
    </div>
    <div class="footer-botom">
        <div class="container">
            Prosoft © <?= date('Y') ?>
        </div>
    </div>
</footer>

<script>
    // When the user scrolls down 50px from the top of the document, resize the header's font size
    window.onscroll = function() {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
            document.getElementById("header").classList.add('header_toggle');
            document.getElementById("header").classList.add('scrolled');
        } else {
            document.getElementById("header").classList.remove('header_toggle');
            document.getElementById("header").classList.remove('scrolled');
        }
    }

    $('.navbar-toggler-icon').on('click', function() {
        var parent = $(this).parents('.navbar-custom');
        if (parent.hasClass('header_toggle')) {
            if (!parent.hasClass('scrolled')) {
                parent.removeClass('header_toggle');
            }
        } else {
            parent.addClass('header_toggle');
        }
    });
</script>