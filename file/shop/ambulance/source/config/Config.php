<?php
namespace source\config;

class Config
{
    private static $_instance = null;
    private static $_params = [];
    private static $_paramsFile = '/params.php';

    private function __construct()
    {

    }

    static private function loadParams(){
        self::$_params = require_once(__DIR__.self::$_paramsFile);
    }

    static public function getInstance(){

        if(empty(self::$_instance)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getParams()
    {
        if(empty(self::$_params)){
            self::loadParams();
        }

        $args = func_get_args();
        $result = [];
        foreach($args as $arg){
            if(isset(self::$_params[$arg])){
                $result = self::$_params[$arg];
            }else{
                break;
            }
        }
        return $result;
    }
}

?>