<?php 
namespace models\helpers\widget;

class curl{

	protected $header = [];
	protected $timeout = 30;
	protected $type = 'get';
	protected $errMsg = '';
	
	public function setHeader($header){
		$this->header = $header;
	}
	
	public function setTimeout($time){
		$this->timeout = $time;
	}
	
	public function setType($type){
		if($type == 'get'){
			$this->type = 'get';
		}else{
			$this->type = 'post';
		}
	}

/*
利用curl对https地址的接口发送请求，使用前确定环境已启动curl和openssl
@params : $url请求地址，$data需发送的数据参数，$header信息头，$timeout请求时间,$type发送类型post或get
@return : bool 或 string
*/
	public function curl_https($url, $data=array()){  
  
    $ch = curl_init();  
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查  
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);  // 从证书中检查SSL加密算法是否存在 
    $params = http_build_query($data);				//将数据数组拼接为地址参数格式，并进行urlencode转码
    
    if($this->type == 'get'){
		$url .= '?'.$params; 			//get的发送方式，将参数接到地址后
		curl_setopt($ch, CURLOPT_POST, false);  
	}else{
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);  //post发送方式，数据参数作为配置参数
		curl_setopt($ch, CURLOPT_POST, true);  
	}
     
    curl_setopt($ch, CURLOPT_URL, $url);  	//配置请求地址
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);  //配置信息头
    
    //curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   //如果成功只将结果返回，不自动输出任何内容
    curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);  //请求等待时间

    $response = curl_exec($ch);  
  
    if($error=curl_error($ch)){ 
   		$this->errMsg = $error; 
       	return false;
    }  
  
    curl_close($ch);  
  
    return $response;  
  
	}
	
	public function getErrMsg(){
		return $this->errMsg;
	}

}
?>