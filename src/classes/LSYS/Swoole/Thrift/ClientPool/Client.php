<?php
namespace LSYS\Swoole\Thrift\ClientPool;
use LSYS\Swoole\Coroutine\Connection;
use LSYS\Swoole\Thrift\ClientPool;
use Thrift\Transport\TFramedTransport;
use Thrift\Transport\TSocket;
/**
 * @method \LSYS\Swoole\Thrift\ClientPool getPool()
 */
class Client implements Connection{
	use \LSYS\Swoole\Coroutine\ConnectionTrait;
    protected $transport;
    protected $config;
    public function __construct(ClientPool $pool,$node,array $config){
        $this->pool=$pool;
        $this->node=$node;
        $this->config=$config+
        [
            'socket'=>TSocket::class,
            'args'=>['127.0.0.1',8099]
        ];
        $this->connect();
    }
    protected function connect(){
        $socket = (new \ReflectionClass($this->config['socket']))->newInstanceArgs($this->config['args']);
        $this->transport= new TFramedTransport($socket);
        $this->transport->open();
    }
    public function transport(){
        return $this->transport;
    }
    public function reConnect():bool
    {
        $this->close();
        try{
            $this->transport->open();
        }catch (\Exception $e){
            \LSYS\Loger\DI::get()->loger()->add(\LSYS\Loger::ERROR,$e);
            return false;
        }
        return true;
    }
	public function close()
    {
        @$this->transport->close(); 
    }
}
