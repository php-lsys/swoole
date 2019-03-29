# 公共接口定义
namespace php Shared

exception ResultException{
	1:required i16 status
  	2:optional string message
}

struct PageParam{
  1:optional i32 page=1
  2:optional i32 offset=0
  3:optional i32 show=0
}

struct TokenParam{
  1:required string token 
  2:required string time
  3:optional i16 type=0
  4:optional i16 platform=1
}

struct ResultPage{
  1:optional i32 page=1
  2:optional i32 pageCount=0
  3:optional i32 count=0
}
service ShareService 
{
	
}

