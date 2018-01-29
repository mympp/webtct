<?php
use models\module\baseModule;
require_once DT_ROOT . '/models/autoload.php';

//新版头部内容
if(!isset($homepageModule)){
    $homepageModule = baseModule::moduleInstance('homepage');
}
$companyMallType = $homepageModule->getMallType();
$companyRecommend = $homepageModule->getRecommendCompany();

?>