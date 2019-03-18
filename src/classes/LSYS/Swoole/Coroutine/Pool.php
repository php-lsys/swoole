<?php
namespace LSYS\Swoole\Coroutine;
use LSYS\Config;
use LSYS\Exception;
abstract class Pool{
    /**
     * @var Config
     */
    protected $config;
    /**
     * @var int
     */
    protected $currentCount=[];
    /**
     * @var \Swoole\Coroutine\Channel[]
     */
    protected $channel=[];
    /**
     * 发生错误剩余重试次数
     * @var int|bool
     */
    protected $_try;
    public function __construct(Config $config) {
        $this->config=$config;
        if(!$config->exist("master"))throw new Exception("miss master config");
        $this->_try=$this->config->get("try",true);
    }
    /**
     * 返回配置对象
     * @return Config
     */
    public function config():Config{
        return $this->config;
    }
    /**
     * 创建连接
     * @return Connection
     */
    abstract protected function createConnection($node):Connection;
    /**
     * 检测请求结果
     * @param Connection $connect
     * @param mixed $result
     * @return bool
     */
    abstract protected function checkReQuery(Connection $connect,$result):bool;
    /**
     * 检测方式请求,请勿在事务中使用
     * @param Connection $connect
     * @param callable $callback
     * @return mixed
     */
    public function query(Connection $connect,callable $callback){
        while (true) {
            $res=call_user_func($callback,$connect);
            if(!$this->checkReQuery($connect,$res))return $res;
            $sleep=$this->config->get("sleep",0);
            if($sleep)\co::sleep($sleep);
            if(!$this->isTryConnect())break;
        }
        return $res;
    }
    /**
     * 从池中取得一个连接,记得归还
     * @param string $node master* 为匹配配置中 master开头的配置 获取指定配置不要加*
     * @return Connection
     */
    public function pop(string $node="master*"):Connection
    {
        $cid=\Swoole\Coroutine::getUid();
        if($cid>0){
            $this->list[$cid]=$comm;
        }
        if(substr($node, -1)=='*'){//按权重获取
            $_config=[];
            $config=$this->config()->as_array();
            if(strlen($node)>1){
                $_node=substr($node, 0,-1);
                foreach ($config as $k=>$v){
                    if(isset($v['connection'])&&strpos($k, $_node)===0){
                        $_config[$k]=$v;
                    }
                }
            }else $_config=$config;
            $filter_key=array();
            $channel=null;//第一个从权重中拿到的 channel
            foreach ($_config as $v){
                foreach ($filter_key as $vv)unset($_config[$vv]);
                $is_last=count($_config)==1;
                if($is_last)$_node=key($_config);
                else {
                    $_node=$this->configWeightGet($_config);
                    $filter_key[]=$_node;
                }
                $_channel=$this->nodeFindChannel($_node);
                if(!$channel)$channel=$_channel;
                if($_channel->isEmpty()){
                    if($this->currentCount($_node)<$_channel->capacity){
                        $this->currentCount[$_node]++;
                        return $this->createConnection($_node);
                    }else{
                        if($is_last)break;//
                    }
                }else break;//存在连接在队列
            }
        }else{//指定某服务器
            $channel=$this->nodeFindChannel($node);
            if($channel->isEmpty()&&$this->currentCount($node)<$channel->capacity){
                $this->currentCount[$node]++;
                return $this->createConnection($node);
            }
        }
        return $channel->pop();
    }
    protected function currentCount($node) {
        if(!isset($this->currentCount[$node])) $this->currentCount[$node]=0;
        return $this->currentCount[$node];
    }
    protected function nodeFindChannel($node) {
        if(!isset($this->channel[$node])){
            if(!$this->config->exist($node)){
                throw new Exception(strtr("node[:node] not find",[":node"=>$node]));
            }
            $size=(int)$this->config->get($node.".size",1);
            $this->channel[$node] = new \Swoole\Coroutine\Channel($size);
        }
        return $this->channel[$node];
    }
    /**
     * 把连接归还回池中
     * @param Connection $connection
     * @return $this
     */
    public function push(Connection $connection){
        $node=$connection->node();
        if(!$this->config->exist($node)||!isset($this->channel[$node]))return $this;
        $this->channel[$node]->push($connection);
        return $this;
    }
    /**
     * 是否重试连接
     * @return boolean
     */
    protected function isTryConnect() {
        if(is_bool($this->_try)&&$this->_try)return true;
        $try=$this->_try=intval($this->_try);
        $this->_try--;
        return $try>0;
    }
    /**
     * 根据权重取配置
     * @param array $config_array
     * @return string
     */
    protected function configWeightGet(array $config_array):string{
        $weight=0;
        $wa=array();
        $nodes=array();
        $k=0;
        foreach ($config_array as $key=>$item){
            if(!is_array($item))continue;
            $nodes[$k]=$key;
            $wa[$k]=intval(isset($item['weight'])?$item['weight']:1);
            $wa[$k]=$wa[$k]<=0?1:$wa[$k];
            $weight+=$wa[$k];
            $k++;
        }
        if($weight===0)return NULL;
        $_k=0;
        $_c=0;
        $r=rand(1,$weight);
        foreach ($wa as $k=>$v){
            $_c+=$v;
            if ($_c>=$r){
                $_k=$k;break;
            }
        }
        return $nodes[$_k];
    }
    public function startClear() {
        //\Swoole\Coroutine::getUid()
    }
    public function clear() {
        
    }
}