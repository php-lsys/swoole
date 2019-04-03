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
     * 检测请求结果,返回true 重试请求,返回false不重试请求
     * @param Connection $connect
     * @param mixed|\Exception $result 请求结果或请求执行时异常
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
            try{
                $res=call_user_func($callback,$connect);
            }catch (\Exception $e){//抛出异常
                if(!$this->checkReQuery($connect,$e)) throw $e;//不重试 继续抛出异常
            }
            if(isset($e))unset($e);
            else if(!$this->checkReQuery($connect,$res))return $res;
            $sleep=$this->config->get("sleep",0);
            if($sleep)\co::sleep($sleep);
            if(!$this->isTryConnect())break;
        }
        return $res;
    }
    /**
     * 从池中取得一个连接,记得归还
     * @param string $node master* 约定使用master开头的配置 获取指定配置不要加*
     * @return Connection
     */
    public function pop(string $node="master*"):Connection
    {
        if(substr($node, -1)=='*'){//按权重获取
            $_config=[];
            $config=$this->config()->asArray();
            $node=substr($node, 0,-1);
            if(strlen($node)>0){
                foreach ($config as $k=>$v){
                    if(isset($v['connection'])&&strpos($k, $node)===0){
                        $_config[$k]=$v;
                    }
                }
            }else{
                foreach ($config as $k=>$v){
                    if(isset($v['connection'])){
                        $_config[$k]=$v;
                    }
                }
            }
            $filter_key=array();
            $channel=null;//第一个从权重中拿到的 channel
            if(count($_config)==0)$this->nodeCheck($node);
            foreach ($_config as $v){
                foreach ($filter_key as $vv)unset($_config[$vv]);
                $is_last=count($_config)==1;
                if($is_last)$node=key($_config);
                else {
                    $node=$this->configWeightGet($_config);
                    $filter_key[]=$node;
                }
                $_channel=$this->nodeFindChannel($node);
                if(!$channel)$channel=$_channel;
                if($_channel->isEmpty()){
                    if($this->currentCount($node)<$_channel->capacity){
                        $this->currentCount[$node]++;
                        return $this->createConnection($node);
                    }else{
                        if($is_last)break;//
                    }
                }else{
					$channel=$_channel;
				 	break;//存在连接在队列
				}
            }
        }else{//指定某服务器
            $channel=$this->nodeFindChannel($node);
            if($channel->isEmpty()){
				if($this->currentCount($node)<$channel->capacity){
                	$this->currentCount[$node]++;
                	return $this->createConnection($node);
				}
            }
        }
		//不为空，丢弃超时连接，感觉没什么卵用，好像很多框架都有这个，补上
		//如果有设置的话，才进行操作。
		$config=$this->config->get($node);
		if(!$channel->isEmpty()
			&&isset($config['keep_size'])
			&&isset($config['keep_time'])
			&&isset($config['size'])
			&&$config['size']>0
			&&$config['keep_size']>0
			&&$config['keep_size']<$config['size']
			&&$config['keep_time']>0
		){
			while(true){
			    if($channel->length()<=$config['keep_size'])break;
				$connection=$channel->pop();
				if((time()-$connection->lastPushTime())>$config['keep_time']){
					$this->currentCount[$node]--;
					$connection->close();
				}else return $connection;
			}	
		}
        return $channel->pop();
    }
	//得到node节点的连接数量
    protected function currentCount($node) {
        if(!isset($this->currentCount[$node])) $this->currentCount[$node]=0;
        return $this->currentCount[$node];
    }
    protected function nodeCheck($node) {
        if(empty($node)||!$this->config->exist($node)){
            throw new Exception(strtr("node[:node] not find",[":node"=>$node]));
        }
    }
	//通过节点名查找channel
    protected function nodeFindChannel($node) {
        if(!isset($this->channel[$node])){
            $this->nodeCheck($node);
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
		$connection->changePushTime();
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
    /**
     * 返回所有队列的统计数据,参见 channel 的 stats 返回
     * @return number[]
     */
    public function stats(){
        $out=array();
        foreach ($this->channel as $k=>$v){
            $out[$k]=$v->stats();
            $out[$k]['current_num']=$this->currentCount($k);
        }
        return $out;
    }
}
