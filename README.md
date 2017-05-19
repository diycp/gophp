
# GoPHP——轻量级现代PHP框架</b>


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

## Documentation

- [核心类库](https://github.com/gouguoyin/doc/blob/master/gophp/library.md)
- [系统函数](https://github.com/gouguoyin/doc/blob/master/gophp/function.md)
- [辅助类库](https://github.com/gouguoyin/doc/blob/master/gophp/helper.md)


## Contaction

- 如果您有任何疑问，或有好的意见和想法，请通过以下途径联系我
- 官方网站：[frame.gouguoyin.cn](http://frame.gouguoyin.cn)
- 使用手册：www.gouguoyin.cn/doc
- 作者博客：www.gouguoyin.cn
- 官方QQ群：421537504 <a style="margin-left:10px" target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=d49826b55d1759513ce5d68253b3f0589b227587edf87059aa08125e620b73c0"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="GoPHP官方交流群" title="GoPHP官方交流群"></a>


