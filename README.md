<p align="center">
    <b>📦 GoPHP轻量级现代PHP框架</b>
</p>

## Feature

 - 遵循PSR-2、PSR-4规范，Composer及单元测试支持；
 - 基于 MVC 架构；
 - 惰性加载，仅在需要时再加载；
 - 完美支持PHP7；
 - 支持请求过滤器（中间件），使控制器专注于业务逻辑；
 - 大量的辅助函数；
 - 每一个类都是高度独立的，最大程度的提高代码的复用性和最小程度的降低组件的耦合性。

## Requirement

1. PHP >= 5.5.0
2. **[COMPOSER](https://getcomposer.org/)**
3. PDO 拓展
4. GD 拓展
5. CURL 拓展
> 框架本身没有什么特别模块要求，具体的应用系统运行环境要求视开发所涉及的模块。

## Installation

```shell
composer require "overtrue/wechat:~3.1" -vvv
```

## Usage

基本使用（以服务端为例）:

```php
<?php

use EasyWeChat\Foundation\Application;

$options = [
    'debug'     => true,
    'app_id'    => 'wx3cf0f39249eb0e60',
    'secret'    => 'f1c242f4f28f735d4687abb469072a29',
    'token'     => 'easywechat',
    'log' => [
        'level' => 'debug',
        'file'  => '/tmp/easywechat.log',
    ],
    // ...
];

$app = new Application($options);

$server = $app->server;
$user = $app->user;

$server->setMessageHandler(function($message) use ($user) {
    $fromUser = $user->get($message->FromUserName);

    return "{$fromUser->nickname} 您好！欢迎关注 overtrue!";
});

$server->serve()->send();
```

更多请参考[http://easywechat.org/](http://easywechat.org/)。

## Documentation

- Homepage: http://easywechat.org
- Forum: https://forum.easywechat.org
- 微信公众平台文档: https://mp.weixin.qq.com/wiki
- WeChat Official Documentation: http://admin.wechat.com/wiki

> 强烈建议看懂微信文档后再来使用本 SDK。

## Integration

[Laravel 5 拓展包: overtrue/laravel-wechat](https://github.com/overtrue/laravel-wechat)

## Contribution

[Contribution Guide](.github/CONTRIBUTING.md)

## License

MIT
