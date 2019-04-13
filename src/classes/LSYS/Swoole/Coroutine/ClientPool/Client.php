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
        $this->config=$config+
        [
            'sock_type'=>SWOOLE_SOCK_TCP,
            'host'=>'127.0.0.1',
            'port'=>8099,
            'set'=>array(
                'connect_timeout' => 8.0,
//                 'open_length_check'     => 1,
//                 'package_length_type'   => 'N',
//                 'package_length_offset' => 0,       //第N个字节是包长度的值
//                 'package_body_offset'   => 4,       //第几个字节开始计算长度
//                 'package_max_length'    => 8192000,  //协议最大长度
            )
        ];
        $this->create();
        $this->connect();
    }
    protected function create(){
        if($this->client)@$this->client ->close();
        $this->client = new \Swoole\Coroutine\Client($this->config['sock_type']);
    }
    protected function connect(){
        $client=$this->client;
        $client->set($this->config['set']);
        if(!$client->connect($this->config['host'], $this->config['port'],$this->config['set']['connect_timeout'])){
            $errno=$client->errCode;
            $error = 'Socket: Could not connect to '.$this->config['host'].':'.$this->config['port'].' ['.$errno.'])';
            throw new \LSYS\Exception($error,10086);
        }
        $this->client=$client;
        return true;
    }
    public function swoole_client(){
        return $this->client;
    }
    protected $msg;
    public function errMsg(){
        return $this->msg;
    }
    public function reConnect():bool
    {
        //重启数据库,原对象不能再连接上了.所以重新NEW
        $this->create();
        try{
            return $this->connect();//重连原数据库
        }catch(\Exception $e){
            $this->msg=$e->getMessage();
            \LSYS\Loger\DI::get()->loger()->add(\LSYS\Loger::ERROR,$e);
        }
        return false;
    }
	public function close()
    {
        @$this->client->close(); 
    }
}
