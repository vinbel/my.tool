<?php

class index_controller extends \core\m_controller\m_controller
{
    public $return_type = 2;
    function act_index() {
//        echo "hellow, world!";
//        $model = $this->load_model('user');
//        $limit = $model->get_limit(1, 10);
//        $data = $model->find_all('', "*", 'id desc', $limit);
//        $data = $model->find('', "*");
//        var_dump($data);
//        $data = $model->db->fetch_all('select * from `user` where id=? and name=?', array(1,'111'));
//        $data = $model->db->update('user', array('id' => '5'), array('name' => '111'));
//        var_dump($data);
//        $data = $model->db->insert('user', array('name' => '111'));
//        var_dump($data);
//        $this->load_header_view();
//        $this->view('index/index');
//        $this->load_footer_view();
//        $this->json_view(array(11 => ''));
        $this->display();
    }

    function act_haha() {
        $this->text_view("haha");
        $this->display();
    }

    function act_login() {
        $username = $this->input_check('username', '', 1, 'str', '用户名');
        $password = $this->input_check('password', '', 1, 'str', '密码');

        $arr = array(
            'admin' => array(
                'username' => 'admin',
                'password' => 'admin',
                'user_id' => '1',
                'token' => '1234'
            ),
            'test' => array(
                'username' => 'test',
                'password' => 'test',
                'user_id' => '1',
                'token' => '111'
            ),
        );

        if(isset($arr[$username]) && $arr[$username]['password'] == $password) {
            $this->json_success(array('token' => $arr[$username]['token']));
        } else {
            $this->json_error('登录失败');
        }
//        $this->json_view($rtn);
        $this->display();
    }

    function act_register() {
        $username = $this->input_check('username', '', 1, 'str', '用户名');
        $password = $this->input_check('password', '', 1, 'str', '密码');
        $re_password = $this->input_check('re_password', '', 1, 'str', '确认密码');

        if($password != $re_password) {
			$this->json_error("两次密码不一致");
			$this->display();

		}

//
//
//        $arr = array(
//            'admin' => array(
//                'username' => 'admin',
//                'password' => 'admin',
//                'user_id' => '1',
//                'token' => '1234'
//            ),
//            'test' => array(
//                'username' => 'test',
//                'password' => 'test',
//                'user_id' => '1',
//                'token' => '111'
//            ),
//        );
//
//        if(isset($arr[$username]) && $arr[$username]['password'] == $password) {
//            $this->json_success(array('token' => $arr[$username]['token']));
//        } else {
//            $this->json_error('登录失败');
//        }
//        $this->json_view($rtn);
        $this->json_success(array());

        $this->display();
    }
}