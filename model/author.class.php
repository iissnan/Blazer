<?php
require_once("dbm.class.php");

class AuthorModel extends DatabaseManipulate{

    public function __construct() {
        $this->table = "authors";
    }
}