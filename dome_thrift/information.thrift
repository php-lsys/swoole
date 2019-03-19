namespace php Information

exception ResultException{
	1:required i16 Status
  	2:optional string Message
}

struct PageParam{
  1:optional i32 page=1
  2:optional i32 offset=0
  3:optional i32 show=0
}

struct AdParam{
  1:optional i16 terminal=0
  2:optional i16 position=0
  3:optional i16 type=0
  4:optional i16 platform=1
  5:optional PageParam page
}

struct ResultPage{
  1:optional i32 page=1
  2:optional i32 page_count=0
  3:optional i32 count=0
}

struct AdItem {
	1:required string title
	2:required string img
	3:required string imgformobiledevice
	4:required string link
}
struct ResultAd {
	1:required i16 Status
  	2:optional list<AdItem> Data
  	3:optional string Message
  	4:optional ResultPage Page
}

service News
{
	string test(1:string test);
    ResultAd ad_lists(1:AdParam param);
}