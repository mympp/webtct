<?php
use models\module\baseModule;

require_once DT_ROOT.'/models/autoload.php';


$newsModule = baseModule::moduleInstance('mallArticle');

$category = $newsModule->getCache('getMenu',[],3600);
$MENU = [];
foreach($category as $cate){
    $cate['linkurl'] = $newsModule->linkurl . $newsModule->searchRewrite(['catid' => $cate['catid']]);
    $MENU[] = $cate;
}

?>