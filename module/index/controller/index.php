<?php

class index_controller extends \core\m_controller\m_controller
{
    function act_index() {
        echo "hellow, world!";
        $model = new \core\m_model\m_model();
        $data = $model->db->fetch_all('select * from pgot_plan where report_id=? and plan=?', array(1,'呵呵呵呵'));
//        $data = $model->db->update('pgot_school', array('id' => '5'), array('name' => '111'));
//        $data = $model->db->insert('pgot_school', array('name' => '111'));
        var_dump($data);

    }
}