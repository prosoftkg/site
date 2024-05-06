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
?>
<div class="page-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <table class='table table-striped table-condensed table-bordered table-dash'>
        <?php
        echo '<tr>';
        echo '<th>User</th>';
        foreach ($dates as $date) {
            echo '<th>' . $date . '</th>';
        }
        echo '</tr>';

        foreach ($hoursByUser as $user_id => $userDays) {
            echo '<tr>';
            echo '<td>' . $users[$user_id]['username'] . '</td>';
            foreach ($dates as $date) {
                $track = '';
                if (isset($userDays[$date])) {
                    $day = $userDays[$date];
                    $track = Hlp::progr($day['plan']);
                    $track .= Hlp::progr($day['work'], true);
                }
                echo '<td>' . $track . '</td>';
            }
            echo '</tr>';
        }
        ?>
    </table>
</div>