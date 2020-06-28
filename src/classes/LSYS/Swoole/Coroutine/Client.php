<?php
/**
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\Swoole\Coroutine;
use LSYS\Swoole\Exception;
class Client extends \Swoole\Coroutine\Client{
    protected $_config=[];
    public function __construct (array $config){
        $this->_config=$config+
        [
            'sock_type'=>SWOOLE_SOCK_TCP,
            'host'=>'127.0.0.1',
            'port'=>8099,
            'set'=>array(
                'connect_timeout' => 8.0,
            )
        ];
        parent::__construct($this->_config['sock_type']);
    }
    public function getConfig():array{
        return $this->_config;
    }
    public function connectFromConfig():bool{
        $config=$this->_config;
        $this->set($config['set']);
        if(!$this->connect($config['host'], $config['port'],$config['set']['connect_timeout'])){
            $errno=$this->errCode;
            $error = 'Socket: Could not connect to '.$config['host'].':'.$config['port'].' ['.$errno.'])';
            throw new Exception($error,10086);
        }
        return true;
    }
}