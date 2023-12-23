<h1 align="center">Ace</h1>

## 介绍
本地多版本`PHP`自动切换工具, 适用于`macOS`. 安装后, 在项目根目录执行`ace php`命令即可自动切换到项目所需的`PHP`版本. 

更多命令:
```shell
ace php
ace composer
ace pecl
```
`ace`命令会按照 `ace.json`, `composer.json`, 系统环境变量的`PHP`, 这个顺序去寻找最合适的`PHP`版本.

也就是如果您在当前目录定义了`ace.json`, 那么`ace`命令会优先使用`ace.json`中定义的`PHP`版本.

否则, 如果您在当前目录定义了`composer.json`, 那么`ace`命令会优先使用`composer.json`中定义的`PHP`版本.

如果都没有定义, 那么`ace`命令会使用系统环境变量中默认的`PHP`版本.

#### 注意
`ace` 选择`php`版本的策略是积极/主战派策略, 所以如果你定义的`php`版本是 `^7.1`, 而你本地同时安装了 `php@7.1`,`php@7.2`,`php@7.3`,`php@7.4`,`php@8.0`版本, 
那么`ace`会选择最高版本的`php@7.x`版本, 也就是`php@7.4`版本. 此种情况下, 如果您需要特殊指定一个版本, 请新建一个`ace.json`文件, 并指定版本号.

## 安装
```shell
composer global require mitoop/ace
```

## ace.json 例子
```json
{
    "php": "^7.4.0"
}
```
## 
Inspired by great `laravel/valet`
