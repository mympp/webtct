<?php
isset($name) or exit('fail');
$session = new dsession();
set_cookie($name,null);
exit('1');
?>