<h1 align="center">Ace</h1>
<p align="center">🥇 macOS 下优雅管理多版本 PHP 的命令行工具</p>

---

## 简介

**Ace** 是一款 macOS 平台下的 PHP 多版本切换工具，灵感来自优秀的 `laravel/valet`。

如果你本地安装了多个版本的 PHP，并希望在不同项目中使用不同版本，**Ace** 将是你不可或缺的工具。

只需在项目根目录下运行：

```bash
ace
# 或者
ace php
```

Ace 会自动为当前项目匹配最合适的 PHP 版本，无需手动切换。

---

## 快速命令参考

```bash
ace                 # 等同于 ace php
ace php             # 使用项目对应 PHP 版本运行
ace composer        # 使用匹配的 PHP 版本执行 composer
ace pecl            # 使用匹配的 PHP 版本执行 pecl
ace artisan         # 执行 Laravel 命令
ace clear           # 清除缓存
ace hello           # 打印 Hello Ace!

# 示例用法
ace -v                      # 查看当前使用的 PHP 版本
ace php -v                 # 同上
ace artisan migrate        # 执行 Laravel 数据迁移
ace composer install       # 安装依赖
ace pecl install redis     # 安装扩展
```

---

## 版本匹配逻辑

Ace 会按照以下优先级查找项目所需 PHP 版本：

1. 当前目录中的 `ace.json`
2. 当前目录中的 `composer.json`
3. 系统环境变量中的默认 PHP 版本

例如：

```json
// ace.json 示例
{
  "php": "^7.4.0"
}
```

支持语义化版本约束，详见 [https://semver.org/lang/zh-CN/](https://semver.org/lang/zh-CN/)

---

## 安装方式

```bash
# 安装
composer global require mitoop/ace

# 升级（先移除旧版本）
composer global remove mitoop/ace
composer global require mitoop/ace
```

---

## 注意事项

1. 支持的 PHP 版本为 `>= 7.1`
2. 若版本约束为 `^7.1`，且本地存在 `php@7.1`, `php@7.2`, `php@7.3`, `php@7.4`, `php@8.0` 等版本，Ace 会选择 **最高的 `php@7.x`**，即 `php@7.4`
3. 若需固定版本，请在项目中创建 `ace.json` 并指定版本
4. 首次运行会缓存所有已安装的 PHP 版本，加快后续执行速度。新增/移除 PHP 后请运行 `ace clear` 清除缓存
5. 多版本 PHP 同时启用时，需注意 `php-fpm` 的监听端口冲突。建议使用不同端口，或通过 unix socket 方式运行
6. 推荐使用 [shivammathur/homebrew-php](https://github.com/shivammathur/homebrew-php) 安装旧版本 PHP
7. 多版本 PHP 安装相同扩展（如 `redis`）时可能冲突。可在对应版本下先卸载再安装
8. Composer 高版本对 PHP 有最低要求，例如：
   ```
   Composer 2.3.0 dropped support for PHP <7.2.5
   ```
   可使用长期维护版：
   ```bash
   composer self-update --2.2
   ```

---

## 灵感来源

✨ Inspired by the great [laravel/valet](https://github.com/laravel/valet)
