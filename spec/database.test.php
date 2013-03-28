<?php

header('Content-Type: text/html; charset=utf-8');
require_once("../dbc.class.php");


$dbc = new DatabaseConnection("localhost", "root", "123456", "bookshelf");

// 执行数据删除
$query = "DELETE FROM `books` WHERE title = '环游黑海历险记'";
$dbc->query($query);
$dbc->remove("books", "WHERE title = '环游黑海历险记'");

// 执行数据插入
$query = 'INSERT INTO `books` (title, author) VALUES("环游黑海历险记", "〔法〕儒尔·凡尔纳")';
$dbc->query($query);

// 执行数据删除
$query = "DELETE FROM `books` WHERE title = '环游黑海历险记'";
$dbc->query($query);

// 释放数据库链接
$dbc->close();