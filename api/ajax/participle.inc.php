<?php
defined('IN_DESTOON') or exit('Access Denied');
$keyword = empty($_GET['keyword']) ? '' : $_GET['keyword'];
$keyword = empty($_POST['keyword']) ? $keyword : $_POST['keyword'];
if(empty($keyword))		exit('');

$seg_str = cutWord([$keyword]);

$seg_crf = exec("/usr/bin/python /usr/local/CRF/python/seg.py '$seg_str' 2>&1",$error,$status);

echo $seg_crf;

/* 将汉字词语拆分为单个字 
@word_arr  ，词语数组
return string
*/
function cutWord($word_arr){
        $word_str = '';
        foreach($word_arr as $v){
                if (preg_match("/[\x7f-\xff]/", $v)){
                        $strlen = mb_strlen($v);
                        $string = $v;
                        while($strlen){
                                $word_str .= mb_substr($string,0,1,"utf8").' ';
                                $string = mb_substr($string,1,$strlen,"utf8");
                                $strlen = mb_strlen($string);
                        }
                }else{
                        $word_str .= $v.' ';
                }
        }
        return substr($word_str,0,-1);
}
?>