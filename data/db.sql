-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 04 月 14 日 20:05
-- 服务器版本: 5.5.29
-- PHP 版本: 5.3.15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+08:00";

--
-- 数据库: `bookshelf`
--

-- --------------------------------------------------------

--
-- 表的结构 `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `isbn` varchar(100) DEFAULT NULL,
  `intro` text(100) DEFAULT NULL,
  `pages` int(11) DEFAULT NULL,
  `cover` varchar(100) NOT NULL DEFAULT 'default.png',
  `douban_link` varchar(100) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `creator` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `books_authors`
--

CREATE TABLE IF NOT EXISTS `books_authors` (
  `book_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  KEY `book_id` (`book_id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `books_categories`
--

CREATE TABLE IF NOT EXISTS `books_categories` (
  `book_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  KEY `book_id` (`book_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `invitations`
--

CREATE TABLE IF NOT EXISTS `invitations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(100) NOT NULL,
  `number` int(11) NOT NULL DEFAULT '5',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `signature` varchar(140) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `times` int(11) NOT NULL DEFAULT '0',
  `deactive` tinyint(1) NOT NULL DEFAULT '0',
  `group` varchar(100) NOT NULL DEFAULT 'user',
  `avatar` varchar(100) DEFAULT 'default.png',
  `refer` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


--
-- 表的结构 `positions`
--

CREATE TABLE IF NOT EXISTS `positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL,
  `note` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `book_id` (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='阅读进度';


--
-- 限制导出的表
--

--
-- 限制表 `books_authors`
--
ALTER TABLE `books_authors`
ADD CONSTRAINT `books_authors_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `books_authors_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `books_categories`
--
ALTER TABLE `books_categories`
ADD CONSTRAINT `books_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `books_categories_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `invitations`
--
ALTER TABLE `invitations`
ADD CONSTRAINT `invitations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `reading_position`
--
ALTER TABLE `positions`
  ADD CONSTRAINT `positions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `positions_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;