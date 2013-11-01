<?php
/**
 * 
 *海量云分词扩展类
 * @lanfengye <zibin_5257@163.com>
 */
class Hailiang{
    private $_secret;
	
	function __construct($secret)
	{
		$this->_secret = $secret;		
	}	
	
	public function execute($url, $params)
	{
		return $this->http_post_data($url, $this->create_post_data($params));
	}
        
        
        public function get_xml_data($contents){
            $textTpl = 
"<?xml version='1.0' encoding='UTF-8'?> 
<Root>
<Input>
<Property Name='Content'>%s</Property>
</Input>
<ProcessList Template=''>
<Resource ID='0' Adapter='DA_HLSegment' OutputXml='true' IgnoreFailed='true' >
<Param Name='Input' Value='Content' />
<Param Name='Output' Value='HLSegToken' />
<Param Name='CustomCalcSign' Value='POS_TAG' />
<Param Name='OutputFieldSign' Value='' />
</Resource>
<Resource ID='1000' Adapter='ClearSegmentProxy' OutputXml='false' IgnoreFailed='true' />
</ProcessList>
</Root>";
            $resultStr = sprintf($textTpl, $contents);
            return $resultStr;
    }
	
	private function http_post_data($url, $post_data)
	{
	   //  $url .= "?start_debug=1"; 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);		
		return curl_exec($ch);
	}
		
	private function create_post_data($params) 
	{   
		ksort($params); 
		
		$post_params = array();
		foreach ($params as $k => $v) 
		{
			
			$post_params[] = $k.'='.urlencode($v);
		}			
		$post_params[] = 'sig='.md5(implode("&", $post_params). $this->_secret);	
		return implode('&', $post_params);
	}
}

?>
