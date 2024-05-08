<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\Hlp;
use yii\helpers\ArrayHelper;
use yii\console\widgets\Table;

/* @var $this yii\web\View */
/* @var $users array */
/* @var $hours array */

$this->title = 'Workday';
$this->params['breadcrumbs'][] = $this->title;
$users = ArrayHelper::index($users, 'id');
$hoursByUser = [];
$workdays = [];
$dates = [];

foreach ($hours as $hour) {
    $hoursByUser[$hour['user_id']][$hour['workday']] = $hour;
    if (!in_array($hour['workday'], $dates)) {
        $dates[] = $hour['workday'];
    }
}

echo "<pre>";
//print_r($users);
//print_r($workdays);
//print_r($hoursByUser);
//print_r($dates);
echo "</pre>";
$c1 = 'active';
$c2 = '';
$d = Yii::$app->request->get('d');
if ($d == 'pw') {
    $c1 = '';
    $c2 = 'active';
}
?>
<div class="page-index">

    <div class="flex spbtw">
        <h3><?= Html::encode($this->title) ?></h3>
        <div class='range-select'>
            <?= Html::a('This week', [''], ['class' => $c1]) ?>
            <?= Html::a('Prev week', ['', 'd' => 'pw'], ['class' => $c2]) ?>
        </div>
    </div>
    <table class='table table-striped table-condensed table-bordered table-dash'>
        <?php
        echo '<tr>';
        echo '<th>User</th>';
        foreach ($dates as $date) {
            echo '<th>' . $date . '</th>';
        }
        echo '<th>Total</th>';
        echo '</tr>';

        foreach ($hoursByUser as $user_id => $userDays) {
            $name = $users[$user_id]['name'];
            if (!$name) {
                $name = $users[$user_id]['username'];
            }
            $plan = 0;
            $work = 0;
            echo '<tr>';
            echo '<td>' . $name . '</td>';
            foreach ($dates as $date) {
                $track = '';
                if (isset($userDays[$date])) {
                    $day = $userDays[$date];
                    $track = Hlp::progr($day['plan']);
                    $track .= Hlp::progr($day['work'], true);
                    $plan += $day['plan'];
                    $work += $day['work'];
                }
                echo '<td>' . $track . '</td>';
            }
            $ttl = Hlp::progr($plan, false, true);
            $ttl .= Hlp::progr($work, true, true);
            echo '<td>' . $ttl . '</td>';
            echo '</tr>';
        }
        ?>
    </table>
</div>