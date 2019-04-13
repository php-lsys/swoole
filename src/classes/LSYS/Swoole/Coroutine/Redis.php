<?php
namespace LSYS\Swoole\Coroutine;
use LSYS\Swoole\Exception;
class Redis extends \Swoole\Coroutine\Redis{
    protected $_config;
    public function __construct (array $config){
        $this->_config=$config+
        [
            'host'             	=> 'localhost',
            'port'             	=> 6379,
            'timeout'			=> '60',
            'connect_timeout'	=> '60',
            'serialize'			=> false,
            'reconnect'			=> '1',
            'db'				=> NULL,
        ];
    }
    public function getConfig() {
        return $this->_config;
    }
    public function connectFromConfig(){
        $config=$this->_config;
        $this->setOptions(array_intersect_key($config, array_flip(array(
            'timeout','connect_timeout','serialize','reconnect',
        ))));
        $res=$this->connect($config['host'],$config['port']);
        if (isset($config['db']))$this->select($config['db']);
        if(!$res)throw new Exception($this->errMsg."[".$config['host'].":".$config['port']."]",$this->errCode);
        return true;
    }
}