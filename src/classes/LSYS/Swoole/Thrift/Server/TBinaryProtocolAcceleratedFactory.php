<?php
namespace LSYS\Swoole\Thrift\Server;
class TBinaryProtocolAcceleratedFactory extends \Thrift\Factory\TBinaryProtocolFactory
{
  public function getProtocol($trans)
  {
      return new \Thrift\Protocol\TBinaryProtocolAccelerated($trans, $this->strictRead_, $this->strictWrite_);
  }
}
