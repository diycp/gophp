<p align="center">
    <b>📦GoPHP轻量级现代PHP框架</b>
</p>

## Feature

 - 基于 MVC 体系架构，确保了清晰分离逻辑层和表现层；
 - 遵循PSR-2、PSR-4规范，Composer及单元测试支持；
 - 惰性加载，仅在需要时再加载，并且只会加载一次；
 - 支持请求过滤器（中间件），使控制器专注于处理业务逻辑；
 - 提供大量的辅助函数、挂件来提高开发者的开发速度；
 - 核心类高度独立，最大程度的提高代码的复用性和最小程度的降低组件的耦合性；
 - 优雅的调用方式，既支持静态调用、动态调用以及静动态混合链式调用；
 - 完美支持PHP7；
 — 内置验证机制；
 - 强大的缓存支持；

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

#### 核心类库:

* db(数据库查询类)
1. 查询单条数据:

```php
db::table('pdo')->where('id', '=', 1)->find(); //返回所有字段数组
db::table('pdo')->where('id', '=', 1)->find('title'); //返回指定字段的值
```

2. 查询多条数据:

3. 多表联查:

4. 聚合查询:

5. 添加单条数据:

6. 添加多条数据:

7. 更新数据:

8. 删除数据:

9. 事务支持:

#### 系统函数:

* dump($arg...)(友好的打印调试)

* input($key, $default)(获取输入参数)

* config($name, $key)(获取配置信息)

* url($uri = null, $arguments = [], $isAbsolute = false, $extension = null)(生成优化的URL)

## Documentation

- 如果您有任何疑问，或有好的意见和想法，请通过以下途径联系我
- 官方网站：[frame.gouguoyin.cn](http://frame.gouguoyin.cn)
- 使用手册：www.gouguoyin.cn/doc
- 作者博客：www.gouguoyin.cn
- 官方QQ群：421537504

## Integration

[Laravel 5 拓展包: overtrue/laravel-wechat](https://github.com/overtrue/laravel-wechat)

## Contribution

[Contribution Guide](.github/CONTRIBUTING.md)

## License

MIT
