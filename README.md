<p align="center">
    <b>📦GoPHP——轻量级现代PHP框架</b>
</p>

## Feature

 - 基于 MVC 体系架构，确保了清晰分离逻辑层和表现层；
 - 遵循PSR-2、PSR-4规范，Composer及单元测试支持；
 - 惰性加载，仅在需要时再加载，并且只会加载一次；
 - 支持请求过滤器（中间件），使控制器专注于处理业务逻辑；
 - 提供大量的辅助函数、挂件来提高开发者的开发速度；
 - 核心类高度独立，最大程度的提高复用性和最小程度的降低耦合性；
 - 优雅的调用方式，支持静态调用、动态调用以及静动态混合链式调用；
 - 内置验证机制，囊括常用的使用场景；
 - 强大的缓存支持及自定义缓存支持；
 - 强安全策略，自动防止跨站脚本、SQL注入攻击等；
 - 完美支持PHP7；

## Requirement

 - PHP >= 5.5.0
 - COMPOSER
 - PDO 拓展
 - GD 拓展
 - CURL 拓展
> 框架本身没有什么特别模块要求，具体的应用系统运行环境要求视开发所涉及的模块。

## Installation

1. 下载框架
2. 设置目录权限


    `public/upload`、`runtime`目录给予可读可写权限(如果不存在则先创建目录)
    

3. 绑定域名


    将域名绑定到`public`目录上
    

4. 开启UrlRewrite来隐藏入口文件index.php(非必须，但是建议开启)
5. 更改配置信息

## Usage

#### 核心类库:

* ##### db(数据库操作类)
1. 查询单条数据

```php
db::table('user')->find(1); //返回主键ID为1的用户信息，如果符合条件的有多条，只返回主键ID降序第一条数据；
db::table('user')->where('id', '=', 1)->find('name'); //返回id等于1的用户姓名数组，如['name'=>'勾国磊']；
db::table('user')->where('id', '=', 1)->find('name,age'); //返回id等于1的用户姓名数组，如['name'=>'勾国磊','age'=>23]；
```

2. 查询多条数据

3. 多表联查

```php
db::table('user')->join('order')->on("user.id = order.user_id")->limit(10)->findAll(); //默认内联合
db::table('user')->join('order', 'inner')->on("user.id = order.user_id")->limit(10)->findAll(); //内联合
db::table('user')->join('order', 'left')->on("user.id = order.user_id")->limit(10)->findAll(); //左联合
db::table('user')->join('order', 'right')->on("user.id = order.user_id")->limit(10)->findAll(); //右联合
```

4. 聚合查询

5. 添加单条数据

```php
$data = ['title' => '勾国磊', 'sex' => '男', 'age' => 23];
db::table('user')->add($data); //返回自增ID
```

6. 添加多条数据

```php
$data1 = ['title' => '勾国磊', 'sex' => '男', 'age' => 23];
$data2 = ['title' => '张雨康', 'sex' => '女', 'age' => 18];
db::table('user')->addAll($data1, $data2); //返回影响行数
```

7. 更新数据

```php
$data = ['title' => '勾国印', 'sex' => '男', 'age' => 18];
db::table('user')->where('id', '=', 1)->update($data); //更新id等于1的用户信息，返回影响行数
```

8. 字段自增

```php
db::table('user')->inc('age'); //将所有用户年龄自增1
db::table('user')->where('id', '=', 1)->inc('age', 2); //将id等于1的用户年龄自增2
```
9. 字段自减

```php
db::table('user')->dec('age'); //将所有用户年龄自减1
db::table('user')->where('id', '=', 1)->dec('age', 2); //将id等于1的用户年龄自减2
```

10. 删除数据

```php
db::table('user')->delete(1); //删除主键为1的用户，返回影响行数
db::table('user')->where('age', '>', 100)->delete(); //删除年龄大于100的用户，返回影响行数
```

11. 事务支持

* ##### config(配置类)

* ##### cookie(COOKIE类)

* ##### session(会话类)

* ##### filter(过滤器)

* ##### validate(验证类)

* ##### request(请求类)

* ##### response(响应类)

* ##### route(路由类)

* ##### upload(上传类)

* ##### controller(控制器基类)

* ##### reflect(反射类)

* ##### cache(缓存类)

* ##### exception(异常基类)

* ##### log(日志类)

* ##### view(视图类)

* ##### mail(邮件类)

* ##### crypt(加密解密类)

* ##### captcha(验证码类)

#### 系统函数:

* ##### dump($arg...)(友好的打印调试)

* ##### input($key, $default)(获取输入参数)

* ##### config($name, $key)(获取配置信息)

* ##### url($uri = null, $arguments = [], $isAbsolute = false, $extension = null)(生成优化的URL)

#### 助手类:

* ##### helper/str(字符串助手类)

* ##### helper/arr(数组助手类)

* ##### helper/dir(目录助手类)

* ##### helper/file(文件助手类)

* ##### helper/url(URL助手类)

## Documentation

- 如果您有任何疑问，或有好的意见和想法，请通过以下途径联系我
- 官方网站：[frame.gouguoyin.cn](http://frame.gouguoyin.cn)
- 使用手册：www.gouguoyin.cn/doc
- 作者博客：www.gouguoyin.cn
- 官方QQ群：421537504 <a style="margin-left:10px" target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=d49826b55d1759513ce5d68253b3f0589b227587edf87059aa08125e620b73c0"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="GoPHP官方交流群" title="GoPHP官方交流群"></a>


