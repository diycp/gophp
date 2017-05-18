<p align="center">
    <b>📦 GoPHP轻量级现代PHP框架</b>
</p>

## Feature

 - 命名不那么乱七八糟；
 - 隐藏开发者不需要关注的细节；
 - 方法使用更优雅，不必再去研究那些奇怪的的方法名或者类名是做啥用的；
 - 自定义缓存方式；
 - 符合 [PSR](https://github.com/php-fig/fig-standards) 标准，你可以各种方便的与你的框架集成；
 - 高度抽象的消息类，免去各种拼json与xml的痛苦；
 - 详细 Debug 日志，一切交互都一目了然；

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
