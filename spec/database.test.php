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

// 获取数据
$result = $dbc->get($table, "WHERE title = '环游黑海历险记'");
echo $result->num_rows . " // 查询结果应该等于1 <br />";

// 执行数据删除
$dbc->remove($table, "WHERE title = '环游黑海历险记'");

// 释放数据库链接
$dbc->close();