<?php
/**
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\Swoole\Coroutine\ClientPool;
/**
 * @method \LSYS\Swoole\Coroutine\ClientPool swoole_client_pool($config=null) 得到SWOOLE client连接池
 */
class DI extends \LSYS\DI{
    /**
     *
     * @var string default config
     */
    public static $config = 'swoole.client_pool';
    /**
     * @return static
     */
    public static function get(){
        $di=parent::get();
        !isset($di->swoole_client_pool)&&$di->swoole_client_pool(new \LSYS\DI\ShareCallback(function($config=null){
            return $config?$config:self::$config;
        },function($config=null){
            $config=\LSYS\Config\DI::get()->config($config?$config:self::$config);
            return new \LSYS\Swoole\Coroutine\ClientPool($config);
        }));
        return $di;
    }
}