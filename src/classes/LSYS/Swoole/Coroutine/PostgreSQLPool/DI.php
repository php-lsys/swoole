<?php
namespace LSYS\Swoole\Coroutine\PostgreSQLPool;
/**
 * @method \LSYS\Swoole\Coroutine\PostgreSQLPool swoole_postgresql_pool() 得到SWOOLE PostgreSQL对象
 */
class DI extends \LSYS\DI{
    /**
     *
     * @var string default config
     */
    public static $config = 'swoole.postgresql';
    /**
     * @return static
     */
    public static function get(){
        $di=parent::get();
        !isset($di->swoole_postgresql_pool)&&$di->swoole_postgresql_pool(new \LSYS\DI\ShareCallback(function($config=null){
            return $config?$config:self::$config;
        },function($config=null){
            $config=\LSYS\Config\DI::get()->config($config?$config:self::$config);
            return new \LSYS\Swoole\Coroutine\PostgreSQLPool($config);
        }));
        return $di;
    }
}