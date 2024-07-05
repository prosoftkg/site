<?php
// 1. Create a new component (e.g., app/components/GlobalData.php)
namespace app\components;

use yii\base\Component;
use yii\db\Query;

class GlobalData extends Component
{
    private $_data = [];

    public function init()
    {
        parent::init();
        $this->loadData();
    }

    private function loadData()
    {
        // Example: Load data from a 'settings' table
        $this->_data = (new Query())
            ->select(['title', 'content'])
            ->from('page')
            ->where(['code' => 'global'])
            ->indexBy('title')
            ->all();
    }

    public function get($key, $default = null)
    {
        return isset($this->_data[$key]) ? $this->_data[$key]['content'] : $default;
    }

    public function set($key, $value)
    {
        if (isset($this->_data[$key])) {
            $this->_data[$key]['content'] = $value;
            // Optionally, update the database here
        }
    }
}
