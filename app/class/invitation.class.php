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
     * @param int $page 指定数据offset
     * @param int $page_size 指定数据条数
     * @return mixed
     */
    public function getItems($filter="", $page=1, $page_size=10){
        return $this->dbc->get($this->table, $filter, $page * $page_size, $page_size);
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