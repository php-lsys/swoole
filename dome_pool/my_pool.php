<?php
use LSYS\Swoole\Coroutine\Connection;
use LSYS\Swoole\Coroutine\Pool;
include_once __DIR__."/../vendor/autoload.php";
\LSYS\Config\File::dirs(array(
    //设置配置目录
    __DIR__."/config",
));
//自定义连接池 实现下面两个类
class myclient implements Connection{
    use \LSYS\Swoole\Coroutine\ConnectionTrait;
    public function __construct($pool,$node,array $config){
        $this->pool=$pool;
        $this->node=$node;
        $this->config=$config;
    }
    public function get_client_method()
    {
        //得到客户端
    }
    public function reConnect(): bool
    {
        //重新连接
    }

    public function close()
    {
        //关闭连接
    }
}
class mypool extends Pool{
    protected function checkReQuery(Connection $connect, $result): bool
    {
        //根据$connect 和 $result 判断是否需要重新请求 返回true为需要重新请求
        //$connect 为 myclient 对象
    }

    protected function createConnection($node): Connection
    {
        //创建连接
    }
}

go(function () {
    
    $client = new mypool(new \LSYS\Config\File("config.yourapp"));//约定使用master配置开头配置
    $connection=$client->pop();
    
    //$connection->get_client_method(); 
    
    $connection->getPool()->push($connection);
   
});
    