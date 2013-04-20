<?php

require_once("dbm.class.php");

class UserModel extends DatabaseManipulate {
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
        $result = $this->get_item("email", $email);
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
                $this->update(array(
                        "times" => $user->times + 1,
                        "last_login_at" => date("Y-m-d H:i:s")
                    ))
                    ->where("email='$email'")
                    ->execute();
            }
        }
        return $user;
    }

    /**
     * 添加用户
     *
     * @param array $data
     * @return boolean 注册成功或者失败
     */
    public function add($data) {
        list($email, $password, $username, $invitation_value, $group) = $data;
        !$group and $group = "user";
        require_once("invitation.class.php");

        $inv_refer = 0;

        $is_first_user = !empty($_SESSION["first_user"]);
        if (!$is_first_user) {
            $invitation_model = new InvitationModel();
            $invitation_result = $invitation_model->get_item("value", $invitation_value);

            // 邀请码不存在
            if ($invitation_result->num_rows == 0) {
                return false;
            }

            // 检测邀请码个数
            list($inv_id, $inv_value, $inv_num, $inv_refer) = $invitation_result->fetch_array();
            if ($inv_num < 1) {
                // 邀请码无效
                return false;
            }
            $invitation_model->minus($invitation_value);
        }
        $insert_data = array(
            "email" => $email,
            "password" => sha1($password),
            "username" => $username,
            "create_at" => date("Y-m-d H:i:s"),
            "update_at" => date("Y-m-d H:i:s"),
            "group" => $group,
            "refer" => $inv_refer
        );

        return $this->insert($insert_data)->execute();
    }

    /**
     * 锁定$email对应的用户
     *
     * @param $email
     * @return boolean 更新成功或者失败
     */
    public function deactive($email) {
        return $this->update(array("deactive" => 1))
                    ->where("email='$email'")
                    ->execute();
    }

    /**
     * 解锁$email对应的用户
     *
     * @param string $email
     * @return bool 更新成功或者失败
     */
    public function active($email) {
        return $this->update(array("deactive" => 0))
                    ->where("email='$email'")
                    ->execute();
    }
}