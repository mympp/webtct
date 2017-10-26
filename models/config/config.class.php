<?php
namespace models\config;

class Config
{
    private static $_params;

    private function __construct()
    {

    }

    private function getParams(){

        if(empty(self::$_params)){
            self::$_params = require __DIR__.'/config.php';
        }
        return self::$_params;
    }

    //获取基础参数,可接受不定参数
    public static function getConfig(){
        $args = func_get_args();
        if(empty($args)) return [];

        $params = self::getParams();
        foreach($args as $arg){
            if(!empty($params[$arg])){
                $params = $params[$arg];
            }else{
                $params = [];
                break;
            }
        }
        return $params;
    }

    //获取拓展配置项参数
    public static function getExtensionConfig($filename,$args = [])
    {
        $filePath = __DIR__.'/'.$filename.'.config.php';
        if(file_exists($filePath)){
            $params = require $filePath;
            foreach($args as $arg){
                if(!empty($params[$arg])){
                    $params = $params[$arg];
                }else{
                    $params = [];
                }
            }
            return $params;
        }else{
            return [];
        }
    }


}

?>