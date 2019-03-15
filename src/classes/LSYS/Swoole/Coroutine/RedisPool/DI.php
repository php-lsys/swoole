<?php
namespace LSYS\Swoole\Coroutine\RedisPool;
/**
 * @method \LSYS\Swoole\Coroutine\RedisPool swoole_redis_pool() 得到SWOOLE Redis对象
 */
class DI extends \LSYS\DI{
    /**
     *
     * @var string default config
     */
    public static $config = 'swoole.redis';
    /**
     * @return static
     */
    public static function get(){
        $di=parent::get();
        !isset($di->swoole_redis_pool)&&$di->swoole_redis_pool(new \LSYS\DI\ShareCallback(function($config=null){
            return $config?$config:self::$config;
        },function($config=null){
            $config=\LSYS\Config\DI::get()->config($config?$config:self::$config);
            return new \LSYS\Swoole\Coroutine\RedisPool($config);
        }));
        return $di;
    }
}