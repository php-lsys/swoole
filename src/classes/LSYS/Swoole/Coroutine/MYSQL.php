<?php
/**
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\Swoole\Coroutine;
use LSYS\Swoole\Exception;
class MySQL extends \Swoole\Coroutine\MySQL{
    protected $_config=[];
    public function __construct (array $config){
        $this->_config=$config+
        [
            'host' => '127.0.0.1',
            'port' => 3306,
            'user' => 'root',
            'password' => '110',
            'fetch_mode'=> 1,
            'database' => 'test',
        ];
		parent::__construct();
    }
    public function getConfig():array{
        return $this->_config;
    }
    public function connectFromConfig():bool{
        $config=$this->_config;
        $re=@$this->connect($config);
        if (!empty($config['charset'])) {
            $this->query("SET NAMES ".addslashes($config['charset']));
        }
        if(!$re)throw new Exception($this->connect_error."[".$config['host'].":".$config['port']."]",$this->connect_errno);
        return true;
    }
}