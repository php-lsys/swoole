<?php
/**
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\Swoole\Coroutine\PostgreSQLPool;
use LSYS\Swoole\Coroutine\Connection;
use LSYS\Swoole\Coroutine\PostgreSQLPool;
/**
 * @method \LSYS\Swoole\Coroutine\PostgreSQL getPool()
 */
class PostgreSQL implements Connection{
	use \LSYS\Swoole\Coroutine\ConnectionTrait;
    protected $pgsql;
    protected $config;
    public function __construct(PostgreSQLPool $pool,$node,array $config){
        $this->pool=$pool;
        $this->node=$node;
        $this->config=$config;
        $this->create();
        $this->pgsql->connectFromConfig();
    }
    protected function create(){
		$this->close();
        $this->pgsql=new \LSYS\Swoole\Coroutine\PostgreSQL($this->config);
    }
    /**
     * @return \Swoole\Coroutine\PostgreSQL
     */
    public function postgresql()
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
            return $this->pgsql->connectFromConfig();//重连原数据库
        }catch(\Exception $e){
            \LSYS\Loger\DI::get()->loger()->add(\LSYS\Loger::ERROR,$e);
        }
        return false;
    }
    public function close()
    {
		unset($this->pgsql);
        $this->pgsql=null;
    }
}
