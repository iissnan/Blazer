<?php
class DatabaseConnection
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
    public function __construct($hostname, $username, $password, $database) {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        $this->connect();
    }

    /**
     * 连接数据库
     */
    public function connect() {
        $db = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        if (mysqli_connect_errno()) {
            die("Error: Could not to connect to database.");
        }
        $this->db = $db;
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
     * 获取$table下的数据，默认限制10条
     *
     * @param $table
     * @param string $filter
     * @param int $num
     * @return mixed
     */
    public function get($table, $filter="", $num=10) {
        $query = "SELECT * FROM `$table` LIMIT $num $filter";
        return $this->query($query);
    }

    /**
     * 向$table插入数据
     *
     * @param $table
     * @param string $value
     * @param string $field
     */
    public function insert($table, $value, $field="") {
        $query = "INSERT INTO `$table` $field VALUES($value)";
        $this->query($query);
    }

    /**
     * 删除$table下的数据
     *
     * @param $table
     * @param string $filter
     */
    public function remove($table, $filter="") {
        $query = "DELETE FROM `$table` $filter";
        $this->query($query);
    }

    /**
     * 执行查询
     *
     * @param $query
     * @return mixed
     */
    public function query($query) {
        $result = $this->db->query($query);
        if ($result === false) {
            die("Error: Could not execute this query: " . $query);
        } else {
            return $result;
        }
    }

    /**
     * 释放数据库链接
     */
    public function close() {
        $this->db->close();
    }
}
