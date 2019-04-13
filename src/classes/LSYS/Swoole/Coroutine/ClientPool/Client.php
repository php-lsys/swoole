<?php
namespace LSYS\Swoole\Coroutine\ClientPool;
use LSYS\Swoole\Coroutine\Connection;
use LSYS\Swoole\Coroutine\ClientPool;
/**
 * @method \LSYS\Swoole\Thrift\ClientPool getPool()
 */
class Client implements Connection{
	use \LSYS\Swoole\Coroutine\ConnectionTrait;
    protected $client;
    protected $config;
    public function __construct(ClientPool $pool,$node,array $config){
        $this->pool=$pool;
        $this->node=$node;
        $this->config=$config;
        $this->create();
        $this->client->connectFromConfig();
    }
    protected function create(){
        $this->close();
        $this->client = new \LSYS\Swoole\Coroutine\Client($this->config);
    }
    /**
     * @return \LSYS\Swoole\Coroutine\Client
     */
    public function swoole_client(){
        return $this->client;
    }
    protected $msg;
    public function errMsg(){
        return $this->msg;
    }
    public function reConnect():bool
    {
        $this->create();
        try{
            return $this->client->connectFromConfig();//重连原数据库
        }catch(\Exception $e){
            $this->msg=$e->getMessage();
            \LSYS\Loger\DI::get()->loger()->add(\LSYS\Loger::ERROR,$e);
        }
        return false;
    }
	public function close()
    {
        if($this->client)@$this->client->close(); 
    }
}
