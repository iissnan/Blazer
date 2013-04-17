<?php
class DatabaseConnection {
    private $hostname;
    private $username;
    private $password;
    private $database;
    private $dbc;

    /**
     * 配置数据库连接参数
     *
     * @param string $hostname
     * @param string $username
     * @param string $password
     * @param string $database
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
     *
     * @throws Exception 连接数据库失败
     * @throws Exception 若提供$database，将测试连接$database
     */
    public function connect() {
        try {
            @$dbc = new mysqli($this->hostname, $this->username, $this->password);

            // mysqli::connect_error 需要PHP ver > 5.2.9
            if ($dbc->connect_error) {
                throw new Exception("Error: Could not to connect to MySQL.");
            }
            $this->dbc = $dbc;

            // 数据库选择
            if (isset($this->database)) {
                $this->select_db($this->database);
                if ($dbc->errno) {
                    throw new Exception($dbc->error);
                }
            }

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * 返回数据库连接对象
     *
     * @return object 数据库连接对象
     */
    public function get_connection() {
        return $this->dbc;
    }

    /**
     * 选择数据库
     *
     * @param string $database
     */
    public function select_db($database) {
        $this->dbc->select_db($database);
    }

    /**
     * 释放数据库链接
     */
    public function close() {
        $this->dbc->close();
    }
}
