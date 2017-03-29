<?php
namespace core\m_db;
$db = include_once WEB_ROOT . '/conf/db.conf.php';
class m_db {

    /**
     * @var \PDO
     */
    public $db;
    public function __construct($db_name)
    {
        $db = $this->get_db($db_name);
        $dns = $db['type'] . ':host=' . $db['host'] . ';dbname=' . $db['database'];
        $this->db = new \PDO($dns, $db['user'], $db['pwd'], array());
        $this->db->exec('set names '. $db['charset']);
    }

    public function get_db($db_name = 'default') {
        global $db;

        if(isset($db[$db_name])) {
            return $db[$db_name];
        }

        return $db['default'];
    }

    public function get_last_insert_id() {
        return $this->db->lastInsertId();
    }

}
