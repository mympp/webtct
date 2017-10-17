<?php

use models\helpers\query\MallValidateQuery;

$mallValidte = new MallValidateQuery();
$lists = $mallValidte->getListByMall($mallid);

include tpl('validate','mall');

?>