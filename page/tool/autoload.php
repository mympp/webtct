<?php
define('__DIR__',dirname(__FILE__));

spl_autoload_register(function($class_name){
    $class_name = str_replace('\\','/',$class_name);
	if(is_file(__DIR__.'/'.$class_name.'.class.php')){
		require_once __DIR__.'/'.$class_name.'.class.php';
	}
});  
?>