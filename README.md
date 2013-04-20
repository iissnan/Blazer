# 书籍收藏与阅读进度管理

***

###环境需求:

* [PHP](http://www.php.net/) >= 5.3.0
* [MySQL](http://dev.mysql.com/downloads/)
* [Smarty3](http://www.smarty.net/)
* [Bower](http://twitter.github.io/bower/) (Bower requires [node.js](http://nodejs.org))


###安装步骤：

1. 在`controller/app.config.php`中配置 `MySQL` 数据库连接信息
2. 在`controller/app.config.php`中配置 `Google reCaptcha` API 密钥
3. 获取前端依赖的库：`bower install`
3. 上传`controller`文件夹在服务器的根目录下
4. 上传`support`目录到服务器的<strong style="color:red">非公开目录</strong>下，并在`controller/app.config.php`中配置support目录相对于controller目录的路径信息
5. 上传完成后浏览器中打开安装页面，安装文件是`install/index.php`： http://example.com/install/
6. 注册第一个账户（管理员级别）
7. 完成安装，<strong style="color:red; font-weight:bold">务必删除</strong> `install` 目录


###目录说明：

    .
    ├── README.md
    ├── component.json              # 前端依赖配置文件
    ├── controller                  # 上传到服务器上的根目录下，此目录放置的controller文件
    │   ├── app.config.php          # 应用配置文件：`MySQL`数据连接配置、`Google Captcha API KEY`、`support`目录
    │   ├── assets                  # 静态资源文件
    │   ├── book                    # 书籍controller
    │   ├── index.php
    │   ├── install                 # 首次安装目录，安装成功后删除
    │   ├── invitation              # 邀请码controller
    │   ├── login.php
    │   ├── logout.php
    │   ├── position                # 阅读进度controller
    │   ├── register.php
    │   ├── require.global.php      # 全站级别引用文件
    │   └── user                    # 用户controller
    ├── sql                         # 数据结构
    │   └── db.sql
    └── support                     # 应用支持目录，放置在非公开的目录下，在`controller/app.config.php`中设置路径
        ├── cache                   # Smarty 的`cache`目录，必需设置成web用户可读写
        ├── config                  # Smarty 的`config`目录，存储通用模板变量
        ├── include                 # 功能性文件
        ├── model                   # 应用程序的数据模型类，数据库操作类
        ├── templates               # 视图
        ├── templates_c             # Smarty 编译后的视图文件，web用户必需可读写
        └── vendor                  # 第三方依赖库

要求5.3.0以上版本的PHP功能备注:

* `__DIR__` available in PHP 5.3.0
* `mysqli::fetch_all()` available in PHP 5.3.0
* `mysqli::connect_error` 5.2.9以上版本上可用
* `mysqli` 长链接(Persistent Connections)