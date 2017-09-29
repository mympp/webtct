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


}

?>