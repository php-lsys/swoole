<?php
include_once __DIR__."/../vendor/autoload.php";
\LSYS\Config\File::dirs(array(
    //设置配置目录
    __DIR__."/config",
));



go(function () {
    //可以在以下基础上在进行一次封装.如集成进 swoft
    $mysql=\LSYS\Swoole\Coroutine\DI::get()->swoole_mysql_pool();
    //如果你使用框架带了依赖管理器,可通过把自行NEW对象并注册到你的依赖管理器中
    //$mysql = new \LSYS\Swoole\Coroutine\MySQLPool($config);
    for ($i = 0; $i < 100; $i++) {
        co::create(function ()use($mysql){
            //从线程池中得到一个MYSQL连接对象
            $connection=$mysql->pop();//默认从 master* 的配置获取连接
            //$connection=$mysql->pop("slave*");//从库随机得到一个连接
            //$connection=$mysql->pop("slave1");//从库slave1得到一个连接
            
            //
            //$connection->mysql() 返回 \Swoole\Coroutine\MySQL 对象
            //
            //$res=$connection->mysql()->query("select sleep(1)");
            //辅助请求方法,改成下面形式 用于非事务请求时断链自动重启连接并请求
            $res=$mysql->query($connection, function()use($connection){
                return $connection->mysql()->query("select sleep(1)");
            });
            var_dump($res);
            //使用完还回线程池,必须手动还
            //$connection->getPool()->push($connection);
            $mysql->push($connection);
            
            var_dump($mysql->stats());
            
        });
    }
});
