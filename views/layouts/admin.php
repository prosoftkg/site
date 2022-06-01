<?php
use yii\helpers\Html; ?>
<div class="admin-block">
    <?= Html::a(Yii::t('app', 'Портфолио'), ['/portfolio/index']); ?>
    <?= Html::a(Yii::t('app', 'Отзывы'), ['/feedback/index']); ?>
    <?= Html::a(Yii::t('app', 'Заявки на звонок'), ['/inquiry/index']); ?>
</div>