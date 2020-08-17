# YiiCommon
               
			  
   Yii2.0通用后台，功能包含用户管理，文档管理，权限管理，即使通讯，图片库管理...等web网站通用模块，提供了很多方便易用的通用方法
希望有兴趣的朋友继续完善！

Yii版本：Yii2.0

php版本：php5.4及以上版本

mysql：5.6

mysql配置：Common\config\main-local下

一、后台运行方式：

1.运行YiiCommon.sql脚本，然后到配置文件下去修改数据库配置

2.配置好本地环境，将项目放到一级目录下，运行localhost/admin.html即可访问后台

二、使用即时通讯：

1.你只要搭建好node.js运行平台（目前只支持my_chat和web运行在同一个平台）

2.到my_chat目录下运行node app.js


三、本系统集成了coreseek搜索引擎

1.你只需要到backend\config\params-local.php下面去配置即可

2.你可以通过实例化QueryApi来使用coreseek全文搜索引擎.
