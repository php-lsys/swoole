<?php
return array(
    "mysql"=>array(
        'host' => '127.0.0.1',
        'port' => 3306,
        'user' => 'root',
        'password' => '110',
        'fetch_mode' 		=> 1,
        'database' => 'test',
        //'charset' => 'utf8',//字符编码
     ),
    "mysql_pool"=>array(
        "try"=>true,//发送错误重试次数,设置为TRUE为不限制
        "sleep"=>1,//断开连接重连暂停时间
        "table_prefix"=>"t_",//表前缀
        "master"=>array(
            "size"=>1,//队列长度
			//设置下面两个会清理释放空闲链接
			//"keep_size"=>1,//空闲时保留链接数量
			//"keep_time"=>300,//空闲超过300关闭链接
            "weight"=>1,//权重
            "connection"=>array(//这里配置根据每个连接不同自定义.这里是MYSQL配置
                //'charset' => 'utf8',//字符编码
                'host' => '127.0.0.1',
                'port' => 3306,
                'user' => 'root',
                'password' => '110',
                'fetch_mode' 		=> 1,
                'database' => 'test',
            )
        ),
        "slave1"=>array(
            "size"=>1,//队列长度
            "weight"=>1,//权重
            "connection"=>array(
                'host' => '127.0.0.1',
                'port' => 3306,
                'user' => 'root',
                'password' => '110',
                'fetch_mode' 		=> 1,
                'database' => 'test',
            )
        ),
        "slave2"=>array(
            "size"=>1,//队列长度
            "weight"=>1,//权重
            "connection"=>array(
                'host' => '127.0.0.1',
                'port' => 3306,
                'user' => 'root',
                'password' => '110',
                'fetch_mode' 		=> 1,
                'database' => 'test',
            )
        ),
        "slave3"=>array(
            "size"=>1,//队列长度
            "weight"=>1,//权重
            "connection"=>array(
                'host' => '127.0.0.1',
                'port' => 3306,
                'user' => 'root',
                'password' => '110',
                'fetch_mode' 		=> 1,
                'database' => 'test',
            )
        ),
    ),
    "redis"=>array(
      ///  'auth'              =>'sss',
        'host'             	=> '192.168.1.101',
        'port'             	=> 6379,
        'timeout'			=> '60',
        'db'				=> NULL,
    ),
    "redis_pool"=>array(
        "try"=>true,//发送错误重试次数,设置为TRUE为不限制
        "sleep"=>1,//断开连接重连暂停时间
        "master"=>array(
            "size"=>1,//队列长度
            "weight"=>1,//权重
            "connection"=>array(
               // 'auth'              =>'xxx',
                'host'             	=> '192.168.1.101',
                'port'             	=> 6379,
                'timeout'			=> '60',
                'db'				=> NULL,
            )
        ),
    ),
    "postgresql"=>array(
        'dsn' => 'host=127.0.0.1 port=5432 dbname=test user=root password=',
    ),
    "postgresql_pool"=>array(
        "try"=>true,//发送错误重试次数,设置为TRUE为不限制
        "sleep"=>1,//断开连接重连暂停时间
        "master"=>array(
            "size"=>1,//队列长度
            "weight"=>1,//权重
            "connection"=>array(
                'dsn' => 'host=127.0.0.1 port=5432 dbname=test user=root password=',
            )
        ),
    ),
);
