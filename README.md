<h1 align="center">Ace</h1>

## 介绍
`macOS`系统下, 多版本`PHP`使用工具.

如果你本地安装了多个版本的`PHP`, 你可能需要它.

安装后, 在项目根目录执行`ace`或者`ace php`命令即可自动使用项目运行的`PHP`版本. 

更多命令:
```shell
ace # ace 等同于执行 ace php
ace php
ace composer
ace pecl
ace clear # 清除 ace 缓存
ace hello # Hello Ace!

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
# 全新安装
composer global require mitoop/ace

# 升级版本 先移除旧版本再安装新版本
composer global remove mitoop/ace 
composer global require mitoop/ace 
```

## 注意
1. `ace` 支持的`PHP`版本为 `>=7.1`
2. `ace` 选择`PHP`版本策略遵循语义化版本约束, 同时在约束下又是积极的, 勇敢的, 如果你定义的`php`版本是 `^7.1`, 而你本地同时安装了 `php@7.1`,`php@7.2`,`php@7.3`,`php@7.4`,`php@8.0`版本,
那么`ace`会选择最高版本的`php@7.x`版本, 也就是`php@7.4`版本. 此种情况下, 如果您需要特殊指定一个版本, 请新建一个`ace.json`文件, 并指定版本号.
3. `ace` 首次执行会缓存所有的`PHP`版本以加快之后的执行速度, 当您新安装了`PHP`版本或者移除了一些`PHP`版本时, 需要执行 `ace clear` 命令来移除缓存.
4. 如果您不太熟悉`PHP`配置相关, 可能需要注意, 多版本`PHP`同时工作需要更改`php-fpm`的监听端口, 因为所有版本`PHP`默认都是监听`9000`端口, 所以需要更改`php-fpm`的监听端口, 或者使用`unix socket`文件方式来保持同时启用.
5. `macOS`系统下安装老版本`PHP`可使用 [https://github.com/shivammathur/homebrew-php](https://github.com/shivammathur/homebrew-php)
6. 多版本`php`同时安装同一扩展时, 可能遇到的问题, `PHP8.0`下安装了`redis`扩展, 这时切换到`PHP7.4`安装`redis`扩展, `pecl`会提示已安装, 需要在`PHP7.4`下先执行卸载`redis`扩展命令, 再安装即可(这样两个版本都安装了`redis`扩展).
7. 当你遇到这个问题 `Composer 2.3.0 dropped support for PHP <7.2.5 and you are running 7.1.33, please upgrade PHP or use Composer 2.2 LTS via "composer self-update --2.2". Aborting.`
   
   这是因为高版本的`composer`要求`PHP`版本大于等于`7.2.5`, 如果你正在同时使用高版本`PHP`(>=7.2.5)与低版本`PHP`(<7.2.5), 那么你可以安装`composer 2.2.x LTS`长期维护版. 长期维护版本支持`PHP 5.3.2+`版本.
   
   详见 [https://getcomposer.org/doc/00-intro.md#system-requirements](https://getcomposer.org/doc/00-intro.md#system-requirements)
   
   安装LTS版本: `composer self-update --2.2`, 如果报错请加`sudo`
## ace.json 例子
版本定义遵循语义化版本约束 [https://semver.org/lang/zh-CN/](https://semver.org/lang/zh-CN/)
```json
{
    "php": "^7.4.0"
}
```
## 
Inspired by great `laravel/valet`
