<?php
namespace Information;

/**
 * Autogenerated by Thrift Compiler (0.9.1)
 *
 * DO NOT EDIT UNLESS YOU ARE SURE THAT YOU KNOW WHAT YOU ARE DOING
 *  @generated
 */
use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Exception\TException;
use Thrift\Exception\TProtocolException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Exception\TApplicationException;


class AdParam {
  static $_TSPEC;

  public $token = null;
  public $page = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'token',
          'type' => TType::STRUCT,
          'class' => '\Shared\TokenParam',
          ),
        2 => array(
          'var' => 'page',
          'type' => TType::STRUCT,
          'class' => '\Shared\PageParam',
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['token'])) {
        $this->token = $vals['token'];
      }
      if (isset($vals['page'])) {
        $this->page = $vals['page'];
      }
    }
  }

  public function getName() {
    return 'AdParam';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::STRUCT) {
            $this->token = new \Shared\TokenParam();
            $xfer += $this->token->read($input);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::STRUCT) {
            $this->page = new \Shared\PageParam();
            $xfer += $this->page->read($input);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('AdParam');
    if ($this->token !== null) {
      if (!is_object($this->token)) {
        throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
      }
      $xfer += $output->writeFieldBegin('token', TType::STRUCT, 1);
      $xfer += $this->token->write($output);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->page !== null) {
      if (!is_object($this->page)) {
        throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
      }
      $xfer += $output->writeFieldBegin('page', TType::STRUCT, 2);
      $xfer += $this->page->write($output);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class AdItem {
  static $_TSPEC;

  public $title = null;
  public $link = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'title',
          'type' => TType::STRING,
          ),
        4 => array(
          'var' => 'link',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['title'])) {
        $this->title = $vals['title'];
      }
      if (isset($vals['link'])) {
        $this->link = $vals['link'];
      }
    }
  }

  public function getName() {
    return 'AdItem';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->title);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 4:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->link);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('AdItem');
    if ($this->title !== null) {
      $xfer += $output->writeFieldBegin('title', TType::STRING, 1);
      $xfer += $output->writeString($this->title);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->link !== null) {
      $xfer += $output->writeFieldBegin('link', TType::STRING, 4);
      $xfer += $output->writeString($this->link);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class ResultAd {
  static $_TSPEC;

  public $Status = null;
  public $Data = null;
  public $Message = null;
  public $Page = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'Status',
          'type' => TType::I16,
          ),
        2 => array(
          'var' => 'Data',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => '\Information\AdItem',
            ),
          ),
        3 => array(
          'var' => 'Message',
          'type' => TType::STRING,
          ),
        4 => array(
          'var' => 'Page',
          'type' => TType::STRUCT,
          'class' => '\Shared\ResultPage',
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['Status'])) {
        $this->Status = $vals['Status'];
      }
      if (isset($vals['Data'])) {
        $this->Data = $vals['Data'];
      }
      if (isset($vals['Message'])) {
        $this->Message = $vals['Message'];
      }
      if (isset($vals['Page'])) {
        $this->Page = $vals['Page'];
      }
    }
  }

  public function getName() {
    return 'ResultAd';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::I16) {
            $xfer += $input->readI16($this->Status);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::LST) {
            $this->Data = array();
            $_size0 = 0;
            $_etype3 = 0;
            $xfer += $input->readListBegin($_etype3, $_size0);
            for ($_i4 = 0; $_i4 < $_size0; ++$_i4)
            {
              $elem5 = null;
              $elem5 = new \Information\AdItem();
              $xfer += $elem5->read($input);
              $this->Data []= $elem5;
            }
            $xfer += $input->readListEnd();
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->Message);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 4:
          if ($ftype == TType::STRUCT) {
            $this->Page = new \Shared\ResultPage();
            $xfer += $this->Page->read($input);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('ResultAd');
    if ($this->Status !== null) {
      $xfer += $output->writeFieldBegin('Status', TType::I16, 1);
      $xfer += $output->writeI16($this->Status);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->Data !== null) {
      if (!is_array($this->Data)) {
        throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
      }
      $xfer += $output->writeFieldBegin('Data', TType::LST, 2);
      {
        $output->writeListBegin(TType::STRUCT, count($this->Data));
        {
          foreach ($this->Data as $iter6)
          {
            $xfer += $iter6->write($output);
          }
        }
        $output->writeListEnd();
      }
      $xfer += $output->writeFieldEnd();
    }
    if ($this->Message !== null) {
      $xfer += $output->writeFieldBegin('Message', TType::STRING, 3);
      $xfer += $output->writeString($this->Message);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->Page !== null) {
      if (!is_object($this->Page)) {
        throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
      }
      $xfer += $output->writeFieldBegin('Page', TType::STRUCT, 4);
      $xfer += $this->Page->write($output);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

