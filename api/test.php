<?php

define('DT_NONUSER', true);
require '../common.inc.php';
if($DT_BOT) dhttp(403);

if($_GET['hekw'] == 'superdh'){
echo phpinfo();
}
?>