<?php
namespace lib\m_curl;

/**
 * simple curl just so so
 * Class m_curl
 * @package lib\m_curl
 */
class m_curl {
    /**
     * @var resource
     */
    public $curl;
    public $data = array();
    public $url = '';
    public $header = array();
    public $response = '';
    public $timeout = 100;
    public $cookie = array();
    public $cookie_str = '';
    public $method = '1'; //1 get 2 post
    public $file_name = '';
    public $flie_path = './';
    public $file_type = 'tmp';
    public $ignore_https = 1;

    public function __construct()
    {
        $this->curl = curl_init();
    }

    public function post($url, $data = array(), $header = array()) {
        $this->url = $url;
        $this->method = 2;
        $this->data = array_merge($this->data, $data);
        $this->header = array_merge($this->header, $header);
        $this->exec();
    }

    public function get($url, $header = array()) {
        $this->url = $url;
        $this->header = $header;
        $this->exec();
    }

    public function download($url, $file_name = null, $path = './', $method = 1, $data =array(), $header = array()) {
        $this->url = $url;
        $this->method = $method;
        $this->data = array_merge($this->data, $data);
        $this->header = $header;
        $this->exec();

        if(!$this->file_name) {
            $this->file_name = $this->make_file_name();
        }

        $this->flie_path = $this->make_file_path($path);
        $this->save_file();
    }

    public function make_file_name() {
        $this->get_file_type();
        return date('Y_m_d_H_i_s'.rand(10000, 99999)) . '.' . $this->file_type;
    }

    public function get_file_type() {

        $path = pathinfo($this->url);
        $file_type = isset($path['extension']) ? $path['extension'] : '';

        if($file_type) {
            $this->file_type = $file_type;
        }

    }

    public function make_file_path($path) {
        return $path = rtrim($path, '/') . '/';
    }

    public function save_file() {
        $fo = fopen($this->flie_path.$this->file_name, 'w');
        fwrite($fo, $this->response);
        fclose($fo);
    }

    public function set_url($url) {
        $this->url = $url;
    }

    public function set_time_out($timeout = 0) {
        $this->timeout = $timeout;
    }

    public function set_data($data) {
        $this->data = array_merge($this->data, $data);
    }

    public function set_cookie($data) {
        $this->cookie = array_merge($this->cookie, $data);
    }

    public function set_opt($key, $val) {
        curl_setopt($this->curl, $key, $val);
    }

    public function set_header($header) {
        $this->header = array_merge($this->header, $header);
    }

    public function get_info($op = null) {
        return curl_getinfo($this->curl, $op);
    }

    public function exec() {
        $this->set_options();
        $this->response = curl_exec($this->curl);
    }

    public function set_options() {
        $this->check_url();
        $this->set_opt(CURLOPT_URL, $this->url);
        $this->set_opt(CURLOPT_TIMEOUT, $this->timeout);
        $this->set_opt(CURLOPT_HTTPHEADER, $this->header);
        $this->set_opt(CURLOPT_RETURNTRANSFER, 1);
        $this->to_set_cookie();

        if($this->method == '2') {
            $this->set_opt(CURLOPT_POST, 1);
            $this->set_opt(CURLOPT_POSTFIELDS, $this->data);
        }
    }

    public function check_url() {
        $preg = '/^https(.+)/';

        if(preg_match($preg, $this->url) && $this->ignore_https) {
            $this->set_opt(CURLOPT_SSL_VERIFYPEER, false);
        }

    }

    public function to_set_cookie() {
        if(is_array($this->cookie)) {
            foreach ($this->cookie as $k => $v) {
                $this->cookie_str .= "{$k}={$v};";
            }
        } else {
            $this->cookie_str = $this->cookie;
        }

        $this->set_opt(CURLOPT_COOKIE, $this->cookie_str);
    }

    public function to_arr() {
        return json_decode($this->response, JSON_OBJECT_AS_ARRAY);
    }

    public function __destruct()
    {
        curl_close($this->curl);
    }
}