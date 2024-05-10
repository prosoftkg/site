<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\Hlp;

/* @var $this yii\web\View */
/* @var $users array */
/* @var $hours array */

$this->title = 'Workday';
$this->params['breadcrumbs'][] = $this->title;
$user_tasks = [];

/* [
    'user_id'=>[
        'name'=>'',
        'tasks'=>tasks
    ]
] */
/* [
    'project_id'=>[
        'title'=>'',
        'columns'=>[
            'column_id'=>[
                'title'=>'',
                'tasks'=>tasks
            ]
        ]
    ]
]
 */

?>
<div class="page-index">

    <h3><?= Html::encode($this->title) ?></h3>
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
                    'tasks' => [$task]
                ];
            }
        }
    }
    foreach ($user_tasks as $user_id => $user) {
        echo '<h4>' . $user['name'] . '</h4>';
        echo "<table class='table table-striped table-condensed table-bordered'>";
        foreach ($user['tasks'] as $task) {
            if (empty($task->column->board->project->title)) {
                echo "<tr><td>" . $task->id . "</td></tr>";
            } else {
            }
            /* echo "<tr>";
            echo "<td>" . $task->column->board->project->title . '</td>';
            echo "<td>" . $task->column->title . '</td>';
            echo "<td>" . $task->id . ': ' . $task->title . '(' . $task->completed . ')</td>';
            echo "<td>" . $task->time_plan . '</td>';
            echo "</tr>";
            if ($task->subtasks) {
                foreach ($task->subtasks as $subtask) {
                    echo "<tr>";
                    echo "<td> </td>";
                    echo "<td> </td>";
                    echo "<td>" . $subtask->id . ': ' . $subtask->title . '(' . $subtask->completed . ')</td>';
                    echo "<td>" . $subtask->time_plan . '</td>';
                    echo "</tr>";
                }
            } */
        }
        echo "</table>";
    }
    ?>

</div>