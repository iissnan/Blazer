# 书籍管理

***

###环境需求:

* [PHP](http://www.php.net/) >= 5.3.0
* [MySQL](http://dev.mysql.com/downloads/)
* [Smarty](http://www.smarty.net/)
* [Bower](http://twitter.github.io/bower/)

要求5.3.0以上版本的PHP功能备注:

* `__DIR__` available in PHP 5.3.0
* `mysqli::fetch_all()` available in PHP 5.3.0
* `mysqli::connect_error` 5.2.9以上版本上可用
* `mysqli` 长链接(Persistent Connections)


###目录说明：

###安装步骤：

* 配置数据库链接数据 和 Google reCaptcha API 密钥
* 上传文件
* 上传完成后浏览器中打开安装页面： http://example.com/install/
* 填写账户信息
* 完成安装，__务必删除__`install`目录