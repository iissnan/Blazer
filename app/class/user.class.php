<?php

require_once("model.class.php");

class User extends Model {
    public $dbc;
    protected $table = "users";

    function __construct () {
        parent::__construct($this->table);
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
        $result = $this->dbc->get($this->table, 1, 0, "email='" . $email . "'");
        if ($result->num_rows == 0) {
            $user->error = 1;
            $user->msg = "用户不存在";
        } else {
            $user = $result->fetch_object();
            if ($user->password != sha1($password)) {
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
     * @param string $invitation_value 13位的邀请码
     * @return boolean 注册成功或者失败
     */
    public function add($email, $password, $nickname, $invitation_value) {
        require_once("invitation.class.php");
        $Invitation = new Invitation();
        $invitation = $Invitation->getItem("value", $invitation_value);

        // 邀请码不存在
        if ($invitation->num_rows == 0) {
            return false;
        }

        // 检测邀请码个数
        list(, , $inv_num) = $invitation->fetch_array();
        if ($inv_num < 1) {
            // 邀请码无效
            return false;
        }

        $Invitation->minus($invitation_value);

        return $this->dbc->insert(
            $this->table,
            array("email", "password", "nickname", "create_at", "update_at"),
            array($email, sha1($password), $nickname, date("Y-m-d H:i:s"), date("Y-m-d H:i:s"))
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