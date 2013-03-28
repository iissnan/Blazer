<?php
class Database
{
    private $hostname;
    private $username;
    private $password;
    private $database;

    private $db;


    /**
     * 配置数据库连接参数
     *
     * @param {string} $hostname
     * @param {string} $username
     * @param {string} $password
     * @param {string} $database
     */
    public function __constructor($hostname, $username, $password, $database) {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    /**
     * 连接数据库
     */
    public function connect() {
        @ $db = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        if (mysqli_connect_errno()) {
            die("Error: Could not to connect to database.");
        } else {
            $this->db = $db;
        }
    }

    /**
     * 选择数据库
     *
     * @param $database
     */
    public function use_database($database) {
        $this->db->select_db($database);
    }

    /**
     * 执行查询
     *
     * @param $query
     * @return mixed
     */
    public function query($query) {
        $result = $this->db->query($query);
        if ($result) {
            return $result;
        } else {
            die("Error: Could not execute this query: " + $query);
        }
    }

    /**
     * 释放数据库链接
     */
    public function close() {
        $this->db->close();
    }
}
