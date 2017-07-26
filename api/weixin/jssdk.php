<?php
/**
 * Created by PhpStorm.
 * User: wusiyuan
 * Date: 16/9/8
 * Time: 上午10:58
 */

require '../../common.inc.php';
require DT_ROOT.'/api/weixin/init.inc.php';

//重新取一次签名配置
$wxconfig = $wx->get_wxconfig($wx->ticket, $_REQUEST['url']);
echo $callback.'('.json_encode($wxconfig).')';
exit;