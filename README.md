<h1 align="center">Ace</h1>

## 介绍
`macOS`系统下, 多版本`PHP`使用工具.

如果你本地安装了多个版本的`PHP`, 你可能需要它.

安装后, 在项目根目录执行`ace`或者`ace php`命令即可自动使用项目运行的`PHP`版本. 

更多命令:
```shell
# ace 等同于执行 ace php
ace 
ace php
ace composer
ace pecl
# 调用
ace -v # 查看当前 PHP 版本
ace php -v # 查看当前 PHP 版本
ace artisan migrate # 执行 laravel 的 artisan
ace composer install # 执行 composer install
ace pecl install redis # 安装当前 PHP 版本的 redis 扩展
```

`ace`命令会按照 `ace.json`, `composer.json`, 系统环境变量的`PHP`, 这样的顺序去寻找最合适的`PHP`版本.

如果您在当前目录定义了`ace.json`, 那么`ace`命令会优先使用`ace.json`中定义的`PHP`版本.

否则, 如果您在当前目录定义了`composer.json`, 那么`ace`命令会优先使用`composer.json`中定义的`PHP`版本.

如果都没有匹配到, `ace`命令会使用系统环境变量中默认的`PHP`版本.

## 安装
```shell
composer global require mitoop/ace
```

## 注意
1. `ace` 支持的`PHP`版本为 `>=7.0`
2. `ace` 选择`PHP`版本的策略是积极的, 勇敢的, 所以如果你定义的`php`版本是 `^7.1`, 而你本地同时安装了 `php@7.1`,`php@7.2`,`php@7.3`,`php@7.4`,`php@8.0`版本,
那么`ace`会选择最高版本的`php@7.x`版本, 也就是`php@7.4`版本. 此种情况下, 如果您需要特殊指定一个版本, 请新建一个`ace.json`文件, 并指定版本号.
3. 如果您不太熟悉`PHP`配置相关, 可能需要注意, 多版本`PHP`同时工作需要更改`php-fpm`的监听端口, 因为所有版本`PHP`默认都是监听`9000`端口, 所以需要更改`php-fpm`的监听端口, 或者使用`unix socket`文件方式来保持同时启用.
4. `macOS`系统下安装老版本`PHP`可使用 [https://github.com/shivammathur/homebrew-php](https://github.com/shivammathur/homebrew-php)

## ace.json 例子
版本定义遵循语义化版本约束 [https://semver.org/lang/zh-CN/](https://semver.org/lang/zh-CN/)
```json
{
    "php": "^7.4.0"
}
```
## 
Inspired by great `laravel/valet`
