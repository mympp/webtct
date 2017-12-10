<?php
namespace models\module;

use models\helpers\query\LinkQuery;

class baseModule implements moduleInterface{
		
	public $moduleid = 0;
	public $modulename = '';
	public $linkurl = '';
    public $title = '';
	
	public function searchRewrite($selector){}
	
	//创建子类对象
	final static public function moduleInstance($moduleName){
		$file_path = __DIR__.'/'.$moduleName.'Module.class.php';	//子类文件名
		if(is_file($file_path)){
			require_once $file_path;
			$object_name = 'models\module\\'.$moduleName.'Module';
			return new $object_name();	//动态创建对象
		}else{
			throw new Exception ('could not found object '.$moduleName.'Module');
			return null;
		}
	}

	//从缓存获取方法返回结果
	public function getCache($funcName,$params = [], $cacheTime = 3600){

		if(!method_exists($this,$funcName)){
			throw new Exception('could not found function '.$funcName);
			return null;
		}

        $buildCacheName = function($params , $funcName){
            $result = $this->modulename .'-'. $funcName ;
            foreach($params as  $key => $value){
                if(is_array($value) || is_object($value)){
                    return false;
                }elseif(is_bool($value)){
                    $v = $value === true ? '1' : '0';
                    $result .= '-'.$key .'_'.$v;
                }else{
                    $result .= '-'.$key .'_'.$value;
                }
            }
            return $result;
        };

        $cacheName = $buildCacheName($params, $funcName);
        if($cacheName !== false){
            global $dc;
            $data = $dc->get($cacheName);
            if(!$data){
                $data = call_user_func_array([$this,$funcName],$params);
                $dc->set($cacheName, $data, $cacheTime);
            }
            return $data;
        }else{
            //不能保证建造唯一键值的请求，不做缓存处理
            return call_user_func_array([$this,$funcName],$params);
        }
	}

    //获取友情链接
    public function getLinks($pagesize = 10 , $field = 'title,linkurl')
    {
        if(empty($this->moduleid)){
            return false;
        }else{
            return (new LinkQuery())->getLinks($this->moduleid,$pagesize,$field);
        }
    }
}

interface moduleInterface{
	public function searchRewrite($selector);	//地址重写接口
}
?>