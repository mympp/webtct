<?php
define('DT_REWRITE', true);
require 'config.inc.php';
require '../common.inc.php';
include "fileupload.class.php";
$up = new fileupload();
//设置属性（上传的位置、大小、类型、设置文件名是否要随机生成）
$up->set("path","./images/");
$up->set("maxsize",2000000); //kb
$up->set("allowtype",array("gif","png","jpg","jpeg"));//可以是"doc"、"docx"、"xls"、"xlsx"、"csv"和"txt"等文件，注意设置其文件大小
$up->set("israndname",true);//true:由系统命名；false：保留原文件名

//使用对象中的upload方法，上传文件，方法需要传一个上传表单的名字name：pic
//如果成功返回true，失败返回false

if($up->upload($_FILES)){
    //获取上传成功后文件名字
    var_dump($up->getFileName());

}else{
    //获取上传失败后的错误提示
    var_dump($up->getErrorMsg());
}
?>