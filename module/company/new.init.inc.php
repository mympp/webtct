<?php
use models\module\baseModule;
require_once DT_ROOT . '/models/autoload.php';

//新版头部内容
$homepageModule = baseModule::moduleInstance('homepage');
$homepageModule->setUser($userid,$username);
$companyInfo = $homepageModule->getCompanyInfo();
$companyBanner = $homepageModule->getBanner();
$companyLogo = $homepageModule->getLogo();
if(empty($companyLogo)){
    $companyLogo = $companyInfo['thumb'];
}
?>