<?php
include_once __DIR__."/../vendor/autoload.php";
\LSYS\Config\File::dirs(array(
    //设置配置目录
    __DIR__."/config",
));
go(function () {
    for ($i = 0; $i < 100; $i++) {
        co::create(function (){
            //可以在以下基础上在进行一次封装.如集成进 swoft
            //如果你使用框架带了依赖管理器,可通过把自行NEW对象并注册到你的依赖管理器中
            $redis=\LSYS\Swoole\Coroutine\RedisPool\DI::get()->swoole_redis_pool();
            //$msyql = new \LSYS\Swoole\Coroutine\RedisPool($config);
            //从线程池中得到一个连接对象
            $connection=$redis->pop();
            //辅助请求方法,改成下面形式 用于非事务请求时断链自动重启连接并请求
            $res=$redis->query($connection, function()use($connection){
                return $connection->redis()->set("bbbb","bbb");
            });
            var_dump($res);
            $res=$redis->query($connection, function()use($connection){
                return $connection->redis()->get("bbbb");
            });
            var_dump($res);
            //使用完还回线程池,必须手动还
            $redis->push($connection);
        });
    }
});