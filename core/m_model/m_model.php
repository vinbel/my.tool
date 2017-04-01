<?php
namespace core\m_model;

class m_model {

    public $db;
    public $db_name = 'default';
    public $table_name = '';
    public function __construct()
    {
        $this->db = new \core\m_db\m_db($this->db_name);
    }

    public function update() {

    }

}
