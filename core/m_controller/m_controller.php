<?php
namespace core\m_controller;

use core\m_view\m_view;

class m_controller {
    public $router;
    /**
     * @var bool|\core\m_view\m_view;
     */
    public $_view = false;
    public $out_str = '';
    /**
     * @var bool|\core\m_module\m_module;
     */
    public $_module = false;
    public $_module_name = '';

    public function __construct()
    {

    }

    public function load_module($name) {
        $this->_module_name = $name;
        require_once WEB_ROOT . 'module/'. $name . '/index.php';
        $module_name = $name . '_module';
        $this->_module = new $module_name($name);
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

    public function view($view, $param = array()) {
        if(!$this->_view) {
            $this->init_view();
        }

        $this->out_str .= $this->_view->load_view($view, $param);
    }

    public function load_header_view($param = array()) {
        if(!$this->_view) {
            $this->init_view();
        }

        $this->out_str .= $this->_view->load_view($this->_module_name . '/' . $this->_module->tmp_header, $param);
    }

    public function load_footer_view($param = array()) {
        if(!$this->_view) {
            $this->init_view();
        }

        $this->out_str .= $this->_view->load_view($this->_module_name . '/' . $this->_module->tmp_footer, $param);
    }

    public function init_view() {
        $this->_view = new \core\m_view\m_view();
    }

    public function display() {
        echo $this->out_str;
        exit;
    }

}
