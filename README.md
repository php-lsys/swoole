swoole 简单封装
===

1. 封装线程池,参见示例

```
MSYQL: dome_pool/mysql_poll.php
REDIS: dome_pool/redis_poll.php
PGSQL: dome_pool/pgsql_poll.php
```

2. 基于swoole 的 thrift 封装

```
dome_thrift/src/Services/ 为具体服务实现
dome_thrift/dome_server.php 服务器端
dome_thrift/dome_client.php 客户端
dome_thrift/dome_client_go.php 协程连接池版客户端,建议使用此方式
```