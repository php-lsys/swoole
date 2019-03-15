<?php
namespace LSYS\Swoole\Coroutine\PostgreSQLPool;
use LSYS\Swoole\Coroutine\Connection;
class PostgreSQL implements Connection{
    protected $pgsql;
    protected $config;
    protected $node;
    public function __construct($node,array $config){
        $this->node=$node;
        $this->config=$config;
        $this->create();
        $this->connect();
    }
    protected function create(){
        if($this->pgsql){
            $this->pgsql=null;
        }
        $this->pgsql=new \Swoole\Coroutine\PostgreSQL();
    }
    /**
     * @return \Swoole\Coroutine\PostgreSQL
     */
    public function get()
    {
        return $this->pgsql;
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
     * @param \Swoole\Coroutine\PostgreSQL $pgsql
     * @return bool
     */
    protected function connect():bool{
        $config=$this->config+
        [
            'dsn' => 'host=127.0.0.1 port=5432 dbname=test user=root password=',
        ];
        $conn  = $this->pgsql -> connect ($config['dsn']);
        print_r($this->pgsql);exit;
        if(!$conn){
            throw new \LSYS\Exception($this->pgsql->error,$this->pgsql->errno);
        }
        return $conn;
    }
    public function node():string
    {
        return $this->node;
    }
}