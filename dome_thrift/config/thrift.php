<?php
return array(
    "client_pool"=>array(
        "try"=>true,//发送错误重试次数,设置为TRUE为不限制
        "sleep"=>1,//断开连接重连暂停时间
        "app1_1"=>array(
            "size"=>1,//队列长度
			//设置下面两个会清理释放空闲链接
			//"keep_size"=>1,//空闲时保留链接数量
			//"keep_time"=>300,//空闲超过300关闭链接
            "weight"=>1,//权重
            "connection"=>array(
                'args'=>['127.0.0.1',8099]
            )
        ),
    ),
);
