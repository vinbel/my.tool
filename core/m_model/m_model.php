<?php
namespace core\m_model;

class m_model {

    /**
     * @var \core\m_db\m_db
     */
    public $db;
    public $db_name = 'default';
    public $table_name = '';
    public $_pk = 'id';
    public function __construct()
    {
        $this->load_db();
    }

    /**
     * load db
     */
    public function load_db() {
        $this->db = new \core\m_db\m_db($this->db_name);
    }

    /**
     * update
     * @param $param
     * @param $data
     * @return bool|int
     */
    public function update($param, $data) {
        return$this->db->update($this->table_name, $param, $data);
    }

    /**
     * insert
     * @param $data
     * @return bool|int|string
     */
    public function insert($data) {
        return $this->db->insert($this->table_name, $data);
    }

    /**
     * find one by param
     * @param $param
     * @param string $search
     * @param string $order
     * @return array|bool|mixed
     */
    public function find($param, $search = '*', $order = '') {

        $sql = "SELECT " . $search . " FROM `{$this->table_name}` WHERE ";

        if(empty($param)) {
            $param = array();
            $sql = rtrim($sql, ' WHERE');
        } elseif(is_array($param)) {
            foreach($param as $k => $v) {
                if($v === false) {
                    $sql = "{$k} AND ";
                } else {
                    $sql .= " `{$k}`='{$v}' AND ";
                }
            }

            $sql = rtrim($param, 'AND ');
        } else {
            $sql .= " `{$this->_pk}`='{$param}'";
        }

        if($order) {
            $sql .= " ORDER BY {$order} ";
        }

        return $this->db->fetch_one($sql, $param);
    }

    /**
     * find one by sql
     * @param $sql
     * @return array|bool|mixed
     */
    public function find_by_sql($sql) {
        return $this->db->fetch_one($sql);
    }

    /**
     * find all by param
     * @param $param
     * @param string $search
     * @param string $order
     * @param string $limit
     * @return array|bool|mixed
     */
    public function find_all($param, $search = '*', $order = '', $limit = '') {

        $sql = "SELECT " . $search . " FROM `{$this->table_name}` WHERE ";

        if(empty($param)) {
            $param = array();
            $sql = rtrim($sql, ' WHERE');
        } elseif(is_array($param)) {
            foreach($param as $k => $v) {
                if($v === false) {
                    $sql = "{$k} AND ";
                } else {
                    $sql .= " `{$k}`='{$v}' AND ";
                }
            }

            $sql = rtrim($sql, 'AND ');
        } else {
            $sql .= " `{$this->_pk}`='{$param}'";
        }

        if($order) {
            $sql .= " ORDER BY {$order} ";
        }

        if($limit) {
            $sql .= " LIMIT {$limit}";
        }

        return $this->db->fetch_all($sql, $param);
    }

    /**
     * find all by sql
     * @param $sql
     * @return array|bool|mixed
     */
    public function find_all_by_sql($sql) {
        return $this->db->fetch_all($sql);
    }

    /**
     * get sql limit string
     * @param int $page
     * @param int $page_size
     * @return string
     */
    public function get_limit($page = 1, $page_size = 10) {
        $start = ($page - 1) * $page_size;
        return $limit = $start . ',' . $page_size;
    }

}
