<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\Hlp;

/* @var $this yii\web\View */
/* @var $users array */
/* @var $hours array */

$this->title = 'Workday';
$this->params['breadcrumbs'][] = $this->title;
$hoursByUser = [];


foreach ($hours as $hour) {
    $hoursByUser[$hour['user_id']] = $hour;
}
?>
<div class="page-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <ul class="list-group">
        <?php

        foreach ($users as $user) {
            $name = $user['name'];
            if (!$name) {
                $name = $user['username'];
            }
            $name = Html::tag('span', $name, ['class' => 'workday-user mb5']);
            $track = '';
            if (isset($hoursByUser[$user['id']])) {
                $day = $hoursByUser[$user['id']];
                //$track = $day['plan'] . ' / ' . $day['work'];
                $track = Hlp::progr($day['plan']);
                $track .= Hlp::progr($day['work'], true);
            }
            echo Html::tag('li', $name . $track, ['class' => 'list-group-item']);
        };
        ?>
    </ul>

</div>