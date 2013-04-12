<?php

require_once("dbc.class.php");

class Invitation extends Model {
    private $table = "invitations";

    /**
     * 次数随使用次数递减
     *
     * @param string $value
     */
    public function minus($value) {
        $inv = $this->getItem('value', $value);
        list(, , $inv_num) = $inv->fetch_array();
        //TODO: update and return result
    }
}