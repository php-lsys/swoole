<?php
use Information\NewsClient;
use Thrift\Protocol\TJSONProtocol;
require __DIR__."/boot.php";

//客户端带连接池实现

go(function () {
    
    $client_pool=LSYS\Swoole\Thrift\ClientPool\DI::get()->thrift_client_pool();
    $connect=$client_pool->pop("app1*");
    
    //协议要跟服务器对上
    $protocol = new TJSONProtocol($connect->transport());
    $client = new NewsClient($protocol);
    
    $client_pool->query($connect, function()use($client){
        $res=$client->test("fdasdfaddd");
        return $res;
    });
    
    $client_pool->push($connect);
     
});

