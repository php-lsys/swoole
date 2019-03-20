<?php
namespace LSYS\Swoole\Thrift;
use LSYS\Swoole\Coroutine\Connection;
use Thrift\Exception\TTransportException;
use LSYS\Swoole\Coroutine\Pool;
use Thrift\Exception\TException;
/**
 * @method \LSYS\Swoole\Thrift\ClientPool\Client pop($node)
 * @method static push(\LSYS\Swoole\Thrift\ClientPool\Client $connection)
 */
class ClientPool extends Pool{
    protected function createConnection($node):Connection{
        return new \LSYS\Swoole\Thrift\ClientPool\Client($this,$node,$this->config->get($node.".connection",[]));
    }
    protected function checkReQuery(Connection $connect,$result):bool{
        if($result instanceof TTransportException||(
            $result instanceof TException &&$result->getCode()=='110'
         )){
            //if(strpos($result->getMessage(), "TSocket: timed out")!==false)return false;
            while (true) {
                $succ=$connect->reConnect();
                if($succ)break;
                $sleep=$this->config->get("sleep",0);
                if($sleep)\co::sleep($sleep);
                if(!$this->isTryConnect())break;
            }
            if($succ)return $succ;
        }
        return false;
    }
}