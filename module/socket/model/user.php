<?php

class user_model extends \core\m_model\m_model {
    public $table_name = 'user';
    public $_pk = 'id';


    public function get_user_by_name($username) {
        $sql = "SELECT user_id,user_name,salt FROM yt_user WHERE user_name='{$username}';";
        return $this->find_by_sql($sql);
    }

    public function check_user_by_password($username, $password) {
        $user = $this->get_user_by_name($username);

        if(!$user) return false;

        $salt = $user['salt'];
        $password = md5(md5($password). $salt);
        $sql = "SELECT * FROM yt_user WHERE user_name='{$username}' AND user_password='{$password}';";
        return $this->find_by_sql($sql);
    }

    public function get_user_by_id($user_id) {
        $sql = "SELECT user_id,user_name FROM yt_user WHERE user_id='{$user_id}';";
        return $this->find_by_sql($sql);
    }
}