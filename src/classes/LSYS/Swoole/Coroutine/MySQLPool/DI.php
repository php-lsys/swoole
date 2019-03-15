<?php
namespace LSYS\Swoole\Coroutine\MySQLPool;
/**
 * @method \LSYS\Swoole\Coroutine\MySQLPool swoole_mysql_pool() 得到SWOOLE MYSQL连接池
 */
class DI extends \LSYS\DI{
    /**
     *
     * @var string default config
     */
    public static $config = 'swoole.mysql';
    /**
     * @return static
     */
    public static function get(){
        $di=parent::get();
        !isset($di->swoole_mysql_pool)&&$di->swoole_mysql_pool(new \LSYS\DI\ShareCallback(function($config=null){
            return $config?$config:self::$config;
        },function($config=null){
            $config=\LSYS\Config\DI::get()->config($config?$config:self::$config);
            return new \LSYS\Swoole\Coroutine\MySQLPool($config);
        }));
        return $di;
    }
}