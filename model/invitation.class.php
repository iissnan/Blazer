<?php

require_once("model.class.php");

class Invitation extends Model {
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
        $inv = $this->getItem('value', $value);
        list(, , $inv_num) = $inv->fetch_array();
        $this->update("value='$value'", array("number"=>$inv_num - 1));
    }
}