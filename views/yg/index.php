<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\Hlp;
use yii\helpers\ArrayHelper;
use yii\console\widgets\Table;

/* @var $this yii\web\View */
/* @var $users array */
/* @var $hours array */

$this->title = 'Workdays';
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
            echo "<td><a href='#{$users[$user_id]['username']}' class='nolink'>" . $name . '</a></td>';
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
    <h3>Tasks</h3>
    <?php
    foreach ($tasks as $task) {
        foreach ($task->users as $user) {
            if (isset($user_tasks[$user->id])) {
                $user_tasks[$user->id]['tasks'][] = $task;
            } else {
                $name = $user->name;
                if (!$name) {
                    $name = $user->username;
                }
                $user_tasks[$user->id] = [
                    'name' => $name,
                    'tasks' => [$task],
                    'username' => $user->username
                ];
            }
        }
    }
    foreach ($user_tasks as $user_id => $user) {
        echo "<h4 id='{$user['username']}'>" . $user['name'] . '</h4>';
        echo "<table class='table table-striped table-condensed table-bordered table-tasks'>";
        foreach ($user['tasks'] as $task) {
            echo "<tr>";
            if (isset($task->column->board->project->title)) {
                echo "<td class='sm'>" . $task->column->board->project->title . '</td>';
                echo "<td class='sm'>" . $task->column->title . '</td>';
            } else {
                echo "<td> NO</td>";
                echo "<td> NO</td>";
            }
            echo "<td data-id='{$task->id}'>" . $task->title . '(' . $task->completed . ')</td>';
            echo "<td>" . $task->time_plan . '</td>';
            echo "</tr>";
            if ($task->subtasks) {
                foreach ($task->subtasks as $subtask) {
                    echo "<tr>";
                    echo "<td> </td>";
                    echo "<td> </td>";
                    echo "<td data-id='{$subtask->id}'>" . $subtask->title . '(' . $subtask->completed . ')</td>';
                    echo "<td>" . $subtask->time_plan . '</td>';
                    echo "</tr>";
                }
            }
        }
        echo "</table>";
    }
    ?>
</div>