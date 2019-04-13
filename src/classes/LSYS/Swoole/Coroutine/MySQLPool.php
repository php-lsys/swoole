<?php
namespace LSYS\Swoole\Coroutine;
use LSYS\Swoole\Exception;
/**
 * @method \LSYS\Swoole\Coroutine\MySQLPool\MySQL pop($node="master*")
 * @method static push(\LSYS\Swoole\Coroutine\MySQLPool\MySQL $connection)
 */
class MySQLPool extends Pool{
    protected function createConnection($node):Connection{
        return new \LSYS\Swoole\Coroutine\MySQLPool\MySQL($this,$node,$this->config->get($node.".connection",[]));
    }
    /**
     * @param \LSYS\Swoole\Coroutine\MySQLPool\MySQL $connect 
     * @param mixed $result 
     */
    protected function checkReQuery(Connection $connect,$result):bool{
        if($result||is_array($result))return false;
        $mysql=$connect->mysql();
        if($mysql->errno=='2006'
            ||$mysql->errno=='2013'
            ||(isset($mysql->errCode)&&$mysql->errCode=='5001')
            ){
            while (true) {
                $succ=$connect->reConnect();
                if($succ)break;
                $sleep=$this->config->get("sleep",0);
                if($sleep)\co::sleep($sleep);
                if(!$this->isTryConnect())break;
            }
            if($succ)return $succ;
        }
        throw new Exception($mysql->error,$mysql->errno);
    }
}