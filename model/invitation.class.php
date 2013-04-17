<?php

require_once("dbm.class.php");

class InvitationModel extends DatabaseManipulate {
    protected $table = "invitations";

    public function __construct() {
        parent::__construct($this->table);
    }
    /**
     * 次数随使用次数递减
     *
     * @param string $value
     */
    public function minus($value) {
        $inv = $this->get_item('value', $value);
        list(, , $inv_num) = $inv->fetch_array();
        $this->update(array("number"=>$inv_num - 1))
            ->where("value='$value'")
            ->execute();
    }
}