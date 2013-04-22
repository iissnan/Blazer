<?php
require_once("dbm.class.php");

class TagModel extends DatabaseManipulate{

    public function __construct() {
        $this->table = "categories";
        parent::__construct("categories");
    }
}