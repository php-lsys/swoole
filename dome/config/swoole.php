<?php
return array(
    "mysql"=>array(
        "try"=>true,//发送错误重试次数,设置为TRUE为不限制
        "sleep"=>1,//断开连接重连暂停时间
        "master"=>array(
            "size"=>1,//队列长度
            "weight"=>1,//队列长度
            "connection"=>array(
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
            "weight"=>1,//队列长度
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
            "weight"=>1,//队列长度
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
            "weight"=>1,//队列长度
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
        "try"=>true,//发送错误重试次数,设置为TRUE为不限制
        "sleep"=>1,//断开连接重连暂停时间
        "master"=>array(
            "size"=>1,//队列长度
            "weight"=>1,//队列长度
            "connection"=>array(
                'auth'              =>'foobaredOu9u080D8FM987H98H98N&%%&%',
                'host'             	=> '192.168.1.101',
                'port'             	=> 6379,
                'timeout'			=> '60',
                'db'				=> NULL,
            )
        ),
    ),
    "postgresql"=>array(
        "try"=>true,//发送错误重试次数,设置为TRUE为不限制
        "sleep"=>1,//断开连接重连暂停时间
        "master"=>array(
            "size"=>1,//队列长度
            "weight"=>1,//队列长度
            "connection"=>array(
                'dsn' => 'host=127.0.0.1 port=5432 dbname=test user=root password=',
            )
        ),
    ),
);