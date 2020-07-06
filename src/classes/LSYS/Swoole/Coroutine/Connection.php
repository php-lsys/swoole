<?php
/**
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\Swoole\Coroutine;
//连接声明为接口，为了可以在某些对象上直接实现
interface Connection{
    /**
     * 配置节点
     * @return string
     */
    public function node():string;
    /**
     * 进行重新连接
     * @return bool
     */
    public function reConnect():bool;
    /**
     * 得到连接池对象
     * @return Pool
     */
    public function getPool():Pool;
	/**
     * 关闭链接
     */
	public function close():bool;
	/**
     * 最后push时间
　　　　　* @return int
     */
	public function lastPushTime():int;
	/**
     * 更改push时间
     */
	public function changePushTime();
}
