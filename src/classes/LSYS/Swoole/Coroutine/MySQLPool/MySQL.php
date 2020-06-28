<?php
/**
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
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
    public function __construct(MySQLPool $pool,string $node,array $config){
        $this->pool=$pool;
        $this->node=$node;
        $this->config=$config;
        $this->create();
        $this->mysql->connectFromConfig();
    }
    protected function create(){
		$this->close();
        $this->mysql=new \LSYS\Swoole\Coroutine\MySQL($this->config);
    }
    /**
     * @return \LSYS\Swoole\Coroutine\MySQL
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
            return $this->mysql->connectFromConfig();//重连原数据库
        }catch(\Exception $e){
            \LSYS\Loger\DI::get()->loger()->add(\LSYS\Loger::ERROR,$e);
        }
        return false;
    }
    public function close():bool
    {
        if($this->mysql){
            @$this->mysql->close();
            $this->mysql=null;
        }
        return true;
    }
}
