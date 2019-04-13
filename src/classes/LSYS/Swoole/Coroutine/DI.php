<?php
namespace LSYS\Swoole\Coroutine;
/**
 * @method \Swoole\Coroutine\Client swoole_client($config) 得到SWOOLE client (非共享,每次调用创建)
 * @method \Swoole\Coroutine\MySQL swoole_mysql($config=null) 得到SWOOLE MySQL
 * @method \Swoole\Coroutine\PostgreSQL swoole_postgresql($config=null) 得到SWOOLE PostgreSQL
 * @method \Swoole\Coroutine\Redis swoole_redis($config=null) 得到SWOOLE Redis(不建议使用 建议用lsys/redis客户端)
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
            $config=\LSYS\Config\DI::get()->config($config);
            $config=$config->asArray()+
            [
                'host' => '127.0.0.1',
                'port' => 3306,
                'user' => 'root',
                'password' => '110',
                'fetch_mode' 		=> 1,
                'database' => 'test',
            ];
            $mysql=new \Swoole\Coroutine\MySQL();
            $re=@$mysql->connect($config);
            if (!empty($config['charset'])) {
                $mysql->query("SET NAMES ".addslashes($config['charset']));
            }
            if(!$re)throw new \LSYS\Exception($mysql->connect_error,$mysql->connect_errno);
            return $mysql;
        }));
        !isset($di->swoole_postgresql)&&$di->swoole_postgresql(new \LSYS\DI\ShareCallback(function($config=null){
            return $config?$config:self::$config_postgresql;
        },function($config=null){
            $config=\LSYS\Config\DI::get()->config($config);
            $config=$config->asArray()+
            [
                'dsn' => 'host=127.0.0.1 port=5432 dbname=test user=root password=110',
            ];
            $pgsql=new \Swoole\Coroutine\PostgreSQL();
            $re=@$pgsql->connect($config);
            if(!$re)throw new \LSYS\Exception($pgsql->connect_error,$pgsql->connect_errno);
            return $pgsql;
        }));
        !isset($di->swoole_redis)&&$di->swoole_redis(new \LSYS\DI\ShareCallback(function($config=null){
            return $config?$config:self::$config_redis;
        },function($config=null){
            $config=\LSYS\Config\DI::get()->config($config);
            $config=$config->asArray()+
            [
                'host'             	=> 'localhost',
                'port'             	=> 6379,
                'timeout'			=> '60',
                'connect_timeout'	=> '60',
                'serialize'			=> false,
                'reconnect'			=> '1',
                'db'				=> NULL,
            ];
            $redis=new \Swoole\Coroutine\Redis();
            $res=$redis->connect($config['host'],$config['port']);
            if(!$res)throw new \LSYS\Exception($redis->errMsg,$redis->errCode);
            if(method_exists($redis, 'setOptions')){
                $redis->setOptions(array_intersect_key($config, array_flip(array(
                    'timeout','connect_timeout','serialize','reconnect',
                ))));
            }
            return $redis;
        }));
        !isset($di->swoole_client)&&$di->swoole_client(new \LSYS\DI\MethodCallback(function($config){
            $config=\LSYS\Config\DI::get()->config($config);
            $config=$config->asArray()+
            [
                'sock_type'=>SWOOLE_SOCK_TCP,
                'host'=>'127.0.0.1',
                'port'=>8099,
                'set'=>array(
                    'connect_timeout' => 8.0,
                )
            ];
            $client = new \Swoole\Coroutine\Client($config['sock_type']);
            $client->set($config['set']);
            if(!$client->connect($config['host'], $config['port'],$config['set']['connect_timeout'])){
                $errno=$client->errCode;
                $error = 'Socket: Could not connect to '.$config['host'].':'.$config['port'].' ['.$errno.'])';
                throw new \LSYS\Exception($error,10086);
            }
            return $client;
        }));
        return $di;
    }
}