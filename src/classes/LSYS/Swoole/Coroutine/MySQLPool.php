<?php
namespace LSYS\Swoole\Coroutine;
/**
 * @method \LSYS\Swoole\Coroutine\MySQLPool\MySQL pop($node="master")
 * @method static push(\LSYS\Swoole\Coroutine\MySQLPool\MySQL $connection)
 */
class MySQLPool extends Pool{
    protected function createConnection($node):Connection{
        return new \LSYS\Swoole\Coroutine\MySQLPool\MySQL($node,$this->config->get($node.".connection",[]));
    }
    /**
     * @param \LSYS\Swoole\Coroutine\MySQLPool\MySQL $connect 
     * @param mixed $result 
     * @param string $mysql 
     */
    protected function checkReQuery(Connection $connect,$result):bool{
        if($result==true)return false;
        $mysql=$connect->get();
        if($mysql->errno=='2006'
            ||$mysql->errno=='2013'
            ||$mysql->errCode=='5001'
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
        throw new \LSYS\Exception($mysql->error,$mysql->errno);
    }
}