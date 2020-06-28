<?php
/**
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\Swoole\Coroutine;
trait ConnectionTrait{
	protected $node;
    protected $pool;
	protected $lasttime;
    public function node():string
    {
        return $this->node;
    }
    /**
     * @return Pool
     */
    public function getPool():Pool
    {
        return $this->pool;
    }
	/**
     * 最后push时间
　　　　　* @return int
     */
	public function lastPushTime():int{
		return $this->lasttime;
	}
	/**
     * 更改push时间
     */
	public function changePushTime():int{
		 $this->lasttime=time();
	}
}
