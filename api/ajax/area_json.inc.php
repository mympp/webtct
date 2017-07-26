<?php
use models\helpers\data\area;

defined('IN_DESTOON') or exit('Access Denied');
require_once DT_ROOT.'/models/autoload.php';

$area = new area();
echo $area->getJsonArea();

?>