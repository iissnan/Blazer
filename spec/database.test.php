<?php

header('Content-Type: text/html; charset=utf-8');
require_once("../class/dbc.class.php");
$table = "books";

// 创建数据库链接对象
$dbc = new DatabaseConnection("localhost", "root", "123456", "bookshelf");

// 执行数据删除
$dbc->remove($table, "WHERE title = '环游黑海历险记'");

// 执行数据插入
$fields = array("title", "author");
$values = array("环游黑海历险记", "〔法〕儒尔·凡尔纳");
$dbc->insert($table, $fields, $values);

// 执行数据删除
$dbc->remove($table, "WHERE title = '环游黑海历险记'");

// 释放数据库链接
$dbc->close();