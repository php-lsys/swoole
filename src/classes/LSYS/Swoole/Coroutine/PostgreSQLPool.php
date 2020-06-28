<?php
/**
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\Swoole\Coroutine;
use LSYS\Swoole\Exception;
/**
 * @method \LSYS\Swoole\Coroutine\PostgreSQLPool\PostgreSQL pop($node="master*")
 * @method static push(\LSYS\Swoole\Coroutine\PostgreSQLPool\PostgreSQL $connection)
 */
class PostgreSQLPool extends Pool{
    protected function createConnection($node):Connection{
        return new \LSYS\Swoole\Coroutine\PostgreSQLPool\PostgreSQL($this,$node,$this->config->get($node.".connection",[]));
    }
    /**
     * @param \LSYS\Swoole\Coroutine\PostgreSQLPool\PostgreSQL $connect
     * @param mixed $mysql
     * @param string $mysql
     */
    protected function checkReQuery(Connection $connect,$result):bool{
        if($result)return false;
        throw new Exception("pg query error");
    }
}