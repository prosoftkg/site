<?php

use yii\helpers\Html;

if (!Yii::$app->user->isGuest) {
?>

    <div class="admin-block testir">
        <?php
        if (Yii::$app->user->identity->role == 'admin') {
            echo Html::a(Yii::t('app', 'Портфолио'), ['/portfolio/index']);
            echo Html::a(Yii::t('app', 'Отзывы'), ['/feedback/index']);
            echo Html::a(Yii::t('app', 'Заявки на звонок'), ['/inquiry/index']);
        } else {
        }
        echo Html::a(Yii::t('app', 'Logout'), ['/site/logout'], ['class' => 'float-right']);
        ?>
    </div>
<?php
}
