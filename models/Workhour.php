<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "workhour".
 *
 * @property int $id
 * @property int|null $user_id
 * @property float|null $plan
 * @property float|null $work
 * @property string|null $workday
 */
class Workhour extends YgModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'workhour';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['plan', 'work'], 'number'],
            [['workday'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'plan' => 'Plan',
            'work' => 'Work',
            'workday' => 'Workday',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [];
    }

    public static function calcHours()
    {
        $dao = Yii::$app->db;
        $rows = $dao->createCommand("SELECT * FROM `yg_task` WHERE completed_at IS NOT NULL AND time_plan IS NOT NULL AND time_work IS NOT NULL")->queryAll();
        $calcs = [];
        foreach ($rows as $row) {
            $completed_at = date('Y-m-d', $row['completed_at']);
            $users = $dao->createCommand("SELECT * FROM `yg_task_user` WHERE task_id={$row['id']}")->queryAll();
            if ($users) {
                $plan = $row['time_plan'] / count($users);
                $work = $row['time_work'] / count($users);
                foreach ($users as $user) {
                    if (!isset($calcs[$completed_at][$user['user_id']])) {
                        $calcs[$completed_at][$user['user_id']] = ['plan' => $plan, 'work' => $work];
                    } else {
                        $calcs[$completed_at][$user['user_id']]['plan'] += $plan;
                        $calcs[$completed_at][$user['user_id']]['work'] += $work;
                    }
                }
            }
        }
        foreach ($calcs as $workday => $users) {
            foreach ($users as $user_id => $calc) {
                $workhour = Workhour::findOne(['user_id' => $user_id, 'workday' => $workday]);
                if (!$workhour) {
                    $workhour = new Workhour();
                    $workhour->user_id = $user_id;
                    $workhour->workday = $workday;
                }
                $workhour->plan = $calc['plan'];
                $workhour->work = $calc['work'];
                $workhour->save();
            }
        }
    }
}
