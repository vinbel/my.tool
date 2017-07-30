<?php
namespace core\m_controller;

class m_controller {
    /**
     * @var \core\m_router\m_router;
     */
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
    public $debug = false;

    public function __construct()
    {
        if(defined('DEBUG')) {
            $this->debug = DEBUG;
        }
    }

    /**
     * load module
     * @param $name string module name
     */
    public function load_module($name) {
        $this->_module_name = $name;
        $file = WEB_ROOT . 'module/'. $name . '/index.php';

        try {
            require_once $file;
            $module_name = $name . '_module';
            $this->_module = new $module_name($name);
        } catch(\Exception $e) {
            $this->out_error($e);
        }
    }

    /**
     * @param $name
     * @param string $module
     * @return \core\m_model\m_model
     */
    public function load_model($name, $module = '') {

        if(empty($module)) $module = $this->_module_name;

        $file = WEB_ROOT . 'module/' . $module . '/model/' . $name . '.php';

        try {
            require_once $file;
            $model_name = $name . '_model';
            return new $model_name();
        } catch(\Exception $e) {
            $this->out_error($e);
        }

    }

    /**
     * merge view var
     * @param $view
     * @param array $param
     */
    public function view($view, $param = array()) {
        if(!$this->_view) {
            $this->init_view();
        }

        $this->out_str .= $this->_view->load_view($view, $param);
    }

    /**
     * load header
     * @param array $param
     */
    public function load_header_view($param = array()) {
        if(!$this->_view) {
            $this->init_view();
        }

        $this->out_str .= $this->_view->load_view($this->_module_name . '/' . $this->_module->tmp_header, $param);
    }

    /**
     * load footer
     * @param array $param
     */
    public function load_footer_view($param = array()) {
        if(!$this->_view) {
            $this->init_view();
        }

        $this->out_str .= $this->_view->load_view($this->_module_name . '/' . $this->_module->tmp_footer, $param);
    }

    /**
     * init var $view
     */
    public function init_view() {
        $this->_view = new \core\m_view\m_view();
    }

    /**
     * outer all display
     */
    public function display() {
        echo $this->out_str;
        exit;
    }

    /**
     * json outer
     * @param $param
     */
    public function json_view($param) {
        $this->out_str = json_encode($param);
    }

    /**
     * text outer
     * @param $text
     */
    public function text_view($text) {
        $this->out_str .= $text;
    }

    public function out_error(\Exception $e) {
        if($this->debug) {
            log_to('error info:' . date('Y-m-d H:i:s') . ' start-----------------------------'. "\n" . var_export($e->getMessage(), 1) ."\n end ----------------------------------------------------------\n" , 'controller/' . $this->_module . '/' . $this->router->controller);
        }

        echo $e->getMessage();
        exit;
    }

    public function out_csv() {

    }

    /**
     * create url
     * @param string $url 'module/controller/action'
     * @param array $param
     * @param int $type
     *  case 1 index.php?m=x&c=x&a=x
     *  case 2 index.php?r=/m/c/a
     *  case 3 /m/c/a/p1/p1v
     * @return string
     */
    public function create_url($url, $param = array(), $type = 3) {
        $url = ltrim($url, '/');
        $url_arr = explode('/', $url);
        $len = count($url_arr);

        if($len < 3) {
            return '';
        }

        for ($i = 3; $i < $len; $i += 2) {
            $v_key = $i + 1;

            if(isset($url_arr[$v_key])) {
                $param[$url_arr[$i]] = $url_arr[$v_key];
            } else {
                $param[$url_arr[$i]] = '';
            }
        }

        $new = '';

        switch ($type) {
            case 1:
                $new = "/index.php?m={$url_arr[0]}&c={$url_arr[1]}&a={$url_arr[2]}";
                break;
            case 2:
                $new = "/index.php?r={$url_arr[0]}/{$url_arr[1]}/{$url_arr[2]}";
                break;
            case 3:
                $new = "/{$url_arr[0]}/{$url_arr[1]}/{$url_arr[2]}";
                break;
            default:
                break;
        }

        switch ($type) {
            case 1:
            case 2:
                foreach ($param as $pk => $pv) {
                    $new .= "&{$pk}={$pv}";
                }
                break;
            case 3:
                foreach ($param as $pk => $pv) {
                    $new .= "/{$pk}/{$pv}";
                }
                break;
            default:
                break;
        }

        return $new;

    }

}
