<?php

require_once("dbc.class.php");

/**
 * 数据操作类
 */
class DatabaseManipulate {
    protected static $conn;
    protected $table;
    protected $query;

    public function __construct($table) {
        $dbc = new DatabaseConnection(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
        self::$conn = $dbc->get_connection();
        !$table and die("Name of the table to be manipulated on is REQUIRED.");
        $this->set_table($table);
    }

    /**
     * 设置操作表
     *
     * @param string $table
     */
    public function set_table($table) {
        $this->table = $table;
    }


    /* ======================================================
     * 数据操作方法
     * ====================================================== */


    /**
     * 查询数据
     *
     * @param string $field 选择字段
     * @param string $table
     * @return $this
     */
    public function select($field, $table="") {
        empty($table) and $table = $this->table;
        $this->query = "SELECT $field FROM $table WHERE 1";
        return $this;
    }

    /**
     * 插入数据
     *
     * @param array $insert_data
     * @param string $table
     * @return $this
     */
    public function insert($insert_data, $table="") {
        empty($table) and $table = $this->table;
        if (is_array($insert_data) && count($insert_data) > 0) {

            $columns_raw = array_keys($insert_data);
            $columns_clean = array();
            foreach($columns_raw as $column) {
                array_push($columns_clean, "`" . $column . "`");
            }
            $columns = join(",", $columns_clean);

            $values_raw = array_values($insert_data);
            // 过滤输入
            $values_clean = array();
            foreach ($values_raw as $value) {
                array_push($values_clean, "'" . $this->escape($value) . "'");
            }

            $values = join(",", $values_clean);
            $this->query = "INSERT INTO $table ($columns) VALUES($values)";
        }
        return $this;
    }

    /**
     * 更新数据
     *
     * @param array $update_data
     * @param string $table
     * @return $this
     */
    public function update($update_data, $table="") {
        empty($table) and $table = $this->table;
        if (is_array($update_data) && count($update_data) > 0) {
            $index = 0;
            $format_data = "";
            foreach ($update_data as $column=>$value) {
                $value = self::$conn->real_escape_string($value);
                $format_data = $format_data . ($index == 0 ?
                    "`$column`='$value'" :
                    ", `$column`='$value'");
                $index++;
            }
            $this->query = "UPDATE $table SET $format_data WHERE 1";
        }
        return $this;
    }

    /**
     * 删除数据
     *
     * @param string $table
     * @return $this
     */
    public function remove($table="") {
        empty($table) and $table = $this->table;
        $this->query = "DELETE FROM $table WHERE 1 ";
        return $this;
    }

    public function where($filter) {
        $this->query .= " AND $filter";
        return $this;
    }

    /**
     * 结果排序，要先于LIMIT调用
     *
     * @param $column
     * @return $this
     */
    public function order_by($column) {
        $this->query .= " ORDER BY $column DESC";
        return $this;
    }
    public function limit($row_count, $offset=0) {
        $this->query .= " LIMIT $offset, $row_count";
        return $this;
    }

    /**
     * 执行$this->query所设定的查询语句
     *
     * @return mixed
     */
    public function execute() {
        self::$conn->query("SET NAMES 'utf8'");
        $query_result = false;
        //echo $this->query . "<br />";
        !empty($this->query) and $query_result = self::$conn->query($this->query);
        return $query_result;
    }



    /* ======================================================
     * 快捷方法
     * ====================================================== */

    /**
     * 获取单条数据的快捷方法
     *
     * @param string $key
     * @param string $value
     * @param string $table
     * @return mixed
     */
    public function get_item($key, $value, $table="") {
        empty($table) and $table = $this->table;
        return $this->select("*", $table)
                    ->where("$key='$value'")
                    ->order_by("id")
                    ->limit(1)
                    ->execute();
    }

    /**
     * 获取多条数据的快捷方法
     *
     * @param $row_count
     * @param $page
     * @param string $table
     * @return mixed
     */
    public function get_items($row_count, $page, $table="") {
        empty($table) and $table = $this->table;
        return $this->select("*", $table)
                    ->order_by("id")
                    ->limit($row_count, $page - 1)
                    ->execute();
    }

    /**
     * 获取表数据的总数
     *
     * @param string $where
     * @return int
     */
    public function get_total($where="1") {
        $total = 0;
        $query_result = $this->select("COUNT(*) AS total", $this->table)->where($where)->execute();
        $query_result and $total = $query_result->fetch_object()->total;
        return $total;
    }


    /* ======================================================
     * 辅助函数
     * ====================================================== */

    /**
     * 获取最后一个insert语句返回的id值
     *
     * @return mixed
     */
    public function get_last_id() {
        return self::$conn->insert_id;
    }

    /**
     * 获取最后一个mysql执行语句的错误描述
     *
     * @return string
     */
    public function get_last_error() {
        return self::$conn->error;
    }

    /**
     * 过滤string
     *
     * @param $string
     * @return string
     */
    public function escape($string) {
        return self::$conn->real_escape_string($string);
    }

    /**
     * 释放数据库链接
     */
    public function release() {
        self::$conn->close();
    }
}