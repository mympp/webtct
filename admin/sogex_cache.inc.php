<?php
defined('DT_ADMIN') or exit('Access Denied');
require 'sogex_common.inc.php';

if(set_cache('hot_news',$write)) dmsg('热门咨询缓存更新完成！');
if(set_cache('info_type',$write)) msg('信息类型缓存更新成功！','?file=sogex');
//var_dump(get_cache('info_type'));
?>
