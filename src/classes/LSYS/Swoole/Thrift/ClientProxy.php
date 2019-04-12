<?php
namespace LSYS\Swoole\Thrift;
use LSYS\Config;
use Thrift\Transport\TSocket;
use Thrift\Transport\TFramedTransport;
use Thrift\Transport\TTransport;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Protocol\TProtocol;
class ClientProxy{
    public static function diMethod($client,$default_config_name){
        return function($config_name=null,ClientProxy $client_proxy=null)use($client,$default_config_name){
            $config=\LSYS\Config\DI::get()->config($config_name?$config_name:$default_config_name);
            if ($client_proxy) {
                return new ClientProxy($client_proxy->getTransport(),$client);
            }
            return ClientProxy::create($client, $config);
        };
    }
    public static function create($client,Config $config) {
        $config=$config->asArray()+array(
            'socket'=>TSocket::class,
            'args'=>array(
                '127.0.0.1','8099'
            ),
        );
        $socket=(new \ReflectionClass($config['socket']))->newInstanceArgs($config['args']);
        $transport=new TFramedTransport($socket);
        return new self($transport, $client);
    }
    protected $client;
    protected $protocol;
    public function __construct(TTransport $transport,$client,callable $protocol=null) {
        if(is_callable($protocol)){
            $protocol=call_user_func($transport);
            assert($protocol instanceof TProtocol);
        }else{
            $protocol=new TBinaryProtocolAccelerated($transport);
        }
        if (is_callable($client)) {
            $this->client=call_user_func($client,$protocol);
        }else{
            $this->client=(new \ReflectionClass($client))->newInstance($protocol);
        }
        $this->protocol=$protocol;
    }
    public function getTransport(){
        return $this->protocol->getTransport();
    }
    public function __call($method,$param_arr) {
        if (!$this->protocol->getTransport()->isOpen()) {
            $this->protocol->getTransport()->open();
        }
        return call_user_func_array([$this->client,$method], $param_arr);
    }
}