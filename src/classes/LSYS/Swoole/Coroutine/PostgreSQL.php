<?php
/**
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\Swoole\Coroutine;
use LSYS\Swoole\Exception;
class PostgreSQL extends \Swoole\Coroutine\PostgreSQL{
    protected $_config=[];
    public function __construct (array $config){
        $this->_config=$config+
        [
            'dsn' => 'host=127.0.0.1 port=5432 dbname=test user=root password=110',
        ];
		parent::__construct();
    }
    public function getConfig():array{
        return $this->_config;
    }
    public function connectFromConfig():bool{
        $config=$this->_config;
        $re=@$this->connect($config);
        if(!$re){
            $dsn=preg_replace("/password.*/i", "password=******",$config['dsn']);
            throw new Exception($this->error."[".$dsn."]");
        }
        return true;
    }
}