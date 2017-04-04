<?php
namespace core\m_db;
class m_db {

    /**
     * @var \PDO
     */
    public $db;
    public $debug = false;
    public $db_name = 'defalut';
    public function __construct($db_name)
    {
        $this->db_name = $db_name;
        $db = $this->get_db($db_name);
        $dns = $db['type'] . ':host=' . $db['host'] . ';dbname=' . $db['database'];

        try{
            $this->db = new \PDO($dns, $db['user'], $db['pwd'], array());
            $this->db->exec('set names '. $db['charset']);
        } catch (\Exception $e) {
            exit('database connect lost!');
        }


        if(defined('DEBUG')) {
            $this->debug = DEBUG;
        }
    }

    /**
     * get database info
     * @param string $db_name
     * @return mixed
     */
    public function get_db($db_name = 'default') {
        $db = get_db();

        if(isset($db[$db_name])) {
            return $db[$db_name];
        }

        return $db['default'];
    }

    /**
     * get last insert id
     * @return string
     */
    public function get_last_insert_id() {
        return $this->db->lastInsertId();
    }

    /**
     * query data
     * @param $sql
     * @param array $param
     * @param string $return_type
     * @return array|bool|mixed
     */
    public function query($sql, $param = array(), $return_type = 'row') {
        return $data = $this->return_result($sql, $param, $return_type, 'all');
    }

    /**
     * fetch one
     * @param $sql
     * @param array $param
     * @param string $return_type
     * @return array|bool|mixed
     */
    public function fetch_one($sql, $param = array(), $return_type = 'row') {
        return $data = $this->return_result($sql, $param, $return_type, 'one');
    }

    /**
     * fetch all
     * @param $sql
     * @param array $param
     * @param string $return_type
     * @return array|bool|mixed
     */
    public function fetch_all($sql, $param = array(), $return_type = 'row') {
        return $data = $this->return_result($sql, $param, $return_type, 'all');;
    }

    /**
     * get num
     * @param $sql
     * @param array $param
     * @return array|bool|mixed
     */
    public function fetch_num($sql, $param = array()) {
        $data = $this->return_result($sql, $param, 'array', 'one');

        if($data) {
            return $data[0];
        }

        return $data;
    }

    /**
     * get data
     * @param $sql
     * @param array $param
     * @param $return_type
     * @param string $return_way
     * @return array|bool|mixed
     */
    public function return_result($sql, $param = array(), $return_type, $return_way = 'all') {
        $return_type = $this->get_return_type($return_type);

        try {
            if($param){
                $query = $this->db->prepare($sql);
                $query->execute($param);

                if(!$query) {
                    throw new \Exception(var_export($this->db->errorInfo(), 1));
                }

                if($return_way == 'all') {
                    $data = $query->fetchAll($return_type);
                } else {
                    $data = $query->fetch($return_type);
                }

            } else {
                $query = $this->db->query($sql, $return_type);

                if(!$query) {
                    throw new \Exception(var_export($this->db->errorInfo(), 1));
                }

                if($return_way == 'all') {
                    $data = $query->fetchAll();
                } else {
                    $data = $query->fetch();
                }
            }

        } catch (\Exception $e) {
            $query = false;
            $data = false;
        }


        if($this->debug) {
            $out_sql = $sql;

            if($query) {
                $out_sql = $query->queryString;
            }

            log_to('sql info:' . date('Y-m-d H:i:s') . ' start-----------------------------'. "\n" . var_export($out_sql, 1) ."\n end ----------------------------------------------------------\n" , 'db/' . $this->db_name);

            if($data === false) {
                log_to('sql error:' . date('Y-m-d H:i:s') . ' start-----------------------------'. "\n" . var_export($this->db->errorInfo(), 1) ."\n end ----------------------------------------------------------\n", 'db/' . $this->db_name);
            }
        }

        return $data;
    }

    /**
     * get result type
     * @param $return_type
     * @return int
     */
    public function get_return_type($return_type) {

        switch ($return_type) {
            case 'row':
                $rtn = \PDO::FETCH_ASSOC;
                break;
            case 'array':
                $rtn = \PDO::FETCH_NUM;
                break;
            case 'all':
                $rtn = \PDO::FETCH_BOTH;
                break;
            default:
                $rtn = \PDO::FETCH_ASSOC;
                break;
        }

        return $rtn;
    }

    public function beginTransaction() {
        $this->db->beginTransaction();
    }

    public function commit() {
        $this->db->commit();
    }

    public function rollBack() {
        $this->db->rollBack();
    }

    /**
     * exec sql no result
     * @param $sql
     * @return int
     */
    public function exec($sql) {
        $result = $this->db->exec($sql);

        if($this->debug) {
            $out_sql = $sql;
            log_to('sql info:' . date('Y-m-d H:i:s') . ' start-----------------------------'. "\n" . var_export($out_sql, 1) ."\n end ----------------------------------------------------------\n" , 'db/' . $this->db_name);

            if($result === false) {
                log_to('sql error:' . date('Y-m-d H:i:s') . ' start-----------------------------'. "\n" . var_export($this->db->errorInfo(), 1) ."\n end ----------------------------------------------------------\n", 'db/' . $this->db_name);
            }
        }

        return $result;
    }

    /**
     * update
     * @param $table string
     * @param $param array where
     * @param $data array data
     * @return bool|int
     */
    public function update($table, $param, $data) {
        $set_sql = '';
        $where_sql = '';

        foreach ($data as $dk => $dv) {
            $set_sql .= " `{$dk}`='{$dv}', ";
        }

        foreach ($param as $pk => $pv) {
            $where_sql .= " `{$pk}`='{$pv}' AND ";
        }

        $set_sql = rtrim($set_sql, ', ');
        $where_sql = rtrim($where_sql, 'AND ');

        if(!($set_sql && $where_sql)) {
            return false;
        }

        $sql = 'UPDATE ' . $table . ' SET ' .$set_sql . ' WHERE ' . $where_sql;
        return $this->exec($sql);
    }

    /**
     * insert
     * @param $table string table
     * @param $data array data
     * @return bool|int|string
     */
    public function insert($table, $data) {
        $set_sql = '';

        foreach ($data as $dk => $dv) {
            $set_sql .= " `{$dk}`='{$dv}', ";
        }

        $set_sql = rtrim($set_sql, ', ');

        if(!($set_sql)) {
            return false;
        }

        $sql = 'INSERT INTO ' . $table . ' SET ' .$set_sql;
        $rs = $this->exec($sql);

        if($rs) {
            $rs = $this->get_last_insert_id();
        }

        return $rs;
    }



}
