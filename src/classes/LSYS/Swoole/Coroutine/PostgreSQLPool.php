<?php
namespace LSYS\Swoole\Coroutine;
/**
 * @method \LSYS\Swoole\Coroutine\PostgreSQLPool\PostgreSQL pop($node="master*")
 * @method static push(\LSYS\Swoole\Coroutine\PostgreSQLPool\PostgreSQL $connection)
 */
class PostgreSQLPool extends Pool{
    protected function createConnection($node):Connection{
        return new \LSYS\Swoole\Coroutine\PostgreSQLPool\PostgreSQL($node,$this->config->get($node.".connection",[]));
    }
    /**
     * @param \LSYS\Swoole\Coroutine\PostgreSQLPool\PostgreSQL $connect
     * @param mixed $mysql
     * @param string $mysql
     */
    protected function checkReQuery(Connection $connect,$result):bool{
        if($result)return false;
        throw new \LSYS\Exception("pg query error");
    }
}