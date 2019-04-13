<?php
namespace LSYS\Swoole\Coroutine;
use LSYS\Swoole\Exception;
class PostgreSQL extends \Swoole\Coroutine\PostgreSQL{
    protected $_config;
    public function __construct (array $config){
        $this->_config=$config+
        [
            'dsn' => 'host=127.0.0.1 port=5432 dbname=test user=root password=110',
        ];
    }
    public function getConfig() {
        return $this->_config;
    }
    public function connectFromConfig(){
        $config=$this->_config;
        $re=@$this->connect($config);
        if(!$re){
            $dsn=preg_replace("/password.*/i", "password=******",$config['dsn']);
            throw new Exception($this->error."[".$dsn."]");
        }
        return true;
    }
}