<?php

namespace LSYS\Swoole\Thrift;
use Thrift\Transport\TFramedTransport;
use Thrift\Factory\TTransportFactory;
class FramedTransportFactory extends TTransportFactory{
  /**
   * @static
   * @param \Thrift\Transport\TTransport $transport
   * @return TFramedTransport
   */
  public static function getTransport(\Thrift\Transport\TTransport $transport) {
    return new TFramedTransport($transport);
  }
}
