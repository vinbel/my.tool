<?php
namespace core\m_controller;

class m_controller {
    public $router;

    public function __construct()
    {

    }

    /**
     * @param $name
     * @param string $module
     * @return \core\m_model\m_model
     */
    public function load_model($name, $module = 'index') {
        require_once WEB_ROOT . 'module/' . $module . '/model/' . $name . '.php';
        $model_name = $name . '_model';
        return new $model_name();
    }

}
