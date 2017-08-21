<?php
define('ModelsDir',__DIR__);

spl_autoload_register(function($class_name){
	$dirPath = str_replace('models','',ModelsDir);
	$file_name = $dirPath.$class_name.'.class.php';
	$file_name = str_replace('\\','/',$file_name);
	if(is_file($file_name)){
		require_once $file_name;;
	}else{
		throw new Exception("could not found $file_name");
	}
});

?>