<?php
namespace LSYS\Swoole\Coroutine\MySQLPool;
use LSYS\Swoole\Coroutine\Connection;
use LSYS\Swoole\Coroutine\MySQLPool;
/**
 * @method \LSYS\Swoole\Coroutine\MySQLPool getPool()
 */
class MySQL implements Connection{
	use \LSYS\Swoole\Coroutine\ConnectionTrait;
    protected $mysql;
    protected $config;
    public function __construct(MySQLPool $pool,$node,array $config){
        $this->pool=$pool;
        $this->node=$node;
        $this->config=$config;
        $this->create();
        $this->connect();
    }
    protected function create(){
		$this->close();
        $this->mysql=new \Swoole\Coroutine\MySQL();
    }
    /**
     * @return \Swoole\Coroutine\MySQL
     */
    public function mysql()
    {
        return $this->mysql;
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
        $config=$this->config+
        [
            'host' => '127.0.0.1',
            'port' => 3306,
            'user' => 'root',
            'password' => '110',
            'fetch_mode' 		=> 1,
            'database' => 'test',
        ];
        $re=@$this->mysql->connect($config);
        if(!$re)throw new \LSYS\Exception($this->mysql->connect_error,$this->mysql->connect_errno);
        return $re;
    }
	public function close()
    {
        if($this->mysql){
            @$this->mysql->close();
            $this->mysql=null;
        }
    }
}
