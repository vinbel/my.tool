<?php
namespace core\m_controller;

class m_controller {
    public $router;

    public function __construct()
    {
    }

    public function load_model($name, $module = 'index') {
        require_once WEB_ROOT . 'module/' . $module . '/' . $name;
        $model_name = $name . '_model';
        return new $model_name();
    }

}
