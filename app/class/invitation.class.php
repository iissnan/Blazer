<?php

require_once("dbc.class.php");

class Invitation {
    private $dbc;
    private $table = "invitations";

    public function __construct() {
        $this->dbc = new DatabaseConnection("localhost", "root", "123456", "bookshelf");
    }

    /**
     * 获取多条数据
     *
     * @param string $filter 过滤语句
     * @param int $row_count 指定数据offset
     * @param int $offset 指定数据条数
     * @return mixed
     */
    public function getItems($row_count, $offset, $filter="number > 0") {
        return $this->dbc->get($this->table, $filter, $row_count, ($offset - 1) * $row_count);
    }

    /**
     * 获取单个数据
     *
     * @param string $value
     * @return mixed
     */
    public function getItem($value) {
        return $this->dbc->get($this->table, "value = '$value'");
    }

    /**
     * 获取数量大于零的数据总数
     *
     * @return boolean
     */
    public function total() {
        $result = $this->dbc->count($this->table, "number > 0");
        return !$result ? 0 : $result->fetch_object()->total;
    }

    /**
     * 添加邀请码
     *
     * @param $value
     * @param $number
     * @return bool
     */
    public function add($value, $number) {
        $result = $this->dbc->insert(
            $this->table,
            array("value", "number"),
            array($value, $number)
        );
        return $result;
    }

    public function minus($value) {
        $inv = $this->getItem($value);
        list(, , $inv_num) = $inv->fetch_array();
        $result = $this->dbc->update(
            $this->table,
            array("number" => $inv_num - 1),
            "value = '$value'"
        );
        return $result;
    }
}