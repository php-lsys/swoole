<?php
error_reporting(E_ALL);
use Thrift\ClassLoader\ThriftClassLoader;
use LSYS\Swoole\Thrift\FramedTransportFactory;
use LSYS\Swoole\Thrift\ServerTransport;
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
if (php_sapi_name() == 'cli') {//
    while(true){
        try{
            $socket_tranport = new ServerTransport('0.0.0.0', 8099);//修改你需要监听的端口
			$out_factory = $in_factory = new FramedTransportFactory();
			$out_protocol = $in_protocol = new TJSONProtocolFactory();
			$server = new LSYS\Swoole\Thrift\Server($processor, $socket_tranport, $in_factory, $out_factory, $in_protocol, $out_protocol);
			$server->config($config)->serve();
        }catch (Exception $e){
            print_r($e);
        }
    }
}ELSE{
   die('run in cli');
}
