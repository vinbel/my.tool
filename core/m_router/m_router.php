<?php
namespace core\m_router;

class m_router{
    public $request = array();
    public $module = 'index';
    public $controller = 'index';
    public $action = 'index';
    public $route = 'index/index/index';
    public $paths = array(
        'module' => 'index',
        'controller' => 'index',
    );

    public function __construct()
    {
        $_REQUEST = $this->decode_arr($_REQUEST);
        $_GET = $this->decode_arr($_GET);
        $this->request = $_REQUEST;

        if( isset($this->request['m']) &&  isset($this->request['c']) &&  isset($this->request['a'])) {
            $this->module = $this->request['m'];
            $this->controller = $this->request['c'];
            $this->action = $this->request['a'];
        } elseif(isset($this->request['r'])) {
            $this->route = str_replace('\\', '/', $this->request['r']);
            $this->route = ltrim($this->route, '/');

            $this->get_full_act();
        }else {

        }
//        print_r($_REQUEST);
//        print_r($_GET);
//        print_r($_POST);
//        var_dump($this->module, $this->controller, $this->action);
    }

    public function run() {
        $file = MODULE . $this->module .'/controller/'. $this->controller . '.php';

        try{
            if(!is_file($file)) {
                throw new \Exception("controller is not found!");
            }

            require_once $file;
            $act = 'act_' . $this->action;
            $c = $this->controller .'_controller';
            $controller = new $c;
            $controller->router = $this;
            $controller->load_module($this->module);

            if(!method_exists($controller, $act)) {
                throw new \Exception("action is not found!");
            }

            $controller->$act();
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }

    }

    public function get_full_act() {
        unset($_REQUEST['r'], $_GET['r']);
        $route = $this->route;
        $full = explode('/', $route);
        $level = count($full);

        if(!$full[0]) {
            $_REQUEST['m'] = $_GET['m'] = $this->module;
            $_REQUEST['c'] = $_GET['c'] = $this->controller;
            $_REQUEST['a'] = $_GET['a'] = $this->action;
            return;
        }

        switch ($level) {
            case 0:
                break;
            case 1:
                $this->action = $full[0];
                break;
            case 2:
                $this->controller = $full[0];
                $this->action = $full[1];
                break;
            case 3:
                $this->module = $full[0];
                $this->controller = $full[1];
                $this->action = $full[2];
                break;
            case $level >3:
                $this->module = $full[0];
                $this->controller = $full[1];
                $this->action = $full[2];

                for ($i = 3; $i < $level; $i += 2) {
                    $v_key = $i + 1;

                    if(isset($full[$v_key])) {
                        $_REQUEST[$full[$i]] = $_GET[$full[$i]] = $full[$v_key];
                    } else {
                        $_REQUEST[$full[$i]] = $_GET[$full[$i]] = '';
                    }
                }

                break;
            default:
                break;
        }

        if(!$this->module) $this->module = 'index';

        if(!$this->controller) $this->controller = 'index';

        if(!$this->action) $this->action = 'index';

        $_REQUEST['m'] = $_GET['m'] = $this->module;
        $_REQUEST['c'] = $_GET['c'] = $this->controller;
        $_REQUEST['a'] = $_GET['a'] = $this->action;

        return;
    }

    public function decode_arr($arr) {
        foreach ($arr as $k => $value) {
            $arr[$k] = urldecode($value);
        }

        return $arr;
    }

}