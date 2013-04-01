-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2013 年 03 月 28 日 09:13
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `bookshelf`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `books`
-- 

CREATE TABLE `books` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `author` varchar(100) default NULL,
  `category` varchar(100) default NULL,
  `isbn` varchar(100) default NULL,
  `cover` varchar(100) default NULL,
  `douban_link` varchar(100) default NULL,
  `create_at` datetime default NULL,
  `update_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL auto_increment,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `create_at` datetime default NULL,
  `update_at` datetime default NULL,
  `last_login_at` datetime default NULL,
  `times` int(11) NOT NULL default '0',
  `deactive` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

