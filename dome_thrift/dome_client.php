<?php

try {
    throw new Exception("fasd");
} catch (Exception $e) {
}

var_dump(isset($e));
exit;

use Thrift\ClassLoader\ThriftClassLoader;
use Thrift\Transport\TSocket;
use Thrift\Protocol\TBinaryProtocol;
use Information\NewsClient;
use Information\AdParam;
use Thrift\Transport\TFramedTransport;
use Thrift\Protocol\TJSONProtocol;
error_reporting(E_ALL);
$autoload=require __DIR__."/../vendor/autoload.php";
$autoload->setPsr4("",["src/"]);
$loader = new ThriftClassLoader();
$loader->registerDefinition('Information',  __DIR__.'/gen-php');
$loader->register();



$socket = new TSocket("127.0.0.1", 8099);
$transport = new TFramedTransport($socket);
$protocol = new TJSONProtocol($transport);
$client = new NewsClient($protocol);
$transport->open();

while (true) {
    //同步方式进行交互
    $recv = $client->test("fdasdfa");
    print_r($recv);
}



//异步方式进行交互
// $client->send_test('Us');
// echo "\n send_sayHello \n";
// $recv = $client->recv_test();
// echo "\n recv_sayHello:".$recv." \n";

$transport->close();

