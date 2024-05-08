<?php

namespace app\components;

use yii\helpers\Html;

class Hlp
{

    public static function pb($v, $bg = '')
    {
        $inner = Html::tag('div', '', ['class' => "progress-bar $bg", 'style' => "width: $v%"]);
        $outer = Html::tag('div', $inner, ['class' => 'progress', 'role' => 'progressbar', 'aria-label' => '2px high', 'aria-valuenow' => $v, 'aria-valuemin' => '0', 'aria-valuemax' => '100', 'style' => 'height:2px']);
        return $outer;
    }

    public static function progr($v, $is_work = false, $is_week = false)
    {
        $bg = '';
        $minutes = ceil(60 * $v);
        $time = intdiv($minutes, 60) . ':' . ($minutes % 60);
        $percent = ($minutes / 480) * 100;
        if ($is_week) {
            $percent = ($minutes / 2400) * 100;
        }
        if ($is_work) {
            $bg = 'bg-success';
            $title = 'Spent: ' . $time;
        } else {
            $title = 'Estimate: ' . $time;
        }
        $title = Html::tag('div', $title, ['class' => 'text-muted font13']);
        $bar = self::pb($percent, $bg);
        return Html::tag('div', $title . $bar, []);
    }
}
