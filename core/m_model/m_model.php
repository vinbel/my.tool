<?php
namespace core\m_model;

class m_model {

    public $db;
    public function __construct()
    {
        $db_name = 'default';
        $this->db = new \core\m_db\m_db($db_name);
    }

}
