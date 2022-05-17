<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Client;
?>
<div class="client_cover">
    <div class="container">
        <h2 class="custom-heading">Наши клиенты</h2>
        <div class="client_grid">
            <?php
            $clients = Client::find()->orderBy(['priority'=>SORT_ASC])->all();
            foreach ($clients as $item) {
                echo Html::tag('div', Html::img($item->getLogo()), ['class' => 'client-block']);
            }
            ?>
        </div>
    </div>
</div>