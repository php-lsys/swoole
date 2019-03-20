<?php
error_reporting(E_ALL);
use Thrift\ClassLoader\ThriftClassLoader;
use Information\NewsProcessor;
use Thrift\Factory\TJSONProtocolFactory;
$autoload=require __DIR__."/../vendor/autoload.php";
$autoload->setPsr4("",[__DIR__."/src/"]);
LSYS\Config\File::dirs(array(
    __DIR__."/config",
));
$loader = new ThriftClassLoader();
$loader->registerDefinition('Information',  __DIR__.'/gen-php');
$loader->register();
$config=(new LSYS\Config\File("swoole"))->get("news",[]);
$handler = new \Services\Information\NewsHandler();
$processor = new NewsProcessor($handler);
$swoole = new \Swoole\Server('0.0.0.0', 8099);
$protocol = new TJSONProtocolFactory();
$server = new LSYS\Swoole\Thrift\Server\TSwooleServer($processor,$swoole,$protocol, $protocol);
$server->config($config)->serve();
