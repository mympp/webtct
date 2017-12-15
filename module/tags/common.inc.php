<?php
use models\module\baseModule;

require_once DT_ROOT.'/models/autoload.php';

$tagsModule = baseModule::moduleInstance('tags');
$logo_title = $tagsModule->modulename;
$logo_url = DT_PATH;

?>