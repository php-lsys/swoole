<?php
/**
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\Swoole\Coroutine;
/**
 * @method \LSYS\Swoole\Coroutine\Client swoole_client($config) 得到SWOOLE client (非共享,每次调用创建)
 * @method \LSYS\Swoole\Coroutine\MySQL swoole_mysql($config=null) 得到SWOOLE MySQL
 * @method \LSYS\Swoole\Coroutine\PostgreSQL swoole_postgresql($config=null) 得到SWOOLE PostgreSQL
 * @method \LSYS\Swoole\Coroutine\Redis swoole_redis($config=null) 得到SWOOLE Redis(不建议使用 建议用lsys/redis客户端)
 */
class DI extends \LSYS\DI{
    /**
     * @var string 默认MYSQL配置
     */
    public static $config_mysql = 'swoole.mysql';
    /**
     * @var string 默认REDIS配置
     */
    public static $config_redis = 'swoole.redis';
    /**
     * @var string 默认PG配置
     */
    public static $config_postgresql = 'swoole.postgresql';
    /**
     * @return static
     */
    public static function get(){
        $di=parent::get();
        !isset($di->swoole_mysql)&&$di->swoole_mysql(new \LSYS\DI\ShareCallback(function($config=null){
            return $config?$config:self::$config_mysql;
        },function($config=null){
            $config=\LSYS\Config\DI::get()->config($config?$config:self::$config_mysql);
            return new \LSYS\Swoole\Coroutine\MySQL($config->asArray());
        }));
        !isset($di->swoole_postgresql)&&$di->swoole_postgresql(new \LSYS\DI\ShareCallback(function($config=null){
            return $config?$config:self::$config_postgresql;
        },function($config=null){
            $config=\LSYS\Config\DI::get()->config($config?$config:self::$config_postgresql);
            return new \LSYS\Swoole\Coroutine\PostgreSQL($config->asArray());
        }));
        !isset($di->swoole_redis)&&$di->swoole_redis(new \LSYS\DI\ShareCallback(function($config=null){
            return $config?$config:self::$config_redis;
        },function($config=null){
            $config=\LSYS\Config\DI::get()->config($config?$config:self::$config_redis);
            return new \LSYS\Swoole\Coroutine\Redis($config->asArray());
        }));
        !isset($di->swoole_client)&&$di->swoole_client(new \LSYS\DI\MethodCallback(function($config){
            $config=\LSYS\Config\DI::get()->config($config);
            return new \LSYS\Swoole\Coroutine\Client($config->asArray());
        }));
        return $di;
    }
}