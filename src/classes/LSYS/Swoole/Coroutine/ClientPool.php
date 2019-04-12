<?php
namespace LSYS\Swoole\Coroutine;
/**
 * @method \LSYS\Swoole\Coroutine\ClientPool\Client pop($node)
 * @method static push(\LSYS\Coroutine\Coroutine\ClientPool\Client $connection)
 */
class ClientPool extends Pool{
    protected function createConnection($node):Connection{
        return new \LSYS\Swoole\Coroutine\ClientPool\Client($this,$node,$this->config->get($node.".connection",[]));
    }
    protected function checkReQuery(Connection $connect,$result):bool{
        if($result!==false)return false;
        while (true) {
            $succ=$connect->reConnect();
            if($succ)break;
            $sleep=$this->config->get("sleep",0);
            if($sleep)\co::sleep($sleep);
            if(!$this->isTryConnect())break;
        }
        if($succ)return $succ;
        throw new \LSYS\Exception($connect->errMsg(),10087);
    }
}