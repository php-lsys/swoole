<?php
namespace LSYS\Swoole\Coroutine;
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
     * 得到连接对象
     * @return object
     */
    public function get();
    /**
     * 得到连接池对象
     * @return Pool
     */
    public function getPool();
}