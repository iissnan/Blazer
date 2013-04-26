<?php

/** MySQL 数据库连接信息设置 */

// 数据库 所在主机地址
define("DB_HOST", "localhost");

// 数据库用户名
define("DB_USER", "root");

// 数据库用户密码
define("DB_PASSWORD", "123456");

// 数据库名字
define("DB_DATABASE", "bookshelf");


/** Google reCaptcha API Key配置 */

// 公开的密钥
define("RECAPTCHA_PUBLIC", "6LfbAeASAAAAAKGOX1J5uXfYX_QBBGOkoze4WA6H");

// 私有的密钥
define("RECAPTCHA_PRIVATE", "");



/** 目录配置 */

// 支持文件目录
define("SUPPORT_DIR", __DIR__ . "/../support");

// 模型文件目录
define("MODEL_DIR", SUPPORT_DIR . "/model");

// 功能文件目录
define("FUNCTION_DIR", SUPPORT_DIR . "/include");

// 第三方库目录
define("VENDOR_DIR", SUPPORT_DIR . "/vendor");

// 头像存储目录
define("AVATAR_DIR", __DIR__ . "/assets/avatar");

// 书籍封面存储目录
define("COVER_DIR", __DIR__ . "/assets/cover");

// 版本
define("VERSION", "0.1.0");
