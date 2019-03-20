<?php
use Information\NewsProcessor;
use Thrift\Factory\TJSONProtocolFactory;
require __DIR__."/boot.php";


$handler = new \Services\Information\NewsHandler();
$processor = new NewsProcessor($handler);


$swoole = new \Swoole\Server('0.0.0.0', 8099);

//协议一定要跟客户端请求对上
$protocol = new TJSONProtocolFactory();
// 二进制 TBinaryProtocolFactory

while (true) {
    $server = new LSYS\Swoole\Thrift\Server\TSwooleServer($processor,$swoole,$protocol, $protocol);
    $server->config([
        'worker_num'=>2
    ])->serve();
}

