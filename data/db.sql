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
-- 表的结构 `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 导出表中的数据 `authors`
--

INSERT INTO `authors` VALUES (1, 'Lee Babin');

-- --------------------------------------------------------

--
-- 表的结构 `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `author` varchar(100) default NULL,
  `isbn` varchar(100) default NULL,
  `cover` varchar(100) NOT NULL default 'default.png',
  `douban_link` varchar(100) default NULL,
  `create_at` datetime default NULL,
  `update_at` datetime default NULL,
  `creator` int(11) NOT NULL,
  `pages` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=134 ;

-- --------------------------------------------------------

--
-- 表的结构 `books_authors`
--

CREATE TABLE `books_authors` (
  `book_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `books_authors`
--

INSERT INTO `books_authors` VALUES (133, 1);

-- --------------------------------------------------------

--
-- 表的结构 `books_categories`
--

CREATE TABLE `books_categories` (
  `book_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  KEY `book_id` (`book_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `books_categories`
--


-- --------------------------------------------------------

--
-- 表的结构 `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `categories`
--


-- --------------------------------------------------------

--
-- 表的结构 `invitations`
--

CREATE TABLE `invitations` (
  `id` int(11) NOT NULL auto_increment,
  `value` varchar(100) NOT NULL,
  `number` int(11) NOT NULL default '10',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

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
  `group` varchar(100) NOT NULL default 'user',
  `avatar` varchar(100) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;
