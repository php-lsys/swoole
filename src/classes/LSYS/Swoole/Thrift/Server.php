<?php
namespace LSYS\Swoole\Thrift;
use Thrift;
use Thrift\Server\TServerTransport;
use Thrift\Factory\TTransportFactory;
use Thrift\Factory\TProtocolFactory;
use Thrift\Server\TServer;

class Server extends TServer
{
    protected $config=array(
        'worker_num'            => 1,
        'dispatch_mode'         => 1, //1: 轮循, 3: 争抢
        'open_length_check'     => true, //打开包长检测
        'package_max_length'    => 8192000, //最大的请求包长度,8M
        'package_length_type'   => 'N', //长度的类型，参见PHP的pack函数
        'package_length_offset' => 0,   //第N个字节是包长度的值
        'package_body_offset'   => 4,   //从第几个字节计算长度
    );
    protected $serviceName;
    protected $handlerName;
    public function __construct($processor,
        TServerTransport $transport,
        TTransportFactory $inputTransportFactory,
        TTransportFactory $outputTransportFactory,
        TProtocolFactory $inputProtocolFactory,
        TProtocolFactory $outputProtocolFactory) {
        assert($transport instanceof ServerTransport);
        parent::__construct($processor, $transport, $inputTransportFactory, $outputTransportFactory, $inputProtocolFactory, $outputProtocolFactory);
        $this->serviceName=get_class($processor);
        $this->handlerName='\Services\\'.preg_replace("/Processor$/", 'Handler', $this->serviceName);
    }
    
   
    
    public function stop() {
        $this->transport_->close();
    }
    
    function config($config){
        $this->config=$config;
        return $this;
    }
    
    function onStart()
    {
        
    }

    function notice($log)
    {
        echo $log."\n";
    }

    public function onReceive($serv, $fd, $from_id, $data)
    {
        $processor_class = $this->serviceName;
        $handler_class = $this->handlerName;

        $handler = new $handler_class();
        $processor = new $processor_class($handler);

        $socket = new Socket();
        $socket->setHandle($fd);
        $socket->buffer = $data;
        $socket->server = $serv;
        $protocol = new Thrift\Protocol\TBinaryProtocol($socket, false, false);

        try {
            $protocol->fname = $this->serviceName;
            $processor->process($protocol, $protocol);
        } catch (\Exception $e) {
            $this->notice('CODE:' . $e->getCode() . ' MESSAGE:' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
    
    public function serve() {
        $serv=$this->transport_->create_swoole();
        $serv->on('workerStart', [$this, 'onStart']);
        $serv->on('receive', [$this, 'onReceive']);
        $serv->set($this->config);
        $this->transport_->listen();
    }
}
