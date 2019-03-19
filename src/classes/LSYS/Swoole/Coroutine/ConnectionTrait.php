<?php
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
	public function changePushTime(){
		 $this->lasttime=time();
	}
}
