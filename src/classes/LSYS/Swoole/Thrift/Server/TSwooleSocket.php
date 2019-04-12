<?php
namespace LSYS\Swoole\Thrift\Server;
use Thrift\Exception\TException;
use Thrift\Exception\TTransportException;
use Thrift\Transport\TTransport;
/**
 * Sockets implementation of the TTransport interface.
 *
 * @package thrift.transport
 */
class TSwooleSocket extends TTransport
{
  /**
   * Handle to PHP socket
   *
   * @var resource
   */
  protected $handle_ = null;

  /**
   * Remote hostname
   *
   * @var string
   */
  protected $host_ = 'localhost';

  /**
   * Remote port
   *
   * @var int
   */
  protected $port_ = '9090';
  protected $sock_type_;
  protected $config_ =array(
      'connect_timeout' => 8.0,
      'write_timeout'     => 6.0,
      'read_timeout'     => 6.0,
      'open_length_check'     => 1,
      'package_length_type'   => 'N',
      'package_length_offset' => 0,       //第N个字节是包长度的值
      'package_body_offset'   => 4,       //第几个字节开始计算长度
      'package_max_length'    => 8192000,  //协议最大长度
  );
  protected $buf="";
  protected $write=0;
  /**
   * Debugging on?
   *
   * @var bool
   */
  protected $debug_ = false;

  /**
   * Debug handler
   *
   * @var mixed
   */
  protected $debugHandler_ = null;
  

  /**
   * Socket constructor
   *
   * @param string $host         Remote hostname
   * @param int    $port         Remote port
   * @param bool   $persist      Whether to use a persistent socket
   * @param string $debugHandler Function to call for error logging
   */
  public function __construct($host='localhost',
                              $port=9090,
                              $config=array(),
                              $sock_type=SWOOLE_SOCK_TCP,
                              $debugHandler=null) {
    $this->host_ = $host;
    $this->port_ = $port;
    $this->sock_type_ = $sock_type;
    $this->config_=$config+$this->config_;
    $this->debugHandler_ = $debugHandler ? $debugHandler : 'error_log';
  }

  /**
   * @param resource $handle
   * @return void
   */
  public function setHandle($handle)
  {
    $this->handle_ = $handle;
  }
  /**
   * Sets debugging output on or off
   *
   * @param bool $debug
   */
  public function setDebug($debug)
  {
    $this->debug_ = $debug;
  }

  /**
   * Get the host that this socket is connected to
   *
   * @return string host
   */
  public function getHost()
  {
    return $this->host_;
  }

  /**
   * Get the remote port that this socket is connected to
   *
   * @return int port
   */
  public function getPort()
  {
    return $this->port_;
  }

  /**
   * Tests whether this is open
   *
   * @return bool true if the socket is open
   */
  public function isOpen()
  {
      return is_object($this->handle_);
  }

  /**
   * Connects the socket.
   */
  public function open()
  {
    if ($this->isOpen()) {
      throw new TTransportException('Socket already connected', TTransportException::ALREADY_OPEN);
    }

    if (empty($this->host_)) {
      throw new TTransportException('Cannot open null host', TTransportException::NOT_OPEN);
    }

    if ($this->port_ <= 0) {
      throw new TTransportException('Cannot open without port', TTransportException::NOT_OPEN);
    }
    
    $this->handle_ = new \Swoole\Coroutine\Client($this->sock_type_);
    $this->handle_->set($this->config_);
    if(!$this->handle_->connect($this->host_, $this->port_,$this->config_['connect_timeout'])){
        $errno=$this->handle_->errCode;
        $errstr=$this->handle_->errMsg;
        $error = 'TSocket: Could not connect to '.$this->host_.':'.$this->port_.' ('.$errstr.' ['.$errno.'])';
        if ($this->debug_) {
            call_user_func($this->debugHandler_, $error);
        }
        throw new TException($error);
    }
  }

  /**
   * Closes the socket.
   */
  public function close()
  {
    if(is_object($this->handle_))@$this->handle_->close();
    $this->handle_ = null;
  }
  /**
   * Read from the socket at most $len bytes.
   *
   * This method will not wait for all the requested data, it will return as
   * soon as any data is received.
   *
   * @param int $len Maximum number of bytes to read.
   * @return string Binary data
   */
  public function read($len)
  {
      if ($this->write>0) {
          $buf=$this->handle_->recv();
          if(!$buf){
              $msg=$this->handle_->errCode;
              throw new TTransportException('TSocket: write fail:'.$msg.
                  $this->host_.':'.$this->port_);
          }
          $this->write--;
          $this->buf.=$buf;
      }
      $slen=\Thrift\Factory\TStringFuncFactory::create()->strlen($this->buf);
      if ($slen<$len) {
          throw new TTransportException('TSocket['.$slen.'] read '.$len.' bytes failed.');
      }
      $data=\Thrift\Factory\TStringFuncFactory::create()->substr($this->buf, 0,$len);
      $this->buf=\Thrift\Factory\TStringFuncFactory::create()->substr($this->buf, $len);
      return $data;
  }

  /**
   * Write to the socket.
   *
   * @param string $buf The data to write
   */
  public function write($buf)
  {
      if(!$this->handle_->send($buf)){
          $msg=$this->handle_->errCode;
          throw new TTransportException('TSocket: write fail:'.$msg.
              $this->host_.':'.$this->port_);
      }
      $this->write++;
   }

  /**
   * Flush output to the socket.
   *
   * Since read(), readAll() and write() operate on the sockets directly,
   * this is a no-op
   *
   * If you wish to have flushable buffering behaviour, wrap this TSocket
   * in a TBufferedTransport.
   */
  public function flush()
  {
    // no-op
  }
}
