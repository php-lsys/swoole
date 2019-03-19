<?php
/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements. See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership. The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied. See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package thrift.transport
 */

namespace LSYS\Swoole\Thrift;

use Thrift\Transport\TSocket;
use Thrift\Server\TServerTransport;

/**
 * Socket implementation of a server agent.
 *
 * @package thrift.transport
 */
class ServerTransport extends TServerTransport
{
  /**
   * Handle for the listener socket
   *
   * @var resource
   */
  protected $listener_;

  /**
   * Port for the listener to listen on
   *
   * @var int
   */
  protected $port_;

  /**
   * Host to listen on
   *
   * @var string
   */
  protected $host_;

  /**
   * ServerSocket constructor
   *
   * @param string $host        Host to listen on
   * @param int $port           Port to listen on
   * @return void
   */
  public function __construct($host = 'localhost', $port = 9090)
  {
    $this->host_ = $host;
    $this->port_ = $port;
  }
  
  protected $_swoole;
  public function create_swoole() {
      if($this->_swoole)return $this->_swoole;
      $swoole= new \swoole_server($this->host_, $this->port_);
      $this->_swoole=$swoole;
      return $swoole;
  }

  /**
   * Opens a new socket server handle
   *
   * @return void
   */
  public function listen()
  {
      if(!$this->_swoole)$this->create_swoole();
      $this->_swoole->start();
  }

  
  
  /**
   * Closes the socket server handle
   *
   * @return void
   */
  public function close()
  {
      if(!$this->_swoole)return;
      $this->_swoole->shutdown();
  }

  /**
   * Implementation of accept. If not client is accepted in the given time
   *
   * @return TSocket
   */
  protected function acceptImpl()
  {
 
  }
}
