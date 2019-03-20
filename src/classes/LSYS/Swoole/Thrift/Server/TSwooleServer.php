<?php
namespace LSYS\Swoole\Thrift\Server;
use Thrift\Factory\TTransportFactory;
use Thrift\Factory\TProtocolFactory;
use LSYS\Swoole\Thrift\Socket;
use Thrift\Transport\TFramedTransport;
/**
 * Simple implemtation of a Thrift server.
 *
 * @package thrift.server
 */
class TSwooleServer
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
    /**
     * Processor to handle clients
     */
    protected $processor_;
    /**
     * @var \Swoole\Server
     */
    protected $server_;
    /**
     * Input protocol factory
     *
     * @var TProtocolFactory
     */
    protected $inputProtocolFactory_;
    
    /**
     * Output protocol factory
     *
     * @var TProtocolFactory
     */
    protected $outputProtocolFactory_;
    
    /**
     * Sets up all the factories, etc
     *
     * @param object $processor
     * @param \Swoole\Server $server
     * @param TTransportFactory $inputTransportFactory
     * @param TTransportFactory $outputTransportFactory
     * @param TProtocolFactory $inputProtocolFactory
     * @param TProtocolFactory $outputProtocolFactory
     * @return void
     */
    public function __construct($processor,
        \Swoole\Server $server,
        TProtocolFactory $inputProtocolFactory,
        TProtocolFactory $outputProtocolFactory) {
            $this->processor_ = $processor;
            $this->server_ = $server;
            $this->inputProtocolFactory_ = $inputProtocolFactory;
            $this->outputProtocolFactory_ = $outputProtocolFactory;
    }
    function config($config){
        $this->config=$config;
        return $this;
    }
    /**
     * Serves the server. This should never return
     * unless a problem permits it to do so or it
     * is interrupted intentionally
     *
     * @abstract
     * @return void
     */
    public function serve(){
        $this->server_->on('receive', [$this, 'onReceive']);
        $this->server_->set($this->config+(array)$this->server_->setting);
        $this->server_->start();
    }
    /**
     * Stops the server serving
     *
     * @abstract
     * @return void
     */
    public function stop(){
        $this->server_->shutdown();
    }
    public function onReceive($serv, $fd, $from_id, $data)
    {
        $transport=new TSwooleFramedTransport();
        $transport->setHandle($fd);
        $transport->buffer = $data;
        $transport->server = $serv;
        $inputProtocol = $this->inputProtocolFactory_->getProtocol($transport);
        $outputProtocol = $this->outputProtocolFactory_->getProtocol($transport);
        try {
            $this->processor_->process($inputProtocol, $outputProtocol);
        } catch (\Exception $e) {
            $this->loger($e);
        }
    }
    protected function loger($e) {
        echo 'CODE:' . $e->getCode() . ' MESSAGE:' . $e->getMessage() . "\n" . $e->getTraceAsString();
    }
}
