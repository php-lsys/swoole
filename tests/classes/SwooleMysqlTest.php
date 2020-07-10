<?php
namespace LSYS;
use PHPUnit\Framework\TestCase;
final class SwooleMysqlTest extends TestCase
{
    public function testPopPush()
    {
        go(function () {
            $mysql=\LSYS\Swoole\Coroutine\DI::get()->swoole_mysql_pool();
            $connection=$mysql->pop();
            
            $res=$connection->mysql()->query("select sleep(1) as sleepnum");
            
            $this->assertTrue($res[0]['sleepnum']=='0');
          
            $res=$mysql->query($connection, function()use($connection){
                return $connection->mysql()->query("select sleep(1) as sleepnum");
            });
            $this->assertTrue($res[0]['sleepnum']=='0');
            
            $stats=$mysql->stats();
            
            $this->assertTrue($stats['master']['queue_num']=='0');
            $this->assertTrue($stats['master']['current_num']=='1');
            
            $mysql->push($connection);
            
            $stats=$mysql->stats();
            $this->assertTrue($stats['master']['queue_num']=='1');
            $this->assertTrue($stats['master']['current_num']=='1');
            exit;
        });
    }
}