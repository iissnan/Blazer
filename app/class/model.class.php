<?php

require_once("dbc.class.php");

/**
 * Model Base Class
 */
class Model {
    public $dbc;
    protected $table;

    public function __construct($table) {
        $table and $this->table = $table or die("表格未设置");
        $this->dbc = new DatabaseConnection("localhost", "root", "123456", "bookshelf");
    }

    public function setTable($table) {
        $table and $this->table = $table;
    }

    /*
     * 开始一个事务
     */
    public function startTransaction() {
        $this->dbc->db->autocommit(false);
    }

    public function commit(){
        $this->dbc->db->commit();
        return true;
    }

    public function rollback() {
        $this->dbc->db->rollback();
        return true;
    }

    /**
     * 添加数据
     *
     * @param array $data
     * @return mixed
     */
    public function add($data) {
        $result = $this->dbc->insert(
            $this->table,
            array_keys($data),
            array_values($data)
        );

        return $result;
    }


    /**
     * 获取数据总数
     *
     * @param string $filter 过滤条件
     * @param array $join_tables 关联查询表
     * @return number
     */
    public function total($filter="", $join_tables=array()) {
        $result = $this->dbc->count($this->table, $filter, $join_tables);
        return !$result ? 0 : $result->fetch_object()->total;
    }

    /**
     * 获取多个数据
     *
     * @param string $filter 过滤条件
     * @param number $row_count 数量
     * @param number $offset 偏移量
     * @return mixed
     */
    public function getItems($row_count, $offset, $filter){
        return $this->dbc->get($this->table, $row_count, ($offset - 1) * $row_count, $filter);
    }

    /*
     * 获取关联查询的数据
     *
     * @param array $join_table
     * @param string $filter
     * @param integer $row_count
     * @param integer $offset
     */
    public function getJoinItems($join_tables, $filter, $row_count=100, $offset=1) {
        return $this->dbc->getJoin(
            $this->table,
            join(",", $join_tables),
            $row_count,
            ($offset - 1) * $row_count,
            $filter
        );
    }

    /**
     * 获取指定key => value的数据
     *
     * @param string $key
     * @param string $value
     * @return mixed
     */
    public function getItem($key, $value) {
        $filter = "$key = '$value'";
        return $this->dbc->get($this->table, 1, 0, $filter);
    }

    /**
     * 更新数据
     *
     * @param string $filter 数据过滤条件
     * @param array $data 字段数据
     * @return boolean 执行成功或者失败
     */
    public function update($filter, $data) {
        return $this->dbc->update($this->table, $data, $filter);
    }

    /**
     * @param array $join_tables
     * @param string $filter
     * @param array $data
     * @return bool
     */
    public function updateJoin($join_tables, $filter, $data) {
        return $this->dbc->updateJoin($this->table, join(",", $join_tables), $data, $filter);
    }

    /**
     * 删除数据
     *
     * @param string $filter
     * @return boolean
     */
    public function remove($filter) {
        return $this->dbc->remove($this->table, $filter);
    }

    /**
     * 释放数据库链接
     */
    public function free() {
        $this->dbc->close();
    }
}