## GoPHP核心类库
### db类(数据库操作类)
- #### 配置数据库信息

```php
'driver' => 'mysql',
'mysql'  => [
    'host'     => '', //主机
    'port'     => '', //端口
    'name'     => '', //数据库名
    'prefix'   => '', //表前缀
    'user'     => '', //用户名
    'password' => '', //数据库密码
    'charset'  => 'UTF8', //数据库编码
],
```  
>数据库配置文件db.php一般放在common/config的环境变量目录下，假如当前开发环境是develop，那么放在common/config/develop目录下，即common/config/develop/db.php；如果不区分开发环境，那么直接放在common/config目录下，即common/config/db.php；如果
common/config/develop/db.php和common/config/db.php同时存在，那么读取的是common/config/develop/db.php里的配置信息，即环境配置文件优先级大于模块配置文件；
- #### CURD操作

1. ###### 查询单条数据

```php
db::table('user')->find(1);
db::table('user')->where('id', '=', 1)->find('name');
db::table('user')->where('id', '=', 1)->find('name,age');
```

2. ###### 查询多条数据

```php
db::table('user')->where('age', '>', 100)->limit(10)->order('id desc')->findAll();
db::table('user')->where('age', '>', 100)->limit(1, 10)->order('id desc')->findAll('name');
db::table('user')->where('age', '>', 100)->limit(10, 10)->order('id desc')->findAll('id, name');
```

3. ###### 多表联查

```php
db::table('user')->join('order')->on("user.id = order.user_id")->limit(10)->findAll(); //默认内联合
db::table('user')->join('order', 'inner')->on("user.id = order.user_id")->limit(10)->findAll(); //内联合
db::table('user')->join('order', 'left')->on("user.id = order.user_id")->limit(10)->findAll(); //左联合
db::table('user')->join('order', 'right')->on("user.id = order.user_id")->limit(10)->findAll(); //右联合
```
4. ###### 数据分页

```php
$total = db::table('user')->where('age', '>', 100)->count(); //查询数据总数
$page  = new page($total, 10); //实例化分页类，每页显示10条数据
db::table('user')->where('age', '>', 100)->page($page)->order('id desc')->findAll(); //每页显示10条数据
db::table('user')->where('age', '>', 100)->page($page, 2)->order('id desc')->findAll(); //显示第二页的10条数据
```

5. ###### 聚合查询

```php
db::table('user')->where('age', '>', 100)->count();
```

6. ###### 添加单条数据

```php
$data = ['name' => '勾国磊', 'sex' => '男', 'age' => 23];
db::table('user')->add($data); //返回自增ID
```

7. ###### 添加多条数据

```php
$data1 = ['name' => '勾国磊', 'sex' => '男', 'age' => 23];
$data2 = ['name' => '张雨康', 'sex' => '女', 'age' => 18];
db::table('user')->addAll($data1, $data2); //返回影响行数
```

8. ###### 更新数据

```php
$data = ['name' => '勾国印', 'sex' => '男', 'age' => 18];
db::table('user')->where('id', '=', 1)->update($data); //更新id等于1的用户信息，返回影响行数
```

9. ###### 字段自增

```php
db::table('user')->inc('age'); //将所有用户年龄自增1
db::table('user')->where('id', '=', 1)->inc('age', 2); //将id等于1的用户年龄自增2
```
10. ###### 字段自减

```php
db::table('user')->dec('age'); //将所有用户年龄自减1
db::table('user')->where('id', '=', 1)->dec('age', 2); //将id等于1的用户年龄自减2
```

11. ###### 删除数据

```php
db::table('user')->delete(1); //删除主键为1的用户，返回影响行数
db::table('user')->where('age', '>', 100)->delete(); //删除年龄大于100的用户，返回影响行数
```

12. ###### 事务支持

- #### 链式操作
1. ###### driver
    ```php
    db::driver('mysql')->table('user')->find();
    ```
2. ###### where
3. ###### limit

    ```php
    db::table('user')->where('age', '>', 100)->limit(10)->order('id desc')->findAll();
    db::table('user')->where('age', '>', 100)->limit(10, 10)->order('id desc')->findAll('id, name');
    ```
4. ###### order

    ```php
    db::table('user')->where('age', '>', 100)->limit(10)->order('id desc')->findAll();
    db::table('user')->where('age', '>', 100)->limit(10)->order('id desc,age asc')->findAll();
    ```
    
5. ###### show

    ```php
    db::table('user')->show(true)->delete(1); //只展示sql语句，不执行
    ```

### config(配置类)

- ###### load：加载配置文件
- ###### get：获取指定配置项
- ###### all：获取所有配置信息

### cookie(COOKIE类)

- ###### set：设置cookie，支持数组格式(只支持一维数组)

    ```php
    cookie::instance()->set('name', '勾国印', 3);
    cookie::instance()->set('user', ['name' => '勾国印', 'age' => 18], 10);
    ```
    
- ###### get：获取指定cookie

    ```php
    cookie::instance()->get('name'); //返回'勾国印'
    cookie::instance()->get('user'); //返回user数组
    cookie::instance()->get('user.age'); //返回18
    ```
    
- ###### has：是否存在指定cookie

    ```php
    cookie::instance()->has('name'); 
    ```
    
- ###### delete：删除指定cookie

    ```php
    cookie::instance()->delete('name'); 
    ```
    
- ###### clean：删除全部cookie

    ```php
    cookie::instance()->clean(); 
    ```

### session(会话类)

### filter(过滤器)

### request(请求类)

- ###### isGet：是否是GET请求
- ###### isPost：是否是POST请求
- ###### isOptions：是否是OPTINS请求
- ###### isHead：是否是HEAD请求
- ###### isDelete：是否是DELETE请求
- ###### isPut：是否是PUT请求
- ###### isPatch：是否是PATCH请求
- ###### isTrace：是否是TRACE请求
- ###### isAjax：是否是AJAX请求
- ###### isPjax：是否是PAJX请求
- ###### isFlash：是否是FLASH请求
- ###### isCLI：是否是命令行模式请求
- ###### isWin：是否是WINDOWS系统服务器发起请求
- ###### isLinux：是否是linux系统服务器发起请求
- ###### isWeChat：是否是微信发起请求
- ###### getMethod：获取请求方法
- ###### getParam：获取当前请求参数
- ###### getUA：获取USER_AGENT
- ###### getUrl：获取当前请求的相对或绝对URL
- ###### getScheme：获取当前请求的协议类型
- ###### getHost：获取当前请求的HOST
- ###### getDomain：获取当前请求的域名
- ###### getPath：获取当前请求的PATH
- ###### getQuery：获取当前请求的query字符串
- ###### getExtension：获取当前请求的URL扩展名
- ###### getTime：获取当前请求的时间
- ###### getServerIp：获取服务端IP
- ###### getClientIp：获取客户端IP
- ###### getReffer：获取前一个页面
- ###### get：获取GET请求的值
- ###### post：获取GET请求的值
- ###### put：获取PUT请求的值
- ###### curl：模拟HTTP请求

### response(响应类)

### route(路由类)

### upload(上传类)

### controller(控制器基类)

- ###### assign：将变量赋值给模板
- ###### display：展示模板
- ###### redirect：重定向

### reflect(反射类)

### cache(缓存类)

### exception(异常基类)

### log(日志类)

### view(视图类)

### mail(邮件类)

### crypt(加密解密类)

### captcha(验证码类)

### validate(验证类)

- ###### isEmail：验证是否是合法邮件地址
- ###### isUrl：验证是否是合法URL
- ###### isPhone：验证是否是合法手机号
- ###### isIP：验证是否是合法IP地址
- ###### isNumber：验证是否是数字
- ###### hasNumber：验证是否包含数字
- ###### isPrice：验证是合法价格
- ###### isEnglish：验证是否是纯英文字母
- ###### hasEnglish：验证是否包含英文字母
- ###### isChinese：验证是否是纯中文
- ###### hasChinese：验证是否包含中文
- ###### isDate：验证是否是合法日期
