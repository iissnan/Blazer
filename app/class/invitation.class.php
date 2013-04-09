<?php

require_once("dbc.class.php");

class Invitation {
    private $dbc;
    private $table = "invitations";

    public function __construct() {
        $this->dbc = new DatabaseConnection("localhost", "root", "123456", "bookshelf");
    }

    public function getItems($page=1, $page_size=10){
        return $this->dbc->get($this->table);
    }

    /**
     * 获取邀请码
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