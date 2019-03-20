<?php
namespace Services\Information;
use Information\AdParam;
use Information\NewsIf;
class NewsHandler implements NewsIf {
    /**
     * @param string $test
     * @return string
     */
    public function test($test){
        \co::sleep(1);
        return "return:".$test;
    }
    public function ad_lists(AdParam $param)
    {
        
    }
}