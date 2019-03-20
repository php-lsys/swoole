<?php
namespace LSYS\Swoole\Thrift;
use Swoole\Process\Pool;
use LSYS\Swoole\Coroutine\Connection;
/**
 * @method \LSYS\Swoole\Thrift\ClientPool\Client pop($node="master*")
 * @method static push(\LSYS\Swoole\Thrift\ClientPool\Client $connection)
 */
class ClientPool extends Pool{
    protected function createConnection($node):Connection{
        return new \LSYS\Swoole\Thrift\ClientPool\Client($this,$node,$this->config->get($node.".connection",[]));
    }
    protected function checkReQuery(Connection $connect,$result):bool{
        if($result==true)return false;
        $error;
        $errno;
        throw new \LSYS\Exception($error,$errno);
    }
}