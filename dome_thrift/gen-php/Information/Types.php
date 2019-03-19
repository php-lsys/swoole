<?php
namespace Information;

/**
 * Autogenerated by Thrift Compiler (0.11.0)
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


class ResultException extends TException {
  static $isValidate = false;

  static $_TSPEC = array(
    1 => array(
      'var' => 'Status',
      'isRequired' => true,
      'type' => TType::I16,
      ),
    2 => array(
      'var' => 'Message',
      'isRequired' => false,
      'type' => TType::STRING,
      ),
    );

  /**
   * @var int
   */
  public $Status = null;
  /**
   * @var string
   */
  public $Message = null;

  public function __construct($vals=null) {
    if (is_array($vals)) {
      if (isset($vals['Status'])) {
        $this->Status = $vals['Status'];
      }
      if (isset($vals['Message'])) {
        $this->Message = $vals['Message'];
      }
    }
  }

  public function getName() {
    return 'ResultException';
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
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->Message);
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
    $xfer += $output->writeStructBegin('ResultException');
    if ($this->Status !== null) {
      $xfer += $output->writeFieldBegin('Status', TType::I16, 1);
      $xfer += $output->writeI16($this->Status);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->Message !== null) {
      $xfer += $output->writeFieldBegin('Message', TType::STRING, 2);
      $xfer += $output->writeString($this->Message);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class PageParam {
  static $isValidate = false;

  static $_TSPEC = array(
    1 => array(
      'var' => 'page',
      'isRequired' => false,
      'type' => TType::I32,
      ),
    2 => array(
      'var' => 'offset',
      'isRequired' => false,
      'type' => TType::I32,
      ),
    3 => array(
      'var' => 'show',
      'isRequired' => false,
      'type' => TType::I32,
      ),
    );

  /**
   * @var int
   */
  public $page = 1;
  /**
   * @var int
   */
  public $offset = 0;
  /**
   * @var int
   */
  public $show = 0;

  public function __construct($vals=null) {
    if (is_array($vals)) {
      if (isset($vals['page'])) {
        $this->page = $vals['page'];
      }
      if (isset($vals['offset'])) {
        $this->offset = $vals['offset'];
      }
      if (isset($vals['show'])) {
        $this->show = $vals['show'];
      }
    }
  }

  public function getName() {
    return 'PageParam';
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
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->page);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->offset);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->show);
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
    $xfer += $output->writeStructBegin('PageParam');
    if ($this->page !== null) {
      $xfer += $output->writeFieldBegin('page', TType::I32, 1);
      $xfer += $output->writeI32($this->page);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->offset !== null) {
      $xfer += $output->writeFieldBegin('offset', TType::I32, 2);
      $xfer += $output->writeI32($this->offset);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->show !== null) {
      $xfer += $output->writeFieldBegin('show', TType::I32, 3);
      $xfer += $output->writeI32($this->show);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class AdParam {
  static $isValidate = false;

  static $_TSPEC = array(
    1 => array(
      'var' => 'terminal',
      'isRequired' => false,
      'type' => TType::I16,
      ),
    2 => array(
      'var' => 'position',
      'isRequired' => false,
      'type' => TType::I16,
      ),
    3 => array(
      'var' => 'type',
      'isRequired' => false,
      'type' => TType::I16,
      ),
    4 => array(
      'var' => 'platform',
      'isRequired' => false,
      'type' => TType::I16,
      ),
    5 => array(
      'var' => 'page',
      'isRequired' => false,
      'type' => TType::STRUCT,
      'class' => '\Information\PageParam',
      ),
    );

  /**
   * @var int
   */
  public $terminal = 0;
  /**
   * @var int
   */
  public $position = 0;
  /**
   * @var int
   */
  public $type = 0;
  /**
   * @var int
   */
  public $platform = 1;
  /**
   * @var \Information\PageParam
   */
  public $page = null;

  public function __construct($vals=null) {
    if (is_array($vals)) {
      if (isset($vals['terminal'])) {
        $this->terminal = $vals['terminal'];
      }
      if (isset($vals['position'])) {
        $this->position = $vals['position'];
      }
      if (isset($vals['type'])) {
        $this->type = $vals['type'];
      }
      if (isset($vals['platform'])) {
        $this->platform = $vals['platform'];
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
          if ($ftype == TType::I16) {
            $xfer += $input->readI16($this->terminal);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::I16) {
            $xfer += $input->readI16($this->position);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::I16) {
            $xfer += $input->readI16($this->type);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 4:
          if ($ftype == TType::I16) {
            $xfer += $input->readI16($this->platform);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 5:
          if ($ftype == TType::STRUCT) {
            $this->page = new \Information\PageParam();
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
    if ($this->terminal !== null) {
      $xfer += $output->writeFieldBegin('terminal', TType::I16, 1);
      $xfer += $output->writeI16($this->terminal);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->position !== null) {
      $xfer += $output->writeFieldBegin('position', TType::I16, 2);
      $xfer += $output->writeI16($this->position);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->type !== null) {
      $xfer += $output->writeFieldBegin('type', TType::I16, 3);
      $xfer += $output->writeI16($this->type);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->platform !== null) {
      $xfer += $output->writeFieldBegin('platform', TType::I16, 4);
      $xfer += $output->writeI16($this->platform);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->page !== null) {
      if (!is_object($this->page)) {
        throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
      }
      $xfer += $output->writeFieldBegin('page', TType::STRUCT, 5);
      $xfer += $this->page->write($output);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class ResultPage {
  static $isValidate = false;

  static $_TSPEC = array(
    1 => array(
      'var' => 'page',
      'isRequired' => false,
      'type' => TType::I32,
      ),
    2 => array(
      'var' => 'page_count',
      'isRequired' => false,
      'type' => TType::I32,
      ),
    3 => array(
      'var' => 'count',
      'isRequired' => false,
      'type' => TType::I32,
      ),
    );

  /**
   * @var int
   */
  public $page = 1;
  /**
   * @var int
   */
  public $page_count = 0;
  /**
   * @var int
   */
  public $count = 0;

  public function __construct($vals=null) {
    if (is_array($vals)) {
      if (isset($vals['page'])) {
        $this->page = $vals['page'];
      }
      if (isset($vals['page_count'])) {
        $this->page_count = $vals['page_count'];
      }
      if (isset($vals['count'])) {
        $this->count = $vals['count'];
      }
    }
  }

  public function getName() {
    return 'ResultPage';
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
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->page);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->page_count);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->count);
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
    $xfer += $output->writeStructBegin('ResultPage');
    if ($this->page !== null) {
      $xfer += $output->writeFieldBegin('page', TType::I32, 1);
      $xfer += $output->writeI32($this->page);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->page_count !== null) {
      $xfer += $output->writeFieldBegin('page_count', TType::I32, 2);
      $xfer += $output->writeI32($this->page_count);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->count !== null) {
      $xfer += $output->writeFieldBegin('count', TType::I32, 3);
      $xfer += $output->writeI32($this->count);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class AdItem {
  static $isValidate = false;

  static $_TSPEC = array(
    1 => array(
      'var' => 'title',
      'isRequired' => true,
      'type' => TType::STRING,
      ),
    2 => array(
      'var' => 'img',
      'isRequired' => true,
      'type' => TType::STRING,
      ),
    3 => array(
      'var' => 'imgformobiledevice',
      'isRequired' => true,
      'type' => TType::STRING,
      ),
    4 => array(
      'var' => 'link',
      'isRequired' => true,
      'type' => TType::STRING,
      ),
    );

  /**
   * @var string
   */
  public $title = null;
  /**
   * @var string
   */
  public $img = null;
  /**
   * @var string
   */
  public $imgformobiledevice = null;
  /**
   * @var string
   */
  public $link = null;

  public function __construct($vals=null) {
    if (is_array($vals)) {
      if (isset($vals['title'])) {
        $this->title = $vals['title'];
      }
      if (isset($vals['img'])) {
        $this->img = $vals['img'];
      }
      if (isset($vals['imgformobiledevice'])) {
        $this->imgformobiledevice = $vals['imgformobiledevice'];
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
        case 2:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->img);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->imgformobiledevice);
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
    if ($this->img !== null) {
      $xfer += $output->writeFieldBegin('img', TType::STRING, 2);
      $xfer += $output->writeString($this->img);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->imgformobiledevice !== null) {
      $xfer += $output->writeFieldBegin('imgformobiledevice', TType::STRING, 3);
      $xfer += $output->writeString($this->imgformobiledevice);
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
  static $isValidate = false;

  static $_TSPEC = array(
    1 => array(
      'var' => 'Status',
      'isRequired' => true,
      'type' => TType::I16,
      ),
    2 => array(
      'var' => 'Data',
      'isRequired' => false,
      'type' => TType::LST,
      'etype' => TType::STRUCT,
      'elem' => array(
        'type' => TType::STRUCT,
        'class' => '\Information\AdItem',
        ),
      ),
    3 => array(
      'var' => 'Message',
      'isRequired' => false,
      'type' => TType::STRING,
      ),
    4 => array(
      'var' => 'Page',
      'isRequired' => false,
      'type' => TType::STRUCT,
      'class' => '\Information\ResultPage',
      ),
    );

  /**
   * @var int
   */
  public $Status = null;
  /**
   * @var \Information\AdItem[]
   */
  public $Data = null;
  /**
   * @var string
   */
  public $Message = null;
  /**
   * @var \Information\ResultPage
   */
  public $Page = null;

  public function __construct($vals=null) {
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
            $this->Page = new \Information\ResultPage();
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

