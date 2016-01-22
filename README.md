# YiiCommon

Yii版本：Yii2.0

php版本：php5.4及以上版本

mysql：5.6

mysql配置：Common\config\main-local下

一、后台运行方式：
1.运行YiiCommon.sql脚本，然后到配置文件下去修改数据库配置

2.配置好本地环境，将项目放到一级目录下，运行localhost/admin.html即可访问后台

二、使用即时通讯：
1.你只要搭建好node.js运行平台即可（目前只支持my_chat和web运行在同一个平台）
2.到my_chat目录下运行node app.js即可


三、本系统集成了coreseek搜索引擎
1.你只需要到backend\config\params-local.php下面去配置即可
2.你可以通过实例化QueryApi来使用coreseek全文搜索引擎，关于搜索引擎，我们希望做的更强大！欢迎假如有猿网（http://www.5151jh.com）讨论
