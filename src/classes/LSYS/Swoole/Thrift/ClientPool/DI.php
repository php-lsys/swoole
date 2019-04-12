<?php
namespace LSYS\Swoole\Thrift\ClientPool;
/**
 * @method \LSYS\Swoole\Thrift\ClientPool thrift_client_pool() 得到Thrift client连接池
 */
class DI extends \LSYS\DI{
    /**
     *
     * @var string default config
     */
    public static $config = 'thrift.client_pool';
    /**
     * @return static
     */
    public static function get(){
        $di=parent::get();
        !isset($di->thrift_client_pool)&&$di->thrift_client_pool(new \LSYS\DI\ShareCallback(function($config=null){
            return $config?$config:self::$config;
        },function($config=null){
            $config=\LSYS\Config\DI::get()->config($config?$config:self::$config);
            return new \LSYS\Swoole\Thrift\ClientPool($config);
        }));
        return $di;
    }
}