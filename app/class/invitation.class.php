<?php

require_once("dbc.class.php");

class Invitation {
    private $dbc;
    private $table = "invitations";

    public function __construct() {
        $this->dbc = new DatabaseConnection("localhost", "root", "123456", "bookshelf");
    }

    /**
     * 获取邀请码
     *
     * @return mixed
     */
    public function get() {
        return $this->dbc->get($this->table);
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
}