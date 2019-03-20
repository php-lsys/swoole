<?php
use Thrift\Transport\TSocket;
use Information\NewsClient;
use Thrift\Transport\TFramedTransport;
use Thrift\Protocol\TJSONProtocol;
require __DIR__."/boot.php";


//TSocket -> fsockopen -> php stream  swoole 可协程化php的stream 所以TSocket可用
$socket = new TSocket("127.0.0.1", 8099);
$transport = new TFramedTransport($socket);

//协议要跟服务器对上
$protocol = new TJSONProtocol($transport);


$client = new NewsClient($protocol);
$transport->open();

//同步方式进行交互
// $recv = $client->test("fdasdfaddd");
// print_r($recv);


//异步方式进行交互
$client->send_test('data1');
$client->send_test('data2');
$recv = $client->recv_test();
print_r($recv);
$recv = $client->recv_test();
print_r($recv);

$transport->close();

