<?php

class index_controller extends \core\m_controller\m_controller
{
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
        $this->load_header_view();
        $this->view('index/index', array('a' =>'123'));
        $this->load_footer_view();
        $this->display();
    }
}