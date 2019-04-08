# icoolyy/fat

- 这是一个微信第三方管理平台的composer包！

> 运行环境要求PHP7.0以上

## 安装

使用composer安装

~~~
composer require icoolyy/fat dev-master
~~~

更新 fat
~~~
composer update icoolyy/fat dev-master
~~~


## 目录结构

初始的目录结构如下：

~~~
├─src           源码目录
│  ├─crypt              微信加解密
│  ├─http               http助手
│  ├─lib                库文件
│  │  ├─open            开放平台
│  │  ├─program         小程序
│  │  └─publicnum       公众号
│  │
│  ├─ApiList.php        接口API地址列表
│  └─Helper.php         助手类
│
├─composer.json         composer 定义文件
├─LICENSE.txt           授权说明文件
├─README.md             README 文件
~~~