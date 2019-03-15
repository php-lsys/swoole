<?php
namespace LSYS\Swoole\Coroutine\RedisPool;
use LSYS\Swoole\Coroutine\Connection;
class Redis implements Connection{
    protected $redis;
    protected $isswoole=true;
    protected $config;
    protected $node;
    public function __construct($node,array $config){
        $this->node=$node;
        $this->config=$config;
        $this->create();
        $this->connect();
    }
    protected function create(){
        if($this->redis){
            @$this->redis->close();
            $this->redis=null;
        }
        if (class_exists(\Swoole\Coroutine\Redis::class)) {
            $this->redis=new \Swoole\Coroutine\Redis();
        }else{
            $this->redis=new \Redis();
            $this->isswoole=0;
        }
    }
    /**
     * @return \Swoole\Coroutine\Redis
     */
    public function get()
    {
        return $this->redis;
    }
    public function getError() {
        if($this->isswoole){
            return $this->redis->errMsg;
        }else return $this->redis->getLastError();
    }
    public function getErrno() {
        if($this->isswoole){
            return $this->redis->errCode;
        }else return 0;
    }
    /**
     * {@inheritDoc}
     * @see \LSYS\Swoole\Coroutine\Connection::reConnect()
     */
    public function reConnect():bool
    {
        //重启数据库,原对象不能再连接上了.所以重新NEW
        $this->create();
        try{
            return $this->connect();//重连原数据库
        }catch(\Exception $e){
            \LSYS\Loger\DI::get()->loger()->add(\LSYS\Loger::ERROR,$e);
        }
        return false;
    }
    /**
     * @return bool
     */
    protected function connect():bool{
        $_config=$this->config+array(
            'host'             	=> 'localhost',
            'port'             	=> 6379,
            'timeout'			=> '60',
            'connect_timeout'	=> '60',
            'serialize'			=> false,
            'reconnect'			=> '1',
            'db'				=> NULL,
        );
        $res=$this->redis->connect($_config['host'],$_config['port']);
        if(!$res)throw new \LSYS\Exception($this->getError(),$this->getErrno());
        if(method_exists($this->redis, 'setOptions')){
            $this->redis->setOptions(array_intersect_key($_config, array_flip(array(
                'timeout','connect_timeout','serialize','reconnect',
            ))));
        }
        if (isset($_config['db']))$this->redis->select($_config['db']);
        return $res;
    }
    public function node():string
    {
        return $this->node;
    }
}