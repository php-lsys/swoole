<?php
/**
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\Swoole\Coroutine;
use LSYS\Swoole\Exception;
/**
 * @method \LSYS\Swoole\Coroutine\RedisPool\Redis pop($node="master*")
 * @method static push(\LSYS\Swoole\Coroutine\RedisPool\Redis $connection)
 */
class RedisPool extends Pool{
    protected function createConnection($node):Connection{
        return new \LSYS\Swoole\Coroutine\RedisPool\Redis($this,$node,$this->config->get($node.".connection",[]));
    }
    /**
     * {@inheritDoc}
     * @see \LSYS\Swoole\Coroutine\Pool::checkReQuery()
     */
    protected function checkReQuery(Connection $connect,$result):bool{
        if($result instanceof \Exception) return false;
        $no=$connect->getErrno();
        if(!$no||$no=='0')return false;
        while ($no=='1') {
            $succ=$connect->reConnect();
            if($succ)break;
            $sleep=$this->config->get("sleep",0);
            if($sleep)\co::sleep($sleep);
            if(!$this->isTryConnect())break;
        }
        if($succ)return $succ;
        throw new Exception($connect->getError(),$no);
    }
}