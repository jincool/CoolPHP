# CoolPHP 超精简PHP框架
### [功能描述]：适用于中小型快速搭建的项目。
### [开发环境]：mysql5.6+，php5.6+
### [项目结构简介]：
1.application 
   * admin   ---默认平台
     * controller  ----控制器文件，调用模型
       * index  ----- 默认文件夹
       * xxx    ----- 自定义文件夹
     * model  ----模型文件，数据库CRUD操作
        * index  ----- 默认文件夹
        * xxx    ----- 自定义文件夹
   * common  ---统一公用代码，如配置跨域、用户登录监测
