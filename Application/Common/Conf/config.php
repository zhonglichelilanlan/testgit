<?php
return array(
    //'配置项'=>'配置值'
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'zlccms',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '0gZDNaDYEM',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'zl_',    // 数据库表前缀
    //'ERROR_PAGE'          =>  '/404.html',


    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
            '__CSS__' => JDCK . '/Public/css',
            '__JS__' => JDCK . '/Public/js',
            '__IMG__' => JDCK . '/Public/images',
            '__zlc__' => 'http://xyhs.zhongliche.com/index.php',
    ),

    'ERROR_PAGE'            =>  '/Home/Errors/error', // 错误定向页面
    //扩展配置
    'LOAD_EXT_CONFIG'       => 'Status_Config',
);