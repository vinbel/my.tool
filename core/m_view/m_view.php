<?php
namespace core\m_view;

class m_view {

    public function __construct()
    {
    }

    /**
     * load view
     * @param $name
     * @param $param
     * @return string
     */
    public function load_view($name, $param) {
        $module = 'index';
        $view_arr = explode('/', $name);
        $view_len = count($view_arr);

        if($view_len == 1) {

        } elseif($view_len == '2') {
            $module = $view_arr[0];
            $name = $view_arr[1];
        }

        ob_start();
        $file =  WEB_ROOT . 'module/' . $module . '/view/' . $name . '.php';

        if(!file_exists($file)) {
            return '';
        }

        extract($param);
        include $file;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

}
