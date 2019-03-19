<?php
namespace LSYS\Swoole\Thrift\Server;
use Thrift\Exception\TTransportException;
use Thrift\Server\TServer;
/**
 * Simple implemtation of a Thrift server.
 *
 * @package thrift.server
 */
class TSwooleServer extends TServer
{
  /**
   * Listens for new client using the supplied
   * transport. It handles TTransportExceptions
   * to avoid timeouts etc killing it
   *
   * @return void
   */
  public function serve()
  {
      
      $serv=$this->transport_->create_swoole();
      $serv->on('workerStart', [$this, 'onStart']);
      $serv->on('receive', [$this, 'onReceive']);
      $serv->set($this->config);
      $this->transport_->listen();
      
      
      $this->transport_->listen();
      
      while (!$this->stop_) {
          try {
              $transport = $this->transport_->accept();
              
              if ($transport != null) {
                  $inputTransport = $this->inputTransportFactory_->getTransport($transport);
                  $outputTransport = $this->outputTransportFactory_->getTransport($transport);
                  $inputProtocol = $this->inputProtocolFactory_->getProtocol($inputTransport);
                  $outputProtocol = $this->outputProtocolFactory_->getProtocol($outputTransport);
                  while ($this->processor_->process($inputProtocol, $outputProtocol)) { }
              }
          } catch (TTransportException $e) { }
      }
      
      
      
//     $this->transport_->listen();

//     while (!$this->stop_) {
//       try {
//         $transport = $this->transport_->accept();

//         if ($transport != null) {
//           $inputTransport = $this->inputTransportFactory_->getTransport($transport);
//           $outputTransport = $this->outputTransportFactory_->getTransport($transport);
//           $inputProtocol = $this->inputProtocolFactory_->getProtocol($inputTransport);
//           $outputProtocol = $this->outputProtocolFactory_->getProtocol($outputTransport);
//           while ($this->processor_->process($inputProtocol, $outputProtocol)) { }
//         }
//       } catch (TTransportException $e) { }
//     }
  }
  function config($config){
      $this->config=$config;
      return $this;
  }
  /**
   * Stops the server running. Kills the transport
   * and then stops the main serving loop
   *
   * @return void
   */
  public function stop()
  {
    
  }
}
