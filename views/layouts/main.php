<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-52342776-1" type="279bf399d1449e8ce1263309-text/javascript"></script>
    <script type="279bf399d1449e8ce1263309-text/javascript">
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-52342776-1');
        gtag('config', 'AW-1001497063');
    </script>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="description" content="
Разработка веб-сайтов, интернет-магазинов и мобильных приложений (iOS, Android) в Бишкеке, в Кыргызстане. Веб-студия в Бишкеке. Дизайн и создание сайтов и приложений под ключ. Заказать сайт визитку. Заказать разрботку мобильного приложения (iOS, Android, Андроид) 
">
    <meta name="keywords" content="разработка сайтов веб-сайтов мобильных приложений iOS Android интернет магазин интернет-магазин Бишкек Кыргызстан в Бишкеке в Кыргызстане дизайн сайта приложения веб-студия лучшие веб-студии программисты услуги программистов веб-разработка yii разработчики заказать сайт">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
    <?php echo $this->render('admin');
    ?>
    <header>
        <?= $this->render('navbar'); ?>
    </header>
    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>
    <?= $this->render('footer') ?>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>