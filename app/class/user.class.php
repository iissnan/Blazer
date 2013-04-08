<?php

require_once("dbc.class.php");

class User {
    private $table = "users";
    private $dbc;

    function __construct () {
        $this->dbc = new DatabaseConnection("localhost", "root", "123456", "bookshelf");
    }

    /**
     * 获取$email对应的用户
     *
     * @param string $email 登录邮箱地址
     * @param string $password 登录密码
     * @return object
     */
    public function get($email, $password) {
        $user = (object) array("error" => 0, "msg" => "");
        $result = $this->dbc->get($this->table, "email='" . $email . "'");
        if ($result->num_rows == 0) {
            $user->error = 1;
            $user->msg = "用户不存在";
        } else {
            $user = $result->fetch_object();
            if ($user->password != $password) {
                $user->error = 2;
                $user->msg = "用户名与密码不匹配";
            } else if ($user->deactive == 1) {
                $user->error = 3;
                $user->msg = "用户已停用";
            } else {
                $user->error = 0;

                // 登录次数++ 与 最后登录时间
                $this->update(
                    $email,
                    array(
                        "times" => $user->times + 1,
                        "last_login_at" => date("Y-m-d H:i:s")
                    )
                );
            }
        }
        return $user;
    }

    /**
     * 添加用户
     *
     * @param string $email
     * @param string $password
     * @param string $nickname
     * @return boolean 注册成功或者失败
     */
    public function add($email, $password, $nickname) {
        return $this->dbc->insert(
            $this->table,
            array("email", "password", "nickname", "create_at", "update_at"),
            array($email, $password, $nickname, date("Y-m-d H:i:s"), date("Y-m-d H:i:s"))
        );
    }

    /**
     * 更新用户信息
     *
     * @param string $email
     * @param array $pair
     * @return boolean 更新成功或者失败
     */
    public function update($email, $pair) {
        return $this->dbc->update(
            $this->table,
            $pair,
            "email='$email'"
        );
    }

    /**
     * 锁定$email对应的用户
     *
     * @param $email
     * @return boolean 更新成功或者失败
     */
    public function deactive($email) {
        return $this->update($email, array("deactive" => 1));
    }

    /**
     * 解锁$email对应的用户
     *
     * @param string $email
     * @return bool 更新成功或者失败
     */
    public function active($email) {
        return $this->update($email, array("deactive" => 0));
    }
}